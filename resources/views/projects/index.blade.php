@extends('layouts.app')
@section('title', 'Tender & Proyek Tersedia – BuilderHub')
@section('content')

{{-- ===== HEADER BAR (matches image) ===== --}}
<div style="background:#fff;border-bottom:1px solid #E5E7EB;padding:1.25rem 2rem">
  <div style="max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:2rem;flex-wrap:wrap">

    {{-- Left: Title --}}
    <div>
      <h1 style="font-size:1.35rem;font-weight:800;color:#111827;margin:0 0 .15rem">
        Tender & Proyek <span style="color:#4F46E5">Tersedia</span>
      </h1>
      <p style="font-size:.8rem;color:#6B7280;margin:0">Temukan peluang proyek terbaik dan ajukan penawaran Anda.</p>
    </div>

    {{-- Right: Search bar (matches image 2 exactly) --}}
    <form method="GET" style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap" role="search">

      {{-- Search input — icon on RIGHT --}}
      <div style="position:relative">
        <input name="search" value="{{ request('search') }}"
          placeholder="Cari proyek, teknologi, atau kata kunci..."
          style="padding:8px 38px 8px 14px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#111827;font-size:.85rem;font-family:inherit;outline:none;min-width:260px;transition:border-color .15s;box-shadow:0 1px 3px rgba(0,0,0,.06)"
          onfocus="this.style.borderColor='#4F46E5'"
          onblur="this.style.borderColor='#E5E7EB'"
          aria-label="Cari project">
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

      {{-- Filter button --}}
      <button type="submit"
        style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:8px;border:none;background:#4F46E5;color:#fff;font-size:.875rem;font-weight:700;cursor:pointer;font-family:inherit;white-space:nowrap;box-shadow:0 1px 3px rgba(79,70,229,.3);transition:background .15s"
        onmouseover="this.style.background='#4338CA'"
        onmouseout="this.style.background='#4F46E5'">
        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v2.586a1 1 0 01-.293.707l-4.414 4.414A1 1 0 0012 11v6.586a1 1 0 01-.293.707l-2 2A1 1 0 018 19v-8a1 1 0 00-.293-.707L3.293 6.293A1 1 0 013 5.586V3z" clip-rule="evenodd"/></svg>
        Filter
      </button>

      @if(request()->hasAny(['search','category']))
        <a href="{{ route('projects') }}"
          style="padding:8px 12px;border-radius:8px;border:1px solid #E5E7EB;color:#6B7280;font-size:.82rem;font-weight:600;text-decoration:none;background:#fff;white-space:nowrap"
          onmouseover="this.style.color='#DC2626';this.style.borderColor='#DC2626'"
          onmouseout="this.style.color='#6B7280';this.style.borderColor='#E5E7EB'">✕</a>
      @endif
    </form>
  </div>
</div>

