@extends('layouts.app')
@section('title', 'Dashboard UMKM')
@section('content')
<div class="dash-layout">
  <!-- PROFILE HEADER -->
  <div class="profile-header">
    <div style="display:flex;align-items:center;gap:1rem">
      <div class="profile-av" style="background:var(--accent)">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
      <div>
        <div style="font-size:1.25rem;font-weight:800">Halo, {{ $user->name }}!</div>
        <div style="font-size:.85rem;color:var(--text2);display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;margin-top:.25rem">
          {{ $user->business_name }}
          @if($user->umkm_verified)<span style="font-size:.7rem;font-weight:600;padding:3px 9px;border-radius:99px;background:var(--green-light);color:var(--green)">✅ UMKM Verified</span>@endif
        </div>
      </div>
    </div>
    <div style="display:flex;gap:.75rem;align-items:center">
      <button onclick="showUTab('posting')" class="btn btn-orange btn-sm" aria-label="Buat project baru">+ Posting Project Baru</button>
      @php
        $unreadMessagesCount = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
      @endphp
      <a href="{{ route('messages.index') }}" class="btn btn-ghost btn-sm" style="border-color:var(--accent);color:var(--accent);background:rgba(16,185,129,0.1);font-weight:600;display:inline-flex;align-items:center;gap:6px">
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

  <!-- IMK: Tabs for distinct task separation -->
  <div class="tab-bar" role="tablist">
    <button class="tab-btn active" onclick="showUTab('overview')" id="utab-overview" role="tab" aria-selected="true" style="color:var(--accent);border-bottom-color:var(--accent)">📊 Overview</button>
    <button class="tab-btn" onclick="showUTab('projects')" id="utab-projects" role="tab">
      📋 Project Saya
      @if($unseenBidsCount > 0)
        <span id="projectsBadge" style="display:inline-flex;align-items:center;justify-content:center;background:var(--red);color:#fff;font-size:0.72rem;font-weight:800;min-width:18px;height:18px;padding:0 5px;border-radius:99px;margin-left:5px;line-height:1;box-shadow:0 2px 6px rgba(239,68,68,0.5);animation:badgePulse 1.5s ease-in-out infinite">{{ $unseenBidsCount }}</span>
      @else
        <span id="projectsBadge" style="display:none;align-items:center;justify-content:center;background:var(--red);color:#fff;font-size:0.72rem;font-weight:800;min-width:18px;height:18px;padding:0 5px;border-radius:99px;margin-left:5px;line-height:1;box-shadow:0 2px 6px rgba(239,68,68,0.5);animation:badgePulse 1.5s ease-in-out infinite">0</span>
      @endif
    </button>
    <button class="tab-btn" onclick="showUTab('posting')" id="utab-posting" role="tab">+ Posting Project</button>
    <button class="tab-btn" onclick="showUTab('programmers')" id="utab-programmers" role="tab">🧑‍💻 Daftar Programmer</button>
  </div>

  <!-- OVERVIEW -->
  <div id="upane-overview" role="tabpanel">
    <div class="stats-grid">
      <div class="stat-card glass-card">
        <div class="stat-card-icon" style="background:rgba(79,70,229,0.1)">
          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 44px; height: 44px; filter: drop-shadow(0 4px 8px rgba(79, 70, 229, 0.4));">
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
        <div class="stat-card-value">{{ $projects->count() }}</div>
        <div class="stat-card-label">Total Project</div>
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
        <div class="stat-card-value">{{ $projects->where('status','in_progress')->count() }}</div>
        <div class="stat-card-label">Sedang Berjalan</div>
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
        <div class="stat-card-value">{{ $projects->where('status','completed')->count() }}</div>
        <div class="stat-card-label">Selesai</div>
      </div>
      <div class="stat-card glass-card">
        <div class="stat-card-icon" style="background:rgba(239,68,68,0.1)">
          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 44px; height: 44px; filter: drop-shadow(0 4px 8px rgba(239, 68, 68, 0.4));">
            <defs>
              <linearGradient id="clock-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#F87171" />
                <stop offset="100%" stop-color="#EF4444" />
              </linearGradient>
            </defs>
            <circle cx="32" cy="34" r="20" fill="url(#clock-grad)" />
            <circle cx="32" cy="34" r="16" fill="#FFF" />
            <path d="M 32 22 V 34 L 40 38" stroke="#EF4444" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />
            <rect x="29" y="8" width="6" height="4" fill="#EF4444" rx="1" />
            <path d="M 12 18 L 18 12 M 52 18 L 46 12" stroke="#EF4444" stroke-width="4.5" stroke-linecap="round" />
          </svg>
        </div>
        <div class="stat-card-value">{{ $projects->where('status','open')->count() }}</div>
        <div class="stat-card-label">Menunggu</div>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem">
      <div class="card">
        <div class="card-header"><span class="card-title">💰 Ringkasan Biaya</span></div>
        @php $totalBudget = $projects->sum('budget'); @endphp
        <div style="display:flex;justify-content:space-between;padding:.5rem 0;font-size:.875rem;border-bottom:1px solid var(--border)"><span>Total Budget Project</span><span style="font-weight:700">Rp {{ number_format($totalBudget, 0, ',', '.') }}</span></div>
        <div style="display:flex;justify-content:space-between;padding:.5rem 0;font-size:.875rem;border-bottom:1px solid var(--border)"><span>Komisi Platform (80%)</span><span style="color:var(--text3)">Rp {{ number_format($totalBudget * 0.80, 0, ',', '.') }}</span></div>
        <div style="display:flex;justify-content:space-between;padding:.5rem 0;font-size:.875rem;color:var(--green);font-weight:700"><span>Total ke Programmer (20%)</span><span>Rp {{ number_format($totalBudget * 0.20, 0, ',', '.') }}</span></div>
        <p style="font-size:.75rem;color:var(--text3);margin-top:.5rem">ℹ Dana dikelola oleh BuilderHub demi keamanan pembayaran programmer</p>
      </div>
      <div class="card">
        <div class="card-header"><span class="card-title">🛡 Status Verifikasi</span></div>
        @if($user->umkm_verified)
        <div style="background:var(--green-light);border:1px solid rgba(16,185,129,.3);border-radius:var(--radius);padding:.85rem 1rem;font-size:.85rem;color:#065F46;margin-bottom:.75rem">✅ UMKM Terverifikasi — Aktif</div>
        <p style="font-size:.85rem;color:var(--text2);line-height:1.6">Data KTP dan Foto Tempat Usaha Anda sudah sukses diverifikasi oleh tim admin BuilderHub. Project Anda sekarang lebih dipercaya oleh Programmer.</p>
        @else
        <div style="background:var(--orange-light);border:1px solid rgba(245,158,11,.3);border-radius:var(--radius);padding:.85rem 1rem;font-size:.85rem;color:#92400E;margin-bottom:.75rem">⏳ Menunggu Verifikasi Admin</div>
        <p style="font-size:.85rem;color:var(--text2);line-height:1.6">Tim admin sedang meninjau data pendaftaran Anda (No. KTP, Foto KTP, dan Foto Usaha). Mohon tunggu hingga akun Anda disetujui sepenuhnya dalam 1x24 jam.</p>
        @endif
      </div>
    </div>

    <div class="card">
      <div class="card-header"><span class="card-title">📋 Project Terbaru</span><button onclick="showUTab('projects')" class="btn btn-ghost btn-sm">Lihat Semua →</button></div>
      @forelse($projects->take(3) as $p)
      <div style="border:1px solid var(--border);border-radius:var(--radius);padding:1rem;margin-bottom:.5rem">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.25rem">
          <span style="font-size:.95rem;font-weight:700">{{ $p->title }}</span>
          <span class="badge badge-{{ $p->status === 'open' ? 'open' : ($p->status === 'in_progress' ? 'running' : 'done') }}">{{ $p->status_label }}</span>
        </div>
        <div style="font-size:.82rem;color:var(--text3)">Budget: {{ $p->budget > 0 ? 'Rp ' . number_format($p->budget, 0, ',', '.') : 'Menunggu Estimasi' }} · {{ $p->bids->count() }} penawaran</div>
      </div>
      @empty
      <p style="color:var(--text3)">Belum ada project. <button onclick="showUTab('posting')" style="color:var(--accent);font-weight:600;background:none;border:none;cursor:pointer">Posting project pertama →</button></p>
      @endforelse
    </div>
  </div>

  <!-- PROJECTS LIST -->
  <div id="upane-projects" style="display:none" role="tabpanel">
    {{-- BAR PENCARIAN & FILTER --}}
    <div class="card" style="margin-bottom:1.5rem;padding:1.25rem;">
      <div style="display:flex;gap:1rem;align-items:center;flex-wrap:wrap">
        <div style="flex:1;min-width:260px;position:relative">
          <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:1.1rem;color:var(--text3)">🔍</span>
          <input type="text" id="umkmSearchProject" placeholder="Cari judul atau deskripsi project Anda..." oninput="filterUmkmProjects()" style="width:100%;padding:10px 16px 10px 42px;border:1.5px solid var(--border);border-radius:12px;font-size:.9rem;background:var(--bg);color:var(--text);font-family:inherit" />
        </div>
        <div style="min-width:180px">
          <select id="umkmFilterStatus" onchange="filterUmkmProjects()" style="width:100%;padding:10px 16px;border:1.5px solid var(--border);border-radius:12px;font-size:.9rem;background:var(--bg);color:var(--text);font-family:inherit">
            <option value="">🟢 Semua Status</option>
            <option value="pending">⏳ Menunggu ACC</option>
            <option value="open">🔓 Dibuka / Estimasi</option>
            <option value="in_progress">⚙️ Berjalan</option>
            <option value="completed">🏆 Selesai</option>
          </select>
        </div>
      </div>
      <div id="umkmProjectsSearchResultText" style="font-size:.82rem;color:var(--text3);margin-top:.75rem;display:none;font-weight:600">
        Menampilkan <span id="umkmFilteredCount">0</span> dari <span id="umkmTotalCount">0</span> project
      </div>
    </div>

    @forelse($projects as $project)
    <div class="card umkm-project-card" style="margin-bottom:1rem" data-title="{{ strtolower($project->title) }}" data-desc="{{ strtolower($project->description) }}" data-status="{{ $project->status }}">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.75rem">
        <div>
          <span style="font-size:1rem;font-weight:700">{{ $project->title }}</span>
          <span class="badge badge-{{ $project->status === 'open' ? 'open' : ($project->status === 'in_progress' ? 'running' : 'done') }}" style="margin-left:.5rem">{{ $project->status_label }}</span>
        </div>
        <div style="text-align:right;display:flex;flex-direction:column;align-items:flex-end;gap:.25rem">
          <div style="font-size:1rem;font-weight:800">{{ $project->budget > 0 ? 'Rp ' . number_format($project->budget, 0, ',', '.') : 'Menunggu Estimasi' }}</div>
          @if($project->status === 'pending')
          <div style="display:flex;gap:.25rem;margin-top:.25rem">
            <button onclick="openEditProjectModal({{ $project->id }}, '{{ addslashes($project->title) }}', '{{ addslashes($project->description) }}', '{{ $project->deadline ? $project->deadline->format('Y-m-d') : '' }}', '{{ addslashes($project->category) }}', '{{ addslashes($project->tags[0] ?? '') }}')" class="btn btn-ghost btn-sm" style="font-size:.72rem;padding:2px 6px">✏️ Edit</button>
            <form method="POST" action="{{ route('umkm.project.delete', $project) }}" onsubmit="return confirm('Hapus pengajuan project ini?')" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-ghost btn-sm" style="font-size:.72rem;padding:2px 6px;color:var(--red)">🗑 Hapus</button>
            </form>
          </div>
          @elseif($project->status !== 'in_progress' && $project->status !== 'completed')
          <form method="POST" action="{{ route('umkm.project.delete', $project) }}" onsubmit="return confirm('Hapus project ini?')" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-ghost btn-sm" style="font-size:.72rem;padding:2px 6px;color:var(--red)">🗑 Hapus</button>
          </form>
          @endif
        </div>
      </div>
      <div style="font-size:.85rem;color:var(--text2);margin-bottom:.75rem;line-height:1.5">
        @if(strlen($project->description) > 120)
          <span class="desc-short">{{ Str::limit($project->description, 120) }}</span>
          <span class="desc-full" style="display:none">{{ $project->description }}</span>
          <button type="button" onclick="toggleDesc(this)" style="background:none;border:none;color:var(--primary);font-size:0.78rem;font-weight:700;cursor:pointer;padding:0;margin-left:4px;display:inline">Selengkapnya</button>
        @else
          <span>{{ $project->description }}</span>
        @endif
      </div>

      {{-- ALERT: Deadline Terlampaui & Belum Ada Programmer --}}
      @php
        $isOverdue = $project->deadline && now()->startOfDay()->gt($project->deadline->startOfDay());
        $hasNoProgrammer = !$project->assigned_programmer_id;
        $hasPendingBids = $project->bids->where('status', 'pending')->count() > 0;
      @endphp
      @if($isOverdue && $hasNoProgrammer && $project->status === 'open')
      <div style="background:linear-gradient(135deg,#FEF2F2,#FFF5F5);border:1.5px solid rgba(239,68,68,0.4);border-radius:var(--radius);padding:.85rem 1rem;margin-bottom:.75rem;display:flex;align-items:flex-start;gap:.75rem;box-shadow:0 2px 8px rgba(239,68,68,0.1)">
        <span style="font-size:1.3rem;flex-shrink:0">⚠️</span>
        <div>
          <div style="font-size:.875rem;font-weight:800;color:#991B1B;margin-bottom:.2rem">Deadline Terlampaui — Belum Ada Programmer</div>
          <div style="font-size:.8rem;color:#B91C1C;line-height:1.5">
            Deadline project ini (<strong>{{ $project->deadline->format('d M Y') }}</strong>) sudah lewat dan belum ada programmer yang mengambil.
            @if($hasPendingBids)
              Namun ada <strong>{{ $project->bids->where('status', 'pending')->count() }} penawaran</strong> yang menunggu persetujuan Anda.
            @else
              Pertimbangkan untuk memperbarui deadline atau menghapus project ini.
            @endif
          </div>
        </div>
      </div>
      @endif

      @if($project->status === 'open' && !$project->assigned_programmer_id && $project->bids->count())
      <div style="background:var(--bg2);border-radius:var(--radius);padding:1rem;margin-bottom:.75rem">
        <div style="font-size:.85rem;font-weight:700;margin-bottom:.75rem">👥 Penawaran Masuk ({{ $project->bids->count() }})
          <span style="font-size:.75rem;font-weight:400;color:var(--text3)"> — Klik 💬 untuk chat & negosiasi harga sebelum menerima</span>
        </div>
        @foreach($project->bids as $bid)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem;border:1px solid var(--border);border-radius:var(--radius);margin-bottom:.5rem;background:var(--bg)">
          <div style="display:flex;align-items:center;gap:.75rem;flex:1">
            <div style="width:40px;height:40px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:.9rem;font-weight:700;color:#fff;flex-shrink:0">{{ strtoupper(substr($bid->programmer->name, 0, 1)) }}</div>
            <div style="flex:1">
              <div style="font-size:.9rem;font-weight:700">{{ $bid->programmer->name }}
                @if($bid->programmer->is_verified)<span style="font-size:.7rem;color:var(--green)"> ✅</span>@endif
                @if($bid->rejection_count === 1 && !$bid->is_revised)
                  <span style="font-size:.72rem;color:var(--orange);font-weight:600;margin-left:.5rem;background:var(--orange-light);padding:2px 8px;border-radius:99px">Ditolak 1x (Menunggu Revisi)</span>
                @elseif($bid->rejection_count === 1 && $bid->is_revised)
                  <span style="font-size:.72rem;color:var(--primary);font-weight:600;margin-left:.5rem;background:var(--primary-light);padding:2px 8px;border-radius:99px">Penawaran Revisi</span>
                @elseif($bid->status === 'rejected' || $bid->rejection_count >= 2)
                  <span style="font-size:.72rem;color:var(--red);font-weight:600;margin-left:.5rem;background:var(--red-light);padding:2px 8px;border-radius:99px">Ditolak! ❌</span>
                @endif
              </div>
              <div style="font-size:.82rem;color:var(--text2);margin-top:2px">{{ Str::limit($bid->message, 80) }}</div>
              <div style="font-size:.75rem;color:var(--text3);margin-top:2px">⏱ {{ $bid->timeline_days }} hari pengerjaan</div>
            </div>
          </div>
          <div style="text-align:right;flex-shrink:0;margin-left:1rem;display:flex;flex-direction:column;align-items:flex-end;gap:.4rem">
            <div style="font-size:1rem;font-weight:800;color:var(--primary)">Rp {{ number_format($bid->amount, 0, ',', '.') }}</div>
            <div style="display:flex;gap:.4rem;align-items:center">
              <!-- IMK: Chat button for negotiation -->
              @php
                $unreadBidChatCount = \App\Models\Message::where('project_id', $project->id)
                    ->where('sender_id', $bid->programmer->id)
                    ->where('receiver_id', auth()->id())
                    ->where('is_read', false)
                    ->count();
              @endphp
              <button onclick="openChat({{ $project->id }}, {{ $bid->programmer->id }}, '{{ addslashes($bid->programmer->name) }}', 'umkm')" class="btn btn-ghost btn-sm" style="font-size:.75rem;padding:4px 10px;display:inline-flex;align-items:center;gap:4px">
                💬 Chat
                @if($unreadBidChatCount > 0)
                  <span style="background:#EF4444;color:#fff;font-size:0.68rem;font-weight:800;padding:1px 5px;border-radius:10px;line-height:1">
                    {{ $unreadBidChatCount }}
                  </span>
                @endif
              </button>
              
              @if(($bid->rejection_count === 0 || $bid->is_revised) && $bid->status !== 'rejected')
                <!-- IMK: Accept button with confirmation -->
                @php $confirmMsg = "Terima penawaran Rp " . number_format($bid->amount, 0, ',', '.') . " dari {$bid->programmer->name}? Budget project akan otomatis disesuaikan."; @endphp
                <form method="POST" action="{{ route('umkm.bid.accept', $bid) }}" onsubmit="return confirm('{{ addslashes($confirmMsg) }}')">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm" style="font-size:.75rem;padding:4px 10px">Terima ✅</button>
                </form>

                <!-- Tolak button -->
                @php $rejectMsg = "Tolak penawaran Rp " . number_format($bid->amount, 0, ',', '.') . " dari {$bid->programmer->name}?"; @endphp
                <form method="POST" action="{{ route('umkm.bid.reject', $bid) }}" onsubmit="return confirm('{{ addslashes($rejectMsg) }}')">
                  @csrf
                  <button type="submit" class="btn btn-ghost btn-sm" style="font-size:.75rem;padding:4px 10px;color:var(--red);border-color:var(--red);background:none">Tolak ❌</button>
                </form>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @endif

      {{-- STATE 1: AWAITING PAYMENT (Rekber Unpaid) --}}
      @if($project->status === 'open' && $project->assigned_programmer_id && $project->escrow_status === 'unpaid')
      <div style="background:rgba(79,70,229,0.05);border:1.5px dashed var(--primary);border-radius:var(--radius-lg);padding:1.25rem;margin-bottom:1rem;box-shadow:0 8px 24px rgba(79,70,229,0.06)">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
          <div>
            <div style="font-size:.95rem;font-weight:800;color:var(--text);display:flex;align-items:center;gap:6px">
              <span>🎉</span> Penawaran Disetujui! Menunggu Pembayaran Rekber
            </div>
            <p style="font-size:.82rem;color:var(--text2);margin-top:4px;line-height:1.5">
              Anda menyetujui penawaran <strong>{{ $project->programmer->name }}</strong>.<br>
              Silakan depositokan dana Rekber sebesar <strong style="color:var(--primary)">Rp {{ number_format($project->budget, 0, ',', '.') }}</strong> agar programmer dapat mulai bekerja.
            </p>
          </div>
          <div>
            <button type="button" onclick="openEscrowPaymentModal({{ $project->id }}, '{{ addslashes($project->title) }}', '{{ addslashes($project->programmer->name) }}', {{ $project->budget }})" class="btn btn-primary btn-sm" style="display:inline-flex;align-items:center;gap:6px;box-shadow:0 4px 14px rgba(79,70,229,0.35);font-weight:700">
              💳 Bayar Rekber (VA / QRIS)
            </button>
          </div>
        </div>
      </div>
      @endif

      {{-- STATE 2: IN PROGRESS (Dalam Pengerjaan) --}}
      @if($project->status === 'in_progress' && $project->programmer)
      <div style="background:rgba(245,158,11,0.05);border:1.5px solid rgba(245,158,11,.25);border-radius:var(--radius-lg);padding:1.25rem;margin-bottom:1rem">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;margin-bottom:0.75rem">
          <div>
            <span style="font-size:.92rem;font-weight:800;color:var(--text);display:flex;align-items:center;gap:6px">
              <span>⚙️</span> Project Sedang Dikerjakan
            </span>
            <div style="font-size:.8rem;color:var(--text3);margin-top:2px">
              Programmer: <strong style="color:var(--text)">{{ $project->programmer->name }}</strong> · 
              Budget Rekber: <strong style="color:var(--green)">Rp {{ number_format($project->budget, 0, ',', '.') }} (Held by Admin 🛡️)</strong>
            </div>
          </div>
          <div style="display:flex;gap:.5rem;align-items:center">
            @php
              $unreadInProgressChatCount = \App\Models\Message::where('project_id', $project->id)
                  ->where('sender_id', $project->programmer->id)
                  ->where('receiver_id', auth()->id())
                  ->where('is_read', false)
                  ->count();
            @endphp
            <button onclick="openChat({{ $project->id }}, {{ $project->programmer->id }}, '{{ addslashes($project->programmer->name) }}', 'umkm')" class="btn btn-ghost btn-sm" style="display:inline-flex;align-items:center;gap:4px">
              💬 Chat Programmer
              @if($unreadInProgressChatCount > 0)
                <span style="background:#EF4444;color:#fff;font-size:0.68rem;font-weight:800;padding:1px 5px;border-radius:10px;line-height:1">
                  {{ $unreadInProgressChatCount }}
                </span>
              @endif
            </button>
            @if($project->project_progress == 100)
            <form method="POST" action="{{ route('umkm.project.complete', $project) }}" onsubmit="return confirm('Apakah Anda yakin menyelesaikan project ini? Saldo bagi hasil (20% untuk programmer, 80% platform fee) akan segera dicairkan secara resmi.')" style="display:inline">
              @csrf
              <button type="submit" class="btn btn-success btn-sm" aria-label="Selesaikan project">✅ Selesaikan</button>
            </form>
            @endif
          </div>
        </div>
        
        <!-- Progress Bar -->
        <div style="margin-top:0.75rem">
          <div style="display:flex;justify-content:space-between;align-items:center;font-size:.8rem;font-weight:700;margin-bottom:.35rem">
            <span style="color:var(--text2)">Progress Pengerjaan</span>
            <span style="color:var(--orange)">{{ $project->project_progress }}%</span>
          </div>
          <div class="progress-bar" style="height:8px;background:var(--border);border-radius:99px;overflow:hidden;margin:0">
            <div class="progress-fill" style="width:{{ $project->project_progress }}%;height:100%;background:linear-gradient(90deg, #F59E0B, #D97706);border-radius:99px;transition:width 0.5s ease-in-out"></div>
          </div>
          <p style="font-size:.78rem;color:var(--text3);margin-top:.4rem">
            ℹ️ Programmer dapat memperbarui progress secara berkala. Setelah progress mencapai 100% dan file dikirim, dana akan dicairkan otomatis.
          </p>
        </div>
      </div>
      @endif

      {{-- STATE 3: COMPLETED DELIVERABLES (Berkas Pengiriman Project) --}}
      @if($project->status === 'completed')
      <div style="background:rgba(16,185,129,0.05);border:1.5px solid rgba(16,185,129,0.25);border-radius:var(--radius-lg);padding:1.25rem;margin-bottom:1rem;box-shadow:0 4px 15px rgba(16,185,129,0.04)">
        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.6rem;color:var(--green)">
          <span style="font-size:1.25rem">📦</span>
          <strong style="font-size:.9rem;font-weight:800">Hasil Pekerjaan & Berkas Project</strong>
        </div>
        <p style="font-size:.82rem;color:var(--text2);margin-bottom:1rem;line-height:1.5">
          Selamat! Project ini telah selesai 100% dan berkas hasil pengerjaan telah diserahkan oleh programmer. Dana Rekber telah dicairkan secara otomatis. Silakan akses hasil pekerjaan di bawah ini:
        </p>
        
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(150px, 1fr));gap:0.75rem">
          @if($project->zip_file)
          <a href="{{ asset('storage/' . $project->zip_file) }}" class="btn btn-sm btn-success" style="display:inline-flex;align-items:center;justify-content:center;gap:6px;font-weight:700;font-size:.8rem;padding:10px" download>
            📥 Download ZIP Berkas
          </a>
          @else
          <div style="background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius);padding:10px;text-align:center;font-size:.78rem;color:var(--text3);font-weight:600">
            📦 Berkas ZIP tidak tersedia
          </div>
          @endif
          
          @if($project->github_link)
          <a href="{{ $project->github_link }}" target="_blank" class="btn btn-sm btn-ghost" style="border-color:#24292e;color:#24292e;background:#f6f8fa;display:inline-flex;align-items:center;justify-content:center;gap:6px;font-weight:700;font-size:.8rem;padding:10px">
            <svg viewBox="0 0 16 16" fill="currentColor" style="width:16px;height:16px"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"/></svg>
            Repository GitHub
          </a>
          @else
          <div style="background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius);padding:10px;text-align:center;font-size:.78rem;color:var(--text3);font-weight:600">
            🐙 GitHub tidak terlampir
          </div>
          @endif

          @if($project->hosting_link)
          <a href="{{ str_starts_with($project->hosting_link, 'http') ? $project->hosting_link : 'https://' . $project->hosting_link }}" target="_blank" class="btn btn-sm btn-ghost" style="border-color:var(--primary);color:var(--primary);background:var(--primary-light);display:inline-flex;align-items:center;justify-content:center;gap:6px;font-weight:700;font-size:.8rem;padding:10px">
            🌐 Kunjungi Website
          </a>
          @else
          <div style="background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius);padding:10px;text-align:center;font-size:.78rem;color:var(--text3);font-weight:600">
            🌐 Hosting tidak terlampir
          </div>
          @endif
        </div>
        
        @if($project->hosting_link)
        <div style="font-size:.75rem;color:var(--text3);margin-top:10px;text-align:center">
          URL Hosting Live: <strong style="color:var(--primary)">{{ $project->hosting_link }}</strong>
        </div>
        @endif
      </div>
      @endif

      {{-- RATING SECTION: Tampil hanya ketika project completed & ada programmer --}}
      @if($project->status === 'completed' && $project->assigned_programmer_id)
      @php $existingReview = $givenReviews->get($project->id); @endphp
      <div style="background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1rem;margin-bottom:.75rem">
        @if($existingReview)
          {{-- Sudah memberikan rating --}}
          <div style="display:flex;align-items:flex-start;gap:1rem">
            <div style="font-size:1.5rem">⭐</div>
            <div style="flex:1">
              <div style="font-size:.8rem;font-weight:700;color:var(--green);margin-bottom:.25rem">Rating Anda untuk {{ $project->programmer->name ?? 'Programmer' }}</div>
              <div style="display:flex;gap:2px;margin-bottom:.35rem">
                @for($s=1;$s<=5;$s++)
                  <span style="font-size:1.2rem;color:{{ $s<=$existingReview->rating ? '#F59E0B' : '#D1D5DB' }}">★</span>
                @endfor
                <span style="font-size:.8rem;color:var(--text3);margin-left:.4rem">({{ $existingReview->rating }}/5)</span>
              </div>
              @if($existingReview->comment)
              <p style="font-size:.82rem;color:var(--text2);font-style:italic">"{{ $existingReview->comment }}"</p>
              @endif
              <div style="font-size:.72rem;color:var(--text3)">Diberikan: {{ $existingReview->created_at->format('d M Y') }}</div>
            </div>
          </div>
        @else
          {{-- Belum memberikan rating --}}
          <div style="font-size:.85rem;font-weight:700;margin-bottom:.75rem;color:var(--text)">⭐ Berikan Rating untuk {{ $project->programmer->name ?? 'Programmer' }}</div>
          <p style="font-size:.8rem;color:var(--text2);margin-bottom:.75rem">Project telah selesai! Bagikan pengalaman Anda bekerja sama dengan programmer ini.</p>
          <form method="POST" action="{{ route('umkm.project.rate', $project) }}" id="ratingFormProject-{{ $project->id }}">
            @csrf
            {{-- Star Rating --}}
            <div style="display:flex;gap:.4rem;margin-bottom:.75rem;align-items:center">
              <span style="font-size:.8rem;font-weight:600;color:var(--text2);margin-right:.4rem">Rating:</span>
              @for($s=1;$s<=5;$s++)
              <label style="cursor:pointer;font-size:1.5rem;line-height:1" title="{{ $s }} Bintang">
                <input type="radio" name="rating" value="{{ $s }}" required style="display:none" onchange="updateStars({{ $project->id }}, {{ $s }})">
                <span class="star-icon-{{ $project->id }}-{{ $s }}" style="color:#D1D5DB;transition:color .15s">★</span>
              </label>
              @endfor
              <span id="ratingLabel-{{ $project->id }}" style="font-size:.8rem;color:var(--text3);margin-left:.4rem"></span>
            </div>
            <div style="margin-bottom:.75rem">
              <textarea name="comment" placeholder="Ceritakan pengalaman Anda (opsional)..." style="width:100%;min-height:70px;padding:.6rem .75rem;border:1px solid var(--border);border-radius:var(--radius);font-size:.85rem;color:var(--text);background:var(--bg);resize:vertical;font-family:inherit" maxlength="1000"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm" id="submitRatingBtn-{{ $project->id }}" disabled>Kirim Rating ⭐</button>
          </form>
          <script>
          function updateStars(projectId, rating) {
            const labels = ['','Sangat Buruk','Buruk','Cukup','Bagus','Sangat Bagus'];
            for (let i = 1; i <= 5; i++) {
              const star = document.querySelector('.star-icon-' + projectId + '-' + i);
              if (star) star.style.color = i <= rating ? '#F59E0B' : '#D1D5DB';
            }
            const label = document.getElementById('ratingLabel-' + projectId);
            if (label) label.textContent = '(' + labels[rating] + ')';
            const btn = document.getElementById('submitRatingBtn-' + projectId);
            if (btn) btn.disabled = false;
          }
          </script>
        @endif
      </div>
      @endif

      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;border-top:1px solid var(--border);padding-top:.75rem;margin-top:.5rem">
        <div><label style="font-size:.72rem;color:var(--text3);display:block;margin-bottom:2px">Budget Disepakati</label><strong style="font-size:.875rem">{{ $project->budget > 0 ? 'Rp '.number_format($project->budget, 0, ',', '.') : 'Menunggu Penawaran' }}</strong></div>
        <div><label style="font-size:.72rem;color:var(--text3);display:block;margin-bottom:2px">Deadline</label><strong style="font-size:.875rem">{{ $project->deadline->format('d M Y') }}</strong></div>
        <div><label style="font-size:.72rem;color:var(--text3);display:block;margin-bottom:2px">Penawaran Masuk</label><strong style="font-size:.875rem">{{ $project->bids->count() }} penawaran</strong></div>
      </div>
    </div>
    @empty
    <div style="text-align:center;padding:3rem;color:var(--text3)">
      <div style="font-size:2rem;margin-bottom:.75rem">📋</div>
      <div style="font-size:1rem;font-weight:600;margin-bottom:.5rem">Belum ada project</div>
      <p style="font-size:.875rem;margin-bottom:1rem">Mulai dengan posting project pertama Anda</p>
      <button onclick="showUTab('posting')" class="btn btn-orange">+ Posting Project Sekarang</button>
    </div>
    @endforelse
  </div>

  <!-- POSTING PROJECT -->
  <div id="upane-posting" style="display:none" role="tabpanel">
    @if($user->umkm_verified)
    <!-- IMK: Clear form with field hints to guide user -->
    <div class="card" style="max-width:750px;margin:0 auto">
      <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:.5rem">📋 Posting Project Baru</h2>
      <p style="font-size:.875rem;color:var(--text2);margin-bottom:.5rem;line-height:1.6">Deskripsikan kebutuhan digital bisnis Anda. Programmer akan memberikan <strong>penawaran harga</strong> sesuai kebutuhan Anda.</p>
      <div class="imk-guide" style="border-left-color:var(--accent);margin-bottom:1.5rem">
        <div class="imk-guide-icon">💡</div>
        <div>
          <div class="imk-guide-title" style="color:var(--accent)">Alur Project di BuilderHub</div>
          <div class="imk-guide-text">
            1. 📝 <strong>Posting</strong>: Ceritakan kebutuhan bisnis Anda (tanpa perlu tahu harga dulu)<br>
            2. ✅ <strong>ACC Admin</strong>: Project Anda disetujui dan ditampilkan ke programmer<br>
            3. 💰 <strong>Terima Penawaran</strong>: Programmer mengajukan harga, Anda bisa chat & negosiasi<br>
            4. 🚀 <strong>Mulai Project</strong>: Setelah sepakat, programmer mulai mengerjakan
          </div>
        </div>
      </div>

      @if($errors->any())
      <div class="alert alert-error" role="alert">❌ {{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('umkm.project.store') }}" aria-label="Form posting project UMKM">
        @csrf
        <div class="form-group">
          <label for="title" class="form-label">Judul Project <span class="required">*</span></label>
          <input type="text" id="title" name="title" class="form-input" placeholder="Contoh: Website Toko Online untuk Usaha Batik Saya" value="{{ old('title') }}" required aria-required="true">
          <div class="form-hint">Judul yang jelas membantu programmer memahami kebutuhan Anda</div>
          @error('title')<div class="field-error">⚠ {{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="description" class="form-label">Deskripsi Kebutuhan <span class="required">*</span></label>
          <textarea id="description" name="description" class="form-textarea" style="min-height:150px" placeholder="Ceritakan detail kebutuhan Anda:&#10;- Fitur apa saja yang dibutuhkan?&#10;- Teknologi yang diinginkan (jika ada)?&#10;- Referensi website yang Anda sukai?&#10;- Jumlah produk/konten yang perlu ditampilkan?" required aria-required="true">{{ old('description') }}</textarea>
          <div class="form-hint" id="descCount">Minimal 50 karakter</div>
          @error('description')<div class="field-error">⚠ {{ $message }}</div>@enderror
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="deadline" class="form-label">Deadline ℹ️</label>
            <input type="date" id="deadline" name="deadline" class="form-input" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('deadline') }}" aria-required="true">
            <div class="form-hint">Opsional, jika ada target waktu penyelesaian</div>
            @error('deadline')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="category" class="form-label">Kategori <span class="required">*</span></label>
            <input type="text" id="category" name="category" class="form-input" placeholder="Contoh: E-Commerce, Landing Page (pisahkan dengan koma)" value="{{ old('category') }}" required aria-required="true" list="category_suggestions" autocomplete="off">
            <datalist id="category_suggestions">
              <option value="E-Commerce">
              <option value="Marketplace">
              <option value="Kuliner & Food Tech">
              <option value="Business Tools">
              <option value="Mobile App">
              <option value="Landing Page">
              <option value="FinTech">
              <option value="AI / Machine Learning">
            </datalist>
            <div class="form-hint">Anda bisa mengetik bebas lebih dari 1 kategori (pisahkan dengan koma)</div>
            @error('category')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="app_type" class="form-label">Jenis Aplikasi <span class="required">*</span></label>
            <input type="text" id="app_type" name="app_type" class="form-input" placeholder="Contoh: Aplikasi Web, Aplikasi Mobile (iOS/Android)" value="{{ old('app_type') }}" required aria-required="true" list="app_type_suggestions" autocomplete="off">
            <datalist id="app_type_suggestions">
              <option value="Aplikasi Web (Web-based)">
              <option value="Aplikasi Mobile (iOS/Android)">
              <option value="Aplikasi Desktop / Sistem Kasir">
              <option value="Sistem Informasi / ERP">
              <option value="PWA (Progressive Web App)">
              <option value="Aplikasi IoT (Internet of Things)">
            </datalist>
            <div class="form-hint">Pilih dari saran atau ketik sendiri jenis aplikasi Anda</div>
            @error('app_type')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
        </div>

        <button type="submit" class="btn btn-orange btn-full" aria-label="Submit posting project">🚀 Posting Project Sekarang</button>
      </form>
    </div>
    @else
    <div class="card" style="max-width:600px;margin:2rem auto;text-align:center;padding:3rem 2rem;border:1.5px dashed var(--orange);background:linear-gradient(135deg, var(--bg2), var(--bg));box-shadow:0 15px 35px rgba(0,0,0,0.15)">
      <div style="font-size:3.8rem;margin-bottom:1.25rem;animation:lockBounce 2s ease-in-out infinite;display:inline-block">🔒</div>
      <h3 style="font-size:1.35rem;font-weight:800;color:var(--text);margin-bottom:0.75rem;letter-spacing:-0.02em">Fitur Posting Project Terkunci</h3>
      <p style="font-size:.92rem;color:var(--text2);line-height:1.6;margin-bottom:1.5rem">
        Akun UMKM Anda belum diverifikasi oleh admin.<br>
        <strong style="color:var(--orange);font-weight:700">Menunggu 1 x 24 jam verifikasi oleh admin agar dapat memosting project.</strong>
      </p>
      <div style="background:var(--orange-light);border:1px solid rgba(245,158,11,0.25);border-radius:var(--radius);padding:1.1rem;font-size:.85rem;color:#92400E;text-align:left;line-height:1.6">
        <strong>🛡 Mengapa verifikasi ini diperlukan?</strong><br>
        Demi menjaga keamanan transaksi, validitas data, dan kepercayaan para programmer di platform BuilderHub, tim admin kami sedang meninjau dokumen pendaftaran Anda:
        <ul style="margin:6px 0 0 18px;padding:0">
          <li>Nomor KTP & Foto KTP</li>
          <li>Foto Bukti Tempat Usaha Fisik</li>
        </ul>
      </div>
      <button onclick="showUTab('overview')" class="btn btn-ghost btn-sm" style="margin-top:1.75rem;border-color:var(--border);color:var(--text2);font-weight:600">Kembali ke Overview</button>
    </div>
    @endif
  </div>

  <!-- PROGRAMMERS TAB -->
  <div id="upane-programmers" style="display:none" role="tabpanel">
    <div class="imk-guide" style="border-left-color:var(--accent)">
      <div class="imk-guide-icon">💡</div>
      <div>
        <div class="imk-guide-title" style="color:var(--accent)">Daftar Programmer Berpengalaman & Terverifikasi</div>
        <div class="imk-guide-text">Hubungi programmer terbaik untuk diajak bekerja sama dalam mewujudkan kebutuhan digital bisnis Anda.</div>
      </div>
    </div>
    
    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:1.25rem;margin-top:1.5rem">
      @foreach($programmers as $p)
      <div class="card" style="display:flex;flex-direction:column;justify-content:between;transition:.15s" onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='var(--border)'">
        <div>
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:1rem">
            <div style="width:48px;height:48px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.1rem">{{ strtoupper(substr($p->name, 0, 1)) }}</div>
            <div>
              <div style="font-weight:700;font-size:.95rem;display:flex;align-items:center;gap:4px">
                {{ $p->name }}
                @if($p->is_verified)<span style="color:var(--green);font-size:.8rem" title="Terverifikasi">✅</span>@endif
              </div>
              <div style="font-size:.78rem;color:var(--text3)">{{ $p->city }} · ⭐ {{ number_format($p->rating ?: 5.0, 1) }}</div>
            </div>
          </div>
          <div style="background:var(--bg2);padding:.5rem;border-radius:var(--radius-sm);font-size:.78rem;margin-bottom:.75rem">
            <strong>Keahlian:</strong> {{ $p->expertise ?: 'Web Developer' }}
          </div>
          <p style="font-size:.82rem;color:var(--text2);line-height:1.5;margin-bottom:1rem">{{ Str::limit($p->bio ?: 'Programmer profesional BuilderHub.', 120) }}</p>
        </div>
        <div style="border-top:1px solid var(--border);padding-top:.75rem;margin-top:auto;display:flex;justify-content:space-between;align-items:center">
          <span style="font-size:.78rem;color:var(--text3)">💼 {{ $p->total_projects ?: 0 }} Selesai</span>
          <a href="{{ route('messages.index') }}?contact_id={{ $p->id }}&msg=Halo%2C%20apakah%20programmer%20ini%20tersedia%20untuk%20mengerjakan%20project%20saya%3F" class="btn btn-sm btn-ghost" style="border-color:var(--accent);color:var(--accent)">Hubungi Programmer</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

