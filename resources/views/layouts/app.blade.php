<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="@yield('meta_description', 'BuilderHub — Platform penghubung UMKM dan Programmer profesional Indonesia')">
<title>@yield('title', 'BuilderHub') — Platform UMKM & Programmer Indonesia</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{
  --primary:#6C38FF;--primary-dark:#4F22D9;--primary-light:#EDE9FF;
  --accent:#FF6B35;--accent-light:#FFF0EA;
  --dark:#0F0F1A;--dark2:#1A1E2E;--dark3:#242840;
  --text:#111827;--text2:#4B5563;--text3:#9CA3AF;
  --bg:#FFFFFF;--bg2:#F9FAFB;--bg3:#F3F4F6;
  --border:#E5E7EB;--border2:#D1D5DB;
  --green:#10B981;--green-light:#ECFDF5;
  --orange:#F59E0B;--orange-light:#FFFBEB;
  --red:#EF4444;--red-light:#FEF2F2;
  --blue:#3B82F6;--blue-light:#EFF6FF;
  --radius:12px;--radius-sm:8px;--radius-lg:16px;--radius-xl:24px;
  --shadow:0 1px 3px rgba(0,0,0,.08);
  --shadow-md:0 4px 12px rgba(0,0,0,.10);
  --shadow-lg:0 8px 24px rgba(0,0,0,.12);
}
body{font-family:'Plus Jakarta Sans',sans-serif;color:var(--text);background:var(--bg);overflow-x:hidden}
a{text-decoration:none;color:inherit}
button,input,select,textarea{font-family:inherit;cursor:pointer;border:none;background:none}
input,select,textarea{cursor:text}

