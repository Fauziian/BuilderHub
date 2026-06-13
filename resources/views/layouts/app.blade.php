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
* { margin: 0; padding: 0; box-sizing: border-box; }
:root {
  --primary: #4F46E5; --primary-dark: #3730A3; --primary-light: #EEF2FF;
  --accent: #F97316; --accent-light: #FFF7ED;
  --dark: #0B0F19; --dark2: #151A2D; --dark3: #1E253A;
  --text: #1E293B; --text2: #475569; --text3: #94A3B8;
  --bg: #F8FAFC; --bg2: #FFFFFF; --bg3: #F1F5F9;
  --border: #E2E8F0; --border2: #CBD5E1;
  --green: #10B981; --green-light: #ECFDF5;
  --orange: #F59E0B; --orange-light: #FFFBEB;
  --red: #EF4444; --red-light: #FEF2F2;
  --blue: #3B82F6; --blue-light: #EFF6FF;
  --radius: 16px; --radius-sm: 10px; --radius-lg: 24px; --radius-xl: 32px;
  --shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
  --shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
  --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -2px rgba(0,0,0,0.04);
  --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
  --shadow-glow: 0 0 20px rgba(79, 70, 229, 0.25);
}
body { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text); background: var(--bg); overflow-x: hidden; -webkit-font-smoothing: antialiased; }
a { text-decoration: none; color: inherit; transition: all 0.2s ease; }
button, input, select, textarea { font-family: inherit; cursor: pointer; border: none; background: none; transition: all 0.2s ease; }
input, select, textarea { cursor: text; }

/* NAVBAR */
.navbar { position: sticky; top: 0; z-index: 100; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255,255,255,0.4); padding: 0 2rem; box-shadow: var(--shadow-sm); }
.navbar-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; height: 72px; gap: 2rem; }
.nav-logo { display: flex; align-items: center; gap: 12px; font-weight: 800; font-size: 1.25rem; color: var(--text); letter-spacing: -0.5px; }
.nav-logo-icon { width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), #818CF8); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1rem; font-weight: 800; box-shadow: var(--shadow-glow); }
.nav-menu { display: flex; gap: 0.5rem; flex: 1; justify-content: center; }
.nav-link { padding: 8px 16px; border-radius: 99px; font-size: 0.95rem; font-weight: 600; color: var(--text2); transition: all 0.3s ease; }
.nav-link:hover, .nav-link.active { color: var(--primary); background: var(--primary-light); }
.nav-right { display: flex; align-items: center; gap: 1rem; margin-left: auto; }

/* BUTTONS */
.btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 24px; border-radius: 99px; font-size: 0.95rem; font-weight: 700; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; border: 1.5px solid transparent; letter-spacing: 0.2px; }
.btn:active { transform: scale(0.97); }
.btn-ghost { color: var(--text2); border-color: var(--border); background: var(--bg2); }
.btn-ghost:hover { background: var(--bg3); border-color: var(--border2); color: var(--text); box-shadow: var(--shadow); }
.btn-primary { background: linear-gradient(135deg, var(--primary), #6366F1); color: #fff; border: none; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); }
.btn-primary:hover { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4); color:#fff; }
.btn-success { background: linear-gradient(135deg, var(--green), #34D399); color: #fff; border: none; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
.btn-success:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4); color:#fff; }
.btn-orange { background: linear-gradient(135deg, var(--accent), #FB923C); color: #fff; border: none; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3); }
.btn-orange:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(249, 115, 22, 0.4); color:#fff; }
.btn-danger { background: var(--red); color: #fff; border-color: var(--red); }
.btn-danger:hover { background: #DC2626; border-color: #DC2626; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }
.btn-sm { padding: 8px 16px; font-size: 0.85rem; }
.btn-full { width: 100%; justify-content: center; }

/* MISC NAV */
.nav-avatar-btn { display: flex; align-items: center; gap: 10px; padding: 6px 16px 6px 6px; border-radius: 99px; border: 1px solid var(--border); cursor: pointer; background: var(--bg2); transition: all 0.2s; box-shadow: var(--shadow-sm); }
.nav-avatar-btn:hover { border-color: var(--primary); box-shadow: var(--shadow-glow); }
.nav-av { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--primary), var(--accent)); }
.nav-notif{position:relative;width:40px;height:40px;border-radius:var(--radius-sm);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:1.1rem;transition:.15s;background:var(--bg2)}
.nav-notif:hover{background:var(--bg3)}
.notif-dot{position:absolute;top:6px;right:6px;width:8px;height:8px;background:var(--red);border-radius:50%;border:2px solid #fff}

/* CARDS */
.card { background: var(--bg2); border: 1px solid rgba(255,255,255,0.8); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow); transition: all 0.3s ease; position: relative; overflow: hidden; }
.card::before { content: ""; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary), var(--accent)); opacity: 0; transition: opacity 0.3s ease; }
.card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); border-color: var(--border); }
.card:hover::before { opacity: 1; }
.card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem; }
.card-title { font-size: 1.1rem; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 8px; }

