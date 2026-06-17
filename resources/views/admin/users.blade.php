@extends('layouts.app')
@section('title', 'Kelola Users — Admin')
@section('content')
@php
  $pendingProjectsCount = \App\Models\Project::where('status', 'pending')->count();
  $pendingCoursesCount = \App\Models\Course::where('is_published', false)->count();
@endphp
<div style="background:linear-gradient(135deg, #0A0A14 0%, #150E36 50%, #080515 100%);color:#fff;padding:1.5rem 2rem;border-bottom:2px solid rgba(129, 140, 248, 0.25);box-shadow:0 10px 30px rgba(0,0,0,0.3)">
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
    <div>
      <h1 style="font-size:1.25rem;font-weight:800;color:#fff;display:flex;align-items:center;gap:8px">👥 Manajemen Users</h1>
      <p style="font-size:.82rem;color:rgba(255,255,255,.6)">Total: {{ $users->total() }} pengguna</p>
    </div>
    <div style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap">
      <a href="{{ route('admin.dashboard') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">📊 Dashboard</a>
      <a href="{{ route('admin.users') }}" class="btn" style="background:var(--primary);color:#fff;border-color:var(--primary);font-size:.82rem">👥 Users</a>
      <a href="{{ route('admin.projects') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem;display:inline-flex;align-items:center;gap:6px">
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
  <form method="GET" style="display:flex;gap:.75rem;margin-bottom:1.5rem;flex-wrap:wrap" role="search">
    <div style="position:relative;flex:1;max-width:350px">
      <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text3)">🔍</span>
      <input name="search" class="form-input" style="padding-left:38px" placeholder="Cari nama atau email..." value="{{ request('search') }}" aria-label="Cari pengguna">
    </div>
    <select name="role" class="form-select" style="width:auto" aria-label="Filter role">
      <option value="">Semua Role</option>
      @foreach(['admin','programmer','umkm','course'] as $r)
      <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
    @if(request()->hasAny(['search','role']))<a href="{{ route('admin.users') }}" class="btn btn-ghost">Reset</a>@endif
  </form>

  <div class="card">
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>Pengguna</th><th>Email</th><th>Role</th><th>Kota</th><th>Status</th><th>Bergabung</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
          <tr>
            <td>
              <div style="display:flex;align-items:center;gap.5rem">
                <div style="width:32px;height:32px;border-radius:50%;background:{{ $u->role === 'admin' ? 'var(--red)' : ($u->role === 'umkm' ? 'var(--accent)' : 'var(--primary)') }};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.8rem;margin-right:.5rem;flex-shrink:0">{{ strtoupper(substr($u->name,0,1)) }}</div>
                <div>
                  <strong style="font-size:.875rem">{{ $u->name }}</strong>
                  @if($u->business_name)<div style="font-size:.75rem;color:var(--text3)">{{ $u->business_name }}</div>@endif
                  
                  @if($u->role === 'programmer')
                  <div style="margin-top:.25rem;font-size:.75rem">
                    <span style="color:var(--primary)">🗂 {{ $u->portfolios->count() }} Porto</span> · 
                    <span style="color:var(--green)">📜 {{ $u->certificates->count() }} Sert</span>
                  </div>
                  @if($u->portfolios->count() || $u->certificates->count())
                  <div style="margin-top:.25rem;max-width:300px;font-size:.72rem;color:var(--text3)">
                    @if($u->portfolios->count())
                    <div style="margin-bottom:2px"><strong>Porto:</strong> {{ implode(', ', $u->portfolios->pluck('title')->toArray()) }}</div>
                    @endif
                    @if($u->certificates->count())
                    <div><strong>Sert:</strong> {{ implode(', ', $u->certificates->pluck('name')->toArray()) }}</div>
                    @endif
                  </div>
                  @endif
                  @endif
                </div>
              </div>
            </td>
            <td style="font-size:.82rem;color:var(--text3)">{{ $u->email }}</td>
            <td>
              <span class="badge" style="background:{{ $u->role === 'admin' ? 'var(--red-light)' : ($u->role === 'programmer' ? 'var(--primary-light)' : ($u->role === 'umkm' ? 'var(--accent-light)' : 'var(--green-light)')) }};color:{{ $u->role === 'admin' ? 'var(--red)' : ($u->role === 'programmer' ? 'var(--primary)' : ($u->role === 'umkm' ? 'var(--accent)' : 'var(--green)')) }}">{{ ucfirst($u->role) }}</span>
            </td>
            <td style="font-size:.82rem;color:var(--text3)">{{ $u->city ?? '-' }}</td>
            <td>
              @if($u->role === 'programmer')
                @if($u->is_verified)<span style="color:var(--green);font-size:.8rem">✅ Verified</span>
                @else<span style="color:var(--text3);font-size:.8rem">○ Belum</span>@endif
              @elseif($u->role === 'umkm')
                @if($u->umkm_verified)<span style="color:var(--green);font-size:.8rem">✅ Verified</span>
                @else<span style="color:var(--text3);font-size:.8rem">○ Belum</span>@endif
              @else<span style="color:var(--text3);font-size:.8rem">—</span>@endif
            </td>
            <td style="font-size:.82rem;color:var(--text3)">{{ $u->created_at->format('d M Y') }}</td>
            <td>
              <div style="display:flex;gap:.25rem;flex-wrap:wrap">
                @if($u->role === 'programmer' && !$u->is_verified)
                <form method="POST" action="{{ route('admin.verify-programmer', $u) }}">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm" aria-label="Verifikasi programmer {{ $u->name }}">✅ Verif</button>
                </form>
                @endif
                @if($u->role === 'umkm' && !$u->umkm_verified)
                <form method="POST" action="{{ route('admin.verify-umkm', $u) }}">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm" aria-label="Verifikasi UMKM {{ $u->name }}">✅ Verif</button>
                </form>
                @endif
                @if($u->id !== auth()->id())
                <form method="POST" action="{{ route('admin.delete-user', $u) }}" onsubmit="return confirm('Hapus user {{ $u->name }}? Semua data terkait akan terhapus.')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" aria-label="Hapus user {{ $u->name }}">🗑</button>
                </form>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" style="text-align:center;color:var(--text3);padding:2rem">Tidak ada pengguna ditemukan.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div style="margin-top:1rem">{{ $users->links() }}</div>
  </div>
</div>
@endsection
