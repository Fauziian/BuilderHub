@extends('layouts.app')
@section('title', 'BuilderHub')
@section('content')
<!-- HERO -->
<section class="hero" style="background:linear-gradient(135deg,#0F0F1A 0%,#1E1260 50%,#3D1FAF 100%);min-height:calc(100vh - 64px);display:flex;align-items:center;padding:4rem 2rem;position:relative;overflow:hidden">
  <div style="position:absolute;inset:0;background:radial-gradient(ellipse 60% 60% at 70% 50%,rgba(108,56,255,.3) 0%,transparent 60%)"></div>
  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;position:relative;z-index:1;width:100%">
    <div>
      <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:99px;padding:6px 14px;font-size:.8rem;color:rgba(255,255,255,.9);margin-bottom:1.5rem">
        ⚡ Platform #1 Jodoh UMKM & Programmer Indonesia
      </div>
      <h1 style="font-size:3.2rem;font-weight:800;color:#fff;line-height:1.15;margin-bottom:1.25rem">
        Wujudkan <span style="color:#A78BFA">Bisnis Digital</span> Anda Bersama Kami
      </h1>
      <p style="font-size:1.05rem;color:rgba(255,255,255,.7);margin-bottom:2rem;line-height:1.7">
        BuilderHub menghubungkan UMKM yang ingin go digital dengan programmer profesional terverifikasi. Mulai dari toko online hingga aplikasi mobile.
      </p>
      <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.5rem">
        <a href="{{ route('register') }}?role=umkm" class="btn btn-primary" style="font-size:.95rem;padding:12px 22px" aria-label="Daftarkan bisnis UMKM Anda">🏢 Daftarkan UMKM →</a>
        <a href="{{ route('register') }}?role=programmer" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.25);font-size:.95rem;padding:12px 22px">&lt;/&gt; Jadi Programmer</a>
      </div>
      <a href="{{ route('courses.index') }}" style="color:rgba(255,255,255,.7);font-size:.85rem;display:inline-flex;align-items:center;gap:6px">▶ Lihat Course Gratis</a>
      <div style="display:flex;align-items:center;gap:12px;margin-top:1.5rem">
        <div style="display:flex">
          @foreach(['R','D','B','S','A'] as $i => $l)
          <div style="width:32px;height:32px;border-radius:50%;border:2px solid rgba(255,255,255,.3);background:{{ ['#6C38FF','#10B981','#F59E0B','#EF4444','#8B5CF6'][$i] }};display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;color:#fff;margin-left:{{ $i === 0 ? '0' : '-8px' }}">{{ $l }}</div>
          @endforeach
        </div>
        <div style="font-size:.85rem;color:rgba(255,255,255,.6)">Dipercaya <strong style="color:#fff">{{ number_format($stats['programmers']) }}+</strong> programmer & UMKM ⭐⭐⭐⭐⭐</div>
      </div>
    </div>
    <div style="position:relative">
      <div style="background:rgba(255,255,255,.08);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.15);border-radius:24px;padding:1.5rem;color:#fff">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
          <div>
            <div style="font-size:.85rem;color:rgba(255,255,255,.6)">Total Pendapatan Programmer</div>
            <div style="font-size:1.8rem;font-weight:800">Rp 1.200.000</div>
          </div>
          <div style="background:rgba(52,211,153,.15);border-radius:var(--radius-sm);padding:.4rem .6rem;color:#34D399;font-size:.8rem;font-weight:600">📈 +24%</div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1.25rem">
          <div style="background:rgba(255,255,255,.06);border-radius:var(--radius-sm);padding:.75rem"><label style="font-size:.7rem;color:rgba(255,255,255,.5);display:block;margin-bottom:4px">Komisi Platform (80%)</label><strong>Rp 4.800.000</strong></div>
          <div style="background:rgba(255,255,255,.06);border-radius:var(--radius-sm);padding:.75rem"><label style="font-size:.7rem;color:rgba(255,255,255,.5);display:block;margin-bottom:4px">Untuk Programmer (20%)</label><strong style="color:#34D399">Rp 1.200.000</strong></div>
        </div>
        @foreach($projects->take(3) as $p)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:.5rem 0;border-bottom:1px solid rgba(255,255,255,.08)">
          <span style="font-size:.82rem;color:rgba(255,255,255,.8)">{{ Str::limit($p->title, 28) }}</span>
          <span style="font-size:.7rem;font-weight:600;padding:3px 8px;border-radius:99px;background:rgba(52,211,153,.2);color:#34D399">{{ $p->status_label }}</span>
        </div>
        @endforeach
      </div>
      <div style="position:absolute;bottom:-10px;right:-10px;background:var(--green);color:#fff;border-radius:var(--radius);padding:.5rem 1rem;font-size:.8rem;font-weight:600">✅ Earn 20% dari setiap project</div>
    </div>
  </div>