/* FORMS */
.form-group { margin-bottom: 1.25rem; }
.form-label { display: block; font-size: 0.875rem; font-weight: 700; color: var(--text); margin-bottom: 0.5rem; }
.form-label .required { color: var(--red); }
.form-input, .form-select, .form-textarea { width: 100%; padding: 12px 16px; border: 2px solid var(--border); border-radius: var(--radius-sm); font-size: 0.95rem; color: var(--text); background: var(--bg); transition: all 0.3s ease; font-family: 'Plus Jakarta Sans', sans-serif; }
.form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: var(--primary); background: var(--bg2); box-shadow: 0 0 0 4px var(--primary-light); }
.form-textarea { resize: vertical; min-height: 120px; }
.form-hint { font-size: 0.8rem; color: var(--text3); margin-top: 0.5rem; }
.field-error { font-size: 0.8rem; color: var(--red); margin-top: 0.5rem; display: flex; align-items: center; gap: 4px; font-weight: 600; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

/* STATS */
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
.stat-card { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.5rem; display: flex; flex-direction: column; align-items: flex-start; box-shadow: var(--shadow); transition: all 0.3s ease; position: relative; overflow: hidden; }
.stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--primary); }
.stat-card-icon { font-size: 1.8rem; margin-bottom: 1rem; padding: 12px; background: var(--primary-light); border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; }
.stat-card-value { font-size: 2rem; font-weight: 800; color: var(--text); letter-spacing: -1px; line-height: 1.2; }
.stat-card-label { font-size: 0.9rem; color: var(--text2); font-weight: 600; margin-top: 4px; }

