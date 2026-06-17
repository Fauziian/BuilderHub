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
p, span, div, td, th, h1, h2, h3, h4, h5, h6, strong, a, label {
  word-break: break-word;
  overflow-wrap: break-word;
}
a { text-decoration: none; color: inherit; transition: all 0.2s ease; }
button, input, select, textarea { font-family: inherit; cursor: pointer; border: none; background: none; transition: all 0.2s ease; }
input, select, textarea { cursor: text; }

/* NAVBAR */
.navbar { position: sticky; top: 0; z-index: 100; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255,255,255,0.4); padding: 0 2rem; box-shadow: var(--shadow-sm); }
.navbar-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; height: 72px; gap: 2rem; }
.nav-logo { display: flex; align-items: center; gap: 12px; font-weight: 800; font-size: 1.25rem; color: var(--text); letter-spacing: -0.5px; }
.nav-logo-icon { width: 44px; height: 35px; flex-shrink: 0; filter: drop-shadow(0 4px 6px rgba(79, 70, 229, 0.15)); }
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

/* 3D Glassmorphism & Premium shadow depth */
.glass-card {
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.45);
  box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.06), inset 0 0 0 1px rgba(255, 255, 255, 0.5);
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.glass-card:hover {
  transform: translateY(-6px) scale(1.01);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06), 0 0 24px rgba(79, 70, 229, 0.15);
  border-color: rgba(79, 70, 229, 0.25);
}

.btn-3d {
  position: relative;
  border: none;
  background: linear-gradient(135deg, var(--primary), #8B5CF6);
  color: #fff !important;
  border-radius: 99px;
  box-shadow: 0 4px 0 #3730A3, 0 8px 16px rgba(79, 70, 229, 0.3);
  transition: all 0.15s ease;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  text-decoration: none;
}
.btn-3d:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 0 #3730A3, 0 12px 20px rgba(79, 70, 229, 0.4);
}
.btn-3d:active {
  transform: translateY(4px);
  box-shadow: 0 0px 0 #3730A3, 0 4px 8px rgba(79, 70, 229, 0.2);
}

.btn-3d-orange {
  background: linear-gradient(135deg, var(--accent), #FB923C);
  box-shadow: 0 4px 0 #C2410C, 0 8px 16px rgba(249, 115, 22, 0.3);
}
.btn-3d-orange:hover {
  box-shadow: 0 6px 0 #C2410C, 0 12px 20px rgba(249, 115, 22, 0.4);
}
.btn-3d-orange:active {
  transform: translateY(4px);
  box-shadow: 0 0px 0 #C2410C, 0 4px 8px rgba(249, 115, 22, 0.2);
}

.btn-3d-green {
  background: linear-gradient(135deg, var(--green), #34D399);
  box-shadow: 0 4px 0 #047857, 0 8px 16px rgba(16, 185, 129, 0.3);
}
.btn-3d-green:hover {
  box-shadow: 0 6px 0 #047857, 0 12px 20px rgba(16, 185, 129, 0.4);
}
.btn-3d-green:active {
  transform: translateY(4px);
  box-shadow: 0 0px 0 #047857, 0 4px 8px rgba(16, 185, 129, 0.2);
}

/* 3D Floating Animations */
@keyframes float {
  0% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-8px) rotate(1deg); }
  100% { transform: translateY(0px) rotate(0deg); }
}

.float-3d {
  animation: float 4s ease-in-out infinite;
}

