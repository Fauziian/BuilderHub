@extends('layouts.app')
@section('title', 'Semua Course — Admin')
@section('content')
<div style="background:var(--dark2);color:#fff;padding:1.5rem 2rem">
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center">
    <div><h1 style="font-size:1.1rem;font-weight:800;color:#fff">📚 Manajemen Course</h1></div>
    <a href="{{ route('admin.dashboard') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">← Dashboard</a>
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
