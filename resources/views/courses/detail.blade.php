@extends('layouts.app')
@section('title', $course->title)
@section('content')
<div style="background:linear-gradient(135deg,#1E1260,#3D1FAF);padding:3rem 2rem;color:#fff">
  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:2fr 1fr;gap:3rem;align-items:start">
    <div>
      <div style="margin-bottom:.75rem">
        <span class="level-badge level-{{ $course->level }}" style="position:static;font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:99px">{{ $course->level_label }}</span>
        <span style="font-size:.8rem;color:rgba(255,255,255,.6);margin-left:.75rem">{{ $course->category }}</span>
      </div>
      <h1 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:.75rem;line-height:1.25">{{ $course->title }}</h1>
      <p style="color:rgba(255,255,255,.8);font-size:.95rem;line-height:1.7;margin-bottom:1.25rem">{{ $course->description }}</p>
      <div style="display:flex;align-items:center;gap:1.5rem;font-size:.85rem;color:rgba(255,255,255,.7)">
        <span>⭐ {{ $course->rating }} ({{ number_format($course->total_students) }} siswa)</span>
        <span>▶ {{ $course->total_videos }} video · {{ $course->duration }}</span>
      </div>
      <div style="display:flex;align-items:center;gap:8px;margin-top:1rem">
        <div style="width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff">{{ strtoupper(substr($course->instructor->name,0,1)) }}</div>
        <span style="color:rgba(255,255,255,.8);font-size:.875rem">Instruktur: <strong>{{ $course->instructor->name }}</strong></span>
        @if($course->instructor->is_verified)<span style="color:#34D399;font-size:.8rem">✓ Verified</span>@endif
      </div>
    </div>
    <!-- ENROLL CARD -->
    <div style="background:rgba(255,255,255,.1);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.15);border-radius:var(--radius-xl);padding:1.5rem;color:#fff;position:sticky;top:80px">
      <div style="font-size:2rem;font-weight:800;margin-bottom:.5rem;color:{{ $course->is_free ? '#34D399' : '#fff' }}">{{ $course->price_formatted }}</div>
      @if($isEnrolled)
        <div style="background:rgba(52,211,153,.2);border:1px solid rgba(52,211,153,.3);border-radius:var(--radius);padding:.75rem 1rem;font-size:.875rem;color:#34D399;margin-bottom:1rem;text-align:center">✅ Anda sudah terdaftar di kursus ini</div>
        <a href="#modul" class="btn btn-success btn-full" style="justify-content:center" aria-label="Lanjutkan belajar">▶ Lanjutkan Belajar</a>
      @else
        @auth
          @if(auth()->user()->role === 'umkm')
          <form method="POST" action="{{ route('umkm.course.enroll', $course) }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-full" style="justify-content:center;font-size:.95rem;padding:12px" aria-label="Daftar ke kursus {{ $course->title }}">
              {{ $course->is_free ? '🎓 Ikuti Gratis' : '🎓 Daftar Sekarang — ' . $course->price_formatted }}
            </button>
          </form>
          @else
          <a href="{{ route('courses.index') }}" class="btn btn-primary btn-full" style="justify-content:center">Jelajahi Course Lain</a>
          @endif
        @else
          <!-- IMK: Clear guidance for unauthenticated users -->
          <div style="background:rgba(255,255,255,.1);border-radius:var(--radius);padding:.75rem;margin-bottom:1rem;font-size:.82rem;color:rgba(255,255,255,.8);text-align:center">
            💡 Login sebagai UMKM atau Course Manager untuk mendaftar
          </div>
          <a href="{{ route('login') }}" class="btn btn-primary btn-full" style="justify-content:center;margin-bottom:.5rem" aria-label="Login untuk daftar kursus">Masuk & Daftar</a>
          <a href="{{ route('register') }}?role=umkm" class="btn btn-ghost btn-full" style="justify-content:center;color:#fff;border-color:rgba(255,255,255,.3)">Daftar Akun Dulu</a>
        @endauth
      @endif
      <div style="margin-top:1rem;font-size:.8rem;color:rgba(255,255,255,.6)">
        <div style="padding:.3rem 0">✅ {{ $course->total_videos }} video pembelajaran</div>
        <div style="padding:.3rem 0">⏱ Total durasi: {{ $course->duration }}</div>
        <div style="padding:.3rem 0">📱 Akses selamanya</div>
        <div style="padding:.3rem 0">🏅 Sertifikat kelulusan</div>
      </div>
    </div>
  </div>
</div>

