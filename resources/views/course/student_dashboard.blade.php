@extends('layouts.app')
@section('title', 'Dashboard Pelajar')
@section('content')
<div style="background:linear-gradient(135deg,#1E1260,#3D1FAF);color:#fff;padding:2.5rem 2rem;position:relative">
  <div style="position:absolute;inset:0;background:radial-gradient(ellipse 50% 50% at 80% 50%,rgba(255,255,255,.1) 0%,transparent 60%)"></div>
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:flex-end;margin-bottom:1rem;position:relative;z-index:2">
    <form method="POST" action="{{ route('logout') }}" style="display:inline">
      @csrf
      <button type="submit" class="btn btn-ghost btn-sm" style="border-color:rgba(255,255,255,.25);color:#fff;background:rgba(255,255,255,.1);font-weight:600" aria-label="Keluar dari akun">Keluar 🚪</button>
    </form>
  </div>
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;position:relative;z-index:1">
    <div>
      <div style="display:inline-block;background:rgba(255,255,255,.15);padding:4px 12px;border-radius:99px;font-size:.78rem;font-weight:700;margin-bottom:.5rem">🎓 ROLE: PELAJAR / STUDENT</div>
      <h1 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:.25rem">Halo, {{ $user->name }}!</h1>
      <p style="font-size:.9rem;color:rgba(255,255,255,.75)">Tingkatkan skill digital Anda dengan belajar dari Programmer berpengalaman.</p>
    </div>
    <div style="text-align:right">
      <div style="font-size:.8rem;color:rgba(255,255,255,.6)">Status Akun</div>
      <span style="font-size:.78rem;font-weight:600;padding:4px 12px;border-radius:99px;background:#D1FAE5;color:#065F46;display:inline-block;margin-top:4px">✓ Pelajar Aktif</span>
    </div>
  </div>
</div>