<!-- ===== CHAT / NEGOTIATION MODAL (IMK: Real-time communication) ===== -->
<div id="chatModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:9999;align-items:center;justify-content:center;padding:1rem">
  <div style="background:#1a1a2e;border:1px solid rgba(255,255,255,.12);border-radius:16px;width:100%;max-width:520px;height:560px;display:flex;flex-direction:column;box-shadow:0 25px 60px rgba(0,0,0,.5)">
    <!-- Header -->
    <div style="padding:1rem 1.25rem;border-bottom:1px solid rgba(255,255,255,.08);display:flex;justify-content:space-between;align-items:center">
      <div>
        <div id="chatReceiverName" style="font-weight:700;color:#fff;font-size:.95rem">💬 Chat Negosiasi</div>
        <div style="font-size:.72rem;color:rgba(255,255,255,.4);margin-top:2px">Diskusikan kebutuhan dan sepakati harga project Anda</div>
      </div>
      <button onclick="closeChat()" style="background:rgba(255,255,255,.08);border:none;border-radius:50%;width:32px;height:32px;color:#fff;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center">&times;</button>
    </div>
    <!-- IMK Tip -->
    <div style="padding:.6rem 1.25rem;background:rgba(109,56,255,.15);border-bottom:1px solid rgba(109,56,255,.2);font-size:.75rem;color:rgba(255,255,255,.65)">
      💡 <strong>Tips Negosiasi:</strong> Sampaikan anggaran yang Anda punya, tanyakan estimasi fitur, dan sepakati harga bersama sebelum menekan "Terima Penawaran".
    </div>
    <!-- Messages -->
    <div id="chatMessages" style="flex:1;overflow-y:auto;padding:1.25rem;display:flex;flex-direction:column;gap:.25rem"></div>
    <!-- Input -->
    <div style="padding:.875rem 1.25rem;border-top:1px solid rgba(255,255,255,.08);display:flex;gap:.5rem;align-items:flex-end">
      <textarea id="chatInput" placeholder="Ketik pesan negosiasi... (Enter untuk kirim)" rows="1" style="flex:1;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:.6rem .875rem;color:#fff;font-size:.875rem;resize:none;outline:none;font-family:inherit" oninput="this.style.height='auto';this.style.height=Math.min(this.scrollHeight,100)+'px'"></textarea>
      <button onclick="sendChatMessage('umkm')" style="background:var(--primary);border:none;border-radius:10px;padding:.6rem 1rem;color:#fff;font-size:1.1rem;cursor:pointer;flex-shrink:0" title="Kirim pesan">➤</button>
    </div>
  </div>