{{-- ===== PROJECT GRID ===== --}}
<section style="background:#F3F4F8;min-height:60vh;padding:1.5rem 2rem">
  <div style="max-width:1200px;margin:0 auto">
    <div style="font-size:.82rem;color:#6B7280;margin-bottom:1.25rem;font-weight:500">
      {{ $projects->total() }} project ditemukan
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:1.25rem">
      @forelse($projects as $project)
      @php
        $isOverdue = $project->deadline && now()->startOfDay()->gt($project->deadline->startOfDay());
        $categoryIcons = [
          'E-Commerce' => '🛒', 'Marketplace' => '🏪', 'Kuliner & Food Tech' => '🍜',
          'Business Tools' => '📊', 'Mobile App' => '📱', 'Landing Page' => '🌐',
          'Lainnya' => '💡', 'Full Stack' => '⚡', 'Frontend' => '🎨',
          'Backend' => '⚙️', 'Database' => '🗄️', 'Data Analytics' => '📈',
          'Healthcare' => '🏥', 'Education' => '📚', 'Finance' => '💰',
          'Data Scraping' => '🔗', 'Development' => '💻',
        ];
        $catIcon = $categoryIcons[$project->category] ?? '💼';
      @endphp

      <div style="background:#fff;border-radius:16px;border:1.5px solid {{ $isOverdue ? 'rgba(239,68,68,0.3)' : '#E5E7EB' }};box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden;display:flex;flex-direction:column;transition:box-shadow .2s,transform .2s" onmouseover="this.style.boxShadow='0 8px 30px rgba(0,0,0,.12)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 2px 12px rgba(0,0,0,.06)';this.style.transform='translateY(0)'">

        {{-- ── TOP STRIP: Category + Budget ── --}}
        <div style="padding:1rem 1.25rem .75rem;display:flex;justify-content:space-between;align-items:flex-start;gap:.5rem">
          <div style="display:flex;flex-direction:column;gap:.35rem">
            {{-- Category badge --}}
            <span style="display:inline-flex;align-items:center;gap:4px;font-size:.72rem;font-weight:700;color:#4F46E5;background:#EEF2FF;border-radius:6px;padding:3px 10px;letter-spacing:.3px;text-transform:uppercase">
              {{ $catIcon }} {{ $project->category ?? 'PROJECT' }}
            </span>
            {{-- Status badge --}}
            @if($isOverdue)
              <span style="display:inline-flex;align-items:center;gap:4px;font-size:.72rem;font-weight:700;color:#DC2626;background:#FEF2F2;border:1px solid rgba(239,68,68,.25);border-radius:6px;padding:3px 10px">⏰ DEADLINE TERLAMPAUI</span>
            @else
              <span style="display:inline-flex;align-items:center;gap:4px;font-size:.72rem;font-weight:700;color:#059669;background:#ECFDF5;border:1px solid rgba(16,185,129,.25);border-radius:6px;padding:3px 10px">✅ DIBUKA</span>
            @endif
          </div>
          {{-- Budget --}}
          <div style="text-align:right;flex-shrink:0">
            @if($project->budget > 0)
              <div style="font-size:1.15rem;font-weight:800;color:#111827;line-height:1.1">Rp {{ number_format($project->budget, 0, ',', '.') }}</div>
              <div style="font-size:.75rem;font-weight:600;color:#059669;margin-top:2px">Dapat: Rp {{ number_format($project->budget * 0.20, 0, ',', '.') }} (20%)</div>
            @else
              <div style="font-size:.95rem;font-weight:700;color:#7C3AED;line-height:1.2">Menunggu<br>Estimasi</div>
            @endif
          </div>
        </div>

        {{-- ── TITLE + UMKM INFO ── --}}
        <div style="padding:0 1.25rem .75rem">
          <h3 style="font-size:1rem;font-weight:800;color:#111827;margin-bottom:.35rem;line-height:1.4">
            &lt;/&gt; {{ $project->title }}
          </h3>
          @if($project->umkm->umkm_verified)
          <div style="display:inline-flex;align-items:center;gap:4px;font-size:.72rem;font-weight:700;color:#059669;background:#ECFDF5;border:1px solid rgba(16,185,129,.2);border-radius:4px;padding:2px 8px;margin-bottom:.35rem">
            ✅ UMKM VERIFIED
          </div>
          @endif
          <div style="font-size:.78rem;color:#9CA3AF;font-weight:500">
            {{ $project->umkm->business_name ?? $project->umkm->name }} · {{ $project->umkm->name }}
          </div>
        </div>

        {{-- ── DESCRIPTION ── --}}
        <div style="padding:0 1.25rem .85rem;font-size:.85rem;color:#374151;line-height:1.65;flex:1">
          @if(strlen($project->description) > 140)
            <span class="desc-short">{{ Str::limit($project->description, 140) }}</span>
            <span class="desc-full" style="display:none">{{ $project->description }}</span>
            <button type="button" onclick="toggleDesc(this)" style="background:none;border:none;color:#4F46E5;font-size:.8rem;font-weight:700;cursor:pointer;padding:0;margin-left:4px;display:inline;font-family:inherit">Selengkapnya</button>
          @else
            {{ $project->description }}
          @endif
        </div>

        {{-- ── TAGS ── --}}
        <div style="padding:0 1.25rem .85rem;display:flex;flex-wrap:wrap;gap:.35rem">
          @foreach(($project->tags ?? []) as $tag)
          <span style="font-size:.75rem;font-weight:600;color:#4F46E5;background:#EEF2FF;border-radius:6px;padding:3px 10px">{{ $tag }}</span>
          @endforeach
        </div>

        {{-- ── FOOTER STATS ── --}}
        <div style="padding:.75rem 1.25rem;border-top:1px solid #F3F4F6;display:flex;align-items:center;gap:1rem;font-size:.76rem;color:#9CA3AF;flex-wrap:wrap">
          <span style="display:flex;align-items:center;gap:4px;color:{{ $isOverdue ? '#DC2626' : '#6B7280' }};font-weight:{{ $isOverdue ? '700' : '400' }}">
            🕐 {{ $project->deadline->format('d M Y') }}
          </span>
          <span style="display:flex;align-items:center;gap:4px">
            👥 {{ $project->bids->count() }} penawaran
          </span>
           <span style="display:flex;align-items:center;gap:4px">
            💳 Fee: {{ $project->budget > 0 ? 'Rp ' . number_format($project->budget * 0.80, 0, ',', '.') : 'Menunggu Estimasi' }}
          </span>
        </div>

        {{-- ── ACTION BUTTON ── --}}
        <div style="padding:.75rem 1.25rem 1.25rem">
          @auth
            @if(auth()->user()->role === 'programmer')
              @if($isOverdue)
                <button disabled style="width:100%;padding:11px;border-radius:10px;border:none;background:#FEF2F2;color:#DC2626;font-weight:700;font-size:.875rem;cursor:not-allowed;display:flex;align-items:center;justify-content:center;gap:6px;font-family:inherit">
                  ⛔ Deadline Terlampaui
                </button>
              @elseif($project->bids->contains('programmer_id', auth()->id()))
                <button disabled style="width:100%;padding:11px;border-radius:10px;border:none;background:#FFFBEB;color:#92400E;font-weight:700;font-size:.875rem;cursor:not-allowed;display:flex;align-items:center;justify-content:center;gap:6px;font-family:inherit">
                  ⏳ Menunggu Persetujuan UMKM
                </button>
              @else
                <button onclick="window.location='{{ route('programmer.dashboard') }}#projects'" style="width:100%;padding:11px;border-radius:10px;border:none;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;font-weight:700;font-size:.875rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;font-family:inherit;transition:opacity .2s" onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                  Ajukan Penawaran →
                </button>
              @endif
            @else
              <a href="{{ route('dashboard') }}" style="width:100%;padding:11px;border-radius:10px;border:none;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;font-weight:700;font-size:.875rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;text-decoration:none;transition:opacity .2s">
                Dashboard →
              </a>
            @endif
          @else
            <a href="{{ route('login') }}" style="width:100%;padding:11px;border-radius:10px;border:none;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;font-weight:700;font-size:.875rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;text-decoration:none;transition:opacity .2s" onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
              🔐 Login untuk Ajukan →
            </a>
          @endauth
        </div>
      </div>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:5rem 2rem;background:#fff;border-radius:16px">
        <div style="font-size:3rem;margin-bottom:1rem">📋</div>
        <div style="font-size:1.1rem;font-weight:700;color:#374151">Tidak ada project ditemukan</div>
        <div style="font-size:.875rem;color:#9CA3AF;margin-top:.35rem">Coba ubah filter atau kata kunci pencarian Anda.</div>
      </div>
      @endforelse
    </div>

    {{-- Pagination --}}
    <div style="margin-top:2.5rem">{{ $projects->links() }}</div>
  </div>
</section>

@push('scripts')
<script>
function toggleDesc(btn) {
  const card = btn.closest('div');
  const short = card.querySelector('.desc-short');
  const full = card.querySelector('.desc-full');
  if (full.style.display === 'none') {
    short.style.display = 'none';
    full.style.display = 'inline';
    btn.textContent = 'Lebih sedikit';
  } else {
    short.style.display = 'inline';
    full.style.display = 'none';
    btn.textContent = 'Selengkapnya';
  }
}
</script>
@endpush
@endsection