/* NAVBAR */
.navbar{position:sticky;top:0;z-index:100;background:rgba(255,255,255,.95);backdrop-filter:blur(12px);border-bottom:1px solid var(--border);padding:0 2rem}
.navbar-inner{max-width:1200px;margin:0 auto;display:flex;align-items:center;height:64px;gap:2rem}
.nav-logo{display:flex;align-items:center;gap:10px;font-weight:800;font-size:1.1rem;color:var(--text)}
.nav-logo-icon{width:36px;height:36px;background:var(--primary);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;font-weight:800}
.nav-menu{display:flex;gap:.25rem;flex:1;justify-content:center}
.nav-link{padding:8px 14px;border-radius:var(--radius-sm);font-size:.875rem;font-weight:500;color:var(--text2);transition:.15s}
.nav-link:hover,.nav-link.active{color:var(--primary);background:var(--primary-light)}
.nav-right{display:flex;align-items:center;gap:.75rem;margin-left:auto}
.btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:var(--radius-sm);font-size:.875rem;font-weight:600;transition:.15s;cursor:pointer;border:1px solid transparent}
.btn-ghost{color:var(--text2);border-color:var(--border)}
.btn-ghost:hover{background:var(--bg2);border-color:var(--border2)}
.btn-primary{background:var(--primary);color:#fff;border-color:var(--primary)}
.btn-primary:hover{background:var(--primary-dark);transform:translateY(-1px)}
.btn-success{background:var(--green);color:#fff;border-color:var(--green)}
.btn-success:hover{opacity:.9}
.btn-orange{background:var(--accent);color:#fff;border-color:var(--accent)}
.btn-danger{background:var(--red);color:#fff;border-color:var(--red)}
.btn-danger:hover{opacity:.9}
.btn-sm{padding:6px 12px;font-size:.8rem}
.btn-full{width:100%;justify-content:center;padding:12px}
.nav-avatar-btn{display:flex;align-items:center;gap:8px;padding:6px 12px;border-radius:var(--radius);border:1px solid var(--border);cursor:pointer;background:var(--bg)}
.nav-av{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:#fff;background:var(--primary)}
.nav-notif{position:relative;width:36px;height:36px;border-radius:var(--radius-sm);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:1rem;transition:.15s}
.nav-notif:hover{background:var(--bg2)}
.notif-dot{position:absolute;top:5px;right:5px;width:7px;height:7px;background:var(--red);border-radius:50%;border:1.5px solid #fff}

/* ALERTS */
.alert{padding:.85rem 1.1rem;border-radius:var(--radius);margin-bottom:1rem;font-size:.875rem;display:flex;align-items:center;gap:.6rem;animation:slideIn .3s ease}
.alert-success{background:var(--green-light);color:#065F46;border:1px solid rgba(16,185,129,.3)}
.alert-error{background:var(--red-light);color:#991B1B;border:1px solid rgba(239,68,68,.3)}
.alert-info{background:var(--blue-light);color:#1E40AF;border:1px solid rgba(59,130,246,.3)}
.alert-warning{background:var(--orange-light);color:#92400E;border:1px solid rgba(245,158,11,.3)}
@keyframes slideIn{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}

/* BADGES */
.badge{font-size:.7rem;font-weight:600;padding:3px 9px;border-radius:99px}
.badge-open{background:var(--primary-light);color:var(--primary)}
.badge-running{background:var(--orange-light);color:var(--orange)}
.badge-done{background:var(--green-light);color:var(--green)}
.badge-verified{background:var(--green-light);color:var(--green)}
.badge-cancelled{background:var(--red-light);color:var(--red)}

/* FORMS */
.form-group{margin-bottom:1rem}
.form-label{display:block;font-size:.82rem;font-weight:600;color:var(--text);margin-bottom:.35rem}
.form-label .required{color:var(--red)}
.form-input{width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-size:.875rem;color:var(--text);transition:.15s;background:var(--bg)}
.form-input:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(108,56,255,.1)}
.form-input.error{border-color:var(--red)}
.form-select{width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-size:.875rem;color:var(--text);background:var(--bg)}
.form-select:focus{outline:none;border-color:var(--primary)}
.form-textarea{width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-size:.875rem;color:var(--text);resize:vertical;min-height:100px}
.form-textarea:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(108,56,255,.1)}
.form-hint{font-size:.75rem;color:var(--text3);margin-top:.25rem}
.field-error{font-size:.75rem;color:var(--red);margin-top:.25rem;display:flex;align-items:center;gap:4px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}

/* CARDS */
.card{background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.25rem}
.card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem}
.card-title{font-size:1rem;font-weight:700}

/* TABLE */
.table-wrap{overflow-x:auto}
.data-table{width:100%;border-collapse:collapse;font-size:.875rem}
.data-table th{text-align:left;padding:.75rem 1rem;font-size:.78rem;font-weight:600;color:var(--text3);background:var(--bg2);border-bottom:1px solid var(--border)}
.data-table td{padding:.85rem 1rem;border-bottom:1px solid var(--border);vertical-align:middle}
.data-table tr:hover td{background:var(--bg2)}

/* SECTION */
.section{padding:4rem 2rem}
.section-inner{max-width:1200px;margin:0 auto}
.section-header{text-align:center;margin-bottom:3rem}
.section-badge{display:inline-flex;align-items:center;gap:6px;background:var(--primary-light);border-radius:99px;padding:5px 14px;font-size:.8rem;font-weight:600;color:var(--primary);margin-bottom:.75rem}
.section h2{font-size:2rem;font-weight:800;margin-bottom:.75rem}
.section p.lead{color:var(--text2);font-size:1rem;max-width:560px;margin:0 auto;line-height:1.7}

/* STATS */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem}
.stat-card{background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.25rem}
.stat-card-icon{font-size:1.25rem;margin-bottom:.5rem}
.stat-card-value{font-size:1.6rem;font-weight:800;color:var(--text)}
.stat-card-label{font-size:.8rem;color:var(--text3);margin-top:2px}

/* FOOTER */
footer{background:var(--dark2);color:rgba(255,255,255,.7);padding:3rem 2rem 1.5rem}
.footer-inner{max-width:1200px;margin:0 auto}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:2rem;margin-bottom:2rem}
.footer-brand h3{font-size:1rem;font-weight:800;color:#fff;margin-bottom:.5rem}
.footer-brand p{font-size:.85rem;line-height:1.7;margin-bottom:1rem}
.footer-social{display:flex;gap:.5rem}
.social-btn{width:32px;height:32px;background:rgba(255,255,255,.1);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;font-size:.8rem;cursor:pointer;transition:.15s}
.social-btn:hover{background:rgba(255,255,255,.2)}
.footer-col h4{font-size:.85rem;font-weight:700;color:#fff;margin-bottom:.75rem}
.footer-links{list-style:none;display:flex;flex-direction:column;gap:.4rem}
.footer-links li a{font-size:.82rem;color:rgba(255,255,255,.6);transition:.15s}
.footer-links li a:hover{color:#fff}
.footer-bottom{border-top:1px solid rgba(255,255,255,.1);padding-top:1.25rem;display:flex;justify-content:space-between;align-items:center;font-size:.78rem}

/* DASHBOARD LAYOUT */
.dash-layout{max-width:1200px;margin:0 auto;padding:2rem}
.profile-header{background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.5rem;display:flex;justify-content:space-between;align-items:center}
.profile-av{width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.3rem;font-weight:800;color:#fff;background:var(--primary)}
.tab-bar{display:flex;gap:.25rem;margin-bottom:1.5rem;border-bottom:1px solid var(--border)}
.tab-btn{padding:10px 16px;font-size:.875rem;font-weight:500;color:var(--text2);border-bottom:2px solid transparent;cursor:pointer;margin-bottom:-1px;transition:.15s;background:none;border-top:none;border-left:none;border-right:none}
.tab-btn:hover{color:var(--text)}
.tab-btn.active{color:var(--primary);border-bottom-color:var(--primary);font-weight:600}

/* PROGRESS */
.progress-bar{height:6px;background:var(--bg3);border-radius:99px;overflow:hidden}
.progress-fill{height:100%;border-radius:99px;background:var(--primary);transition:.4s}

/* TAGS */
.tag-list{display:flex;gap:.4rem;flex-wrap:wrap}
.tag{background:var(--bg3);color:var(--text2);font-size:.75rem;font-weight:500;padding:3px 9px;border-radius:var(--radius-sm)}

/* PROJECT CARD */
.project-card{border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.25rem;background:var(--bg);transition:.2s}
.project-card:hover{box-shadow:var(--shadow-md);border-color:var(--border2);transform:translateY(-2px)}
.project-grid{display:flex;flex-direction:column;gap:1rem}

/* COURSE CARD */
.course-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));gap:1.25rem}
.course-card{border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;background:var(--bg);transition:.2s;display:flex;flex-direction:column}
.course-card:hover{box-shadow:var(--shadow-md);transform:translateY(-2px)}
.course-thumb{height:150px;background:linear-gradient(135deg,#1E1260,#3D1FAF);display:flex;align-items:center;justify-content:center;font-size:3rem;position:relative}
.level-badge{position:absolute;top:10px;left:10px;padding:3px 9px;border-radius:99px;font-size:.7rem;font-weight:700}
.level-pemula{background:#059669;color:#fff}
.level-menengah{background:#D97706;color:#fff}
.level-mahir{background:#DC2626;color:#fff}

/* IMK TOOLTIP */
.imk-tooltip{position:relative;display:inline-block}
.imk-tooltip .tooltip-text{visibility:hidden;background:var(--dark);color:#fff;text-align:center;border-radius:var(--radius-sm);padding:6px 10px;position:absolute;z-index:10;bottom:125%;left:50%;transform:translateX(-50%);width:200px;font-size:.75rem;opacity:0;transition:.2s;pointer-events:none}
.imk-tooltip:hover .tooltip-text{visibility:visible;opacity:1}

/* IMK ONBOARDING GUIDE */
.imk-guide{background:linear-gradient(135deg,var(--primary-light),#fff);border:1px solid rgba(108,56,255,.2);border-radius:var(--radius-lg);padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:flex-start;gap:.75rem}
.imk-guide-icon{font-size:1.25rem;flex-shrink:0;margin-top:.1rem}
.imk-guide-title{font-size:.9rem;font-weight:700;color:var(--primary);margin-bottom:.25rem}
.imk-guide-text{font-size:.82rem;color:var(--text2);line-height:1.5}

/* MOBILE RESPONSIVE */
@media(max-width:768px){
  .stats-grid{grid-template-columns:repeat(2,1fr)}
  .course-grid{grid-template-columns:1fr}
  .footer-grid{grid-template-columns:1fr 1fr}
  .form-row{grid-template-columns:1fr}
  .navbar{padding:0 1rem}
  .nav-menu{display:none}
  .section{padding:2rem 1rem}
  .dash-layout{padding:1rem}
}
@media(max-width:480px){
  .footer-grid{grid-template-columns:1fr}
  .stats-grid{grid-template-columns:1fr 1fr}
}
</style>
<script>window.APP_URL = "{{ url('/') }}";</script>
@stack('styles')
</head>
<body>

@if(session('success'))
<div style="position:fixed;top:1rem;right:1rem;z-index:9999;max-width:380px">
  <div class="alert alert-success">
    @if(str_starts_with(session('success'), '🎉'))
      {{ session('success') }}
    @else
      ✅ {{ preg_replace('/^\s*✅\s*/u', '', session('success')) }}
    @endif
  </div>
</div>
<script>setTimeout(()=>{document.querySelector('.alert-success')?.remove()},4000)</script>
@endif
@if(session('error'))
<div style="position:fixed;top:1rem;right:1rem;z-index:9999;max-width:380px">
  <div class="alert alert-error">{{ str_starts_with(session('error'), '❌') ? session('error') : '❌ ' . session('error') }}</div>
</div>
<script>setTimeout(()=>{document.querySelector('.alert-error')?.remove()},5000)</script>
@endif
@if(session('info'))
<div style="position:fixed;top:1rem;right:1rem;z-index:9999;max-width:380px">
  <div class="alert alert-info">{{ (str_starts_with(session('info'), 'ℹ️') || str_starts_with(session('info'), 'ℹ')) ? session('info') : 'ℹ️ ' . session('info') }}</div>
</div>
<script>setTimeout(()=>{document.querySelector('.alert-info')?.remove()},4000)</script>
@endif

@guest
<nav class="navbar" aria-label="Navigasi utama BuilderHub">
  <div class="navbar-inner">
    <a href="{{ route('home') }}" class="nav-logo" aria-label="BuilderHub Beranda">
      <div class="nav-logo-icon" aria-hidden="true">&lt;/&gt;</div>BuilderHub
    </a>
    <nav class="nav-menu" aria-label="Menu navigasi">
      <a href="{{ route('projects') }}" class="nav-link {{ request()->routeIs('projects') ? 'active' : '' }}">Project UMKM</a>
      <a href="{{ route('courses.index') }}" class="nav-link {{ request()->routeIs('courses*') ? 'active' : '' }}">Course</a>
      <a href="{{ route('cara-kerja') }}" class="nav-link {{ request()->routeIs('cara-kerja') ? 'active' : '' }}">Cara Kerja</a>
    </nav>
    <div class="nav-right">
      <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
      <a href="{{ route('register') }}" class="btn btn-primary">Daftar Gratis</a>
    </div>
  </div>
</nav>
@endguest

<main id="main-content" role="main">
  @yield('content')
</main>

@guest
<footer role="contentinfo">
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-brand">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:.75rem">
          <div class="nav-logo-icon">&lt;/&gt;</div><h3 style="margin:0">BuilderHub</h3>
        </div>
        <p>Platform penghubung UMKM dengan programmer profesional Indonesia. Wujudkan bisnis digital Anda bersama kami.</p>
        <div class="footer-social">
          <div class="social-btn" aria-label="Twitter">𝕏</div>
          <div class="social-btn" aria-label="Instagram">📷</div>
          <div class="social-btn" aria-label="LinkedIn">in</div>
        </div>
      </div>
      <div class="footer-col">
        <h4>Platform</h4>
        <ul class="footer-links">
          <li><a href="{{ route('home') }}">Beranda</a></li>
          <li><a href="{{ route('projects') }}">Project UMKM</a></li>
          <li><a href="{{ route('courses.index') }}">Course & Pelatihan</a></li>
          <li><a href="{{ route('cara-kerja') }}">Cara Kerja</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Daftar Sebagai</h4>
        <ul class="footer-links">
          <li><a href="{{ route('register') }}?role=programmer">Programmer</a></li>
          <li><a href="{{ route('register') }}?role=umkm">UMKM / Bisnis</a></li>
          <li><a href="{{ route('register') }}?role=course">Pelajar / Student</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Kontak</h4>
        <div style="display:flex;flex-direction:column;gap:.5rem;font-size:.82rem">
          <div>📧 hello@builderhub.id</div>
          <div>📞 +62 812-3456-7890</div>
          <div>📍 Jakarta Selatan, Indonesia</div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© {{ date('Y') }} BuilderHub. Hak cipta dilindungi.</span>
      <div style="display:flex;gap:1.25rem">
        <a href="#" style="color:rgba(255,255,255,.5)">Kebijakan Privasi</a>
        <a href="#" style="color:rgba(255,255,255,.5)">Syarat & Ketentuan</a>
      </div>
    </div>
  </div>
</footer>
@endguest

@stack('scripts')
<script>
// IMK: Auto-dismiss alerts
document.querySelectorAll('.alert').forEach(el=>{
  setTimeout(()=>el.closest('div')?.remove(), 4500);
});
</script>
</body>
</html>