</div>

@push('scripts')
<style>
@keyframes badgePulse {
  0%, 100% { transform: scale(1); box-shadow: 0 2px 6px rgba(239,68,68,0.5); }
  50% { transform: scale(1.15); box-shadow: 0 4px 12px rgba(239,68,68,0.7); }
}
@keyframes lockBounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}
/* Sembunyikan panah drop-down bawaan browser yang kaku pada input datalist */
input[list]::-webkit-calendar-picker-indicator {
  display: none !important;
}
</style>
<script>
function showUTab(name){
  ['overview','projects','posting','programmers'].forEach(t=>{
    const pane = document.getElementById('upane-'+t);
    if(pane) pane.style.display = 'none';
    const btn = document.getElementById('utab-'+t);
    if(btn){ btn.classList.remove('active'); btn.style.color=''; btn.style.borderBottomColor=''; }
  });
  const activePane = document.getElementById('upane-'+name);
  if(activePane) activePane.style.display = 'block';
  const activeBtn = document.getElementById('utab-'+name);
  if(activeBtn){ activeBtn.classList.add('active'); activeBtn.style.color='var(--accent)'; activeBtn.style.borderBottomColor='var(--accent)'; }
  history.replaceState(null,'','#'+name);
  if(window.checkMascotVisibility) window.checkMascotVisibility(name);

  // Ketika tab Projects dibuka, mark semua bid sebagai sudah dilihat
  if (name === 'projects') {
    markBidsSeen();
  }
}