</section>

<!-- STATS BAR -->
<div style="background:var(--bg2);border-bottom:1px solid var(--border);padding:2rem">
  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;text-align:center">
    <div><strong style="font-size:2rem;font-weight:800;display:block">{{ number_format($stats['programmers']) }}+</strong><span style="font-size:.85rem;color:var(--text3)">Programmer Aktif</span></div>
    <div><strong style="font-size:2rem;font-weight:800;display:block">{{ number_format($stats['projects_done']) }}+</strong><span style="font-size:.85rem;color:var(--text3)">Project Selesai</span></div>
    <div><strong style="font-size:2rem;font-weight:800;display:block">{{ $stats['satisfaction'] }}%</strong><span style="font-size:.85rem;color:var(--text3)">Kepuasan UMKM</span></div>
    <div><strong style="font-size:2rem;font-weight:800;display:block">Rp {{ number_format(($stats['avg_earning'] ?? 4200000)/1000000, 1) }}M</strong><span style="font-size:.85rem;color:var(--text3)">Rata-rata Earning</span></div>
  </div>
</div>

<!-- PROJECT SECTION -->
<section class="section" id="cari-project" style="background:var(--bg2)">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">🔥 Project Terbaru</div>
      <h2>Project UMKM yang Menunggu</h2>
      <p class="lead">Programmer terverifikasi siap mengerjakan project digital bisnis Anda dengan sistem pembayaran aman dan transparan.</p>
    </div>
    <div class="project-grid">
      @foreach($projects as $project)
      <div class="project-card">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.75rem">
          <div>
            <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;margin-bottom:.3rem">
              <span style="font-size:1rem;font-weight:700">&lt;/&gt; {{ $project->title }}</span>
              <span class="badge badge-open">Dibuka</span>
              @if($project->umkm->umkm_verified)<span class="badge badge-verified">✅ UMKM Verified</span>@endif
            </div>
            <div style="font-size:.8rem;color:var(--text3)">{{ $project->umkm->business_name ?? $project->umkm->name }}</div>
          </div>
          <div style="text-align:right;flex-shrink:0">
            @if($project->budget > 0)
              <div style="font-size:1.1rem;font-weight:800">Rp {{ number_format($project->budget, 0, ',', '.') }}</div>
              <div style="font-size:.82rem;font-weight:600;color:var(--green)">Anda dapat: Rp {{ number_format($project->budget * 0.20, 0, ',', '.') }} (20%)</div>
            @else
              <div style="font-size:1.0rem;font-weight:700;color:var(--accent)">Menunggu Estimasi</div>
              <div style="font-size:.82rem;color:var(--text3)">Harga ditentukan Programmer</div>
            @endif
          </div>
        </div>
        <p style="color:var(--text2);font-size:.875rem;margin-bottom:.75rem;line-height:1.6">{{ Str::limit($project->description, 120) }}</p>
        <div class="tag-list" style="margin-bottom:.75rem">
          @foreach(($project->tags ?? []) as $tag)<span class="tag">{{ $tag }}</span>@endforeach
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;color:var(--text3);font-size:.78rem;padding-top:.75rem;border-top:1px solid var(--border)">
          <span>🕐 Deadline: {{ $project->deadline->format('d M Y') }}</span>
          <span>👥 {{ $project->bids->count() }} penawaran</span>
          @auth
            @if(auth()->user()->role === 'programmer')
              @if($project->bids->contains('programmer_id', auth()->id()))
                <button class="btn btn-sm" style="background:var(--orange-light);color:#92400E;border-color:rgba(245,158,11,.3);cursor:default;font-weight:600" disabled>Menunggu Persetujuan UMKM ⏳</button>
              @else
                <a href="{{ route('programmer.dashboard') }}#projects" class="btn btn-primary btn-sm">Ajukan Penawaran →</a>
              @endif
            @else
              <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">Dashboard →</a>
            @endif
          @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login untuk Melamar →</a>
          @endauth
        </div>
      </div>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:1.5rem">
      <a href="{{ route('projects') }}" class="btn btn-ghost">Lihat Semua Project →</a>
    </div>
  </div>
