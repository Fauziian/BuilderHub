<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Tampilkan halaman Messenger
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $selectedContactId = $request->query('contact_id');
        $selectedProjectId = $request->query('project_id');
        $selectedCourseId = $request->query('course_id');
        $initialMessage = $request->query('msg');

        return view('messenger.index', compact('selectedContactId', 'selectedProjectId', 'selectedCourseId', 'initialMessage'));
    }

    /**
     * Ambil daftar thread chat (conversations) untuk user login
     */
    public function getThreads(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();
        
        // 1. Dapatkan user-user yang sudah pernah bertukar pesan
        $sentContacts = Message::where('sender_id', $userId)->pluck('receiver_id')->toArray();
        $receivedContacts = Message::where('receiver_id', $userId)->pluck('sender_id')->toArray();
        $chattedUserIds = array_unique(array_merge($sentContacts, $receivedContacts));

        // 2. Dapatkan relasi bisnis baru yang belum sempat chat
        $potentialUserIds = [];
        if ($user->role === 'umkm') {
            // Programmer yang bid di project milik UMKM ini
            $projectIds = Project::where('umkm_id', $userId)->pluck('id');
            $potentialUserIds = Bid::whereIn('project_id', $projectIds)->pluck('programmer_id')->toArray();
        } elseif ($user->role === 'programmer') {
            // UMKM pemilik project yang di-bid oleh Programmer ini
            $projectIds = Bid::where('programmer_id', $userId)->pluck('project_id');
            $potentialUserIds = Project::whereIn('id', $projectIds)->pluck('umkm_id')->toArray();

            // Pelajar yang terdaftar di course milik programmer ini
            $courseIds = Course::where('instructor_id', $userId)->pluck('id');
            $studentIds = CourseEnrollment::whereIn('course_id', $courseIds)->pluck('user_id')->toArray();
            $potentialUserIds = array_unique(array_merge($potentialUserIds, $studentIds));
        } elseif ($user->role === 'course') {
            // Instruktur programmer dari course yang dibeli oleh Pelajar ini
            $courseIds = CourseEnrollment::where('user_id', $userId)->pluck('course_id');
            $potentialUserIds = Course::whereIn('id', $courseIds)->pluck('instructor_id')->toArray();
        }

        $allContactIds = array_unique(array_merge($chattedUserIds, $potentialUserIds));
        if ($request->has('contact_id')) {
            $allContactIds[] = (int)$request->query('contact_id');
        }
        $allContactIds = array_filter($allContactIds, fn($id) => $id != $userId);

        $contacts = User::whereIn('id', $allContactIds)->get();

        $threads = [];
        foreach ($contacts as $contact) {
            // Dapatkan pesan terakhir antara user login dan kontak ini
            $lastMsg = Message::where(function($q) use ($userId, $contact) {
                    $q->where('sender_id', $userId)->where('receiver_id', $contact->id);
                })->orWhere(function($q) use ($userId, $contact) {
                    $q->where('sender_id', $contact->id)->where('receiver_id', $userId);
                })
                ->orderBy('created_at', 'desc')
                ->first();

            // Hitung unread count
            $unreadCount = Message::where('sender_id', $contact->id)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();

            // Cek context (Project atau Course) yang mengaitkan mereka
            $contextLabel = '';
            $contextProjectId = null;
            $contextCourseId = null;

            if ($lastMsg && $lastMsg->project_id) {
                $proj = Project::find($lastMsg->project_id);
                if ($proj) {
                    $contextLabel = '💼 Project: ' . $proj->title;
                    $contextProjectId = $proj->id;
                }
            } elseif ($lastMsg && $lastMsg->course_id) {
                $crs = Course::find($lastMsg->course_id);
                if ($crs) {
                    $contextLabel = '📚 Course: ' . $crs->title;
                    $contextCourseId = $crs->id;
                }
            } else {
                // Cari default context jika belum ada chat
                if ($user->role === 'umkm' || $contact->role === 'umkm') {
                    $umkmId = $user->role === 'umkm' ? $userId : $contact->id;
                    $progId = $user->role === 'programmer' ? $userId : $contact->id;
                    $sharedProj = Project::where('umkm_id', $umkmId)
                        ->where(function($q) use ($progId) {
                            $q->where('assigned_programmer_id', $progId)
                              ->orWhereHas('bids', fn($b) => $b->where('programmer_id', $progId));
                        })->first();
                    if ($sharedProj) {
                        $contextLabel = '💼 Project: ' . $sharedProj->title;
                        $contextProjectId = $sharedProj->id;
                    }
                } elseif ($user->role === 'course' || $contact->role === 'course') {
                    $studentId = $user->role === 'course' ? $userId : $contact->id;
                    $instId = $user->role === 'programmer' ? $userId : $contact->id;
                    $sharedEnroll = CourseEnrollment::where('user_id', $studentId)
                        ->whereHas('course', fn($c) => $c->where('instructor_id', $instId))
                        ->with('course')
                        ->first();
                    if ($sharedEnroll && $sharedEnroll->course) {
                        $contextLabel = '📚 Course: ' . $sharedEnroll->course->title;
                        $contextCourseId = $sharedEnroll->course->id;
                    }
                }
            }

            $threads[] = [
                'contact_id'        => $contact->id,
                'contact_name'      => $contact->name,
                'contact_role'      => strtoupper($contact->role === 'course' ? 'pelajar' : $contact->role),
                'last_message'      => $lastMsg ? $lastMsg->message : 'Belum ada pesan.',
                'last_message_time' => $lastMsg ? $lastMsg->created_at->diffForHumans() : '',
                'unread_count'      => $unreadCount,
                'context_label'     => $contextLabel,
                'project_id'        => $contextProjectId,
                'course_id'         => $contextCourseId,
            ];
        }

        // Urutkan thread yang memiliki pesan terbaru di atas
        usort($threads, function($a, $b) {
            return strcmp($b['last_message_time'], $a['last_message_time']);
        });

        return response()->json($threads);
    }

    /**
     * Ambil isi pesan detail dengan kontak tertentu
     */
    public function getMessages(Request $request, User $contact)
    {
        $userId = Auth::id();

        $messages = Message::where(function($q) use ($userId, $contact) {
                $q->where('sender_id', $userId)->where('receiver_id', $contact->id);
            })
            ->orWhere(function($q) use ($userId, $contact) {
                $q->where('sender_id', $contact->id)->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'sender'     => $m->sender->name,
                'message'    => $m->message,
                'created_at' => $m->created_at->format('H:i, d M Y'),
                'is_me'      => $m->sender_id === $userId,
            ]);

        // Tandai sudah dibaca
        Message::where('sender_id', $contact->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    /**
     * Kirim pesan baru
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|string|max:2000',
        ]);

        $userId = Auth::id();
        $receiverId = $request->receiver_id;

        // Auto-detect context if not explicitly passed
        $projectId = $request->project_id;
        $courseId = $request->course_id;

        if (!$projectId && !$courseId) {
            // Cari project yang mengaitkan keduanya
            $umkmId = Auth::user()->role === 'umkm' ? $userId : $receiverId;
            $progId = Auth::user()->role === 'programmer' ? $userId : $receiverId;
            $sharedProj = Project::where('umkm_id', $umkmId)
                ->where(function($q) use ($progId) {
                    $q->where('assigned_programmer_id', $progId)
                      ->orWhereHas('bids', fn($b) => $b->where('programmer_id', $progId));
                })->first();
            if ($sharedProj) {
                $projectId = $sharedProj->id;
            } else {
                // Cari course yang mengaitkan keduanya
                $studentId = Auth::user()->role === 'course' ? $userId : $receiverId;
                $instId = Auth::user()->role === 'programmer' ? $userId : $receiverId;
                $sharedEnroll = CourseEnrollment::where('user_id', $studentId)
                    ->whereHas('course', fn($c) => $c->where('instructor_id', $instId))
                    ->with('course')
                    ->first();
                if ($sharedEnroll && $sharedEnroll->course) {
                    $courseId = $sharedEnroll->course->id;
                }
            }
        }

        $msg = Message::create([
            'sender_id'   => $userId,
            'receiver_id' => $receiverId,
            'project_id'  => $projectId ?: null,
            'course_id'   => $courseId ?: null,
            'message'     => $request->message,
        ]);

        return response()->json([
            'ok'         => true,
            'id'         => $msg->id,
            'sender'     => Auth::user()->name,
            'message'    => $msg->message,
            'created_at' => $msg->created_at->format('H:i, d M Y'),
            'is_me'      => true,
        ]);
    }
}