// Mark bid sebagai sudah dilihat oleh UMKM via AJAX
function markBidsSeen() {
  const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
  fetch(window.APP_URL + '/umkm/bids/mark-seen', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json', 'Content-Type': 'application/json' }
  }).then(r => r.json()).then(data => {
    if (data.ok) {
      // Sembunyikan badge
      const badge = document.getElementById('projectsBadge');
      if (badge) badge.style.display = 'none';
    }
  }).catch(() => {});
}

// Poll badge count setiap 30 detik (agar jika programmer baru kirim bid, badge muncul tanpa reload)
function pollUnseenBidsCount() {
  fetch(window.APP_URL + '/umkm/bids/unseen-count', {
    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
  }).then(r => r.json()).then(data => {
    const badge = document.getElementById('projectsBadge');
    if (!badge) return;
    if (data.count > 0) {
      badge.textContent = data.count;
      badge.style.display = 'inline-flex';
    } else {
      badge.style.display = 'none';
    }
  }).catch(() => {});
}

// Jalankan polling setiap 30 detik
setInterval(pollUnseenBidsCount, 30000);
function calcFee(){ /* removed - budget now set by programmer */ }
// IMK: Real-time description character count
document.getElementById('description')?.addEventListener('input', function(){
  const l = this.value.length;
  const el = document.getElementById('descCount');
  if(l < 50) { el.textContent = `Minimal 50 karakter (${l}/50)`; el.style.color = 'var(--red)'; }
  else { el.textContent = `${l} karakter ✓`; el.style.color = 'var(--green)'; }
});