/* BADGES */
.badge { font-size: 0.75rem; font-weight: 700; padding: 4px 12px; border-radius: 99px; display: inline-flex; align-items: center; gap: 4px; letter-spacing: 0.3px; text-transform: uppercase; }
.badge-open { background: var(--primary-light); color: var(--primary-dark); }
.badge-running { background: var(--orange-light); color: #B45309; }
.badge-done { background: var(--green-light); color: #047857; }
.badge-verified { background: var(--green-light); color: var(--green); }
.badge-cancelled { background: var(--red-light); color: var(--red); }

/* TABS */
.tab-bar { display: flex; gap: 0.5rem; margin-bottom: 2rem; border-bottom: 2px solid var(--border); padding-bottom: 0px; overflow-x: auto; scrollbar-width: none; }
.tab-bar::-webkit-scrollbar { display: none; }
.tab-btn { padding: 12px 20px; font-size: 0.95rem; font-weight: 600; color: var(--text2); border-bottom: 3px solid transparent; margin-bottom: -2px; transition: all 0.3s ease; white-space: nowrap; }
.tab-btn:hover { color: var(--primary); background: var(--bg3); border-radius: 8px 8px 0 0; }
.tab-btn.active { color: var(--primary); border-bottom-color: var(--primary); }

/* DASHBOARD LAYOUT */
.dash-layout { max-width: 1200px; margin: 0 auto; padding: 2.5rem 2rem; }
.profile-header { background: linear-gradient(135deg, var(--dark) 0%, var(--dark2) 100%); border-radius: var(--radius-xl); padding: 2.5rem; margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center; color: #fff; box-shadow: var(--shadow-lg); position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); }
.profile-header::after { content: ''; position: absolute; right: -50px; top: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(79,70,229,0.3) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
.profile-av { width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--primary), var(--accent)); box-shadow: 0 0 20px rgba(255,255,255,0.2); border: 3px solid rgba(255,255,255,0.2); }

/* TABLES */
.table-wrap { overflow-x: auto; border-radius: var(--radius); border: 1px solid var(--border); background: var(--bg2); }
.data-table { width: 100%; border-collapse: collapse; font-size: 0.95rem; }
.data-table th { text-align: left; padding: 1rem 1.25rem; font-size: 0.85rem; font-weight: 700; color: var(--text2); background: var(--bg3); border-bottom: 2px solid var(--border); text-transform: uppercase; letter-spacing: 0.5px; }
.data-table td { padding: 1.25rem 1.25rem; border-bottom: 1px solid var(--border); vertical-align: middle; color: var(--text); }
.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: var(--primary-light); }

/* ALERTS */
.alert { padding: 1rem 1.25rem; border-radius: var(--radius); margin-bottom: 1.5rem; font-size: 0.95rem; font-weight: 600; display: flex; align-items: center; gap: 0.75rem; animation: slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: var(--shadow); }
.alert-success { background: var(--green-light); color: #065F46; border: 1px solid rgba(16,185,129,0.3); }
.alert-error { background: var(--red-light); color: #991B1B; border: 1px solid rgba(239,68,68,0.3); }
.alert-info { background: var(--blue-light); color: #1E40AF; border: 1px solid rgba(59,130,246,0.3); }
.alert-warning { background: var(--orange-light); color: #92400E; border: 1px solid rgba(245,158,11,0.3); }
@keyframes slideIn{from{opacity:0;transform:translateY(-10px) scale(0.98)}to{opacity:1;transform:translateY(0) scale(1)}}

/* TOAST CONTAINER */
.toast-container { position: fixed; top: 2rem; right: 2rem; z-index: 9999; display: flex; flex-direction: column; gap: 1rem; max-width: 400px; }

/* SECTION */
.section { padding: 6rem 2rem; }
.section-inner { max-width: 1200px; margin: 0 auto; }
.section-header { text-align: center; margin-bottom: 4rem; }
.section-badge { display: inline-flex; align-items: center; gap: 8px; background: var(--primary-light); border-radius: 99px; padding: 8px 20px; font-size: 0.85rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1.25rem; text-transform: uppercase; letter-spacing: 1px; }
.section h2 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; letter-spacing: -1px; }
.section p.lead { color: var(--text2); font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.8; }

/* PROGRESS */
.progress-bar { height: 8px; background: var(--bg3); border-radius: 99px; overflow: hidden; }
.progress-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, var(--primary), var(--accent)); transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1); }

/* TAGS */
.tag-list { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.tag { background: var(--bg3); color: var(--text2); font-size: 0.8rem; font-weight: 600; padding: 4px 12px; border-radius: var(--radius-sm); border: 1px solid var(--border); }

/* PROJECT / COURSE GRID */
.project-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.5rem; }
.project-card { border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.5rem; background: var(--bg2); transition: all 0.3s ease; display: flex; flex-direction: column; }
.project-card:hover { box-shadow: var(--shadow-lg); border-color: var(--primary); transform: translateY(-4px); }

.course-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem; }
.course-card { border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; background: var(--bg2); transition: all 0.3s ease; display: flex; flex-direction: column; box-shadow: var(--shadow); }
.course-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); border-color: var(--primary); }
.course-thumb { height: 180px; display: flex; align-items: center; justify-content: center; font-size: 4rem; position: relative; }
.level-badge { position: absolute; top: 12px; left: 12px; padding: 4px 12px; border-radius: 99px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); }
.level-pemula { background: #059669; color: #fff; }
.level-menengah { background: #D97706; color: #fff; }
.level-mahir { background: #DC2626; color: #fff; }

/* IMK TOOLTIP */
.imk-tooltip { position: relative; display: inline-block; cursor: help; }
.imk-tooltip .tooltip-text { visibility: hidden; background: var(--dark); color: #fff; text-align: center; border-radius: var(--radius-sm); padding: 8px 12px; position: absolute; z-index: 10; bottom: 125%; left: 50%; transform: translateX(-50%) translateY(10px); width: 220px; font-size: 0.8rem; opacity: 0; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); pointer-events: none; box-shadow: var(--shadow-md); font-weight: 500; line-height: 1.4; }
.imk-tooltip .tooltip-text::after { content: ""; position: absolute; top: 100%; left: 50%; margin-left: -5px; border-width: 5px; border-style: solid; border-color: var(--dark) transparent transparent transparent; }
.imk-tooltip:hover .tooltip-text { visibility: visible; opacity: 1; transform: translateX(-50%) translateY(0); }

/* IMK ONBOARDING GUIDE */
.imk-guide { background: linear-gradient(135deg, var(--primary-light), #fff); border: 1px solid rgba(79, 70, 229, 0.2); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 1rem; box-shadow: var(--shadow-sm); }
.imk-guide-icon { font-size: 1.5rem; flex-shrink: 0; margin-top: 0.1rem; background: #fff; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 12px; box-shadow: var(--shadow-sm); }
.imk-guide-title { font-size: 1rem; font-weight: 800; color: var(--primary-dark); margin-bottom: 0.4rem; }
.imk-guide-text { font-size: 0.9rem; color: var(--text2); line-height: 1.6; }

/* FOOTER */
footer { background: var(--dark); color: rgba(255,255,255,0.7); padding: 5rem 2rem 2rem; border-top: 1px solid rgba(255,255,255,0.05); }
.footer-inner { max-width: 1200px; margin: 0 auto; }
.footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 4rem; margin-bottom: 4rem; }
.footer-brand h3 { font-size: 1.25rem; font-weight: 800; color: #fff; margin-bottom: 1rem; }
.footer-brand p { font-size: 0.95rem; line-height: 1.8; margin-bottom: 1.5rem; max-width: 300px; }
.footer-social { display: flex; gap: 0.75rem; }
.social-btn { width: 40px; height: 40px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; cursor: pointer; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.1); }
.social-btn:hover { background: var(--primary); border-color: var(--primary); transform: translateY(-3px); color: #fff; }
.footer-col h4 { font-size: 1rem; font-weight: 800; color: #fff; margin-bottom: 1.25rem; }
.footer-links { list-style: none; display: flex; flex-direction: column; gap: 0.75rem; }
.footer-links li a { font-size: 0.9rem; color: rgba(255,255,255,0.6); transition: all 0.2s; }
.footer-links li a:hover { color: #fff; padding-left: 4px; }
.footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; }

/* MOBILE RESPONSIVE */
@media(max-width: 992px) {
  .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
}
@media(max-width: 768px) {
  .navbar { padding: 0 1rem; }
  .nav-menu { display: none; }
  .stats-grid { grid-template-columns: 1fr; }
  .form-row { grid-template-columns: 1fr; }
  .section { padding: 3rem 1.5rem; }
  .section h2 { font-size: 2rem; }
  .dash-layout { padding: 1.5rem 1rem; }
  .profile-header { flex-direction: column; text-align: center; gap: 1.5rem; padding: 2rem 1.5rem; }
  .profile-header > div:first-child { flex-direction: column; align-items: center; }
  .footer-grid { grid-template-columns: 1fr; }
  .footer-bottom { flex-direction: column; gap: 1rem; text-align: center; }
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
