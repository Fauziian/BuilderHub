<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Notification;
use App\Models\Portfolio;
use App\Models\Project;
use App\Services\NotificationService;
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
        $receivedReviews = \App\Models\Review::where('reviewed_id', $user->id)
            ->with(['reviewer', 'project', 'course'])
            ->latest()
            ->get();

        return view('programmer.dashboard', compact(
            'user', 'myBids', 'activeBids', 'activeProjects', 'completedProjects',
            'availableProjects', 'myCourses', 'portfolios', 'certificates', 'receivedReviews'
        ));
    }

    public function projects(Request $request)
    {
        return redirect()->route('projects');
    }

    public function submitBid(Request $request, Project $project)
    {
        $this->checkAccess();
        
        $user = Auth::user();
        if ($user->portfolios()->where('status', 'approved')->count() === 0 && $user->certificates()->where('status', 'approved')->count() === 0) {
            return back()->with('error', 'Anda harus memiliki minimal 1 Portofolio atau 1 Sertifikat yang telah disetujui/diverifikasi oleh admin terlebih dahulu untuk mengajukan penawaran.');
        }

        // Blokir penawaran jika deadline project sudah terlampaui
        if ($project->deadline && now()->startOfDay()->gt($project->deadline->startOfDay())) {
            return back()->with('error', '⛔ Deadline project ini sudah terlampaui (' . $project->deadline->format('d M Y') . '). Penawaran tidak dapat dikirim.');
        }

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
            'project_id'      => $project->id,
            'programmer_id'   => Auth::id(),
            'amount'          => $request->amount,
            'message'         => $request->message,
            'timeline_days'   => $request->timeline_days,
            'status'          => 'pending',
            'is_seen_by_umkm' => false,
        ]);

        // Kirim notifikasi ke pemilik project (UMKM)
        Notification::create([
            'user_id' => $project->umkm_id,
            'title'   => 'Penawaran Baru Masuk! 💰',
            'message' => $user->name . ' mengajukan penawaran untuk project "' . $project->title . '" sebesar Rp ' . number_format($request->amount, 0, ',', '.'),
            'type'    => 'bid',
            'link'    => '/umkm/dashboard#projects',
            'is_read' => false,
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
            'is_revised' => true,
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
            'status'      => 'pending',
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

    public function updateProfile(Request $request)
    {
        $this->checkAccess();
        $user = Auth::user();

        $request->validate([
            'bio' => 'required|string|min:10',
            'expertise' => 'nullable|string|max:255',
        ], [
            'bio.required' => 'Bio wajib diisi',
            'bio.min' => 'Bio minimal 10 karakter',
        ]);

        $user->update([
            'bio' => $request->bio,
            'expertise' => $request->expertise,
        ]);

        return back()->with('success', '✅ Profil (Bio & Keahlian) berhasil diperbarui!');
    }

    private function checkBadges()
    {
        $user = Auth::user();
        $approvedCertCount = $user->certificates()->where('status', 'approved')->count();
        $approvedPortCount = $user->portfolios()->where('status', 'approved')->count();
        $user->update([
            'is_verified'      => $user->is_verified ? true : ($approvedCertCount >= 2 && $approvedPortCount >= 1),
            'is_top_programmer' => $user->is_top_programmer ? true : ($approvedCertCount >= 3 && $approvedPortCount >= 3),
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
            'description' => 'required|string|min:20',
            'price'       => 'required|numeric|min:0',
            'level'       => 'required|in:pemula,menengah,mahir',
            'category'    => 'required|string|max:100',
            'videos'      => 'required|array|min:1',
            'videos.*.title' => 'required|string|max:255',
            'videos.*.video_url' => 'required|url',
            'videos.*.duration'  => 'nullable|string',
        ], [
            'title.required' => 'Judul course wajib diisi.',
            'title.max' => 'Judul course tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi course wajib diisi.',
            'description.min' => 'Deskripsi course minimal berisi :min karakter.',
            'price.required' => 'Harga wajib diisi (isi 0 jika gratis).',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'level.required' => 'Level course wajib dipilih.',
            'level.in' => 'Level course tidak valid.',
            'category.required' => 'Kategori wajib diisi.',
            'category.max' => 'Kategori tidak boleh lebih dari 100 karakter.',
            'videos.required' => 'Minimal 1 video pembelajaran wajib disertakan.',
            'videos.min' => 'Minimal 1 video pembelajaran wajib disertakan.',
            'videos.*.title.required' => 'Judul video wajib diisi.',
            'videos.*.video_url.required' => 'Link YouTube wajib diisi.',
            'videos.*.video_url.url' => 'Format link YouTube video tidak valid.',
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
            'total_videos'  => count($request->videos),
        ]);

        foreach ($request->videos as $index => $vid) {
            \App\Models\CourseVideo::create([
                'course_id' => $course->id,
                'title'     => $vid['title'],
                'video_url' => $vid['video_url'],
                'duration'  => $vid['duration'] ?? '15 menit',
                'order'     => $index + 1,
            ]);
        }

        // Notifikasi ke admin bahwa ada course baru yang perlu ditinjau
        NotificationService::courseSubmitted($user->id, $user->name, $request->title);

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
            'videos'      => 'required|array|min:1',
            'videos.*.title' => 'required|string|max:255',
            'videos.*.video_url' => 'required|url',
            'videos.*.duration'  => 'nullable|string',
        ], [
            'title.required' => 'Judul course wajib diisi.',
            'title.max' => 'Judul course tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi course wajib diisi.',
            'description.min' => 'Deskripsi course minimal berisi :min karakter.',
            'price.required' => 'Harga wajib diisi (isi 0 jika gratis).',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'level.required' => 'Level course wajib dipilih.',
            'level.in' => 'Level course tidak valid.',
            'category.required' => 'Kategori wajib diisi.',
            'category.max' => 'Kategori tidak boleh lebih dari 100 karakter.',
            'videos.required' => 'Minimal 1 video pembelajaran wajib disertakan.',
            'videos.min' => 'Minimal 1 video pembelajaran wajib disertakan.',
            'videos.*.title.required' => 'Judul video wajib diisi.',
            'videos.*.video_url.required' => 'Link YouTube wajib diisi.',
            'videos.*.video_url.url' => 'Format link YouTube video tidak valid.',
        ]);
        $course->update([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->has('is_free') ? 0 : $request->price,
            'level'       => $request->level,
            'category'    => $request->category,
            'is_free'     => $request->has('is_free'),
            'duration'    => $request->duration,
            'total_videos' => count($request->videos),
        ]);

        $course->videos()->delete();

        foreach ($request->videos as $index => $vid) {
            \App\Models\CourseVideo::create([
                'course_id' => $course->id,
                'title'     => $vid['title'],
                'video_url' => $vid['video_url'],
                'duration'  => $vid['duration'] ?? '15 menit',
                'order'     => $index + 1,
            ]);
        }
        return redirect()->route('programmer.dashboard')->with('success', '✅ Course berhasil diperbarui!');
    }

    public function deleteCourse(Course $course)
    {
        $this->checkAccess();
        if ($course->instructor_id !== Auth::id() && Auth::user()->role !== 'admin') abort(403);
        $instructorId = $course->instructor_id;
        $course->delete();
        if ($instructorId) {
            \App\Models\User::recalcRatings($instructorId);
        }
        return back()->with('success', 'Course berhasil dihapus.');
    }
}