// Restore active tab
const hash = location.hash.replace('#','');
if(['overview','projects','posting','programmers'].includes(hash)) showUTab(hash);

// Dengarkan perubahan hash secara dinamis (misal klik notifikasi)
window.addEventListener('hashchange', () => {
  const newHash = location.hash.replace('#','');
  if(['overview','projects','posting','programmers'].includes(newHash)) showUTab(newHash);
});

// ===== CHAT / NEGOTIATION SYSTEM =====
let chatProjectId = null, chatReceiverId = null, chatPollInterval = null;

function openChat(projectId, receiverId, receiverName, role) {
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.setProperty('display', 'none', 'important');
  chatProjectId = projectId;
  chatReceiverId = receiverId;
  document.getElementById('chatReceiverName').textContent = '💬 Negosiasi dengan ' + receiverName;
  document.getElementById('chatModal').style.display = 'flex';
  document.getElementById('chatMessages').innerHTML = '<div style="text-align:center;color:rgba(255,255,255,.4);font-size:.8rem;padding:1rem">Memuat percakapan...</div>';
  loadMessages(role);
  if (chatPollInterval) clearInterval(chatPollInterval);
  chatPollInterval = setInterval(() => loadMessages(role), 4000);
}

function loadMessages(role) {
  const url = window.APP_URL + '/' + (role === 'umkm' ? 'umkm' : 'programmer') + '/project/' + chatProjectId + '/messages';
  fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(msgs => {
      const box = document.getElementById('chatMessages');
      if (!msgs.length) {
        box.innerHTML = '<div style="text-align:center;color:rgba(255,255,255,.4);font-size:.8rem;padding:2rem">Belum ada pesan. Mulai negosiasi sekarang!</div>';
        return;
      }
      box.innerHTML = msgs.map(m => `
        <div style="display:flex;flex-direction:column;align-items:${m.is_me ? 'flex-end' : 'flex-start'};margin-bottom:.75rem">
          <div style="font-size:.7rem;color:rgba(255,255,255,.4);margin-bottom:2px">${m.sender} · ${m.created_at}</div>
          <div style="max-width:75%;padding:.6rem .9rem;border-radius:${m.is_me ? '14px 14px 4px 14px' : '14px 14px 14px 4px'};background:${m.is_me ? 'var(--primary)' : 'rgba(255,255,255,.1)'};color:#fff;font-size:.875rem;line-height:1.5">${m.message.replace(/</g,'&lt;')}</div>
        </div>
      `).join('');
      box.scrollTop = box.scrollHeight;
    }).catch(() => {});
}

