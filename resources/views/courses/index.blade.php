@extends('layouts.app')
@section('title', 'Jelajah Course – BuilderHub')
@section('content')

{{-- ===== HEADER BAR (matches image & projects/index exactly) ===== --}}
<div style="background:#fff;border-bottom:1px solid #E5E7EB;padding:1.25rem 2rem">
  <div style="max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:2rem;flex-wrap:wrap">

    {{-- Left: Title --}}
    <div>
      <h1 style="font-size:1.35rem;font-weight:800;color:#111827;margin:0 0 .15rem">
        Jelajah Kelas & <span style="color:#4F46E5">Course</span>
      </h1>
      <p style="font-size:.8rem;color:#6B7280;margin:0">Tingkatkan skill digital Anda dengan belajar dari programmer expert.</p>
    </div>

    {{-- Right: Search bar (matches image 2 exactly) --}}
    <form method="GET" style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap" role="search" aria-label="Pencarian kursus">

      {{-- Search input — icon on RIGHT --}}
      <div style="position:relative">
        <input name="search" value="{{ request('search') }}"
          placeholder="Cari nama course, skill..."
          style="padding:8px 38px 8px 14px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#111827;font-size:.85rem;font-family:inherit;outline:none;min-width:240px;transition:border-color .15s;box-shadow:0 1px 3px rgba(0,0,0,.06)"
          onfocus="this.style.borderColor='#4F46E5'"
          onblur="this.style.borderColor='#E5E7EB'"
          aria-label="Cari course">
        {{-- 🔍 icon on RIGHT inside input --}}
        <span style="position:absolute;right:11px;top:50%;transform:translateY(-50%);color:#9CA3AF;font-size:.85rem;pointer-events:none">🔍</span>
      </div>

      {{-- Category dropdown — grid icon on LEFT --}}
      <div style="position:relative;display:flex;align-items:center">
        {{-- Grid icon --}}
        <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);pointer-events:none;z-index:1">
          <svg width="14" height="14" viewBox="0 0 16 16" fill="none" style="display:block">
            <rect x="1" y="1" width="5" height="5" rx="1" fill="#6B7280"/>
            <rect x="10" y="1" width="5" height="5" rx="1" fill="#6B7280"/>
            <rect x="1" y="10" width="5" height="5" rx="1" fill="#6B7280"/>
            <rect x="10" y="10" width="5" height="5" rx="1" fill="#6B7280"/>
          </svg>
        </span>
        <select name="category"
          style="padding:8px 30px 8px 30px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#374151;font-size:.85rem;font-family:inherit;cursor:pointer;outline:none;appearance:none;min-width:160px;box-shadow:0 1px 3px rgba(0,0,0,.06);transition:border-color .15s"
          onfocus="this.style.borderColor='#4F46E5'"
          onblur="this.style.borderColor='#E5E7EB'"
          aria-label="Filter kategori">
          <option value="">Semua Kategori</option>
          @foreach($categories as $cat)
          <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
          @endforeach
        </select>
        {{-- Chevron on right --}}
        <span style="position:absolute;right:10px;top:50%;transform:translateY(-50%);pointer-events:none;color:#6B7280;font-size:.7rem">▼</span>
      </div>

      {{-- Level dropdown --}}
      <div style="position:relative;display:flex;align-items:center">
        <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);pointer-events:none;z-index:1;font-size:.95rem">
          ⚡
        </span>
        <select name="level"
          style="padding:8px 30px 8px 28px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#374151;font-size:.85rem;font-family:inherit;cursor:pointer;outline:none;appearance:none;min-width:140px;box-shadow:0 1px 3px rgba(0,0,0,.06);transition:border-color .15s"
          onfocus="this.style.borderColor='#4F46E5'"
          onblur="this.style.borderColor='#E5E7EB'"
          aria-label="Filter level">
          <option value="">Semua Level</option>
          <option value="pemula" {{ request('level') === 'pemula' ? 'selected' : '' }}>Pemula</option>
          <option value="menengah" {{ request('level') === 'menengah' ? 'selected' : '' }}>Menengah</option>
          <option value="mahir" {{ request('level') === 'mahir' ? 'selected' : '' }}>Mahir</option>
        </select>
        <span style="position:absolute;right:10px;top:50%;transform:translateY(-50%);pointer-events:none;color:#6B7280;font-size:.7rem">▼</span>
      </div>

      {{-- Filter button --}}
      <button type="submit"
        style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:8px;border:none;background:#4F46E5;color:#fff;font-size:.875rem;font-weight:700;cursor:pointer;font-family:inherit;white-space:nowrap;box-shadow:0 1px 3px rgba(79,70,229,.3);transition:background .15s"
        onmouseover="this.style.background='#4338CA'"
        onmouseout="this.style.background='#4F46E5'">
        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v2.586a1 1 0 01-.293.707l-4.414 4.414A1 1 0 0012 11v6.586a1 1 0 01-.293.707l-2 2A1 1 0 018 19v-8a1 1 0 00-.293-.707L3.293 6.293A1 1 0 013 5.586V3z" clip-rule="evenodd"/></svg>
        Cari & Filter
      </button>

      @if(request()->hasAny(['search','category','level']))
        <a href="{{ route('courses.index') }}"
          style="padding:8px 12px;border-radius:8px;border:1px solid #E5E7EB;color:#6B7280;font-size:.82rem;font-weight:600;text-decoration:none;background:#fff;white-space:nowrap"
          onmouseover="this.style.color='#DC2626';this.style.borderColor='#DC2626'"
          onmouseout="this.style.color='#6B7280';this.style.borderColor='#E5E7EB'">✕ Reset</a>
      @endif
    </form>
  </div>
