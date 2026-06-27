<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Project;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmController extends Controller
{
    private function checkAccess(): void
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['umkm', 'admin'])) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk UMKM.');
        }
    }

    public function dashboard()
    {
        $this->checkAccess();
        $user = Auth::user();
        $projects = Project::where('umkm_id', $user->id)
            ->with(['bids.programmer', 'programmer'])
            ->latest()->get();
        $totalBudget = $projects->where('status', 'completed')->sum('budget');
        $programmers = \App\Models\User::where('role', 'programmer')->latest()->get();

        // Rating yang sudah diberikan UMKM ini (keyed by project_id)
        $givenReviews = \App\Models\Review::where('reviewer_id', $user->id)
            ->where('type', 'umkm')
            ->get()
            ->keyBy('project_id');

        // Hitung bid baru yang belum dilihat UMKM (untuk badge notifikasi di tab Project Saya)
        $unseenBidsCount = Bid::whereIn('project_id', $projects->pluck('id'))
            ->where('is_seen_by_umkm', false)
            ->where('status', 'pending')
            ->count();

        // Hitung notifikasi bid yang belum dibaca
        $unreadNotificationsCount = Notification::where('user_id', $user->id)
            ->where('type', 'bid')
            ->where('is_read', false)
            ->count();

        return view('umkm.dashboard', compact('user', 'projects', 'totalBudget', 'programmers', 'givenReviews', 'unseenBidsCount', 'unreadNotificationsCount'));
    }

    public function storeProject(Request $request)
    {
        $this->checkAccess();
        if (!Auth::user()->umkm_verified) {
            return back()->with('error', '❌ Gagal: Akun UMKM Anda belum diverifikasi. Menunggu 1 x 24 jam verifikasi oleh admin agar dapat memosting project.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'deadline'    => 'nullable|date|after:today',
            'category'    => 'required|string',
            'app_type'    => 'required|string',
        ], [
            'title.required'       => 'Judul project wajib diisi',
            'description.required' => 'Deskripsi project wajib diisi',
            'description.min'      => 'Deskripsi minimal 50 karakter agar programmer memahami kebutuhan Anda',
            'deadline.after'       => 'Deadline harus setelah hari ini',
            'category.required'    => 'Kategori wajib dipilih',
            'app_type.required'    => 'Jenis Aplikasi wajib dipilih',
        ]);

        $tags = [$request->app_type];

        Project::create([
            'umkm_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'budget'      => 0,
            'deadline'    => $request->deadline ?? date('Y-m-d', strtotime('+3 months')),
            'status'      => 'pending',
            'category'    => $request->category,
            'tags'        => $tags,
            'platform_fee'       => 0,
            'programmer_earning' => 0,
        ]);

        // Notifikasi ke admin bahwa ada project baru yang perlu di-ACC
        NotificationService::projectSubmitted(Auth::id(), Auth::user()->name, $request->title);

        return back()->with('success', '✅ Project berhasil diajukan! Menunggu ACC/Persetujuan Admin sebelum dipublikasikan ke Programmer.');
    }

    public function editProject(Project $project)
    {
        $this->checkAccess();
        if ($project->umkm_id !== Auth::id()) abort(403);
        if (!in_array($project->status, ['pending'])) {
            return back()->with('error', 'Project yang sudah disetujui tidak dapat diedit.');
        }
        return response()->json($project);
    }

    public function updateProject(Request $request, Project $project)
    {
        $this->checkAccess();
        if ($project->umkm_id !== Auth::id()) abort(403);
        if (!in_array($project->status, ['pending'])) {
            return back()->with('error', 'Project yang sudah disetujui tidak dapat diedit.');
        }
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'deadline'    => 'nullable|date|after:today',
            'category'    => 'required|string',
            'app_type'    => 'required|string',
        ]);
        $project->update([
            'title'       => $request->title,
            'description' => $request->description,
            'deadline'    => $request->deadline ?? $project->deadline,
            'category'    => $request->category,
            'tags'        => [$request->app_type],
        ]);
        return back()->with('success', '✅ Project berhasil diperbarui!');
    }

    public function deleteProject(Project $project)
    {
        $this->checkAccess();
        if ($project->umkm_id !== Auth::id() && Auth::user()->role !== 'admin') abort(403);
        if ($project->status === 'in_progress') {
            return back()->with('error', 'Project yang sedang berjalan tidak dapat dihapus.');
        }
        $programmerId = $project->assigned_programmer_id;
        $project->delete();

        if ($programmerId) {
            \App\Models\User::recalcRatings($programmerId);
        }

        return back()->with('success', 'Project berhasil dihapus.');
    }

    /**
     * Mark semua bid pada project UMKM ini sebagai sudah dilihat
     * Dipanggil via AJAX ketika UMKM membuka tab "Project Saya"
     */
    public function markBidsSeen()
    {
        $this->checkAccess();
        $user = Auth::user();

        // Ambil semua project milik user ini
        $projectIds = Project::where('umkm_id', $user->id)->pluck('id');

        // Mark semua bid yang belum dilihat sebagai sudah dilihat
        Bid::whereIn('project_id', $projectIds)
            ->where('is_seen_by_umkm', false)
            ->update(['is_seen_by_umkm' => true]);

        // Mark juga notifikasi bid sebagai sudah dibaca
        Notification::where('user_id', $user->id)
            ->where('type', 'bid')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['ok' => true]);
    }

    /**
     * Hitung jumlah bid baru yang belum dilihat (untuk badge real-time)
     */
    public function getUnseenBidsCount()
    {
        $this->checkAccess();
        $user = Auth::user();

        $projectIds = Project::where('umkm_id', $user->id)->pluck('id');
        $count = Bid::whereIn('project_id', $projectIds)
            ->where('is_seen_by_umkm', false)
            ->where('status', 'pending')
            ->count();

        return response()->json(['count' => $count]);
    }

    public function acceptBid(Bid $bid)
    {
        $this->checkAccess();
        $project = $bid->project;
        if ($project->umkm_id !== Auth::id()) {
            abort(403);
        }

        // Tolak semua bid lain + notifikasi ke programmer yang ditolak
        $otherBids = Bid::where('project_id', $project->id)->where('id', '!=', $bid->id)->get();
        foreach ($otherBids as $otherBid) {
            NotificationService::bidRejected($otherBid->programmer_id, Auth::user()->business_name ?? Auth::user()->name, $project->title, true);
        }
        Bid::where('project_id', $project->id)->where('id', '!=', $bid->id)->update(['status' => 'rejected']);
        $bid->update(['status' => 'accepted']);

        // Set budget project & split fee (80% platform / 20% programmer)
        // Set status tetap 'open' namun dengan assigned_programmer dan escrow_status = 'unpaid'
        $project->update([
            'status'                  => 'open',
            'assigned_programmer_id'  => $bid->programmer_id,
            'budget'                  => $bid->amount,
            'platform_fee'            => $bid->amount * 0.80,
            'programmer_earning'      => $bid->amount * 0.20,
            'escrow_status'           => 'unpaid',
            'project_progress'        => 0,
        ]);

        // Notifikasi ke programmer pemenang
        \App\Models\Notification::create([
            'user_id' => $bid->programmer_id,
            'title'   => 'Penawaran Diterima! Menunggu Pembayaran 💰',
            'message' => 'Penawaran Anda sebesar Rp ' . number_format($bid->amount, 0, ',', '.') . ' untuk project "' . $project->title . '" telah disetujui. Pekerjaan dapat dimulai setelah UMKM menyelesaikan pembayaran Rekber.',
            'type'    => 'bid',
            'link'    => '/programmer/dashboard',
            'is_read' => false,
        ]);

        return back()->with('success', "✅ Penawaran Rp " . number_format($bid->amount, 0, ',', '.') . " dari {$bid->programmer->name} diterima! Silakan lakukan pembayaran Rekber (Rekening Bersama) agar programmer dapat mulai bekerja.");
    }

    public function rejectBid(Bid $bid)
    {
        $this->checkAccess();
        $project = $bid->project;
        if ($project->umkm_id !== Auth::id()) {
            abort(403);
        }

        $bid->increment('rejection_count');
        $bid->update(['is_revised' => false]);

        if ($bid->rejection_count >= 2) {
            $bid->update(['status' => 'rejected']);
            NotificationService::bidRejected($bid->programmer_id, Auth::user()->business_name ?? Auth::user()->name, $project->title, true);
            return back()->with('success', "Penawaran dari {$bid->programmer->name} ditolak secara permanen (Ditolak!).");
        } else {
            $bid->update(['status' => 'pending']);
            NotificationService::bidRejected($bid->programmer_id, Auth::user()->business_name ?? Auth::user()->name, $project->title, false);
            return back()->with('success', "Penawaran dari {$bid->programmer->name} ditolak. Programmer dapat mengajukan penawaran kembali.");
        }
    }

    public function payProject(Request $request, Project $project)
    {
        $this->checkAccess();
        if ($project->umkm_id !== Auth::id()) {
            abort(403);
        }
        if ($project->escrow_status !== 'unpaid') {
            return back()->with('error', 'Project ini sudah dibayar ke Rekber.');
        }

        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $project->update([
            'status' => 'in_progress',
            'escrow_status' => 'held_by_admin',
            'payment_method' => $request->payment_method,
            'payment_date' => now(),
        ]);

        // Kirim notifikasi ke Programmer
        \App\Models\Notification::create([
            'user_id' => $project->assigned_programmer_id,
            'title' => 'Pembayaran Rekber Diterima! 💳',
            'message' => 'UMKM ' . (Auth::user()->business_name ?? Auth::user()->name) . ' telah membayar Rp ' . number_format($project->budget, 0, ',', '.') . ' via ' . $request->payment_method . '. Dana aman di Rekber (Admin). Silakan mulai pengerjaan!',
            'type' => 'project',
            'link' => '/programmer/dashboard',
            'is_read' => false,
        ]);

        // Kirim notifikasi ke UMKM
        \App\Models\Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Pembayaran Rekber Berhasil! 🎉',
            'message' => 'Pembayaran Rp ' . number_format($project->budget, 0, ',', '.') . ' via ' . $request->payment_method . ' berhasil diamankan di Rekber Admin. Programmer telah diinstruksikan untuk mulai bekerja.',
            'type' => 'project',
            'link' => '/umkm/dashboard',
            'is_read' => false,
        ]);

        return back()->with('success', '✅ Pembayaran Rekber berhasil! Project sekarang dalam status Berjalan (Dalam Pengerjaan) dan Programmer telah dinotifikasi.');
    }

    public function completeProject(Project $project)
    {
        $this->checkAccess();
        if ($project->umkm_id !== Auth::id()) {
            abort(403);
        }

        if ($project->status === 'completed') {
            return back()->with('info', 'Project ini sudah selesai.');
        }

        $project->update([
            'status' => 'completed',
            'escrow_status' => 'released',
            'project_progress' => 100
        ]);

        if ($project->assigned_programmer_id) {
            $programmer = $project->programmer;
            $earning = $project->programmer_earning > 0 ? $project->programmer_earning : ($project->budget * 0.20);
            
            $programmer->increment('total_earnings', $earning);
            $programmer->increment('total_projects');

            // Notifikasi ke programmer bahwa project selesai dan pembayaran dirilis
            \App\Models\Notification::create([
                'user_id' => $programmer->id,
                'title' => 'Dana Rekber Dirilis! 💰',
                'message' => 'Project "' . $project->title . '" telah diselesaikan oleh UMKM. Dana sebesar Rp ' . number_format($earning, 0, ',', '.') . ' (20%) telah dicairkan ke saldo Anda.',
                'type' => 'project',
                'link' => '/programmer/dashboard',
                'is_read' => false,
            ]);
        }

        return back()->with('success', '✅ Project diselesaikan! Dana Rekber telah dicairkan ke saldo Programmer.');
    }

    /**
     * Kirim pesan negosiasi dari UMKM ke Programmer (atau sebaliknya)
     */
    public function sendMessage(Request $request, Project $project)
    {
        if (!Auth::check()) abort(403);

        // Hanya UMKM pemilik atau programmer terkait yang bisa chat
        $user = Auth::user();
        $isUmkm = $user->role === 'umkm' && $project->umkm_id === $user->id;
        $isProgrammerBidder = $user->role === 'programmer' &&
            $project->bids()->where('programmer_id', $user->id)->exists();

        if (!$isUmkm && !$isProgrammerBidder && $user->role !== 'admin') {
            abort(403);
        }

        $request->validate(['message' => 'required|string|max:2000']);

        // Tentukan receiver
        if ($isUmkm) {
            // UMKM kirim ke programmer yang bid pertama / yang dipilih
            $receiverId = $request->receiver_id ?? $project->bids()->first()?->programmer_id;
        } else {
            // Programmer kirim ke UMKM
            $receiverId = $project->umkm_id;
        }

        if (!$receiverId) {
            return response()->json(['error' => 'Penerima pesan tidak ditemukan'], 422);
        }

        $msg = Message::create([
            'project_id'  => $project->id,
            'sender_id'   => $user->id,
            'receiver_id' => $receiverId,
            'message'     => $request->message,
        ]);

        return response()->json([
            'ok'         => true,
            'id'         => $msg->id,
            'sender'     => $user->name,
            'message'    => $msg->message,
            'created_at' => $msg->created_at->format('H:i'),
            'is_me'      => true,
        ]);
    }

    /**
     * Ambil pesan-pesan dalam sebuah project (JSON untuk AJAX polling)
     */
    public function getMessages(Project $project)
    {
        if (!Auth::check()) abort(403);

        $user = Auth::user();
        $messages = Message::where('project_id', $project->id)
            ->with('sender')
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'sender'     => $m->sender->name,
                'message'    => $m->message,
                'created_at' => $m->created_at->format('H:i, d M'),
                'is_me'      => $m->sender_id === $user->id,
            ]);

        // Mark as read
        Message::where('project_id', $project->id)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }
}