<div style="max-width:1200px;margin:0 auto;padding:2rem;display:grid;grid-template-columns:2fr 1fr;gap:2rem">
  <!-- VIDEO MODULES -->
  <div id="modul">
    <h2 style="font-size:1.2rem;font-weight:700;margin-bottom:1rem">📋 Modul Pembelajaran ({{ $course->videos->count() }})</h2>
    @if($course->videos->count())
    <div style="border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:1.5rem">
      @foreach($course->videos as $video)
      <div style="padding:.7rem 1rem;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border);{{ !$loop->last ? '' : 'border-bottom:none' }};cursor:pointer;transition:.15s" onmouseover="this.style.background='var(--bg2)'" onmouseout="this.style.background=''" onclick="playVideo('{{ $video->video_url }}', '{{ addslashes($video->title) }}')" role="button" aria-label="Putar video {{ $video->title }}" tabindex="0">
        <div style="display:flex;align-items:center;gap:.5rem;color:var(--primary);font-weight:500;font-size:.875rem">
          <span style="font-size:1rem">▶</span> {{ $video->order }}. {{ $video->title }}
        </div>
        <span style="color:var(--text3);font-size:.78rem">{{ $video->duration }}</span>
      </div>
      @endforeach
    </div>
    <!-- Video Player -->
    <div id="videoPlayer" style="display:none;margin-bottom:1.5rem">
      <div style="font-size:.875rem;font-weight:700;margin-bottom:.5rem" id="videoTitle"></div>
      <div style="position:relative;padding-bottom:56.25%;height:0;border-radius:var(--radius-lg);overflow:hidden">
        <iframe id="videoIframe" src="" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;border:none" title="Video pembelajaran BuilderHub" aria-label="Video player kursus"></iframe>
      </div>
    </div>
    @else
    <div style="text-align:center;padding:2rem;color:var(--text3);border:1px dashed var(--border);border-radius:var(--radius)">Konten sedang disiapkan 📚</div>
    @endif

    <!-- IMK: About instructor section for trust building -->
    <h2 style="font-size:1.2rem;font-weight:700;margin-bottom:1rem">👤 Tentang Instruktur</h2>
    <div style="display:flex;gap:1rem;align-items:flex-start;padding:1.25rem;border:1px solid var(--border);border-radius:var(--radius-lg)">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:1.3rem;font-weight:800;color:#fff;flex-shrink:0">{{ strtoupper(substr($course->instructor->name,0,1)) }}</div>
      <div>
        <div style="font-size:1rem;font-weight:700">{{ $course->instructor->name }}</div>
        @if($course->instructor->is_verified)<span style="font-size:.75rem;font-weight:600;padding:2px 8px;border-radius:99px;background:#ECFDF5;color:#059669">✅ Terverifikasi</span>@endif
        @if($course->instructor->is_top_programmer)<span style="font-size:.75rem;font-weight:600;padding:2px 8px;border-radius:99px;background:#FFF7ED;color:#C2410C;margin-left:.25rem">🏆 Top Programmer</span>@endif
        <p style="font-size:.875rem;color:var(--text2);margin-top:.5rem;line-height:1.6">{{ $course->instructor->bio ?? 'Programmer profesional terverifikasi dengan pengalaman nyata di berbagai project UMKM Indonesia.' }}</p>
        <div style="font-size:.82rem;color:var(--text3);margin-top:.4rem">
          {{ $course->instructor->total_projects }} project selesai · ⭐ {{ number_format($course->instructor->rating ?: 5.0, 1) }} rating UMKM · 🎓 {{ number_format($course->instructor->course_rating ?: 5.0, 1) }} rating mengajar
        </div>
      </div>
    </div>
  </div>

  <!-- SIDEBAR -->
  <div>
    <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem">📚 Course Terkait</h3>
    @forelse($relatedCourses as $r)
    <a href="{{ route('courses.detail', $r) }}" style="display:flex;gap:.75rem;margin-bottom:.75rem;padding:.75rem;border:1px solid var(--border);border-radius:var(--radius);transition:.15s" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
      <div style="width:64px;height:52px;background:linear-gradient(135deg,#1E1260,#3D1FAF);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0">📚</div>
      <div>
        <div style="font-size:.85rem;font-weight:600;line-height:1.3">{{ Str::limit($r->title, 35) }}</div>
        <div style="font-size:.75rem;color:{{ $r->is_free ? 'var(--green)' : 'var(--text3)' }};margin-top:.25rem">{{ $r->price_formatted }}</div>
      </div>
    </a>
    @empty
    <p style="color:var(--text3);font-size:.875rem">Tidak ada course terkait.</p>
    @endforelse
  </div>
</div>

@push('scripts')
<script>
function playVideo(url, title){
  document.getElementById('videoTitle').textContent = '▶ ' + title;
  document.getElementById('videoIframe').src = url;
  document.getElementById('videoPlayer').style.display = 'block';
  // IMK: Smooth scroll to player
  document.getElementById('videoPlayer').scrollIntoView({behavior:'smooth', block:'start'});
}
</script>
@endpush
@endsection
