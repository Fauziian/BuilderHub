<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    private function checkAccess(): void
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['course', 'admin', 'programmer'])) {
            abort(403, 'Akses ditolak.');
        }
    }

    public function dashboard()
    {
        $this->checkAccess();
        $user = Auth::user();

        if ($user->role === 'course') {
            $enrollments = CourseEnrollment::where('user_id', $user->id)
                ->with(['course.instructor', 'course.videos'])
                ->get();

            $categories = Course::where('is_published', true)->distinct()->pluck('category');

            $query = Course::where('is_published', true)->with('instructor');

            if ($search = request('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('category', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhereHas('instructor', function ($qi) use ($search) {
                          $qi->where('name', 'like', '%' . $search . '%');
                      });
                });
            }

            if ($level = request('level')) {
                $query->where('level', $level);
            }

            if ($category = request('category')) {
                $query->where('category', $category);
            }

            $availableCourses = $query->latest()->paginate(6)->withQueryString();

            // Review yang sudah diberikan pelajar ini (keyed by course_id)
            $givenCourseReviews = \App\Models\Review::where('reviewer_id', $user->id)
                ->where('type', 'course')
                ->get()
                ->keyBy('course_id');

            return view('course.student_dashboard', compact('user', 'enrollments', 'availableCourses', 'categories', 'givenCourseReviews'));
        }

        $courses = Course::with(['instructor', 'enrollments', 'videos'])->latest()->paginate(10);
        $totalStudents = CourseEnrollment::count();
        $totalRevenue = CourseEnrollment::sum('amount_paid');
        $totalCourses = Course::count();

        return view('course.dashboard', compact('user', 'courses', 'totalStudents', 'totalRevenue', 'totalCourses'));
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:pemula,menengah,mahir',
            'category' => 'required|string|max:100',
            'instructor_id' => 'required|exists:users,id',
        ]);

        Course::create([
            'instructor_id' => $request->instructor_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->has('is_free') ? 0 : $request->price,
            'level' => $request->level,
            'category' => $request->category,
            'is_free' => $request->has('is_free'),
            'is_published' => $request->has('is_published'),
            'duration' => $request->duration,
        ]);

        return back()->with('success', '✅ Course berhasil dibuat!');
    }

    public function addVideo(Request $request, Course $course)
    {
        $this->checkAccess();
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'duration' => 'nullable|string',
        ]);

        $order = CourseVideo::where('course_id', $course->id)->max('order') + 1;

        CourseVideo::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'video_url' => $request->video_url,
            'duration' => $request->duration,
            'order' => $order,
        ]);

        $course->update(['total_videos' => $course->videos()->count()]);

        return back()->with('success', '✅ Video berhasil ditambahkan!');
    }

    public function togglePublish(Course $course)
    {
        $this->checkAccess();
        $course->update(['is_published' => !$course->is_published]);
        $status = $course->is_published ? 'dipublikasikan' : 'tidak dipublikasikan';
        return back()->with('success', "Course berhasil $status.");
    }

    public function deleteVideo(CourseVideo $video)
    {
        $this->checkAccess();
        $course = $video->course;
        $video->delete();
        $course->update(['total_videos' => $course->videos()->count()]);
        return back()->with('success', 'Video dihapus.');
    }

    public function enroll(Request $request, Course $course)
    {
        if (Auth::user()->role !== 'course') {
            return back()->with('error', 'Hanya Pelajar / Student yang dapat mengikuti course.');
        }

        $existing = CourseEnrollment::where('user_id', Auth::id())->where('course_id', $course->id)->first();
        if ($existing) {
            return redirect()->route('course.dashboard')->with('info', 'Anda sudah terdaftar di course ini.');
        }

        $amountPaid = $course->is_free ? 0 : $course->price;

        CourseEnrollment::create([
            'course_id' => $course->id,
            'user_id' => Auth::id(),
            'amount_paid' => $amountPaid,
            'status' => 'active',
        ]);

        $course->increment('total_students');

        // Programmer mendapatkan 80% pendapatan dari penjualan course
        if ($amountPaid > 0) {
            $instructor = $course->instructor;
            if ($instructor) {
                $instructor->increment('total_earnings', $amountPaid * 0.80);
            }
        }

        return redirect()->route('course.dashboard')->with('success', '✅ Berhasil mendaftar course! Selamat belajar.');
    }

    public function complete(Course $course)
    {
        $enrollment = CourseEnrollment::where('user_id', Auth::id())->where('course_id', $course->id)->firstOrFail();

        if ($enrollment->status === 'completed') {
            return back()->with('info', 'Course ini sudah selesai sebelumnya.');
        }

        $enrollment->update(['status' => 'completed']);

        return redirect()
            ->route('course.dashboard')
            ->with('success', '🎉 Selamat! Anda telah menyelesaikan course ini. Sertifikat Anda kini tersedia.')
            ->with('prompt_rating_course_id', $course->id)
            ->with('prompt_rating_course_title', $course->title)
            ->with('prompt_rating_instructor', $course->instructor->name);
    }

    public function showUpgradeForm()
    {
        if (Auth::user()->role !== 'course') {
            return redirect()->route('dashboard');
        }
        $user = Auth::user();
        
        // Cek status belajar & kelulusan pelajar
        $hasEnrollments = CourseEnrollment::where('user_id', $user->id)->exists();
        $completedEnrollments = CourseEnrollment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('course.instructor')
            ->get();
            
        $hasCompletedCourse = !$completedEnrollments->isEmpty();

        // Syarat mutlak: Harus lulus minimal 1 course di BuilderHub!
        if (!$hasCompletedCourse) {
            return redirect()->route('course.dashboard')
                ->with('error', 'Akses ditolak: Anda wajib menyelesaikan minimal 1 course di BuilderHub dan mengklaim sertifikat kelulusan sebelum dapat mengajukan upgrade akun.');
        }

        return view('course.upgrade_programmer', compact('user', 'completedEnrollments', 'hasEnrollments', 'hasCompletedCourse'));
    }

    public function processUpgrade(Request $request)
    {
        if (Auth::user()->role !== 'course') {
            return redirect()->route('dashboard');
        }
        
        $user = Auth::user();

        // Syarat mutlak: Harus lulus minimal 1 course di BuilderHub!
        $hasCompletedCourse = CourseEnrollment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->exists();

        if (!$hasCompletedCourse) {
            return redirect()->route('course.dashboard')
                ->with('error', 'Akses ditolak: Anda wajib menyelesaikan minimal 1 course di BuilderHub dan mengklaim sertifikat kelulusan sebelum dapat mengajukan upgrade akun.');
        }

        $request->validate([
            'ktp_number' => 'required|numeric|digits:16',
            'ktp_photo' => 'required|image|max:2048',
            'cv_file' => 'required|mimes:pdf,doc,docx|max:3072',
            'bio' => 'required|string|min:20',
            'expertise' => 'required|string|max:255',
            'builderhub_certificate' => 'nullable|exists:courses,id',
            'external_certificate' => 'required_if:certificate_choice,external|nullable|mimes:pdf,jpg,jpeg,png|max:3072',
            'external_certificate_name' => 'required_if:certificate_choice,external|nullable|string|max:255',
            'external_certificate_issuer' => 'required_if:certificate_choice,external|nullable|string|max:255',
            'external_certificate_date' => 'required_if:certificate_choice,external|nullable|date',
        ], [
            'ktp_number.required' => 'Nomor KTP wajib diisi',
            'ktp_number.digits' => 'Nomor KTP harus tepat 16 digit',
            'ktp_number.numeric' => 'Nomor KTP harus berupa angka',
            'ktp_photo.required' => 'Foto KTP wajib diunggah',
            'ktp_photo.image' => 'Foto KTP harus berupa gambar (jpeg, png, jpg)',
            'ktp_photo.max' => 'Ukuran foto KTP maksimal 2MB',
            'cv_file.required' => 'Dokumen CV wajib diunggah',
            'cv_file.mimes' => 'Dokumen CV harus berformat PDF, DOC, atau DOCX',
            'cv_file.max' => 'Ukuran dokumen CV maksimal 3MB',
            'bio.required' => 'Bio / Deskripsi diri wajib diisi',
            'bio.min' => 'Bio minimal 20 karakter',
            'expertise.required' => 'Keahlian wajib diisi',
            'external_certificate.required_if' => 'File sertifikat eksternal wajib diunggah jika memilih opsi sertifikat eksternal',
            'external_certificate.mimes' => 'Sertifikat eksternal harus berformat PDF atau Gambar',
            'external_certificate.max' => 'Ukuran file sertifikat eksternal maksimal 3MB',
            'external_certificate_name.required_if' => 'Nama sertifikat eksternal wajib diisi',
            'external_certificate_issuer.required_if' => 'Penerbit sertifikat eksternal wajib diisi',
            'external_certificate_date.required_if' => 'Tanggal terbit sertifikat eksternal wajib diisi',
        ]);

        // 1. Update user fields and change role to 'programmer'
        $userData = [
            'role' => 'programmer',
            'is_verified' => false,
            'ktp_number' => $request->ktp_number,
            'bio' => $request->bio,
            'expertise' => $request->expertise,
        ];

        if ($request->hasFile('ktp_photo')) {
            $userData['ktp_photo'] = $request->file('ktp_photo')->store('verification/ktp', 'public');
        }
        if ($request->hasFile('cv_file')) {
            $userData['cv_file'] = $request->file('cv_file')->store('verification/cv', 'public');
        }

        $user->update($userData);

        // 2. Create the Certificate record in the certificates table
        if ($request->builderhub_certificate) {
            $course = Course::with('instructor')->find($request->builderhub_certificate);
            \App\Models\Certificate::create([
                'programmer_id' => $user->id,
                'name' => 'Sertifikat Kelulusan: ' . $course->title,
                'issuer' => 'BuilderHub Academy (oleh ' . $course->instructor->name . ')',
                'issue_date' => now(),
                'status' => 'pending', // Will be approved when admin approves the user!
            ]);
        } elseif ($request->hasFile('external_certificate')) {
            $path = $request->file('external_certificate')->store('verification/certificates', 'public');
            \App\Models\Certificate::create([
                'programmer_id' => $user->id,
                'name' => $request->external_certificate_name,
                'issuer' => $request->external_certificate_issuer,
                'issue_date' => $request->external_certificate_date,
                'certificate_file' => $path,
                'status' => 'pending',
            ]);
        } else {
            // Default fall-back
            \App\Models\Certificate::create([
                'programmer_id' => $user->id,
                'name' => 'Sertifikat Kompetensi Awal',
                'issuer' => 'BuilderHub Academy',
                'issue_date' => now(),
                'status' => 'pending',
            ]);
        }

        // Send notification to user
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'title' => 'Permohonan Upgrade Programmer',
            'message' => 'Akun Anda berhasil diajukan untuk upgrade menjadi Programmer. Menunggu verifikasi admin 1 x 24 jam.',
            'type' => 'info',
        ]);

        return redirect()->route('dashboard')->with('success', 'Akun Anda berhasil diajukan untuk upgrade menjadi Programmer! Silakan tunggu verifikasi admin 1 x 24 jam untuk mulai mengambil project.');
    }
}
