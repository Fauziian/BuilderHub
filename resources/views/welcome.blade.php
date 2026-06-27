@extends('layouts.app')
@section('title', 'BuilderHub')
@section('content')

<style>
  @keyframes float {
    0% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-8px) rotate(0.5deg); }
    100% { transform: translateY(0px) rotate(0deg); }
  }
  @keyframes pulse-glow {
    0% { box-shadow: 0 0 25px rgba(99, 102, 241, 0.2); }
    50% { box-shadow: 0 0 50px rgba(99, 102, 241, 0.5); }
    100% { box-shadow: 0 0 25px rgba(99, 102, 241, 0.2); }
  }
  
  .fantasy-card {
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 24px;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
  }
  .fantasy-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), transparent);
    z-index: 1;
    pointer-events: none;
  }
  
  .portal-umkm:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(99, 102, 241, 0.4);
    border-color: #6366f1;
    background: rgba(99, 102, 241, 0.04);
  }
  .portal-programmer:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(236, 72, 153, 0.4);
    border-color: #ec4899;
    background: rgba(236, 72, 153, 0.04);
  }
  .portal-student:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(16, 185, 129, 0.4);
    border-color: #10b981;
    background: rgba(16, 185, 129, 0.04);
  }

  .earning-card {
    transition: opacity 0.5s cubic-bezier(0.16, 1, 0.3, 1), transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    opacity: 0;
    transform: translateX(50px) scale(0.97);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    pointer-events: none;
  }
  
  .earning-card.active {
    opacity: 1;
    transform: translateX(0) scale(1);
    position: relative;
    pointer-events: auto;
  }
  
  .earning-card.exit {
    opacity: 0;
    transform: translateX(-50px) scale(0.97);
    position: absolute;
    pointer-events: none;
  }
  
  .earning-badge {
    transition: opacity 0.5s ease, transform 0.5s ease;
    opacity: 0;
    transform: translateY(15px);
    pointer-events: none;
    display: none !important;
  }
  
  .earning-badge.active {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
    display: flex !important;
  }
</style>

