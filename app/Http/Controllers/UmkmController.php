<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Message;
use App\Models\Project;
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

        return view('umkm.dashboard', compact('user', 'projects', 'totalBudget', 'programmers', 'givenReviews'));
    }

    public function storeProject(Request $request)
    {
        $this->checkAccess();
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
        $project->delete();
        return back()->with('success', 'Project berhasil dihapus.');
    }

    public function acceptBid(Bid $bid)
    {
        $this->checkAccess();
        $project = $bid->project;
        if ($project->umkm_id !== Auth::id()) {
            abort(403);
        }

        // Tolak semua bid lain
        Bid::where('project_id', $project->id)->where('id', '!=', $bid->id)->update(['status' => 'rejected']);
        $bid->update(['status' => 'accepted']);

        // Set budget project = harga yang diajukan programmer (bid amount)
        $project->update([
            'status'                  => 'in_progress',
            'assigned_programmer_id'  => $bid->programmer_id,
            'budget'                  => $bid->amount,
            'platform_fee'            => $bid->amount * 0.80,
            'programmer_earning'      => $bid->amount * 0.20,
        ]);

        return back()->with('success', "✅ Penawaran Rp " . number_format($bid->amount, 0, ',', '.') . " dari {$bid->programmer->name} diterima! Project sekarang berstatus Berjalan.");
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
            return back()->with('success', "Penawaran dari {$bid->programmer->name} ditolak secara permanen (Ditolak!).");
        } else {
            $bid->update(['status' => 'pending']);
            return back()->with('success', "Penawaran dari {$bid->programmer->name} ditolak. Programmer dapat mengajukan penawaran kembali.");
        }
    }

    public function completeProject(Project $project)
    {
        $this->checkAccess();
        if ($project->umkm_id !== Auth::id()) {
            abort(403);
        }

        $project->update(['status' => 'completed']);

        if ($project->assigned_programmer_id) {
            $programmer = $project->programmer;
            $programmer->increment('total_earnings', $project->budget * 0.20);
            $programmer->increment('total_projects');
        }

        return back()->with('success', '✅ Project selesai! Pembayaran akan segera diproses.');
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
