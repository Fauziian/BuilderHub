@extends('layouts.app')
@section('title', 'Semua Project — Admin')
@section('content')
<div style="background:var(--dark2);color:#fff;padding:1.5rem 2rem">
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center">
    <div><h1 style="font-size:1.1rem;font-weight:800;color:#fff">📋 Manajemen Project</h1><div style="font-size:.82rem;color:rgba(255,255,255,.6)">Total: {{ $projects->total() }} project</div></div>
    <a href="{{ route('admin.dashboard') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">← Dashboard</a>
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
