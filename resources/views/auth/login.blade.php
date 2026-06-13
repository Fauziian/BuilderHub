@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div style="min-height:calc(100vh - 64px);display:grid;grid-template-columns:1fr 1fr">
  <!-- LEFT PANEL (IMK: Visual branding & benefit summary) -->
  <div style="background:linear-gradient(135deg,#1E1260 0%,#3D1FAF 100%);padding:3rem;display:flex;flex-direction:column;justify-content:center">
    <div style="display:flex;align-items:center;gap:10px;font-weight:800;font-size:1.1rem;color:#fff;margin-bottom:2rem">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 160" class="nav-logo-icon" aria-hidden="true" style="fill: none; width: 44px; height: 35px;">
        <defs>
          <linearGradient id="logo-grad-login" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="var(--primary)" />
            <stop offset="100%" stop-color="#8B5CF6" />
          </linearGradient>
        </defs>
        <path d="M 93 12 A 10 10 0 0 1 107 12 L 182 72 A 10 10 0 0 1 185 80 L 185 140 A 10 10 0 0 1 175 150 L 25 150 A 10 10 0 0 1 15 140 L 15 80 A 10 10 0 0 1 18 72 Z" fill="url(#logo-grad-login)" />
        <path d="M 85 45 L 75 51 L 85 57 M 115 45 L 125 51 L 115 57 M 105 40 L 95 62" stroke="#ffffff" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
        <path d="M 80 150 V 120 L 100 102 L 120 120 V 150 Z" fill="#ffffff" />
        <rect x="93" y="122" width="5" height="5" fill="url(#logo-grad-login)" rx="1.5" />
        <rect x="102" y="122" width="5" height="5" fill="url(#logo-grad-login)" rx="1.5" />
        <rect x="93" y="131" width="5" height="5" fill="url(#logo-grad-login)" rx="1.5" />
        <rect x="102" y="131" width="5" height="5" fill="url(#logo-grad-login)" rx="1.5" />
        <circle cx="50" cy="98" r="9.5" fill="#ffffff" />
        <path d="M 24 150 V 134 C 24 125 30 118 38 118 C 42 118 45 122 46 126 L 47 132 H 58 A 1 1 0 0 1 59 133 L 64 124 A 1 1 0 0 1 65.8 125 L 61 135 A 2 2 0 0 1 59 136.5 H 46.5 C 45 136.5 44 142 44 150 Z" fill="#ffffff" />
        <circle cx="150" cy="98" r="9.5" fill="#ffffff" />
        <path d="M 136 84 L 150 79 L 164 84 L 150 89 Z" fill="#ffffff" />
        <path d="M 144 86.5 V 90 C 144 92 156 92 156 90 V 86.5" fill="#ffffff" />
        <path d="M 158 84 L 162 90" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" fill="none" />
        <path d="M 176 150 V 134 C 176 125 170 118 162 118 C 158 118 155 122 154 126 L 153 132 H 144 L 140 126 A 1 1 0 0 0 138.2 127 L 141 135 A 2 2 0 0 0 143 136.5 H 153.5 C 155 136.5 156 142 156 150 Z" fill="#ffffff" />
        <path d="M 135 128 L 126 130 L 128 136 L 135 133 Z" fill="#ffffff" opacity="0.9" />
        <path d="M 135 128 L 142 126 L 144 132 L 135 133 Z" fill="#ffffff" opacity="0.9" />
      </svg> BuilderHub
    </div>
    <h2 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:.75rem">Selamat Datang Kembali!</h2>
    <p style="color:rgba(255,255,255,.7);font-size:.95rem;line-height:1.7;margin-bottom:2rem">
      Platform penghubung UMKM dan programmer profesional Indonesia. Wujudkan bisnis digital Anda.
    </p>
    <ul style="list-style:none;display:flex;flex-direction:column;gap:.75rem">
      @foreach(['Programmer terverifikasi & berportofolio nyata','Komisi 20% langsung ke programmer','Sistem pembayaran aman & transparan','Course dari programmer expert'] as $item)
      <li style="display:flex;align-items:center;gap:.75rem;color:rgba(255,255,255,.85);font-size:.9rem">
        <span style="width:20px;height:20px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;flex-shrink:0">✓</span>
        {{ $item }}
      </li>
      @endforeach
    </ul>
  </div>

  <!-- RIGHT PANEL (IMK: Clean form with clear labels & feedback) -->
  <div style="background:var(--bg);display:flex;align-items:center;justify-content:center;padding:3rem 4rem">
    <div style="width:100%;max-width:420px">
      <a href="{{ route('home') }}" style="font-size:.85rem;color:var(--text2);display:flex;align-items:center;gap:4px;margin-bottom:1.5rem;transition:.15s" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text2)'">← Kembali ke Beranda</a>

      <h1 style="font-size:1.6rem;font-weight:800;margin-bottom:.25rem">Masuk ke Akun</h1>
      <p style="font-size:.9rem;color:var(--text2);margin-bottom:1.5rem">Masukkan email dan password Anda</p>

      <!-- IMK: Tab toggle for Login/Register navigation clarity -->
      <div style="display:grid;grid-template-columns:1fr 1fr;border:1px solid var(--border);border-radius:var(--radius-sm);margin-bottom:1.5rem;overflow:hidden">
        <div style="padding:10px;text-align:center;font-size:.875rem;font-weight:600;background:var(--primary);color:#fff">Masuk</div>
        <a href="{{ route('register') }}" style="padding:10px;text-align:center;font-size:.875rem;font-weight:500;color:var(--text2);display:block">Daftar</a>
      </div>

      @if($errors->any())
      <div class="alert alert-error" role="alert">
        ❌ {{ $errors->first() }}
      </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}" novalidate aria-label="Form login BuilderHub">
        @csrf
        <!-- IMK: Label + input pair, always visible labels (not placeholder-only) -->
        <div class="form-group">
          <label for="email" class="form-label">Email <span class="required">*</span></label>
          <input type="email" id="email" name="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}"
            placeholder="nama@email.com" value="{{ old('email') }}" autocomplete="email"
            aria-required="true" aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}">
          @error('email')<div id="email-error" class="field-error" role="alert">⚠ {{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Password <span class="required">*</span></label>
          <div style="position:relative">
            <input type="password" id="password" name="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}"
              placeholder="Masukkan password" autocomplete="current-password"
              aria-required="true">
            <!-- IMK: Toggle password visibility -->
            <button type="button" onclick="togglePwd()" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text3);font-size:.85rem" aria-label="Tampilkan/sembunyikan password" title="Tampilkan password">👁</button>
          </div>
          @error('password')<div class="field-error" role="alert">⚠ {{ $message }}</div>@enderror
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
          <label style="display:flex;align-items:center;gap:6px;font-size:.82rem;cursor:pointer">
            <input type="checkbox" name="remember" style="width:auto;cursor:pointer"> Ingat saya
          </label>
          <a href="#" style="font-size:.82rem;color:var(--primary)">Lupa password?</a>
        </div>

        <!-- IMK: Primary action button is large and clearly labeled -->
        <button type="submit" class="btn btn-primary btn-full" id="loginBtn" aria-label="Masuk ke akun BuilderHub">
          Masuk ke Akun
        </button>
      </form>

      <p style="font-size:.75rem;color:var(--text3);text-align:center;margin-top:.75rem">
        Belum punya akun? <a href="{{ route('register') }}" style="color:var(--primary);font-weight:600">Daftar Gratis</a>
      </p>

      <hr style="margin:1.5rem 0;border:none;border-top:1px solid var(--border)">

      <!-- IMK: Quick login for demo/testing (clearly labeled) -->
      <p style="font-size:.8rem;color:var(--text3);text-align:center;margin-bottom:.75rem">Demo — Masuk langsung sebagai:</p>
      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:.5rem">
        @foreach([['Admin', 'admin@builderhub.id', 'var(--red)'], ['Programmer', 'rizky@builderhub.id', 'var(--primary)'], ['UMKM', 'budi@batik.id', 'var(--accent)'], ['Pelajar/Student', 'student@builderhub.id', 'var(--green)']] as [$label, $email, $color])
        <form method="POST" action="{{ route('login.post') }}">
          @csrf
          <input type="hidden" name="email" value="{{ $email }}">
          <input type="hidden" name="password" value="password">
          <button type="submit" class="btn btn-ghost btn-sm" style="width:100%;justify-content:center" aria-label="Demo masuk sebagai {{ $label }}">
            <span style="width:8px;height:8px;border-radius:50%;background:{{ $color }};display:inline-block"></span> {{ $label }}
          </button>
        </form>
        @endforeach
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function togglePwd(){
  const p = document.getElementById('password');
  p.type = p.type === 'password' ? 'text' : 'password';
}
// IMK: Loading state on submit
document.querySelector('form[action="{{ route('login.post') }}"]')?.addEventListener('submit', function(){
  const btn = document.getElementById('loginBtn');
  btn.textContent = 'Memuat...';
  btn.disabled = true;
});
</script>
@endpush
@endsection
