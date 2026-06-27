@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
@php
  $pendingProjectsCount = \App\Models\Project::where('status', 'pending')->count();
  $pendingCoursesCount = \App\Models\Course::where('is_published', false)->count();
@endphp
<div style="background:linear-gradient(135deg, #0A0A14 0%, #150E36 50%, #080515 100%);color:#fff;padding:1.5rem 2rem;border-bottom:2px solid rgba(129, 140, 248, 0.25);box-shadow:0 10px 30px rgba(0,0,0,0.3)">
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
    <div>
      <h1 style="font-size:1.25rem;font-weight:800;color:#fff;display:flex;align-items:center;gap:8px">⚙️ Admin BuilderHub</h1>
      <p style="font-size:.82rem;color:rgba(255,255,255,.6)">Panel Administrasi Platform</p>
    </div>
    <div style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap">
      <a href="{{ route('admin.dashboard') }}" id="admin-nav-dashboard" class="btn" style="background:{{ request()->routeIs('admin.dashboard') ? 'var(--primary)' : 'rgba(255,255,255,.1)' }};color:#fff;border-color:{{ request()->routeIs('admin.dashboard') ? 'var(--primary)' : 'rgba(255,255,255,.2)' }};font-size:.82rem">📊 Dashboard</a>
      <a href="{{ route('admin.users') }}" id="admin-nav-users" class="btn" style="background:{{ request()->routeIs('admin.users') ? 'rgba(255,255,255,.1)' : 'rgba(255,255,255,.1)' }};color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem">👥 Users</a>
      <a href="{{ route('admin.projects') }}" id="admin-nav-projects" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem;display:inline-flex;align-items:center;gap:6px">
        📋 Projects
        @if($pendingProjectsCount > 0)
          <span style="background:#EF4444;color:#fff;font-size:0.72rem;font-weight:800;padding:2px 7px;border-radius:10px;line-height:1;box-shadow:0 2px 5px rgba(239,68,68,0.4)">
            {{ $pendingProjectsCount }}
          </span>
        @endif
      </a>
      <a href="{{ route('admin.courses') }}" id="admin-nav-courses" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.2);font-size:.82rem;display:inline-flex;align-items:center;gap:6px">
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
  <!-- STATS -->
  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:1rem;margin-bottom:1.5rem">
    <div class="stat-card glass-card" style="padding: 1.25rem;">
      <div style="margin-bottom:.5rem; background:rgba(79,70,229,0.1); width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center;">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 34px; height: 34px; filter: drop-shadow(0 4px 6px rgba(79, 70, 229, 0.35));">
          <defs>
            <linearGradient id="user-grad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#818CF8" />
              <stop offset="100%" stop-color="#4F46E5" />
            </linearGradient>
          </defs>
          <circle cx="32" cy="22" r="10" fill="url(#user-grad)" />
          <path d="M 12 50 C 12 40 20 38 32 38 C 44 38 52 40 52 50 Z" fill="url(#user-grad)" />
        </svg>
      </div>
      <div style="font-size:1.6rem;font-weight:800">{{ $stats['total_users'] }}</div>
      <div style="font-size:.8rem;color:var(--text3)">Total Users</div>
    </div>

    <div class="stat-card glass-card" style="padding: 1.25rem;">
      <div style="margin-bottom:.5rem; background:rgba(79,70,229,0.1); width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center;">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 34px; height: 34px; filter: drop-shadow(0 4px 6px rgba(79, 70, 229, 0.35));">
          <defs>
            <linearGradient id="board-grad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#818CF8" />
              <stop offset="100%" stop-color="#4F46E5" />
            </linearGradient>
          </defs>
          <rect x="14" y="10" width="36" height="46" rx="4" fill="url(#board-grad)" />
          <rect x="18" y="16" width="28" height="36" fill="#FFF" rx="2" />
          <rect x="26" y="6" width="12" height="6" fill="#4B5563" rx="1.5" />
          <line x1="22" y1="22" x2="34" y2="22" stroke="#4F46E5" stroke-width="2.5" stroke-linecap="round" />
          <line x1="22" y1="28" x2="42" y2="28" stroke="#E2E8F0" stroke-width="2.5" stroke-linecap="round" />
          <line x1="22" y1="34" x2="38" y2="34" stroke="#E2E8F0" stroke-width="2.5" stroke-linecap="round" />
        </svg>
      </div>
      <div style="font-size:1.6rem;font-weight:800">{{ $stats['total_projects'] }}</div>
      <div style="font-size:.8rem;color:var(--text3)">Total Project</div>
    </div>

    <div class="stat-card glass-card" style="padding: 1.25rem;">
      <div style="margin-bottom:.5rem; background:rgba(79,70,229,0.1); width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center;">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 34px; height: 34px; filter: drop-shadow(0 4px 6px rgba(99, 102, 241, 0.35));">
          <defs>
            <linearGradient id="book1-grad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#818CF8" />
              <stop offset="100%" stop-color="#4F46E5" />
            </linearGradient>
            <linearGradient id="book2-grad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#F472B6" />
              <stop offset="100%" stop-color="#DB2777" />
            </linearGradient>
          </defs>
          <path d="M 12 36 L 46 36 L 52 42 L 18 42 Z" fill="#E2E8F0" />
          <path d="M 10 32 C 10 30 12 30 18 30 L 48 30 L 48 38 L 18 38 C 12 38 10 36 10 32 Z" fill="url(#book2-grad)" />
          <rect x="44" y="32" width="4" height="6" fill="#FCE7F3" />
          <path d="M 18 20 L 52 20 L 58 26 L 24 26 Z" fill="#FFF" />
          <path d="M 16 16 C 16 14 18 14 24 14 L 54 14 L 54 22 L 24 22 C 18 22 16 20 16 16 Z" fill="url(#book1-grad)" />
          <rect x="50" y="16" width="4" height="6" fill="#EEF2FF" />
        </svg>
      </div>
      <div style="font-size:1.6rem;font-weight:800">{{ $stats['total_courses'] }}</div>
      <div style="font-size:.8rem;color:var(--text3)">Total Course</div>
    </div>

    <div class="stat-card glass-card" style="padding: 1.25rem;">
      <div style="margin-bottom:.5rem; background:rgba(245,158,11,0.1); width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center;">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 34px; height: 34px; filter: drop-shadow(0 4px 6px rgba(245, 158, 11, 0.35));">
          <defs>
            <linearGradient id="coin-grad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#FCD34D" />
              <stop offset="100%" stop-color="#D97706" />
            </linearGradient>
            <linearGradient id="coin-edge" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#FBBF24" />
              <stop offset="100%" stop-color="#B45309" />
            </linearGradient>
          </defs>
          <ellipse cx="32" cy="36" rx="20" ry="12" fill="url(#coin-edge)" />
          <ellipse cx="32" cy="32" rx="20" ry="12" fill="url(#coin-grad)" />
          <ellipse cx="32" cy="32" rx="14" ry="8" fill="none" stroke="#FFF" stroke-width="1.5" opacity="0.5" />
          <path d="M 28 32 C 28 30 30 29 32 29 C 34 29 36 30 36 32 C 36 34 34 35 32 35 C 30 35 28 34 28 32 Z M 32 27 V 37" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" />
        </svg>
      </div>
      <div style="font-size:1.6rem;font-weight:800">Rp {{ number_format($stats['total_revenue']/1000000,1) }}M</div>
      <div style="font-size:.8rem;color:var(--text3)">Revenue Platform</div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:1rem;margin-bottom:1.5rem">
    @foreach([['🧑‍💻', $stats['programmers'], 'Programmer', 'var(--primary)'],['🏢', $stats['umkms'], 'UMKM', 'var(--accent)'],['⏰', $stats['open_projects'], 'Project Open', 'var(--orange)'],['✅', $stats['completed_projects'], 'Project Selesai', 'var(--green)']] as [$ic,$v,$l,$c])
    <div class="card glass-card" style="border-left:4px solid {{ $c }}">
      <div style="font-size:1.5rem;font-weight:800;color:{{ $c }}">{{ $v }}</div>
      <div style="font-size:.82rem;color:var(--text3)">{{ $ic }} {{ $l }}</div>
    </div>
    @endforeach
  </div>

  <!-- PENDING PROJECTS (ACC ACTION) -->
  <div id="adminPendingProjectsCard" class="card" style="margin-bottom:1.5rem;border-left:4px solid var(--orange)">
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

  <div id="adminPendingVerificationsGrid" style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.5rem">
    <!-- Pending Programmer Verifications -->
    <div class="card">
      <div class="card-header">
        <span class="card-title">✅ Verifikasi Programmer Pending ({{ $stats['pending_verifications'] }})</span>
      </div>
      @forelse($pendingProgrammers as $prog)
      <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:1rem 0;border-bottom:1px solid var(--border)">
        <div style="display:flex;align-items:flex-start;gap:.5rem;flex:1">
          <div style="width:36px;height:36px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;margin-right:.5rem;flex-shrink:0">{{ strtoupper(substr($prog->name,0,1)) }}</div>
          <div style="flex:1">
            <div style="font-size:.9rem;font-weight:800;color:var(--text)">{{ $prog->name }}</div>
            <div style="font-size:.78rem;color:var(--text3);margin-bottom:0.5rem">{{ $prog->city ?? 'Kota belum diisi' }} · {{ $prog->phone ?? 'No HP belum diisi' }}</div>
            
            <!-- Dokumen Pendaftaran Sah -->
            <div style="background:rgba(255,255,255,0.03);border:1px dashed var(--border);border-radius:var(--radius-sm);padding:0.6rem;margin-bottom:0.6rem;font-size:0.8rem">
              <div style="margin-bottom:0.4rem">
                <span style="color:var(--text3)">No. KTP:</span> 
                <strong style="color:var(--text);font-family:monospace">{{ $prog->ktp_number ?? '—' }}</strong>
              </div>
              <div style="display:flex;gap:0.4rem;flex-wrap:wrap">
                @if($prog->ktp_photo)
                  <a href="{{ asset('storage/' . $prog->ktp_photo) }}" target="_blank" class="btn btn-xs" style="background:rgba(79, 70, 229, 0.1);color:#818CF8;border:1px solid rgba(79, 70, 229, 0.3);font-size:0.72rem;padding:4px 8px;border-radius:4px;font-weight:600">🪪 Lihat KTP</a>
                @endif
                @if($prog->cv_file)
                  <a href="{{ asset('storage/' . $prog->cv_file) }}" target="_blank" class="btn btn-xs" style="background:rgba(16, 185, 129, 0.1);color:#34D399;border:1px solid rgba(16, 185, 129, 0.3);font-size:0.72rem;padding:4px 8px;border-radius:4px;font-weight:600">📄 Lihat CV</a>
                @endif
                @if($prog->portfolio_file)
                  <a href="{{ asset('storage/' . $prog->portfolio_file) }}" target="_blank" class="btn btn-xs" style="background:rgba(245, 158, 11, 0.1);color:#FBBF24;border:1px solid rgba(245, 158, 11, 0.3);font-size:0.72rem;padding:4px 8px;border-radius:4px;font-weight:600">💼 Portofolio Awal</a>
                @endif
              </div>
            </div>

            <!-- Portofolio list -->
            <div style="margin-top: 0.35rem;">
              <span style="font-size:.78rem;font-weight:600;color:var(--primary)">🗂 Portofolio ({{ $prog->portfolios->count() }}):</span>
              <ul style="margin: 2px 0 0 10px; padding: 0; font-size: .75rem; color: var(--text2); list-style-type: disc;">
                @forelse($prog->portfolios as $p)
                  <li>
                    <strong>{{ $p->title }}</strong>: {{ Str::limit($p->description, 50) }}
                    @if($p->portfolio_file)
                      · <a href="{{ asset('storage/' . $p->portfolio_file) }}" target="_blank" style="color:var(--primary);text-decoration:underline;font-weight:600">Lihat Lampiran 📷</a>
                    @endif
                  </li>
                @empty
                  <li style="color: var(--text3); list-style-type: none; margin-left: -10px;">Belum ada portofolio</li>
                @endforelse
              </ul>
            </div>
            <!-- Sertifikat list -->
            <div style="margin-top: 0.35rem;">
              <span style="font-size:.78rem;font-weight:600;color:var(--green)">📜 Sertifikat ({{ $prog->certificates->count() }}):</span>
              <ul style="margin: 2px 0 0 10px; padding: 0; font-size: .75rem; color: var(--text2); list-style-type: disc;">
                @forelse($prog->certificates as $c)
                  <li>
                    <strong>{{ $c->name }}</strong> (oleh {{ $c->issuer }})
                    @if($c->certificate_file)
                      · <a href="{{ asset('storage/' . $c->certificate_file) }}" target="_blank" style="color:var(--primary);text-decoration:underline;font-weight:600">Lihat Lampiran 📷</a>
                    @endif
                  </li>
                @empty
                  <li style="color: var(--text3); list-style-type: none; margin-left: -10px;">Belum ada sertifikat</li>
                @endforelse
              </ul>
            </div>
          </div>
        </div>
        <div style="flex-shrink:0;margin-left:0.5rem">
          <form method="POST" action="{{ route('admin.verify-programmer', $prog) }}">
            @csrf
            <button type="submit" class="btn btn-success btn-sm" style="background:var(--green);border-color:var(--green);font-weight:600" aria-label="Verifikasi programmer {{ $prog->name }}">Verifikasi ✅</button>
          </form>
        </div>
      </div>
      @empty
      <p style="color:var(--text3);font-size:.875rem;padding:1rem 0">Tidak ada pending verifikasi. 🎉</p>
      @endforelse
    </div>

    <!-- Pending UMKM Verifications -->
    <div class="card">
      <div class="card-header">
        <span class="card-title">🏢 Verifikasi UMKM Pending ({{ $stats['umkm_pending'] }})</span>
      </div>
      @forelse($pendingUmkms as $umkm)
      <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:1rem 0;border-bottom:1px solid var(--border)">
        <div style="display:flex;align-items:flex-start;gap:.5rem;flex:1">
          <div style="width:36px;height:36px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;margin-right:.5rem;flex-shrink:0">{{ strtoupper(substr($umkm->name,0,1)) }}</div>
          <div style="flex:1">
            <div style="font-size:.9rem;font-weight:800;color:var(--text)">{{ $umkm->business_name ?? $umkm->name }}</div>
            <div style="font-size:.78rem;color:var(--text3);margin-bottom:0.5rem">Pemilik: {{ $umkm->name }} · {{ $umkm->city ?? 'Kota belum diisi' }} · {{ $umkm->phone ?? 'No HP belum diisi' }}</div>
            
            <!-- Dokumen Pendaftaran Sah -->
            <div style="background:rgba(255,255,255,0.03);border:1px dashed var(--border);border-radius:var(--radius-sm);padding:0.6rem;font-size:0.8rem">
              <div style="margin-bottom:0.4rem">
                <span style="color:var(--text3)">No. KTP:</span> 
                <strong style="color:var(--text);font-family:monospace">{{ $umkm->ktp_number ?? '—' }}</strong>
              </div>
              <div style="display:flex;gap:0.4rem;flex-wrap:wrap">
                @if($umkm->ktp_photo)
                  <a href="{{ asset('storage/' . $umkm->ktp_photo) }}" target="_blank" class="btn btn-xs" style="background:rgba(79, 70, 229, 0.1);color:#818CF8;border:1px solid rgba(79, 70, 229, 0.3);font-size:0.72rem;padding:4px 8px;border-radius:4px;font-weight:600">🪪 Lihat KTP</a>
                @endif
                @if($umkm->business_photo)
                  <a href="{{ asset('storage/' . $umkm->business_photo) }}" target="_blank" class="btn btn-xs" style="background:rgba(16, 185, 129, 0.1);color:#34D399;border:1px solid rgba(16, 185, 129, 0.3);font-size:0.72rem;padding:4px 8px;border-radius:4px;font-weight:600">🏪 Lihat Foto Usaha</a>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div style="flex-shrink:0;margin-left:0.5rem">
          <form method="POST" action="{{ route('admin.verify-umkm', $umkm) }}">
            @csrf
            <button type="submit" class="btn btn-success btn-sm" style="background:var(--green);border-color:var(--green);font-weight:600" aria-label="Verifikasi UMKM {{ $umkm->name }}">Verifikasi ✅</button>
          </form>
        </div>
      </div>
      @empty
      <p style="color:var(--text3);font-size:.875rem;padding:1rem 0">Tidak ada pending verifikasi. 🎉</p>
      @endforelse
    </div>
  </div>

  <!-- Pending Portfolios & Certificates Verifications -->
  <div id="adminDocVerificationsCard" class="card" style="margin-bottom:1.25rem">
    <div class="card-header" style="border-bottom:1px solid var(--border);padding-bottom:.75rem;margin-bottom:.75rem">
      <span class="card-title" style="color:var(--primary)">🗂 Verifikasi Portofolio & Sertifikat Pending</span>
    </div>
    <div style="display:flex;flex-direction:column;gap:.75rem">
      @php
        $pendingPorts = \App\Models\Portfolio::where('status', 'pending')->with('programmer')->get();
        $pendingCerts = \App\Models\Certificate::where('status', 'pending')->with('programmer')->get();
      @endphp

      @forelse($pendingPorts as $p)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:.85rem;background:var(--bg2);border-radius:var(--radius);border:1px solid var(--border)">
        <div style="flex:1;padding-right:1.5rem">
          <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.25rem">
            <span class="badge" style="background:var(--primary-light);color:var(--primary);font-size:.7rem;font-weight:700">PORTOFOLIO</span>
            <strong style="font-size:.92rem;color:var(--text)">{{ $p->title }}</strong>
            <span style="font-size:.75rem;color:var(--text3)">oleh {{ $p->programmer->name }}</span>
          </div>
          <p style="font-size:.82rem;color:var(--text2);margin-bottom:.25rem;line-height:1.5">{{ $p->description }}</p>
          @if($p->tags)
            <div style="display:flex;gap:.25rem;flex-wrap:wrap">
              @foreach($p->tags as $tag)
                <span style="font-size:.7rem;padding:2px 6px;background:var(--bg3);border-radius:4px;color:var(--text2)">{{ $tag }}</span>
              @endforeach
            </div>
          @endif
          @if($p->project_url)
            <div style="font-size:.75rem;color:var(--primary);margin-top:4px"><a href="{{ $p->project_url }}" target="_blank">🔗 Lihat Project</a></div>
          @endif
          @if($p->portfolio_file)
            <div style="font-size:.75rem;color:var(--primary);margin-top:4px"><a href="{{ asset('storage/' . $p->portfolio_file) }}" target="_blank">📷 Lihat Lampiran / Hasil Scan</a></div>
          @endif
        </div>
        <div style="flex-shrink:0;display:flex;gap:.5rem;align-items:center">
          <form method="POST" action="{{ route('admin.portfolio.approve', $p) }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm" style="background:var(--green);border-color:var(--green);font-weight:600">Setujui ✅</button>
          </form>
          <form method="POST" action="{{ route('admin.portfolio.reject', $p) }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--red);border-color:var(--red);background:var(--red-light);padding:6px 12px">❌ Tolak</button>
          </form>
        </div>
      </div>
      @empty
      @endforelse

      @forelse($pendingCerts as $c)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:.85rem;background:var(--bg2);border-radius:var(--radius);border:1px solid var(--border)">
        <div style="flex:1;padding-right:1.5rem">
          <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.25rem">
            <span class="badge" style="background:var(--green-light);color:var(--green);font-size:.7rem;font-weight:700">SERTIFIKAT</span>
            <strong style="font-size:.92rem;color:var(--text)">{{ $c->name }}</strong>
            <span style="font-size:.75rem;color:var(--text3)">oleh {{ $c->programmer->name }}</span>
          </div>
          <p style="font-size:.82rem;color:var(--text2);margin-bottom:.25rem;line-height:1.5">Penerbit: <strong>{{ $c->issuer }}</strong> @if($c->issue_date) · Tanggal: {{ $c->issue_date->format('M Y') }} @endif</p>
          @if($c->credential_url)
            <div style="font-size:.75rem;color:var(--primary);margin-top:4px"><a href="{{ $c->credential_url }}" target="_blank">🔗 Lihat Kredensial</a></div>
          @endif
          @if($c->certificate_file)
            <div style="font-size:.75rem;color:var(--primary);margin-top:4px"><a href="{{ asset('storage/' . $c->certificate_file) }}" target="_blank">📷 Lihat Lampiran / Hasil Scan</a></div>
          @endif
        </div>
        <div style="flex-shrink:0;display:flex;gap:.5rem;align-items:center">
          <form method="POST" action="{{ route('admin.certificate.approve', $c) }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm" style="background:var(--green);border-color:var(--green);font-weight:600">Setujui ✅</button>
          </form>
          <form method="POST" action="{{ route('admin.certificate.reject', $c) }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--red);border-color:var(--red);background:var(--red-light);padding:6px 12px">❌ Tolak</button>
          </form>
        </div>
      </div>
      @empty
      @endforelse

      @if($pendingPorts->isEmpty() && $pendingCerts->isEmpty())
      <div style="text-align:center;padding:1.5rem;color:var(--text3);font-size:.875rem">
        Tidak ada portofolio atau sertifikat baru yang menunggu verifikasi.
      </div>
      @endif
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
            <td>{{ $p->budget > 0 ? 'Rp ' . number_format($p->budget/1000000,1) . 'M' : 'Menunggu Estimasi' }}</td>
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
