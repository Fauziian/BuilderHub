@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<div style="background:var(--dark2);color:#fff;padding:1.5rem 2rem;border-bottom:1px solid rgba(255,255,255,.1)">
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center">
    <div>
      <h1 style="font-size:1.25rem;font-weight:800;color:#fff">⚙️ Admin BuilderHub</h1>
      <p style="font-size:.82rem;color:rgba(255,255,255,.6)">Panel Administrasi Platform</p>
    </div>
    <div style="display:flex;gap:.5rem;align-items:center">
      <a href="{{ route('admin.users') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">👥 Users</a>
      <a href="{{ route('admin.projects') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">📋 Projects</a>
      <a href="{{ route('admin.courses') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">📚 Courses</a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="btn" style="background:var(--red);color:#fff;border-color:var(--red);font-size:.82rem" aria-label="Keluar dari akun">Keluar 🚪</button>
      </form>
    </div>
  </div>
</div>

<div class="dash-layout">
  <!-- STATS -->
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem">
    @foreach([
      ['👥', $stats['total_users'], 'Total Users', null],
      ['📋', $stats['total_projects'], 'Total Project', null],
      ['📚', $stats['total_courses'], 'Total Course', null],
      ['💰', 'Rp '.number_format($stats['total_revenue']/1000000,1).'M', 'Revenue Platform', null],
    ] as [$icon, $val, $label, $_])
    <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:var(--radius-lg);padding:1.25rem;background:var(--bg);border-color:var(--border)">
      <div style="font-size:1.25rem;margin-bottom:.5rem">{{ $icon }}</div>
      <div style="font-size:1.6rem;font-weight:800">{{ $val }}</div>
      <div style="font-size:.8rem;color:var(--text3)">{{ $label }}</div>
    </div>
    @endforeach
  </div>

  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem">
    @foreach([['🧑‍💻', $stats['programmers'], 'Programmer', 'var(--primary)'],['🏢', $stats['umkms'], 'UMKM', 'var(--accent)'],['⏰', $stats['open_projects'], 'Project Open', 'var(--orange)'],['✅', $stats['completed_projects'], 'Project Selesai', 'var(--green)']] as [$ic,$v,$l,$c])
    <div class="card" style="border-left:4px solid {{ $c }}">
      <div style="font-size:1.5rem;font-weight:800;color:{{ $c }}">{{ $v }}</div>
      <div style="font-size:.82rem;color:var(--text3)">{{ $ic }} {{ $l }}</div>
    </div>
    @endforeach
  </div>

  <!-- PENDING PROJECTS (ACC ACTION) -->
  <div class="card" style="margin-bottom:1.5rem;border-left:4px solid var(--orange)">
    <div class="card-header" style="border-bottom:1px solid var(--border);padding-bottom:.75rem;margin-bottom:.75rem">
      <span class="card-title" style="color:var(--orange)">⏳ Persetujuan Project UMKM Baru (ACC)</span>
      <span style="font-size:.78rem;font-weight:600;background:var(--orange-light);color:#92400E;padding:3px 10px;border-radius:99px">
        {{ $pendingProjects->count() }} Menunggu Persetujuan
      </span>
    </div>
    <div style="display:flex;flex-direction:column;gap:.75rem">
      @forelse($pendingProjects as $p)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:.85rem;background:var(--bg2);border-radius:var(--radius);border:1px solid var(--border)">
        <div style="flex:1;padding-right:1.5rem">
          <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.25rem">
            <strong style="font-size:.92rem;color:var(--text)">{{ $p->title }}</strong>
            <span class="badge" style="background:var(--orange-light);color:#92400E;font-size:.7rem">Pending</span>
          </div>
          <p style="font-size:.82rem;color:var(--text2);margin-bottom:.5rem;line-height:1.5">{{ Str::limit($p->description, 150) }}</p>
          <div style="font-size:.75rem;color:var(--text3);display:flex;gap:1rem;flex-wrap:wrap">
            <span>🏢 UMKM: <strong>{{ $p->umkm->business_name ?? $p->umkm->name }}</strong></span>
            <span>💰 Budget: <strong>{{ $p->budget > 0 ? 'Rp ' . number_format($p->budget, 0, ',', '.') : 'Menunggu Estimasi' }}</strong></span>
            <span>Platform Fee (80%): <strong>{{ $p->budget > 0 ? 'Rp ' . number_format($p->budget * 0.80, 0, ',', '.') : '—' }}</strong></span>
            <span>Prog. Earning (20%): <strong>{{ $p->budget > 0 ? 'Rp ' . number_format($p->budget * 0.20, 0, ',', '.') : '—' }}</strong></span>
          </div>
        </div>
        <div style="flex-shrink:0;display:flex;gap:.5rem;align-items:center">
          <form method="POST" action="{{ route('admin.approve-project', $p) }}" onsubmit="return confirm('Apakah Anda yakin menyetujui (ACC) project ini untuk dipublikasikan ke Programmer?')">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm" style="background:var(--green);border-color:var(--green);font-weight:600">ACC & Publikasikan ✅</button>
          </form>
          <form method="POST" action="{{ route('admin.delete-project', $p) }}" onsubmit="return confirm('Hapus/Tolak pengajuan project ini secara permanen?')" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--red);border-color:var(--red);background:var(--red-light);padding:6px 12px" aria-label="Tolak dan Hapus project">
              🗑 Tolak
            </button>
          </form>
        </div>
      </div>
      @empty
      <div style="text-align:center;padding:1.5rem;color:var(--text3);font-size:.875rem">
        Tidak ada project baru yang menunggu persetujuan (ACC).
      </div>
      @endforelse
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.5rem">
    <!-- Pending Programmer Verifications -->
    <div class="card">
      <div class="card-header">
        <span class="card-title">✅ Verifikasi Programmer Pending ({{ $stats['pending_verifications'] }})</span>
      </div>
      @forelse($pendingProgrammers as $prog)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:.6rem 0;border-bottom:1px solid var(--border)">
        <div style="display:flex;align-items:center;gap.5rem">
          <div style="width:32px;height:32px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.8rem;margin-right:.5rem">{{ strtoupper(substr($prog->name,0,1)) }}</div>
          <div>
            <div style="font-size:.875rem;font-weight:600">{{ $prog->name }}</div>
            <div style="font-size:.75rem;color:var(--text3)">{{ $prog->certificates()->count() }} sert · {{ $prog->portfolios()->count() }} porto</div>
          </div>
        </div>
        <form method="POST" action="{{ route('admin.verify-programmer', $prog) }}">
          @csrf
          <button type="submit" class="btn btn-success btn-sm" aria-label="Verifikasi programmer {{ $prog->name }}">Verifikasi</button>
        </form>
      </div>
      @empty
      <p style="color:var(--text3);font-size:.875rem">Tidak ada pending verifikasi. 🎉</p>
      @endforelse
    </div>

    <!-- Pending UMKM Verifications -->
    <div class="card">
      <div class="card-header">
        <span class="card-title">🏢 Verifikasi UMKM Pending ({{ $stats['umkm_pending'] }})</span>
      </div>
      @forelse($pendingUmkms as $umkm)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:.6rem 0;border-bottom:1px solid var(--border)">
        <div style="display:flex;align-items:center;gap.5rem">
          <div style="width:32px;height:32px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.8rem;margin-right:.5rem">{{ strtoupper(substr($umkm->name,0,1)) }}</div>
          <div>
            <div style="font-size:.875rem;font-weight:600">{{ $umkm->business_name ?? $umkm->name }}</div>
            <div style="font-size:.75rem;color:var(--text3)">{{ $umkm->city }}</div>
          </div>
        </div>
        <form method="POST" action="{{ route('admin.verify-umkm', $umkm) }}">
          @csrf
          <button type="submit" class="btn btn-success btn-sm" aria-label="Verifikasi UMKM {{ $umkm->name }}">Verifikasi</button>
        </form>
      </div>
      @empty
      <p style="color:var(--text3);font-size:.875rem">Tidak ada pending verifikasi. 🎉</p>
      @endforelse
    </div>
  </div>

  <!-- Recent Users -->
  <div class="card" style="margin-bottom:1.25rem">
    <div class="card-header"><span class="card-title">👥 User Terbaru</span><a href="{{ route('admin.users') }}" class="btn btn-ghost btn-sm">Lihat Semua</a></div>
    <div class="table-wrap">
      <table class="data-table">
        <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Bergabung</th><th>Status</th></tr></thead>
        <tbody>
          @foreach($recentUsers as $u)
          <tr>
            <td><strong>{{ $u->name }}</strong></td>
            <td style="color:var(--text3)">{{ $u->email }}</td>
            <td><span class="badge" style="background:{{ $u->role === 'admin' ? 'var(--red-light)' : ($u->role === 'programmer' ? 'var(--primary-light)' : ($u->role === 'umkm' ? 'var(--accent-light)' : 'var(--green-light)')) }};color:{{ $u->role === 'admin' ? 'var(--red)' : ($u->role === 'programmer' ? 'var(--primary)' : ($u->role === 'umkm' ? 'var(--accent)' : 'var(--green)')) }}">{{ ucfirst($u->role) }}</span></td>
            <td style="font-size:.82rem;color:var(--text3)">{{ $u->created_at->format('d M Y') }}</td>
            <td>
              @if($u->role === 'programmer' && $u->is_verified)<span style="color:var(--green);font-size:.8rem">✅ Verified</span>
              @elseif($u->role === 'umkm' && $u->umkm_verified)<span style="color:var(--green);font-size:.8rem">✅ Verified</span>
              @else<span style="color:var(--text3);font-size:.8rem">○ Pending</span>@endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Recent Projects -->
  <div class="card">
    <div class="card-header"><span class="card-title">📋 Project Terbaru</span><a href="{{ route('admin.projects') }}" class="btn btn-ghost btn-sm">Lihat Semua</a></div>
    <div class="table-wrap">
      <table class="data-table">
        <thead><tr><th>Judul</th><th>UMKM</th><th>Budget</th><th>Status</th><th>Dibuat</th></tr></thead>
        <tbody>
          @foreach($recentProjects as $p)
          <tr>
            <td><strong>{{ Str::limit($p->title, 35) }}</strong></td>
            <td style="font-size:.82rem;color:var(--text3)">{{ $p->umkm->business_name ?? $p->umkm->name }}</td>
            <td>Rp {{ number_format($p->budget/1000000,1) }}M</td>
            <td><span class="badge badge-{{ $p->status === 'open' ? 'open' : ($p->status === 'in_progress' ? 'running' : 'done') }}">{{ $p->status_label }}</span></td>
            <td style="font-size:.82rem;color:var(--text3)">{{ $p->created_at->format('d M Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
