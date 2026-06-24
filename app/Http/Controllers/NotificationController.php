<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Ambil 15 notifikasi terbaru milik user yang sedang login (untuk dropdown bell navbar).
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(15)
            ->get()
            ->map(function($n) use ($user) {
                $link = $n->link;
                if ($user->role === 'course' && ($n->type === 'new_course' || $n->link === '/courses' || str_contains($n->link, '/courses/detail'))) {
                    // Ekstrak judul course di antara tanda kutip ganda dari pesan
                    if (preg_match('/"([^"]+)"/', $n->message, $matches)) {
                        $courseTitle = $matches[1];
                        $link = '/course-manager/dashboard?search=' . urlencode($courseTitle) . '#explore';
                    } else {
                        $link = '/course-manager/dashboard#explore';
                    }
                }
                
                return [
                    'id'         => $n->id,
                    'title'      => $n->title,
                    'message'    => $n->message,
                    'type'       => $n->type,
                    'link'       => $link,
                    'is_read'    => $n->is_read,
                    'created_at' => $n->created_at->diffForHumans(),
                ];
            });

        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }

    /**
     * Mark semua notifikasi user sebagai sudah dibaca.
     */
    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['ok' => true]);
    }

    /**
     * Mark satu notifikasi sebagai sudah dibaca.
     */
    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        $notification->update(['is_read' => true]);
        return response()->json(['ok' => true]);
    }
}
