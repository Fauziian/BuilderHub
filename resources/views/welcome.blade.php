@extends('layouts.app')
@section('title', 'BuilderHub')
@section('content')
<!-- HERO -->
<section class="hero" style="background:linear-gradient(135deg, var(--dark) 0%, var(--dark2) 50%, var(--dark3) 100%);min-height:calc(100vh - 72px);display:flex;align-items:center;padding:6rem 2rem;position:relative;overflow:hidden">
  <!-- Decorative Orbs -->
  <div style="position:absolute;top:-20%;right:-10%;width:600px;height:600px;background:radial-gradient(circle, rgba(79, 70, 229, 0.4) 0%, transparent 70%);border-radius:50%;filter:blur(60px);z-index:0;animation:pulse 8s infinite alternate;"></div>
  <div style="position:absolute;bottom:-20%;left:-10%;width:500px;height:500px;background:radial-gradient(circle, rgba(249, 115, 22, 0.3) 0%, transparent 70%);border-radius:50%;filter:blur(60px);z-index:0;animation:pulse 10s infinite alternate-reverse;"></div>

  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;position:relative;z-index:1;width:100%">
    <div>
      <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.05);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.1);border-radius:99px;padding:8px 20px;font-size:0.85rem;font-weight:700;color:#fff;margin-bottom:2rem;box-shadow:var(--shadow-sm);text-transform:uppercase;letter-spacing:1px">
        <span style="color:var(--accent)">🚀</span> Platform #1 UMKM & Programmer
      </div>
      <h1 style="font-size:3.8rem;font-weight:800;color:#fff;line-height:1.15;margin-bottom:1.5rem;letter-spacing:-1px;">
        Wujudkan <span style="background:linear-gradient(to right, #818CF8, #C084FC);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Bisnis Digital</span> Anda Bersama Kami
      </h1>
      <p style="font-size:1.15rem;color:rgba(255,255,255,0.7);margin-bottom:2.5rem;line-height:1.8;max-width:90%">
        BuilderHub menghubungkan UMKM yang ingin go digital dengan programmer profesional terverifikasi. Mulai dari toko online hingga aplikasi mobile kelas enterprise.
      </p>
      <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:2rem">
        <a href="{{ route('register') }}?role=umkm" class="btn btn-primary" style="padding:16px 32px;font-size:1rem;box-shadow:0 10px 25px rgba(79,70,229,0.4)">🏢 Daftarkan UMKM</a>
        <a href="{{ route('register') }}?role=programmer" class="btn" style="background:rgba(255,255,255,0.05);color:#fff;border:1px solid rgba(255,255,255,0.2);padding:16px 32px;font-size:1rem;backdrop-filter:blur(10px)">&lt;/&gt; Jadi Programmer</a>
      </div>
      <a href="{{ route('courses.index') }}" style="color:rgba(255,255,255,0.6);font-size:0.9rem;display:inline-flex;align-items:center;gap:6px;font-weight:600;transition:0.3s">
        <span style="display:flex;align-items:center;justify-content:center;width:24px;height:24px;background:rgba(255,255,255,0.1);border-radius:50%;color:#fff;font-size:0.7rem">▶</span> Lihat Course Gratis
      </a>
      
      <div style="display:flex;align-items:center;gap:16px;margin-top:3rem;padding-top:2rem;border-top:1px solid rgba(255,255,255,0.1)">
        <div style="display:flex">
          @foreach(['R','D','B','S','A'] as $i => $l)
          <div style="width:40px;height:40px;border-radius:50%;border:2px solid var(--dark);background:{{ ['#4F46E5','#10B981','#F59E0B','#EF4444','#8B5CF6'][$i] }};display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:800;color:#fff;margin-left:{{ $i === 0 ? '0' : '-12px' }};box-shadow:var(--shadow-sm)">{{ $l }}</div>
          @endforeach
        </div>
        <div style="font-size:0.95rem;color:rgba(255,255,255,0.6);line-height:1.4">
          Dipercaya <strong style="color:#fff">{{ number_format($stats['programmers']) }}+</strong> pengguna <br>
          <span style="color:var(--orange)">★★★★★</span> Rating
        </div>
      </div>
    </div>
    
    <div style="position:relative;perspective:1000px">
      <div style="background:rgba(255,255,255,0.03);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.1);border-radius:var(--radius-xl);padding:2.5rem;color:#fff;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);transform:rotateY(-5deg) rotateX(5deg);transition:all 0.5s ease" onmouseover="this.style.transform='rotateY(0deg) rotateX(0deg)'" onmouseout="this.style.transform='rotateY(-5deg) rotateX(5deg)'">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem">
          <div>
            <div style="font-size:0.9rem;color:rgba(255,255,255,0.6);font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Pendapatan Programmer</div>
            <div style="font-size:2.5rem;font-weight:800;letter-spacing:-1px">Rp 1.200.000</div>
          </div>
          <div style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);border-radius:99px;padding:6px 14px;color:#34D399;font-size:0.85rem;font-weight:700">📈 +24%</div>
        </div>
        
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:2rem">
          <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.05);border-radius:var(--radius-sm);padding:1.25rem">
            <label style="font-size:0.75rem;color:rgba(255,255,255,0.5);display:block;margin-bottom:8px;font-weight:600">Nilai Project (100%)</label>
            <strong style="font-size:1.1rem">Rp 6.000.000</strong>
          </div>
          <div style="background:linear-gradient(135deg, rgba(79,70,229,0.1), rgba(79,70,229,0.2));border:1px solid rgba(79,70,229,0.3);border-radius:var(--radius-sm);padding:1.25rem">
            <label style="font-size:0.75rem;color:rgba(255,255,255,0.7);display:block;margin-bottom:8px;font-weight:600">Untuk Programmer (20%)</label>
            <strong style="color:#A78BFA;font-size:1.1rem">Rp 1.200.000</strong>
          </div>
        </div>
        
        <h4 style="font-size:0.9rem;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:1px;margin-bottom:1rem;font-weight:700">Project Terkini</h4>
        @foreach($projects->take(3) as $p)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem 0;border-bottom:1px solid rgba(255,255,255,0.05)">
          <div style="display:flex;align-items:center;gap:12px">
            <div style="width:36px;height:36px;background:rgba(255,255,255,0.05);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--primary-light);font-size:1rem">&lt;/&gt;</div>
            <span style="font-size:0.95rem;color:rgba(255,255,255,0.9);font-weight:500">{{ Str::limit($p->title, 25) }}</span>
          </div>
          <span style="font-size:0.75rem;font-weight:700;padding:4px 10px;border-radius:99px;background:rgba(52,211,153,0.15);color:#34D399;border:1px solid rgba(52,211,153,0.2)">{{ $p->status_label }}</span>
        </div>
        @endforeach
      </div>
      <div style="position:absolute;bottom:-20px;right:-20px;background:linear-gradient(135deg, var(--green), #059669);color:#fff;border-radius:var(--radius);padding:1rem 1.5rem;font-size:0.9rem;font-weight:700;box-shadow:0 10px 25px rgba(16,185,129,0.4);border:1px solid rgba(255,255,255,0.2);display:flex;align-items:center;gap:8px">
        <span style="background:#fff;color:var(--green);width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.8rem">✓</span> 
        Skema Transparan 20%
      </div>
    </div>
  </div>
  <style>@keyframes pulse { 0% { opacity: 0.5; transform: scale(0.9); } 100% { opacity: 0.8; transform: scale(1.1); } }</style>