<div class="dash-layout">
  <!-- STATS -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-card-icon">📚</div>
      <div class="stat-card-value">{{ $enrollments->count() }}</div>
      <div class="stat-card-label">Course Diikuti</div>
    </div>
    <div class="stat-card">
      <div class="stat-card-icon">⏳</div>
      <div class="stat-card-value">{{ $enrollments->where('status', 'active')->count() }}</div>
      <div class="stat-card-label">Sedang Dipelajari</div>
    </div>
    <div class="stat-card">
      <div class="stat-card-icon">🏆</div>
      <div class="stat-card-value">{{ $enrollments->where('status', 'completed')->count() }}</div>
      <div class="stat-card-label">Course Selesai</div>
    </div>
    <div class="stat-card">
      <div class="stat-card-icon">📜</div>
      <div class="stat-card-value">{{ $enrollments->where('status', 'completed')->count() }}</div>
      <div class="stat-card-label">Sertifikat Kelulusan</div>
    </div>
  </div>

  <!-- IMK GUIDE: Human-Computer Interaction Guidelines -->
  <div class="imk-guide">
    <div class="imk-guide-icon">💡</div>
    <div>
      <div class="imk-guide-title">Panduan Interaksi Manusia & Komputer (IMK)</div>
      <div class="imk-guide-text">
        BuilderHub memudahkan Anda belajar:
        <ul style="margin-left:1.2rem;margin-top:.25rem;display:flex;flex-direction:column;gap:3px">
          <li><strong>Eksplorasi</strong>: Cari dan pilih course premium/gratis pada tab <strong>Jelajah Course</strong>.</li>
          <li><strong>Pembayaran Jelas</strong>: Klik "Ikuti Course" untuk memicu dialog checkout simulasi yang interaktif.</li>
          <li><strong>Belajar Mandiri</strong>: Tonton materi video, tandai progress belajar Anda, dan klaim sertifikat secara instan setelah selesai!</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- TABS -->
  <div class="tab-bar" role="tablist" aria-label="Menu Dashboard Pelajar">
    <button class="tab-btn active" onclick="showTab('my-courses')" role="tab" aria-selected="true" id="tab-my-courses">📚 Course Saya</button>
    <button class="tab-btn" onclick="showTab('explore')" role="tab" id="tab-explore">🔍 Jelajah Course</button>
    <button class="tab-btn" onclick="showTab('certificates')" role="tab" id="tab-certificates">📜 Sertifikat Saya</button>
  </div>

  <!-- MY COURSES TAB -->
  <div id="pane-my-courses" role="tabpanel">
    <div style="display:grid;grid-template-columns:1fr;gap:1rem">
      @forelse($enrollments as $enroll)
      @php $c = $enroll->course; @endphp
      <div class="card" style="display:flex;gap:1.5rem;align-items:center;padding:1.5rem;flex-wrap:wrap">
        <div style="width:100px;height:80px;background:linear-gradient(135deg,#1E1260,#3D1FAF);border-radius:var(--radius);display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fff;flex-shrink:0">⚛️</div>
        <div style="flex:1;min-width:280px">
          <div style="display:flex;gap:.5rem;margin-bottom:.25rem;align-items:center">
            <span class="level-badge level-{{ $c->level }}" style="position:static;font-size:.7rem;font-weight:700;padding:2px 8px;border-radius:99px">{{ $c->level_label }}</span>
            <span style="font-size:.75rem;color:var(--text3)">Pengajar: <strong>{{ $c->instructor->name }}</strong></span>
          </div>
          <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:.35rem">{{ $c->title }}</h3>
          <p style="font-size:.82rem;color:var(--text2);margin-bottom:.5rem">{{ Str::limit($c->description, 120) }}</p>
          <div style="font-size:.78rem;color:var(--text3)">
            <span>📹 {{ $c->videos->count() }} Video Pembelajaran</span> · <span>⏱ {{ $c->duration ?? 'Durasi tidak ditentukan' }}</span>
          </div>
        </div>
        <div style="text-align:right;flex-shrink:0;min-width:180px">
          @if($enroll->status === 'completed')
            <div style="color:var(--green);font-weight:700;font-size:.9rem;margin-bottom:.5rem;display:flex;align-items:center;justify-content:flex-end;gap:4px">
              <span>✓ Selesai & Lulus</span>
            </div>
            <button onclick="viewCertificate('{{ $user->name }}', '{{ addslashes($c->title) }}', '{{ addslashes($c->instructor->name) }}', '{{ $enroll->updated_at->format('d M Y') }}')" class="btn btn-ghost btn-sm" style="color:var(--primary);border-color:var(--primary)">📜 Lihat Sertifikat</button>
          @else
            <div style="margin-bottom:.5rem;font-size:.8rem;color:var(--text3)">Status: <strong style="color:var(--orange)">Belajar</strong></div>
            <button onclick="openLearningRoom({{ $c->id }}, '{{ addslashes($c->title) }}', {{ json_encode($c->videos) }}, {{ $c->id }})" class="btn btn-primary btn-sm">▶ Mulai Belajar</button>
          @endif
        </div>
      </div>
      @empty
      <div style="text-align:center;padding:4rem 2rem;background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius-lg)">
        <div style="font-size:3rem;margin-bottom:1rem">📚</div>
        <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:.25rem">Belum ada course yang Anda ikuti</h3>
        <p style="font-size:.85rem;color:var(--text3);margin-bottom:1.5rem">Mulai belajar teknologi baru sekarang dengan gratis maupun premium!</p>
        <button onclick="showTab('explore')" class="btn btn-primary">Cari Course Sekarang</button>
      </div>
      @endforelse
    </div>
  </div>

  <!-- EXPLORE COURSES TAB -->
  <div id="pane-explore" style="display:none" role="tabpanel">
    <div class="course-grid">
      @forelse($availableCourses as $course)
      @php
        $isEnrolled = $enrollments->contains('course_id', $course->id);
      @endphp
      <article class="course-card" style="display:flex;flex-direction:column;justify-content:space-between">
        <div>
          <div class="course-thumb" style="background:linear-gradient(135deg,#1E1260,#6C38FF)">
            <span style="font-size:2.5rem">💻</span>
            <span class="level-badge level-{{ $course->level }}">{{ $course->level_label }}</span>
          </div>
          <div style="padding:1rem">
            <div style="font-size:.78rem;color:var(--text3);margin-bottom:.25rem">Kategori: <strong>{{ $course->category }}</strong></div>
            <h3 style="font-size:.95rem;font-weight:700;margin-bottom:.4rem;line-height:1.4">{{ $course->title }}</h3>
            <p style="font-size:.8rem;color:var(--text2);margin-bottom:.75rem;line-height:1.5">{{ Str::limit($course->description, 90) }}</p>
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:.5rem">
              <div style="width:20px;height:20px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:.6rem;font-weight:700;color:#fff">{{ strtoupper(substr($course->instructor->name, 0, 1)) }}</div>
              <span style="font-size:.78rem;color:var(--text2)">{{ $course->instructor->name }}</span>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;font-size:.75rem;color:var(--text3)">
              <span>⭐ {{ $course->rating }} · {{ number_format($course->total_students) }} siswa</span>
              <span>📹 {{ $course->total_videos }} video</span>
            </div>
          </div>
        </div>
        <div style="padding:1rem;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;background:var(--bg2)">
          <span style="font-size:1.05rem;font-weight:800;color:{{ $course->is_free ? 'var(--green)' : 'var(--text)' }}">{{ $course->price_formatted }}</span>
          @if($isEnrolled)
            <span style="font-size:.8rem;color:var(--green);font-weight:700">Diikuti ✓</span>
          @else
            <button onclick="triggerEnroll({{ $course->id }}, '{{ addslashes($course->title) }}', {{ $course->price }}, {{ $course->is_free ? 1 : 0 }}, '{{ addslashes($course->instructor->name) }}')" class="btn btn-primary btn-sm">
              {{ $course->is_free ? 'Ikuti Gratis' : 'Beli Course' }}
            </button>
          @endif
        </div>
      </article>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text3)">
        Belum ada course lain yang tersedia.
      </div>
      @endforelse
    </div>
  </div>

  <!-- CERTIFICATES TAB -->
  <div id="pane-certificates" style="display:none" role="tabpanel">
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1rem">
      @forelse($enrollments->where('status', 'completed') as $enroll)
      @php $c = $enroll->course; @endphp
      <div class="card" style="border-top:4px solid var(--primary);text-align:center;padding:1.5rem">
        <div style="font-size:2.5rem;margin-bottom:.5rem">📜</div>
        <h4 style="font-size:1rem;font-weight:700;margin-bottom:.25rem">{{ $c->title }}</h4>
        <p style="font-size:.8rem;color:var(--text2);margin-bottom:.75rem">Pengajar: {{ $c->instructor->name }}</p>
        <p style="font-size:.75rem;color:var(--text3);margin-bottom:1rem">Selesai pada: {{ $enroll->updated_at->format('d M Y') }}</p>
        <button onclick="viewCertificate('{{ $user->name }}', '{{ addslashes($c->title) }}', '{{ addslashes($c->instructor->name) }}', '{{ $enroll->updated_at->format('d M Y') }}')" class="btn btn-primary btn-sm btn-full">Tampilkan Sertifikat 📜</button>
      </div>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text3)">
        Belum ada sertifikat kelulusan. Selesaikan salah satu course Anda untuk mengklaim sertifikat!
      </div>
      @endforelse
    </div>
  </div>
