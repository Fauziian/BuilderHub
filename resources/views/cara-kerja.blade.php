@extends('layouts.app')
@section('title', 'Cara Kerja BuilderHub')
@section('content')
<div style="background:linear-gradient(135deg,#0F0F1A 0%,#1E1260 100%);padding:4rem 2rem;text-align:center">
  <div style="max-width:1200px;margin:0 auto">
    <div class="section-badge" style="margin-bottom:.75rem">📋 Panduan Lengkap</div>
    <h1 style="font-size:2.5rem;font-weight:800;color:#fff;margin-bottom:.75rem">Cara Kerja BuilderHub</h1>
    <p style="color:rgba(255,255,255,.7);font-size:1rem;max-width:500px;margin:0 auto">Mudah & transparan — alur yang jelas untuk UMKM dan Programmer</p>
  </div>
</div>
<section class="section">
  <div class="section-inner">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem">
      <div>
        <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:1.5rem;padding:10px 16px;background:var(--primary-light);color:var(--primary);border-radius:var(--radius-sm)">🏢 Alur untuk UMKM</h3>
        @foreach([['01','Daftar Akun UMKM','Lengkapi profil dan upload dokumen legalitas usaha (SIUP/NIB) untuk mendapat badge UMKM Verified.'],['02','Posting Project','Deskripsikan kebutuhan digital bisnis Anda beserta budget dan deadline yang jelas.'],['03','Pilih Programmer','Terima penawaran dari programmer, review portofolio dan pilih yang terbaik sesuai kebutuhan.'],['04','Monitor & Terima','Pantau progress project dan lakukan pembayaran saat selesai sesuai kesepakatan.']] as [$num,$title,$desc])
        <div style="display:flex;gap:1rem;margin-bottom:1.25rem;align-items:flex-start">
          <div style="width:36px;height:36px;border-radius:50%;background:var(--primary);color:#fff;font-weight:800;font-size:.9rem;display:flex;align-items:center;justify-content:center;flex-shrink:0">{{ $num }}</div>
          <div><h4 style="font-size:.95rem;font-weight:700;margin-bottom:.25rem">{{ $title }}</h4><p style="font-size:.85rem;color:var(--text2);line-height:1.6">{{ $desc }}</p></div>
        </div>
        @endforeach
      </div>
      <div>
        <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:1.5rem;padding:10px 16px;background:var(--primary-light);color:var(--primary);border-radius:var(--radius-sm)">&lt;/&gt; Alur untuk Programmer</h3>
        @foreach([['01','Daftar & Verifikasi','Isi biodata, upload sertifikat, dan portofolio untuk mendapatkan badge Terverifikasi dari BuilderHub.'],['02','Jelajahi Project','Browse project UMKM yang sesuai skill dan budget yang Anda inginkan dengan filter canggih.'],['03','Ajukan Penawaran','Kirim bid dengan harga dan timeline yang Anda tawarkan kepada UMKM secara transparan.'],['04','Kerjakan & Terima Bayaran','Selesaikan project dan terima 20% dari nilai project langsung ke rekening Anda.']] as [$num,$title,$desc])
        <div style="display:flex;gap:1rem;margin-bottom:1.25rem;align-items:flex-start">
          <div style="width:36px;height:36px;border-radius:50%;background:var(--primary);color:#fff;font-weight:800;font-size:.9rem;display:flex;align-items:center;justify-content:center;flex-shrink:0">{{ $num }}</div>
          <div><h4 style="font-size:.95rem;font-weight:700;margin-bottom:.25rem">{{ $title }}</h4><p style="font-size:.85rem;color:var(--text2);line-height:1.6">{{ $desc }}</p></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
<section id="harga" class="section" style="background:var(--bg2)">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">💰 Komisi & Pembagian</div>
      <h2>Transparan, Adil, dan Menguntungkan</h2>
      <p class="lead">Sistem pembagian komisi yang jelas dan tidak ada biaya tersembunyi</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:0;margin:2rem 0">
      <div style="padding:2rem;text-align:center;border:1px solid var(--border);border-radius:var(--radius-lg) 0 0 var(--radius-lg)"><div style="font-size:2.5rem;font-weight:800">100%</div><div style="font-size:.95rem;font-weight:700;margin-bottom:.25rem">UMKM Membayar</div><div style="font-size:.82rem;color:var(--text2)">Total nilai project yang disepakati</div></div>
      <div style="padding:2rem;text-align:center;background:var(--bg3);border:1px solid var(--border)"><div style="font-size:2.5rem;font-weight:800;color:var(--text3)">80%</div><div style="font-size:.95rem;font-weight:700;margin-bottom:.25rem">Platform BuilderHub</div><div style="font-size:.82rem;color:var(--text2)">Untuk operasional & pengembangan</div></div>
      <div style="padding:2rem;text-align:center;background:var(--green-light);border:1px solid var(--border);border-radius:0 var(--radius-lg) var(--radius-lg) 0"><div style="font-size:2.5rem;font-weight:800;color:var(--green)">20%</div><div style="font-size:.95rem;font-weight:700;margin-bottom:.25rem">Programmer Terima</div><div style="font-size:.82rem;color:var(--text2)">Langsung ke rekening programmer</div></div>
    </div>
    <div style="background:var(--bg);border-radius:var(--radius-xl);padding:2rem;border:1px solid var(--border);max-width:500px;margin:0 auto">
      <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem">📊 Contoh: Project senilai <strong style="color:var(--primary)">Rp 5.000.000</strong></h3>
      <div style="display:flex;justify-content:space-between;padding:.5rem 0;border-bottom:1px solid var(--border);font-size:.875rem"><span>Total nilai project</span><span><strong>Rp 5.000.000</strong></span></div>
      <div style="display:flex;justify-content:space-between;padding:.5rem 0;border-bottom:1px solid var(--border);font-size:.875rem"><span>Platform (80%)</span><span style="color:var(--text3)">- Rp 4.000.000</span></div>
      <div style="display:flex;justify-content:space-between;padding:.5rem 0;font-size:.875rem;color:var(--green);font-weight:700"><span>Programmer menerima (20%)</span><span>Rp 1.000.000</span></div>
    </div>
  </div>
</section>
<section class="section" style="background:linear-gradient(135deg,#0F0F1A,#1E1260);text-align:center">
  <div class="section-inner">
    <h2 style="color:#fff;font-size:2rem;margin-bottom:.75rem">Siap Memulai?</h2>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="{{ route('register') }}?role=umkm" class="btn btn-primary" style="font-size:.95rem;padding:12px 24px">Daftar sebagai UMKM</a>
      <a href="{{ route('register') }}?role=programmer" class="btn" style="background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.25);font-size:.95rem;padding:12px 24px">Daftar sebagai Programmer</a>
    </div>
  </div>
</section>
@endsection
