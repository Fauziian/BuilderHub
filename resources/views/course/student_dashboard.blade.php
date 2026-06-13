@extends('layouts.app')
@section('title', 'Dashboard Pelajar')
@section('content')
<div style="background:linear-gradient(135deg,#1E1260,#3D1FAF);color:#fff;padding:2.5rem 2rem;position:relative">
  <div style="position:absolute;inset:0;background:radial-gradient(ellipse 50% 50% at 80% 50%,rgba(255,255,255,.1) 0%,transparent 60%)"></div>
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:flex-end;align-items:center;gap:.75rem;margin-bottom:1rem;position:relative;z-index:2">
    <a href="{{ route('messages.index') }}" class="btn btn-ghost btn-sm" style="border-color:rgba(255,255,255,.25);color:#fff;background:rgba(255,255,255,.1);font-weight:600;display:inline-flex;align-items:center;gap:6px">💬 Pesan / Chat</a>
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
    <div class="stat-card glass-card">
      <div class="stat-card-icon" style="background:rgba(79,70,229,0.1)">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 44px; height: 44px; filter: drop-shadow(0 4px 8px rgba(79, 70, 229, 0.4));">
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
      <div class="stat-card-value">{{ $enrollments->count() }}</div>
      <div class="stat-card-label">Course Diikuti</div>
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
      <div class="stat-card-value">{{ $enrollments->where('status', 'active')->count() }}</div>
      <div class="stat-card-label">Sedang Dipelajari</div>
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
      <div class="stat-card-value">{{ $enrollments->where('status', 'completed')->count() }}</div>
      <div class="stat-card-label">Course Selesai</div>
    </div>
    <div class="stat-card glass-card">
      <div class="stat-card-icon" style="background:rgba(139,92,246,0.1)">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 44px; height: 44px; filter: drop-shadow(0 4px 8px rgba(139, 92, 246, 0.4));">
          <defs>
            <linearGradient id="cert-grad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#C084FC" />
              <stop offset="100%" stop-color="#8B5CF6" />
            </linearGradient>
          </defs>
          <rect x="8" y="12" width="48" height="34" rx="4" fill="#FFF" stroke="url(#cert-grad)" stroke-width="3" />
          <line x1="16" y1="20" x2="36" y2="20" stroke="#DDD" stroke-width="2" stroke-linecap="round" />
          <line x1="16" y1="26" x2="48" y2="26" stroke="#DDD" stroke-width="2" stroke-linecap="round" />
          <line x1="16" y1="32" x2="40" y2="32" stroke="#DDD" stroke-width="2" stroke-linecap="round" />
          <circle cx="44" cy="36" r="6" fill="#F59E0B" />
          <path d="M 42 42 L 40 48 L 44 46 L 48 48 L 46 42 Z" fill="#D97706" />
        </svg>
      </div>
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
    <!-- Search & Filter Bar for My Courses -->
    <div class="glass-card" style="margin-bottom:1.5rem;padding:1.25rem;display:flex;gap:1rem;flex-wrap:wrap;align-items:center;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.02)">
      <div style="flex:1;min-width:260px;position:relative">
        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:0.9rem;color:var(--text3)">🔍</span>
        <input type="text" id="myCoursesSearch" placeholder="Cari berdasarkan judul atau pengajar..." style="width:100%;padding:0.6rem 0.6rem 0.6rem 2.2rem;border-radius:var(--radius-sm);background:var(--bg2);border:1px solid var(--border);color:var(--text);font-size:0.85rem">
      </div>
      <div style="min-width:160px">
        <select id="myCoursesLevelFilter" style="width:100%;padding:0.6rem;border-radius:var(--radius-sm);background:var(--bg2);border:1px solid var(--border);color:var(--text);font-size:0.85rem">
          <option value="">Semua Tingkat</option>
          <option value="beginner">Pemula</option>
          <option value="intermediate">Menengah</option>
          <option value="advanced">Mahir</option>
        </select>
      </div>
    </div>

    <!-- Empty Search Result Alert -->
    <div id="myCoursesEmptySearch" class="card glass-card" style="display:none;text-align:center;padding:3rem;color:var(--text3)">
      <div style="font-size:2rem;margin-bottom:0.5rem">🔍</div>
      <div>Tidak ada course yang sesuai dengan pencarian Anda.</div>
    </div>

    <div id="myCoursesList" style="display:grid;grid-template-columns:1fr;gap:1rem">
      @forelse($enrollments as $enroll)
      @php $c = $enroll->course; @endphp
      <div class="card glass-card my-course-item" data-title="{{ strtolower($c->title) }}" data-instructor="{{ strtolower($c->instructor->name) }}" data-level="{{ $c->level }}" style="display:flex;gap:1.5rem;align-items:center;padding:1.5rem;flex-wrap:wrap">
        <div style="width:100px;height:80px;background:linear-gradient(135deg,#3B82F6,#8B5CF6);border-radius:var(--radius);display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;box-shadow:0 8px 16px rgba(59,130,246,0.3)">
          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:38px;height:38px;filter:drop-shadow(0 2px 4px rgba(255,255,255,0.4))">
            <path d="M 16 48 L 32 16 L 48 48 Z" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="32" cy="16" r="4" fill="#FFF" />
            <circle cx="16" cy="48" r="4" fill="#FFF" />
            <circle cx="48" cy="48" r="4" fill="#FFF" />
          </svg>
        </div>
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
            <button onclick="viewCertificate('{{ $user->name }}', '{{ addslashes($c->title) }}', '{{ addslashes($c->instructor->name) }}', '{{ $enroll->updated_at->format('d M Y') }}')" class="btn btn-3d btn-sm" style="color:var(--primary);border-color:var(--primary)">Lihat Sertifikat 📜</button>
            {{-- Rating block --}}
            @php $existingCourseReview = $givenCourseReviews->get($c->id); @endphp
            @if($existingCourseReview)
              <div style="margin-top:.5rem;padding:.5rem .75rem;background:var(--bg2);border-radius:var(--radius);border:1px solid var(--border)">
                <div style="font-size:.72rem;font-weight:600;color:var(--green);margin-bottom:.2rem">Rating Anda:</div>
                <div style="display:flex;gap:1px;justify-content:flex-end">
                  @for($s=1;$s<=5;$s++)
                    <span style="font-size:1rem;color:{{ $s<=$existingCourseReview->rating ? '#F59E0B' : '#D1D5DB' }}">★</span>
                  @endfor
                </div>
                @if($existingCourseReview->comment)
                <p style="font-size:.72rem;color:var(--text2);margin-top:.25rem;font-style:italic">"{{ Str::limit($existingCourseReview->comment, 60) }}"</p>
                @endif
              </div>
            @else
              <button onclick="openCourseRatingModal({{ $c->id }}, '{{ addslashes($c->title) }}', '{{ addslashes($c->instructor->name) }}')" class="btn btn-3d btn-3d-orange btn-sm" style="margin-top:.4rem;font-size:.78rem">⭐ Beri Rating</button>
            @endif
          @else
            <div style="margin-bottom:.5rem;font-size:.8rem;color:var(--text3)">Status: <strong style="color:var(--orange)">Belajar</strong></div>
            <button onclick="openLearningRoom({{ $c->id }}, '{{ addslashes($c->title) }}', {{ json_encode($c->videos) }}, {{ $c->id }}, {{ $c->instructor_id }})" class="btn btn-3d btn-sm">▶ Mulai Belajar</button>
          @endif
        </div>
      </div>
      @empty
      <div class="card glass-card" style="text-align:center;padding:4rem 2rem;">
        <div style="font-size:3rem;margin-bottom:1rem">📚</div>
        <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:.25rem">Belum ada course yang Anda ikuti</h3>
        <p style="font-size:.85rem;color:var(--text3);margin-bottom:1.5rem">Mulai belajar teknologi baru sekarang dengan gratis maupun premium!</p>
        <button onclick="showTab('explore')" class="btn btn-3d">Cari Course Sekarang</button>
      </div>
      @endforelse
    </div>
  </div>

  <!-- EXPLORE COURSES TAB -->
  <div id="pane-explore" style="display:none" role="tabpanel">
    <!-- Search & Filter Bar for Explore Courses -->
    <div class="glass-card" style="margin-bottom:1.5rem;padding:1.25rem;display:flex;gap:1rem;flex-wrap:wrap;align-items:center;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.02)">
      <div style="flex:1;min-width:260px;position:relative">
        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:0.9rem;color:var(--text3)">🔍</span>
        <input type="text" id="exploreSearch" placeholder="Cari berdasarkan judul, pengajar, kategori..." style="width:100%;padding:0.6rem 0.6rem 0.6rem 2.2rem;border-radius:var(--radius-sm);background:var(--bg2);border:1px solid var(--border);color:var(--text);font-size:0.85rem">
      </div>
      <div style="min-width:150px">
        <select id="exploreLevelFilter" style="width:100%;padding:0.6rem;border-radius:var(--radius-sm);background:var(--bg2);border:1px solid var(--border);color:var(--text);font-size:0.85rem">
          <option value="">Semua Tingkat</option>
          <option value="beginner">Pemula</option>
          <option value="intermediate">Menengah</option>
          <option value="advanced">Mahir</option>
        </select>
      </div>
      <div style="min-width:150px">
        <select id="exploreCategoryFilter" style="width:100%;padding:0.6rem;border-radius:var(--radius-sm);background:var(--bg2);border:1px solid var(--border);color:var(--text);font-size:0.85rem">
          <option value="">Semua Kategori</option>
          @foreach($availableCourses->pluck('category')->unique() as $cat)
            @if($cat)
              <option value="{{ strtolower($cat) }}">{{ $cat }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </div>

    <!-- Empty Search Result Alert -->
    <div id="exploreEmptySearch" class="card glass-card" style="grid-column:1/-1;display:none;text-align:center;padding:3rem;color:var(--text3)">
      <div style="font-size:2rem;margin-bottom:0.5rem">🔍</div>
      <div>Tidak ada course yang sesuai dengan pencarian Anda.</div>
    </div>

    <div id="exploreCoursesList" class="course-grid">
      @forelse($availableCourses as $course)
      @php
        $isEnrolled = $enrollments->contains('course_id', $course->id);
      @endphp
      <article class="course-card explore-course-item" data-title="{{ strtolower($course->title) }}" data-instructor="{{ strtolower($course->instructor->name) }}" data-category="{{ strtolower($course->category) }}" data-level="{{ $course->level }}" style="display:flex;flex-direction:column;justify-content:space-between">
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
            <button onclick="triggerEnroll({{ $course->id }}, '{{ addslashes($course->title) }}', {{ $course->price }}, {{ $course->is_free ? 1 : 0 }}, '{{ addslashes($course->instructor->name) }}')" class="btn btn-3d btn-sm">
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
      <div class="card glass-card" style="border-top:4px solid var(--primary);text-align:center;padding:1.5rem">
        <div style="font-size:2.5rem;margin-bottom:.5rem" class="float-3d">📜</div>
        <h4 style="font-size:1rem;font-weight:700;margin-bottom:.25rem">{{ $c->title }}</h4>
        <p style="font-size:.8rem;color:var(--text2);margin-bottom:.75rem">Pengajar: {{ $c->instructor->name }}</p>
        <p style="font-size:.75rem;color:var(--text3);margin-bottom:1rem">Selesai pada: {{ $enroll->updated_at->format('d M Y') }}</p>
        <button onclick="viewCertificate('{{ $user->name }}', '{{ addslashes($c->title) }}', '{{ addslashes($c->instructor->name) }}', '{{ $enroll->updated_at->format('d M Y') }}')" class="btn btn-3d btn-sm btn-full">Tampilkan Sertifikat 📜</button>
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
  <div style="background:var(--bg);border-radius:var(--radius-xl);padding:2rem;max-width:500px;width:100%;box-shadow:var(--shadow-lg);max-height:90vh;overflow-y:auto">
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
      <!-- Screen 1: Selection of payment method -->
      <div id="paymentSelectionScreen">
        <h4 style="font-size:.85rem;font-weight:700;margin-bottom:.75rem;color:var(--text)">💳 Pilih Metode Pembayaran</h4>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:1.25rem">
          <label class="payment-method-option" style="border:1.5px solid var(--primary);border-radius:var(--radius-sm);padding:.6rem .5rem;display:flex;align-items:center;gap:.4rem;font-size:.8rem;cursor:pointer;background:var(--primary-light)">
            <input type="radio" name="payment_method" value="qris" checked onchange="selectPaymentMethod('qris')">
            <span>📱 QRIS</span>
          </label>
          <label class="payment-method-option" style="border:1.5px solid var(--border);border-radius:var(--radius-sm);padding:.6rem .5rem;display:flex;align-items:center;gap:.4rem;font-size:.8rem;cursor:pointer">
            <input type="radio" name="payment_method" value="bank_transfer" onchange="selectPaymentMethod('bank_transfer')">
            <span>🏦 Bank Transfer</span>
          </label>
          <label class="payment-method-option" style="border:1.5px solid var(--border);border-radius:var(--radius-sm);padding:.6rem .5rem;display:flex;align-items:center;gap:.4rem;font-size:.8rem;cursor:pointer">
            <input type="radio" name="payment_method" value="debit" onchange="selectPaymentMethod('debit')">
            <span>💳 Debit Card</span>
          </label>
          <label class="payment-method-option" style="border:1.5px solid var(--border);border-radius:var(--radius-sm);padding:.6rem .5rem;display:flex;align-items:center;gap:.4rem;font-size:.8rem;cursor:pointer">
            <input type="radio" name="payment_method" value="visa" onchange="selectPaymentMethod('visa')">
            <span>💳 Visa</span>
          </label>
          <label class="payment-method-option" style="border:1.5px solid var(--border);border-radius:var(--radius-sm);padding:.6rem .5rem;display:flex;align-items:center;gap:.4rem;font-size:.8rem;cursor:pointer">
            <input type="radio" name="payment_method" value="bri" onchange="selectPaymentMethod('bri')">
            <span>🏦 Bank BRI</span>
          </label>
          <label class="payment-method-option" style="border:1.5px solid var(--border);border-radius:var(--radius-sm);padding:.6rem .5rem;display:flex;align-items:center;gap:.4rem;font-size:.8rem;cursor:pointer">
            <input type="radio" name="payment_method" value="bni" onchange="selectPaymentMethod('bni')">
            <span>🏦 Bank BNI</span>
          </label>
          <label class="payment-method-option" style="border:1.5px solid var(--border);border-radius:var(--radius-sm);padding:.6rem .5rem;display:flex;align-items:center;gap:.4rem;font-size:.8rem;cursor:pointer">
            <input type="radio" name="payment_method" value="bjb" onchange="selectPaymentMethod('bjb')">
            <span>🏦 Bank BJB</span>
          </label>
        </div>

        <div style="font-size:.78rem;color:var(--text2);margin-bottom:1.25rem;background:var(--bg2);padding:.75rem;border-radius:var(--radius-sm);border:1px solid var(--border);line-height:1.4">
          ℹ️ Pilih salah satu metode di atas. Anda akan diarahkan ke halaman invoice/gateway simulasi setelah mengklik tombol di bawah.
        </div>

        <div style="display:flex;gap:.75rem">
          <button type="button" onclick="goToInvoiceScreen()" class="btn btn-primary" style="flex:1;justify-content:center">Lanjutkan Pembayaran ➡️</button>
          <button type="button" onclick="closeCheckoutModal()" class="btn btn-ghost">Batal</button>
        </div>
      </div>

      <!-- Screen 2: Invoice / Payment Gateway Screen -->
      <div id="paymentInvoiceScreen" style="display:none">
        <h4 style="font-size:.88rem;font-weight:800;margin-bottom:1rem;color:var(--text);display:flex;align-items:center;gap:6px">
          <span>🧾</span> Invoice Pembayaran BuilderHub
        </h4>
        
        <!-- Status & Timer -->
        <div style="display:flex;justify-content:space-between;align-items:center;background:#FEF3C7;border:1px solid #F59E0B;border-radius:var(--radius-sm);padding:0.5rem 0.75rem;margin-bottom:1rem;font-size:0.75rem;color:#92400E">
          <span>Status: <strong>MENUNGGU PEMBAYARAN</strong></span>
          <span id="invoiceTimer" style="font-weight:700">23:59:59</span>
        </div>

        <!-- Dynamic Payment Details -->
        <div style="background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:1rem;margin-bottom:1.25rem">
          <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;font-size:0.8rem">
            <span style="color:var(--text3)">Metode Pembayaran</span>
            <strong id="invoicePaymentMethod" style="color:var(--primary)">QRIS</strong>
          </div>
          <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;font-size:0.8rem">
            <span style="color:var(--text3)">Total Tagihan</span>
            <strong id="invoiceTotalText" style="color:var(--text)">Rp 0</strong>
          </div>

          <!-- QRIS display -->
          <div id="qrisContainer" style="text-align:center;margin-top:1rem;padding:0.75rem;background:#fff;border-radius:var(--radius-sm);border:1px solid var(--border)">
            <div style="font-size:0.7rem;color:#000;font-weight:800;margin-bottom:0.25rem">QRIS DUKUNG SELURUH APLIKASI PEMBAYARAN</div>
            <img id="qrisImage" style="width:180px;height:180px;object-fit:contain;margin:0 auto" alt="QRIS Code">
            <div style="font-size:0.68rem;color:#666;margin-top:0.25rem">Pindai kode QR di atas untuk menyelesaikan pembayaran</div>
          </div>

          <!-- VA / Bank Details display -->
          <div id="vaContainer" style="display:none;margin-top:1rem;padding-top:0.75rem;border-top:1px dashed var(--border)">
            <div style="font-size:0.8rem;color:var(--text2);margin-bottom:0.25rem">Nomor Virtual Account (VA)</div>
            <div style="display:flex;justify-content:space-between;align-items:center;background:var(--bg);border:1px solid var(--border);padding:0.5rem 0.75rem;border-radius:var(--radius-sm)">
              <code id="vaNumber" style="font-size:0.95rem;font-weight:700;letter-spacing:1px;color:var(--primary)">8839081234567890</code>
              <button type="button" onclick="copyVaText()" style="background:var(--primary-light);color:var(--primary);border:none;border-radius:4px;padding:3px 8px;font-size:0.7rem;font-weight:700;cursor:pointer">Salin</button>
            </div>
            <div style="font-size:0.7rem;color:var(--text3);margin-top:0.4rem">Transfer dapat dilakukan melalui ATM, M-Banking, atau Internet Banking.</div>
          </div>
        </div>

        <form id="enrollForm" method="POST">
          @csrf
          <div style="display:flex;gap:.75rem">
            <button type="submit" class="btn btn-success" style="flex:1;justify-content:center;font-weight:700">Simulasikan Bayar Berhasil ✅</button>
            <button type="button" onclick="backToSelection()" class="btn btn-ghost">Ubah Metode</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Free Enrollment Direct Submit -->
    <div id="freeEnrollSection" style="display:none">
      <div style="font-size:.78rem;color:var(--text2);margin-bottom:1.25rem;background:var(--primary-light);padding:.75rem;border-radius:var(--radius-sm);border:1px solid rgba(79,70,229,.2);line-height:1.4">
        🎉 <strong>Course Gratis!</strong> Anda tidak memerlukan metode pembayaran untuk bergabung dengan course ini. Klik tombol di bawah untuk mendaftar secara langsung.
      </div>
      <form id="freeEnrollForm" method="POST">
        @csrf
        <div style="display:flex;gap:.75rem">
          <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">Daftar Sekarang (Gratis) ✅</button>
          <button type="button" onclick="closeCheckoutModal()" class="btn btn-ghost">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- IMK LEARNING ROOM VIEW (UDEMY-LIKE INTERACTIVE COMPONENT) -->
<div id="learningRoomModal" style="display:none;position:fixed;inset:0;background:rgba(10,10,22,.98);backdrop-filter:blur(20px);z-index:9999;color:#fff;display:none;flex-direction:column">
  <!-- Top Bar -->
  <div style="height:70px;background:rgba(20,20,35,0.8);border-bottom:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:space-between;padding:0 2rem;backdrop-filter:blur(10px)">
    <div style="display:flex;align-items:center;gap:1rem">
      <div style="background:rgba(79,70,229,0.15);width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(79,70,229,0.3)">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;filter:drop-shadow(0 2px 4px rgba(79,70,229,0.5))"><path d="M21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h5v2h8v-2h5c1.1 0 1.9-.9 1.9-2l.01-12c0-1.1-.9-2-2-2zm0 14H3V5h18v12z" fill="#8B5CF6"/><path d="M10 8l6 4-6 4V8z" fill="#8B5CF6"/></svg>
      </div>
      <div>
        <h3 id="learnCourseTitle" style="font-size:1.05rem;font-weight:800;color:#fff;margin:0">-</h3>
        <div style="font-size:.78rem;color:rgba(255,255,255,.5);display:flex;align-items:center;gap:4px">
          <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#10B981"></span>
          Ruang Belajar Interaktif Pelajar
        </div>
      </div>
    </div>
    <div style="display:flex;align-items:center;gap:12px">
      <button id="chatInstructorBtn" class="btn btn-primary btn-sm" style="display:inline-flex;align-items:center;gap:6px;font-size:.78rem;font-weight:700;padding:6px 12px">💬 Tanya Instruktur</button>
      <button onclick="closeLearningRoom()" class="btn-3d" style="background:#EF4444;box-shadow:0 3px 0 #B91C1C;color:#fff;border-radius:50%;width:34px;height:34px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;border:none;cursor:pointer">&times;</button>
    </div>
  </div>

  <!-- Main Grid -->
  <div style="flex:1;display:grid;grid-template-columns:3fr 1fr;overflow:hidden">
    <!-- Player Panel -->
    <div style="padding:2rem;display:flex;flex-direction:column;justify-content:space-between;overflow-y:auto;background:radial-gradient(circle at top left, rgba(79,70,229,0.05), transparent)">
      <div style="width:100%;aspect-ratio:16/9;background:#000;border-radius:var(--radius-lg);overflow:hidden;border:2px solid rgba(79, 70, 229, 0.4);box-shadow:0 0 35px rgba(79, 70, 229, 0.3)">
        <iframe id="videoIframe" style="width:100%;height:100%;border:none" src="" allowfullscreen></iframe>
      </div>
      
      <div class="card glass-card" style="margin-top:1.5rem;padding:1.5rem 1.5rem 2rem 1.5rem;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);overflow:visible">
        <h4 style="font-size:1.05rem;font-weight:700;margin-bottom:.5rem;color:#FFF">Progress Belajar Anda</h4>
        <p style="font-size:.82rem;color:rgba(255,255,255,.6);margin-bottom:1.25rem">Tonton seluruh video pembelajaran dari Programmer untuk menguasai materi secara komprehensif. Setelah siap, Anda dapat menyatakan kelulusan di bawah.</p>
        
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
          <div style="font-size:.85rem;color:#34D399;font-weight:600;display:flex;align-items:center;gap:6px">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="#10B981"/></svg>
            Pastikan semua materi dipahami dengan baik
          </div>
          <form id="completeCourseForm" method="POST" style="margin:0;display:inline-block">
            @csrf
            <button type="submit" class="btn btn-success btn-3d-green" style="font-size:.85rem;font-weight:700;padding:8px 16px">Selesaikan Kelas & Claim Sertifikat 📜</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Sidebar Videos List -->
    <div style="background:rgba(15,15,28,0.7);border-left:1px solid rgba(255,255,255,.08);overflow-y:auto;padding:1.25rem">
      <h4 style="font-size:.78rem;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:1.25rem;text-transform:uppercase;letter-spacing:1px;display:flex;align-items:center;gap:6px">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8 12.5v-9l6 4.5-6 4.5z" fill="rgba(255,255,255,.5)"/></svg>
        Daftar Materi Video
      </h4>
      <div id="videoListContainer" style="display:flex;flex-direction:column;gap:.75rem">
        <!-- Rendered via JS -->
      </div>
    </div>
  </div>
</div>

<!-- ===== COURSE RATING MODAL (muncul setelah Selesaikan Kelas) ===== -->
<div id="courseRatingModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:99998;align-items:center;justify-content:center;padding:1rem">
  <div style="background:var(--bg);border-radius:var(--radius-xl);padding:2rem;max-width:480px;width:100%;box-shadow:var(--shadow-lg)">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
      <h3 style="font-size:1.1rem;font-weight:800;color:var(--text)">⭐ Berikan Rating & Ulasan</h3>
      <button onclick="closeCourseRatingModal()" style="font-size:1.5rem;color:var(--text3);background:none;border:none;cursor:pointer">&times;</button>
    </div>

    <div style="background:var(--bg2);border-radius:var(--radius);padding:.85rem 1rem;margin-bottom:1.25rem">
      <div style="font-size:.75rem;color:var(--text3);margin-bottom:2px">Course</div>
      <strong id="ratingModalCourseTitle" style="font-size:.95rem;color:var(--text)">-</strong>
      <div style="font-size:.75rem;color:var(--text3);margin-top:.4rem">Instruktur / Programmer</div>
      <span id="ratingModalInstructor" style="font-size:.875rem;color:var(--text2)">-</span>
    </div>

    <form id="courseRatingForm" method="POST">
      @csrf
      <!-- Star selector -->
      <div style="margin-bottom:1rem">
        <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:.6rem;color:var(--text)">Pilih Rating Bintang <span style="color:var(--red)">*</span></label>
        <div style="display:flex;gap:.5rem;align-items:center">
          @for($s=1;$s<=5;$s++)
          <label style="cursor:pointer;font-size:2rem;line-height:1" title="{{ $s }} Bintang">
            <input type="radio" name="rating" value="{{ $s }}" required style="display:none" onchange="updateModalStars({{ $s }})">
            <span class="modal-star modal-star-{{ $s }}" style="color:#D1D5DB;transition:color .15s">★</span>
          </label>
          @endfor
          <span id="modalRatingLabel" style="font-size:.85rem;color:var(--text3);margin-left:.5rem"></span>
        </div>
      </div>

      <!-- Comment -->
      <div style="margin-bottom:1.25rem">
        <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:.4rem;color:var(--text)">Ulasan / Komentar <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
        <textarea name="comment" id="ratingModalComment" placeholder="Ceritakan pengalaman belajar Anda di course ini..." style="width:100%;min-height:90px;padding:.75rem;border:1px solid var(--border);border-radius:var(--radius);font-size:.875rem;color:var(--text);background:var(--bg);resize:vertical;font-family:inherit;outline:none" maxlength="1000"></textarea>
        <div style="font-size:.72rem;color:var(--text3);margin-top:.25rem">Maksimal 1000 karakter</div>
      </div>

      <div style="display:flex;gap:.75rem">
        <button type="submit" id="submitCourseRatingBtn" class="btn btn-primary" style="flex:1;justify-content:center" disabled>Kirim Rating ⭐</button>
        <button type="button" onclick="closeCourseRatingModal()" class="btn btn-ghost">Lewati</button>
      </div>
    </form>
  </div>
</div>


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

@push('styles')
<style>
.video-list-item {
  padding: .85rem;
  border-radius: var(--radius);
  cursor: pointer;
  background: rgba(255,255,255,.02);
  border: 1px solid rgba(255,255,255,.05);
  transition: all .25s ease;
}
.video-list-item:hover {
  background: rgba(255,255,255,.06);
  border-color: rgba(255,255,255,.12);
  transform: translateY(-2px);
}
.video-list-item.active {
  background: linear-gradient(135deg, rgba(79,70,229,0.2), rgba(139,92,246,0.2)) !important;
  border-color: rgba(79,70,229,0.5) !important;
  box-shadow: 0 4px 15px rgba(79,70,229,0.15);
}
.video-index-badge {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: rgba(255,255,255,0.08);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 0.72rem;
  font-weight: 700;
  color: rgba(255,255,255,0.7);
  transition: all 0.25s ease;
  flex-shrink: 0;
}
.video-list-item.active .video-index-badge {
  background: var(--primary) !important;
  color: #fff !important;
  box-shadow: 0 2px 8px rgba(79,70,229,0.4);
}
</style>
@endpush

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
let countdownInterval;
function startCountdown() {
  if (countdownInterval) clearInterval(countdownInterval);
  let duration = 24 * 60 * 60 - 1; // 24 hours
  const timerEl = document.getElementById('invoiceTimer');
  if (!timerEl) return;
  
  const updateTimer = () => {
    let hours = Math.floor(duration / 3600);
    let minutes = Math.floor((duration % 3600) / 60);
    let seconds = duration % 60;
    
    hours = hours < 10 ? '0' + hours : hours;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;
    
    timerEl.textContent = `${hours}:${minutes}:${seconds}`;
    if (duration > 0) duration--;
  };
  updateTimer();
  countdownInterval = setInterval(updateTimer, 1000);
}

function selectPaymentMethod(method) {
  const labels = document.querySelectorAll('.payment-method-option');
  labels.forEach(label => {
    const radio = label.querySelector('input[type="radio"]');
    if (radio && radio.checked) {
      label.style.borderColor = 'var(--primary)';
      label.style.background = 'var(--primary-light)';
    } else {
      label.style.borderColor = 'var(--border)';
      label.style.background = 'transparent';
    }
  });
}

function goToInvoiceScreen() {
  const selectedMethodInput = document.querySelector('input[name="payment_method"]:checked');
  if (!selectedMethodInput) {
    alert("Silakan pilih metode pembayaran.");
    return;
  }
  const method = selectedMethodInput.value;
  
  const methodLabelMap = {
    qris: 'QRIS (E-Wallet & Mobile Banking)',
    bank_transfer: 'Bank Transfer (Virtual Account)',
    debit: 'Debit Card Payment',
    visa: 'Visa Credit/Debit Card',
    bri: 'Bank Rakyat Indonesia (BRIVA)',
    bni: 'Bank Negara Indonesia (BNI VA)',
    bjb: 'Bank Pembangunan Daerah BJB (BJB VA)'
  };
  
  document.getElementById('invoicePaymentMethod').textContent = methodLabelMap[method] || method.toUpperCase();
  document.getElementById('invoiceTotalText').textContent = document.getElementById('checkoutPriceText').textContent;
  
  const qrisContainer = document.getElementById('qrisContainer');
  const vaContainer = document.getElementById('vaContainer');
  
  if (method === 'qris') {
    qrisContainer.style.display = 'block';
    vaContainer.style.display = 'none';
    const amountStr = document.getElementById('checkoutPriceText').textContent;
    document.getElementById('qrisImage').src = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=BuilderHub-Simulated-QRIS-Amount-${encodeURIComponent(amountStr)}`;
  } else {
    qrisContainer.style.display = 'none';
    vaContainer.style.display = 'block';
    
    const vaNumbers = {
      bank_transfer: '88390812' + Math.floor(10000000 + Math.random() * 90000000),
      debit: '40001234' + Math.floor(10000000 + Math.random() * 90000000),
      visa: '45567890' + Math.floor(10000000 + Math.random() * 90000000),
      bri: '12345678' + Math.floor(10000000 + Math.random() * 90000000),
      bni: '98765432' + Math.floor(10000000 + Math.random() * 90000000),
      bjb: '33221100' + Math.floor(10000000 + Math.random() * 90000000)
    };
    
    document.getElementById('vaNumber').textContent = vaNumbers[method] || '8839081299999999';
  }
  
  document.getElementById('paymentSelectionScreen').style.display = 'none';
  document.getElementById('paymentInvoiceScreen').style.display = 'block';
  startCountdown();
}

function backToSelection() {
  document.getElementById('paymentSelectionScreen').style.display = 'block';
  document.getElementById('paymentInvoiceScreen').style.display = 'none';
  if (countdownInterval) clearInterval(countdownInterval);
}

function copyVaText() {
  const vaText = document.getElementById('vaNumber').textContent;
  navigator.clipboard.writeText(vaText).then(() => {
    alert("Nomor Virtual Account disalin ke clipboard!");
  }).catch(() => {
    alert("Gagal menyalin. Silakan salin secara manual.");
  });
}

function triggerEnroll(id, title, price, isFree, instructor){
  document.getElementById('checkoutCourseTitle').textContent = title;
  document.getElementById('checkoutInstructorName').textContent = instructor;
  document.getElementById('checkoutPriceText').textContent = isFree ? 'Gratis' : 'Rp ' + price.toLocaleString('id-ID');
  
  // Set forms action URL
  document.getElementById('enrollForm').action = `${window.APP_URL}/course-manager/course/${id}/enroll`;
  document.getElementById('freeEnrollForm').action = `${window.APP_URL}/course-manager/course/${id}/enroll`;
  
  if (isFree) {
    document.getElementById('paymentFormSection').style.display = 'none';
    document.getElementById('freeEnrollSection').style.display = 'block';
  } else {
    document.getElementById('paymentFormSection').style.display = 'block';
    document.getElementById('freeEnrollSection').style.display = 'none';
    
    // Reset screen state to selection
    document.getElementById('paymentSelectionScreen').style.display = 'block';
    document.getElementById('paymentInvoiceScreen').style.display = 'none';
    
    // Reset radios
    const firstRadio = document.querySelector('input[name="payment_method"]');
    if (firstRadio) {
      firstRadio.checked = true;
      selectPaymentMethod(firstRadio.value);
    }
  }
  
  document.getElementById('checkoutModal').style.display = 'flex';
}

function closeCheckoutModal(){
  document.getElementById('checkoutModal').style.display = 'none';
  if (countdownInterval) clearInterval(countdownInterval);
}

// Learning room logic
function openLearningRoom(id, title, videos, courseId, instructorId){
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.setProperty('display', 'none', 'important');

  document.getElementById('learnCourseTitle').textContent = title;
  document.getElementById('completeCourseForm').action = `${window.APP_URL}/course-manager/course/${courseId}/complete`;
  
  // Bind chat instructor button action
  document.getElementById('chatInstructorBtn').onclick = () => {
    window.location.href = `${window.APP_URL}/messages?contact_id=${instructorId}&course_id=${courseId}`;
  };
  
  const container = document.getElementById('videoListContainer');
  container.innerHTML = '';
  
  if(!videos || videos.length === 0){
    container.innerHTML = '<div style="color:rgba(255,255,255,.5);font-size:.8rem;text-align:center;padding:1rem">Materi video belum diunggah oleh Programmer.</div>';
    document.getElementById('videoIframe').src = '';
  } else {
    videos.forEach((vid, index) => {
      const item = document.createElement('div');
      item.className = 'video-list-item';
      item.onclick = () => selectVideo(vid.video_url, item);
      item.innerHTML = `
        <div style="display:flex;align-items:center;gap:10px">
          <span class="video-index-badge">${index + 1}</span>
          <div style="display:flex;flex-direction:column;gap:2px">
            <span style="font-size:.8rem;font-weight:700;color:#fff">${vid.title}</span>
            <span style="font-size:.7rem;color:rgba(255,255,255,.5);display:inline-flex;align-items:center;gap:4px">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:10px;height:10px;"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm4.3 14.3L11 13V7h1.5v5.2l4.5 2.7-.7 1.4z" fill="rgba(255,255,255,0.4)"/></svg>
              ${vid.duration || 'N/A'}
            </span>
          </div>
        </div>
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
    if(s.nodeType === 1) s.classList.remove('active');
  });
  element.classList.add('active');
  
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
  
  const mascot = document.getElementById('buddyMascot');
  if(mascot) mascot.style.removeProperty('display');
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
document.getElementById('courseRatingModal')?.addEventListener('click', e => {
  if(e.target === e.currentTarget) closeCourseRatingModal();
});

// ===== COURSE RATING MODAL =====
const ratingLabels = ['','Sangat Buruk 😞','Buruk 😕','Cukup 😐','Bagus 😊','Sangat Bagus 🤩'];

function openCourseRatingModal(courseId, courseTitle, instructor) {
  document.getElementById('ratingModalCourseTitle').textContent = courseTitle;
  document.getElementById('ratingModalInstructor').textContent = instructor;
  document.getElementById('courseRatingForm').action = `${window.APP_URL}/course-manager/course/${courseId}/rate`;
  // Reset form
  document.getElementById('courseRatingForm').reset();
  document.getElementById('ratingModalComment').value = '';
  document.getElementById('submitCourseRatingBtn').disabled = true;
  document.getElementById('modalRatingLabel').textContent = '';
  document.querySelectorAll('.modal-star').forEach(s => s.style.color = '#D1D5DB');
  document.getElementById('courseRatingModal').style.display = 'flex';
}

function closeCourseRatingModal() {
  document.getElementById('courseRatingModal').style.display = 'none';
}

function updateModalStars(rating) {
  document.querySelectorAll('.modal-star').forEach((star, i) => {
    star.style.color = i < rating ? '#F59E0B' : '#D1D5DB';
  });
  document.getElementById('modalRatingLabel').textContent = ratingLabels[rating] || '';
  document.getElementById('submitCourseRatingBtn').disabled = false;
}

// Auto-popup rating modal jika baru saja selesaikan course
@if(session('prompt_rating_course_id'))
window.addEventListener('load', () => {
  openCourseRatingModal(
    {{ session('prompt_rating_course_id') }},
    '{{ addslashes(session('prompt_rating_course_title', '')) }}',
    '{{ addslashes(session('prompt_rating_instructor', '')) }}'
  );
});
@endif

// Real-time Search & Filter for Student Courses
document.addEventListener('DOMContentLoaded', function() {
  // 1. My Courses Pane filtering
  const myCoursesSearch = document.getElementById('myCoursesSearch');
  const myCoursesLevelFilter = document.getElementById('myCoursesLevelFilter');
  const myCourseItems = document.querySelectorAll('.my-course-item');
  const myCoursesEmptySearch = document.getElementById('myCoursesEmptySearch');
  
  function filterMyCourses() {
    const query = myCoursesSearch ? myCoursesSearch.value.toLowerCase().trim() : '';
    const level = myCoursesLevelFilter ? myCoursesLevelFilter.value : '';
    let visibleCount = 0;
    
    myCourseItems.forEach(item => {
      const title = item.getAttribute('data-title') || '';
      const instructor = item.getAttribute('data-instructor') || '';
      const itemLevel = item.getAttribute('data-level') || '';
      
      const matchesQuery = !query || title.includes(query) || instructor.includes(query);
      const matchesLevel = !level || itemLevel === level;
      
      if (matchesQuery && matchesLevel) {
        item.style.setProperty('display', 'flex', 'important');
        visibleCount++;
      } else {
        item.style.setProperty('display', 'none', 'important');
      }
    });
    
    if (myCoursesEmptySearch) {
      myCoursesEmptySearch.style.display = (visibleCount === 0 && myCourseItems.length > 0) ? 'block' : 'none';
    }
  }
  
  if (myCoursesSearch) myCoursesSearch.addEventListener('input', filterMyCourses);
  if (myCoursesLevelFilter) myCoursesLevelFilter.addEventListener('change', filterMyCourses);

  // 2. Explore Courses Pane filtering
  const exploreSearch = document.getElementById('exploreSearch');
  const exploreLevelFilter = document.getElementById('exploreLevelFilter');
  const exploreCategoryFilter = document.getElementById('exploreCategoryFilter');
  const exploreCourseItems = document.querySelectorAll('.explore-course-item');
  const exploreEmptySearch = document.getElementById('exploreEmptySearch');
  
  function filterExploreCourses() {
    const query = exploreSearch ? exploreSearch.value.toLowerCase().trim() : '';
    const level = exploreLevelFilter ? exploreLevelFilter.value : '';
    const category = exploreCategoryFilter ? exploreCategoryFilter.value : '';
    let visibleCount = 0;
    
    exploreCourseItems.forEach(item => {
      const title = item.getAttribute('data-title') || '';
      const instructor = item.getAttribute('data-instructor') || '';
      const cat = item.getAttribute('data-category') || '';
      const itemLevel = item.getAttribute('data-level') || '';
      
      const matchesQuery = !query || title.includes(query) || instructor.includes(query) || cat.includes(query);
      const matchesLevel = !level || itemLevel === level;
      const matchesCategory = !category || cat === category;
      
      if (matchesQuery && matchesLevel && matchesCategory) {
        item.style.setProperty('display', 'flex', 'important');
        visibleCount++;
      } else {
        item.style.setProperty('display', 'none', 'important');
      }
    });
    
    if (exploreEmptySearch) {
      exploreEmptySearch.style.display = (visibleCount === 0 && exploreCourseItems.length > 0) ? 'block' : 'none';
    }
  }
  
  if (exploreSearch) exploreSearch.addEventListener('input', filterExploreCourses);
  if (exploreLevelFilter) exploreLevelFilter.addEventListener('change', filterExploreCourses);
  if (exploreCategoryFilter) exploreCategoryFilter.addEventListener('change', filterExploreCourses);
});
</script>
@endpush
@endsection