</div>

<!-- IMK CHECKOUT MODAL (HUMAN-COMPUTER INTERACTION DEMONSTRATION) -->
<div id="checkoutModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;padding:1rem">
  <div style="background:var(--bg);border-radius:var(--radius-xl);padding:2rem;max-width:500px;width:100%;box-shadow:var(--shadow-lg)">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
      <h3 style="font-size:1.15rem;font-weight:800;color:var(--text)">🛒 Konfirmasi Pendaftaran Course</h3>
      <button onclick="closeCheckoutModal()" style="font-size:1.5rem;color:var(--text3);background:none;border:none">&times;</button>
    </div>
    
    <!-- IMK: System feedback layout with clear price splits and instructions -->
    <div style="background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:1rem;margin-bottom:1.25rem">
      <div style="font-size:.8rem;color:var(--text3);margin-bottom:2px">Judul Course</div>
      <strong id="checkoutCourseTitle" style="font-size:.95rem;color:var(--text)">-</strong>
      <div style="font-size:.8rem;color:var(--text3);margin-top:.5rem;margin-bottom:2px">Pengajar</div>
      <span id="checkoutInstructorName" style="font-size:.875rem;color:var(--text2)">-</span>
      <hr style="margin:.75rem 0;border:none;border-top:1px solid var(--border)">
      <div style="display:flex;justify-content:space-between;font-size:.9rem">
        <strong>Biaya Pendaftaran:</strong>
        <strong id="checkoutPriceText" style="color:var(--primary)">Rp 0</strong>
      </div>
    </div>

    <!-- MOCK CHECKOUT PAYMENT INTERACTION -->
    <div id="paymentFormSection">
      <h4 style="font-size:.85rem;font-weight:700;margin-bottom:.5rem">💳 Metode Pembayaran Simulasi</h4>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:1rem">
        <label style="border:1.5px solid var(--primary);border-radius:var(--radius-sm);padding:.5rem;display:flex;align-items:center;gap:.4rem;font-size:.8rem;cursor:pointer;background:var(--primary-light)">
          <input type="radio" name="payment_method" checked> Bank Transfer
        </label>
        <label style="border:1.5px solid var(--border);border-radius:var(--radius-sm);padding:.5rem;display:flex;align-items:center;gap:.4rem;font-size:.8rem;cursor:pointer;opacity:.6">
          <input type="radio" name="payment_method" disabled> Kartu Kredit
        </label>
      </div>

      <div style="font-size:.78rem;color:var(--text2);margin-bottom:1.25rem;background:var(--orange-light);padding:.75rem;border-radius:var(--radius-sm);border:1px solid rgba(245,158,11,.2);line-height:1.4">
        📌 <strong>Simulasi Pembayaran IMK:</strong> Tekan <strong>"Bayar & Daftarkan"</strong> untuk mensimulasikan pembayaran yang aman. Sistem akan memproses pendaftaran dan membuka akses materi secara instan.
      </div>

      <form id="enrollForm" method="POST">
        @csrf
        <div style="display:flex;gap:.75rem">
          <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">Bayar & Daftarkan Sekarang ✅</button>
          <button type="button" onclick="closeCheckoutModal()" class="btn btn-ghost">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- IMK LEARNING ROOM VIEW (UDEMY-LIKE INTERACTIVE COMPONENT) -->
