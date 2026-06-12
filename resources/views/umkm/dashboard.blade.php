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
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="btn btn-ghost btn-sm" style="border-color:var(--red);color:var(--red);background:var(--red-light)" aria-label="Keluar dari akun">Keluar 🚪</button>
      </form>
    </div>
  </div>

  <!-- IMK: Tabs for distinct task separation -->
  <div class="tab-bar" role="tablist">
    <button class="tab-btn active" onclick="showUTab('overview')" id="utab-overview" role="tab" aria-selected="true" style="color:var(--accent);border-bottom-color:var(--accent)">📊 Overview</button>
    <button class="tab-btn" onclick="showUTab('projects')" id="utab-projects" role="tab">📋 Project Saya</button>
    <button class="tab-btn" onclick="showUTab('posting')" id="utab-posting" role="tab">+ Posting Project</button>
    <button class="tab-btn" onclick="showUTab('programmers')" id="utab-programmers" role="tab">🧑‍💻 Daftar Programmer</button>
  </div>

  <!-- OVERVIEW -->
  <div id="upane-overview" role="tabpanel">
    <div class="stats-grid">
      <div class="stat-card"><div class="stat-card-icon">📋</div><div class="stat-card-value">{{ $projects->count() }}</div><div class="stat-card-label">Total Project</div></div>
      <div class="stat-card"><div class="stat-card-icon">⏳</div><div class="stat-card-value">{{ $projects->where('status','in_progress')->count() }}</div><div class="stat-card-label">Sedang Berjalan</div></div>
      <div class="stat-card"><div class="stat-card-icon">✅</div><div class="stat-card-value">{{ $projects->where('status','completed')->count() }}</div><div class="stat-card-label">Selesai</div></div>
      <div class="stat-card"><div class="stat-card-icon">⏰</div><div class="stat-card-value">{{ $projects->where('status','open')->count() }}</div><div class="stat-card-label">Menunggu</div></div>
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
        <p style="font-size:.85rem;color:var(--text2);line-height:1.6">Dokumen legalitas Anda sudah diverifikasi tim BuilderHub. Project Anda lebih dipercaya programmer.</p>
        @else
        <div style="background:var(--orange-light);border:1px solid rgba(245,158,11,.3);border-radius:var(--radius);padding:.85rem 1rem;font-size:.85rem;color:#92400E;margin-bottom:.75rem">⏳ Belum Terverifikasi</div>
        <p style="font-size:.85rem;color:var(--text2);line-height:1.6">Upload dokumen SIUP/NIB ke tim admin untuk mendapatkan badge <strong>UMKM Verified</strong> dan meningkatkan kepercayaan programmer.</p>
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
    @forelse($projects as $project)
    <div class="card" style="margin-bottom:1rem">
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
      <p style="font-size:.85rem;color:var(--text2);margin-bottom:.75rem">{{ Str::limit($project->description, 120) }}</p>

      @if($project->status === 'open' && $project->bids->count())
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
              </div>
              <div style="font-size:.82rem;color:var(--text2);margin-top:2px">{{ Str::limit($bid->message, 80) }}</div>
              <div style="font-size:.75rem;color:var(--text3);margin-top:2px">⏱ {{ $bid->timeline_days }} hari pengerjaan</div>
            </div>
          </div>
          <div style="text-align:right;flex-shrink:0;margin-left:1rem;display:flex;flex-direction:column;align-items:flex-end;gap:.4rem">
            <div style="font-size:1rem;font-weight:800;color:var(--primary)">Rp {{ number_format($bid->amount, 0, ',', '.') }}</div>
            <div style="display:flex;gap:.4rem">
              <!-- IMK: Chat button for negotiation -->
              <button onclick="openChat({{ $project->id }}, {{ $bid->programmer->id }}, '{{ addslashes($bid->programmer->name) }}', 'umkm')" class="btn btn-ghost btn-sm" style="font-size:.75rem;padding:4px 10px">💬 Chat</button>
              <!-- IMK: Accept button with confirmation -->
              @php $confirmMsg = "Terima penawaran Rp " . number_format($bid->amount, 0, ',', '.') . " dari {$bid->programmer->name}? Budget project akan otomatis disesuaikan."; @endphp
              <form method="POST" action="{{ route('umkm.bid.accept', $bid) }}" onsubmit="return confirm('{{ addslashes($confirmMsg) }}')">
                @csrf
                <button type="submit" class="btn btn-success btn-sm" style="font-size:.75rem;padding:4px 10px">Terima ✅</button>
              </form>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @endif

      @if($project->status === 'in_progress' && $project->programmer)
      <div style="background:var(--orange-light);border:1px solid rgba(245,158,11,.2);border-radius:var(--radius);padding:.75rem;margin-bottom:.75rem;display:flex;justify-content:space-between;align-items:center">
        <div>
          <span style="font-size:.85rem;font-weight:700">🧑‍💻 Dikerjakan: {{ $project->programmer->name }}</span>
          @if($project->budget > 0)
          <div style="font-size:.78rem;color:var(--text3);margin-top:2px">Budget Disepakati: <strong style="color:var(--primary)">Rp {{ number_format($project->budget, 0, ',', '.') }}</strong></div>
          @endif
        </div>
        <div style="display:flex;gap:.5rem;align-items:center">
          <button onclick="openChat({{ $project->id }}, {{ $project->programmer->id }}, '{{ addslashes($project->programmer->name) }}', 'umkm')" class="btn btn-ghost btn-sm">💬 Chat Programmer</button>
          <form method="POST" action="{{ route('umkm.project.complete', $project) }}" onsubmit="return confirm('Tandai project sebagai selesai? Dana akan dikirim ke programmer.')">
            @csrf
            <button type="submit" class="btn btn-success btn-sm" aria-label="Selesaikan project">✅ Selesai & Bayar</button>
          </form>
        </div>
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
            <select id="category" name="category" class="form-select" required aria-required="true">
              <option value="">Pilih kategori</option>
              @foreach(['E-Commerce','Marketplace','Kuliner & Food Tech','Business Tools','Mobile App','Landing Page','Lainnya'] as $cat)
              <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
              @endforeach
            </select>
            @error('category')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="app_type" class="form-label">Jenis Aplikasi <span class="required">*</span></label>
            <select id="app_type" name="app_type" class="form-select" required aria-required="true">
              <option value="">Pilih jenis aplikasi</option>
              @foreach(['Aplikasi Web (Web-based)','Aplikasi Mobile (iOS/Android)','Aplikasi Desktop / Sistem Kasir','Sistem Informasi / ERP','Lainnya'] as $type)
              <option value="{{ $type }}" {{ old('app_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
              @endforeach
            </select>
            <div class="form-hint">Tentukan platform media utama aplikasi Anda</div>
            @error('app_type')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
        </div>

        <button type="submit" class="btn btn-orange btn-full" aria-label="Submit posting project">🚀 Posting Project Sekarang</button>
      </form>
    </div>
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
          <a href="mailto:{{ $p->email }}" class="btn btn-sm btn-ghost" style="border-color:var(--accent);color:var(--accent)">Hubungi Programmer</a>
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
}
function calcFee(){ /* removed - budget now set by programmer */ }
// IMK: Real-time description character count
document.getElementById('description')?.addEventListener('input', function(){
  const l = this.value.length;
  const el = document.getElementById('descCount');
  if(l < 50) { el.textContent = `Minimal 50 karakter (${l}/50)`; el.style.color = 'var(--red)'; }
  else { el.textContent = `${l} karakter ✓`; el.style.color = 'var(--green)'; }
});

const hash = location.hash.replace('#','');
if(['overview','projects','posting','programmers'].includes(hash)) showUTab(hash);

// ===== CHAT / NEGOTIATION SYSTEM =====
let chatProjectId = null, chatReceiverId = null, chatPollInterval = null;

function openChat(projectId, receiverId, receiverName, role) {
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
}

document.getElementById('chatInput')?.addEventListener('keydown', e => {
  if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendChatMessage('umkm'); }
});

// ===== PROJECT EDIT SYSTEM =====
function openEditProjectModal(id, title, description, deadline, category, appType) {
  const form = document.getElementById('editProjectForm');
  form.action = window.APP_URL + '/umkm/project/' + id;
  document.getElementById('editProjTitle').value = title;
  document.getElementById('editProjDesc').value = description;
  document.getElementById('editProjDeadline').value = deadline;
  document.getElementById('editProjCategory').value = category;
  document.getElementById('editProjAppType').value = appType;
  document.getElementById('editProjectModal').style.display = 'flex';
}
function closeEditProjectModal() {
  document.getElementById('editProjectModal').style.display = 'none';
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
      </div>
      <div class="form-group">
        <label class="form-label" for="editProjDeadline">Deadline</label>
        <input id="editProjDeadline" type="date" name="deadline" class="form-input">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="editProjCategory">Kategori</label>
          <select id="editProjCategory" name="category" class="form-select" required>
            @foreach(['E-Commerce','Marketplace','Kuliner & Food Tech','Business Tools','Mobile App','Landing Page','Lainnya'] as $cat)
            <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="editProjAppType">Jenis Aplikasi</label>
          <select id="editProjAppType" name="app_type" class="form-select" required>
            @foreach(['Aplikasi Web (Web-based)','Aplikasi Mobile (iOS/Android)','Aplikasi Desktop / Sistem Kasir','Sistem Informasi / ERP','Lainnya'] as $type)
            <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div style="display:flex;gap:.5rem;justify-content:flex-end;margin-top:1.5rem">
        <button type="button" onclick="closeEditProjectModal()" class="btn btn-ghost btn-sm">Batal</button>
        <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection
