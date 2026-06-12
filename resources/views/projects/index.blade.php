@extends('layouts.app')
@section('title', 'Cari Project UMKM')
@section('content')
<div style="background:linear-gradient(135deg,#1E1260,#6C38FF);padding:3rem 2rem;color:#fff">
  <div style="max-width:1200px;margin:0 auto">
    <div class="section-badge" style="margin-bottom:.75rem">🔥 Project Terbaru</div>
    <h1 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:.5rem">Project UMKM yang Menunggu Programmer</h1>
    <p style="color:rgba(255,255,255,.7);max-width:500px">Ajukan penawaran terbaik Anda dan kerjakan project digital UMKM Indonesia</p>
  </div>
</div>
<section class="section">
  <div class="section-inner">
    <form method="GET" style="display:flex;gap:.75rem;margin-bottom:1rem;flex-wrap:wrap" role="search" aria-label="Filter project">
      <div style="position:relative;flex:1;max-width:400px">
        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text3)">🔍</span>
        <input name="search" class="form-input" style="padding-left:38px" placeholder="Cari project, skill, kategori..." value="{{ request('search') }}" aria-label="Cari project">
      </div>
      <select name="category" class="form-select" style="width:auto" aria-label="Filter kategori">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn btn-primary">Filter</button>
      @if(request()->hasAny(['search','category']))<a href="{{ route('projects') }}" class="btn btn-ghost">Reset</a>@endif
    </form>
    <p style="font-size:.82rem;color:var(--text3);margin-bottom:1rem">{{ $projects->total() }} project ditemukan</p>
    <div class="project-grid">
      @forelse($projects as $project)
      <div class="project-card">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.75rem">
          <div>
            <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;margin-bottom:.3rem">
              <span style="font-size:1rem;font-weight:700">&lt;/&gt; {{ $project->title }}</span>
              <span class="badge badge-open">Dibuka</span>
              @if($project->umkm->umkm_verified)<span class="badge badge-verified">✅ UMKM Verified</span>@endif
            </div>
            <div style="font-size:.8rem;color:var(--text3)">{{ $project->umkm->business_name ?? $project->umkm->name }} · {{ $project->umkm->name }}</div>
          </div>
          <div style="text-align:right;flex-shrink:0">
            @if($project->budget > 0)
              <div style="font-size:1.1rem;font-weight:800">Rp {{ number_format($project->budget, 0, ',', '.') }}</div>
              <div style="font-size:.82rem;font-weight:600;color:var(--green)">Dapat: Rp {{ number_format($project->budget * 0.20, 0, ',', '.') }} (20%)</div>
            @else
              <div style="font-size:1.0rem;font-weight:700;color:var(--accent)">Menunggu Estimasi</div>
              <div style="font-size:.82rem;color:var(--text3)">Harga ditentukan Programmer</div>
            @endif
          </div>
        </div>
        <p style="color:var(--text2);font-size:.875rem;margin-bottom:.75rem;line-height:1.6">{{ Str::limit($project->description, 130) }}</p>
        <div class="tag-list" style="margin-bottom:.75rem">@foreach(($project->tags ?? []) as $tag)<span class="tag">{{ $tag }}</span>@endforeach</div>
        <div style="display:flex;justify-content:space-between;align-items:center;color:var(--text3);font-size:.78rem;padding-top:.75rem;border-top:1px solid var(--border)">
          <span>🕐 {{ $project->deadline->format('d M Y') }}</span>
          <span>👥 {{ $project->bids->count() }} penawaran</span>
          <span>💳 Fee: {{ $project->budget > 0 ? 'Rp ' . number_format($project->budget * 0.80, 0, ',', '.') : 'Menunggu Estimasi' }}</span>
          @auth
            @if(auth()->user()->role === 'programmer')
              @if($project->bids->contains('programmer_id', auth()->id()))
                <button class="btn btn-sm" style="background:var(--orange-light);color:#92400E;border-color:rgba(245,158,11,.3);cursor:default;font-weight:600" disabled>Menunggu Persetujuan UMKM ⏳</button>
              @else
                <button onclick="window.location='{{ route('programmer.dashboard') }}#projects'" class="btn btn-primary btn-sm" aria-label="Ajukan penawaran untuk {{ $project->title }}">Ajukan →</button>
              @endif
            @else
              <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">Dashboard →</a>
            @endif
          @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm" aria-label="Login untuk ajukan penawaran">Login →</a>
          @endauth
        </div>
      </div>
      @empty
      <div style="text-align:center;padding:3rem;color:var(--text3)">
        <div style="font-size:2rem">📋</div>
        <div style="font-size:1rem;font-weight:600;margin-top:.75rem">Tidak ada project ditemukan</div>
      </div>
      @endforelse
    </div>
    <div style="margin-top:2rem">{{ $projects->links() }}</div>
  </div>
</section>
@endsection