<div id="learningRoomModal" style="display:none;position:fixed;inset:0;background:rgba(15,15,26,.97);z-index:9999;color:#fff;display:none;flex-direction:column">
  <!-- Top Bar -->
  <div style="height:60px;background:var(--dark2);border-bottom:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:space-between;padding:0 2rem">
    <div style="display:flex;align-items:center;gap:1rem">
      <span style="font-size:1.5rem">💻</span>
      <div>
        <h3 id="learnCourseTitle" style="font-size:.95rem;font-weight:700;color:#fff;margin:0">-</h3>
        <div style="font-size:.75rem;color:rgba(255,255,255,.6)">Ruang Belajar Interaktif Pelajar</div>
      </div>
    </div>
    <button onclick="closeLearningRoom()" style="background:rgba(255,255,255,.1);border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem;border:none">&times;</button>
  </div>

  <!-- Main Grid -->
  <div style="flex:1;display:grid;grid-template-columns:3fr 1fr;overflow:hidden">
    <!-- Player Panel -->
    <div style="padding:2rem;display:flex;flex-direction:column;justify-content:space-between;overflow-y:auto">
      <div style="width:100%;aspect-ratio:16/9;background:#000;border-radius:var(--radius-lg);overflow:hidden;border:1px solid rgba(255,255,255,.15)">
        <iframe id="videoIframe" style="width:100%;height:100%;border:none" src="" allowfullscreen></iframe>
      </div>
      
      <div style="margin-top:1.5rem;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);padding:1.5rem;border-radius:var(--radius-lg)">
        <h4 style="font-size:1.05rem;font-weight:700;margin-bottom:.5rem">Progress Belajar Anda</h4>
        <p style="font-size:.82rem;color:rgba(255,255,255,.7);margin-bottom:1.25rem">Tonton seluruh video pembelajaran dari Programmer untuk menguasai materi secara komprehensif. Setelah siap, Anda dapat menyatakan kelulusan di bawah.</p>
        
        <div style="display:flex;justify-content:space-between;align-items:center">
          <div style="font-size:.85rem;color:#34D399;font-weight:600">✓ Pastikan semua materi dipahami dengan baik</div>
          <form id="completeCourseForm" method="POST">
            @csrf
            <button type="submit" class="btn btn-success" style="font-size:.85rem;font-weight:700">Selesaikan Kelas & Claim Sertifikat 📜</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Sidebar Videos List -->
    <div style="background:var(--dark2);border-left:1px solid rgba(255,255,255,.1);overflow-y:auto;padding:1rem">
      <h4 style="font-size:.85rem;font-weight:700;color:rgba(255,255,255,.8);margin-bottom:1rem;text-transform:uppercase;letter-spacing:1px">Daftar Materi Video</h4>
      <div id="videoListContainer" style="display:flex;flex-direction:column;gap:.5rem">
        <!-- Rendered via JS -->
      </div>
    </div>
  </div>
