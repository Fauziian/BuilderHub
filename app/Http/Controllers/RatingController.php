<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Project;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * UMKM memberikan rating ke Programmer setelah project selesai.
     * Syarat: project status = 'completed' dan UMKM belum pernah rating project ini.
     */
    public function rateProject(Request $request, Project $project)
    {
        $user = Auth::user();

        // Pastikan user adalah UMKM pemilik project
        if ($project->umkm_id !== $user->id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk memberikan rating pada project ini.');
        }

        // Pastikan project sudah completed
        if ($project->status !== 'completed') {
            return back()->with('error', 'Rating hanya bisa diberikan setelah project selesai.');
        }

        // Pastikan project memiliki programmer
        if (!$project->assigned_programmer_id) {
            return back()->with('error', 'Project ini tidak memiliki programmer yang ditugaskan.');
        }

        // Cek apakah sudah pernah rating
        $existing = Review::where('project_id', $project->id)
            ->where('reviewer_id', $user->id)
            ->where('type', 'umkm')
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan rating untuk project ini.');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating (bintang) wajib dipilih.',
            'rating.min'      => 'Rating minimal 1 bintang.',
            'rating.max'      => 'Rating maksimal 5 bintang.',
        ]);

        Review::create([
            'project_id'  => $project->id,
            'course_id'   => null,
            'reviewer_id' => $user->id,
            'reviewed_id' => $project->assigned_programmer_id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
            'type'        => 'umkm',
        ]);

        // Update rata-rata rating programmer
        $this->recalcProgrammerRating($project->assigned_programmer_id);

        return back()->with('success', '⭐ Terima kasih! Rating dan ulasan Anda telah berhasil dikirim ke programmer.');
    }

    /**
     * Pelajar memberikan rating ke Programmer (instruktur course) setelah menyelesaikan course.
     * Syarat: enrollment status = 'completed' dan pelajar belum pernah rating course ini.
     */
    public function rateCourse(Request $request, Course $course)
    {
        $user = Auth::user();

        if ($user->role !== 'course') {
            return back()->with('error', 'Hanya Pelajar yang dapat memberikan rating course.');
        }

        // Cek enrollment dan status completed
        $enrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'Anda harus menyelesaikan course ini terlebih dahulu untuk memberikan rating.');
        }

        // Cek apakah sudah pernah rating course ini
        $existing = Review::where('course_id', $course->id)
            ->where('reviewer_id', $user->id)
            ->where('type', 'course')
            ->first();

        if ($existing) {
            return back()->with('info', 'Anda sudah memberikan rating untuk course ini sebelumnya.');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating (bintang) wajib dipilih.',
            'rating.min'      => 'Rating minimal 1 bintang.',
            'rating.max'      => 'Rating maksimal 5 bintang.',
        ]);

        Review::create([
            'project_id'  => null,
            'course_id'   => $course->id,
            'reviewer_id' => $user->id,
            'reviewed_id' => $course->instructor_id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
            'type'        => 'course',
        ]);

        // Update rating course dan programmer
        $this->recalcCourseRating($course);
        $this->recalcProgrammerRating($course->instructor_id);

        return back()->with('success', '⭐ Terima kasih! Rating course telah dikirim ke programmer.');
    }

    /**
     * Hitung ulang rata-rata rating programmer.
     * rating dari UMKM (type = umkm) disimpan di kolom `rating`
     * rating dari Pelajar (type = course) disimpan di kolom `course_rating`
     */
    private function recalcProgrammerRating(int $programmerId): void
    {
        $umkmAvg = Review::where('reviewed_id', $programmerId)
            ->where('type', 'umkm')
            ->avg('rating') ?? 0;

        $courseAvg = Review::where('reviewed_id', $programmerId)
            ->where('type', 'course')
            ->avg('rating') ?? 0;

        User::where('id', $programmerId)->update([
            'rating' => round($umkmAvg, 2),
            'course_rating' => round($courseAvg, 2),
        ]);
    }

    /**
     * Hitung ulang rata-rata rating course dari semua review course.
     */
    private function recalcCourseRating(Course $course): void
    {
        $avg = Review::where('course_id', $course->id)->where('type', 'course')->avg('rating') ?? 0;
        $course->update(['rating' => round($avg, 2)]);
    }
}
