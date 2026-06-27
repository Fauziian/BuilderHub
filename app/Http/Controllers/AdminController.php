<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Project;
use App\Models\User;
use App\Models\Portfolio;
use App\Models\Certificate;
use App\Services\NotificationService;
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
            'total_revenue' => (Project::where('status', 'completed')->sum('budget') * 0.80) + Project::where('status', 'in_progress')->sum('budget') + (CourseEnrollment::sum('amount_paid') * 0.20),
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
        if ($request->role) {
            $query->where('role', $request->role);
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }
        $users = $query->with(['portfolios', 'certificates'])->latest()->paginate(8)->withQueryString();
        return view('admin.users', compact('users'));
    }

    public function verifyProgrammer(User $user)
    {
        $this->checkAccess();
        $user->update(['is_verified' => true]);
        
        // Auto-approve their pending certificates and portfolios
        $user->certificates()->where('status', 'pending')->update(['status' => 'approved']);
        $user->portfolios()->where('status', 'pending')->update(['status' => 'approved']);
        
        // Recalculate badge status
        $this->recalculateBadges($user);
        
        NotificationService::programmerVerified($user->id, $user->name);
        return back()->with('success', "Programmer {$user->name} berhasil diverifikasi.");
    }

    public function verifyUmkm(User $user)
    {
        $this->checkAccess();
        $user->update(['umkm_verified' => true]);
        NotificationService::umkmVerified($user->id, $user->name);
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

    public function projects(Request $request)
    {
        $this->checkAccess();
        $query = Project::query();
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('umkm', function($uq) use ($request) {
                      $uq->where('name', 'like', '%' . $request->search . '%')
                         ->orWhere('business_name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $projects = $query->with(['umkm', 'programmer', 'bids'])->latest()->paginate(8)->withQueryString();
        return view('admin.projects', compact('projects'));
    }

    public function courses(Request $request)
    {
        $this->checkAccess();
        $query = Course::query();
        
        if ($request->level) {
            $query->where('level', $request->level);
        }
        if ($request->status) {
            $query->where('is_published', $request->status === 'public');
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%')
                  ->orWhereHas('instructor', function($iq) use ($request) {
                      $iq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $courses = $query->with(['instructor', 'enrollments'])->latest()->paginate(8)->withQueryString();
        return view('admin.courses', compact('courses'));
    }

    public function publishCourse(Course $course)
    {
        $this->checkAccess();
        $course->update(['is_published' => !$course->is_published]);
        $status = $course->is_published ? 'dipublikasikan' : 'disembunyikan';

        if ($course->is_published) {
            // Course baru dipublikasikan → notifikasi ke instructor + semua pelajar
            NotificationService::coursePublished(
                $course->instructor_id,
                $course->instructor->name,
                $course->title,
                $course->id
            );
        } else {
            // Course disembunyikan → notifikasi ke instructor
            NotificationService::courseUnpublished($course->instructor_id, $course->title);
        }

        return back()->with('success', "Course berhasil $status.");
    }

    public function approveProject(Project $project)
    {
        $this->checkAccess();
        $project->update(['status' => 'open']);

        // Kirim notifikasi ke UMKM pemilik + semua programmer terverifikasi
        NotificationService::projectApproved($project->umkm_id, $project->title, $project->id);

        return back()->with('success', "Project \"{$project->title}\" berhasil di-ACC (disetujui) dan dipublikasikan.");
    }

    public function deleteProject(Project $project)
    {
        $this->checkAccess();
        $umkmId = $project->umkm_id;
        $title  = $project->title;
        $wasPending = $project->status === 'pending';
        $programmerId = $project->assigned_programmer_id;
        $project->delete();
        if ($programmerId) {
            User::recalcRatings($programmerId);
        }
        // Jika project masih pending (belum pernah di-acc), beri tahu UMKM bahwa ditolak
        if ($wasPending) {
            NotificationService::projectRejected($umkmId, $title);
        }
        return back()->with('success', "Project \"{$title}\" berhasil dihapus.");
    }

    public function deleteCourse(Course $course)
    {
        $this->checkAccess();
        $instructorId = $course->instructor_id;
        $course->delete();
        if ($instructorId) {
            User::recalcRatings($instructorId);
        }
        return back()->with('success', "Course \"{$course->title}\" berhasil dihapus.");
    }

    private function recalculateBadges(User $user)
    {
        $approvedCertCount = $user->certificates()->where('status', 'approved')->count();
        $approvedPortCount = $user->portfolios()->where('status', 'approved')->count();
        $user->update([
            'is_verified'      => $user->is_verified,
            'is_top_programmer' => $user->is_top_programmer ? true : ($approvedCertCount >= 3 && $approvedPortCount >= 3),
        ]);
    }

    public function approvePortfolio(Portfolio $portfolio)
    {
        $this->checkAccess();
        $portfolio->status = 'approved';
        $portfolio->save();
        $this->recalculateBadges($portfolio->programmer);
        NotificationService::portfolioApproved($portfolio->programmer_id, $portfolio->title);
        return back()->with('success', '✅ Portofolio berhasil disetujui!');
    }

    public function rejectPortfolio(Portfolio $portfolio)
    {
        $this->checkAccess();
        $portfolio->status = 'rejected';
        $portfolio->save();
        $this->recalculateBadges($portfolio->programmer);
        NotificationService::portfolioRejected($portfolio->programmer_id, $portfolio->title);
        return back()->with('success', '❌ Portofolio telah ditolak.');
    }

    public function approveCertificate(Certificate $certificate)
    {
        $this->checkAccess();
        $certificate->status = 'approved';
        $certificate->save();
        $this->recalculateBadges($certificate->programmer);
        NotificationService::certificateApproved($certificate->programmer_id, $certificate->name);
        return back()->with('success', '✅ Sertifikat berhasil disetujui!');
    }

    public function rejectCertificate(Certificate $certificate)
    {
        $this->checkAccess();
        $certificate->status = 'rejected';
        $certificate->save();
        $this->recalculateBadges($certificate->programmer);
        NotificationService::certificateRejected($certificate->programmer_id, $certificate->name);
        return back()->with('success', '❌ Sertifikat telah ditolak.');
    }
}
