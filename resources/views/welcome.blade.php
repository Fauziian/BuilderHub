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
    0% { box-shadow: 0 0 20px rgba(129, 140, 248, 0.15); }
    50% { box-shadow: 0 0 40px rgba(129, 140, 248, 0.45); }
    100% { box-shadow: 0 0 20px rgba(129, 140, 248, 0.15); }
  }
  
  .fantasy-card {
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 24px;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
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
  .fantasy-card:hover {
    transform: translateY(-8px) scale(1.02);
    border-color: rgba(129, 140, 248, 0.4);
    background: rgba(255, 255, 255, 0.04);
  }
  
  .portal-umkm:hover {
    box-shadow: 0 15px 35px rgba(79, 70, 229, 0.25);
    border-color: rgba(79, 70, 229, 0.5);
  }
  .portal-programmer:hover {
    box-shadow: 0 15px 35px rgba(245, 158, 11, 0.25);
    border-color: rgba(245, 158, 11, 0.5);
  }
  .portal-student:hover {
    box-shadow: 0 15px 35px rgba(16, 185, 129, 0.25);
    border-color: rgba(16, 185, 129, 0.5);
  }

  .earning-card {
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1), transform 0.6s cubic-bezier(0.4, 0, 0.2, 1) !important;
    opacity: 0;
    transform: translateX(100px) rotateY(-5deg) rotateX(5deg);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    pointer-events: none;
  }
  
  .earning-card.active {
    opacity: 1;
    transform: translateX(0) rotateY(-5deg) rotateX(5deg);
    position: relative;
    pointer-events: auto;
  }
  
  .earning-card.exit {
    opacity: 0;
    transform: translateX(-100px) rotateY(-5deg) rotateX(5deg);
    position: absolute;
    pointer-events: none;
  }
  
  .earning-badge {
    transition: opacity 0.6s ease, transform 0.6s ease !important;
    opacity: 0;
    transform: translateY(20px);
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
  <div style="position:absolute;top:-10%;right:-5%;width:700px;height:700px;background:radial-gradient(circle, rgba(129, 140, 248, 0.25) 0%, transparent 70%);border-radius:50%;filter:blur(80px);z-index:0;animation:pulse 12s infinite alternate;"></div>
  <div style="position:absolute;bottom:-15%;left:-5%;width:600px;height:600px;background:radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);border-radius:50%;filter:blur(80px);z-index:0;animation:pulse 15s infinite alternate-reverse;"></div>
  <div style="position:absolute;top:40%;left:35%;width:400px;height:400px;background:radial-gradient(circle, rgba(245, 158, 11, 0.12) 0%, transparent 70%);border-radius:50%;filter:blur(60px);z-index:0;animation:pulse 10s infinite alternate;"></div>

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
            UMKM &nbsp;&nbsp; Programmer &nbsp;&nbsp; Pelajar
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
      <div style="position:relative;perspective:1000px;min-height:510px">
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
          <div id="cardProject" class="earning-card active" style="background:rgba(255,255,255,0.02);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.08);border-radius:var(--radius-xl);padding:2.5rem;color:#fff;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5)" onmouseover="this.style.transform='rotateY(0deg) rotateX(0deg)'" onmouseout="this.style.transform='rotateY(-5deg) rotateX(5deg)'">
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
          <div id="cardCourse" class="earning-card" style="background:rgba(255,255,255,0.02);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.08);border-radius:var(--radius-xl);padding:2.5rem;color:#fff;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5)" onmouseover="this.style.transform='rotateY(0deg) rotateX(0deg)'" onmouseout="this.style.transform='rotateY(-5deg) rotateX(5deg)'">
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
        <div class="fantasy-card portal-umkm" style="padding:2.5rem;display:flex;flex-direction:column;justify-content:space-between;height:340px;background:radial-gradient(circle at top right, rgba(79, 70, 229, 0.08) 0%, transparent 60%)">
          <div>
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(79,70,229,0.15);border:1px solid rgba(79,70,229,0.3);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin-bottom:1.5rem;box-shadow:0 0 15px rgba(79,70,229,0.2)">🏢</div>
            <h3 style="font-size:1.4rem;font-weight:800;color:#fff;margin-bottom:0.75rem">Digitalisasi UMKM</h3>
            <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;line-height:1.6">
              Go digital dengan aman. Hubungkan bisnis Anda dengan programmer handal untuk membuat web, aplikasi mobile, atau software kustom.
            </p>
          </div>
          <a href="{{ route('register') }}?role=umkm" class="btn btn-primary" style="width:100%;text-align:center;padding:12px;font-size:0.9rem;background:linear-gradient(135deg, var(--primary), #3b82f6);box-shadow:0 8px 20px rgba(79,70,229,0.3)">
            Mulai Project UMKM →
          </a>
        </div>

        <!-- Portal Programmer -->
        <div class="fantasy-card portal-programmer" style="padding:2.5rem;display:flex;flex-direction:column;justify-content:space-between;height:340px;background:radial-gradient(circle at top right, rgba(245, 158, 11, 0.08) 0%, transparent 60%)">
          <div>
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(245,158,11,0.15);border:1px solid rgba(245,158,11,0.3);display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:1.5rem;box-shadow:0 0 15px rgba(245,158,11,0.2);color:#F59E0B;font-weight:900;font-family:monospace">&lt;/&gt;</div>
            <h3 style="font-size:1.4rem;font-weight:800;color:#fff;margin-bottom:0.75rem">Programmer Realm</h3>
            <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;line-height:1.6">
              Raih pendapatan melimpah. Kerjakan proyek terverifikasi dengan potongan minim, serta jual course pemrograman dengan bagi hasil 80%.
            </p>
          </div>
          <a href="{{ route('register') }}?role=programmer" class="btn" style="width:100%;text-align:center;padding:12px;font-size:0.9rem;background:linear-gradient(135deg, var(--orange), #d97706);color:#fff;border:none;box-shadow:0 8px 20px rgba(245,158,11,0.3)">
            Daftar Programmer →
          </a>
        </div>

        <!-- Portal Pelajar -->
        <div class="fantasy-card portal-student" style="padding:2.5rem;display:flex;flex-direction:column;justify-content:space-between;height:340px;background:radial-gradient(circle at top right, rgba(16, 185, 129, 0.08) 0%, transparent 60%)">
          <div>
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin-bottom:1.5rem;box-shadow:0 0 15px rgba(16,185,129,0.2)">🎓</div>
            <h3 style="font-size:1.4rem;font-weight:800;color:#fff;margin-bottom:0.75rem">Akselerasi Pelajar</h3>
            <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;line-height:1.6">
              Akselerasikan keahlian Anda. Pelajari studi kasus proyek industri nyata, buat tugas bersertifikat, dan hubungkan profil Anda ke UMKM.
            </p>
          </div>
          <a href="{{ route('courses.index') }}" class="btn" style="width:100%;text-align:center;padding:12px;font-size:0.9rem;background:linear-gradient(135deg, #10B981, #059669);color:#fff;border:none;box-shadow:0 8px 20px rgba(16,185,129,0.3)">
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

    currentTab = type;

    if (type === 'project') {
      // Button states
      btnProject.style.background = 'var(--primary)';
      btnProject.style.color = '#fff';
      btnCourse.style.background = 'transparent';
      btnCourse.style.color = 'rgba(255,255,255,0.6)';

      // Card states
      cardCourse.classList.remove('active');
      cardCourse.classList.add('exit');
      
      cardProject.classList.remove('exit');
      cardProject.classList.add('active');

      // Badge states
      badgeCourse.classList.remove('active');
      badgeProject.classList.add('active');
    } else {
      // Button states
      btnCourse.style.background = 'var(--orange)';
      btnCourse.style.color = '#fff';
      btnProject.style.background = 'transparent';
      btnProject.style.color = 'rgba(255,255,255,0.6)';

      // Card states
      cardProject.classList.remove('active');
      cardProject.classList.add('exit');
      
      cardCourse.classList.remove('exit');
      cardCourse.classList.add('active');

      // Badge states
      badgeProject.classList.remove('active');
      badgeCourse.classList.add('active');
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
