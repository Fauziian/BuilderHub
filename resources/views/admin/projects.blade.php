@extends('layouts.app')
@section('title', 'Semua Project — Admin')
@section('content')
@php
  $pendingProjectsCount = \App\Models\Project::where('status', 'pending')->count();
  $pendingCoursesCount = \App\Models\Course::where('is_published', false)->count();
@endphp
<div style="background:var(--dark2);color:#fff;padding:1.5rem 2rem;border-bottom:1px solid rgba(255,255,255,.1)">
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
    <div>
      <h1 style="font-size:1.25rem;font-weight:800;color:#fff;display:flex;align-items:center;gap:8px">📋 Manajemen Project</h1>
      <p style="font-size:.82rem;color:rgba(255,255,255,.6)">Total: {{ $projects->total() }} project</p>
    </div>
    <div style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap">
      <a href="{{ route('admin.dashboard') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">📊 Dashboard</a>
      <a href="{{ route('admin.users') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">👥 Users</a>
      <a href="{{ route('admin.projects') }}" class="btn" style="background:var(--primary);color:#fff;border-color:var(--primary);font-size:.82rem;display:inline-flex;align-items:center;gap:6px">
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
            <td><span class="badge badge-{{ $p->status === 'open' ? 'open' : ($p->status === 'in_progress' ? 'running' : 'done') }}">{{ $p->status_label }}</span></td>
            <td style="font-size:.82rem;color:var(--text3)">{{ $p->deadline->format('d M Y') }}</td>
            <td>
              <form method="POST" action="{{ route('admin.delete-project', $p) }}" onsubmit="return confirm('Hapus project ini secara permanen?')" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--red)" aria-label="Hapus project">
                  🗑 Hapus
                </button>
              </form>
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