</div>

<!-- BEAUTIFUL CERTIFICATE PREVIEW MODAL (PRINT-READY) -->
<div id="certificateModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:99999;align-items:center;justify-content:center;padding:2rem;overflow-y:auto">
  <div style="background:#fff;border-radius:var(--radius-lg);padding:2rem;max-width:850px;width:100%;box-shadow:var(--shadow-lg);position:relative">
    <button onclick="closeCertificate()" style="position:absolute;top:1rem;right:1rem;background:var(--bg3);border-radius:50%;width:36px;height:36px;font-size:1.25rem;color:var(--text);border:none">&times;</button>
    
    <div id="printCertArea" style="border:15px double #3D1FAF;padding:3rem 4rem;background:#FFFDF9;text-align:center;color:#1E1260;position:relative">
      <!-- Watermark background -->
      <div style="position:absolute;inset:0;background-image:radial-gradient(#3D1FAF 1px,transparent 1px);background-size:24px 24px;opacity:0.04;pointer-events:none"></div>
      
      <div style="font-size:1.8rem;font-weight:800;letter-spacing:4px;margin-bottom:.5rem;text-transform:uppercase;color:#1E1260">Sertifikat Kelulusan</div>
      <div style="font-size:.85rem;letter-spacing:2px;color:var(--text3);text-transform:uppercase;margin-bottom:2rem">Diberikan secara resmi oleh BuilderHub</div>
      
      <div style="font-size:.95rem;color:var(--text2);margin-bottom:.5rem">Dengan ini menyatakan bahwa pelajar:</div>
      <div id="certStudentName" style="font-family:'Georgia',serif;font-size:2.2rem;font-weight:700;text-decoration:underline;color:#111827;margin-bottom:1.5rem">-</div>
      
      <div style="font-size:.95rem;color:var(--text2);max-width:550px;margin:0 auto 1.5rem;line-height:1.6">
        Telah menyelesaikan seluruh materi pengajaran dan lulus evaluasi pembelajaran online pada kelas:
      </div>
      
      <div id="certCourseTitle" style="font-size:1.4rem;font-weight:800;color:#3D1FAF;margin-bottom:.5rem;line-height:1.3">-</div>
      <div style="font-size:.85rem;color:var(--text3);margin-bottom:2.5rem">Diajarkan & Terverifikasi oleh Programmer: <strong id="certInstructorName" style="color:var(--text2)">-</strong></div>

      <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-top:2.5rem;padding:0 2rem">
        <div style="text-align:left">
          <div style="font-size:.78rem;color:var(--text3);margin-bottom:.25rem">Tanggal Kelulusan</div>
          <strong id="certDateText" style="font-size:.9rem;color:var(--text2)">-</strong>
        </div>
        <div style="text-align:center">
          <div style="width:70px;height:70px;background:#3D1FAF;border-radius:50%;border:3px solid #FFF7ED;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:.65rem;transform:rotate(-12deg);margin-bottom:.5rem;box-shadow:0 2px 8px rgba(0,0,0,.15)">
            BUILDERHUB<br>VERIFIED
          </div>
        </div>
        <div style="text-align:right">
          <div style="font-size:.75rem;color:var(--text3);margin-bottom:.5rem;text-transform:uppercase;letter-spacing:1px">Direktur Kurikulum</div>
          <div style="font-family:'Georgia',serif;font-style:italic;font-size:1.1rem;font-weight:700;color:var(--text);margin-bottom:4px">BuilderHub Academy</div>
          <div style="width:120px;height:1px;background:var(--border);margin:0 0 0 auto"></div>
        </div>
      </div>
    </div>
    
    <div style="margin-top:1.5rem;display:flex;justify-content:flex-end;gap:.5rem">
      <button onclick="window.print()" class="btn btn-primary">🖨 Cetak / Simpan PDF</button>
      <button onclick="closeCertificate()" class="btn btn-ghost">Tutup</button>
    </div>
  </div>
</div>