</div>

{{-- ===== COURSE LIST SECTION ===== --}}
<section style="background:#F3F4F8;min-height:65vh;padding:1.5rem 2rem">
  <div style="max-width:1200px;margin:0 auto">
    <div style="font-size:.82rem;color:#6B7280;margin-bottom:1.25rem;font-weight:500">
      {{ $courses->total() }} course ditemukan
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(340px, 1fr));gap:1.5rem">
      @forelse($courses as $course)
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
                $logoHtml = '<span style="font-family: Arial Black, sans-serif; font-size: 2.25rem; font-weight: 900; color: #323330; display:block; line-height:1">JS</span>';
            } elseif ($preset === 'php') {
                $gradient = 'linear-gradient(135deg, #4F5D95, #777BB4)';
                $logoHtml = '<span style="font-family: Impact, sans-serif; font-size: 2rem; font-style: italic; color: #fff; text-shadow: 1px 1px 3px rgba(0,0,0,0.3); display:block; line-height:1">php</span>';
            } elseif ($preset === 'mysql') {
                $gradient = 'linear-gradient(135deg, #00758F, #005E74)';
                $logoHtml = '<span style="font-family: Inter, sans-serif; font-size: 1.5rem; font-weight: 800; color: #fff; letter-spacing: -1px; display:block; line-height:1">MySQL</span>';
            } elseif ($preset === 'laravel') {
                $gradient = 'linear-gradient(135deg, #FF2E2E, #E31B1B)';
                $logoHtml = '<svg width="46" height="46" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>';
            } elseif ($preset === 'react') {
                $gradient = 'linear-gradient(135deg, #20232A, #282C34)';
                $logoHtml = '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#61DAFB" stroke-width="2" style="display:block"><ellipse cx="12" cy="12" rx="10" ry="4.5" transform="rotate(0 12 12)"/><ellipse cx="12" cy="12" rx="10" ry="4.5" transform="rotate(60 12 12)"/><ellipse cx="12" cy="12" rx="10" ry="4.5" transform="rotate(120 12 12)"/><circle cx="12" cy="12" r="2" fill="#61DAFB"/></svg>';
            } elseif ($preset === 'node') {
                $gradient = 'linear-gradient(135deg, #303030, #43853D)';
                $logoHtml = '<span style="font-family: Arial, sans-serif; font-size: 1.65rem; font-weight: 800; color: #fff; display:block; line-height:1">node</span>';
            } elseif ($preset === 'flutter') {
                $gradient = 'linear-gradient(135deg, #02569B, #0175C2)';
                $logoHtml = '<svg width="42" height="42" viewBox="0 0 24 24" fill="#fff" style="display:block"><path d="M14.314 0L2.3 12 6 15.7 21.684 0h-7.37zM21.684 12.329l-3.685-3.686L6 20.329l3.7 3.671 11.984-11.671z"/></svg>';
            } elseif ($preset === 'git') {
                $gradient = 'linear-gradient(135deg, #F1502F, #F05133)';
                $logoHtml = '<span style="font-family: Arial, sans-serif; font-size: 2.1rem; font-weight: 800; color: #fff; display:block; line-height:1">git</span>';
            }
        } elseif ($course->thumbnail) {
            $hasCustomThumb = true;
            $thumbUrl = str_starts_with($course->thumbnail, 'http') ? $course->thumbnail : asset('storage/' . $course->thumbnail);
        }
      @endphp
      
      <article style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.05);border:1px solid #E5E7EB;display:flex;flex-direction:column;transition:transform .2s, box-shadow .2s"
        onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 20px rgba(0,0,0,.08)'"
        onmouseout="this.style.transform='none';this.style.boxShadow='0 1px 3px rgba(0,0,0,.05)'">
        
        {{-- Thumbnail Area --}}
        <div style="height:150px;background:{!! $hasCustomThumb ? 'transparent' : $gradient !!};position:relative;display:flex;align-items:center;justify-content:center;box-shadow:inset 0 0 20px rgba(0,0,0,0.1);overflow:hidden">
          @if($hasCustomThumb)
            <img src="{{ $thumbUrl }}" alt="{{ $course->title }}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit">
          @else
            {!! $logoHtml !!}
          @endif
          
          {{-- Level badge --}}
          @php
            $lvlBg = '#ECFDF5'; $lvlColor = '#059669';
            if($course->level === 'menengah') { $lvlBg = '#FFF7ED'; $lvlColor = '#C2410C'; }
            elseif($course->level === 'mahir') { $lvlBg = '#FEF2F2'; $lvlColor = '#DC2626'; }
          @endphp
          <span style="position:absolute;bottom:12px;left:12px;font-size:.68rem;font-weight:800;padding:3px 10px;border-radius:99px;background:{{ $lvlBg }};color:{{ $lvlColor }};text-transform:uppercase;letter-spacing:0.5px;box-shadow:0 2px 4px rgba(0,0,0,0.05)">
            {{ $course->level_label }}
          </span>
          
          {{-- Category badge --}}
          <span style="position:absolute;top:12px;left:12px;font-size:.68rem;font-weight:700;padding:3px 10px;border-radius:99px;background:rgba(255,255,255,0.9);color:#374151;box-shadow:0 2px 4px rgba(0,0,0,0.05)">
            {{ $course->category }}
          </span>
        </div>

        {{-- Content Area --}}
        <div style="padding:1.25rem;flex:1;display:flex;flex-direction:column;justify-content:space-between">
          <div>
            <h3 style="font-size:1.05rem;font-weight:800;color:#111827;margin:0 0 .5rem;line-height:1.4">
              {{ $course->title }}
            </h3>
            <p style="font-size:.82rem;color:#6B7280;margin:0 0 1rem;line-height:1.5">
              {{ Str::limit($course->description, 100) }}
            </p>
          </div>

          <div>
            {{-- Instructor Row --}}
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:.75rem">
              <div style="width:26px;height:26px;border-radius:50%;background:#EEF2FF;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:800;color:#4F46E5;border:1.5px solid #E5E7EB">
                {{ strtoupper(substr($course->instructor->name,0,1)) }}
              </div>
              <span style="font-size:.8rem;color:#4B5563;font-weight:600">{{ $course->instructor->name }}</span>
              @if($course->instructor->is_verified)
                <span style="color:#059669;font-size:.8rem;font-weight:bold" title="Verified Instructor">✓</span>
              @endif
            </div>

            {{-- Metadata Row --}}
            <div style="display:flex;align-items:center;gap:.5rem;font-size:.76rem;color:#9CA3AF">
              <span style="color:#F59E0B;font-weight:700;display:inline-flex;align-items:center;gap:3px">
                ⭐ {{ number_format($course->rating ?: 0.0, 1) }}
              </span>
              <span>•</span>
              <span>{{ number_format($course->enrollments->count()) }} siswa</span>
              <span>•</span>
              <span>{{ $course->total_videos }} video</span>
            </div>
          </div>
        </div>

        {{-- Footer Area --}}
        <div style="padding:1rem 1.25rem;border-top:1px solid #F3F4F6;display:flex;justify-content:space-between;align-items:center;background:#FCFDFD">
          <span style="font-size:1.15rem;font-weight:900;color:#4F46E5">
            {{ $course->price_formatted }}
          </span>
          <a href="{{ route('courses.detail', $course) }}"
            style="display:inline-flex;align-items:center;gap:4px;padding:8px 16px;border-radius:8px;background:#4F46E5;color:#fff;font-size:.82rem;font-weight:700;text-decoration:none;transition:background .15s;box-shadow:0 1px 3px rgba(79,70,229,.2)"
            onmouseover="this.style.background='#4338CA'"
            onmouseout="this.style.background='#4F46E5'"
            aria-label="Lihat detail kursus {{ $course->title }}">
            Lihat Kelas
          </a>
        </div>
      </article>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:4rem 2rem;background:#fff;border-radius:16px;border:1px solid #E5E7EB">
        <div style="font-size:3rem;margin-bottom:1rem">📚</div>
        <h3 style="font-size:1.15rem;font-weight:800;color:#374151;margin-bottom:.35rem">Tidak ada course ditemukan</h3>
        <p style="font-size:.85rem;color:#9CA3AF">Coba kata kunci lain atau hapus filter pencarian.</p>
      </div>
      @endforelse
    </div>

    {{-- Symmetrical pagination row --}}
    <div style="margin-top:2.5rem;display:flex;justify-content:center">
      {{ $courses->links('partials.pagination') }}
    </div>
  </div>
</section>
@endsection
