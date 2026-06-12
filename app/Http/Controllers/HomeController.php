<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::with(['umkm', 'bids'])->where('status', 'open')->latest()->take(3)->get();
        $courses = Course::with('instructor')->where('is_published', true)->latest()->take(4)->get();
        $stats = [
            'programmers' => User::where('role', 'programmer')->count(),
            'projects_done' => Project::where('status', 'completed')->count(),
            'satisfaction' => 98,
            'avg_earning' => User::where('role', 'programmer')->where('total_earnings', '>', 0)->avg('total_earnings'),
        ];
        return view('welcome', compact('projects', 'courses', 'stats'));
    }

    public function caraKerja()
    {
        return view('cara-kerja');
    }

    public function projects(Request $request)
    {
        $query = Project::with(['umkm', 'bids'])->where('status', 'open');
        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $projects = $query->latest()->paginate(9);
        $categories = Project::distinct()->pluck('category');
        return view('projects.index', compact('projects', 'categories'));
    }

    public function courses(Request $request)
    {
        $query = Course::with('instructor')->where('is_published', true);
        if ($request->level) {
            $query->where('level', $request->level);
        }
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $courses = $query->latest()->paginate(9);
        return view('courses.index', compact('courses'));
    }

    public function courseDetail(Course $course)
    {
        $course->load(['instructor', 'videos', 'enrollments']);
        $isEnrolled = auth()->check() ? $course->enrollments->where('user_id', auth()->id())->isNotEmpty() : false;
        $relatedCourses = Course::where('category', $course->category)->where('id', '!=', $course->id)->take(3)->get();
        return view('courses.detail', compact('course', 'isEnrolled', 'relatedCourses'));
    }
}