<!-- HERO & PORTALS SECTION (High-end Fantasy Theme) -->
<section class="hero" style="background:linear-gradient(135deg, #0A0A14 0%, #121228 50%, #0F0F1A 100%);min-height:100vh;display:flex;align-items:center;padding:7rem 2rem 5rem 2rem;position:relative;overflow:hidden">
  <!-- Interactive Cosmic Orbs -->
  <div style="position:absolute;top:-10%;right:-5%;width:700px;height:700px;background:radial-gradient(circle, rgba(99, 102, 241, 0.35) 0%, transparent 70%);border-radius:50%;filter:blur(80px);z-index:0;animation:pulse 12s infinite alternate;"></div>
  <div style="position:absolute;bottom:-15%;left:-5%;width:600px;height:600px;background:radial-gradient(circle, rgba(16, 185, 129, 0.25) 0%, transparent 70%);border-radius:50%;filter:blur(80px);z-index:0;animation:pulse 15s infinite alternate-reverse;"></div>
  <div style="position:absolute;top:40%;left:35%;width:500px;height:500px;background:radial-gradient(circle, rgba(236, 72, 153, 0.25) 0%, transparent 70%);border-radius:50%;filter:blur(70px);z-index:0;animation:pulse 10s infinite alternate;"></div>

  <div style="max-width:1300px;margin:0 auto;width:100%;position:relative;z-index:1;display:flex;flex-direction:column;gap:5rem">
    
    <!-- Hero Main Pitch -->
    <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:4rem;align-items:center">
      <div>
        <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.03);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.08);border-radius:99px;padding:8px 20px;font-size:0.85rem;font-weight:700;color:#fff;margin-bottom:2rem;box-shadow:var(--shadow-sm);text-transform:uppercase;letter-spacing:1px">
          <span style="color:var(--orange)">✨</span> Tiga Pilar Kolaborasi Digital
        </div>
        <h1 style="font-size:4.2rem;font-weight:900;color:#fff;line-height:1.1;margin-bottom:1.5rem;letter-spacing:-1.5px">
          Satu Ekosistem Tech Terpadu: <br>
          <span style="background:linear-gradient(to right, #818CF8, #C084FC, #34D399);-webkit-background-clip:text;-webkit-text-fill-color:transparent;filter:drop-shadow(0 2px 10px rgba(129,140,248,0.2))">
            UMKM <br> Programmer <br> Pelajar
          </span>
        </h1>
        <p style="font-size:1.2rem;color:rgba(255,255,255,0.7);margin-bottom:2.5rem;line-height:1.8;max-width:92%">
          BuilderHub menyatukan tiga pilar kekuatan digital. UMKM mendapatkan solusi bisnis nyata, Programmer meraih pendapatan berlipat ganda, dan Pelajar bertransformasi menjadi praktisi profesional melalui studi kasus nyata.
        </p>

        <!-- Dynamic Trust Stats -->
        <div style="display:flex;align-items:center;gap:16px;padding-top:1.5rem;border-top:1px solid rgba(255,255,255,0.06)">
          <div style="display:flex">
            @foreach(['R','D','B','S','A'] as $i => $l)
            <div style="width:36px;height:36px;border-radius:50%;border:2px solid #0F0F1A;background:{{ ['#4F46E5','#10B981','#F59E0B','#EF4444','#8B5CF6'][$i] }};display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:800;color:#fff;margin-left:{{ $i === 0 ? '0' : '-10px' }};box-shadow:var(--shadow-sm)">{{ $l }}</div>
            @endforeach
          </div>
          <div style="font-size:0.9rem;color:rgba(255,255,255,0.5);line-height:1.4">
            Dipercaya <strong style="color:#fff">{{ number_format($stats['programmers']) }}+</strong> talenta & bisnis <br>
            <span style="color:var(--orange)">★★★★★</span> Penilaian Terverifikasi
          </div>
        </div>
      </div>

      <!-- Live Earning Simulation Hub -->
      <div id="earningHub" style="position:relative;min-height:510px;transition:all 0.5s ease;border-radius:24px;border:1px solid rgba(99, 102, 241, 0.3);box-shadow:0 25px 60px -10px rgba(99, 102, 241, 0.25)">
        <!-- Tabs Switcher -->
        <div style="display:flex;gap:8px;margin-bottom:1rem;background:rgba(255,255,255,0.03);backdrop-filter:blur(10px);padding:4px;border-radius:12px;border:1px solid rgba(255,255,255,0.08);position:relative;z-index:2">
          <button onclick="switchTab('project', true)" id="tabBtnProject" style="flex:1;background:var(--primary);border:none;border-radius:8px;padding:10px;color:#fff;font-size:0.8rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:0.3s">
            💼 Project Earning (20%)
          </button>
          <button onclick="switchTab('course', true)" id="tabBtnCourse" style="flex:1;background:transparent;border:none;border-radius:8px;padding:10px;color:rgba(255,255,255,0.6);font-size:0.8rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:0.3s">
            🎓 Course Earning (80%)
          </button>
        </div>

        <!-- Wrapper for sliding cards -->
        <div style="position:relative;width:100%">
          <!-- Card Project Earning -->
          <div id="cardProject" class="earning-card active" style="background:rgba(255,255,255,0.02);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.08);border-radius:var(--radius-xl);padding:2.5rem;color:#fff;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5)">
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

          <!-- Card Course Earning -->
          <div id="cardCourse" class="earning-card" style="background:rgba(255,255,255,0.02);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.08);border-radius:var(--radius-xl);padding:2.5rem;color:#fff;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5)">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem">
              <div>
                <div style="font-size:0.9rem;color:rgba(255,255,255,0.6);font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Pendapatan Course (Programmer Expert)</div>
                <div style="font-size:2.5rem;font-weight:800;letter-spacing:-1px;color:var(--orange)">Rp 6.000.000</div>
              </div>
              <div style="background:rgba(245,158,11,0.15);border:1px solid rgba(245,158,11,0.3);border-radius:99px;padding:6px 14px;color:#F59E0B;font-size:0.85rem;font-weight:700">🚀 Passive Income</div>
            </div>
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:2rem">
              <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.05);border-radius:var(--radius-sm);padding:1.25rem">
                <label style="font-size:0.75rem;color:rgba(255,255,255,0.5);display:block;margin-bottom:8px;font-weight:600">Harga per Siswa</label>
                <strong style="font-size:1.1rem">Rp 150.000</strong>
              </div>
              <div style="background:linear-gradient(135deg, rgba(245,158,11,0.1), rgba(245,158,11,0.2));border:1px solid rgba(245,158,11,0.3);border-radius:var(--radius-sm);padding:1.25rem">
                <label style="font-size:0.75rem;color:rgba(255,255,255,0.7);display:block;margin-bottom:8px;font-weight:600">Bagi Hasil Instruktur (80%)</label>
                <strong style="color:var(--orange);font-size:1.1rem">Rp 120.000</strong>
              </div>
            </div>
            
            <h4 style="font-size:0.9rem;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:1px;margin-bottom:1rem;font-weight:700">Skema Pendapatan (Simulasi 50 Siswa)</h4>
            <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);border-radius:12px;padding:1.25rem;display:flex;flex-direction:column;gap:12px">
              <div style="display:flex;justify-content:space-between;font-size:0.9rem">
                <span style="color:rgba(255,255,255,0.6)">Total Penjualan (50 Siswa)</span>
                <strong>Rp 7.500.000</strong>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:0.9rem">
                <span style="color:rgba(255,255,255,0.6)">Bagi Hasil Website (20%)</span>
                <span style="color:var(--red-light)">- Rp 1.500.000</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:0.95rem;font-weight:700;padding-top:10px;border-top:1px solid rgba(255,255,255,0.1)">
                <span style="color:var(--orange)">Bersih untuk Anda (80%)</span>
                <span style="color:var(--orange)">Rp 6.000.000</span>
              </div>
            </div>
          </div>

          <!-- Badge Project -->
          <div id="badgeProject" class="earning-badge active" style="position:absolute;bottom:-20px;right:-20px;background:linear-gradient(135deg, var(--green), #059669);color:#fff;border-radius:var(--radius);padding:1rem 1.5rem;font-size:0.9rem;font-weight:700;box-shadow:0 10px 25px rgba(16,185,129,0.4);border:1px solid rgba(255,255,255,0.2);display:flex;align-items:center;gap:8px">
            <span style="background:#fff;color:var(--green);width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.8rem">✓</span> 
            Skema Transparan 20%
          </div>

          <!-- Badge Course -->
          <div id="badgeCourse" class="earning-badge" style="position:absolute;bottom:-20px;right:-20px;background:linear-gradient(135deg, var(--orange), #D97706);color:#fff;border-radius:var(--radius);padding:1rem 1.5rem;font-size:0.9rem;font-weight:700;box-shadow:0 10px 25px rgba(245,158,11,0.4);border:1px solid rgba(255,255,255,0.2);display:flex;align-items:center;gap:8px">
            <span style="background:#fff;color:var(--orange);width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.8rem">🎓</span> 
            Skema Adil 80% Programmer
          </div>
        </div>
      </div>
    </div>

    <!-- Majestic Tri-Realm Portals (Equal Representation) -->
    <div>
      <div style="text-align:center;margin-bottom:3rem">
        <h2 style="font-size:2rem;font-weight:800;color:#fff;letter-spacing:-0.5px">Pilih Perjalanan Anda di BuilderHub</h2>
        <p style="color:rgba(255,255,255,0.5);font-size:1rem;margin-top:0.5rem">Tiga portal utama untuk memicu revolusi digital Anda</p>
      </div>

      <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:2rem">
        
        <!-- Portal UMKM -->
        <div class="fantasy-card portal-umkm" style="padding:2.5rem;display:flex;flex-direction:column;justify-content:space-between;height:340px;background:radial-gradient(circle at top right, rgba(99, 102, 241, 0.12) 0%, transparent 60%)">
          <div>
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin-bottom:1.5rem;box-shadow:0 0 15px rgba(99,102,241,0.2)">🏢</div>
            <h3 style="font-size:1.4rem;font-weight:800;color:#fff;margin-bottom:0.75rem">Digitalisasi UMKM</h3>
            <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;line-height:1.6">
              Go digital dengan aman. Hubungkan bisnis Anda dengan programmer handal untuk membuat web, aplikasi mobile, atau software kustom.
            </p>
          </div>
          <a href="{{ route('register') }}?role=umkm" class="btn" style="width:100%;text-align:center;padding:12px;font-size:0.9rem;color:#fff;border:none;background:linear-gradient(135deg, #6366f1, #a855f7);box-shadow:0 8px 20px rgba(99,102,241,0.35)">
            Mulai Project UMKM →
          </a>
        </div>

        <!-- Portal Programmer -->
        <div class="fantasy-card portal-programmer" style="padding:2.5rem;display:flex;flex-direction:column;justify-content:space-between;height:340px;background:radial-gradient(circle at top right, rgba(236, 72, 153, 0.12) 0%, transparent 60%)">
          <div>
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(236,72,153,0.15);border:1px solid rgba(236,72,153,0.3);display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:1.5rem;box-shadow:0 0 15px rgba(236,72,153,0.2);color:#ec4899;font-weight:900;font-family:monospace">&lt;/&gt;</div>
            <h3 style="font-size:1.4rem;font-weight:800;color:#fff;margin-bottom:0.75rem">Programmer Realm</h3>
            <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;line-height:1.6">
              Raih pendapatan melimpah. Kerjakan proyek terverifikasi dengan potongan minim, serta jual course pemrograman dengan bagi hasil 80%.
            </p>
          </div>
          <a href="{{ route('register') }}?role=programmer" class="btn" style="width:100%;text-align:center;padding:12px;font-size:0.9rem;background:linear-gradient(135deg, #ec4899, #f59e0b);color:#fff;border:none;box-shadow:0 8px 20px rgba(236,72,153,0.35)">
            Daftar Programmer →
          </a>
        </div>

        <!-- Portal Pelajar -->
        <div class="fantasy-card portal-student" style="padding:2.5rem;display:flex;flex-direction:column;justify-content:space-between;height:340px;background:radial-gradient(circle at top right, rgba(16, 185, 129, 0.12) 0%, transparent 60%)">
          <div>
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin-bottom:1.5rem;box-shadow:0 0 15px rgba(16,185,129,0.2)">🎓</div>
            <h3 style="font-size:1.4rem;font-weight:800;color:#fff;margin-bottom:0.75rem">Akselerasi Pelajar</h3>
            <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;line-height:1.6">
              Akselerasikan keahlian Anda. Pelajari studi kasus proyek industri nyata, buat tugas bersertifikat, dan hubungkan profil Anda ke UMKM.
            </p>
          </div>
          <a href="{{ route('courses.index') }}" class="btn" style="width:100%;text-align:center;padding:12px;font-size:0.9rem;background:linear-gradient(135deg, #10b981, #0ea5e9);color:#fff;border:none;box-shadow:0 8px 20px rgba(16,185,129,0.35)">
            Jelajahi Course →
          </a>
        </div>

      </div>
    </div>

  </div>
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

