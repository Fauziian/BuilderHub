@extends('layouts.app')
@section('title', 'Semua Project — Admin')
@section('content')
@php
  $pendingProjectsCount = \App\Models\Project::where('status', 'pending')->count();
  $pendingCoursesCount = \App\Models\Course::where('is_published', false)->count();
@endphp
<div style="background:linear-gradient(135deg, #0A0A14 0%, #150E36 50%, #080515 100%);color:#fff;padding:1.5rem 2rem;border-bottom:2px solid rgba(129, 140, 248, 0.25);box-shadow:0 10px 30px rgba(0,0,0,0.3)">
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
    <div>
      <h1 style="font-size:1.25rem;font-weight:800;color:#fff;display:flex;align-items:center;gap:8px">📋 Manajemen Project</h1>
      <p style="font-size:.82rem;color:rgba(255,255,255,.6)">Total: {{ $projects->total() }} project</p>
    </div>
    <div style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap">
      <a href="{{ route('admin.dashboard') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">📊 Dashboard</a>
      <a href="{{ route('admin.users') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">👥 Users</a>
      <a href="{{ route('admin.projects', $pendingProjectsCount > 0 ? ['status' => 'pending'] : []) }}" class="btn" style="background:var(--primary);color:#fff;border-color:var(--primary);font-size:.82rem;display:inline-flex;align-items:center;gap:6px">
        📋 Projects
        @if($pendingProjectsCount > 0)
          <span style="background:#EF4444;color:#fff;font-size:0.72rem;font-weight:800;padding:2px 7px;border-radius:10px;line-height:1;box-shadow:0 2px 5px rgba(239,68,68,0.4)">
            {{ $pendingProjectsCount }}
          </span>
        @endif
      </a>
      <a href="{{ route('admin.courses') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem;display:inline-flex;align-items:center;gap:6px">
        📚 Courses
        @if($pendingCoursesCount > 0)
          <span style="background:#EF4444;color:#fff;font-size:0.72rem;font-weight:800;padding:2px 7px;border-radius:10px;line-height:1;box-shadow:0 2px 5px rgba(239,68,68,0.4)">
            {{ $pendingCoursesCount }}
          </span>
        @endif
      </a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="btn" style="background:var(--red);color:#fff;border-color:var(--red);font-size:.82rem" aria-label="Keluar dari akun">Keluar 🚪</button>
      </form>
    </div>
  </div>
</div>
<div class="dash-layout">
  <form method="GET" style="display:flex;gap:.75rem;margin-bottom:1.5rem;flex-wrap:wrap;align-items:center" role="search">
    <div style="position:relative;flex:1;max-width:380px">
      <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--text3);font-size:0.95rem">🔍</span>
      <input name="search" class="form-input" style="padding-left:42px;height:46px;border-radius:12px;border:2px solid var(--border)" placeholder="Cari judul project, deskripsi, atau UMKM..." value="{{ request('search') }}" aria-label="Cari project">
    </div>
    <select name="status" class="form-select" style="width:auto;height:46px;border-radius:12px;border:2px solid var(--border);font-weight:600" aria-label="Filter status">
      <option value="">Semua Status</option>
      <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (Menunggu ACC)</option>
      <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Dibuka (Open)</option>
      <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Dikerjakan (In Progress)</option>
      <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
      <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
    </select>
    <button type="submit" class="btn btn-primary" style="height:46px;padding:0 24px;border-radius:12px">Cari & Filter</button>
    @if(request()->hasAny(['search','status']))
      <a href="{{ route('admin.projects') }}" class="btn btn-ghost" style="height:46px;padding:0 20px;border-radius:12px;display:inline-flex;align-items:center">Reset 🔄</a>
    @endif
  </form>

  <div class="card">
    <div class="table-wrap">
      <table class="data-table">
        <thead><tr><th>Judul</th><th>UMKM</th><th>Budget</th><th>Programmer</th><th>Penawaran</th><th>Status</th><th>Deadline</th><th>Aksi</th></tr></thead>
        <tbody>
          @forelse($projects as $p)
          <tr>
            <td><strong style="font-size:.875rem">{{ Str::limit($p->title, 30) }}</strong><div class="tag-list" style="margin-top:.25rem">@foreach(array_slice($p->tags ?? [], 0, 2) as $t)<span class="tag">{{ $t }}</span>@endforeach</div></td>
            <td style="font-size:.82rem">{{ $p->umkm->business_name ?? $p->umkm->name }}<div style="font-size:.75rem;color:var(--text3)">{{ $p->umkm->email }}</div></td>
            <td style="font-weight:700">{{ $p->budget > 0 ? 'Rp ' . number_format($p->budget/1000000, 1) . 'M' : 'Menunggu Estimasi' }}</td>
            <td style="font-size:.82rem;color:var(--text3)">{{ $p->programmer?->name ?? '—' }}</td>
            <td style="text-align:center">{{ $p->bids->count() }}</td>
            <td>
              @if($p->status === 'pending')
                <span class="badge" style="background:var(--orange-light);color:#92400E;font-size:.7rem;font-weight:700">PENDING</span>
              @else
                <span class="badge badge-{{ $p->status === 'open' ? 'open' : ($p->status === 'in_progress' ? 'running' : 'done') }}">{{ $p->status_label }}</span>
              @endif
            </td>
            <td style="font-size:.82rem;color:var(--text3)">{{ $p->deadline->format('d M Y') }}</td>
            <td>
              <div style="display:flex;gap:.35rem;align-items:center">
                @if($p->status === 'pending')
                  <form method="POST" action="{{ route('admin.approve-project', $p) }}" onsubmit="return confirm('Apakah Anda yakin menyetujui (ACC) project ini untuk dipublikasikan?')">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary" style="background:var(--green);border-color:var(--green);color:#fff;font-weight:600;padding:5px 10px;border-radius:6px;font-size:0.75rem;white-space:nowrap">
                      ACC & Publikasikan ✅
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.delete-project', $p) }}" onsubmit="return confirm('Tolak/Hapus pengajuan project ini?')" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--red);border-color:var(--red);background:var(--red-light);padding:5px 10px;border-radius:6px;font-size:0.75rem" aria-label="Tolak project">
                      Tolak 🗑
                    </button>
                  </form>
                @else
                  <form method="POST" action="{{ route('admin.delete-project', $p) }}" onsubmit="return confirm('Hapus project ini secara permanen?')" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--red);padding:5px 10px;border-radius:6px;font-size:0.75rem" aria-label="Hapus project">
                      Hapus 🗑
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="8" style="text-align:center;color:var(--text3);padding:2rem">Belum ada project.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div style="margin-top:1rem">{{ $projects->links() }}</div>
  </div>
</div>
@endsection