</section>

<!-- COURSE SECTION -->
<section class="section" id="courses">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">⚡ Course dari Programmer Expert</div>
      <h2>Belajar dari yang Berpengalaman</h2>
      <p class="lead">Semua instruktur adalah programmer yang sudah terbukti mengerjakan project nyata. Bukan teori semata.</p>
    </div>
    <div class="course-grid">
      @foreach($courses as $course)
      <article class="course-card">
        <div class="course-thumb" style="background:linear-gradient(135deg,#1E1260,#{{ ['6C38FF','0F4C75','7C3626','1A1A2E'][($loop->index % 4)] }})">
          <span style="font-size:2.5rem">{{ ['⚛','🔌','🚀','📱'][$loop->index % 4] }}</span>
          <span class="level-badge level-{{ $course->level }}">{{ $course->level_label }}</span>
          @if($course->is_free)<span style="position:absolute;top:10px;right:10px;background:rgba(0,0,0,.5);color:#fff;padding:3px 9px;border-radius:99px;font-size:.7rem;font-weight:700">Gratis</span>@endif
        </div>
        <div style="padding:1rem;flex:1">
          <h3 style="font-size:.95rem;font-weight:700;margin-bottom:.4rem;line-height:1.4">{{ $course->title }}</h3>
          <p style="font-size:.8rem;color:var(--text2);margin-bottom:.75rem;line-height:1.5">{{ Str::limit($course->description, 80) }}</p>
          <div style="display:flex;align-items:center;gap:6px;margin-bottom:.5rem">
            <div style="width:22px;height:22px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:#fff">{{ strtoupper(substr($course->instructor->name, 0, 1)) }}</div>
            <span style="font-size:.78rem;color:var(--text2)">{{ $course->instructor->name }}</span>
            <span style="color:var(--green);font-size:.75rem">✓</span>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;font-size:.78rem;color:var(--text3)">
            <span>⭐ {{ $course->rating }} · {{ number_format($course->total_students) }} siswa</span>
            <span>▶ {{ $course->total_videos }} video · {{ $course->duration }}</span>
          </div>
        </div>
        <div style="padding:.75rem 1rem;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
          <span style="font-size:1rem;font-weight:800;color:{{ $course->is_free ? 'var(--green)' : 'var(--text)' }}">{{ $course->price_formatted }}</span>
          <a href="{{ route('courses.detail', $course) }}" class="btn btn-primary btn-sm" aria-label="Lihat detail kursus {{ $course->title }}">Lihat Kursus</a>
        </div>
      </article>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:1.5rem">
      <a href="{{ route('courses.index') }}" class="btn btn-ghost">Lihat Semua Course →</a>
    </div>
  </div>
</section>

<!-- CTA SECTION -->
<section class="section" style="background:linear-gradient(135deg,#0F0F1A,#1E1260)">
  <div class="section-inner" style="text-align:center">
    <h2 style="color:#fff;font-size:2.2rem;margin-bottom:.75rem">Siap Bergabung dengan BuilderHub?</h2>
    <p style="color:rgba(255,255,255,.7);margin-bottom:2rem;font-size:1rem">Gratis mendaftar, mulai journey digital Anda hari ini</p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="{{ route('register') }}?role=umkm" class="btn btn-primary" style="font-size:.95rem;padding:12px 24px">Daftar sebagai UMKM</a>
      <a href="{{ route('register') }}?role=programmer" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.25);font-size:.95rem;padding:12px 24px">Daftar sebagai Programmer</a>
      <a href="{{ route('courses.index') }}" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.25);font-size:.95rem;padding:12px 24px">Mulai Belajar</a>
    </div>
  </div>
</section>
@endsection