<!-- STUDENT ACCELERATOR SECTION (IMK: Menarik minat Pelajar / Mahasiswa) -->
<section class="section" style="background:linear-gradient(180deg, var(--dark2) 0%, var(--dark) 100%);padding:6rem 2rem;position:relative;overflow:hidden">
  <div style="position:absolute;top:10%;left:50%;width:300px;height:300px;background:radial-gradient(circle, rgba(245,158,11,0.15) 0%, transparent 70%);border-radius:50%;filter:blur(50px);z-index:0"></div>
  
  <div style="max-width:1200px;margin:0 auto;position:relative;z-index:1">
    <div style="text-align:center;margin-bottom:4rem">
      <div style="display:inline-block;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.3);color:var(--orange);font-size:0.85rem;font-weight:700;padding:6px 16px;border-radius:99px;text-transform:uppercase;letter-spacing:1px;margin-bottom:1rem">
        🎓 Untuk Pelajar & Mahasiswa
      </div>
      <h2 style="font-size:2.6rem;font-weight:800;color:#fff;margin-bottom:1rem;letter-spacing:-0.5px">Akselerasi Karir Tech Anda dengan Studi Kasus Nyata</h2>
      <p style="color:rgba(255,255,255,0.7);max-width:700px;margin:0 auto;font-size:1.1rem;line-height:1.7">
        BuilderHub adalah wadah terbaik bagi pelajar dan mahasiswa untuk melompat dari teori kampus langsung ke industri. Belajar dari programmer handal yang terbukti sukses membangun bisnis digital nyata.
      </p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));gap:2rem;margin-bottom:4rem">
      <!-- Card 1 -->
      <div class="glass-card" style="padding:2.25rem;border-radius:20px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);transition:all 0.3s ease;display:flex;flex-direction:column;gap:1.25rem" onmouseover="this.style.background='rgba(255,255,255,0.04)';this.style.borderColor='rgba(245,158,11,0.2)';this.style.transform='translateY(-6px)'" onmouseout="this.style.background='rgba(255,255,255,0.02)';this.style.borderColor='rgba(255,255,255,0.05)';this.style.transform='translateY(0)'">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(79,70,229,0.15);display:flex;align-items:center;justify-content:center;font-size:1.5rem">💡</div>
        <h3 style="font-size:1.2rem;font-weight:700;color:#fff">Proyek Riil & Teori Terapan</h3>
        <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;line-height:1.6">
          Belajar melalui kurikulum berbasis projek nyata. Kurikulum dirancang dari studi kasus project UMKM yang dikerjakan oleh para Programmer Expert.
        </p>
      </div>

      <!-- Card 2 -->
      <div class="glass-card" style="padding:2.25rem;border-radius:20px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);transition:all 0.3s ease;display:flex;flex-direction:column;gap:1.25rem" onmouseover="this.style.background='rgba(255,255,255,0.04)';this.style.borderColor='rgba(245,158,11,0.2)';this.style.transform='translateY(-6px)'" onmouseout="this.style.background='rgba(255,255,255,0.02)';this.style.borderColor='rgba(255,255,255,0.05)';this.style.transform='translateY(0)'">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(16,185,129,0.15);display:flex;align-items:center;justify-content:center;font-size:1.5rem">🏆</div>
        <h3 style="font-size:1.2rem;font-weight:700;color:#fff">Portofolio Terakreditasi</h3>
        <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;line-height:1.6">
          Selesaikan tugas-tugas akhir dan bangun portofolio handal Anda yang siap diverifikasi oleh tim kurator kami untuk menarik minat klien UMKM.
        </p>
      </div>

      <!-- Card 3 -->
      <div class="glass-card" style="padding:2.25rem;border-radius:20px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);transition:all 0.3s ease;display:flex;flex-direction:column;gap:1.25rem" onmouseover="this.style.background='rgba(255,255,255,0.04)';this.style.borderColor='rgba(245,158,11,0.2)';this.style.transform='translateY(-6px)'" onmouseout="this.style.background='rgba(255,255,255,0.02)';this.style.borderColor='rgba(255,255,255,0.05)';this.style.transform='translateY(0)'">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(245,158,11,0.15);display:flex;align-items:center;justify-content:center;font-size:1.5rem">🤝</div>
        <h3 style="font-size:1.2rem;font-weight:700;color:#fff">Peluang Kolaborasi</h3>
        <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;line-height:1.6">
          Mahasiswa terbaik berkesempatan berkolaborasi langsung dengan UMKM di bawah bimbingan programmer senior, mendapatkan pengalaman kerja nyata pertama Anda.
        </p>
      </div>

      <!-- Card 4 -->
      <div class="glass-card" style="padding:2.25rem;border-radius:20px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);transition:all 0.3s ease;display:flex;flex-direction:column;gap:1.25rem" onmouseover="this.style.background='rgba(255,255,255,0.04)';this.style.borderColor='rgba(245,158,11,0.2)';this.style.transform='translateY(-6px)'" onmouseout="this.style.background='rgba(255,255,255,0.02)';this.style.borderColor='rgba(255,255,255,0.05)';this.style.transform='translateY(0)'">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(139,92,246,0.15);display:flex;align-items:center;justify-content:center;font-size:1.5rem">🎓</div>
        <h3 style="font-size:1.2rem;font-weight:700;color:#fff">Sertifikat Industri</h3>
        <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;line-height:1.6">
          Setiap menyelesaikan course, Anda mendapatkan sertifikasi kelulusan resmi yang terhubung langsung ke profil CV online Anda di BuilderHub.
        </p>
      </div>
    </div>

    <div style="text-align:center">
      <a href="{{ route('courses.index') }}" class="btn btn-primary" style="padding:16px 36px;font-size:1rem;background:linear-gradient(135deg, var(--orange), #D97706);border:none;box-shadow:0 10px 25px rgba(245,158,11,0.3)">
        🚀 Eksplor Materi & Mulai Belajar
      </a>
    </div>
  </div>
