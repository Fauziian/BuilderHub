@extends('layouts.app')
@section('title', 'Transformasi ke Programmer')
@section('content')
<div style="background:linear-gradient(135deg, #0A0A14 0%, #17103C 50%, #090518 100%);min-height:100vh;color:#fff;padding:3rem 2rem;position:relative">
  <div style="position:absolute;inset:0;background:radial-gradient(circle at 20% 30%, rgba(139, 92, 246, 0.15) 0%, rgba(79, 70, 229, 0.1) 40%, transparent 70%);pointer-events:none"></div>
  
  <div style="max-width:800px;margin:0 auto;position:relative;z-index:1">
    <!-- Back to Dashboard -->
    <a href="{{ route('course.dashboard') }}" style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,0.7);text-decoration:none;font-size:0.875rem;font-weight:600;margin-bottom:1.5rem;transition:color 0.2s" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">
      ⬅ Kembali ke Dashboard Pelajar
    </a>

    <!-- Header Section -->
    <div style="text-align:center;margin-bottom:3rem">
      <div style="display:inline-block;background:linear-gradient(90deg, #8B5CF6, #EC4899);padding:6px 16px;border-radius:99px;font-size:0.8rem;font-weight:800;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem;box-shadow:0 4px 12px rgba(139, 92, 246, 0.3)">
        🚀 Transformasi Karir
      </div>
      <h1 style="font-size:2.25rem;font-weight:800;letter-spacing:-0.5px;background:linear-gradient(to right, #fff, rgba(255,255,255,0.7));-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:0.5rem">
        Upgrade Akun Anda Menjadi Programmer
      </h1>
      <p style="font-size:1rem;color:rgba(255,255,255,0.6);max-width:600px;margin:0 auto;line-height:1.6">
        Langkah akhir perjuangan belajar Anda. Gunakan sertifikat kelulusan BuilderHub Anda untuk mulai mengambil project real dan menghasilkan uang dari UMKM!
      </p>
    </div>

    <!-- Transformation Visual Timeline (Dinamis Sesuai Progress Belajar Nyata!) -->
    <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:var(--radius-xl);padding:1.5rem;margin-bottom:2.5rem;backdrop-filter:blur(10px)">
      <h3 style="font-size:0.95rem;font-weight:800;color:#A5B4FC;text-transform:uppercase;letter-spacing:1px;margin-bottom:1.25rem;text-align:center">
        Status Perjalanan Karir Anda 🗺️
      </h3>
      <div style="display:flex;justify-content:space-between;align-items:center;gap:0.5rem;flex-wrap:wrap">
        
        <!-- Step 1: Pelajar Aktif -->
        <div style="text-align:center;flex:1;min-width:110px">
          @if($hasEnrollments)
            <div style="width:44px;height:44px;border-radius:50%;background:rgba(16, 185, 129, 0.15);border:2px solid #10B981;color:#10B981;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin:0 auto 0.5rem;font-weight:700">✓</div>
            <div style="font-size:0.75rem;font-weight:700;color:#10B981">1. Pelajar Aktif</div>
            <div style="font-size:0.65rem;color:rgba(16, 185, 129, 0.85);margin-top:2px;font-weight:600">Mulai Belajar</div>
          @else
            <div style="width:44px;height:44px;border-radius:50%;background:rgba(245, 158, 11, 0.15);border:2px solid #F59E0B;color:#F59E0B;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin:0 auto 0.5rem;font-weight:700;animation:pulseActiveStep 2s infinite">🎓</div>
            <div style="font-size:0.75rem;font-weight:800;color:#FBBF24">1. Pelajar Aktif</div>
            <div style="font-size:0.65rem;color:#FBBF24;margin-top:2px;font-weight:600">Proses Saat Ini</div>
          @endif
        </div>
        
        <!-- Arrow -->
        <div style="font-size:1.2rem;color:{{ $hasEnrollments ? '#10B981' : 'rgba(255,255,255,0.15)' }};font-weight:700;margin-bottom:1rem">➔</div>
        
        <!-- Step 2: Lulus & Sertifikat -->
        <div style="text-align:center;flex:1;min-width:110px">
          @if($hasCompletedCourse)
            <div style="width:44px;height:44px;border-radius:50%;background:rgba(16, 185, 129, 0.15);border:2px solid #10B981;color:#10B981;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin:0 auto 0.5rem;font-weight:700">✓</div>
            <div style="font-size:0.75rem;font-weight:700;color:#10B981">2. Lulus & Sertifikat</div>
            <div style="font-size:0.65rem;color:rgba(16, 185, 129, 0.85);margin-top:2px;font-weight:600">Lulus Course</div>
          @elseif($hasEnrollments)
            <div style="width:44px;height:44px;border-radius:50%;background:rgba(239, 68, 68, 0.15);border:2px solid #EF4444;color:#EF4444;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin:0 auto 0.5rem;font-weight:700;animation:pulseActiveStep 2s infinite">📜</div>
            <div style="font-size:0.75rem;font-weight:800;color:#FCA5A5">2. Lulus & Sertifikat</div>
            <div style="font-size:0.65rem;color:#FCA5A5;margin-top:2px;font-weight:600">Proses Saat Ini</div>
          @else
            <div style="width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,0.05);border:2px dashed rgba(255,255,255,0.2);color:rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin:0 auto 0.5rem;font-weight:700">🔒</div>
            <div style="font-size:0.75rem;font-weight:700;color:rgba(255,255,255,0.4)">2. Lulus & Sertifikat</div>
            <div style="font-size:0.65rem;color:rgba(255,255,255,0.3);margin-top:2px">Belum Lulus</div>
          @endif
        </div>
        
        <!-- Arrow -->
        <div style="font-size:1.2rem;color:{{ $hasCompletedCourse ? '#10B981' : 'rgba(255,255,255,0.15)' }};font-weight:700;margin-bottom:1rem">➔</div>
        
        <!-- Step 3: Upgrade Akun -->
        <div style="text-align:center;flex:1;min-width:110px;position:relative">
          @if($hasCompletedCourse)
            <div style="width:44px;height:44px;border-radius:50%;background:#8B5CF6;color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin:0 auto 0.5rem;font-weight:700;box-shadow:0 0 15px rgba(139, 92, 246, 0.5);animation:pulseUpgrade 2s infinite">🚀</div>
            <div style="font-size:0.75rem;font-weight:800;color:#C7D2FE">3. Upgrade Akun</div>
            <div style="font-size:0.65rem;color:#A5B4FC;margin-top:2px;font-weight:600">Proses Saat Ini</div>
          @else
            <div style="width:44px;height:44px;border-radius:50%;background:rgba(245, 158, 11, 0.15);border:2px solid #F59E0B;color:#F59E0B;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin:0 auto 0.5rem;font-weight:700;box-shadow:0 0 10px rgba(245, 158, 11, 0.2)">⚠️</div>
            <div style="font-size:0.75rem;font-weight:800;color:#FBBF24">3. Upgrade Akun</div>
            <div style="font-size:0.65rem;color:#FBBF24;margin-top:2px;font-weight:600">Lewati via Eksternal</div>
          @endif
        </div>
        
        <!-- Arrow -->
        <div style="font-size:1.2rem;color:rgba(255,255,255,0.15);font-weight:700;margin-bottom:1rem">➔</div>
        
        <!-- Step 4: Verifikasi -->
        <div style="text-align:center;flex:1;min-width:110px">
          <div style="width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,0.05);border:2px dashed rgba(255,255,255,0.2);color:rgba(255,255,255,0.4);display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin:0 auto 0.5rem;font-weight:700">⏳</div>
          <div style="font-size:0.75rem;font-weight:700;color:rgba(255,255,255,0.4)">4. Verifikasi</div>
          <div style="font-size:0.65rem;color:rgba(255,255,255,0.3);margin-top:2px">Ditinjau Admin</div>
        </div>
        
        <!-- Arrow -->
        <div style="font-size:1.2rem;color:rgba(255,255,255,0.15);font-weight:700;margin-bottom:1rem">➔</div>
        
        <!-- Step 5: Programmer -->
        <div style="text-align:center;flex:1;min-width:110px">
          <div style="width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,0.05);border:2px dashed rgba(255,255,255,0.2);color:rgba(255,255,255,0.4);display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin:0 auto 0.5rem;font-weight:700">💼</div>
          <div style="font-size:0.75rem;font-weight:700;color:rgba(255,255,255,0.4)">5. Programmer</div>
          <div style="font-size:0.65rem;color:rgba(255,255,255,0.3);margin-top:2px">Ambil Project Real</div>
        </div>
      </div>
    </div>

    <!-- Main Upgrade Form Card -->
    <div style="background:rgba(20, 15, 45, 0.6);border:1px solid rgba(139, 92, 246, 0.2);border-radius:var(--radius-2xl);box-shadow:0 20px 50px rgba(0,0,0,0.5);padding:2.5rem;backdrop-filter:blur(20px)">
      <h2 style="font-size:1.25rem;font-weight:800;color:#fff;margin-bottom:1.5rem;display:flex;align-items:center;gap:8px">
        <span>📝</span> Lengkapi Data Diri & Dokumen Sah
      </h2>

      @if ($errors->any())
        <div style="background:rgba(239, 68, 68, 0.1);border:1px solid rgba(239, 68, 68, 0.3);border-radius:var(--radius);padding:1rem;margin-bottom:1.5rem;color:#FCA5A5;font-size:0.85rem">
          <strong style="display:block;margin-bottom:0.4rem">⚠ Mohon perbaiki beberapa kesalahan berikut:</strong>
          <ul style="margin-left:1.25rem;list-style-type:disc">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('course.upgrade-programmer.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 1. IDENTITAS -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem">
          <div class="form-group" style="margin:0">
            <label for="ktp_number" class="form-label" style="color:rgba(255,255,255,0.85);font-size:0.85rem;font-weight:600;margin-bottom:0.4rem;display:block">Nomor KTP <span style="color:var(--red)">*</span></label>
            <input type="text" id="ktp_number" name="ktp_number" class="form-input" placeholder="16 digit nomor KTP" value="{{ old('ktp_number') }}" maxlength="16" required style="background:rgba(0,0,0,0.3);border-color:rgba(255,255,255,0.1);color:#fff">
          </div>
          <div class="form-group" style="margin:0">
            <label for="ktp_photo" class="form-label" style="color:rgba(255,255,255,0.85);font-size:0.85rem;font-weight:600;margin-bottom:0.4rem;display:block">Upload Foto KTP <span style="color:var(--red)">*</span></label>
            <input type="file" id="ktp_photo" name="ktp_photo" class="form-input" accept="image/*" required onchange="previewKtpImage(event)" style="background:rgba(0,0,0,0.3);border-color:rgba(255,255,255,0.1);color:#fff">
            <small style="color:rgba(255,255,255,0.4);font-size:0.7rem;display:block;margin-top:4px">Format gambar (.jpg, .jpeg, .png), maks. 2MB</small>
          </div>
        </div>

        <!-- KTP Preview Container -->
        <div id="ktp_preview_container" style="display:none;margin-bottom:1.5rem;text-align:center;background:rgba(0,0,0,0.2);padding:10px;border-radius:var(--radius);border:1px dashed rgba(255,255,255,0.1)">
          <span style="font-size:0.75rem;color:rgba(255,255,255,0.5);display:block;margin-bottom:5px">Pratinjau KTP Anda:</span>
          <img id="ktp_preview_img" style="max-height:140px;border-radius:4px;border:1px solid rgba(255,255,255,0.2)">
        </div>

        <!-- 2. DOKUMEN CV -->
        <div class="form-group" style="margin-bottom:1.5rem">
          <label for="cv_file" class="form-label" style="color:rgba(255,255,255,0.85);font-size:0.85rem;font-weight:600;margin-bottom:0.4rem;display:block">Dokumen CV (Curriculum Vitae) <span style="color:var(--red)">*</span></label>
          <input type="file" id="cv_file" name="cv_file" class="form-input" accept=".pdf,.doc,.docx" required style="background:rgba(0,0,0,0.3);border-color:rgba(255,255,255,0.1);color:#fff">
          <small style="color:rgba(255,255,255,0.4);font-size:0.7rem;display:block;margin-top:4px">Unggah CV terbaik Anda (.pdf, .doc, .docx), maks. 3MB</small>
        </div>

        <!-- 3. KEAHLIAN & BIO -->
        <div class="form-group" style="margin-bottom:1.25rem">
          <label for="expertise" class="form-label" style="color:rgba(255,255,255,0.85);font-size:0.85rem;font-weight:600;margin-bottom:0.4rem;display:block">Bidang Keahlian (pisahkan dengan koma) <span style="color:var(--red)">*</span></label>
          <input type="text" id="expertise" name="expertise" class="form-input" placeholder="Contoh: Laravel, React, Vue, Python" value="{{ old('expertise', $user->expertise) }}" required style="background:rgba(0,0,0,0.3);border-color:rgba(255,255,255,0.1);color:#fff">
        </div>

        <div class="form-group" style="margin-bottom:1.75rem">
          <label for="bio" class="form-label" style="color:rgba(255,255,255,0.85);font-size:0.85rem;font-weight:600;margin-bottom:0.4rem;display:block">Bio / Deskripsi Diri Singkat <span style="color:var(--red)">*</span></label>
          <textarea id="bio" name="bio" class="form-textarea" style="min-height:90px;padding:.6rem .75rem;border:1px solid rgba(255,255,255,0.1);border-radius:var(--radius);font-size:.875rem;color:#fff;background:rgba(0,0,0,0.3);width:100%;resize:vertical;font-family:inherit;outline:none" placeholder="Ceritakan latar belakang, keahlian, dan motivasi Anda untuk mengambil project..." required>{{ old('bio', $user->bio) }}</textarea>
          <small style="color:rgba(255,255,255,0.4);font-size:0.7rem;display:block;margin-top:4px">Minimal 20 karakter</small>
        </div>

        <!-- 4. SERTIFIKAT KELULUSAN (INTEGRASI ALUR) -->
        <div style="background:rgba(139, 92, 246, 0.05);border:1px solid rgba(139, 92, 246, 0.2);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:2rem">
          <h3 style="font-size:0.95rem;font-weight:800;color:#C084FC;margin-bottom:0.75rem;display:flex;align-items:center;gap:6px">
            <span>📜</span> Pilih Sertifikat Kompetensi Utama
          </h3>
          <p style="font-size:0.8rem;color:rgba(255,255,255,0.6);margin-bottom:1rem;line-height:1.4">
            Sebagai syarat mendaftar sebagai Programmer, Anda wajib menyertakan minimal 1 Sertifikat. Anda dapat menggunakan sertifikat kelulusan course yang Anda selesaikan di BuilderHub, atau mengunggah sertifikat eksternal Anda.
          </p>

          <div style="display:flex;flex-direction:column;gap:0.75rem">
            <!-- BuilderHub Certificates (Jika Ada) -->
            @forelse($completedEnrollments as $enroll)
              <label style="display:flex;align-items:center;gap:10px;background:rgba(0,0,0,0.2);border:1.5px solid rgba(139, 92, 246, 0.3);padding:0.85rem;border-radius:var(--radius);cursor:pointer;transition:all 0.2s" onmouseover="this.style.borderColor='#8B5CF6'" onmouseout="this.style.borderColor='rgba(139, 92, 246, 0.3)'">
                <input type="radio" name="certificate_choice" value="builderhub_{{ $enroll->course->id }}" checked onchange="toggleCertFields('builderhub')">
                <div style="flex:1">
                  <div style="font-size:0.82rem;font-weight:700;color:#fff">🏅 Sertifikat BuilderHub: {{ $enroll->course->title }}</div>
                  <div style="font-size:0.7rem;color:rgba(255,255,255,0.5)">Diterbitkan oleh: Instruktur {{ $enroll->course->instructor->name }} · Lulus pada {{ $enroll->updated_at->format('d M Y') }}</div>
                </div>
                <span style="font-size:0.65rem;font-weight:800;padding:2px 8px;border-radius:99px;background:#D1FAE5;color:#065F46">TERVERIFIKASI ✓</span>
              </label>
              <!-- Hidden input to store selected course ID -->
              <input type="hidden" name="builderhub_certificate" id="builderhub_cert_input" value="{{ $enroll->course->id }}">
            @empty
              <!-- Jika belum punya sertifikat BuilderHub -->
              <div style="background:rgba(245, 158, 11, 0.1);border:1px solid rgba(245, 158, 11, 0.2);border-radius:var(--radius-sm);padding:0.75rem;font-size:0.78rem;color:#FBBF24;margin-bottom:0.5rem;line-height:1.4">
                💡 <strong>Rekomendasi Dosen:</strong> Anda belum memiliki Sertifikat Kelulusan dari course BuilderHub. Anda tetap dapat mengajukan upgrade dengan menggunakan <strong>Sertifikat Eksternal</strong> di bawah. Namun, lulus course di platform ini memberikan peluang verifikasi disetujui lebih cepat!
              </div>
            @endforelse

            <!-- External Certificate Option -->
            <label style="display:flex;align-items:center;gap:10px;background:rgba(0,0,0,0.2);border:1.5px solid rgba(255,255,255,0.08);padding:0.85rem;border-radius:var(--radius);cursor:pointer;transition:all 0.2s" id="external_cert_label" onmouseover="this.style.borderColor='rgba(255,255,255,0.2)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'">
              <input type="radio" name="certificate_choice" value="external" @if($completedEnrollments->isEmpty()) checked @endif onchange="toggleCertFields('external')">
              <div style="flex:1">
                <div style="font-size:0.82rem;font-weight:700;color:#fff">📂 Gunakan Sertifikat Kompetensi Eksternal</div>
                <div style="font-size:0.7rem;color:rgba(255,255,255,0.5)">Unggah sertifikat keahlian eksternal Anda sendiri</div>
              </div>
            </label>
          </div>

          <!-- Dynamic External Certificate Upload Field -->
          <div id="external_upload_section" style="margin-top:1.25rem;padding-top:1.25rem;border-top:1px dashed rgba(255,255,255,0.1);@if(!$completedEnrollments->isEmpty()) display:none @endif">
            <div class="form-group" style="margin-bottom:1rem">
              <label for="external_certificate_name" class="form-label" style="color:rgba(255,255,255,0.85);font-size:0.8rem;font-weight:600;margin-bottom:0.4rem;display:block">Nama Sertifikat Eksternal <span style="color:var(--red)">*</span></label>
              <input type="text" id="external_certificate_name" name="external_certificate_name" class="form-input" placeholder="Contoh: AWS Certified Solutions Architect" style="background:rgba(0,0,0,0.3);border-color:rgba(255,255,255,0.1);color:#fff" value="{{ old('external_certificate_name') }}">
            </div>
            <div class="form-group" style="margin-bottom:1rem">
              <label for="external_certificate_issuer" class="form-label" style="color:rgba(255,255,255,0.85);font-size:0.8rem;font-weight:600;margin-bottom:0.4rem;display:block">Penerbit Sertifikat <span style="color:var(--red)">*</span></label>
              <input type="text" id="external_certificate_issuer" name="external_certificate_issuer" class="form-input" placeholder="Contoh: Amazon Web Services" style="background:rgba(0,0,0,0.3);border-color:rgba(255,255,255,0.1);color:#fff" value="{{ old('external_certificate_issuer') }}">
            </div>
            <div class="form-group" style="margin-bottom:1rem">
              <label for="external_certificate_date" class="form-label" style="color:rgba(255,255,255,0.85);font-size:0.8rem;font-weight:600;margin-bottom:0.4rem;display:block">Tanggal Terbit Sertifikat <span style="color:var(--red)">*</span></label>
              <input type="date" id="external_certificate_date" name="external_certificate_date" class="form-input" style="background:rgba(0,0,0,0.3);border-color:rgba(255,255,255,0.1);color:#fff" value="{{ old('external_certificate_date') }}">
            </div>
            <div class="form-group" style="margin:0">
              <label for="external_certificate" class="form-label" style="color:rgba(255,255,255,0.85);font-size:0.8rem;font-weight:600;margin-bottom:0.4rem;display:block">File Sertifikat Eksternal <span style="color:var(--red)">*</span></label>
              <input type="file" id="external_certificate" name="external_certificate" class="form-input" accept=".pdf,image/*" style="background:rgba(0,0,0,0.3);border-color:rgba(255,255,255,0.1);color:#fff">
              <small style="color:rgba(255,255,255,0.4);font-size:0.7rem;display:block;margin-top:4px">Unggah berkas sertifikat pendukung (.pdf, gambar), maks. 3MB</small>
            </div>
          </div>
        </div>

        <!-- Submit Panel -->
        <div style="display:flex;gap:1rem;margin-top:2rem">
          <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;font-size:0.95rem;font-weight:700;padding:12px;background:linear-gradient(90deg, #6366F1, #8B5CF6);border:none;box-shadow:0 8px 20px rgba(99, 102, 241, 0.3)">
            Kirim Pengajuan Transformasi & Upgrade 🚀
          </button>
          <a href="{{ route('course.dashboard') }}" class="btn btn-ghost" style="padding:12px 20px;display:inline-flex;align-items:center;justify-content:center;font-weight:600;border-color:rgba(255,255,255,0.15)">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

@push('styles')
<style>
@keyframes pulseUpgrade {
  0%, 100% { transform: scale(1); box-shadow: 0 0 10px rgba(139, 92, 246, 0.4); }
  50% { transform: scale(1.08); box-shadow: 0 0 22px rgba(139, 92, 246, 0.75); }
}
@keyframes pulseActiveStep {
  0%, 100% { transform: scale(1); box-shadow: 0 0 8px rgba(245, 158, 11, 0.3); }
  50% { transform: scale(1.06); box-shadow: 0 0 18px rgba(245, 158, 11, 0.6); }
}
</style>
@endpush

@push('scripts')
<script>
function previewKtpImage(event) {
  const reader = new FileReader();
  reader.onload = function() {
    const previewContainer = document.getElementById('ktp_preview_container');
    const previewImg = document.getElementById('ktp_preview_img');
    if (previewContainer && previewImg) {
      previewImg.src = reader.result;
      previewContainer.style.display = 'block';
    }
  }
  if (event.target.files[0]) {
    reader.readAsDataURL(event.target.files[0]);
  }
}

function toggleCertFields(choice) {
  const uploadSection = document.getElementById('external_upload_section');
  const externalInput = document.getElementById('external_certificate');
  const externalName = document.getElementById('external_certificate_name');
  const externalIssuer = document.getElementById('external_certificate_issuer');
  const externalDate = document.getElementById('external_certificate_date');
  const builderhubCertInput = document.getElementById('builderhub_cert_input');
  
  if (choice === 'external') {
    if (uploadSection) uploadSection.style.display = 'block';
    if (externalInput) externalInput.required = true;
    if (externalName) externalName.required = true;
    if (externalIssuer) externalIssuer.required = true;
    if (externalDate) externalDate.required = true;
    // Disable builderhub cert input
    if (builderhubCertInput) builderhubCertInput.disabled = true;
  } else {
    if (uploadSection) uploadSection.style.display = 'none';
    if (externalInput) {
      externalInput.required = false;
      externalInput.value = ''; // clear value
    }
    if (externalName) {
      externalName.required = false;
      externalName.value = '';
    }
    if (externalIssuer) {
      externalIssuer.required = false;
      externalIssuer.value = '';
    }
    if (externalDate) {
      externalDate.required = false;
      externalDate.value = '';
    }
    // Enable builderhub cert input
    if (builderhubCertInput) builderhubCertInput.disabled = false;
  }
}

// Set initial required state for external certificate if selected
document.addEventListener('DOMContentLoaded', () => {
  const externalRadio = document.querySelector('input[name="certificate_choice"][value="external"]');
  if (externalRadio && externalRadio.checked) {
    toggleCertFields('external');
  } else {
    toggleCertFields('builderhub');
  }
});
</script>
@endpush
@endsection