@push('scripts')
<script>
function showTab(name){
  ['my-courses','explore','certificates'].forEach(t=>{
    document.getElementById('pane-'+t).style.display = 'none';
    document.getElementById('tab-'+t).classList.remove('active');
    document.getElementById('tab-'+t).setAttribute('aria-selected','false');
  });
  document.getElementById('pane-'+name).style.display = 'block';
  document.getElementById('tab-'+name).classList.add('active');
  document.getElementById('tab-'+name).setAttribute('aria-selected','true');
  history.replaceState(null,'','#'+name);
}

// Restore active tab
const hash = location.hash.replace('#','');
if(['my-courses','explore','certificates'].includes(hash)) showTab(hash);

// Checkout Modal logic
function triggerEnroll(id, title, price, isFree, instructor){
  document.getElementById('checkoutCourseTitle').textContent = title;
  document.getElementById('checkoutInstructorName').textContent = instructor;
  document.getElementById('checkoutPriceText').textContent = isFree ? 'Gratis' : 'Rp ' + price.toLocaleString('id-ID');
  document.getElementById('enrollForm').action = `${window.APP_URL}/course-manager/course/${id}/enroll`;
  document.getElementById('checkoutModal').style.display = 'flex';
}
function closeCheckoutModal(){
  document.getElementById('checkoutModal').style.display = 'none';
}

// Learning room logic
function openLearningRoom(id, title, videos, courseId){
  document.getElementById('learnCourseTitle').textContent = title;
  document.getElementById('completeCourseForm').action = `${window.APP_URL}/course-manager/course/${courseId}/complete`;
  
  const container = document.getElementById('videoListContainer');
  container.innerHTML = '';
  
  if(!videos || videos.length === 0){
    container.innerHTML = '<div style="color:rgba(255,255,255,.5);font-size:.8rem;text-align:center;padding:1rem">Materi video belum diunggah oleh Programmer.</div>';
    document.getElementById('videoIframe').src = '';
  } else {
    videos.forEach((vid, index) => {
      const activeClass = index === 0 ? 'background:var(--primary);' : 'background:rgba(255,255,255,.05);';
      const item = document.createElement('div');
      item.style = `padding:.75rem;border-radius:var(--radius-sm);cursor:pointer;display:flex;flex-direction:column;gap:.25rem;transition:.15s;${activeClass}`;
      item.onclick = () => selectVideo(vid.video_url, item);
      item.innerHTML = `
        <span style="font-size:.8rem;font-weight:700;color:#fff">${index + 1}. ${vid.title}</span>
        <span style="font-size:.7rem;color:rgba(255,255,255,.6)">⏱ ${vid.duration || 'N/A'}</span>
      `;
      container.appendChild(item);
    });
    
    // Play the first video by default
    selectVideo(videos[0].video_url, container.firstChild);
  }
  
  document.getElementById('learningRoomModal').style.display = 'flex';
}

function selectVideo(url, element){
  // Set active style
  const siblings = element.parentNode.childNodes;
  siblings.forEach(s => {
    if(s.nodeType === 1) s.style.background = 'rgba(255,255,255,.05)';
  });
  element.style.background = 'var(--primary)';
  
  // Format embed url if needed
  let embedUrl = url;
  if(url.includes('youtube.com/watch?v=')){
    embedUrl = url.replace('watch?v=', 'embed/');
  }
  document.getElementById('videoIframe').src = embedUrl;
}

function closeLearningRoom(){
  document.getElementById('videoIframe').src = '';
  document.getElementById('learningRoomModal').style.display = 'none';
}

// Certificate logic
function viewCertificate(student, course, instructor, date){
  document.getElementById('certStudentName').textContent = student;
  document.getElementById('certCourseTitle').textContent = course;
  document.getElementById('certInstructorName').textContent = instructor;
  document.getElementById('certDateText').textContent = date;
  document.getElementById('certificateModal').style.display = 'flex';
}
function closeCertificate(){
  document.getElementById('certificateModal').style.display = 'none';
}

// Close modals on backdrop click
document.getElementById('checkoutModal')?.addEventListener('click', e => {
  if(e.target === e.currentTarget) closeCheckoutModal();
});
document.getElementById('certificateModal')?.addEventListener('click', e => {
  if(e.target === e.currentTarget) closeCertificate();
});
</script>
@endpush
@endsection