</section>

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
                $logoHtml = '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px"><div style="font-family:\'Arial Black\', sans-serif;font-size:1.35rem;font-weight:900;color:#000;letter-spacing:2px;line-height:1;margin-top:4px">HTML</div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 452 520" width="58" height="66" style="display:block"><path fill="#e34f26" d="M41 460L0 0h451l-41 460-185 52" /><path fill="#ef652a" d="M226 472l149-41 35-394H226" /><path fill="#ecedee" d="M226 208h-75l-5-58h80V94H84l15 171h127zm0 147l-64-17-4-45h-56l7 89 117 32z"/><path fill="#fff" d="M226 265h69l-7 73-62 17v59l115-32 16-174H226zm0-171v56h136l5-56z"/></svg></div>';
            } elseif ($preset === 'css') {
                $gradient = '#2d88d3';
                $logoHtml = '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px"><div style="font-family:\'Arial Black\', sans-serif;font-size:1.35rem;font-weight:900;color:#000;letter-spacing:2px;line-height:1;margin-top:4px">CSS</div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 452 520" width="58" height="66" style="display:block"><path fill="#0c72b8" d="M41 460L0 0h451l-41 460-185 52" /><path fill="#1c8adb" d="M226 472l149-41 35-394H226" /><path fill="#ebebeb" d="M226 94H96l5 56h125z M226 208H161l5 57h60z M226 355H117l5 60h104z" /><path fill="#ffffff" d="M226 94h141l-5 56H226z M226 208h131l-5 57H226z M226 355h118l-5 60H226z M295 150h67l-18 205H295z" /></svg></div>';
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
      <article class="course-card">
        <div style="display:flex;flex-direction:column;height:100%">
          <div class="course-thumb" style="background:{!! $hasCustomThumb ? 'transparent' : $gradient !!};position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden">
            @if($hasCustomThumb)
              <img src="{{ $thumbUrl }}" alt="{{ $course->title }}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit">
            @else
              {!! $logoHtml !!}
            @endif
            <span class="level-badge level-{{ $course->level }}" style="z-index:2">{{ $course->level_label }}</span>
            @if($course->is_free)<span style="position:absolute;top:10px;right:10px;background:rgba(0,0,0,.5);color:#fff;padding:3px 9px;border-radius:99px;font-size:.7rem;font-weight:700;z-index:2">Gratis</span>@endif
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
              <span>⭐ {{ number_format($course->rating ?: 0.0, 1) }} · {{ number_format($course->enrollments->count()) }} siswa</span>
              <span>▶ {{ $course->total_videos }} video · {{ $course->duration }}</span>
            </div>
          </div>
          <div style="padding:.75rem 1rem;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
            <span style="font-size:1rem;font-weight:800;color:{{ $course->is_free ? 'var(--green)' : 'var(--text)' }}">{{ $course->price_formatted }}</span>
            <a href="{{ route('courses.detail', $course) }}" class="btn btn-primary btn-sm" aria-label="Lihat detail kursus {{ $course->title }}">Lihat Kursus</a>
          </div>
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
<script>
  let autoSlideInterval;
  let currentTab = 'project';

  function switchTab(type, isManual = false) {
    if (isManual) {
      clearInterval(autoSlideInterval);
    }
    
    const btnProject = document.getElementById('tabBtnProject');
    const btnCourse = document.getElementById('tabBtnCourse');
    const cardProject = document.getElementById('cardProject');
    const cardCourse = document.getElementById('cardCourse');
    const badgeProject = document.getElementById('badgeProject');
    const badgeCourse = document.getElementById('badgeCourse');
    const earningHub = document.getElementById('earningHub');

    currentTab = type;

    if (type === 'project') {
      // Button states
      btnProject.style.background = 'linear-gradient(135deg, #6366f1, #a855f7)';
      btnProject.style.color = '#fff';
      btnProject.style.boxShadow = '0 4px 15px rgba(99, 102, 241, 0.4)';
      
      btnCourse.style.background = 'transparent';
      btnCourse.style.color = 'rgba(255,255,255,0.6)';
      btnCourse.style.boxShadow = 'none';

      // Card states
      cardCourse.classList.remove('active');
      cardCourse.classList.add('exit');
      
      cardProject.classList.remove('exit');
      cardProject.classList.add('active');

      // Badge states
      badgeCourse.classList.remove('active');
      badgeProject.classList.add('active');

      // Container border & glow
      if (earningHub) {
        earningHub.style.borderColor = 'rgba(99, 102, 241, 0.3)';
        earningHub.style.boxShadow = '0 25px 60px -10px rgba(99, 102, 241, 0.25)';
      }
    } else {
      // Button states
      btnCourse.style.background = 'linear-gradient(135deg, #ec4899, #f59e0b)';
      btnCourse.style.color = '#fff';
      btnCourse.style.boxShadow = '0 4px 15px rgba(236, 72, 153, 0.4)';
      
      btnProject.style.background = 'transparent';
      btnProject.style.color = 'rgba(255,255,255,0.6)';
      btnProject.style.boxShadow = 'none';

      // Card states
      cardProject.classList.remove('active');
      cardProject.classList.add('exit');
      
      cardCourse.classList.remove('exit');
      cardCourse.classList.add('active');

      // Badge states
      badgeProject.classList.remove('active');
      badgeCourse.classList.add('active');

      // Container border & glow
      if (earningHub) {
        earningHub.style.borderColor = 'rgba(236, 72, 153, 0.3)';
        earningHub.style.boxShadow = '0 25px 60px -10px rgba(236, 72, 153, 0.25)';
      }
    }
  }

  function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
      let nextTab = currentTab === 'project' ? 'course' : 'project';
      switchTab(nextTab);
    }, 5000); // Switch tab every 5 seconds
  }

  window.addEventListener('DOMContentLoaded', () => {
    startAutoSlide();
  });
</script>
@endsection
