@extends('layouts.app')
@section('title', 'Semua Course')
@section('content')
<div style="background:linear-gradient(135deg,#1E1260,#3D1FAF);padding:3rem 2rem;text-align:center;color:#fff">
  <div class="section-badge" style="margin-bottom:.75rem">📚 Semua Kursus</div>
  <h1 style="font-size:2.2rem;font-weight:800;color:#fff;margin-bottom:.75rem">Belajar dari Programmer Expert</h1>
  <p style="color:rgba(255,255,255,.7);max-width:500px;margin:0 auto">Instruktur kami adalah programmer nyata yang telah mengerjakan puluhan project UMKM</p>
</div>
<section class="section">
  <div class="section-inner">
    <form method="GET" style="display:flex;gap:.75rem;margin-bottom:1.5rem;flex-wrap:wrap" role="search" aria-label="Pencarian kursus">
      <div style="position:relative;flex:1;max-width:400px">
        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text3)">🔍</span>
        <input name="search" class="form-input" style="padding-left:38px" placeholder="Cari course..." value="{{ request('search') }}" aria-label="Cari kursus">
      </div>
      <select name="level" class="form-select" style="width:auto" aria-label="Filter level kursus">
        <option value="">Semua Level</option>
        <option value="pemula" {{ request('level') === 'pemula' ? 'selected' : '' }}>Pemula</option>
        <option value="menengah" {{ request('level') === 'menengah' ? 'selected' : '' }}>Menengah</option>
        <option value="mahir" {{ request('level') === 'mahir' ? 'selected' : '' }}>Mahir</option>
      </select>
      <button type="submit" class="btn btn-primary" aria-label="Terapkan filter">Filter</button>
      @if(request()->hasAny(['search','level']))<a href="{{ route('courses.index') }}" class="btn btn-ghost" aria-label="Reset filter">Reset</a>@endif
    </form>
    <p style="font-size:.82rem;color:var(--text3);margin-bottom:1rem">{{ $courses->total() }} kursus ditemukan</p>
    <div class="course-grid">
      @forelse($courses as $course)
      <article class="course-card">
        <div class="course-thumb" style="background:linear-gradient(135deg,{{ ['#1E1260,#6C38FF','#0F4C75,#1B262C','#7C3626,#D44000','#1A1A2E,#4A2080'][$loop->index % 4] }})">
          <span style="font-size:2.5rem">{{ ['⚛','🔌','🚀','📱','🐍','☁️','🎨','⚡'][$loop->index % 8] }}</span>
          <span class="level-badge level-{{ $course->level }}">{{ $course->level_label }}</span>
          @if($course->is_free)<span style="position:absolute;top:10px;right:10px;background:rgba(0,0,0,.5);color:#fff;padding:3px 9px;border-radius:99px;font-size:.7rem;font-weight:700">Gratis</span>@endif
        </div>
        <div style="padding:1rem;flex:1">
          <h3 style="font-size:.95rem;font-weight:700;margin-bottom:.4rem;line-height:1.4">{{ $course->title }}</h3>
          <p style="font-size:.8rem;color:var(--text2);margin-bottom:.75rem;line-height:1.5">{{ Str::limit($course->description, 80) }}</p>
          <div style="display:flex;align-items:center;gap:6px;margin-bottom:.5rem">
            <div style="width:22px;height:22px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:#fff">{{ strtoupper(substr($course->instructor->name,0,1)) }}</div>
            <span style="font-size:.78rem;color:var(--text2)">{{ $course->instructor->name }}</span>
            @if($course->instructor->is_verified)<span style="color:var(--green);font-size:.75rem">✓</span>@endif
          </div>
          <div style="font-size:.78rem;color:var(--text3)">⭐ {{ $course->rating }} · {{ number_format($course->total_students) }} siswa · {{ $course->total_videos }} video</div>
        </div>
        <div style="padding:.75rem 1rem;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
          <span style="font-size:1rem;font-weight:800;color:{{ $course->is_free ? 'var(--green)' : 'var(--text)' }}">{{ $course->price_formatted }}</span>
          <a href="{{ route('courses.detail', $course) }}" class="btn btn-primary btn-sm" aria-label="Lihat kursus {{ $course->title }}">Lihat Kursus</a>
        </div>
      </article>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text3)">
        <div style="font-size:2rem;margin-bottom:.75rem">📚</div>
        <div style="font-size:1rem;font-weight:600">Tidak ada course ditemukan</div>
        <p style="font-size:.875rem;margin-top:.5rem">Coba kata kunci lain atau hapus filter</p>
      </div>
      @endforelse
    </div>
    <div style="margin-top:2rem">{{ $courses->links() }}</div>
  </div>
</section>
@endsection
