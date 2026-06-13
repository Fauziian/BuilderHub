<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Project;
use App\Models\User;
use App\Models\Portfolio;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private function checkAccess(): void
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Admin.');
        }
    }

    public function dashboard()
    {
        $this->checkAccess();
        $stats = [
            'total_users' => User::count(),
            'total_projects' => Project::count(),
            'total_courses' => Course::count(),
            'total_revenue' => Project::where('status', 'completed')->sum('budget') * 0.80,
            'programmers' => User::where('role', 'programmer')->count(),
            'umkms' => User::where('role', 'umkm')->count(),
            'open_projects' => Project::where('status', 'open')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'pending_verifications' => User::where('role', 'programmer')->where('is_verified', false)->count(),
            'umkm_pending' => User::where('role', 'umkm')->where('umkm_verified', false)->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentProjects = Project::with('umkm')->latest()->take(5)->get();
        $pendingProgrammers = User::where('role', 'programmer')->where('is_verified', false)->with(['portfolios', 'certificates'])->take(5)->get();
        $pendingUmkms = User::where('role', 'umkm')->where('umkm_verified', false)->take(5)->get();
        $pendingProjects = Project::where('status', 'pending')->with('umkm')->latest()->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentProjects', 'pendingProgrammers', 'pendingUmkms', 'pendingProjects'));
    }

    public function users(Request $request)
    {
        $this->checkAccess();
        $query = User::query();
        if ($request->role) $query->where('role', $request->role);
        if ($request->search) $query->where('name', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%');
        $users = $query->with(['portfolios', 'certificates'])->latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function verifyProgrammer(User $user)
    {
        $this->checkAccess();
        $user->update(['is_verified' => true]);
        return back()->with('success', "Programmer {$user->name} berhasil diverifikasi.");
    }

    public function verifyUmkm(User $user)
    {
        $this->checkAccess();
        $user->update(['umkm_verified' => true]);
        return back()->with('success', "UMKM {$user->name} berhasil diverifikasi.");
    }

    public function deleteUser(User $user)
    {
        $this->checkAccess();
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return back()->with('success', "User {$user->name} berhasil dihapus.");
    }

    public function projects()
    {
        $this->checkAccess();
        $projects = Project::with(['umkm', 'programmer', 'bids'])->latest()->paginate(15);
        return view('admin.projects', compact('projects'));
    }

    public function courses()
    {
        $this->checkAccess();
        $courses = Course::with(['instructor', 'enrollments'])->latest()->paginate(15);
        return view('admin.courses', compact('courses'));
    }

    public function publishCourse(Course $course)
    {
        $this->checkAccess();
        $course->update(['is_published' => !$course->is_published]);
        $status = $course->is_published ? 'dipublikasikan' : 'disembunyikan';
        return back()->with('success', "Course berhasil $status.");
    }

    public function approveProject(Project $project)
    {
        $this->checkAccess();
        $project->update(['status' => 'open']);
        return back()->with('success', "Project \"{$project->title}\" berhasil di-ACC (disetujui) dan dipublikasikan.");
    }

    public function deleteProject(Project $project)
    {
        $this->checkAccess();
        $project->delete();
        return back()->with('success', "Project \"{$project->title}\" berhasil dihapus.");
    }



    public function deleteCourse(Course $course)
    {
        $this->checkAccess();
        $course->delete();
        return back()->with('success', "Course \"{$course->title}\" berhasil dihapus.");
    }

    private function recalculateBadges(User $user)
    {
        $approvedCertCount = $user->certificates()->where('status', 'approved')->count();
        $approvedPortCount = $user->portfolios()->where('status', 'approved')->count();
        $user->update([
            'is_verified'      => $user->is_verified ? true : ($approvedCertCount >= 2 && $approvedPortCount >= 1),
            'is_top_programmer' => $user->is_top_programmer ? true : ($approvedCertCount >= 3 && $approvedPortCount >= 3),
        ]);
    }

    public function approvePortfolio(Portfolio $portfolio)
    {
        $this->checkAccess();
        $portfolio->status = 'approved';
        $portfolio->save();
        $this->recalculateBadges($portfolio->programmer);
        return back()->with('success', '✅ Portofolio berhasil disetujui!');
    }

    public function rejectPortfolio(Portfolio $portfolio)
    {
        $this->checkAccess();
        $portfolio->status = 'rejected';
        $portfolio->save();
        $this->recalculateBadges($portfolio->programmer);
        return back()->with('success', '❌ Portofolio telah ditolak.');
    }

    public function approveCertificate(Certificate $certificate)
    {
        $this->checkAccess();
        $certificate->status = 'approved';
        $certificate->save();
        $this->recalculateBadges($certificate->programmer);
        return back()->with('success', '✅ Sertifikat berhasil disetujui!');
    }

    public function rejectCertificate(Certificate $certificate)
    {
        $this->checkAccess();
        $certificate->status = 'rejected';
        $certificate->save();
        $this->recalculateBadges($certificate->programmer);
        return back()->with('success', '❌ Sertifikat telah ditolak.');
    }
}
