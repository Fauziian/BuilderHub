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

            $availableCourses = Course::where('is_published', true)
                ->with('instructor')
                ->get();

            // Review yang sudah diberikan pelajar ini (keyed by course_id)
            $givenCourseReviews = \App\Models\Review::where('reviewer_id', $user->id)
                ->where('type', 'course')
                ->get()
                ->keyBy('course_id');

            return view('course.student_dashboard', compact('user', 'enrollments', 'availableCourses', 'givenCourseReviews'));
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
}
