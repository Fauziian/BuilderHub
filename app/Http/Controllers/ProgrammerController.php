<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Portfolio;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgrammerController extends Controller
{
    private function checkAccess(): void
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['programmer', 'admin'])) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Programmer.');
        }
    }

    public function dashboard()
    {
        $this->checkAccess();
        $user = Auth::user();
        $myBids = Bid::with(['project', 'project.umkm'])->where('programmer_id', $user->id)->where('status', 'pending')->get();
        $activeBids = $myBids->count();
        $activeProjects = Project::where('assigned_programmer_id', $user->id)->where('status', 'in_progress')->get();
        $completedProjects = Project::where('assigned_programmer_id', $user->id)->where('status', 'completed')->count();
        $availableProjects = Project::with('bids')->where('status', 'open')->latest()->take(5)->get();
        $myCourses = Course::where('instructor_id', $user->id)->get();
        $portfolios = $user->portfolios;
        $certificates = $user->certificates;

        return view('programmer.dashboard', compact(
            'user', 'myBids', 'activeBids', 'activeProjects', 'completedProjects',
            'availableProjects', 'myCourses', 'portfolios', 'certificates'
        ));
    }

    public function projects(Request $request)
    {
        return redirect()->route('projects');
    }

    public function submitBid(Request $request, Project $project)
    {
        $this->checkAccess();
        
        $daysRemaining = max(1, (int)now()->startOfDay()->diffInDays($project->deadline->startOfDay()));

        $request->validate([
            'amount' => 'required|numeric|min:100000',
            'message' => 'required|string|min:20',
            'timeline_days' => "required|integer|min:1|max:{$daysRemaining}",
        ], [
            'amount.required' => 'Jumlah penawaran wajib diisi',
            'amount.min' => 'Penawaran minimal Rp 100.000',
            'message.required' => 'Pesan penawaran wajib diisi',
            'message.min' => 'Pesan minimal 20 karakter',
            'timeline_days.required' => 'Estimasi waktu wajib diisi',
            'timeline_days.max' => "Estimasi waktu tidak boleh melebihi sisa waktu deadline project ({$daysRemaining} hari)",
        ]);

        $existingBid = Bid::where('project_id', $project->id)->where('programmer_id', Auth::id())->first();
        if ($existingBid) {
            return back()->with('error', 'Anda sudah mengajukan penawaran untuk project ini.');
        }

        Bid::create([
            'project_id' => $project->id,
            'programmer_id' => Auth::id(),
            'amount' => $request->amount,
            'message' => $request->message,
            'timeline_days' => $request->timeline_days,
            'status' => 'pending',
        ]);

        return back()->with('success', '✅ Penawaran berhasil dikirim! UMKM akan menghubungi Anda jika tertarik.');
    }

    public function updateBid(Request $request, Bid $bid)
    {
        $this->checkAccess();
        if ($bid->programmer_id !== Auth::id()) {
            abort(403);
        }
        if ($bid->status !== 'pending') {
            return back()->with('error', 'Penawaran ini sudah diproses dan tidak dapat diubah.');
        }

        $project = $bid->project;
        $daysRemaining = max(1, (int)now()->startOfDay()->diffInDays($project->deadline->startOfDay()));

        $request->validate([
            'amount' => 'required|numeric|min:100000',
            'message' => 'required|string|min:20',
            'timeline_days' => "required|integer|min:1|max:{$daysRemaining}",
        ], [
            'amount.required' => 'Jumlah penawaran wajib diisi',
            'amount.min' => 'Penawaran minimal Rp 100.000',
            'message.required' => 'Pesan penawaran wajib diisi',
            'message.min' => 'Pesan minimal 20 karakter',
            'timeline_days.required' => 'Estimasi waktu wajib diisi',
            'timeline_days.max' => "Estimasi waktu tidak boleh melebihi sisa waktu deadline project ({$daysRemaining} hari)",
        ]);

        $bid->update([
            'amount' => $request->amount,
            'message' => $request->message,
            'timeline_days' => $request->timeline_days,
        ]);

        return back()->with('success', '✅ Penawaran berhasil diperbarui! Perubahan harga dan estimasi telah disimpan.');
    }

    public function addPortfolio(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'project_url' => 'nullable|url',
        ]);

        $tags = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];

        Portfolio::create([
            'programmer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'tags' => $tags,
            'project_url' => $request->project_url,
        ]);

        $this->checkBadges();
        return back()->with('success', '✅ Portofolio berhasil ditambahkan!');
    }

    public function editPortfolio(Portfolio $portfolio)
    {
        $this->checkAccess();
        if ($portfolio->programmer_id !== Auth::id()) abort(403);
        return response()->json($portfolio);
    }

    public function updatePortfolio(Request $request, Portfolio $portfolio)
    {
        $this->checkAccess();
        if ($portfolio->programmer_id !== Auth::id()) abort(403);
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'tags'        => 'nullable|string',
            'project_url' => 'nullable|url',
        ]);
        $tags = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];
        $portfolio->update([
            'title'       => $request->title,
            'description' => $request->description,
            'tags'        => $tags,
            'project_url' => $request->project_url,
        ]);
        return back()->with('success', '✅ Portofolio berhasil diperbarui!');
    }

    public function deletePortfolio(Portfolio $portfolio)
    {
        $this->checkAccess();
        if ($portfolio->programmer_id !== Auth::id()) abort(403);
        $portfolio->delete();
        $this->checkBadges();
        return back()->with('success', 'Portofolio dihapus.');
    }

    public function addCertificate(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'name'       => 'required|string|max:255',
            'issuer'     => 'required|string|max:255',
            'issue_date' => 'nullable|date',
        ]);

        Certificate::create([
            'programmer_id'  => Auth::id(),
            'name'           => $request->name,
            'issuer'         => $request->issuer,
            'issue_date'     => $request->issue_date,
            'credential_url' => $request->credential_url,
        ]);

        $this->checkBadges();
        return back()->with('success', '✅ Sertifikat berhasil ditambahkan!');
    }

    public function deleteCertificate(Certificate $certificate)
    {
        $this->checkAccess();
        if ($certificate->programmer_id !== Auth::id()) abort(403);
        $certificate->delete();
        $this->checkBadges();
        return back()->with('success', 'Sertifikat dihapus.');
    }

    private function checkBadges()
    {
        $user = Auth::user();
        $certCount = $user->certificates()->count();
        $portCount = $user->portfolios()->count();
        $user->update([
            'is_verified'      => $certCount >= 2 && $portCount >= 1,
            'is_top_programmer' => $certCount >= 3 && $portCount >= 3,
        ]);
    }

    public function createCourse()
    {
        $this->checkAccess();
        $user = Auth::user();
        if (!$user->is_top_programmer && $user->role !== 'admin') {
            return back()->with('error', 'Anda harus menjadi Top Programmer untuk membuat course.');
        }
        return view('programmer.create-course');
    }

    public function storeCourse(Request $request)
    {
        $this->checkAccess();
        $user = Auth::user();
        if (!$user->is_top_programmer && $user->role !== 'admin') {
            return back()->with('error', 'Akses ditolak.');
        }
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'price'       => 'required|numeric|min:0',
            'level'       => 'required|in:pemula,menengah,mahir',
            'category'    => 'required|string|max:100',
            'video_url'   => 'required|url',
        ], [
            'video_url.required' => 'Link YouTube wajib disertakan agar pelajar dapat menonton materi.',
            'video_url.url'      => 'Format link YouTube tidak valid.',
        ]);
        $course = Course::create([
            'instructor_id' => $user->id,
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->has('is_free') ? 0 : $request->price,
            'level'         => $request->level,
            'category'      => $request->category,
            'is_free'       => $request->has('is_free'),
            'is_published'  => false,
            'duration'      => $request->duration,
            'total_videos'  => 1,
        ]);

        // Auto-create video dari YouTube link yang diberikan programmer
        \App\Models\CourseVideo::create([
            'course_id' => $course->id,
            'title'     => 'Materi Utama: ' . $request->title,
            'video_url' => $request->video_url,
            'duration'  => $request->duration ?? '15 menit',
            'order'     => 1,
        ]);

        return redirect()->route('programmer.dashboard')->with('success', '✅ Course berhasil dibuat! Video materi sudah tersedia. Admin akan meninjaunya.');
    }

    public function editCourse(Course $course)
    {
        $this->checkAccess();
        if ($course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') abort(403);
        return view('programmer.edit-course', compact('course'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $this->checkAccess();
        if ($course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') abort(403);
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'price'       => 'required|numeric|min:0',
            'level'       => 'required|in:pemula,menengah,mahir',
            'category'    => 'required|string|max:100',
        ]);
        $course->update([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->has('is_free') ? 0 : $request->price,
            'level'       => $request->level,
            'category'    => $request->category,
            'is_free'     => $request->has('is_free'),
            'duration'    => $request->duration,
        ]);
        return redirect()->route('programmer.dashboard')->with('success', '✅ Course berhasil diperbarui!');
    }

    public function deleteCourse(Course $course)
    {
        $this->checkAccess();
        if ($course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') abort(403);
        $course->delete();
        return back()->with('success', 'Course berhasil dihapus.');
    }
}

