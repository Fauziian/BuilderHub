@extends('layouts.app')
@section('title', 'Dashboard Programmer')
@section('content')
<style>
  @keyframes lockBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
  }
</style>
<div class="dash-layout">
  <!-- PROFILE HEADER -->
  <div class="profile-header">
    <div style="display:flex;align-items:center;gap:1rem">
      <div class="profile-av">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
      <div>
        <div style="font-size:1.25rem;font-weight:800">{{ $user->name }}</div>
        <div style="font-size:.85rem;color:var(--text2);display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;margin-top:.35rem">
          @if($user->city)
          <span style="display:inline-flex;align-items:center;gap:4px;font-size:.78rem;font-weight:600;color:var(--text2)">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="#EF4444"/></svg>
            {{ $user->city }}
          </span>
          @endif
          @if($user->is_verified)
          <span style="font-size:.7rem;font-weight:700;padding:3px 10px;border-radius:99px;background:#ECFDF5;color:#059669;border:1px solid rgba(5,150,105,0.2);display:inline-flex;align-items:center;gap:4px">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:12px;height:12px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="#10B981"/></svg>
            Terverifikasi
          </span>
          @endif
          @if($user->is_top_programmer)
          <span style="font-size:.7rem;font-weight:700;padding:3px 10px;border-radius:99px;background:#FFF7ED;color:#C2410C;border:1px solid rgba(194,65,12,0.2);display:inline-flex;align-items:center;gap:4px">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:12px;height:12px;"><path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v3c0 2.44 1.72 4.48 4 4.88V17c0 1.1.9 2 2 2h2v2H9v2h6v-2h-2v-2h2c1.1 0 2-.9 2-2v-2.12c2.28-.4 4-2.44 4-4.88V7c0-1.1-.9-2-2-2zm-12 5V7h2v3c0 .55-.45 1-1 1s-1-.45-1-1zm10 0c0 .55-.45 1-1 1s-1-.45-1-1V7h2v3z" fill="#F59E0B"/></svg>
            Top Programmer
          </span>
          @endif
          @if($user->is_top_programmer)
          <span style="font-size:.7rem;font-weight:700;padding:3px 10px;border-radius:99px;background:#EDE9FE;color:#6D28D9;border:1px solid rgba(109,40,217,0.2);display:inline-flex;align-items:center;gap:4px">
            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:12px;height:12px;"><path d="M32 6 L54 22 L32 58 L10 22 Z" fill="#8B5CF6"/><path d="M32 6 L42 22 L32 38 L22 22 Z" fill="#A78BFA"/></svg>
            Pemateri
          </span>
          @endif
        </div>
      </div>
    </div>
    <div style="display:flex;gap:.75rem;align-items:center">
      @if($user->is_verified)
      <a href="{{ route('projects') }}" class="btn btn-primary btn-sm">🔍 Cari Project</a>
      @endif
      @php
        $unreadMessagesCount = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
      @endphp
      <a href="{{ route('messages.index') }}" class="btn btn-ghost btn-sm" style="border-color:var(--primary);color:var(--primary);background:var(--primary-light);font-weight:600;display:inline-flex;align-items:center;gap:6px">
        💬 Pesan / Chat
        @if($unreadMessagesCount > 0)
          <span style="background:var(--red);color:#fff;font-size:0.75rem;font-weight:800;padding:2px 7px;border-radius:99px;line-height:1;display:inline-flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(239,68,68,0.4)">{{ $unreadMessagesCount }}</span>
        @endif
      </a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="btn btn-ghost btn-sm" style="border-color:var(--red);color:var(--red);background:var(--red-light)" aria-label="Keluar dari akun">Keluar 🚪</button>
      </form>
    </div>
  </div>

  <!-- IMK: Tab navigation makes feature discoverability clear -->
  <div class="tab-bar" role="tablist" aria-label="Menu Dashboard Programmer">
    <button class="tab-btn active" onclick="showTab('overview')" role="tab" aria-selected="true" id="tab-overview">📊 Overview</button>
    <button class="tab-btn" onclick="showTab('projects')" role="tab" id="tab-projects">🔍 Cari Project</button>
    <button class="tab-btn" onclick="showTab('courses')" role="tab" id="tab-courses">📚 Course Saya</button>
    <button class="tab-btn" onclick="showTab('verify')" role="tab" id="tab-verify">✅ Verifikasi</button>
  </div>

  <!-- OVERVIEW TAB -->
  <div id="pane-overview" role="tabpanel">
    <div class="stats-grid">
      <div class="stat-card glass-card">
        <div class="stat-card-icon" style="background:rgba(245,158,11,0.1)">
          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 44px; height: 44px; filter: drop-shadow(0 4px 8px rgba(245, 158, 11, 0.4));">
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
        <div class="stat-card-value">Rp {{ number_format($user->total_earnings / 1000000, 1) }}M</div>
        <div class="stat-card-label">Total Pendapatan</div>
      </div>
      <div class="stat-card glass-card">
        <div class="stat-card-icon" style="background:rgba(59,130,246,0.1)">
          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 44px; height: 44px; filter: drop-shadow(0 4px 8px rgba(59, 130, 246, 0.4));">
            <defs>
              <linearGradient id="glass-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#93C5FD" />
                <stop offset="50%" stop-color="#3B82F6" />
                <stop offset="100%" stop-color="#1D4ED8" />
              </linearGradient>
              <linearGradient id="sand-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#FCD34D" />
                <stop offset="100%" stop-color="#F59E0B" />
              </linearGradient>
            </defs>
            <rect x="10" y="8" width="44" height="6" rx="3" fill="#1D4ED8" />
            <rect x="10" y="50" width="44" height="6" rx="3" fill="#1D4ED8" />
            <path d="M 16 14 C 16 28 28 30 28 32 C 28 34 16 36 16 50 Z" fill="none" stroke="url(#glass-grad)" stroke-width="3" stroke-linecap="round" />
            <path d="M 48 14 C 48 28 36 30 36 32 C 36 34 48 36 48 50 Z" fill="none" stroke="url(#glass-grad)" stroke-width="3" stroke-linecap="round" />
            <path d="M 18 16 Q 32 28 32 30" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" opacity="0.6" />
            <path d="M 20 18 C 20 26 28 28 30 30 L 34 30 C 36 28 44 26 44 18 Z" fill="url(#sand-grad)" />
            <rect x="31" y="30" width="2" height="10" fill="#F59E0B" opacity="0.8" />
            <path d="M 22 48 C 22 42 26 40 32 40 C 38 40 42 42 42 48 Z" fill="url(#sand-grad)" />
          </svg>
        </div>
        <div class="stat-card-value">{{ $activeProjects->count() }}</div>
        <div class="stat-card-label">Project Berjalan</div>
      </div>
      <div class="stat-card glass-card">
        <div class="stat-card-icon" style="background:rgba(16,185,129,0.1)">
          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 44px; height: 44px; filter: drop-shadow(0 4px 8px rgba(16, 185, 129, 0.4));">
            <defs>
              <linearGradient id="shield-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#34D399" />
                <stop offset="50%" stop-color="#10B981" />
                <stop offset="100%" stop-color="#047857" />
              </linearGradient>
              <linearGradient id="check-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#FFF" />
                <stop offset="100%" stop-color="#ECFDF5" />
              </linearGradient>
            </defs>
            <path d="M 32 6 C 44 6 52 10 52 18 C 52 38 32 56 32 58 C 32 56 12 38 12 18 C 12 10 20 6 32 6 Z" fill="url(#shield-grad)" />
            <path d="M 32 9 C 41 9 48 12 48 18 C 48 34 32 49 32 52" stroke="#6EE7B7" stroke-width="2" stroke-linecap="round" opacity="0.5" />
            <path d="M 22 30 L 29 37 L 44 22" stroke="url(#check-grad)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </div>
        <div class="stat-card-value">{{ $completedProjects }}</div>
        <div class="stat-card-label">Project Selesai</div>
      </div>
      <div class="stat-card glass-card">
        <div class="stat-card-icon" style="background:rgba(245,158,11,0.1)">
          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 44px; height: 44px; filter: drop-shadow(0 4px 8px rgba(245, 158, 11, 0.4));">
            <defs>
              <linearGradient id="star-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#FDE047" />
                <stop offset="50%" stop-color="#F59E0B" />
                <stop offset="100%" stop-color="#D97706" />
              </linearGradient>
            </defs>
            <path d="M 32 6 L 40 22 L 58 24 L 44 36 L 48 54 L 32 44 L 16 54 L 20 36 L 6 24 L 24 22 Z" fill="url(#star-grad)" />
            <path d="M 32 9 L 38 23 L 53 25 L 41 35 L 45 50 L 32 41" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" opacity="0.4" />
          </svg>
        </div>
        <div class="stat-card-value" style="font-size:1.15rem;display:flex;flex-direction:column;gap:4px;margin-top:4px">
          <span style="font-weight:800;color:var(--text)">🏢 {{ number_format($user->rating ?: 5.0, 1) }} ★ <span style="font-size:0.75rem;font-weight:normal;color:var(--text2)">Project</span></span>
          <span style="font-weight:800;color:var(--text)">🎓 {{ number_format($user->course_rating ?: 5.0, 1) }} ★ <span style="font-size:0.75rem;font-weight:normal;color:var(--text2)">Course</span></span>
        </div>
        <div class="stat-card-label" style="margin-top:6px">Rating Saya</div>
      </div>
    </div>

    <!-- IMK: Progress bar shows user completion status with clear goal -->
    <div class="card" style="margin-bottom:1.25rem">
      <div class="card-header"><span class="card-title">📋 Kelengkapan Profil Verifikasi</span>
        <span style="font-size:.85rem;font-weight:600;color:var(--primary)">
          @php
            $approvedCertCount = $certificates->where('status', 'approved')->count();
            $approvedPortCount = $portfolios->where('status', 'approved')->count();
            
            $hasBio = !empty($user->bio) && !empty($user->expertise);
            $hasKtp = !empty($user->ktp_number) && !empty($user->ktp_photo);
            $hasCv = !empty($user->cv_file);
            
            $hasCertApproved = $user->is_verified || ($approvedCertCount >= 1);
            $certStatus = $hasCertApproved ? true : 'pending';
            
            $hasTop = $user->is_top_programmer && $approvedCertCount >= 3 && $approvedPortCount >= 3;
            $hasCourse = $user->is_top_programmer;
            
            // Calculate progress based on all 6 items as requested
            $doneCount = ($hasBio ? 1 : 0) + ($hasKtp ? 1 : 0) + ($hasCv ? 1 : 0) + ($hasCertApproved ? 1 : 0) + ($hasTop ? 1 : 0) + ($hasCourse ? 1 : 0);
            $progress = (int)($doneCount / 6 * 100);
          @endphp
          {{ $progress }}%
        </span>
      </div>
      <div class="progress-bar" style="margin-bottom:.75rem"><div class="progress-fill" style="width:{{ $progress }}%"></div></div>
      <div style="display:flex;flex-direction:column;gap:.4rem">
        @foreach([
          ['Skill/Bio ditambahkan', $hasBio],
          ['KTP', $hasKtp],
          ['CV (Curriculum Vitae)', $hasCv],
          [$hasCertApproved ? 'Minimal 1 sertifikat (Disetujui)' : 'Minimal 1 sertifikat (menunggu di review oleh admin 1 x 24 jam)', $certStatus],
          ['Top Programmer (3+ sertifikat + 3+ portofolio)', $hasTop],
          ['Hak Membuat Course (Top Programmer)', $hasCourse],
        ] as [$label, $done])
        <div style="display:flex;align-items:center;gap:.75rem;padding:.5rem 0;border-bottom:1px solid var(--border)">
          @php
            if ($done === true) {
                $bg = 'var(--green-light)';
                $color = 'var(--green)';
                $icon = '✓';
                $lblColor = 'var(--text)';
            } elseif ($done === 'pending') {
                $bg = '#FEF3C7';
                $color = '#D97706';
                $icon = '○';
                $lblColor = '#B45309';
            } else {
                $bg = 'var(--bg3)';
                $color = 'var(--text3)';
                $icon = '○';
                $lblColor = 'var(--text3)';
            }
          @endphp
          <div style="width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;background:{{ $bg }};color:{{ $color }};flex-shrink:0;font-weight:bold;border:1px solid {{ $done === 'pending' ? 'rgba(245,158,11,0.3)' : 'transparent' }}">{{ $icon }}</div>
          <span style="font-size:.875rem;color:{{ $lblColor }};font-weight:{{ $done === 'pending' ? '600' : 'normal' }}">{{ $label }}</span>
        </div>
        @endforeach
      </div>
    </div>

    @if($activeProjects->count() || $myBids->count())
      @if($activeProjects->count())
      <div class="card" style="margin-bottom:1.25rem">
        <div class="card-header"><span class="card-title">🔥 Project Aktif</span></div>
        <div style="display:flex;flex-direction:column;gap:1rem">
          @foreach($activeProjects as $p)
          <div style="padding:1.25rem;background:var(--green-light);border-radius:var(--radius-lg);border:1px solid rgba(16,185,129,.25);box-shadow:0 4px 15px rgba(16,185,129,0.04)">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:0.85rem">
              <div>
                <div style="font-size:.95rem;font-weight:800;color:var(--text)">&lt;/&gt; {{ $p->title }}</div>
                <div style="font-size:.8rem;color:var(--text3);margin-top:2px">Klien: <strong>{{ $p->umkm->business_name ?? $p->umkm->name }}</strong></div>
              </div>
              <div style="text-align:right">
                <div style="font-size:1.05rem;font-weight:800;color:var(--green)">Rp {{ number_format($p->programmer_earning, 0, ',', '.') }}</div>
                <div style="font-size:.75rem;color:var(--text3);font-weight:600">Pendapatan Bersih Anda (20%)</div>
                <div style="font-size:.7rem;color:var(--text3);margin-top:2px">Komisi Platform (80%): Rp {{ number_format($p->platform_fee, 0, ',', '.') }}</div>
              </div>
            </div>

            <!-- Progress tracker bar -->
            <div style="margin-bottom:1rem">
              <div style="display:flex;justify-content:space-between;align-items:center;font-size:.8rem;font-weight:700;margin-bottom:.35rem">
                <span style="color:var(--text2)">Progress Pengerjaan</span>
                <span style="color:var(--primary)">{{ $p->project_progress }}%</span>
              </div>
              <div class="progress-bar" style="height:8px;background:rgba(255,255,255,0.5);border-radius:99px;overflow:hidden;margin:0">
                <div class="progress-fill" style="width:{{ $p->project_progress }}%;height:100%;background:linear-gradient(90deg, var(--primary), var(--accent));border-radius:99px;transition:width 0.4s"></div>
              </div>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:.5rem;align-items:center">
              <button onclick="openChat({{ $p->id }}, {{ $p->umkm->id }}, '{{ addslashes($p->umkm->business_name ?? $p->umkm->name) }}', 'programmer')" class="btn btn-ghost btn-sm" style="display:inline-flex;align-items:center;gap:4px">
                💬 Chat Klien
              </button>
              <button onclick="openProgressModal({{ $p->id }}, '{{ addslashes($p->title) }}', {{ $p->project_progress }}, {{ $p->programmer_earning }})" class="btn btn-primary btn-sm" style="display:inline-flex;align-items:center;gap:4px;font-weight:700;box-shadow:0 4px 12px rgba(108,56,255,0.2)">
                ⚙️ Kelola Progress & Kirim
              </button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      {{-- PROJECT SELESAI SECTION --}}
      @php
        $completedProjectsList = \App\Models\Project::with('umkm')
            ->where('assigned_programmer_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->get();
      @endphp
      
      @if($completedProjectsList->count() > 0)
      <div class="card" style="margin-bottom:1.25rem">
        <div class="card-header"><span class="card-title">✅ Project Selesai & Sukses ({{ $completedProjectsList->count() }})</span></div>
        <div style="display:flex;flex-direction:column;gap:0.75rem">
          @foreach($completedProjectsList as $cp)
          <div style="padding:1rem;background:var(--bg2);border:1.5px solid var(--border);border-radius:var(--radius-lg)">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:0.5rem">
              <div>
                <div style="font-size:.9rem;font-weight:700;color:var(--text)">{{ $cp->title }}</div>
                <div style="font-size:.78rem;color:var(--text3);margin-top:2px">Klien: {{ $cp->umkm->business_name ?? $cp->umkm->name }} · Status: <strong style="color:var(--green)">Selesai & Dana Cair 💎</strong></div>
              </div>
              <div style="text-align:right">
                <div style="font-size:0.95rem;font-weight:800;color:var(--green)">+ Rp {{ number_format($cp->programmer_earning, 0, ',', '.') }}</div>
                <div style="font-size:.7rem;color:var(--text3)">Diterima Bersih (80%)</div>
              </div>
            </div>
            
            <div style="display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap;margin-top:0.75rem;padding-top:0.75rem;border-top:1px dashed var(--border)">
              <span style="font-size:.75rem;color:var(--text3);font-weight:600;margin-right:4px">Berkas Terkirim:</span>
              @if($cp->zip_file)
                <a href="{{ asset('storage/' . $cp->zip_file) }}" class="badge" style="background:var(--green-light);color:var(--green);font-size:0.7rem;text-decoration:none;font-weight:700" download>📥 Download ZIP</a>
              @else
                <span class="badge" style="background:var(--bg3);color:var(--text3);font-size:0.7rem">📦 Tidak ada ZIP</span>
              @endif
              @if($cp->github_link)
                <a href="{{ $cp->github_link }}" target="_blank" style="font-size:0.7rem;color:var(--primary);text-decoration:underline;font-weight:700;margin-left:8px">🐙 GitHub Repo</a>
              @endif
              @if($cp->hosting_link)
                <a href="{{ str_starts_with($cp->hosting_link, 'http') ? $cp->hosting_link : 'https://' . $cp->hosting_link }}" target="_blank" style="font-size:0.7rem;color:var(--accent);text-decoration:underline;font-weight:700;margin-left:8px">Live Domain: {{ $cp->hosting_link }} 🌐</a>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      @if($myBids->count())
      <div class="card" style="margin-bottom:1.25rem">
        <div class="card-header"><span class="card-title">⏳ Status Penawaran Anda</span></div>
        <div style="display:flex;flex-direction:column;gap:.5rem">
          @foreach($myBids as $bid)
          @php
            $isRejectedOnce = ($bid->rejection_count === 1 && !$bid->is_revised);
            $isRejectedPermanently = ($bid->status === 'rejected' || $bid->rejection_count >= 2);
            $isPendingReversion = ($bid->rejection_count === 1 && $bid->is_revised);
            
            $bg = 'var(--orange-light)';
            $border = 'rgba(245,158,11,.2)';
            $statusText = 'Menunggu Persetujuan UMKM ⏳';
            if ($isRejectedOnce) {
              $bg = '#FEF3C7'; // soft yellow-orange
              $border = 'rgba(245,158,11,.3)';
              $statusText = 'Penawaran Ditolak (Silakan Ajukan Penawaran Kembali)';
            } elseif ($isRejectedPermanently) {
              $bg = '#FEE2E2'; // soft red
              $border = 'rgba(239,68,68,.3)';
              $statusText = 'Ditolak! ❌';
            } elseif ($isPendingReversion) {
              $statusText = 'Menunggu Persetujuan UMKM (Revisi Ke-1) ⏳';
            }
          @endphp
          <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem;background:{{ $bg }};border-radius:var(--radius);border:1px solid {{ $border }}">
            <div>
              <div style="font-size:.9rem;font-weight:700">{{ $bid->project->title }}</div>
              <div style="font-size:.8rem;color:var(--text3);margin-top:2px">
                {{ $bid->project->umkm->business_name ?? $bid->project->umkm->name }} · 
                <span style="font-weight:600">{{ $statusText }}</span>
              </div>
            </div>
            <div style="text-align:right;display:flex;align-items:center;gap:.75rem">
              <div>
                <div style="font-size:.95rem;font-weight:800;color:var(--primary)">Rp {{ number_format($bid->amount, 0, ',', '.') }}</div>
                <div style="font-size:.75rem;color:var(--text3)">{{ $bid->timeline_days }} hari pengerjaan</div>
              </div>
              <div style="display:flex;gap:.35rem;align-items:center">
                @if($isRejectedOnce)
                  <!-- Ajukan Penawaran Kembali button -->
                  <button onclick="openEditBidModal({{ $bid->id }}, {{ $bid->amount }}, {{ $bid->timeline_days }}, '{{ addslashes($bid->message) }}', '{{ addslashes($bid->project->title) }}', {{ max(1, (int)now()->startOfDay()->diffInDays($bid->project->deadline->startOfDay())) }})" class="btn btn-primary btn-sm" style="font-size:.78rem;background:var(--accent);border-color:var(--accent)">🔁 Ajukan Penawaran Kembali</button>
                @elseif(!$isRejectedPermanently)
                  <!-- Normal Edit button -->
                  <button onclick="openEditBidModal({{ $bid->id }}, {{ $bid->amount }}, {{ $bid->timeline_days }}, '{{ addslashes($bid->message) }}', '{{ addslashes($bid->project->title) }}', {{ max(1, (int)now()->startOfDay()->diffInDays($bid->project->deadline->startOfDay())) }})" class="btn btn-ghost btn-sm" style="font-size:.78rem;color:var(--primary);border-color:var(--primary);background:#fff">✏️ Ubah Penawaran</button>
                @endif
                @php
                  $unreadChatCount = \App\Models\Message::where('project_id', $bid->project_id)
                      ->where('receiver_id', auth()->id())
                      ->where('is_read', false)
                      ->count();
                @endphp
                <button onclick="openChat({{ $bid->project_id }}, {{ $bid->project->umkm_id }}, '{{ addslashes($bid->project->umkm->business_name ?? $bid->project->umkm->name) }}', 'programmer')" class="btn btn-primary btn-sm" style="font-size:.78rem;display:inline-flex;align-items:center;gap:6px">
                  💬 Diskusi / Chat
                  @if($unreadChatCount > 0)
                    <span style="background:#EF4444;color:#fff;font-size:0.7rem;font-weight:800;padding:2px 6px;border-radius:10px;line-height:1;box-shadow:0 2px 5px rgba(239,68,68,0.4)">
                      {{ $unreadChatCount }}
                    </span>
                  @endif
                </button>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif
    @endif

    {{-- ULASAN & RATING DITERIMA --}}
    @if($receivedReviews->count())
    <div class="card" style="margin-bottom:1.25rem">
      <div class="card-header">
        <span class="card-title">⭐ Ulasan & Rating Saya ({{ $receivedReviews->count() }})</span>
        <span style="font-size:.8rem;color:var(--text3)">
          Project: <strong style="color:var(--text)">{{ number_format($user->rating ?: 5.0, 1) }} ★</strong> &nbsp;·&nbsp;
          Course: <strong style="color:var(--text)">{{ number_format($user->course_rating ?: 5.0, 1) }} ★</strong>
        </span>
      </div>
      <div style="display:flex;flex-direction:column;gap:.75rem">
        @foreach($receivedReviews as $review)
        <div style="padding:.85rem 1rem;border:1px solid var(--border);border-radius:var(--radius-lg);background:var(--bg2);display:flex;gap:1rem;align-items:flex-start">
          {{-- Badge tipe rating --}}
          <div style="flex-shrink:0;text-align:center">
            @if($review->type === 'umkm')
              <div style="background:#FFF7ED;color:#C2410C;font-size:.65rem;font-weight:700;padding:3px 8px;border-radius:99px;border:1px solid rgba(194,65,12,.2);white-space:nowrap">🏢 UMKM</div>
            @else
              <div style="background:#EDE9FE;color:#6D28D9;font-size:.65rem;font-weight:700;padding:3px 8px;border-radius:99px;border:1px solid rgba(109,40,217,.2);white-space:nowrap">🎓 Pelajar</div>
            @endif
          </div>
          <div style="flex:1;min-width:0">
            {{-- Stars --}}
            <div style="display:flex;gap:2px;margin-bottom:.35rem;align-items:center">
              @for($s=1;$s<=5;$s++)
                <span style="font-size:1rem;color:{{ $s<=$review->rating ? '#F59E0B' : '#D1D5DB' }}">★</span>
              @endfor
              <span style="font-size:.78rem;color:var(--text3);margin-left:.4rem">{{ $review->rating }}/5</span>
            </div>
            {{-- Context (project/course title) --}}
            <div style="font-size:.75rem;color:var(--text3);margin-bottom:.25rem">
              @if($review->type === 'umkm' && $review->project)
                Project: <strong>{{ $review->project->title }}</strong>
              @elseif($review->type === 'course' && $review->course)
                Course: <strong>{{ $review->course->title }}</strong>
              @endif
            </div>
            {{-- Comment --}}
            @if($review->comment)
            <p style="font-size:.85rem;color:var(--text2);font-style:italic;margin-bottom:.35rem">"{{ $review->comment }}"</p>
            @else
            <p style="font-size:.82rem;color:var(--text3);font-style:italic;margin-bottom:.35rem">— Tidak ada komentar —</p>
            @endif
            {{-- Reviewer + date --}}
            <div style="font-size:.72rem;color:var(--text3)">
              Oleh: <strong>{{ $review->reviewer->name }}</strong> · {{ $review->created_at->format('d M Y') }}
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>

  <!-- PROJECTS TAB -->
  <div id="pane-projects" style="display:none" role="tabpanel">
    @if(!$user->is_verified)
    <div class="imk-guide" style="margin-bottom:1.5rem;background:#FEF3C7;border-color:rgba(245,158,11,0.3);border-style:solid;border-width:1.5px;padding:1.5rem;display:flex;align-items:center;gap:1.25rem;border-radius:var(--radius-lg)">
      <div style="font-size:2.5rem;animation:lockBounce 2s infinite;flex-shrink:0">🔒</div>
      <div>
        <div class="imk-guide-title" style="color:#B45309;font-size:1.1rem;font-weight:800">Fitur Belum Terbuka</div>
        <div class="imk-guide-text" style="color:#D97706;font-size:0.9rem;line-height:1.6;margin-top:4px">Akun Anda sedang dalam proses peninjauan oleh admin. Menunggu 1 x 24 jam verifikasi oleh admin agar dapat mencari dan mengambil project.</div>
      </div>
    </div>
    @else
    <div style="background:linear-gradient(135deg,#4F46E5,#7C3AED);border-radius:16px;padding:1.5rem 1.75rem;margin-bottom:1.25rem;color:#fff;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
      <div>
        <h2 style="color:#fff;font-size:1.3rem;font-weight:800;margin-bottom:.2rem">Tender & Proyek Tersedia</h2>
        <p style="color:rgba(255,255,255,.75);font-size:.875rem">{{ $availableProjects->total() }} proyek tersedia · Ajukan penawaran terbaik Anda</p>
      </div>
      <span style="font-size:2rem">🏆</span>
    </div>

    {{-- BAR PENCARIAN & FILTER CARI PROJECT --}}
    <form method="GET" action="{{ route('programmer.dashboard') }}#projects" style="margin-bottom:1.25rem;">
      <div style="background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:.85rem 1.25rem;display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;box-shadow:0 1px 4px rgba(0,0,0,.05)">

        {{-- Search — icon on RIGHT --}}
        <div style="position:relative;flex:2;min-width:220px">
          <input type="text" name="search" id="progSearchProject" value="{{ request('search') }}"
            placeholder="Cari proyek, teknologi, atau kata kunci..."
            style="width:100%;padding:8px 38px 8px 14px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#111827;font-size:.85rem;font-family:inherit;outline:none;transition:border-color .15s;box-shadow:0 1px 3px rgba(0,0,0,.05)"
            onfocus="this.style.borderColor='#4F46E5'"
            onblur="this.style.borderColor='#E5E7EB'" />
          <span style="position:absolute;right:11px;top:50%;transform:translateY(-50%);color:#9CA3AF;font-size:.85rem;pointer-events:none">🔍</span>
        </div>

        {{-- Category — grid icon LEFT --}}
        <div style="position:relative;min-width:155px">
          <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);pointer-events:none;z-index:1">
            <svg width="13" height="13" viewBox="0 0 16 16" fill="none" style="display:block">
              <rect x="1" y="1" width="5" height="5" rx="1" fill="#6B7280"/>
              <rect x="10" y="1" width="5" height="5" rx="1" fill="#6B7280"/>
              <rect x="1" y="10" width="5" height="5" rx="1" fill="#6B7280"/>
              <rect x="10" y="10" width="5" height="5" rx="1" fill="#6B7280"/>
            </svg>
          </span>
          <select name="category" id="progFilterCategory" onchange="this.form.submit()"
            style="width:100%;padding:8px 26px 8px 28px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#374151;font-size:.85rem;font-family:inherit;cursor:pointer;outline:none;appearance:none;box-shadow:0 1px 3px rgba(0,0,0,.05);transition:border-color .15s"
            onfocus="this.style.borderColor='#4F46E5'"
            onblur="this.style.borderColor='#E5E7EB'">
            <option value="">Semua Kategori</option>
            @foreach(['E-Commerce','Marketplace','Kuliner & Food Tech','Business Tools','Mobile App','Landing Page','Lainnya'] as $cat)
              <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
          <span style="position:absolute;right:9px;top:50%;transform:translateY(-50%);color:#6B7280;font-size:.65rem;pointer-events:none">▼</span>
        </div>

        {{-- App Type — phone icon LEFT --}}
        <div style="position:relative;min-width:165px">
          <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#6B7280;font-size:.8rem;pointer-events:none">📱</span>
          <select name="app_type" id="progFilterAppType" onchange="this.form.submit()"
            style="width:100%;padding:8px 26px 8px 28px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#374151;font-size:.85rem;font-family:inherit;cursor:pointer;outline:none;appearance:none;box-shadow:0 1px 3px rgba(0,0,0,.05);transition:border-color .15s"
            onfocus="this.style.borderColor='#4F46E5'"
            onblur="this.style.borderColor='#E5E7EB'">
            <option value="">Semua Jenis Apps</option>
            @foreach(['Aplikasi Web (Web-based)','Aplikasi Mobile (iOS/Android)','Aplikasi Desktop / Sistem Kasir','Sistem Informasi / ERP','Lainnya'] as $type)
              <option value="{{ $type }}" {{ request('app_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
          </select>
          <span style="position:absolute;right:9px;top:50%;transform:translateY(-50%);color:#6B7280;font-size:.65rem;pointer-events:none">▼</span>
        </div>

        {{-- Filter Button --}}
        <button type="submit"
          style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:8px;border:none;background:#4F46E5;color:#fff;font-size:.875rem;font-weight:700;cursor:pointer;font-family:inherit;white-space:nowrap;box-shadow:0 1px 4px rgba(79,70,229,.3);transition:background .15s;flex-shrink:0"
          onmouseover="this.style.background='#4338CA'" onmouseout="this.style.background='#4F46E5'">
          <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v2.586a1 1 0 01-.293.707l-4.414 4.414A1 1 0 0012 11v6.586a1 1 0 01-.293.707l-2 2A1 1 0 018 19v-8a1 1 0 00-.293-.707L3.293 6.293A1 1 0 013 5.586V3z" clip-rule="evenodd"/></svg>
          Filter
        </button>

        @if(request('search') || request('category') || request('app_type'))
          <a href="{{ route('programmer.dashboard') }}#projects"
            style="padding:8px 12px;border-radius:8px;border:1px solid #E5E7EB;color:#6B7280;font-size:.82rem;font-weight:600;text-decoration:none;background:#fff;white-space:nowrap;flex-shrink:0"
            onmouseover="this.style.color='#DC2626';this.style.borderColor='#DC2626'"
            onmouseout="this.style.color='#6B7280';this.style.borderColor='#E5E7EB'">✕ Reset</a>
        @endif
      </div>
    </form>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1.25rem" id="programmerProjectsGrid">
      @forelse($availableProjects as $p)
      @php
        $pOverdue = $p->deadline && now()->startOfDay()->gt($p->deadline->startOfDay());
        $pCatIcons = ['E-Commerce'=>'🛒','Marketplace'=>'🏪','Kuliner & Food Tech'=>'🍜','Business Tools'=>'📊','Mobile App'=>'📱','Landing Page'=>'🌐','Lainnya'=>'💡','Full Stack'=>'⚡','Frontend'=>'🎨','Backend'=>'⚙️','Database'=>'🗄️'];
        $pCatIcon = $pCatIcons[$p->category] ?? '💼';
      @endphp
      <div class="programmer-project-card" data-title="{{ strtolower($p->title) }}" data-desc="{{ strtolower($p->description) }}" data-category="{{ $p->category }}" data-apptype="{{ $p->app_type }}" data-tags="{{ strtolower(implode(',', $p->tags ?? [])) }}"
        style="background:{{ $pOverdue ? '#FFF5F5' : '#fff' }};border-radius:16px;border:1.5px solid {{ $pOverdue ? 'rgba(239,68,68,.3)' : '#E5E7EB' }};box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden;display:flex;flex-direction:column;transition:box-shadow .2s,transform .2s"
        onmouseover="this.style.boxShadow='0 8px 30px rgba(0,0,0,.14)';this.style.transform='translateY(-2px)'"
        onmouseout="this.style.boxShadow='0 2px 12px rgba(0,0,0,.06)';this.style.transform='translateY(0)'">

        {{-- TOP: Category badge + Status + Budget --}}
        <div style="padding:1rem 1.15rem .6rem;display:flex;justify-content:space-between;align-items:flex-start;gap:.5rem">
          <div style="display:flex;flex-direction:column;gap:.3rem">
            <span style="display:inline-flex;align-items:center;gap:4px;font-size:.7rem;font-weight:700;color:#4F46E5;background:#EEF2FF;border-radius:6px;padding:3px 10px;letter-spacing:.3px;text-transform:uppercase">
              {{ $pCatIcon }} {{ $p->category ?? 'PROJECT' }}
            </span>
            @if($pOverdue)
              <span style="display:inline-flex;align-items:center;gap:4px;font-size:.7rem;font-weight:700;color:#DC2626;background:#FEF2F2;border:1px solid rgba(239,68,68,.25);border-radius:6px;padding:3px 10px">⏰ DEADLINE TERLAMPAUI</span>
            @else
              <span style="display:inline-flex;align-items:center;gap:4px;font-size:.7rem;font-weight:700;color:#059669;background:#ECFDF5;border:1px solid rgba(16,185,129,.25);border-radius:6px;padding:3px 10px">✅ DIBUKA</span>
            @endif
          </div>
          <div style="text-align:right;flex-shrink:0">
            @if($p->budget > 0)
              <div style="font-size:1.1rem;font-weight:800;color:#111827;line-height:1.1">Rp {{ number_format($p->budget, 0, ',', '.') }}</div>
              <div style="font-size:.73rem;font-weight:600;color:#059669;margin-top:2px">Dapat: Rp {{ number_format($p->budget * 0.20, 0, ',', '.') }} (20%)</div>
            @else
              <div style="font-size:.9rem;font-weight:700;color:#7C3AED;line-height:1.2">Menunggu<br>Estimasi</div>
            @endif
          </div>
        </div>

        {{-- TITLE + UMKM --}}
        <div style="padding:0 1.15rem .6rem">
          <h3 style="font-size:.97rem;font-weight:800;color:#111827;margin-bottom:.3rem;line-height:1.4">&lt;/&gt; {{ $p->title }}</h3>
          @if(isset($p->umkm) && $p->umkm?->umkm_verified)
          <div style="display:inline-flex;align-items:center;gap:4px;font-size:.7rem;font-weight:700;color:#059669;background:#ECFDF5;border:1px solid rgba(16,185,129,.2);border-radius:4px;padding:2px 8px;margin-bottom:.3rem">✅ UMKM VERIFIED</div>
          @endif
          @if(isset($p->umkm))
          <div style="font-size:.76rem;color:#9CA3AF">{{ $p->umkm->business_name ?? $p->umkm->name }} · {{ $p->umkm->name }}</div>
          @endif
        </div>

        {{-- DESCRIPTION --}}
        <div style="padding:0 1.15rem .7rem;font-size:.84rem;color:#374151;line-height:1.65;flex:1">
          @if(strlen($p->description) > 130)
            <span class="desc-short">{{ Str::limit($p->description, 130) }}</span>
            <span class="desc-full" style="display:none">{{ $p->description }}</span>
            <button type="button" onclick="toggleDesc(this)" style="background:none;border:none;color:#4F46E5;font-size:.78rem;font-weight:700;cursor:pointer;padding:0;margin-left:4px;display:inline;font-family:inherit">Selengkapnya</button>
          @else
            {{ $p->description }}
          @endif
        </div>

        {{-- TAGS --}}
        <div style="padding:0 1.15rem .7rem;display:flex;flex-wrap:wrap;gap:.3rem">
          @foreach(($p->tags ?? []) as $tag)
          <span style="font-size:.73rem;font-weight:600;color:#4F46E5;background:#EEF2FF;border-radius:6px;padding:3px 9px">{{ $tag }}</span>
          @endforeach
        </div>

        {{-- FOOTER STATS --}}
        <div style="padding:.65rem 1.15rem;border-top:1px solid #F3F4F6;display:flex;align-items:center;gap:.85rem;font-size:.74rem;color:#9CA3AF;flex-wrap:wrap">
          <span style="color:{{ $pOverdue ? '#DC2626' : '#6B7280' }};font-weight:{{ $pOverdue ? '700' : '400' }}">🕐 {{ $p->deadline->format('d M Y') }}</span>
          <span>👥 {{ $p->bids->count() }} penawaran</span>
          <span>💳 Fee: {{ $p->budget > 0 ? 'Rp '.number_format($p->budget*.80,0,',','.') : 'Estimasi' }}</span>
        </div>

        {{-- ACTION BUTTON --}}
        <div style="padding:.65rem 1.15rem 1.1rem">
          @if($pOverdue)
            <button disabled style="width:100%;padding:10px;border-radius:10px;border:none;background:#FEF2F2;color:#DC2626;font-weight:700;font-size:.85rem;cursor:not-allowed;display:flex;align-items:center;justify-content:center;gap:6px;font-family:inherit">⛔ Deadline Terlampaui</button>
          @elseif($p->bids->contains('programmer_id', $user->id))
            <button disabled style="width:100%;padding:10px;border-radius:10px;border:none;background:#FFFBEB;color:#92400E;font-weight:700;font-size:.85rem;cursor:not-allowed;display:flex;align-items:center;justify-content:center;gap:6px;font-family:inherit">⏳ Menunggu Persetujuan UMKM</button>
          @elseif(!$user->is_verified)
            <button disabled style="width:100%;padding:10px;border-radius:10px;border:none;background:#F9FAFB;color:#9CA3AF;font-weight:700;font-size:.85rem;cursor:not-allowed;display:flex;align-items:center;justify-content:center;gap:6px;font-family:inherit">🔒 Menunggu Verifikasi Akun</button>
          @else
            <button onclick="openBidModal({{ $p->id }}, '{{ addslashes($p->title) }}', {{ $p->budget }}, {{ max(1,(int)now()->startOfDay()->diffInDays($p->deadline->startOfDay())) }})"
              style="width:100%;padding:10px;border-radius:10px;border:none;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;font-weight:700;font-size:.875rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;font-family:inherit;transition:opacity .2s"
              onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'"
              aria-label="Ajukan penawaran untuk {{ $p->title }}">
              Ajukan Penawaran →
            </button>
          @endif
        </div>
      </div>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:5rem 2rem;background:#fff;border-radius:16px;border:1px solid #E5E7EB">
        <div style="font-size:3rem;margin-bottom:1rem">🔍</div>
        <h3 style="font-size:1.1rem;font-weight:700;color:#374151;margin-bottom:.35rem">Tidak ada project yang tersedia</h3>
        <p style="font-size:.85rem;color:#9CA3AF">Coba cari dengan kata kunci lain atau reset filter Anda.</p>
      </div>
      @endforelse
    </div>

    <!-- Beautiful Pagination Links -->
    <div style="margin-top:2rem">
      {{ $availableProjects->fragment('projects')->links() }}
    </div>
    @endif
  </div>

  <!-- COURSES TAB -->
  <div id="pane-courses" style="display:none" role="tabpanel">
    @if(!$user->is_verified)
    <div class="imk-guide" style="margin-bottom:1.5rem;background:#FEF3C7;border-color:rgba(245,158,11,0.3);border-style:solid;border-width:1.5px;padding:1.5rem;display:flex;align-items:center;gap:1.25rem;border-radius:var(--radius-lg)">
      <div style="font-size:2.5rem;animation:lockBounce 2s infinite;flex-shrink:0">🔒</div>
      <div>
        <div class="imk-guide-title" style="color:#B45309;font-size:1.1rem;font-weight:800">Fitur Belum Terbuka</div>
        <div class="imk-guide-text" style="color:#D97706;font-size:0.9rem;line-height:1.6;margin-top:4px">Akun Anda sedang dalam proses peninjauan oleh admin. Menunggu 1 x 24 jam verifikasi oleh admin agar dapat membuat dan mengelola course.</div>
      </div>
    </div>
    @elseif(!$user->is_top_programmer)
    <!-- IMK: Clear explanation of what user needs to unlock feature -->
    <div class="imk-guide">
      <div class="imk-guide-icon">🔒</div>
      <div>
        <div class="imk-guide-title">Fitur Belum Terbuka</div>
        <div class="imk-guide-text">Untuk membuat Course, Anda harus menjadi <strong>Top Programmer</strong>: Upload minimal 3 sertifikat & 3 portofolio. Saat ini: {{ $certificates->count() }}/3 sertifikat, {{ $portfolios->count() }}/3 portofolio.</div>
      </div>
    </div>
    @else
    <div style="background:var(--primary-light);border:1px solid rgba(108,56,255,.2);border-radius:var(--radius);padding:.85rem 1rem;font-size:.85rem;color:var(--primary);margin-bottom:1rem;display:flex;justify-content:space-between;align-items:center">
      <span>💡 Anda adalah Top Programmer! Bagikan ilmu Anda dan dapatkan penghasilan tambahan.</span>
      <a href="{{ route('programmer.create-course') }}" class="btn btn-primary btn-sm">+ Buat Course</a>
    </div>
    @endif

    {{-- TITLE & STATS CARDS --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem">
      <div>
        <h2 style="font-size:1.4rem;font-weight:800;color:#111827;margin:0 0 .2rem">Course Saya ({{ $myCourses->count() }})</h2>
        <p style="font-size:.82rem;color:#6B7280;margin:0">Kelola semua course Anda dengan mudah</p>
      </div>
      
      {{-- Stats Cards Row --}}
      <div style="display:flex;gap:.75rem;flex-wrap:wrap">
        {{-- Card 1: Total Course --}}
        <div style="background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:.7rem 1rem;display:flex;align-items:center;gap:.75rem;min-width:130px;box-shadow:0 1px 3px rgba(0,0,0,.05)">
          <div style="width:38px;height:38px;border-radius:8px;background:#EEF2FF;color:#4F46E5;display:flex;align-items:center;justify-content:center;font-size:1.1rem">
            📖
          </div>
          <div>
            <div style="font-size:1.05rem;font-weight:800;color:#111827;line-height:1.2">{{ $myCourses->count() }}</div>
            <div style="font-size:.68rem;color:#6B7280;font-weight:500">Total Course</div>
          </div>
        </div>
        
        {{-- Card 2: Total Siswa --}}
        <div style="background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:.7rem 1rem;display:flex;align-items:center;gap:.75rem;min-width:130px;box-shadow:0 1px 3px rgba(0,0,0,.05)">
          <div style="width:38px;height:38px;border-radius:8px;background:#ECFDF5;color:#059669;display:flex;align-items:center;justify-content:center;font-size:1.1rem">
            👥
          </div>
          <div>
            <div style="font-size:1.05rem;font-weight:800;color:#111827;line-height:1.2">
              {{ number_format($myCourses->sum(fn($c) => $c->enrollments->count())) }}
            </div>
            <div style="font-size:.68rem;color:#6B7280;font-weight:500">Total Siswa</div>
          </div>
        </div>

        {{-- Card 3: Total Video --}}
        <div style="background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:.7rem 1rem;display:flex;align-items:center;gap:.75rem;min-width:130px;box-shadow:0 1px 3px rgba(0,0,0,.05)">
          <div style="width:38px;height:38px;border-radius:8px;background:#F0FDF4;color:#15803D;display:flex;align-items:center;justify-content:center;font-size:1.1rem">
            📹
          </div>
          <div>
            <div style="font-size:1.05rem;font-weight:800;color:#111827;line-height:1.2">{{ $myCourses->sum('total_videos') }}</div>
            <div style="font-size:.68rem;color:#6B7280;font-weight:500">Total Video</div>
          </div>
        </div>

        {{-- Card 4: Total Pendapatan --}}
        @php
          $totalCourseGross = 0;
          foreach($myCourses as $c) {
            $totalCourseGross += $c->enrollments->count() * $c->price;
          }
          $programmerCourseEarning = $totalCourseGross * 0.80;
          $platformCourseFee = $totalCourseGross * 0.20;
        @endphp
        <div style="background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:.7rem 1rem;display:flex;align-items:center;gap:.75rem;min-width:180px;box-shadow:0 1px 3px rgba(0,0,0,.05)">
          <div style="width:38px;height:38px;border-radius:8px;background:#FFFBEB;color:#D97706;display:flex;align-items:center;justify-content:center;font-size:1.1rem">
            💰
          </div>
          <div>
            <div style="font-size:1.05rem;font-weight:800;color:#059669;line-height:1.2">
              Rp {{ number_format($programmerCourseEarning, 0, ',', '.') }}
            </div>
            <div style="font-size:.68rem;color:#6B7280;font-weight:700;margin-top:2px">Pendapatan Bersih Anda (80%)</div>
            <div style="font-size:.62rem;color:#9CA3AF;margin-top:2px">Komisi Platform (20%): Rp {{ number_format($platformCourseFee, 0, ',', '.') }}</div>
          </div>
        </div>
      </div>
    </div>

    {{-- BILAH PENCARIAN & FILTER COURSE SAYA --}}
    @if($myCourses->count() > 0)
    <div style="background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:.85rem 1.25rem;display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;box-shadow:0 1px 4px rgba(0,0,0,.05);margin-bottom:1.5rem">
      
      {{-- Search — icon on LEFT --}}
      <div style="position:relative;flex:2;min-width:220px">
        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9CA3AF;font-size:.85rem;pointer-events:none">🔍</span>
        <input type="text" id="progSearchCourse" oninput="filterProgrammerCourses()"
          placeholder="Cari nama course, kategori, atau keyword..."
          style="width:100%;padding:8px 14px 8px 36px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#111827;font-size:.85rem;font-family:inherit;outline:none;transition:border-color .15s;box-shadow:0 1px 3px rgba(0,0,0,.05)"
          onfocus="this.style.borderColor='#4F46E5'"
          onblur="this.style.borderColor='#E5E7EB'" />
      </div>

      {{-- Category dropdown --}}
      <div style="position:relative;min-width:150px">
        <select id="progFilterCourseCategory" onchange="filterProgrammerCourses()"
          style="width:100%;padding:8px 26px 8px 14px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#374151;font-size:.85rem;font-family:inherit;cursor:pointer;outline:none;appearance:none;box-shadow:0 1px 3px rgba(0,0,0,.05);transition:border-color .15s"
          onfocus="this.style.borderColor='#4F46E5'"
          onblur="this.style.borderColor='#E5E7EB'">
          <option value="">Semua Kategori</option>
          @foreach($myCourses->pluck('category')->unique() as $cat)
            <option value="{{ $cat }}">{{ $cat }}</option>
          @endforeach
        </select>
        <span style="position:absolute;right:9px;top:50%;transform:translateY(-50%);color:#6B7280;font-size:.65rem;pointer-events:none">▼</span>
      </div>

      {{-- Status dropdown --}}
      <div style="position:relative;min-width:150px">
        <select id="progFilterCourseStatus" onchange="filterProgrammerCourses()"
          style="width:100%;padding:8px 26px 8px 14px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#374151;font-size:.85rem;font-family:inherit;cursor:pointer;outline:none;appearance:none;box-shadow:0 1px 3px rgba(0,0,0,.05);transition:border-color .15s"
          onfocus="this.style.borderColor='#4F46E5'"
          onblur="this.style.borderColor='#E5E7EB'">
          <option value="">Semua Status</option>
          <option value="published">Dipublikasikan</option>
          <option value="draft">Draft</option>
        </select>
        <span style="position:absolute;right:9px;top:50%;transform:translateY(-50%);color:#6B7280;font-size:.65rem;pointer-events:none">▼</span>
      </div>

      {{-- Create Course Button --}}
      <a href="{{ route('programmer.create-course') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:8px;border:none;background:#4F46E5;color:#fff;font-size:.875rem;font-weight:700;cursor:pointer;font-family:inherit;white-space:nowrap;box-shadow:0 1px 4px rgba(79,70,229,.3);transition:background .15s;text-decoration:none;flex-shrink:0"
        onmouseover="this.style.background='#4338CA'" onmouseout="this.style.background='#4F46E5'">
        <span style="font-size:1.1rem;font-weight:bold;line-height:1;margin-top:-2px">+</span> Buat Course Baru
      </a>
    </div>

    {{-- Filter count status text --}}
    <div id="progCoursesSearchResultText" style="font-size:.82rem;color:#6B7280;margin:-0.75rem 0 1.25rem 0;display:none;font-weight:600;padding-left:4px">
      Menampilkan <span id="progCourseFilteredCount">0</span> dari <span id="progCourseTotalCount">0</span> course
    </div>
    @endif

    {{-- LIST COURSE --}}
    <div id="programmerCoursesContainer">
      @forelse($myCourses as $course)
      @php
        $lowerTitle = strtolower($course->title);
        $gradient = 'linear-gradient(135deg, #4F46E5, #7C3AED)';
        $logoHtml = '📚';
        $hasCustomThumb = false;
        
        $preset = $course->thumbnail;
        if (!$preset) {
            if (str_contains($lowerTitle, 'html')) { $preset = 'html'; }
            elseif (str_contains($lowerTitle, 'css')) { $preset = 'css'; }
            elseif (str_contains($lowerTitle, 'javascript') || str_contains($lowerTitle, 'js')) { $preset = 'js'; }
            elseif (str_contains($lowerTitle, 'php')) { $preset = 'php'; }
            elseif (str_contains($lowerTitle, 'mysql')) { $preset = 'mysql'; }
            elseif (str_contains($lowerTitle, 'laravel')) { $preset = 'laravel'; }
            elseif (str_contains($lowerTitle, 'react')) { $preset = 'react'; }
            elseif (str_contains($lowerTitle, 'node')) { $preset = 'node'; }
            elseif (str_contains($lowerTitle, 'flutter')) { $preset = 'flutter'; }
            elseif (str_contains($lowerTitle, 'git')) { $preset = 'git'; }
        }
        
        if ($preset && in_array($preset, ['html','css','js','php','mysql','laravel','react','node','flutter','git'])) {
            if ($preset === 'html') {
                $gradient = '#F16529';
                $logoHtml = '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:3px"><div style="font-family:\'Arial Black\', sans-serif;font-size:0.7rem;font-weight:900;color:#000;letter-spacing:1px;line-height:1;margin-top:2px">HTML</div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 452 520" width="30" height="34" style="display:block"><path fill="#e34f26" d="M41 460L0 0h451l-41 460-185 52" /><path fill="#ef652a" d="M226 472l149-41 35-394H226" /><path fill="#ecedee" d="M226 208h-75l-5-58h80V94H84l15 171h127zm0 147l-64-17-4-45h-56l7 89 117 32z"/><path fill="#fff" d="M226 265h69l-7 73-62 17v59l115-32 16-174H226zm0-171v56h136l5-56z"/></svg></div>';
            } elseif ($preset === 'css') {
                $gradient = '#2d88d3';
                $logoHtml = '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:3px"><div style="font-family:\'Arial Black\', sans-serif;font-size:0.7rem;font-weight:900;color:#000;letter-spacing:1px;line-height:1;margin-top:2px">CSS</div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 452 520" width="30" height="34" style="display:block"><path fill="#0c72b8" d="M41 460L0 0h451l-41 460-185 52" /><path fill="#1c8adb" d="M226 472l149-41 35-394H226" /><path fill="#ebebeb" d="M226 94H96l5 56h125z M226 208H161l5 57h60z M226 355H117l5 60h104z" /><path fill="#ffffff" d="M226 94h141l-5 56H226z M226 208h131l-5 57H226z M226 355h118l-5 60H226z M295 150h67l-18 205H295z" /></svg></div>';
            } elseif ($preset === 'js') {
                $gradient = 'linear-gradient(135deg, #F0DB4F, #F7DF1E)';
                $logoHtml = '<span style="font-family: Arial Black, sans-serif; font-size: 2rem; font-weight: 900; color: #323330; display:block; line-height:1">JS</span>';
            } elseif ($preset === 'php') {
                $gradient = 'linear-gradient(135deg, #4F5D95, #777BB4)';
                $logoHtml = '<span style="font-family: Impact, sans-serif; font-size: 1.8rem; font-style: italic; color: #fff; text-shadow: 1px 1px 3px rgba(0,0,0,0.3); display:block; line-height:1">php</span>';
            } elseif ($preset === 'mysql') {
                $gradient = 'linear-gradient(135deg, #00758F, #005E74)';
                $logoHtml = '<span style="font-family: Inter, sans-serif; font-size: 1.35rem; font-weight: 800; color: #fff; letter-spacing: -1px; display:block; line-height:1">MySQL</span>';
            } elseif ($preset === 'laravel') {
                $gradient = 'linear-gradient(135deg, #FF2E2E, #E31B1B)';
                $logoHtml = '<svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>';
            } elseif ($preset === 'react') {
                $gradient = 'linear-gradient(135deg, #20232A, #282C34)';
                $logoHtml = '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#61DAFB" stroke-width="2" style="display:block"><ellipse cx="12" cy="12" rx="10" ry="4.5" transform="rotate(0 12 12)"/><ellipse cx="12" cy="12" rx="10" ry="4.5" transform="rotate(60 12 12)"/><ellipse cx="12" cy="12" rx="10" ry="4.5" transform="rotate(120 12 12)"/><circle cx="12" cy="12" r="2" fill="#61DAFB"/></svg>';
            } elseif ($preset === 'node') {
                $gradient = 'linear-gradient(135deg, #303030, #43853D)';
                $logoHtml = '<span style="font-family: Arial, sans-serif; font-size: 1.4rem; font-weight: 800; color: #fff; display:block; line-height:1">node</span>';
            } elseif ($preset === 'flutter') {
                $gradient = 'linear-gradient(135deg, #02569B, #0175C2)';
                $logoHtml = '<svg width="34" height="34" viewBox="0 0 24 24" fill="#fff" style="display:block"><path d="M14.314 0L2.3 12 6 15.7 21.684 0h-7.37zM21.684 12.329l-3.685-3.686L6 20.329l3.7 3.671 11.984-11.671z"/></svg>';
            } elseif ($preset === 'git') {
                $gradient = 'linear-gradient(135deg, #F1502F, #F05133)';
                $logoHtml = '<span style="font-family: Arial, sans-serif; font-size: 1.8rem; font-weight: 800; color: #fff; display:block; line-height:1">git</span>';
            }
        } elseif ($course->thumbnail) {
            $hasCustomThumb = true;
            $thumbUrl = str_starts_with($course->thumbnail, 'http') ? $course->thumbnail : asset('storage/' . $course->thumbnail);
        }
      @endphp
      <div class="prog-course-card" style="position:relative;background:#fff;border:1px solid #E5E7EB;border-radius:16px;padding:1.25rem;margin-bottom:1rem;display:flex;gap:1.5rem;align-items:center;box-shadow:0 1px 3px rgba(0,0,0,.04);transition:transform .15s, box-shadow .15s"
        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 4px 12px rgba(0,0,0,.05)'"
        onmouseout="this.style.transform='none';this.style.boxShadow='0 1px 3px rgba(0,0,0,.04)'"
        data-title="{{ strtolower($course->title) }}"
        data-category="{{ $course->category }}"
        data-status="{{ $course->is_published ? 'published' : 'draft' }}">
        
        {{-- Left: Thumbnail --}}
        <div style="width:110px;height:82px;border-radius:12px;background:{!! $hasCustomThumb ? 'transparent' : $gradient !!};flex-shrink:0;display:flex;align-items:center;justify-content:center;box-shadow:inset 0 0 10px rgba(0,0,0,0.1);position:relative;overflow:hidden">
          @if($hasCustomThumb)
            <img src="{{ $thumbUrl }}" alt="{{ $course->title }}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit">
          @else
            {!! $logoHtml !!}
          @endif
        </div>

        {{-- Middle: Info --}}
        <div style="flex:1;min-width:0">
          <div style="display:flex;gap:.5rem;margin-bottom:.4rem;flex-wrap:wrap">
            {{-- Level badge --}}
            @php
              $lvlBg = '#ECFDF5'; $lvlColor = '#059669';
              if($course->level === 'menengah') { $lvlBg = '#FFF7ED'; $lvlColor = '#C2410C'; }
              elseif($course->level === 'mahir') { $lvlBg = '#FEF2F2'; $lvlColor = '#DC2626'; }
            @endphp
            <span style="font-size:.68rem;font-weight:700;padding:3px 9px;border-radius:99px;background:{{ $lvlBg }};color:{{ $lvlColor }};text-transform:uppercase;letter-spacing:0.5px">
              {{ $course->level_label }}
            </span>
            {{-- Status badge --}}
            @if($course->is_published)
              <span style="font-size:.68rem;font-weight:700;padding:3px 9px;border-radius:99px;background:#ECFDF5;color:#059669;text-transform:uppercase;letter-spacing:0.5px">
                Dipublikasikan
              </span>
            @else
              <span style="font-size:.68rem;font-weight:700;padding:3px 9px;border-radius:99px;background:#F3F4F6;color:#6B7280;text-transform:uppercase;letter-spacing:0.5px">
                Draft
              </span>
            @endif
          </div>
          
          <h3 style="font-size:1.02rem;font-weight:800;color:#111827;margin:0 0 .4rem;line-height:1.4">
            {{ $course->title }}
          </h3>
          
          {{-- Metadata --}}
          <div style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;font-size:.76rem;color:#6B7280">
            <span style="color:#F59E0B;font-weight:600;display:inline-flex;align-items:center;gap:3px">
              ⭐ {{ number_format($course->rating ?: 0.0, 1) }}
            </span>
            <span>•</span>
            <span style="display:inline-flex;align-items:center;gap:4px">
              👥 {{ number_format($course->enrollments->count()) }} siswa
            </span>
            <span>•</span>
            <span style="display:inline-flex;align-items:center;gap:4px">
              📹 {{ $course->total_videos }} video
            </span>
            <span>•</span>
            <span style="display:inline-flex;align-items:center;gap:4px">
              ⏱️ {{ $course->duration }}
            </span>
          </div>
        </div>

        {{-- Right Side: Price & Actions --}}
        <div style="display:flex;align-items:center;gap:2rem;flex-shrink:0;text-align:right">
          
          {{-- Price --}}
          <div style="display:flex;flex-direction:column;align-items:flex-end;gap:.25rem">
            <div style="font-size:1.15rem;font-weight:800;color:#4F46E5">
              {{ $course->price_formatted }}
            </div>
            @if(!$course->is_free && $course->price > 0)
              <div style="font-size:.73rem;font-weight:600;color:#059669">Bagi Hasil Anda: Rp {{ number_format($course->price * 0.80, 0, ',', '.') }} (80%)</div>
              <div style="font-size:.65rem;color:#6B7280">Komisi Platform (20%): Rp {{ number_format($course->price * 0.20, 0, ',', '.') }}</div>
            @endif
          </div>

          {{-- Dropdown Action Menu (matches image) --}}
          <div style="position:relative" class="prog-course-dropdown-container">
            <button type="button" onclick="toggleCourseDropdown(event, {{ $course->id }})"
              style="width:36px;height:36px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#6B7280;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.1rem;transition:background .15s;outline:none"
              onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='#fff'"
              aria-label="Aksi kursus {{ $course->title }}">
              •••
            </button>
            
            {{-- Dropdown Card --}}
            <div id="prog-course-dropdown-{{ $course->id }}" class="prog-course-dropdown-menu"
              style="display:none;position:absolute;right:0;top:110%;width:160px;background:#fff;border:1px solid #E5E7EB;border-radius:10px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);z-index:100;padding:.35rem;text-align:left">
              
              {{-- Preview --}}
              <a href="{{ route('courses.detail', $course) }}"
                style="display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:6px;color:#374151;font-size:.8rem;font-weight:600;text-decoration:none;transition:background .15s"
                onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">
                👁️ <span style="margin-left:2px">Preview</span>
              </a>
              
              {{-- Edit Course --}}
              <a href="{{ route('programmer.course.edit', $course) }}"
                style="display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:6px;color:#374151;font-size:.8rem;font-weight:600;text-decoration:none;transition:background .15s"
                onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">
                ✏️ <span style="margin-left:2px">Edit Course</span>
              </a>

              <div style="height:1px;background:#F3F4F6;margin:4px 0"></div>

              {{-- Hapus Course --}}
              <form method="POST" action="{{ route('programmer.course.delete', $course) }}"
                onsubmit="return confirm('Hapus course ini beserta seluruh video materinya?')"
                style="margin:0">
                @csrf @method('DELETE')
                <button type="submit"
                  style="width:100%;display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:6px;color:#EF4444;font-size:.8rem;font-weight:600;background:none;border:none;cursor:pointer;text-align:left;font-family:inherit;transition:background .15s"
                  onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'">
                  🗑️ <span style="margin-left:2px">Hapus Course</span>
                </button>
              </form>
            </div>
          </div>

        </div>
      </div>
      @empty
      <div style="text-align:center;padding:4rem 2rem;background:#fff;border-radius:16px;border:1px solid #E5E7EB">
        <div style="font-size:3rem;margin-bottom:1rem">📚</div>
        <h3 style="font-size:1.1rem;font-weight:700;color:#374151;margin-bottom:.35rem">Belum ada course</h3>
        <p style="font-size:.85rem;color:#9CA3AF">Buat course pertama Anda dan bagikan pengetahuan kepada para programmer muda!</p>
      </div>
      @endforelse
    </div>
  </div>



  <!-- VERIFY TAB -->
  <div id="pane-verify" style="display:none" role="tabpanel">
    <div class="card">
      <div class="card-header"><span class="card-title">🏅 Badge & Status Verifikasi</span></div>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem">
        @foreach([['✅ Terverifikasi', $user->is_verified, '#ECFDF5', '#059669'],['🏆 Top Programmer', $user->is_top_programmer, '#FFF7ED', '#C2410C'],['💎 Pemateri', $user->is_top_programmer, '#EDE9FE', '#6D28D9']] as [$b, $has, $bg, $c])
        <div style="border:1px solid var(--border);border-radius:var(--radius);padding:1rem;text-align:center;opacity:{{ $has ? '1' : '.5' }}">
          <div style="font-size:.82rem;font-weight:600;padding:3px 9px;border-radius:99px;background:{{ $bg }};color:{{ $c }};display:inline-block;margin-bottom:.4rem">{{ $b }}</div>
          <div style="font-size:.75rem;color:var(--text3)">{{ $has ? 'Aktif ✓' : 'Belum' }}</div>
        </div>
        @endforeach
      </div>

      <!-- 0. BIO & SKILLS -->
      <h4 style="font-size:.9rem;font-weight:700;margin-bottom:.75rem">📝 Bio & Keahlian</h4>
      <form method="POST" action="{{ route('programmer.profile.update') }}" style="margin-bottom:1.5rem">
        @csrf
        <div class="form-group" style="margin-bottom:.75rem">
          <label style="display:block;font-size:.78rem;font-weight:600;margin-bottom:.25rem;color:var(--text2)">Bio / Deskripsi Diri</label>
          <textarea name="bio" class="form-textarea" placeholder="Ceritakan tentang keahlian dan pengalaman Anda..." required style="min-height:80px">{{ $user->bio }}</textarea>
        </div>
        <div class="form-group" style="margin-bottom:.75rem">
          <label style="display:block;font-size:.78rem;font-weight:600;margin-bottom:.25rem;color:var(--text2)">Keahlian (pisahkan dengan koma)</label>
          <input name="expertise" class="form-input" placeholder="Contoh: Laravel, React, Vue, Python" value="{{ $user->expertise }}">
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Simpan Profil 💾</button>
      </form>
      
      <!-- Scanner Style -->
      <style>
      .scanner-line {
        position: absolute;
        left: 10px;
        right: 10px;
        height: 3px;
        background: rgba(239, 68, 68, 0.7);
        box-shadow: 0 0 8px rgba(239, 68, 68, 0.9);
        animation: scanAnim 2.5s linear infinite;
        z-index: 10;
        pointer-events: none;
      }

      @keyframes scanAnim {
        0% { top: 10px; }
        50% { top: calc(100% - 65px); }
        100% { top: 10px; }
      }
      </style>

      <hr style="margin:1.5rem 0;border:none;border-top:1px solid var(--border)">

      <!-- 1. PORTOFOLIO -->
      <h4 style="font-size:.9rem;font-weight:700;margin-bottom:.75rem">🗂 Portofolio ({{ $portfolios->count() }})</h4>
      @forelse($portfolios as $p)
      <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem;border:1px solid var(--border);border-radius:var(--radius);margin-bottom:.5rem;background:var(--bg2)">
        <div style="width:36px;height:36px;background:var(--primary-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:.8rem;flex-shrink:0">&lt;/&gt;</div>
        <div style="flex:1">
          <div style="font-size:.9rem;font-weight:600">{{ $p->title }}</div>
          <div style="font-size:.78rem;color:var(--text3)">{{ Str::limit($p->description, 60) }}</div>
          <div class="tag-list" style="margin-top:.25rem">@foreach(($p->tags ?? []) as $tag)<span class="tag">{{ $tag }}</span>@endforeach</div>
          @if($p->portfolio_file)
            <div style="font-size:.78rem;margin-top:5px;display:flex;align-items:center;gap:4px">
              <span>📷</span> <a href="{{ asset('storage/' . $p->portfolio_file) }}" target="_blank" style="color:var(--primary);text-decoration:underline;font-weight:600">Lihat Lampiran / Scan</a>
            </div>
          @endif
          @if($p->status === 'pending')
          <div style="font-size:.78rem;color:var(--accent);font-weight:600;margin-top:6px">⚠️ portofolio sedang ditinjau admin, tunggu 1x24 jam</div>
          @elseif($p->status === 'rejected')
          <div style="font-size:.78rem;color:var(--red);font-weight:600;margin-top:6px">❌ portofolio ditolak admin</div>
          @elseif($p->status === 'approved')
          <div style="font-size:.78rem;color:var(--green);font-weight:600;margin-top:6px">✅ portofolio telah disetujui admin</div>
          @endif
        </div>
        <div style="display:flex;gap:.25rem;align-items:center">
          <button onclick="openEditPortfolioModal({{ $p->id }}, '{{ addslashes($p->title) }}', '{{ addslashes($p->description) }}', '{{ addslashes(implode(', ', $p->tags ?? [])) }}', '{{ addslashes($p->project_url) }}')" class="btn btn-ghost btn-sm" aria-label="Edit portofolio {{ $p->title }}">✏️</button>
          <form method="POST" action="{{ route('programmer.portfolio.delete', $p) }}" onsubmit="return confirm('Hapus portofolio ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-ghost btn-sm" aria-label="Hapus portofolio {{ $p->title }}">🗑</button>
          </form>
        </div>
      </div>
      @empty
      <p style="color:var(--text3);font-size:.875rem">Belum ada portofolio. Tambahkan portofolio pertama Anda!</p>
      @endforelse

      <hr style="margin:1rem 0;border:none;border-top:1px solid var(--border)">
      <h4 style="font-size:.9rem;font-weight:700;margin-bottom:.75rem">+ Tambah Portofolio Baru</h4>
      <form method="POST" action="{{ route('programmer.portfolio.store') }}" enctype="multipart/form-data" aria-label="Form tambah portofolio">
        @csrf
        <div class="form-group"><input name="title" class="form-input" placeholder="Judul project" required aria-label="Judul portofolio"></div>
        <div class="form-group"><textarea name="description" class="form-textarea" placeholder="Deskripsi singkat project..." required aria-label="Deskripsi portofolio"></textarea></div>
        <div class="form-group"><input name="tags" class="form-input" placeholder="Tags (pisahkan koma): React, Laravel..." aria-label="Tags portofolio"><div class="form-hint">Contoh: React, Laravel, MySQL</div></div>
        <div class="form-group"><input name="project_url" type="url" class="form-input" placeholder="Link project (opsional)" aria-label="URL portofolio"></div>
        
        <div class="form-group" style="margin-bottom:1.5rem">
          <label style="display:block;font-size:.78rem;font-weight:600;margin-bottom:.35rem;color:var(--text2)">Lampiran Portofolio / Hasil Scan (Opsional)</label>
          <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <input type="file" name="portfolio_file" class="form-input" style="flex:1" accept="image/*,application/pdf">
            <button type="button" class="btn btn-sm btn-ghost" onclick="startCameraScan('portfolio')" style="border-color:var(--primary);color:var(--primary);background:var(--primary-light);font-weight:600">📷 Scan dengan Kamera</button>
          </div>
          <!-- Hidden field to store base64 camera image -->
          <input type="hidden" name="portfolio_camera" id="portfolio_camera_input">
          <div id="portfolio_camera_preview_container" style="display:none;margin-top:10px;border:2px dashed var(--primary);border-radius:var(--radius);padding:10px;background:var(--bg2);position:relative;text-align:center">
            <video id="portfolio_video" width="100%" style="max-height:280px;border-radius:var(--radius-sm);background:#000" autoplay playsinline></video>
            <div id="portfolio_scanner_line" class="scanner-line"></div>
            <div style="margin-top:10px;display:flex;gap:10px;justify-content:center">
              <button type="button" class="btn btn-sm btn-primary" onclick="captureSnapshot('portfolio')">📸 Ambil Foto (Scan)</button>
              <button type="button" class="btn btn-sm btn-ghost" style="color:var(--red);border-color:var(--red)" onclick="stopCameraScan('portfolio')">Tutup ❌</button>
            </div>
          </div>
          <div id="portfolio_scanned_preview" style="display:none;margin-top:10px;text-align:center;position:relative">
            <p style="font-size:.8rem;color:var(--green);font-weight:700;margin-bottom:5px">✓ Berhasil di-scan!</p>
            <img id="portfolio_scanned_img" style="max-width:100%;max-height:200px;border-radius:var(--radius);border:1.5px solid var(--border)">
            <button type="button" class="btn btn-xs btn-ghost" style="color:var(--red);border-color:var(--red);margin-top:5px;display:block;margin-left:auto;margin-right:auto" onclick="clearCameraScan('portfolio')">Hapus Scan 🗑</button>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-sm" style="margin-bottom:1.5rem">Simpan Portofolio ✅</button>
      </form>

      <hr style="margin:1.5rem 0;border:none;border-top:1px solid var(--border)">

      <!-- 2. SERTIFIKAT -->
      <h4 style="font-size:.9rem;font-weight:700;margin-bottom:.5rem">📜 Sertifikat ({{ $certificates->count() }})</h4>
      @if($certificates->count() > 0)
        <p style="color:var(--green);font-size:.875rem;font-weight:700;margin-bottom:1rem">Mempunyai {{ $certificates->count() }} Sertifikat</p>
      @endif
      @forelse($certificates as $cert)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem;background:var(--bg2);border-radius:var(--radius);margin-bottom:.5rem">
        <div>
          <div style="font-size:.875rem;font-weight:600">{{ $cert->name }}</div>
          <div style="font-size:.78rem;color:var(--text3)">{{ $cert->issuer }} · {{ $cert->issue_date?->format('M Y') }}</div>
          @if($cert->certificate_file)
            <div style="font-size:.78rem;margin-top:5px;display:flex;align-items:center;gap:4px">
              <span>📷</span> <a href="{{ asset('storage/' . $cert->certificate_file) }}" target="_blank" style="color:var(--primary);text-decoration:underline;font-weight:600">Lihat Lampiran / Scan</a>
            </div>
          @endif
          @if($cert->status === 'pending')
          <div style="font-size:.78rem;color:var(--accent);font-weight:600;margin-top:6px">⚠️ sertifikat sedang ditinjau admin, tunggu 1x24 jam</div>
          @elseif($cert->status === 'rejected')
          <div style="font-size:.78rem;color:var(--red);font-weight:600;margin-top:6px">❌ sertifikat ditolak admin</div>
          @elseif($cert->status === 'approved')
          <div style="font-size:.78rem;color:var(--green);font-weight:600;margin-top:6px">✅ sertifikat telah disetujui admin</div>
          @endif
        </div>
        <div style="display:flex;align-items:center;gap:.5rem">
          <form method="POST" action="{{ route('programmer.certificate.delete', $cert) }}" onsubmit="return confirm('Hapus sertifikat ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--red);padding:2px 6px;font-size:.8rem" aria-label="Hapus sertifikat {{ $cert->name }}">🗑 Hapus</button>
          </form>
          <span style="font-size:.7rem;font-weight:600;padding:3px 9px;border-radius:99px;background:#ECFDF5;color:#059669">✓</span>
        </div>
      </div>
      @empty
      <p style="color:var(--text3);font-size:.875rem">Belum ada sertifikat.</p>
      @endforelse

      <hr style="margin:1rem 0;border:none;border-top:1px solid var(--border)">
      <h4 style="font-size:.9rem;font-weight:700;margin-bottom:.75rem">+ Tambah Sertifikat</h4>
      <form method="POST" action="{{ route('programmer.certificate.store') }}" enctype="multipart/form-data" aria-label="Form tambah sertifikat">
        @csrf
        <div class="form-row">
          <div class="form-group"><input name="name" class="form-input" placeholder="Nama sertifikat" required aria-label="Nama sertifikat"></div>
          <div class="form-group"><input name="issuer" class="form-input" placeholder="Penerbit (contoh: Google)" required aria-label="Penerbit sertifikat"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><input name="issue_date" type="date" class="form-input" aria-label="Tanggal sertifikat"></div>
          <div class="form-group"><input name="credential_url" type="url" class="form-input" placeholder="URL verifikasi (opsional)" aria-label="URL sertifikat"></div>
        </div>
        
        <div class="form-group" style="margin-bottom:1.5rem">
          <label style="display:block;font-size:.78rem;font-weight:600;margin-bottom:.35rem;color:var(--text2)">Lampiran Sertifikat / Hasil Scan (Opsional)</label>
          <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <input type="file" name="certificate_file" class="form-input" style="flex:1" accept="image/*,application/pdf">
            <button type="button" class="btn btn-sm btn-ghost" onclick="startCameraScan('certificate')" style="border-color:var(--primary);color:var(--primary);background:var(--primary-light);font-weight:600">📷 Scan dengan Kamera</button>
          </div>
          <!-- Hidden field to store base64 camera image -->
          <input type="hidden" name="certificate_camera" id="certificate_camera_input">
          <div id="certificate_camera_preview_container" style="display:none;margin-top:10px;border:2px dashed var(--primary);border-radius:var(--radius);padding:10px;background:var(--bg2);position:relative;text-align:center">
            <video id="certificate_video" width="100%" style="max-height:280px;border-radius:var(--radius-sm);background:#000" autoplay playsinline></video>
            <div id="certificate_scanner_line" class="scanner-line"></div>
            <div style="margin-top:10px;display:flex;gap:10px;justify-content:center">
              <button type="button" class="btn btn-sm btn-primary" onclick="captureSnapshot('certificate')">📸 Ambil Foto (Scan)</button>
              <button type="button" class="btn btn-sm btn-ghost" style="color:var(--red);border-color:var(--red)" onclick="stopCameraScan('certificate')">Tutup ❌</button>
            </div>
          </div>
          <div id="certificate_scanned_preview" style="display:none;margin-top:10px;text-align:center;position:relative">
            <p style="font-size:.8rem;color:var(--green);font-weight:700;margin-bottom:5px">✓ Berhasil di-scan!</p>
            <img id="certificate_scanned_img" style="max-width:100%;max-height:200px;border-radius:var(--radius);border:1.5px solid var(--border)">
            <button type="button" class="btn btn-xs btn-ghost" style="color:var(--red);border-color:var(--red);margin-top:5px;display:block;margin-left:auto;margin-right:auto" onclick="clearCameraScan('certificate')">Hapus Scan 🗑</button>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-sm" style="margin-bottom:1.5rem">Simpan Sertifikat ✅</button>
      </form>
    </div>
  </div>
</div>

<!-- IMK: Bid Modal - clear form with context about project -->
<div id="bidModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;display:none;align-items:center;justify-content:center;padding:1rem">
  <div style="background:var(--bg);border-radius:var(--radius-xl);padding:2rem;max-width:480px;width:100%;max-height:90vh;overflow-y:auto">
    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:.25rem">Ajukan Penawaran</h3>
    <p id="bidProjectTitle" style="font-size:.85rem;color:var(--text2);margin-bottom:1.25rem"></p>
    <form id="bidForm" method="POST" aria-label="Form ajukan penawaran">
      @csrf
      <div class="form-group">
        <label class="form-label">Jumlah Penawaran <span class="required">*</span></label>
        <!-- IMK: Pre-fill with project budget as suggestion -->
        <input type="number" name="amount" id="bidAmount" class="form-input" placeholder="Rp" required aria-label="Jumlah penawaran dalam rupiah">
        <div id="bidEarning" class="form-hint" style="color:var(--green)"></div>
      </div>
      <div class="form-group">
        <label class="form-label">Estimasi Waktu (hari) <span class="required">*</span></label>
        <input type="number" name="timeline_days" class="form-input" placeholder="Contoh: 30" min="1" max="365" required aria-label="Estimasi waktu pengerjaan">
      </div>
      <div class="form-group">
        <label class="form-label">Pesan untuk UMKM <span class="required">*</span></label>
        <textarea name="message" class="form-textarea" placeholder="Jelaskan pengalaman relevan Anda, pendekatan pengerjaan, dan mengapa Anda cocok untuk project ini (minimal 20 karakter)..." required minlength="20" aria-label="Pesan penawaran"></textarea>
        <div class="form-hint">Pesan yang detail meningkatkan peluang diterima</div>
      </div>
      <div style="display:flex;gap:.75rem">
        <button type="submit" class="btn btn-primary" style="flex:1">Kirim Penawaran ✅</button>
        <button type="button" onclick="closeBidModal()" class="btn btn-ghost" aria-label="Batal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Bid Modal -->
<div id="editBidModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;padding:1rem">
  <div style="background:var(--bg);border-radius:var(--radius-xl);padding:2rem;max-width:480px;width:100%;max-height:90vh;overflow-y:auto">
    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:.25rem">✏️ Ubah Penawaran</h3>
    <p id="editBidProjectTitle" style="font-size:.85rem;color:var(--text2);margin-bottom:1.25rem"></p>
    <form id="editBidForm" method="POST" aria-label="Form ubah penawaran">
      @csrf
      <div class="form-group">
        <label class="form-label">Jumlah Penawaran <span class="required">*</span></label>
        <input type="number" name="amount" id="editBidAmount" class="form-input" placeholder="Rp" required aria-label="Jumlah penawaran dalam rupiah">
        <div id="editBidEarning" class="form-hint" style="color:var(--green)"></div>
      </div>
      <div class="form-group">
        <label class="form-label">Estimasi Waktu (hari) <span class="required">*</span></label>
        <input type="number" name="timeline_days" id="editBidTimeline" class="form-input" required aria-label="Estimasi waktu pengerjaan" min="1">
      </div>
      <div class="form-group">
        <label class="form-label">Pesan untuk UMKM <span class="required">*</span></label>
        <textarea name="message" id="editBidMessage" class="form-textarea" placeholder="Tuliskan pesan..." required minlength="20" aria-label="Pesan penawaran"></textarea>
      </div>
      <div style="display:flex;gap:.75rem">
        <button type="submit" class="btn btn-primary" style="flex:1">Simpan Perubahan ✅</button>
        <button type="button" onclick="closeEditBidModal()" class="btn btn-ghost" aria-label="Batal">Batal</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function showTab(name){
  ['overview','projects','courses','verify'].forEach(t=>{
    const p = document.getElementById('pane-'+t);
    const tb = document.getElementById('tab-'+t);
    if(p) p.style.display = 'none';
    if(tb) {
      tb.classList.remove('active');
      tb.setAttribute('aria-selected','false');
    }
  });
  const ap = document.getElementById('pane-'+name);
  const atb = document.getElementById('tab-'+name);
  if(ap) ap.style.display = 'block';
  if(atb) {
    atb.classList.add('active');
    atb.setAttribute('aria-selected','true');
  }
  history.replaceState(null,'','#'+name);
  if(window.checkMascotVisibility) window.checkMascotVisibility(name);
}

// IMK: Restore tab from URL hash & support real-time search from notifications
const allowedTabs = [
  'overview',
  'projects',
  'courses',
  'verify'
];

function handleProgrammerUrlState() {
  const hash = location.hash.replace('#','');
  
  // Baca parameter pencarian dari query string jika ada
  const urlParams = new URLSearchParams(window.location.search);
  const searchQuery = urlParams.get('search');
  const categoryQuery = urlParams.get('category');
  const appTypeQuery = urlParams.get('app_type');
  const pageQuery = urlParams.get('page');
  
  if (searchQuery || categoryQuery || appTypeQuery || pageQuery) {
    showTab('projects');
    if (searchQuery) {
      // Highlight project card yang sesuai jika ada search spesifik dari notifikasi
      setTimeout(() => {
        const queryLower = searchQuery.toLowerCase().trim();
        const cards = document.querySelectorAll('.programmer-project-card');
        let foundCard = null;
        
        cards.forEach(card => {
          const title = (card.getAttribute('data-title') || '').toLowerCase();
          if (title.includes(queryLower)) {
            foundCard = card;
          }
        });
        
        if (foundCard) {
          foundCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
          foundCard.style.transition = 'all 0.3s ease';
          foundCard.style.borderColor = 'var(--primary)';
          foundCard.style.boxShadow = '0 0 30px rgba(79, 70, 229, 0.6)';
          foundCard.style.transform = 'scale(1.03)';
          
          setTimeout(() => {
            foundCard.style.boxShadow = '';
            foundCard.style.transform = '';
          }, 4000);
        }
      }, 300);
    }
  } else if (hash && allowedTabs.includes(hash)) {
    showTab(hash);
  } else {
    showTab('overview');
  }
}

// Dengarkan event load dan perubahan hash
window.addEventListener('load', handleProgrammerUrlState);
window.addEventListener('hashchange', handleProgrammerUrlState);

let bidProjectId, bidBudget;
function openBidModal(id, title, budget, daysRemaining){
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.setProperty('display', 'none', 'important');
  bidProjectId = id; bidBudget = budget;
  document.getElementById('bidProjectTitle').textContent = title;
  document.getElementById('bidAmount').value = budget > 0 ? budget : '';
  
  // Set max limit and placeholder for timeline_days input dynamically
  const timelineInput = document.querySelector('#bidModal input[name="timeline_days"]');
  if (timelineInput) {
    timelineInput.max = daysRemaining;
    timelineInput.placeholder = `Maksimal ${daysRemaining} hari`;
  }

  updateEarning();
  document.getElementById('bidModal').style.display = 'flex';
  document.getElementById('bidForm').action = `${window.APP_URL}/programmer/projects/${id}/bid`;
}
function closeBidModal(){ 
  document.getElementById('bidModal').style.display = 'none'; 
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.removeProperty('display');
  if(window.checkMascotVisibility) window.checkMascotVisibility();
}
function updateEarning(){
  const v = parseFloat(document.getElementById('bidAmount').value) || 0;
  document.getElementById('bidEarning').textContent = v > 0 ? `Estimasi Anda terima (20%): Rp ${(v*0.2).toLocaleString('id-ID')}` : '';
}
document.getElementById('bidAmount')?.addEventListener('input', updateEarning);
// Close modal on backdrop click
document.getElementById('bidModal')?.addEventListener('click', e=>{ if(e.target===e.currentTarget) closeBidModal(); });

// ===== EDIT BID SYSTEM =====
function openEditBidModal(bidId, amount, timelineDays, message, projectTitle, daysRemaining) {
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.setProperty('display', 'none', 'important');
  document.getElementById('editBidProjectTitle').textContent = projectTitle;
  document.getElementById('editBidAmount').value = amount;
  document.getElementById('editBidTimeline').value = timelineDays;
  
  const timelineInput = document.getElementById('editBidTimeline');
  if (timelineInput) {
    timelineInput.max = daysRemaining;
    timelineInput.placeholder = `Maksimal ${daysRemaining} hari`;
  }
  
  document.getElementById('editBidMessage').value = message;
  
  updateEditBidEarning();
  
  document.getElementById('editBidForm').action = `${window.APP_URL}/programmer/bid/${bidId}/update`;
  document.getElementById('editBidModal').style.display = 'flex';
}
function closeEditBidModal() {
  document.getElementById('editBidModal').style.display = 'none';
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.removeProperty('display');
  if(window.checkMascotVisibility) window.checkMascotVisibility();
}
function updateEditBidEarning() {
  const v = parseFloat(document.getElementById('editBidAmount').value) || 0;
  document.getElementById('editBidEarning').textContent = v > 0 ? `Estimasi Anda terima (20%): Rp ${(v*0.2).toLocaleString('id-ID')}` : '';
}
document.getElementById('editBidAmount')?.addEventListener('input', updateEditBidEarning);
document.getElementById('editBidModal')?.addEventListener('click', e => { if (e.target === e.currentTarget) closeEditBidModal(); });

// ===== CHAT / NEGOTIATION SYSTEM (Programmer side) =====
let chatProjectId = null, chatReceiverId = null, chatPollInterval = null;
function openChat(projectId, receiverId, receiverName, role) {
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.setProperty('display', 'none', 'important');
  chatProjectId = projectId; chatReceiverId = receiverId;
  document.getElementById('chatReceiverName').textContent = '\ud83d\udcac Chat dengan ' + receiverName;
  document.getElementById('chatModal').style.display = 'flex';
  document.getElementById('chatMessages').innerHTML = '<div style="text-align:center;color:rgba(255,255,255,.4);font-size:.8rem;padding:1rem">Memuat percakapan...</div>';
  loadMessages(role);
  if (chatPollInterval) clearInterval(chatPollInterval);
  chatPollInterval = setInterval(() => loadMessages(role), 4000);
}
function loadMessages(role) {
  const url = window.APP_URL + '/' + (role === 'umkm' ? 'umkm' : 'programmer') + '/project/' + chatProjectId + '/messages';
  fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
    .then(r => r.json()).then(msgs => {
      const box = document.getElementById('chatMessages');
      if (!msgs.length) { box.innerHTML = '<div style="text-align:center;color:rgba(255,255,255,.4);font-size:.8rem;padding:2rem">Belum ada pesan. Mulai negosiasi!</div>'; return; }
      box.innerHTML = msgs.map(m => `
        <div style="display:flex;flex-direction:column;align-items:${m.is_me?'flex-end':'flex-start'};margin-bottom:.75rem">
          <div style="font-size:.7rem;color:rgba(255,255,255,.4);margin-bottom:2px">${m.sender} \u00b7 ${m.created_at}</div>
          <div style="max-width:75%;padding:.6rem .9rem;border-radius:${m.is_me?'14px 14px 4px 14px':'14px 14px 14px 4px'};background:${m.is_me?'var(--primary)':'rgba(255,255,255,.1)'};color:#fff;font-size:.875rem;line-height:1.5">${m.message.replace(/</g,'&lt;')}</div>
        </div>`).join('');
      box.scrollTop = box.scrollHeight;
    }).catch(() => {});
}
function sendChatMessage(role) {
  const input = document.getElementById('chatInput');
  const msg = input.value.trim(); if (!msg) return;
  const url = window.APP_URL + '/' + (role === 'umkm' ? 'umkm' : 'programmer') + '/project/' + chatProjectId + '/message';
  const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
  fetch(url, { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':token,'Accept':'application/json'}, body:JSON.stringify({message:msg,receiver_id:chatReceiverId}) })
    .then(r => r.json()).then(data => { if(data.ok){input.value='';loadMessages(role);} else alert(data.error||'Gagal.'); })
    .catch(() => alert('Gagal mengirim.'));
}
function closeChat() { document.getElementById('chatModal').style.display='none'; if(chatPollInterval) clearInterval(chatPollInterval); chatPollInterval=null; location.reload(); }
document.getElementById('chatInput')?.addEventListener('keydown', e=>{ if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();sendChatMessage('programmer');} });

// ===== PORTFOLIO EDIT SYSTEM =====
function openEditPortfolioModal(id, title, description, tags, projectUrl) {
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.setProperty('display', 'none', 'important');
  const form = document.getElementById('editPortfolioForm');
  form.action = window.APP_URL + '/programmer/portfolio/' + id;
  document.getElementById('editPortTitle').value = title;
  document.getElementById('editPortDesc').value = description;
  document.getElementById('editPortTags').value = tags;
  document.getElementById('editPortUrl').value = projectUrl;
  document.getElementById('editPortfolioModal').style.display = 'flex';
}
function closeEditPortfolioModal() {
  document.getElementById('editPortfolioModal').style.display = 'none';
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.removeProperty('display');
  if(window.checkMascotVisibility) window.checkMascotVisibility();
}

// Real-time filtering project untuk Programmer
function filterProgrammerProjects() {
  const query = document.getElementById('progSearchProject').value.toLowerCase().trim();
  const category = document.getElementById('progFilterCategory').value;
  const appType = document.getElementById('progFilterAppType').value;
  
  const cards = document.querySelectorAll('.programmer-project-card');
  const resultText = document.getElementById('progProjectsSearchResultText');
  const filteredCountEl = document.getElementById('progFilteredCount');
  const totalCountEl = document.getElementById('progTotalCount');
  
  let visibleCount = 0;
  
  cards.forEach(card => {
    const title = card.getAttribute('data-title') || '';
    const desc = card.getAttribute('data-desc') || '';
    const tags = card.getAttribute('data-tags') || '';
    const cardCategory = card.getAttribute('data-category') || '';
    const cardAppType = card.getAttribute('data-apptype') || '';
    
    const matchesQuery = title.includes(query) || desc.includes(query) || tags.includes(query);
    const matchesCategory = category === '' || cardCategory === category;
    const matchesAppType = appType === '' || cardAppType === appType;
    
    if (matchesQuery && matchesCategory && matchesAppType) {
      card.style.display = 'block';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });
  
  totalCountEl.textContent = cards.length;
  filteredCountEl.textContent = visibleCount;
  
  if (query !== '' || category !== '' || appType !== '') {
    resultText.style.display = 'block';
  } else {
    resultText.style.display = 'none';
  }
}

// Real-time filtering course untuk Programmer
function filterProgrammerCourses() {
  const query = document.getElementById('progSearchCourse').value.toLowerCase().trim();
  const category = document.getElementById('progFilterCourseCategory') ? document.getElementById('progFilterCourseCategory').value : '';
  const status = document.getElementById('progFilterCourseStatus') ? document.getElementById('progFilterCourseStatus').value : '';
  
  const cards = document.querySelectorAll('.prog-course-card');
  const resultText = document.getElementById('progCoursesSearchResultText');
  const filteredCountEl = document.getElementById('progCourseFilteredCount');
  const totalCountEl = document.getElementById('progCourseTotalCount');
  
  let visibleCount = 0;
  
  cards.forEach(card => {
    const title = card.getAttribute('data-title') || '';
    const cardCategory = card.getAttribute('data-category') || '';
    const cardStatus = card.getAttribute('data-status') || '';
    
    const matchesQuery = title.includes(query);
    const matchesCategory = category === '' || cardCategory === category;
    const matchesStatus = status === '' || cardStatus === status;
    
    if (matchesQuery && matchesCategory && matchesStatus) {
      card.style.display = 'flex';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });
  
  if (totalCountEl) totalCountEl.textContent = cards.length;
  if (filteredCountEl) filteredCountEl.textContent = visibleCount;
  
  if (resultText) {
    if (query !== '' || category !== '' || status !== '') {
      resultText.style.display = 'block';
    } else {
      resultText.style.display = 'none';
    }
  }
}

// Course Dropdown Menu Controls
function toggleCourseDropdown(event, id) {
  event.stopPropagation();
  // Close all other dropdowns
  document.querySelectorAll('.prog-course-dropdown-menu').forEach(el => {
    if (el.id !== 'prog-course-dropdown-' + id) {
      el.style.display = 'none';
      const card = el.closest('.prog-course-card');
      if (card) {
        card.style.zIndex = '';
      }
    }
  });
  
  const menu = document.getElementById('prog-course-dropdown-' + id);
  if (menu) {
    const card = menu.closest('.prog-course-card');
    if (menu.style.display === 'none' || menu.style.display === '') {
      menu.style.display = 'block';
      if (card) {
        card.style.zIndex = '50';
      }
    } else {
      menu.style.display = 'none';
      if (card) {
        card.style.zIndex = '';
      }
    }
  }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
  if (!event.target.closest('.prog-course-dropdown-container')) {
    document.querySelectorAll('.prog-course-dropdown-menu').forEach(el => {
      el.style.display = 'none';
      const card = el.closest('.prog-course-card');
      if (card) {
        card.style.zIndex = '';
      }
    });
  }
});

// Camera scanner functions for Portfolios & Certificates
let activeStreams = {};

function startCameraScan(type) {
  const container = document.getElementById(type + '_camera_preview_container');
  const video = document.getElementById(type + '_video');
  
  if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
    alert('Browser Anda tidak mendukung akses kamera.');
    return;
  }
  
  clearCameraScan(type);
  container.style.display = 'block';
  
  navigator.mediaDevices.getUserMedia({ 
    video: { facingMode: 'environment' }
  })
  .then(stream => {
    activeStreams[type] = stream;
    video.srcObject = stream;
    video.play();
  })
  .catch(err => {
    console.error('Error accessing camera:', err);
    alert('Gagal mengakses kamera. Mohon berikan izin akses kamera.');
    container.style.display = 'none';
  });
}

function stopCameraScan(type) {
  const container = document.getElementById(type + '_camera_preview_container');
  const video = document.getElementById(type + '_video');
  
  if (activeStreams[type]) {
    activeStreams[type].getTracks().forEach(track => track.stop());
    delete activeStreams[type];
  }
  
  if (video) {
    video.srcObject = null;
  }
  
  container.style.display = 'none';
}

function captureSnapshot(type) {
  const video = document.getElementById(type + '_video');
  const input = document.getElementById(type + '_camera_input');
  const scannedPreview = document.getElementById(type + '_scanned_preview');
  const scannedImg = document.getElementById(type + '_scanned_img');
  
  if (!video || !video.srcObject) return;
  
  const canvas = document.createElement('canvas');
  canvas.width = video.videoWidth || 640;
  canvas.height = video.videoHeight || 480;
  
  const ctx = canvas.getContext('2d');
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  
  const base64Data = canvas.toDataURL('image/jpeg', 0.85);
  
  input.value = base64Data;
  scannedImg.src = base64Data;
  scannedPreview.style.display = 'block';
  
  stopCameraScan(type);
}

function clearCameraScan(type) {
  const input = document.getElementById(type + '_camera_input');
  const scannedPreview = document.getElementById(type + '_scanned_preview');
  const scannedImg = document.getElementById(type + '_scanned_img');
  
  if (input) input.value = '';
  if (scannedPreview) scannedPreview.style.display = 'none';
  if (scannedImg) scannedImg.src = '';
}

// ===== PROGRESS & SUBMISSION SYSTEM =====
let progressProjectEarning = 0;

function openProgressModal(projectId, title, currentProgress, earning) {
  progressProjectEarning = earning;
  const form = document.getElementById('progressUpdateForm');
  form.action = window.APP_URL + '/programmer/project/' + projectId + '/update-progress';
  
  document.getElementById('progressProjectTitle').textContent = title;
  
  const slider = document.getElementById('progressSlider');
  slider.value = currentProgress;
  
  updateProgressSliderValue(currentProgress);
  
  document.getElementById('progressUpdateModal').style.display = 'flex';
  
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.setProperty('display', 'none', 'important');
}

function closeProgressModal() {
  document.getElementById('progressUpdateModal').style.display = 'none';
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.removeProperty('display');
  if(window.checkMascotVisibility) window.checkMascotVisibility();
}

function updateProgressSliderValue(val) {
  document.getElementById('progressValueBubble').textContent = val + '%';
  const deliverables = document.getElementById('deliverablesSection');
  const zipInput = document.getElementById('zipFileInput');
  const githubInput = document.getElementById('githubLinkInput');
  const submitBtn = document.getElementById('submitProgressBtn');
  
  if (parseInt(val) === 100) {
    deliverables.style.display = 'block';
    if (zipInput) zipInput.required = true;
    if (githubInput) githubInput.required = true;
    submitBtn.textContent = '🚀 Kirim Hasil & Cairkan Dana (Rp ' + progressProjectEarning.toLocaleString('id-ID') + ')';
    submitBtn.className = 'btn btn-success';
    submitBtn.style.boxShadow = '0 4px 15px rgba(16,185,129,0.4)';
  } else {
    deliverables.style.display = 'none';
    if (zipInput) zipInput.required = false;
    if (githubInput) githubInput.required = false;
    submitBtn.textContent = 'Simpan & Perbarui Progress 💾';
    submitBtn.className = 'btn btn-primary';
    submitBtn.style.boxShadow = 'none';
  }
}
</script>
@endpush

<!-- Chat Modal (Programmer side) -->
<div id="chatModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:9999;align-items:center;justify-content:center;padding:1rem">
  <div style="background:#1a1a2e;border:1px solid rgba(255,255,255,.12);border-radius:16px;width:100%;max-width:520px;height:560px;display:flex;flex-direction:column;box-shadow:0 25px 60px rgba(0,0,0,.5)">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid rgba(255,255,255,.08);display:flex;justify-content:space-between;align-items:center">
      <div>
        <div id="chatReceiverName" style="font-weight:700;color:#fff;font-size:.95rem">💬 Chat Negosiasi</div>
        <div style="font-size:.72rem;color:rgba(255,255,255,.4);margin-top:2px">Diskusikan detail dan harga project</div>
      </div>
      <button onclick="closeChat()" style="background:rgba(255,255,255,.08);border:none;border-radius:50%;width:32px;height:32px;color:#fff;font-size:1.1rem;cursor:pointer">&times;</button>
    </div>
    <div style="padding:.6rem 1.25rem;background:rgba(109,56,255,.15);border-bottom:1px solid rgba(109,56,255,.2);font-size:.75rem;color:rgba(255,255,255,.65)">
      💡 Jelaskan pendekatan teknis Anda dan negosiasikan harga yang sesuai dengan kebutuhan UMKM.
    </div>
    <div id="chatMessages" style="flex:1;overflow-y:auto;padding:1.25rem;display:flex;flex-direction:column;gap:.25rem"></div>
    <div style="padding:.875rem 1.25rem;border-top:1px solid rgba(255,255,255,.08);display:flex;gap:.5rem;align-items:flex-end">
      <textarea id="chatInput" placeholder="Ketik pesan... (Enter untuk kirim)" rows="1" style="flex:1;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:.6rem .875rem;color:#fff;font-size:.875rem;resize:none;outline:none;font-family:inherit" oninput="this.style.height='auto';this.style.height=Math.min(this.scrollHeight,100)+'px'"></textarea>
      <button onclick="sendChatMessage('programmer')" style="background:var(--primary);border:none;border-radius:10px;padding:.6rem 1rem;color:#fff;font-size:1.1rem;cursor:pointer;flex-shrink:0">➤</button>
    </div>
  </div>
</div>

<!-- Edit Portfolio Modal -->
<div id="editPortfolioModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;padding:1rem">
  <div style="background:var(--bg);border-radius:var(--radius-xl);padding:2rem;max-width:480px;width:100%;max-height:90vh;overflow-y:auto">
    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:1rem">✏️ Edit Portofolio</h3>
    <form id="editPortfolioForm" method="POST" aria-label="Form edit portofolio">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label class="form-label" for="editPortTitle">Judul Project</label>
        <input id="editPortTitle" name="title" class="form-input" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="editPortDesc">Deskripsi</label>
        <textarea id="editPortDesc" name="description" class="form-textarea" required></textarea>
      </div>
      <div class="form-group">
        <label class="form-label" for="editPortTags">Tags (pisahkan koma)</label>
        <input id="editPortTags" name="tags" class="form-input">
      </div>
      <div class="form-group">
        <label class="form-label" for="editPortUrl">Link Project (opsional)</label>
        <input id="editPortUrl" name="project_url" type="url" class="form-input">
      </div>
      <div style="display:flex;gap:.5rem;justify-content:flex-end;margin-top:1rem">
        <button type="button" onclick="closeEditPortfolioModal()" class="btn btn-ghost btn-sm">Batal</button>
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- ===== PROGRESS & SUBMISSION MODAL ===== -->
<div id="progressUpdateModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:99999;align-items:center;justify-content:center;padding:1rem;backdrop-filter:blur(4px)">
  <div style="background:#1e1e38;border:1.5px solid rgba(255,255,255,.1);border-radius:20px;width:100%;max-width:520px;display:flex;flex-direction:column;box-shadow:0 25px 60px rgba(0,0,0,.6);overflow:hidden;color:#e2e8f0;font-family:inherit">
    <!-- Header -->
    <div style="padding:1.25rem 1.5rem;border-bottom:1px solid rgba(255,255,255,.08);display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg, #111126, #1e1e38)">
      <div>
        <div style="font-weight:800;color:#fff;font-size:1.1rem;display:flex;align-items:center;gap:8px">
          ⚙️ Kelola Progress & Pengiriman
        </div>
        <div style="font-size:.78rem;color:rgba(255,255,255,.5);margin-top:2px">Perbarui persentase pekerjaan Anda atau kirim berkas selesai</div>
      </div>
      <button onclick="closeProgressModal()" style="background:rgba(255,255,255,.08);border:none;border-radius:50%;width:32px;height:32px;color:#fff;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center">&times;</button>
    </div>

    <form id="progressUpdateForm" method="POST" enctype="multipart/form-data">
      @csrf
      <div style="padding:1.5rem;max-height:70vh;overflow-y:auto">
        <!-- Project Context Card -->
        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:0.85rem 1rem;margin-bottom:1.25rem">
          <div style="font-size:0.75rem;color:var(--text3);text-transform:uppercase;font-weight:700">Project Aktif</div>
          <div id="progressProjectTitle" style="font-size:0.95rem;font-weight:800;color:#fff;margin-top:2px">Judul Project</div>
        </div>

        <!-- Slider Progress Selector -->
        <div class="form-group" style="margin-bottom:1.5rem;text-align:center">
          <label style="display:block;font-size:0.88rem;font-weight:700;margin-bottom:0.75rem;color:#fff;text-align:left">Geser untuk Update Progress</label>
          
          <div style="display:flex;align-items:center;gap:1.5rem;background:rgba(0,0,0,0.2);padding:1rem 1.25rem;border-radius:14px;border:1px solid rgba(255,255,255,0.05)">
            <input type="range" name="project_progress" id="progressSlider" min="0" max="100" step="25" style="flex:1;height:6px;accent-color:var(--primary);cursor:pointer" oninput="updateProgressSliderValue(this.value)">
            <span id="progressValueBubble" style="font-size:1.4rem;font-weight:900;color:var(--primary);min-width:70px;text-align:right">0%</span>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:0.72rem;color:var(--text3);padding:4px 10px 0 10px">
            <span>0% (Mulai)</span>
            <span>25%</span>
            <span>50% (Tengah)</span>
            <span>75%</span>
            <span>100% (Selesai)</span>
          </div>
        </div>

        <!-- Deliverables Section (Only shown when 100%) -->
        <div id="deliverablesSection" style="display:none;background:rgba(16,185,129,0.04);border:1.5px dashed rgba(16,185,129,0.3);border-radius:14px;padding:1.25rem;margin-top:1rem;animation:fadeSlideIn 0.25s ease-out">
          <div style="display:flex;align-items:center;gap:6px;color:#10b981;font-weight:800;font-size:0.9rem;margin-bottom:0.75rem">
            <span>🚀</span> Berkas Pengiriman & Link Deliverables
          </div>
          <p style="font-size:0.78rem;color:var(--text2);margin-bottom:1rem;line-height:1.5">
            Anda memilih progress <strong>100%</strong>. Agar project dapat diselesaikan dan dana dicairkan, harap unggah berkas arsip project dan tautan repositori/hosting di bawah ini.
          </p>

          <!-- ZIP Upload -->
          <div class="form-group" style="margin-bottom:0.85rem">
            <label style="display:block;font-size:0.78rem;font-weight:600;margin-bottom:0.35rem;color:#fff">Upload Berkas Hasil Project (ZIP/RAR) <span style="color:#EF4444">*</span></label>
            <input type="file" name="zip_file" id="zipFileInput" class="form-input" accept=".zip,.rar,.tar.gz" style="width:100%;background:rgba(255,255,255,0.05);color:#fff;border-color:rgba(255,255,255,0.1)">
            <div class="form-hint" style="color:var(--text3);font-size:0.7rem">Format berkas .zip atau .rar, maksimal 15MB</div>
          </div>

          <!-- GitHub Link -->
          <div class="form-group" style="margin-bottom:0.85rem">
            <label style="display:block;font-size:0.78rem;font-weight:600;margin-bottom:0.35rem;color:#fff">Link Repository GitHub <span style="color:#EF4444">*</span></label>
            <input type="url" name="github_link" id="githubLinkInput" class="form-input" placeholder="https://github.com/username/repository" style="width:100%;background:rgba(255,255,255,0.05);color:#fff;border-color:rgba(255,255,255,0.1)">
          </div>

          <!-- Hosting Link -->
          <div class="form-group" style="margin-bottom:0">
            <label style="display:block;font-size:0.78rem;font-weight:600;margin-bottom:0.35rem;color:#fff">Link Hosting Live (Opsional)</label>
            <input type="text" name="hosting_link" class="form-input" placeholder="contoh: rifqifauzian.web.id" style="width:100%;background:rgba(255,255,255,0.05);color:#fff;border-color:rgba(255,255,255,0.1)">
            <div class="form-hint" style="color:var(--text3);font-size:0.7rem">Masukkan custom domain live jika website sudah dideploy.</div>
          </div>
        </div>

      </div>

      <!-- Footer Buttons -->
      <div style="padding:1.25rem 1.5rem;border-top:1px solid rgba(255,255,255,.08);display:flex;gap:0.75rem;background:rgba(255,255,255,0.01)">
        <button type="submit" id="submitProgressBtn" class="btn btn-primary" style="flex:1;font-weight:800;font-size:0.9rem">
          Simpan & Perbarui Progress 💾
        </button>
        <button type="button" onclick="closeProgressModal()" class="btn btn-ghost" style="color:var(--text2);border-color:rgba(255,255,255,0.1)">
          Batal
        </button>
      </div>
    </form>
  </div>
</div>

<style>
@keyframes fadeSlideIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