function sendChatMessage(role) {
  const input = document.getElementById('chatInput');
  const msg = input.value.trim();
  if (!msg) return;
  const url = window.APP_URL + '/' + (role === 'umkm' ? 'umkm' : 'programmer') + '/project/' + chatProjectId + '/message';
  const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
  fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
    body: JSON.stringify({ message: msg, receiver_id: chatReceiverId })
  }).then(r => r.json()).then(data => {
    if (data.ok) { input.value = ''; loadMessages(role); }
    else alert(data.error || 'Gagal mengirim pesan.');
  }).catch(() => alert('Gagal mengirim pesan.'));
}

function closeChat() {
  document.getElementById('chatModal').style.display = 'none';
  if (chatPollInterval) clearInterval(chatPollInterval);
  chatPollInterval = null;
  location.reload();
}

document.getElementById('chatInput')?.addEventListener('keydown', e => {
  if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendChatMessage('umkm'); }
});

// ===== PROJECT EDIT SYSTEM =====
function openEditProjectModal(id, title, description, deadline, category, appType) {
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.setProperty('display', 'none', 'important');
  const form = document.getElementById('editProjectForm');
  form.action = window.APP_URL + '/umkm/project/' + id;
  document.getElementById('editProjTitle').value = title;
  document.getElementById('editProjDesc').value = description;
  document.getElementById('editProjDeadline').value = deadline;
  document.getElementById('editProjCategory').value = category;
  document.getElementById('editProjAppType').value = appType;
  document.getElementById('editProjectModal').style.display = 'flex';
  if (window.updateEditProjectCounter) window.updateEditProjectCounter();
}
function closeEditProjectModal() {
  document.getElementById('editProjectModal').style.display = 'none';
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.removeProperty('display');
  if(window.checkMascotVisibility) window.checkMascotVisibility();
}

