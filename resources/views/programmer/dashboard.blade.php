@extends('layouts.app')
@section('title', 'Dashboard Programmer')
@section('content')
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
      <a href="{{ route('messages.index') }}" class="btn btn-ghost btn-sm" style="border-color:var(--primary);color:var(--primary);background:var(--primary-light);font-weight:600;display:inline-flex;align-items:center;gap:6px">💬 Pesan / Chat</a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="btn btn-ghost btn-sm" style="border-color:var(--red);color:var(--red);background:var(--red-light)" aria-label="Keluar dari akun">Keluar 🚪</button>
      </form>
    </div>
  </div>

  <!-- IMK: Tab navigation makes feature discoverability clear -->
  <div class="tab-bar" role="tablist" aria-label="Menu Dashboard Programmer">
    @php
      $hasFilledThree = !empty($user->bio) && $portfolios->count() >= 1 && $certificates->count() >= 1;
      $showAllTabs = $user->is_verified || $hasFilledThree;
    @endphp
    <button class="tab-btn active" onclick="showTab('overview')" role="tab" aria-selected="true" id="tab-overview">📊 Overview</button>
    @if($showAllTabs)
      <button class="tab-btn" onclick="showTab('projects')" role="tab" id="tab-projects">🔍 Cari Project</button>
      <button class="tab-btn" onclick="showTab('courses')" role="tab" id="tab-courses">📚 Course Saya</button>
    @endif
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
            $certCount = $certificates->count();
            $portCount = $portfolios->count();
            $approvedCertCount = $certificates->where('status', 'approved')->count();
            $approvedPortCount = $portfolios->where('status', 'approved')->count();
            $progress = min(100, (int)(($approvedCertCount / 3 + $approvedPortCount / 3) / 2 * 100));
          @endphp
          {{ $progress }}%
        </span>
      </div>
      <div class="progress-bar" style="margin-bottom:.75rem"><div class="progress-fill" style="width:{{ $progress }}%"></div></div>
      <div style="display:flex;flex-direction:column;gap:.4rem">
        @foreach([
          ['Skill/Bio ditambahkan', !empty($user->bio)],
          ['Minimal 1 sertifikat (Disetujui)', $approvedCertCount >= 1],
          ['Minimal 1 portofolio (Disetujui)', $approvedPortCount >= 1],
          ['Terverifikasi (2+ sertifikat + 1+ portofolio)', $user->is_verified && $approvedCertCount >= 2 && $approvedPortCount >= 1],
          ['Top Programmer (3+ sertifikat + 3+ portofolio)', $user->is_top_programmer && $approvedCertCount >= 3 && $approvedPortCount >= 3],
          ['Hak Membuat Course (Top Programmer)', $user->is_top_programmer],
        ] as [$label, $done])
        <div style="display:flex;align-items:center;gap:.75rem;padding:.5rem 0;border-bottom:1px solid var(--border)">
          <div style="width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;background:{{ $done ? 'var(--green-light)' : 'var(--bg3)' }};color:{{ $done ? 'var(--green)' : 'var(--text3)' }};flex-shrink:0">{{ $done ? '✓' : '○' }}</div>
          <span style="font-size:.875rem;color:{{ $done ? 'var(--text)' : 'var(--text3)' }}">{{ $label }}</span>
        </div>
        @endforeach
      </div>
    </div>

    @if($activeProjects->count() || $myBids->count())
      @if($activeProjects->count())
      <div class="card" style="margin-bottom:1.25rem">
        <div class="card-header"><span class="card-title">🔥 Project Aktif</span></div>
        <div style="display:flex;flex-direction:column;gap:.5rem">
          @foreach($activeProjects as $p)
          <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem;background:var(--green-light);border-radius:var(--radius);border:1px solid rgba(16,185,129,.2)">
            <div>
              <div style="font-size:.9rem;font-weight:700">{{ $p->title }}</div>
              <div style="font-size:.8rem;color:var(--text3);margin-top:2px">{{ $p->umkm->business_name ?? $p->umkm->name }}</div>
            </div>
            <div style="text-align:right;display:flex;align-items:center;gap:.75rem">
              <div>
                <div style="font-size:1rem;font-weight:800;color:var(--green)">Rp {{ number_format($p->budget * 0.20, 0, ',', '.') }}</div>
                <div style="font-size:.75rem;color:var(--green);font-weight:600">20% komisi</div>
              </div>
              <button onclick="openChat({{ $p->id }}, {{ $p->umkm->id }}, '{{ addslashes($p->umkm->business_name ?? $p->umkm->name) }}', 'programmer')" class="btn btn-ghost btn-sm" style="font-size:.78rem">💬 Chat UMKM</button>
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

  @if($showAllTabs)
  <!-- PROJECTS TAB -->
  <div id="pane-projects" style="display:none" role="tabpanel">
    @php
      $approvedPortCount = $user->portfolios()->where('status', 'approved')->count();
      $approvedCertCount = $user->certificates()->where('status', 'approved')->count();
      $totalPortCount = $user->portfolios()->count();
      $totalCertCount = $user->certificates()->count();
    @endphp

    @if(!$user->is_verified)
    <div class="imk-guide" style="margin-bottom:1.5rem;background:#FEF3C7;border-color:#F59E0B">
      <div class="imk-guide-icon">⏳</div>
      <div>
        <div class="imk-guide-title" style="color:#B45309">Menunggu Verifikasi Akun oleh Admin</div>
        <div class="imk-guide-text" style="color:#D97706">Akun Anda sedang dalam proses peninjauan oleh admin. Akses fitur "Cari Project" akan terbuka sepenuhnya setelah admin menyetujui verifikasi akun Anda.</div>
      </div>
    </div>
    @elseif($totalPortCount === 0 && $totalCertCount === 0)
    <div class="imk-guide" style="margin-bottom:1.5rem">
      <div class="imk-guide-icon">🔒</div>
      <div>
        <div class="imk-guide-title">Fitur Belum Terbuka</div>
        <div class="imk-guide-text">Anda belum memenuhi syarat untuk mencari project, penuhi kriteria dengan mengisi portofolio atau sertifikat agar anda mendapatkan akses fitur ini (cari project).</div>
      </div>
    </div>
    @elseif($approvedPortCount === 0 && $approvedCertCount === 0)
    <div class="imk-guide" style="margin-bottom:1.5rem;background:#FEF3C7;border-color:#F59E0B">
      <div class="imk-guide-icon">⏳</div>
      <div>
        <div class="imk-guide-title" style="color:#B45309">Menunggu Verifikasi Oleh Admin</div>
        <div class="imk-guide-text" style="color:#D97706">Portofolio atau sertifikat yang Anda unggah sedang dalam proses peninjauan oleh admin. Akses fitur "Cari Project" akan terbuka setelah verifikasi disetujui.</div>
      </div>
    </div>
    @else
    <div style="background:linear-gradient(135deg,#1E1260,#6C38FF);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.5rem;color:#fff">
      <h2 style="color:#fff;font-size:1.25rem;margin-bottom:.25rem">{{ $availableProjects->count() }} project tersedia untuk Anda</h2>
      <p style="color:rgba(255,255,255,.7);font-size:.875rem">Klik "Ajukan Penawaran" untuk mengirim bid ke UMKM</p>
    </div>
    <div class="project-grid">
      @foreach($availableProjects as $p)
      <div class="project-card">
        <div style="display:flex;justify-content:space-between;margin-bottom:.5rem">
          <div>
            <span style="font-size:.95rem;font-weight:700">&lt;/&gt; {{ $p->title }}</span>
            <span class="badge badge-open" style="margin-left:.5rem">Dibuka</span>
          </div>
          <div style="text-align:right">
            @if($p->budget > 0)
              <div style="font-size:1rem;font-weight:800">Rp {{ number_format($p->budget, 0, ',', '.') }}</div>
              <div style="font-size:.78rem;color:var(--green)">Anda dapat: Rp {{ number_format($p->budget * 0.20, 0, ',', '.') }}</div>
            @else
              <div style="font-size:0.95rem;font-weight:700;color:var(--accent)">Menunggu Estimasi</div>
              <div style="font-size:.78rem;color:var(--text3)">Tentukan estimasi harga Anda</div>
            @endif
          </div>
        </div>
        <p style="font-size:.85rem;color:var(--text2);margin-bottom:.75rem">{{ Str::limit($p->description, 100) }}</p>
        <div class="tag-list" style="margin-bottom:.75rem">
          @foreach(($p->tags ?? []) as $tag)<span class="tag">{{ $tag }}</span>@endforeach
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;border-top:1px solid var(--border);padding-top:.75rem">
          <span style="font-size:.78rem;color:var(--text3)">⏰ Deadline: {{ $p->deadline->format('d M Y') }}</span>
          @if($p->bids->contains('programmer_id', $user->id))
            <button class="btn btn-sm" style="background:var(--orange-light);color:#92400E;border-color:rgba(245,158,11,.3);cursor:default;font-weight:600" disabled>Menunggu Persetujuan UMKM ⏳</button>
          @elseif($approvedPortCount === 0 && $approvedCertCount === 0)
            <button class="btn btn-sm" style="background:var(--bg3);color:var(--text3);border-color:var(--border);cursor:not-allowed" title="Tambahkan minimal 1 Portofolio atau Sertifikat yang disetujui terlebih dahulu" disabled>Kunci Penawaran 🔒</button>
          @else
            <button onclick="openBidModal({{ $p->id }}, '{{ addslashes($p->title) }}', {{ $p->budget }}, {{ max(1, (int)now()->startOfDay()->diffInDays($p->deadline->startOfDay())) }})" class="btn btn-primary btn-sm" aria-label="Ajukan penawaran untuk {{ $p->title }}">Ajukan Penawaran →</button>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:1rem">
      <a href="{{ route('projects') }}" class="btn btn-ghost">Lihat Semua Project →</a>
    </div>
    @endif
  </div>
  @endif

  @if($showAllTabs)
  <!-- COURSES TAB -->
  <div id="pane-courses" style="display:none" role="tabpanel">
    @if(!$user->is_verified)
    <div class="imk-guide" style="margin-bottom:1.5rem;background:#FEF3C7;border-color:#F59E0B">
      <div class="imk-guide-icon">⏳</div>
      <div>
        <div class="imk-guide-title" style="color:#B45309">Menunggu Verifikasi Akun oleh Admin</div>
        <div class="imk-guide-text" style="color:#D97706">Akun Anda sedang dalam proses peninjauan oleh admin. Akses fitur "Course Saya" akan terbuka sepenuhnya setelah admin menyetujui verifikasi akun Anda.</div>
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

    <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem">Course Saya ({{ $myCourses->count() }})</h3>
    @forelse($myCourses as $course)
    <div style="border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.25rem;margin-bottom:1rem;display:flex;gap:1rem;align-items:flex-start">
      <div style="width:90px;height:70px;border-radius:var(--radius);background:linear-gradient(135deg,#1E1260,#3D1FAF);flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:1.5rem">📚</div>
      <div style="flex:1">
        <div style="display:flex;gap:.5rem;margin-bottom:.25rem">
          <span class="level-badge level-{{ $course->level }}" style="position:static;font-size:.7rem;font-weight:700;padding:2px 8px;border-radius:99px">{{ $course->level_label }}</span>
          @if($course->is_published)<span style="font-size:.7rem;font-weight:600;padding:2px 8px;border-radius:99px;background:var(--green-light);color:var(--green)">Dipublikasikan</span>@endif
        </div>
        <div style="font-size:.95rem;font-weight:700;margin-bottom:.25rem">{{ $course->title }}</div>
        <div style="font-size:.82rem;color:var(--text2)">⭐ {{ $course->rating }} · {{ number_format($course->total_students) }} siswa · {{ $course->total_videos }} video</div>
      </div>
      <div style="text-align:right;display:flex;flex-direction:column;align-items:flex-end;gap:.5rem">
        <div style="font-size:1rem;font-weight:800;color:var(--primary)">{{ $course->price_formatted }}</div>
        <div style="display:flex;gap:.4rem">
          <a href="{{ route('programmer.course.edit', $course) }}" class="btn btn-ghost btn-sm" style="font-size:.75rem;padding:4px 10px">✏️ Edit</a>
          <form method="POST" action="{{ route('programmer.course.delete', $course) }}" onsubmit="return confirm('Hapus course ini beserta seluruh video materinya?')" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-ghost btn-sm" style="font-size:.75rem;padding:4px 10px;color:var(--red)">🗑 Hapus</button>
          </form>
        </div>
      </div>
    </div>
    @empty
    <div style="text-align:center;padding:2rem;color:var(--text3)">Belum ada course. Buat course pertama Anda!</div>
    @endforelse
  </div>
  @endif



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
      <form method="POST" action="{{ route('programmer.portfolio.store') }}" aria-label="Form tambah portofolio">
        @csrf
        <div class="form-group"><input name="title" class="form-input" placeholder="Judul project" required aria-label="Judul portofolio"></div>
        <div class="form-group"><textarea name="description" class="form-textarea" placeholder="Deskripsi singkat project..." required aria-label="Deskripsi portofolio"></textarea></div>
        <div class="form-group"><input name="tags" class="form-input" placeholder="Tags (pisahkan koma): React, Laravel..." aria-label="Tags portofolio"><div class="form-hint">Contoh: React, Laravel, MySQL</div></div>
        <div class="form-group"><input name="project_url" type="url" class="form-input" placeholder="Link project (opsional)" aria-label="URL portofolio"></div>
        <button type="submit" class="btn btn-primary btn-sm" style="margin-bottom:1.5rem">+ Tambah Portofolio</button>
      </form>

      <hr style="margin:1.5rem 0;border:none;border-top:1px solid var(--border)">

      <!-- 2. SERTIFIKAT -->
      <h4 style="font-size:.9rem;font-weight:700;margin-bottom:.75rem">📜 Sertifikat ({{ $certificates->count() }})</h4>
      @forelse($certificates as $cert)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem;background:var(--bg2);border-radius:var(--radius);margin-bottom:.5rem">
        <div>
          <div style="font-size:.875rem;font-weight:600">{{ $cert->name }}</div>
          <div style="font-size:.78rem;color:var(--text3)">{{ $cert->issuer }} · {{ $cert->issue_date?->format('M Y') }}</div>
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
      <form method="POST" action="{{ route('programmer.certificate.store') }}" aria-label="Form tambah sertifikat">
        @csrf
        <div class="form-row">
          <div class="form-group"><input name="name" class="form-input" placeholder="Nama sertifikat" required aria-label="Nama sertifikat"></div>
          <div class="form-group"><input name="issuer" class="form-input" placeholder="Penerbit (contoh: Google)" required aria-label="Penerbit sertifikat"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><input name="issue_date" type="date" class="form-input" aria-label="Tanggal sertifikat"></div>
          <div class="form-group"><input name="credential_url" type="url" class="form-input" placeholder="URL verifikasi (opsional)" aria-label="URL sertifikat"></div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">+ Tambah Sertifikat</button>
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
}

// IMK: Restore tab from URL hash
const hash = location.hash.replace('#','');
const allowedTabs = [
  'overview',
  @if($showAllTabs) 'projects','courses', @endif
  'verify'
];
if(hash && allowedTabs.includes(hash)) {
  showTab(hash);
} else {
  showTab('overview');
}

let bidProjectId, bidBudget;
function openBidModal(id, title, budget, daysRemaining){
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
function closeBidModal(){ document.getElementById('bidModal').style.display = 'none'; }
function updateEarning(){
  const v = parseFloat(document.getElementById('bidAmount').value) || 0;
  document.getElementById('bidEarning').textContent = v > 0 ? `Estimasi Anda terima (20%): Rp ${(v*0.2).toLocaleString('id-ID')}` : '';
}
document.getElementById('bidAmount')?.addEventListener('input', updateEarning);
// Close modal on backdrop click
document.getElementById('bidModal')?.addEventListener('click', e=>{ if(e.target===e.currentTarget) closeBidModal(); });

// ===== EDIT BID SYSTEM =====
function openEditBidModal(bidId, amount, timelineDays, message, projectTitle, daysRemaining) {
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
@endsection