</section>

<!-- STATS BAR -->
<div style="background:var(--bg2);border-bottom:1px solid var(--border);padding:3rem 2rem;position:relative;z-index:10;margin-top:-2rem;box-shadow:0 -10px 30px rgba(0,0,0,0.05)">
  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:2rem;text-align:center">
    <div>
      <strong style="font-size:2.5rem;font-weight:800;display:block;color:var(--primary);letter-spacing:-1px">{{ number_format($stats['programmers']) }}+</strong>
      <span style="font-size:0.95rem;color:var(--text2);font-weight:600;text-transform:uppercase;letter-spacing:0.5px">Programmer Aktif</span>
    </div>
    <div style="position:relative">
      <div style="position:absolute;left:-1rem;top:20%;bottom:20%;width:1px;background:var(--border)"></div>
      <strong style="font-size:2.5rem;font-weight:800;display:block;color:var(--text);letter-spacing:-1px">{{ number_format($stats['projects_done']) }}+</strong>
      <span style="font-size:0.95rem;color:var(--text2);font-weight:600;text-transform:uppercase;letter-spacing:0.5px">Project Selesai</span>
    </div>
    <div style="position:relative">
      <div style="position:absolute;left:-1rem;top:20%;bottom:20%;width:1px;background:var(--border)"></div>
      <strong style="font-size:2.5rem;font-weight:800;display:block;color:var(--green);letter-spacing:-1px">{{ $stats['satisfaction'] }}%</strong>
      <span style="font-size:0.95rem;color:var(--text2);font-weight:600;text-transform:uppercase;letter-spacing:0.5px">Kepuasan UMKM</span>
    </div>
    <div style="position:relative">
      <div style="position:absolute;left:-1rem;top:20%;bottom:20%;width:1px;background:var(--border)"></div>
      <strong style="font-size:2.5rem;font-weight:800;display:block;color:var(--orange);letter-spacing:-1px">Rp {{ number_format(($stats['avg_earning'] ?? 4200000)/1000000, 1) }}M</strong>
      <span style="font-size:0.95rem;color:var(--text2);font-weight:600;text-transform:uppercase;letter-spacing:0.5px">Rata-rata Pendapatan</span>
    </div>
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