// Edit Project description counter
document.addEventListener('DOMContentLoaded', function() {
  const editProjDesc = document.getElementById('editProjDesc');
  const editProjCounter = document.getElementById('editProjDescCount');
  if (editProjDesc && editProjCounter) {
    const updateEditCount = () => {
      const len = editProjDesc.value.length;
      if (len < 50) {
        editProjCounter.textContent = `Minimal 50 karakter (${len}/50)`;
        editProjCounter.style.color = 'var(--red)';
      } else {
        editProjCounter.textContent = `${len} karakter ✓`;
        editProjCounter.style.color = 'var(--green)';
      }
    };
    editProjDesc.addEventListener('input', updateEditCount);
    window.updateEditProjectCounter = updateEditCount;
  }
});

// Real-time filtering project UMKM
function filterUmkmProjects() {
  const query = document.getElementById('umkmSearchProject').value.toLowerCase().trim();
  const status = document.getElementById('umkmFilterStatus').value;
  const cards = document.querySelectorAll('.umkm-project-card');
  const resultText = document.getElementById('umkmProjectsSearchResultText');
  const filteredCountEl = document.getElementById('umkmFilteredCount');
  const totalCountEl = document.getElementById('umkmTotalCount');
  
  let visibleCount = 0;
  
  cards.forEach(card => {
    const title = card.getAttribute('data-title') || '';
    const desc = card.getAttribute('data-desc') || '';
    const cardStatus = card.getAttribute('data-status') || '';
    
    const matchesQuery = title.includes(query) || desc.includes(query);
    const matchesStatus = status === '' || cardStatus === status;
    
    if (matchesQuery && matchesStatus) {
      card.style.display = 'block';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });
  
  totalCountEl.textContent = cards.length;
  filteredCountEl.textContent = visibleCount;
  
  if (query !== '' || status !== '') {
    resultText.style.display = 'block';
  } else {
    resultText.style.display = 'none';
  }
}

// ===== ESCROW PAYMENT SYSTEM =====
let currentPayProjectId = null;

function openEscrowPaymentModal(projectId, title, programmerName, budget) {
  currentPayProjectId = projectId;
  const form = document.getElementById('escrowPaymentForm');
  form.action = window.APP_URL + '/umkm/project/' + projectId + '/pay';
  
  document.getElementById('payProjectTitle').textContent = title;
  document.getElementById('payProjectProgrammer').textContent = programmerName;
  document.getElementById('payProjectBudget').textContent = 'Rp ' + budget.toLocaleString('id-ID');
  
  // Generate simulated VA numbers dynamically
  const userId = '{{ auth()->id() }}';
  // BNI VA prefix 98801, BRI 92002, BJB 95003, Mandiri 90004
  window.vaNumbers = {
    qris: '',
    bni: '98801' + userId.toString().padStart(3, '0') + projectId.toString().padStart(4, '0'),
    bri: '92002' + userId.toString().padStart(3, '0') + projectId.toString().padStart(4, '0'),
    bjb: '95003' + userId.toString().padStart(3, '0') + projectId.toString().padStart(4, '0'),
    mandiri: '90004' + userId.toString().padStart(3, '0') + projectId.toString().padStart(4, '0')
  };
  
  // Select QRIS by default
  const qrisRadio = document.querySelector('input[name="payment_method"][value="QRIS"]');
  if (qrisRadio) qrisRadio.checked = true;
  selectPayMethod('qris');
  
  document.getElementById('escrowPaymentModal').style.display = 'flex';
  
  // Hide mascot if visible
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.setProperty('display', 'none', 'important');
}

function closeEscrowPaymentModal() {
  document.getElementById('escrowPaymentModal').style.display = 'none';
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.removeProperty('display');
  if(window.checkMascotVisibility) window.checkMascotVisibility();
}

function selectPayMethod(method) {
  // Reset borders & backgrounds on all card containers
  ['qris', 'bni', 'bri', 'bjb'].forEach(m => {
    const card = document.getElementById('pay_card_' + m);
    if (card) {
      card.style.borderColor = 'rgba(255,255,255,0.08)';
      card.style.background = 'rgba(255,255,255,0.02)';
    }
  });
  
  // Highlight the selected one
  const activeCard = document.getElementById('pay_card_' + method);
  if (activeCard) {
    activeCard.style.borderColor = 'var(--primary)';
    activeCard.style.background = 'rgba(79,70,229,0.12)';
  }
  
  // Show/hide detail panels
  if (method === 'qris') {
    document.getElementById('pay_detail_qris').style.display = 'block';
    document.getElementById('pay_detail_va').style.display = 'none';
  } else {
    document.getElementById('pay_detail_qris').style.display = 'none';
    document.getElementById('pay_detail_va').style.display = 'block';
    
    const vaNumber = window.vaNumbers[method] || '';
    document.getElementById('vaNumberText').textContent = vaNumber;
  }
}

function copyVaNumber() {
  const num = document.getElementById('vaNumberText').textContent;
  navigator.clipboard.writeText(num).then(() => {
    alert('📋 Nomor Virtual Account berhasil disalin: ' + num);
  }).catch(() => {
    alert('Gagal menyalin. Silakan salin manual: ' + num);
  });
}
</script>
@endpush

<!-- Edit Project Modal -->
<div id="editProjectModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;padding:1rem">
  <div style="background:var(--bg);border-radius:var(--radius-xl);padding:2rem;max-width:540px;width:100%;max-height:90vh;overflow-y:auto">
    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:1rem">✏️ Edit Pengajuan Project</h3>
    <form id="editProjectForm" method="POST" aria-label="Form edit project">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label class="form-label" for="editProjTitle">Judul Project</label>
        <input id="editProjTitle" name="title" class="form-input" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="editProjDesc">Deskripsi Kebutuhan</label>
        <textarea id="editProjDesc" name="description" class="form-textarea" style="min-height:120px" required></textarea>
        <div id="editProjDescCount" style="font-size:0.78rem;margin-top:4px;font-weight:600;color:var(--text3)">
          Minimal 50 karakter (0/50)
        </div>
      </div>
      <div class="form-group">
        <label class="form-label" for="editProjDeadline">Deadline</label>
        <input id="editProjDeadline" type="date" name="deadline" class="form-input">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="editProjCategory">Kategori</label>
          <input type="text" id="editProjCategory" name="category" class="form-input" placeholder="Contoh: E-Commerce, Landing Page (pisahkan koma)" required list="category_suggestions" autocomplete="off">
        </div>
        <div class="form-group">
          <label class="form-label" for="editProjAppType">Jenis Aplikasi</label>
          <input type="text" id="editProjAppType" name="app_type" class="form-input" placeholder="Contoh: Aplikasi Web, Aplikasi Mobile" required list="app_type_suggestions" autocomplete="off">
        </div>
      </div>
      <div style="display:flex;gap:.5rem;justify-content:flex-end;margin-top:1.5rem">
        <button type="button" onclick="closeEditProjectModal()" class="btn btn-ghost btn-sm">Batal</button>
        <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- ===== PAYMENT GATEWAY MODAL (REKBER ESCROW) ===== -->
<div id="escrowPaymentModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:99999;align-items:center;justify-content:center;padding:1rem;backdrop-filter:blur(6px)">
  <div style="background:#0f172a;border:1.5px solid rgba(255,255,255,.1);border-radius:20px;width:100%;max-width:540px;display:flex;flex-direction:column;box-shadow:0 25px 60px rgba(0,0,0,.8);overflow:hidden;color:#e2e8f0;font-family:inherit">
    <!-- Header -->
    <div style="padding:1.25rem 1.5rem;border-bottom:1px solid rgba(255,255,255,.08);display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg, #1e1b4b, #0f172a)">
      <div>
        <div style="font-weight:800;color:#fff;font-size:1.15rem;display:flex;align-items:center;gap:8px">
          🛡️ Payment Gateway Rekber
        </div>
        <div style="font-size:.78rem;color:rgba(255,255,255,.6);margin-top:2px">Pembayaran Aman & Terlindungi oleh BuilderHub</div>
      </div>
      <button onclick="closeEscrowPaymentModal()" style="background:rgba(255,255,255,.08);border:none;border-radius:50%;width:32px;height:32px;color:#fff;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center">&times;</button>
    </div>

    <form id="escrowPaymentForm" method="POST">
      @csrf
      <div style="padding:1.5rem;max-height:70vh;overflow-y:auto">
        <!-- Project Summary Card -->
        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:1rem;margin-bottom:1.25rem">
          <div style="font-size:0.75rem;color:var(--text3);text-transform:uppercase;font-weight:700">Project yang Dibayar</div>
          <div id="payProjectTitle" style="font-size:0.95rem;font-weight:800;color:#fff;margin-top:2px">Judul Project</div>
          <div style="font-size:0.8rem;color:var(--text2);margin-top:4px">Programmer: <strong id="payProjectProgrammer" style="color:var(--accent)">Nama Programmer</strong></div>
          
          <div style="border-top:1.5px dashed rgba(255,255,255,0.1);margin:0.75rem 0;padding-top:0.75rem;display:flex;justify-content:space-between;align-items:center">
            <span style="font-size:0.85rem;color:#fff;font-weight:700">Total Pembayaran</span>
            <span id="payProjectBudget" style="font-size:1.15rem;font-weight:800;color:var(--green)">Rp 0</span>
          </div>
        </div>

        <!-- Payment Methods Grid -->
        <div style="margin-bottom:1.25rem">
          <label style="display:block;font-size:0.85rem;font-weight:700;margin-bottom:0.6rem;color:#fff">Pilih Metode Pembayaran</label>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
            
            <!-- QRIS Option -->
            <label style="cursor:pointer;position:relative">
              <input type="radio" name="payment_method" value="QRIS" checked style="position:absolute;opacity:0" onchange="selectPayMethod('qris')">
              <div id="pay_card_qris" style="border:2px solid var(--primary);background:rgba(79,70,229,0.15);border-radius:12px;padding:0.85rem;text-align:center;transition:all 0.2s">
                <div style="font-size:1.5rem">🤳</div>
                <div style="font-weight:800;font-size:0.85rem;color:#fff;margin-top:4px">QRIS / E-Wallet</div>
                <div style="font-size:0.7rem;color:var(--text3);margin-top:2px">Gopay, OVO, Dana, LinkAja</div>
              </div>
            </label>

            <!-- BNI VA Option -->
            <label style="cursor:pointer;position:relative">
              <input type="radio" name="payment_method" value="BNI Virtual Account" style="position:absolute;opacity:0" onchange="selectPayMethod('bni')">
              <div id="pay_card_bni" style="border:2px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);border-radius:12px;padding:0.85rem;text-align:center;transition:all 0.2s">
                <div style="font-size:1.5rem">🏦</div>
                <div style="font-weight:800;font-size:0.85rem;color:#fff;margin-top:4px">BNI VA</div>
                <div style="font-size:0.7rem;color:var(--text3);margin-top:2px">Transfer VA BNI</div>
              </div>
            </label>

            <!-- BRI VA Option -->
            <label style="cursor:pointer;position:relative">
              <input type="radio" name="payment_method" value="BRI Virtual Account" style="position:absolute;opacity:0" onchange="selectPayMethod('bri')">
              <div id="pay_card_bri" style="border:2px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);border-radius:12px;padding:0.85rem;text-align:center;transition:all 0.2s">
                <div style="font-size:1.5rem">🏦</div>
                <div style="font-weight:800;font-size:0.85rem;color:#fff;margin-top:4px">BRI BRIVA</div>
                <div style="font-size:0.7rem;color:var(--text3);margin-top:2px">Transfer BRIVA</div>
              </div>
            </label>

            <!-- BJB VA Option -->
            <label style="cursor:pointer;position:relative">
              <input type="radio" name="payment_method" value="BJB Virtual Account" style="position:absolute;opacity:0" onchange="selectPayMethod('bjb')">
              <div id="pay_card_bjb" style="border:2px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);border-radius:12px;padding:0.85rem;text-align:center;transition:all 0.2s">
                <div style="font-size:1.5rem">🏦</div>
                <div style="font-weight:800;font-size:0.85rem;color:#fff;margin-top:4px">BJB VA</div>
                <div style="font-size:0.7rem;color:var(--text3);margin-top:2px">Transfer VA BJB</div>
              </div>
            </label>

          </div>
        </div>

        <!-- Dynamic Payment Instructions Screen -->
        <div style="background:rgba(255,255,255,0.02);border:1px dashed rgba(255,255,255,0.1);border-radius:14px;padding:1.25rem">
          
          <!-- QRIS Detail Panel -->
          <div id="pay_detail_qris" style="display:block;text-align:center">
            <div style="font-weight:800;font-size:0.9rem;color:#fff;margin-bottom:0.5rem">Scan Kode QRIS di Bawah Ini</div>
            
            <!-- Simulated QR Code Card with animation -->
            <div style="position:relative;width:180px;height:180px;margin:1rem auto;background:#fff;border-radius:12px;padding:10px;box-shadow:0 0 20px rgba(16,185,129,0.25);border:3px solid #10b981">
              <!-- Moving laser line -->
              <div style="position:absolute;left:10px;right:10px;height:3px;background:#10b981;box-shadow:0 0 8px #10b981;animation:qrisLaser 2s linear infinite;z-index:5"></div>
              <!-- QR Image -->
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=BuilderHubEscrowPayment" style="width:100%;height:100%;display:block" alt="QRIS Code">
            </div>
            
            <p style="font-size:0.78rem;color:var(--text3);line-height:1.5">
              Buka aplikasi e-wallet Anda (Gopay, OVO, ShopeePay, Dana) atau aplikasi mobile banking, lalu scan kode QR di atas untuk membayar.
            </p>
          </div>

          <!-- VA Detail Panel -->
          <div id="pay_detail_va" style="display:none">
            <div style="font-weight:700;font-size:0.88rem;color:#fff;margin-bottom:0.6rem">Nomor Virtual Account Anda</div>
            
            <div style="display:flex;align-items:center;background:rgba(0,0,0,0.3);border:1.5px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.75rem 1rem;margin-bottom:1rem;justify-content:space-between">
              <span id="vaNumberText" style="font-size:1.25rem;font-weight:900;color:var(--accent);letter-spacing:1.5px">98801123456789</span>
              <button type="button" onclick="copyVaNumber()" style="background:var(--primary);color:#fff;border:none;border-radius:6px;padding:4px 10px;font-size:0.75rem;font-weight:700;cursor:pointer;transition:all 0.15s">
                📋 Salin
              </button>
            </div>
            
            <div style="font-size:0.8rem;color:#fff;font-weight:700;margin-bottom:4px">Petunjuk Transfer:</div>
            <ul style="font-size:0.75rem;color:var(--text2);margin:0;padding-left:16px;line-height:1.6">
              <li>Pilih menu Transfer atau Pembayaran Virtual Account pada ATM / Mobile Banking Anda.</li>
              <li>Masukkan Nomor Virtual Account di atas.</li>
              <li>Pastikan nama merchant yang muncul adalah <strong style="color:#fff">BuilderHub Escrow</strong>.</li>
              <li>Masukkan jumlah dana sesuai nominal project.</li>
              <li>Transaksi akan otomatis terverifikasi setelah transfer berhasil.</li>
            </ul>
          </div>

        </div>

      </div>

      <!-- Footer Buttons -->
      <div style="padding:1.25rem 1.5rem;border-top:1px solid rgba(255,255,255,.08);display:flex;gap:0.75rem;background:rgba(255,255,255,0.01)">
        <button type="submit" class="btn btn-success" style="flex:1;font-weight:800;font-size:0.9rem;box-shadow:0 4px 15px rgba(16,185,129,0.3)">
          ✅ Konfirmasi Pembayaran Berhasil
        </button>
        <button type="button" onclick="closeEscrowPaymentModal()" class="btn btn-ghost" style="color:var(--text2);border-color:var(--border)">
          Batal
        </button>
      </div>
    </form>
  </div>
</div>

<style>
@keyframes qrisLaser {
  0% { top: 10px; }
  50% { top: 170px; }
  100% { top: 10px; }
}
</style>
@endsection
