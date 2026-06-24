<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgrammerController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cara-kerja', [HomeController::class, 'caraKerja'])->name('cara-kerja');
Route::get('/projects', [HomeController::class, 'projects'])->name('projects');
Route::get('/courses', [HomeController::class, 'courses'])->name('courses.index');
Route::get('/courses/{course}', [HomeController::class, 'courseDetail'])->name('courses.detail');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard redirect
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Messenger / Central Chat system (for all roles)
Route::middleware('auth')->group(function () {
    Route::get('/messages', [ChatController::class, 'index'])->name('messages.index');
    Route::get('/api/chat/threads', [ChatController::class, 'getThreads'])->name('chat.threads');
    Route::get('/api/chat/messages/{contact}', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/api/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    // Notifikasi bell global (semua role)
    Route::get('/api/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/api/notifications/mark-read', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.mark-read');
    Route::post('/api/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.read');
});

// Programmer routes
Route::prefix('programmer')->name('programmer.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [ProgrammerController::class, 'dashboard'])->name('dashboard');
    Route::get('/projects', [ProgrammerController::class, 'projects'])->name('projects');
    Route::post('/projects/{project}/bid', [ProgrammerController::class, 'submitBid'])->name('bid');
    Route::post('/bid/{bid}/update', [ProgrammerController::class, 'updateBid'])->name('bid.update');
    Route::post('/profile', [ProgrammerController::class, 'updateProfile'])->name('profile.update');

    // Portfolio CRUD
    Route::post('/portfolio', [ProgrammerController::class, 'addPortfolio'])->name('portfolio.store');
    Route::get('/portfolio/{portfolio}/edit', [ProgrammerController::class, 'editPortfolio'])->name('portfolio.edit');
    Route::put('/portfolio/{portfolio}', [ProgrammerController::class, 'updatePortfolio'])->name('portfolio.update');
    Route::delete('/portfolio/{portfolio}', [ProgrammerController::class, 'deletePortfolio'])->name('portfolio.delete');

    // Certificate CRUD
    Route::post('/certificate', [ProgrammerController::class, 'addCertificate'])->name('certificate.store');
    Route::delete('/certificate/{certificate}', [ProgrammerController::class, 'deleteCertificate'])->name('certificate.delete');

    // Course CRUD (by programmer)
    Route::get('/create-course', [ProgrammerController::class, 'createCourse'])->name('create-course');
    Route::post('/create-course', [ProgrammerController::class, 'storeCourse'])->name('store-course');
    Route::get('/course/{course}/edit', [ProgrammerController::class, 'editCourse'])->name('course.edit');
    Route::put('/course/{course}', [ProgrammerController::class, 'updateCourse'])->name('course.update');
    Route::delete('/course/{course}', [ProgrammerController::class, 'deleteCourse'])->name('course.delete');

    // Chat with UMKM
    Route::post('/project/{project}/message', [UmkmController::class, 'sendMessage'])->name('project.message');
    Route::get('/project/{project}/messages', [UmkmController::class, 'getMessages'])->name('project.messages');
});

// UMKM routes
Route::prefix('umkm')->name('umkm.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [UmkmController::class, 'dashboard'])->name('dashboard');

    // Project CRUD
    Route::post('/project', [UmkmController::class, 'storeProject'])->name('project.store');
    Route::get('/project/{project}/edit', [UmkmController::class, 'editProject'])->name('project.edit');
    Route::put('/project/{project}', [UmkmController::class, 'updateProject'])->name('project.update');
    Route::delete('/project/{project}', [UmkmController::class, 'deleteProject'])->name('project.delete');

    Route::post('/bid/{bid}/accept', [UmkmController::class, 'acceptBid'])->name('bid.accept');
    Route::post('/bid/{bid}/reject', [UmkmController::class, 'rejectBid'])->name('bid.reject');
    Route::post('/project/{project}/complete', [UmkmController::class, 'completeProject'])->name('project.complete');

    // Rating Programmer (oleh UMKM, setelah project selesai)
    Route::post('/project/{project}/rate', [RatingController::class, 'rateProject'])->name('project.rate');

    // Chat with Programmer
    Route::post('/project/{project}/message', [UmkmController::class, 'sendMessage'])->name('project.message');
    Route::get('/project/{project}/messages', [UmkmController::class, 'getMessages'])->name('project.messages');

    // Notifikasi bid baru
    Route::post('/bids/mark-seen', [UmkmController::class, 'markBidsSeen'])->name('bids.mark-seen');
    Route::get('/bids/unseen-count', [UmkmController::class, 'getUnseenBidsCount'])->name('bids.unseen-count');
});

// Course Manager & Student routes
Route::prefix('course-manager')->name('course.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [CourseController::class, 'dashboard'])->name('dashboard');
    Route::post('/store', [CourseController::class, 'store'])->name('store');
    Route::post('/course/{course}/video', [CourseController::class, 'addVideo'])->name('video.store');
    Route::post('/course/{course}/toggle-publish', [CourseController::class, 'togglePublish'])->name('toggle-publish');
    Route::delete('/video/{video}', [CourseController::class, 'deleteVideo'])->name('video.delete');
    Route::post('/course/{course}/enroll', [CourseController::class, 'enroll'])->name('enroll');
    Route::post('/course/{course}/complete', [CourseController::class, 'complete'])->name('complete');

    // Rating Programmer (oleh Pelajar, setelah course selesai)
    Route::post('/course/{course}/rate', [RatingController::class, 'rateCourse'])->name('course.rate');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/verify-programmer', [AdminController::class, 'verifyProgrammer'])->name('verify-programmer');
    Route::post('/users/{user}/verify-umkm', [AdminController::class, 'verifyUmkm'])->name('verify-umkm');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('delete-user');
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
    Route::post('/projects/{project}/approve', [AdminController::class, 'approveProject'])->name('approve-project');
    Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('delete-project');
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
    Route::post('/courses/{course}/publish', [AdminController::class, 'publishCourse'])->name('publish-course');
    Route::delete('/courses/{course}', [AdminController::class, 'deleteCourse'])->name('delete-course');
    Route::post('/portfolio/{portfolio}/approve', [AdminController::class, 'approvePortfolio'])->name('portfolio.approve');
    Route::post('/portfolio/{portfolio}/reject', [AdminController::class, 'rejectPortfolio'])->name('portfolio.reject');
    Route::post('/certificate/{certificate}/approve', [AdminController::class, 'approveCertificate'])->name('certificate.approve');
    Route::post('/certificate/{certificate}/reject', [AdminController::class, 'rejectCertificate'])->name('certificate.reject');
});
