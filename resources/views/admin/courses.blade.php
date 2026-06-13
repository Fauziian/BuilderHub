@extends('layouts.app')
@section('title', 'Semua Course — Admin')
@section('content')
@php
  $pendingProjectsCount = \App\Models\Project::where('status', 'pending')->count();
  $pendingCoursesCount = \App\Models\Course::where('is_published', false)->count();
@endphp
<div style="background:var(--dark2);color:#fff;padding:1.5rem 2rem;border-bottom:1px solid rgba(255,255,255,.1)">
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
    <div>
      <h1 style="font-size:1.25rem;font-weight:800;color:#fff;display:flex;align-items:center;gap:8px">📚 Manajemen Course</h1>
      <p style="font-size:.82rem;color:rgba(255,255,255,.6)">Total: {{ $courses->total() }} course</p>
    </div>
    <div style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap">
      <a href="{{ route('admin.dashboard') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">📊 Dashboard</a>
      <a href="{{ route('admin.users') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">👥 Users</a>
      <a href="{{ route('admin.projects') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem;display:inline-flex;align-items:center;gap:6px">
        📋 Projects
        @if($pendingProjectsCount > 0)
          <span style="background:#EF4444;color:#fff;font-size:0.72rem;font-weight:800;padding:2px 7px;border-radius:10px;line-height:1;box-shadow:0 2px 5px rgba(239,68,68,0.4)">
            {{ $pendingProjectsCount }}
          </span>
        @endif
      </a>
      <a href="{{ route('admin.courses') }}" class="btn" style="background:var(--primary);color:#fff;border-color:var(--primary);font-size:.82rem;display:inline-flex;align-items:center;gap:6px">
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
        <thead><tr><th>Judul</th><th>Instruktur</th><th>Level</th><th>Harga</th><th>Siswa</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          @forelse($courses as $c)
          <tr>
            <td><strong style="font-size:.875rem">{{ Str::limit($c->title,30) }}</strong><div style="font-size:.75rem;color:var(--text3)">{{ $c->total_videos }} video · {{ $c->duration }}</div></td>
            <td style="font-size:.82rem">{{ $c->instructor->name }}</td>
            <td><span class="level-badge level-{{ $c->level }}" style="position:static;font-size:.7rem;font-weight:700;padding:2px 8px;border-radius:99px">{{ $c->level_label }}</span></td>
            <td style="font-weight:600;color:{{ $c->is_free ? 'var(--green)' : 'var(--text)' }}">{{ $c->price_formatted }}</td>
            <td>{{ number_format($c->enrollments->count()) }}</td>
            <td><span class="badge {{ $c->is_published ? 'badge-done' : 'badge-cancelled' }}">{{ $c->is_published ? 'Publik' : 'Draft' }}</span></td>
            <td>
              <div style="display:flex;gap:.25rem;align-items:center">
                <form method="POST" action="{{ route('admin.publish-course', $c) }}" style="display:inline">
                  @csrf
                  <button type="submit" class="btn btn-sm {{ $c->is_published ? 'btn-ghost' : 'btn-success' }}" aria-label="{{ $c->is_published ? 'Sembunyikan' : 'Publish' }} course">
                    {{ $c->is_published ? 'Sembunyikan' : '✅ Publish' }}
                  </button>
                </form>
                <form method="POST" action="{{ route('admin.delete-course', $c) }}" onsubmit="return confirm('Hapus course ini secara permanen?')" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--red)" aria-label="Hapus course">
                    🗑 Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" style="text-align:center;color:var(--text3);padding:2rem">Belum ada course.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div style="margin-top:1rem">{{ $courses->links() }}</div>
  </div>
</div>
@endsection