/* Mascot Buddy Styling */
.buddy-mascot-container {
  position: fixed;
  bottom: 24px;
  right: 24px;
  z-index: 99999;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  font-family: inherit;
  pointer-events: none;
  transition: transform 1.2s cubic-bezier(0.6, -0.28, 0.735, 0.045), opacity 0.8s ease-in;
}
.buddy-mascot-container.buddy-fallen {
  transform: translateY(500px) rotate(15deg);
  opacity: 0;
  pointer-events: none;
}
.buddy-bubble {
  background: #ffffff;
  border: 2px solid #4F46E5;
  border-radius: var(--radius-lg);
  padding: 1.25rem;
  box-shadow: 0 20px 40px rgba(0,0,0,0.15);
  max-width: 320px;
  margin-bottom: 12px;
  font-size: 0.88rem;
  color: var(--text);
  line-height: 1.5;
  position: relative;
  border-bottom-right-radius: 2px;
  opacity: 0;
  transform: translateY(30px) scale(0.9);
  pointer-events: none;
  transition: all 0.45s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.buddy-bubble.active {
  opacity: 1;
  transform: translateY(0) scale(1);
  pointer-events: all;
}
.buddy-bubble.closing {
  opacity: 0;
  transform: translateY(120px) scale(0.8);
  pointer-events: none;
}
.buddy-bubble::after {
  content: '';
  position: absolute;
  bottom: -10px;
  right: 18px;
  border-width: 10px 10px 0;
  border-style: solid;
  border-color: #ffffff transparent;
  display: block;
  width: 0;
}
.buddy-bubble::before {
  content: '';
  position: absolute;
  bottom: -13px;
  right: 17px;
  border-width: 11px 11px 0;
  border-style: solid;
  border-color: #4F46E5 transparent;
  display: block;
  width: 0;
  z-index: -1;
}
.buddy-avatar {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #4F46E5, #8B5CF6);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4), inset 0 -4px 0 rgba(0,0,0,0.2);
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  border: 3px solid #ffffff;
  animation: float 3s ease-in-out infinite;
  position: relative;
  pointer-events: all;
}
.buddy-avatar:hover {
  transform: scale(1.1) rotate(5deg);
  box-shadow: 0 15px 32px rgba(79, 70, 229, 0.5), inset 0 -4px 0 rgba(0,0,0,0.2);
}
.buddy-face {
  font-size: 2.2rem;
  user-select: none;
}
.buddy-pulse {
  position: absolute;
  top: -2px;
  right: -2px;
  width: 14px;
  height: 14px;
  background: #10B981;
  border: 2px solid #ffffff;
  border-radius: 50%;
  animation: pulse-ring 1.5s infinite;
  transition: opacity 0.3s ease;
}
@keyframes pulse-ring {
  0% { transform: scale(0.85); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
  100% { transform: scale(0.85); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
</style>
<script>
  window.APP_URL = "{{ url('/') }}";
  window.USER_ROLE = "{{ Auth::check() ? Auth::user()->role : 'guest' }}";
</script>
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
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 160" class="nav-logo-icon" aria-hidden="true" style="fill: none;">
        <defs>
          <linearGradient id="logo-grad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="var(--primary)" />
            <stop offset="100%" stop-color="#8B5CF6" />
          </linearGradient>
        </defs>
        <path d="M 93 12 A 10 10 0 0 1 107 12 L 182 72 A 10 10 0 0 1 185 80 L 185 140 A 10 10 0 0 1 175 150 L 25 150 A 10 10 0 0 1 15 140 L 15 80 A 10 10 0 0 1 18 72 Z" fill="url(#logo-grad)" />
        <path d="M 85 45 L 75 51 L 85 57 M 115 45 L 125 51 L 115 57 M 105 40 L 95 62" stroke="#ffffff" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
        <path d="M 80 150 V 120 L 100 102 L 120 120 V 150 Z" fill="#ffffff" />
        <rect x="93" y="122" width="5" height="5" fill="url(#logo-grad)" rx="1.5" />
        <rect x="102" y="122" width="5" height="5" fill="url(#logo-grad)" rx="1.5" />
        <rect x="93" y="131" width="5" height="5" fill="url(#logo-grad)" rx="1.5" />
        <rect x="102" y="131" width="5" height="5" fill="url(#logo-grad)" rx="1.5" />
        <circle cx="50" cy="98" r="9.5" fill="#ffffff" />
        <path d="M 24 150 V 134 C 24 125 30 118 38 118 C 42 118 45 122 46 126 L 47 132 H 58 A 1 1 0 0 1 59 133 L 64 124 A 1 1 0 0 1 65.8 125 L 61 135 A 2 2 0 0 1 59 136.5 H 46.5 C 45 136.5 44 142 44 150 Z" fill="#ffffff" />
        <circle cx="150" cy="98" r="9.5" fill="#ffffff" />
        <path d="M 136 84 L 150 79 L 164 84 L 150 89 Z" fill="#ffffff" />
        <path d="M 144 86.5 V 90 C 144 92 156 92 156 90 V 86.5" fill="#ffffff" />
        <path d="M 158 84 L 162 90" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" fill="none" />
        <path d="M 176 150 V 134 C 176 125 170 118 162 118 C 158 118 155 122 154 126 L 153 132 H 144 L 140 126 A 1 1 0 0 0 138.2 127 L 141 135 A 2 2 0 0 0 143 136.5 H 153.5 C 155 136.5 156 142 156 150 Z" fill="#ffffff" />
        <path d="M 135 128 L 126 130 L 128 136 L 135 133 Z" fill="#ffffff" opacity="0.9" />
        <path d="M 135 128 L 142 126 L 144 132 L 135 133 Z" fill="#ffffff" opacity="0.9" />
      </svg>BuilderHub
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
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 160" class="nav-logo-icon" aria-hidden="true" style="fill: none;">
            <defs>
              <linearGradient id="logo-grad-footer" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="var(--primary)" />
                <stop offset="100%" stop-color="#8B5CF6" />
              </linearGradient>
            </defs>
            <path d="M 93 12 A 10 10 0 0 1 107 12 L 182 72 A 10 10 0 0 1 185 80 L 185 140 A 10 10 0 0 1 175 150 L 25 150 A 10 10 0 0 1 15 140 L 15 80 A 10 10 0 0 1 18 72 Z" fill="url(#logo-grad-footer)" />
            <path d="M 85 45 L 75 51 L 85 57 M 115 45 L 125 51 L 115 57 M 105 40 L 95 62" stroke="#ffffff" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
            <path d="M 80 150 V 120 L 100 102 L 120 120 V 150 Z" fill="#ffffff" />
            <rect x="93" y="122" width="5" height="5" fill="url(#logo-grad-footer)" rx="1.5" />
            <rect x="102" y="122" width="5" height="5" fill="url(#logo-grad-footer)" rx="1.5" />
            <rect x="93" y="131" width="5" height="5" fill="url(#logo-grad-footer)" rx="1.5" />
            <rect x="102" y="131" width="5" height="5" fill="url(#logo-grad-footer)" rx="1.5" />
            <circle cx="50" cy="98" r="9.5" fill="#ffffff" />
            <path d="M 24 150 V 134 C 24 125 30 118 38 118 C 42 118 45 122 46 126 L 47 132 H 58 A 1 1 0 0 1 59 133 L 64 124 A 1 1 0 0 1 65.8 125 L 61 135 A 2 2 0 0 1 59 136.5 H 46.5 C 45 136.5 44 142 44 150 Z" fill="#ffffff" />
            <circle cx="150" cy="98" r="9.5" fill="#ffffff" />
            <path d="M 136 84 L 150 79 L 164 84 L 150 89 Z" fill="#ffffff" />
            <path d="M 144 86.5 V 90 C 144 92 156 92 156 90 V 86.5" fill="#ffffff" />
            <path d="M 158 84 L 162 90" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path d="M 176 150 V 134 C 176 125 170 118 162 118 C 158 118 155 122 154 126 L 153 132 H 144 L 140 126 A 1 1 0 0 0 138.2 127 L 141 135 A 2 2 0 0 0 143 136.5 H 153.5 C 155 136.5 156 142 156 150 Z" fill="#ffffff" />
            <path d="M 135 128 L 126 130 L 128 136 L 135 133 Z" fill="#ffffff" opacity="0.9" />
            <path d="M 135 128 L 142 126 L 144 132 L 135 133 Z" fill="#ffffff" opacity="0.9" />
          </svg><h3 style="margin:0">BuilderHub</h3>
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

@auth
@if(in_array(Route::currentRouteName(), ['programmer.dashboard', 'umkm.dashboard', 'course.dashboard', 'admin.dashboard']))
<!-- INTERACTIVE MASCOT: BuilderBuddy Guide -->
<div class="buddy-mascot-container" id="buddyMascot">
  <div class="buddy-bubble" id="buddyBubble">
    <div id="buddyText">Hai! Saya BuilderBuddy. Ada yang bisa saya bantu hari ini?</div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px;border-top:1px solid #eee;padding-top:8px">
      <span id="buddyStep" style="font-size:0.75rem;color:var(--text3);font-weight:600"></span>
      <div style="display:flex;gap:6px">
        <button type="button" onclick="buddyPrev()" class="btn btn-ghost btn-sm" id="buddyPrevBtn" style="padding:4px 8px;font-size:0.72rem;display:none">Kembali</button>
        <button type="button" onclick="buddyNext()" class="btn btn-primary btn-sm" id="buddyNextBtn" style="padding:4px 10px;font-size:0.72rem">Lanjut</button>
        <button type="button" onclick="closeBuddy()" class="btn btn-ghost btn-sm" id="buddyCloseBtn" style="padding:4px 8px;font-size:0.72rem">Tutup</button>
      </div>
    </div>
  </div>
  <div class="buddy-avatar" onclick="toggleBuddy()" aria-label="Interactive Human Guide" title="Klik saya untuk panduan interaktif! 💡">
    <span class="buddy-face" id="buddyFace">🤖</span>
    <span class="buddy-pulse" id="buddyPulse"></span>
  </div>
</div>
@endif

<script>
let buddyTour = [];
let buddyCurrentStep = 0;

function initBuddyTour() {
  const role = window.USER_ROLE || 'guest';
  
  if (role === 'course') {
    buddyTour = [
      {
        text: "Selamat datang di **Dashboard Pelajar**! Saya akan membantu Anda memahami alur belajar di BuilderHub. 🎓",
        target: null,
        face: "🎓"
      },
      {
        text: "Di sini Anda bisa memantau **statistik belajar** Anda: course yang diikuti, sedang dipelajari, selesai, dan sertifikat yang Anda peroleh! 📊",
        target: ".stats-grid",
        face: "📈"
      },
      {
        text: "Gunakan **Tab Menu** ini untuk berpindah halaman antara Course Saya, Jelajah Course Baru, dan Sertifikat Anda. 🗂️",
        target: ".tab-bar",
        face: "🎯"
      },
      {
        text: "Gunakan **Pencarian & Filter** untuk mencari course tertentu berdasarkan judul, nama pengajar, atau memfilternya berdasarkan tingkat kesulitan! 🔍",
        target: "#myCoursesSearch",
        face: "🔎"
      },
      {
        text: "Di tab **Jelajah Course**, Anda dapat menemukan kelas gratis atau premium, lalu klik tombol ikuti untuk membuka simulasi pembayaran interaktif! 💳",
        target: "#tab-explore",
        face: "💡"
      },
      {
        text: "Klik **Mulai Belajar** pada course Anda untuk masuk ke **Ruang Kelas Virtual**. Anda bisa memutar video materi dan mengikuti materi yang diunggah. 📹",
        target: "[onclick*='openLearningRoom']",
        face: "👨‍🏫"
      },
      {
        text: "Setelah Anda menyelesaikan semua video di Ruang Belajar, Anda bisa langsung mengklaim **Sertifikat Kelulusan Resmi** dan memberikan rating bintang! 📜",
        target: "#tab-certificates",
        face: "🏆"
      }
    ];
  } else if (role === 'programmer') {
    buddyTour = [
      {
        text: "Selamat datang di **Dashboard Programmer**! Mari kita lihat kelengkapan akun Anda agar siap menerima project UMKM. 🧑‍💻",
        target: null,
        face: "🧑‍💻"
      },
      {
        text: "Ini adalah **Statistik Pendapatan & Project** Anda. Semua pendapatan dari project dikumpulkan secara transparan di sini. 💰",
        target: ".stats-grid",
        face: "📈"
      },
      {
        text: "Perhatikan **Kelengkapan Profil Verifikasi** Anda. Anda perlu mengunggah portofolio dan sertifikat hingga 100% agar diverifikasi admin dan mendapatkan hak membuat course! 📋",
        target: ".progress-bar",
        face: "⚙️"
      },
      {
        text: "Gunakan **Tab Menu** ini untuk berpindah antara Overview, Cari Project UMKM, Course Saya, dan menu Verifikasi dokumen. 🗂️",
        target: ".tab-bar",
        face: "🎯"
      },
      {
        text: "Setelah akun Anda diverifikasi oleh Admin, Anda bisa mengajukan penawaran (*bid*) harga dan durasi pengerjaan pada halaman **Cari Project**! 🤝",
        target: "#tab-projects",
        face: "💡"
      },
      {
        text: "Unggah karya terbaik Anda di tab **Verifikasi** dengan melampirkan berkas Portofolio dan Sertifikat pendukung agar dilirik oleh UMKM. 🗂️",
        target: "#tab-verification",
        face: "🛡️"
      },
      {
        text: "Jika verifikasi profil Anda sudah disetujui Admin, Anda dapat memposting video materi dan membuat kelas baru di tab **Course Saya**! 📚",
        target: "#tab-courses",
        face: "✨"
      },
      {
        text: "Gunakan tombol **Diskusi / Chat** untuk bernegosiasi mengenai spesifikasi dan biaya project dengan UMKM secara real-time. 💬",
        target: "[onclick*='openChat']",
        face: "💬"
      }
    ];
  } else if (role === 'umkm') {
    buddyTour = [
      {
        text: "Selamat datang di **Dashboard UMKM**! Di sini Anda dapat memposting project digital dan merekrut programmer profesional. 🏢",
        target: null,
        face: "🏢"
      },
      {
        text: "Ini adalah **Ringkasan Project** Anda. Anda bisa memantau project yang sedang menunggu antrean, berjalan, atau sudah selesai. 📊",
        target: ".stats-grid",
        face: "📈"
      },
      {
        text: "Klik **Posting Project Baru** untuk membuat tawaran pekerjaan. Deskripsikan kebutuhan sistem Anda dengan jelas (min. 50 karakter) agar programmer tertarik. 📝",
        target: "#utab-posting",
        face: "💡"
      },
      {
        text: "Di tab **Project Saya**, Anda dapat melihat penawaran masuk dari programmer, berdiskusi via Chat negosiasi, dan menyetujui penawaran terpilih! 💬",
        target: "#utab-projects",
        face: "🤝"
      },
      {
        text: "Ingin mencari bakat secara langsung? Jelajahi daftar **Programmer Terverifikasi** untuk melihat profil, keahlian, dan portofolio mereka! 🔍",
        target: "#utab-programmers",
        face: "🔎"
      },
      {
        text: "Gunakan fitur **Chat Diskusi** di samping detail project Anda untuk melakukan tawar-menawar secara langsung dengan programmer pelamar. 💬",
        target: "[onclick*='openChat']",
        face: "💬"
      },
      {
        text: "Jika penawaran programmer cocok, klik **Terima Penawaran** untuk memulai kolaborasi. Jangan lupa beri rating review setelah project rampung! ⭐",
        target: "[onclick*='terima']",
        face: "🏆"
      }
    ];
  } else if (role === 'admin') {
    buddyTour = [
      {
        text: "Selamat datang di **Panel Administrasi**! Anda bertugas memverifikasi akun pengguna dan menyetujui postingan project baru. ⚙️",
        target: null,
        face: "⚡"
      },
      {
        text: "Gunakan **Statistik Utama** di atas untuk memantau performa platform: total user, project aktif, course terdaftar, dan revenue bagi hasil platform. 📊",
        target: ".stats-grid",
        face: "📈"
      },
      {
        text: "Periksa daftar **Persetujuan Project UMKM Baru**. Klik *ACC & Publikasikan* untuk meloloskan project agar dapat dilamar oleh Programmer! 📋",
        target: "#adminPendingProjectsCard",
        face: "🔍"
      },
      {
        text: "Periksa juga **Verifikasi Programmer & UMKM** yang tertunda. Verifikasi mereka jika dokumen yang dilampirkan sudah valid dan lengkap. ✅",
        target: "#adminPendingVerificationsGrid",
        face: "🛡️"
      },
      {
        text: "Tinjau berkas **Portofolio & Sertifikat** programmer yang menunggu validasi di sini untuk menaikkan persentase progres profil mereka. 🗂️",
        target: "#adminDocVerificationsCard",
        face: "📂"
      },
      {
        text: "Gunakan tombol navigasi **Users** di bar atas untuk memantau, mengaktifkan, atau mengelola seluruh akun yang terdaftar di sistem. 👥",
        target: "#admin-nav-users",
        face: "👥"
      },
      {
        text: "Kelola daftar **Courses** di bar atas untuk melihat, memvalidasi, atau meninjau modul pembelajaran yang dibuat oleh pengajar programmer. 📚",
        target: "#admin-nav-courses",
        face: "🎓"
      }
    ];
  } else {
    buddyTour = [
      {
        text: "Hai! Selamat datang di **BuilderHub**. Saya siap memandu Anda menelusuri halaman platform ini. 🚀",
        target: null,
        face: "👋"
      },
      {
        text: "Silakan gunakan menu navigasi di atas untuk menjelajahi **Project UMKM**, daftar **Course** pembelajaran, atau mendaftar akun baru! 💡",
        target: ".navbar-inner",
        face: "🎯"
      }
    ];
  }
}

function toggleBuddy() {
  if (sessionStorage.getItem('ai_tour_finished') === 'true') return;
  const bubble = document.getElementById('buddyBubble');
  if (bubble.classList.contains('active') && document.getElementById('buddyStep').textContent !== '') {
    closeBuddy();
  } else {
    initBuddyTour();
    buddyCurrentStep = 0;
    showBuddyStep();
  }
}

function showBuddyStep() {
  const bubble = document.getElementById('buddyBubble');
  const textEl = document.getElementById('buddyText');
  const stepEl = document.getElementById('buddyStep');
  const faceEl = document.getElementById('buddyFace');
  const prevBtn = document.getElementById('buddyPrevBtn');
  const nextBtn = document.getElementById('buddyNextBtn');
  const pulseEl = document.getElementById('buddyPulse');
  
  if (buddyTour.length === 0) return;
  
  const step = buddyTour[buddyCurrentStep];
  
  // Clean previous highlights
  document.querySelectorAll('.buddy-highlight').forEach(el => {
    el.style.outline = '';
    el.style.outlineOffset = '';
    el.classList.remove('buddy-highlight');
  });
  
  // Format markdown-like text to HTML
  let formattedText = step.text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
  textEl.innerHTML = formattedText;
  faceEl.textContent = step.face || '🤖';
  stepEl.textContent = `${buddyCurrentStep + 1} / ${buddyTour.length}`;
  
  // Handle highlight target
  if (step.target) {
    const targetEl = document.querySelector(step.target);
    if (targetEl) {
      targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
      targetEl.style.outline = '3px solid #4F46E5';
      targetEl.style.outlineOffset = '6px';
      targetEl.classList.add('buddy-highlight');
    }
  }
  
  prevBtn.style.display = buddyCurrentStep > 0 ? 'inline-block' : 'none';
  nextBtn.style.display = 'inline-block';
  nextBtn.textContent = buddyCurrentStep === buddyTour.length - 1 ? 'Selesai' : 'Lanjut';
  
  // Hide pulsing badge while guide is active/opened
  if (pulseEl) pulseEl.style.opacity = '0';
  
  bubble.classList.remove('closing');
  bubble.classList.add('active');
}

function buddyNext() {
  if (buddyCurrentStep < buddyTour.length - 1) {
    buddyCurrentStep++;
    showBuddyStep();
  } else {
    finishBuddyTour();
  }
}

function buddyPrev() {
  if (buddyCurrentStep > 0) {
    buddyCurrentStep--;
    showBuddyStep();
  }
}

function closeBuddy() {
  const bubble = document.getElementById('buddyBubble');
  bubble.classList.remove('active');
  bubble.classList.add('closing');
  
  const pulseEl = document.getElementById('buddyPulse');
  if (pulseEl) pulseEl.style.opacity = '1';
  
  // Clean highlight
  document.querySelectorAll('.buddy-highlight').forEach(el => {
    el.style.outline = '';
    el.style.outlineOffset = '';
    el.classList.remove('buddy-highlight');
  });
}

function finishBuddyTour() {
  sessionStorage.setItem('ai_tour_finished', 'true');
  const container = document.getElementById('buddyMascot');
  if (container) {
    container.classList.add('buddy-fallen');
    setTimeout(() => {
      container.style.display = 'none';
    }, 1200);
  }
  document.querySelectorAll('.buddy-highlight').forEach(el => {
    el.style.outline = '';
    el.style.outlineOffset = '';
    el.classList.remove('buddy-highlight');
  });
}

// Automatically welcome user with a tiny floating tip after 3 seconds
window.checkMascotVisibility = function(activeTabName) {
  const mascot = document.getElementById('buddyMascot');
  if (!mascot) return;
  
  const tab = activeTabName || window.location.hash.replace('#', '') || 'overview';
  
  if (tab === 'overview' || tab === 'my-courses') {
    if (sessionStorage.getItem('ai_tour_finished') !== 'true') {
      mascot.style.display = 'flex';
    }
  } else {
    mascot.style.display = 'none';
    const bubble = document.getElementById('buddyBubble');
    if (bubble) {
      bubble.classList.remove('active');
      bubble.classList.add('closing');
    }
  }
};

// Automatically welcome user with a tiny floating tip after 3 seconds
window.addEventListener('load', () => {
  if (sessionStorage.getItem('ai_tour_finished') === 'true') {
    const container = document.getElementById('buddyMascot');
    if (container) container.style.display = 'none';
    return;
  }
  
  // Running the visibility check on load based on current hash
  window.checkMascotVisibility();
  
  setTimeout(() => {
    const bubble = document.getElementById('buddyBubble');
    const hash = window.location.hash.replace('#', '') || 'overview';
    
    // Only show welcome tip if on overview/my-courses tab and bubble is not already active
    if ((hash === 'overview' || hash === 'my-courses') && bubble && !bubble.classList.contains('active')) {
      const textEl = document.getElementById('buddyText');
      textEl.innerHTML = "Butuh bantuan memahami halaman ini? **Klik saya** untuk panduan interaktif! 👋";
      document.getElementById('buddyFace').textContent = "👋";
      document.getElementById('buddyStep').textContent = "";
      document.getElementById('buddyPrevBtn').style.display = 'none';
      document.getElementById('buddyNextBtn').style.display = 'none';
      
      const pulseEl = document.getElementById('buddyPulse');
      if (pulseEl) pulseEl.style.opacity = '1';
      
      bubble.classList.remove('closing');
      bubble.classList.add('active');
    }
  }, 3000);
});

// Intercept logout forms and clear sessionStorage to reset tour guide
document.addEventListener('submit', function(e) {
  if (e.target && e.target.action && e.target.action.includes('logout')) {
    sessionStorage.removeItem('ai_tour_finished');
  }
});
</script>
@endauth

@stack('scripts')
<script>
// IMK: Auto-dismiss alerts
document.querySelectorAll('.alert').forEach(el=>{
  setTimeout(()=>el.closest('div')?.remove(), 4500);
});

window.toggleDesc = function(btn) {
  const shortEl = btn.previousElementSibling.previousElementSibling;
  const fullEl = btn.previousElementSibling;
  if (fullEl.style.display === 'none') {
    fullEl.style.display = 'inline';
    shortEl.style.display = 'none';
    btn.textContent = 'Sembunyikan';
  } else {
    fullEl.style.display = 'none';
    shortEl.style.display = 'inline';
    btn.textContent = 'Selengkapnya';
  }
};
</script>
</body>
</html>
