@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div style="min-height:calc(100vh - 64px);display:grid;grid-template-columns:1fr 1fr">
  <div style="background:linear-gradient(135deg,#1E1260 0%,#3D1FAF 100%);padding:3rem;display:flex;flex-direction:column;justify-content:center">
    <div style="display:flex;align-items:center;gap:10px;font-weight:800;font-size:1.1rem;color:#fff;margin-bottom:2rem">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 160" class="nav-logo-icon" aria-hidden="true" style="fill: none; width: 44px; height: 35px;">
        <defs>
          <linearGradient id="logo-grad-register" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="var(--primary)" />
            <stop offset="100%" stop-color="#8B5CF6" />
          </linearGradient>
        </defs>
        <path d="M 93 12 A 10 10 0 0 1 107 12 L 182 72 A 10 10 0 0 1 185 80 L 185 140 A 10 10 0 0 1 175 150 L 25 150 A 10 10 0 0 1 15 140 L 15 80 A 10 10 0 0 1 18 72 Z" fill="url(#logo-grad-register)" />
        <path d="M 85 45 L 75 51 L 85 57 M 115 45 L 125 51 L 115 57 M 105 40 L 95 62" stroke="#ffffff" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
        <path d="M 80 150 V 120 L 100 102 L 120 120 V 150 Z" fill="#ffffff" />
        <rect x="93" y="122" width="5" height="5" fill="url(#logo-grad-register)" rx="1.5" />
        <rect x="102" y="122" width="5" height="5" fill="url(#logo-grad-register)" rx="1.5" />
        <rect x="93" y="131" width="5" height="5" fill="url(#logo-grad-register)" rx="1.5" />
        <rect x="102" y="131" width="5" height="5" fill="url(#logo-grad-register)" rx="1.5" />
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
    <h2 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:.75rem">Bergabung dengan BuilderHub</h2>
    <p style="color:rgba(255,255,255,.7);font-size:.95rem;line-height:1.7;margin-bottom:2rem">Pilih peran Anda dan mulai perjalanan digital bersama ribuan pengguna aktif BuilderHub.</p>
    <!-- IMK: Role benefits explained before form - user makes informed decision -->
    <div style="display:flex;flex-direction:column;gap:.75rem">
      <div style="background:rgba(255,255,255,.08);border-radius:var(--radius);padding:.85rem 1rem">
        <div style="font-weight:700;color:#fff;margin-bottom:.25rem">&lt;/&gt; Programmer</div>
        <div style="font-size:.82rem;color:rgba(255,255,255,.7)">Ambil project UMKM & dapatkan 20% komisi + buat course</div>
      </div>
      <div style="background:rgba(255,255,255,.08);border-radius:var(--radius);padding:.85rem 1rem">
        <div style="font-weight:700;color:#fff;margin-bottom:.25rem">🏢 UMKM</div>
        <div style="font-size:.82rem;color:rgba(255,255,255,.7)">Posting project & temukan programmer terverifikasi</div>
      </div>
      <div style="background:rgba(255,255,255,.08);border-radius:var(--radius);padding:.85rem 1rem">
        <div style="font-weight:700;color:#fff;margin-bottom:.25rem">📚 Pelajar / Student</div>
        <div style="font-size:.82rem;color:rgba(255,255,255,.7)">Pelajari materi ajaran yang diberikan oleh programmer professional</div>
      </div>
    </div>
  </div>

  <div style="background:var(--bg);display:flex;align-items:center;justify-content:center;padding:2rem 3rem;overflow-y:auto">
    <div style="width:100%;max-width:440px">
      <a href="{{ route('home') }}" style="font-size:.85rem;color:var(--text2);display:flex;align-items:center;gap:4px;margin-bottom:1.5rem">← Kembali ke Beranda</a>

      <h1 style="font-size:1.6rem;font-weight:800;margin-bottom:.25rem">Buat Akun Baru</h1>
      <p style="font-size:.9rem;color:var(--text2);margin-bottom:1.25rem">Isi data dengan benar untuk memulai</p>

      <div style="display:grid;grid-template-columns:1fr 1fr;border:1px solid var(--border);border-radius:var(--radius-sm);margin-bottom:1.25rem;overflow:hidden">
        <a href="{{ route('login') }}" style="padding:10px;text-align:center;font-size:.875rem;font-weight:500;color:var(--text2);display:block">Masuk</a>
        <div style="padding:10px;text-align:center;font-size:.875rem;font-weight:600;background:var(--primary);color:#fff">Daftar</div>
      </div>

      @if($errors->any())
      <div class="alert alert-error" role="alert">❌ {{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" novalidate aria-label="Form registrasi BuilderHub" id="registerForm">
        @csrf
        <!-- IMK: Role selection with clear visual differentiation -->
        <div style="margin-bottom:1.25rem">
          <p style="font-size:.82rem;font-weight:600;color:var(--text);margin-bottom:.5rem">Daftar sebagai <span style="color:var(--red)">*</span></p>
          <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.5rem" role="radiogroup" aria-label="Pilih peran">
            @foreach([['programmer','&lt;/&gt;','Programmer','Kerjakan project & buat course'],['umkm','🏢','UMKM / Bisnis','Posting project digital'],['course','📚','Pelajar','Pelajari course pemrograman']] as [$r, $icon, $label, $desc])
            <label style="border:1.5px solid {{ (old('role', request('role')) === $r) ? 'var(--primary)' : 'var(--border)' }};border-radius:var(--radius);padding:.75rem .5rem;text-align:center;cursor:pointer;transition:.15s;background:{{ (old('role', request('role')) === $r) ? 'var(--primary-light)' : 'var(--bg)' }}" id="label-{{ $r }}">
              <input type="radio" name="role" value="{{ $r }}" {{ old('role', request('role','programmer')) === $r ? 'checked' : '' }} style="display:none" onchange="selectRole('{{ $r }}')" aria-label="{{ $label }}">
              <span style="font-size:1.25rem;display:block;margin-bottom:.25rem">{!! $icon !!}</span>
              <span style="font-size:.8rem;font-weight:600;color:var(--text2);display:block">{{ $label }}</span>
              <span style="font-size:.68rem;color:var(--text3);display:block;margin-top:.25rem">{{ $desc }}</span>
            </label>
            @endforeach
          </div>
          @error('role')<div class="field-error">⚠ {{ $message }}</div>@enderror
        </div>

        <!-- IMK: Contextual help about selected role -->
        <div id="roleGuide" class="imk-guide" style="display:none">
          <div class="imk-guide-icon">💡</div>
          <div><div class="imk-guide-title" id="guideTitle"></div><div class="imk-guide-text" id="guideText"></div></div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="name" class="form-label">Nama Lengkap <span class="required">*</span></label>
            <input type="text" id="name" name="name" class="form-input {{ $errors->has('name') ? 'error' : '' }}"
              placeholder="Nama lengkap Anda" value="{{ old('name') }}" autocomplete="name" aria-required="true">
            @error('name')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="phone" class="form-label">Nomor HP</label>
            <input type="tel" id="phone" name="phone" class="form-input" placeholder="08xx-xxxx-xxxx" value="{{ old('phone') }}">
          </div>
        </div>

        <div class="form-group">
          <label for="email" class="form-label">Email <span class="required">*</span></label>
          <input type="email" id="email" name="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}"
            placeholder="nama@email.com" value="{{ old('email') }}" aria-required="true">
          @error('email')<div class="field-error">⚠ {{ $message }}</div>@enderror
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="password" class="form-label">Password <span class="required">*</span></label>
            <input type="password" id="password" name="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}"
              placeholder="Min. 6 karakter" aria-required="true" oninput="checkPwd(this.value)">
            <!-- IMK: Real-time password strength indicator -->
            <div id="pwdStrength" style="margin-top:.4rem;display:none">
              <div style="height:4px;background:var(--bg3);border-radius:99px"><div id="pwdBar" style="height:100%;border-radius:99px;transition:.3s;width:0%"></div></div>
              <div id="pwdLabel" style="font-size:.72rem;margin-top:.2rem;color:var(--text3)"></div>
            </div>
            @error('password')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="required">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
              placeholder="Ulangi password" oninput="checkMatch()">
            <div id="matchMsg" style="font-size:.72rem;margin-top:.2rem"></div>
          </div>
        </div>

        <div class="form-group">
          <label for="city" class="form-label">Kota</label>
          <input type="text" id="city" name="city" class="form-input" placeholder="Jakarta, Bandung, Surabaya..." value="{{ old('city') }}">
        </div>

        <!-- Programmer Extra Fields -->
        <div id="programmerFields" style="display:none">
          <div class="form-group">
            <label for="prog_ktp_number" class="form-label">Nomor KTP <span class="required">*</span></label>
            <input type="text" id="prog_ktp_number" name="ktp_number" class="form-input" placeholder="16 digit nomor KTP" value="{{ old('ktp_number') }}" maxlength="16">
            @error('ktp_number')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="prog_ktp_photo" class="form-label">Foto KTP <span class="required">*</span></label>
            <div style="display:flex;gap:10px;align-items:center">
              <input type="file" id="prog_ktp_photo" name="ktp_photo" class="form-input" accept="image/*" style="flex:1">
              <button type="button" class="btn btn-ghost btn-sm" onclick="openCameraScanner('prog_ktp_photo')" style="white-space:nowrap;display:flex;align-items:center;gap:6px;height:45px;padding:0 12px;border:1px dashed var(--primary);color:var(--primary);border-radius:var(--radius-sm)">
                📷 Ambil Foto
              </button>
            </div>
            <div id="preview-container-prog_ktp_photo" style="display:none;margin-top:8px;position:relative;width:100%;max-width:200px;border-radius:var(--radius-sm);overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-sm)">
              <img id="preview-prog_ktp_photo" src="" style="width:100%;display:block;object-fit:cover;aspect-ratio:4/3">
              <button type="button" onclick="clearCameraCapture('prog_ktp_photo')" style="position:absolute;right:5px;top:5px;background:rgba(239,68,68,0.9);color:white;border:none;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:10px" title="Hapus foto">✕</button>
            </div>
            <small style="color:var(--text3);font-size:.72rem;display:block;margin-top:2px">Format gambar (.jpg, .jpeg, .png), maks. 2MB</small>
            @error('ktp_photo')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="cv_file" class="form-label">Dokumen CV (Curriculum Vitae) <span class="required">*</span></label>
            <input type="file" id="cv_file" name="cv_file" class="form-input" accept=".pdf,.doc,.docx">
            <small style="color:var(--text3);font-size:.72rem;display:block;margin-top:2px">Format dokumen (.pdf, .doc, .docx), maks. 3MB</small>
            @error('cv_file')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="certificate_name" class="form-label">Nama Sertifikat Pertama <span class="required">*</span></label>
            <input type="text" id="certificate_name" name="certificate_name" class="form-input" placeholder="Contoh: Sertifikat Web Developer Professional" value="{{ old('certificate_name') }}">
            @error('certificate_name')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="certificate_issuer" class="form-label">Penerbit Sertifikat <span class="required">*</span></label>
            <input type="text" id="certificate_issuer" name="certificate_issuer" class="form-input" placeholder="Contoh: Google, Dicoding, LSP" value="{{ old('certificate_issuer') }}">
            @error('certificate_issuer')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="certificate_date" class="form-label">Tanggal Terbit Sertifikat <span class="required">*</span></label>
            <input type="date" id="certificate_date" name="certificate_date" class="form-input" value="{{ old('certificate_date') }}">
            @error('certificate_date')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="certificate_file" class="form-label">Sertifikat Pertama <span class="required">*</span></label>
            <div style="display:flex;gap:10px;align-items:center">
              <input type="file" id="certificate_file" name="certificate_file" class="form-input" accept=".pdf,image/*" style="flex:1">
              <button type="button" class="btn btn-ghost btn-sm" onclick="openCameraScanner('certificate_file')" style="white-space:nowrap;display:flex;align-items:center;gap:6px;height:45px;padding:0 12px;border:1px dashed var(--primary);color:var(--primary);border-radius:var(--radius-sm)">
                📷 Ambil Foto
              </button>
            </div>
            <div id="preview-container-certificate_file" style="display:none;margin-top:8px;position:relative;width:100%;max-width:200px;border-radius:var(--radius-sm);overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-sm)">
              <img id="preview-certificate_file" src="" style="width:100%;display:block;object-fit:cover;aspect-ratio:4/3">
              <button type="button" onclick="clearCameraCapture('certificate_file')" style="position:absolute;right:5px;top:5px;background:rgba(239,68,68,0.9);color:white;border:none;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:10px" title="Hapus foto">✕</button>
            </div>
            <small style="color:var(--text3);font-size:.72rem;display:block;margin-top:2px">Unggah sertifikat pendukung keahlian terbaik Anda (.pdf, gambar), maks. 3MB</small>
            @error('certificate_file')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="prog_bio" class="form-label">Bio / Deskripsi Diri <span class="required">*</span></label>
            <textarea id="prog_bio" name="bio" class="form-textarea" style="min-height:80px;padding:.6rem .75rem;border:1px solid var(--border);border-radius:var(--radius);font-size:.875rem;color:var(--text);background:var(--bg);width:100%;resize:vertical;font-family:inherit" placeholder="Ceritakan tentang keahlian dan pengalaman Anda..." required>{{ old('bio') }}</textarea>
            @error('bio')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="prog_expertise" class="form-label">Keahlian (pisahkan dengan koma) <span class="required">*</span></label>
            <input type="text" id="prog_expertise" name="expertise" class="form-input" placeholder="Contoh: Laravel, React, Vue, Python" value="{{ old('expertise') }}" required>
            @error('expertise')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div style="background:var(--blue-light);border:1px solid #BFDBFE;border-radius:var(--radius-sm);padding:.6rem .85rem;font-size:.78rem;color:#1E40AF;margin-bottom:1rem">
            ℹ️ Untuk memastikan keaslian keahlian Anda, Admin akan memverifikasi CV, KTP, dan Portofolio Anda terlebih dahulu.
          </div>
        </div>

        <!-- UMKM Extra Fields -->
        <div id="umkmFields" style="display:none">
          <div class="form-group">
            <label for="business_name" class="form-label">Nama Usaha <span class="required">*</span></label>
            <input type="text" id="business_name" name="business_name" class="form-input" placeholder="Contoh: Batik Nusantara Collection" value="{{ old('business_name') }}">
            @error('business_name')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="business_type" class="form-label">Jenis Usaha</label>
            <select id="business_type" name="business_type" class="form-select">
              <option value="">Pilih jenis usaha</option>
              @foreach(['Fashion & Kerajinan','Kuliner & Food','Teknologi','Retail & E-Commerce','Jasa','Pendidikan','Lainnya'] as $type)
              <option value="{{ $type }}" {{ old('business_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
              @endforeach
            </select>
          </div>
          
          <!-- New Verification Fields for UMKM -->
          <div class="form-group">
            <label for="umkm_ktp_number" class="form-label">Nomor KTP <span class="required">*</span></label>
            <input type="text" id="umkm_ktp_number" name="ktp_number" class="form-input" placeholder="16 digit nomor KTP" value="{{ old('ktp_number') }}" maxlength="16">
            @error('ktp_number')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="umkm_ktp_photo" class="form-label">Foto KTP <span class="required">*</span></label>
            <div style="display:flex;gap:10px;align-items:center">
              <input type="file" id="umkm_ktp_photo" name="ktp_photo" class="form-input" accept="image/*" style="flex:1">
              <button type="button" class="btn btn-ghost btn-sm" onclick="openCameraScanner('umkm_ktp_photo')" style="white-space:nowrap;display:flex;align-items:center;gap:6px;height:45px;padding:0 12px;border:1px dashed var(--primary);color:var(--primary);border-radius:var(--radius-sm)">
                📷 Ambil Foto
              </button>
            </div>
            <div id="preview-container-umkm_ktp_photo" style="display:none;margin-top:8px;position:relative;width:100%;max-width:200px;border-radius:var(--radius-sm);overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-sm)">
              <img id="preview-umkm_ktp_photo" src="" style="width:100%;display:block;object-fit:cover;aspect-ratio:4/3">
              <button type="button" onclick="clearCameraCapture('umkm_ktp_photo')" style="position:absolute;right:5px;top:5px;background:rgba(239,68,68,0.9);color:white;border:none;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:10px" title="Hapus foto">✕</button>
            </div>
            <small style="color:var(--text3);font-size:.72rem;display:block;margin-top:2px">Format gambar (.jpg, .jpeg, .png), maks. 2MB</small>
            @error('ktp_photo')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="business_photo" class="form-label">Foto Usaha <span class="required">*</span></label>
            <div style="display:flex;gap:10px;align-items:center">
              <input type="file" id="business_photo" name="business_photo" class="form-input" accept="image/*" style="flex:1">
              <button type="button" class="btn btn-ghost btn-sm" onclick="openCameraScanner('business_photo')" style="white-space:nowrap;display:flex;align-items:center;gap:6px;height:45px;padding:0 12px;border:1px dashed var(--primary);color:var(--primary);border-radius:var(--radius-sm)">
                📷 Ambil Foto
              </button>
            </div>
            <div id="preview-container-business_photo" style="display:none;margin-top:8px;position:relative;width:100%;max-width:200px;border-radius:var(--radius-sm);overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-sm)">
              <img id="preview-business_photo" src="" style="width:100%;display:block;object-fit:cover;aspect-ratio:4/3">
              <button type="button" onclick="clearCameraCapture('business_photo')" style="position:absolute;right:5px;top:5px;background:rgba(239,68,68,0.9);color:white;border:none;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:10px" title="Hapus foto">✕</button>
            </div>
            <small style="color:var(--text3);font-size:.72rem;display:block;margin-top:2px">Unggah foto fisik lokasi tempat usaha Anda, maks. 2MB</small>
            @error('business_photo')<div class="field-error">⚠ {{ $message }}</div>@enderror
          </div>

          <div style="background:var(--blue-light);border:1px solid #BFDBFE;border-radius:var(--radius-sm);padding:.6rem .85rem;font-size:.78rem;color:#1E40AF;margin-bottom:1rem">
            ℹ️ Admin akan memverifikasi data dan foto KTP serta foto usaha Anda dalam waktu 1x24 jam sebelum akun aktif sepenuhnya.
          </div>
        </div>

        <!-- Course Extra Fields -->
        <div id="courseFields" style="display:none">
          <div class="form-group">
            <label for="expertise" class="form-label">Bidang Keahlian</label>
            <input type="text" id="expertise" name="expertise" class="form-input" placeholder="Contoh: Web Development, Data Science" value="{{ old('expertise') }}">
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-full" id="regBtn" aria-label="Buat akun BuilderHub">
          Buat Akun Gratis
        </button>
        <p style="font-size:.75rem;color:var(--text3);text-align:center;margin-top:.75rem">
          Dengan mendaftar, Anda menyetujui <a href="#" style="color:var(--primary);font-weight:600">Syarat & Ketentuan</a> BuilderHub.
        </p>
      </form>
    </div>
  </div>
</div>

<!-- ================= CAMERA SCANNER MODAL ================= -->
<div id="cameraModal" class="camera-modal" style="display:none;">
  <div class="camera-modal-content">
    <div class="camera-modal-header">
      <h3>📷 Ambil Foto Dokumen / KTP</h3>
      <button type="button" class="camera-modal-close" onclick="closeCameraModal()">&times;</button>
    </div>
    <div class="camera-modal-body">
      <!-- Video & Canvas Container -->
      <div class="camera-preview-container">
        <video id="cameraVideo" autoplay playsinline></video>
        <!-- Neon overlay scanner frame -->
        <div class="scanner-frame">
          <div class="scanner-line"></div>
          <div class="scanner-frame-bottom-left"></div>
          <div class="scanner-frame-bottom-right"></div>
        </div>
        <!-- Snapshotted Canvas (hidden initially) -->
        <canvas id="cameraCanvas" style="display:none;"></canvas>
      </div>
      
      <div class="camera-select-container" style="display:none;">
        <label for="cameraSelect">Pilih Kamera:</label>
        <select id="cameraSelect" class="form-select" onchange="changeCamera()"></select>
      </div>
    </div>
    <div class="camera-modal-footer">
      <!-- Buttons for control -->
      <button type="button" class="btn btn-ghost" onclick="closeCameraModal()" style="border-radius:var(--radius-sm); padding:10px 20px;">Batal</button>
      <button type="button" class="btn btn-primary" id="shutterBtn" onclick="takeSnapshot()" style="border-radius:var(--radius-sm); padding:10px 20px; display:inline-flex; align-items:center; gap:8px;">
        📸 Ambil Foto
      </button>
      <div id="captureConfirmBtns" style="display:none; gap:10px; width: 100%;">
        <button type="button" class="btn btn-ghost" onclick="retakePhoto()" style="flex:1; border-radius:var(--radius-sm); padding:10px 20px;">Ulangi</button>
        <button type="button" class="btn btn-primary" onclick="useCapturedPhoto()" style="flex:1; border-radius:var(--radius-sm); padding:10px 20px;">Gunakan Foto</button>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
/* ================= CAMERA SCANNER STYLES ================= */
.camera-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(11, 15, 25, 0.85);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  z-index: 999999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  animation: modalFadeIn 0.3s ease forwards;
}

@keyframes modalFadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.camera-modal-content {
  background: var(--bg2);
  border: 1.5px solid rgba(255, 255, 255, 0.2);
  border-radius: var(--radius-lg);
  width: 100%;
  max-width: 500px;
  box-shadow: var(--shadow-lg), 0 0 40px rgba(79, 70, 229, 0.2);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  animation: cardScaleIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

@keyframes cardScaleIn {
  from { transform: scale(0.92); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

.camera-modal-header {
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid var(--border);
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: var(--bg3);
}

.camera-modal-header h3 {
  font-size: 1.05rem;
  font-weight: 800;
  color: var(--text);
  margin: 0;
  display: flex;
  align-items: center;
  gap: 8px;
}

.camera-modal-close {
  font-size: 1.5rem;
  color: var(--text3);
  cursor: pointer;
  line-height: 1;
  background: none;
  border: none;
  transition: color 0.2s;
}

.camera-modal-close:hover {
  color: var(--red);
}

.camera-modal-body {
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.camera-preview-container {
  position: relative;
  width: 100%;
  aspect-ratio: 4/3;
  background: #000;
  border-radius: var(--radius-sm);
  overflow: hidden;
  box-shadow: inset 0 0 30px rgba(0,0,0,0.9);
  border: 2px solid var(--border);
}

.camera-preview-container video, .camera-preview-container canvas {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.scanner-frame {
  position: absolute;
  top: 10%;
  left: 10%;
  right: 10%;
  bottom: 10%;
  border: 2px dashed rgba(79, 70, 229, 0.8);
  border-radius: var(--radius-sm);
  box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5);
  pointer-events: none;
  transition: border-color 0.3s;
}

.scanner-frame::before {
  content: '';
  position: absolute;
  top: -5px; left: -5px; width: 20px; height: 20px;
  border-top: 5px solid var(--primary); border-left: 5px solid var(--primary);
}
.scanner-frame::after {
  content: '';
  position: absolute;
  top: -5px; right: -5px; width: 20px; height: 20px;
  border-top: 5px solid var(--primary); border-right: 5px solid var(--primary);
}

.scanner-frame-bottom-left {
  position: absolute;
  bottom: -5px; left: -5px; width: 20px; height: 20px;
  border-bottom: 5px solid var(--primary); border-left: 5px solid var(--primary);
}
.scanner-frame-bottom-right {
  position: absolute;
  bottom: -5px; right: -5px; width: 20px; height: 20px;
  border-bottom: 5px solid var(--primary); border-right: 5px solid var(--primary);
}

.scanner-line {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(90deg, transparent, var(--primary), transparent);
  box-shadow: 0 0 10px var(--primary);
  animation: scanAnimation 2.8s linear infinite;
}

@keyframes scanAnimation {
  0% { top: 0%; }
  50% { top: 100%; }
  100% { top: 0%; }
}

.camera-select-container {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}

.camera-select-container label {
  font-size: 0.8rem;
  font-weight: 700;
  color: var(--text2);
}

.camera-select-container select {
  padding: 10px;
  font-size: 0.875rem;
}

.camera-modal-footer {
  padding: 1rem 1.25rem;
  border-top: 1px solid var(--border);
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  background: var(--bg3);
}
</style>
@endpush

@push('scripts')
<script>
const guides = {
  programmer: {title:'Hak Programmer', text:'Kerjakan project UMKM, dapatkan 20% komisi. Setelah memiliki 3 sertifikat & 3 portofolio, Anda jadi Top Programmer dan bisa membuat Course!'},
  umkm: {title:'Hak UMKM', text:'Posting project digital Anda (toko online, aplikasi mobile, dll), tunggu persetujuan Admin, lalu terima penawaran dari programmer.'},
  course: {title:'Hak Pelajar / Student', text:'Jelajahi berbagai course premium dari programmer berpengalaman untuk menguasai coding (seperti Udemy).'}
};
const activeRole = '{{ old('role', request('role', 'programmer')) }}';
if(activeRole) setTimeout(() => selectRole(activeRole), 100);

// ================= CAMERA SCANNER JAVASCRIPT =================
let currentTargetInputId = '';
let mediaStream = null;
let videoDevices = [];
let capturedBlob = null;

async function openCameraScanner(inputId) {
  currentTargetInputId = inputId;
  const modal = document.getElementById('cameraModal');
  modal.style.display = 'flex';
  
  // Reset UI
  document.getElementById('cameraVideo').style.display = 'block';
  document.getElementById('cameraCanvas').style.display = 'none';
  document.querySelector('.scanner-frame').style.display = 'block';
  document.getElementById('shutterBtn').style.display = 'inline-flex';
  document.getElementById('captureConfirmBtns').style.display = 'none';
  capturedBlob = null;

  try {
    // Get list of video devices
    const devices = await navigator.mediaDevices.enumerateDevices();
    videoDevices = devices.filter(device => device.kind === 'videoinput');
    
    // Populate select
    const select = document.getElementById('cameraSelect');
    select.innerHTML = '';
    videoDevices.forEach((device, index) => {
      const option = document.createElement('option');
      option.value = device.deviceId;
      option.text = device.label || `Kamera ${index + 1}`;
      select.appendChild(option);
    });

    if (videoDevices.length > 1) {
      document.querySelector('.camera-select-container').style.display = 'flex';
    } else {
      document.querySelector('.camera-select-container').style.display = 'none';
    }

    // Start stream with the first camera
    await startCameraStream();
  } catch (err) {
    console.error('Gagal mengakses kamera:', err);
    alert('Gagal mengakses kamera. Pastikan Anda memberikan izin akses kamera pada browser.');
    closeCameraModal();
  }
}

async function startCameraStream(deviceId = null) {
  if (mediaStream) {
    mediaStream.getTracks().forEach(track => track.stop());
  }

  const constraints = {
    video: {
      width: { ideal: 1280 },
      height: { ideal: 720 },
      facingMode: deviceId ? undefined : 'environment' // default to back camera on mobile
    }
  };

  if (deviceId) {
    constraints.video.deviceId = { exact: deviceId };
  }

  try {
    mediaStream = await navigator.mediaDevices.getUserMedia(constraints);
    const video = document.getElementById('cameraVideo');
    video.srcObject = mediaStream;
    video.play();
  } catch (err) {
    console.error('Gagal memulai video stream:', err);
    // Try with simpler constraints
    try {
      mediaStream = await navigator.mediaDevices.getUserMedia({ video: true });
      const video = document.getElementById('cameraVideo');
      video.srcObject = mediaStream;
      video.play();
    } catch (fallbackErr) {
      alert('Tidak dapat memulai kamera stream.');
      throw fallbackErr;
    }
  }
}

async function changeCamera() {
  const select = document.getElementById('cameraSelect');
  await startCameraStream(select.value);
}

function takeSnapshot() {
  const video = document.getElementById('cameraVideo');
  const canvas = document.getElementById('cameraCanvas');
  const context = canvas.getContext('2d');

  // Set canvas size to video size
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;

  // Draw video frame to canvas
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Stop camera stream to freeze/save power
  if (mediaStream) {
    mediaStream.getTracks().forEach(track => track.stop());
    mediaStream = null;
  }

  // Convert canvas to blob
  canvas.toBlob(blob => {
    capturedBlob = blob;
  }, 'image/png');

  // Show snapshot in canvas, hide video and scanner line
  video.style.display = 'none';
  canvas.style.display = 'block';
  document.querySelector('.scanner-frame').style.display = 'none';

  // Toggle buttons
  document.getElementById('shutterBtn').style.display = 'none';
  document.getElementById('captureConfirmBtns').style.display = 'flex';
}

function retakePhoto() {
  document.getElementById('cameraVideo').style.display = 'block';
  document.getElementById('cameraCanvas').style.display = 'none';
  document.querySelector('.scanner-frame').style.display = 'block';
  document.getElementById('shutterBtn').style.display = 'inline-flex';
  document.getElementById('captureConfirmBtns').style.display = 'none';
  capturedBlob = null;
  
  const select = document.getElementById('cameraSelect');
  startCameraStream(select.value || null);
}

function useCapturedPhoto() {
  if (!capturedBlob) return;

  const fileInput = document.getElementById(currentTargetInputId);
  if (!fileInput) return;

  // Create file object from blob
  const file = new File([capturedBlob], `camera_capture_${currentTargetInputId}.png`, {
    type: 'image/png',
    lastModified: new Date().getTime()
  });

  // Put file into input
  const container = new DataTransfer();
  container.items.add(file);
  fileInput.files = container.files;

  // Show local preview
  const previewImg = document.getElementById(`preview-${currentTargetInputId}`);
  const previewContainer = document.getElementById(`preview-container-${currentTargetInputId}`);
  if (previewImg && previewContainer) {
    previewImg.src = URL.createObjectURL(capturedBlob);
    previewContainer.style.display = 'block';
  }

  // Dispatch change event
  fileInput.dispatchEvent(new Event('change', { bubbles: true }));

  closeCameraModal();
}

function clearCameraCapture(inputId) {
  const fileInput = document.getElementById(inputId);
  if (fileInput) {
    fileInput.value = ''; // reset file input
    fileInput.dispatchEvent(new Event('change', { bubbles: true }));
  }

  const previewContainer = document.getElementById(`preview-container-${inputId}`);
  const previewImg = document.getElementById(`preview-${inputId}`);
  if (previewContainer && previewImg) {
    previewContainer.style.display = 'none';
    previewImg.src = '';
  }
}

function closeCameraModal() {
  const modal = document.getElementById('cameraModal');
  modal.style.display = 'none';

  // Stop stream
  if (mediaStream) {
    mediaStream.getTracks().forEach(track => track.stop());
    mediaStream = null;
  }
}

// Global hook to support standard file input preview as well!
document.addEventListener('DOMContentLoaded', function() {
  const imageInputs = ['prog_ktp_photo', 'certificate_file', 'umkm_ktp_photo', 'business_photo'];
  imageInputs.forEach(id => {
    const input = document.getElementById(id);
    if (!input) return;
    input.addEventListener('change', function(e) {
      const file = e.target.files[0];
      const previewImg = document.getElementById(`preview-${id}`);
      const previewContainer = document.getElementById(`preview-container-${id}`);
      if (!previewImg || !previewContainer) return;
      
      if (file && file.type.startsWith('image/')) {
        previewImg.src = URL.createObjectURL(file);
        previewContainer.style.display = 'block';
      } else if (file && file.type === 'application/pdf') {
        // If it's a PDF (for certificate_file), we can show a PDF icon
        previewImg.src = 'https://cdn-icons-png.flaticon.com/512/337/337946.png'; // standard PDF icon
        previewContainer.style.display = 'block';
      } else if (!file) {
        previewContainer.style.display = 'none';
        previewImg.src = '';
      }
    });
  });
});

function selectRole(r){
  document.querySelectorAll('label[id^="label-"]').forEach(el=>{
    el.style.borderColor = 'var(--border)';
    el.style.background = 'var(--bg)';
  });
  const lbl = document.getElementById('label-'+r);
  if(lbl){ lbl.style.borderColor='var(--primary)'; lbl.style.background='var(--primary-light)'; }
  document.querySelector(`input[value="${r}"]`).checked = true;
  
  document.getElementById('programmerFields').style.display = r==='programmer' ? 'block' : 'none';
  document.getElementById('umkmFields').style.display = r==='umkm' ? 'block' : 'none';
  document.getElementById('courseFields').style.display = r==='course' ? 'block' : 'none';
  
  // Enable active section's inputs, disable inactive ones so they don't get submitted
  enableSectionInputs('programmerFields', r==='programmer');
  enableSectionInputs('umkmFields', r==='umkm');
  enableSectionInputs('courseFields', r==='course');

  const g = guides[r];
  if(g){
    document.getElementById('roleGuide').style.display='flex';
    document.getElementById('guideTitle').textContent = g.title;
    document.getElementById('guideText').textContent = g.text;
  }
}

function enableSectionInputs(sectionId, enabled) {
  const section = document.getElementById(sectionId);
  if (!section) return;
  const inputs = section.querySelectorAll('input, select, textarea');
  inputs.forEach(input => {
    input.disabled = !enabled;
  });
}

function checkPwd(v){
  const bar = document.getElementById('pwdBar');
  const lbl = document.getElementById('pwdLabel');
  document.getElementById('pwdStrength').style.display = v ? 'block' : 'none';
  let score = 0;
  if(v.length >= 6) score++;
  if(v.length >= 10) score++;
  if(/[A-Z]/.test(v)) score++;
  if(/[0-9]/.test(v)) score++;
  if(/[^a-zA-Z0-9]/.test(v)) score++;
  const levels = [['0%',''],['25%','Sangat Lemah','var(--red)'],['50%','Lemah','var(--orange)'],['75%','Cukup','var(--orange)'],['90%','Kuat','var(--green)'],['100%','Sangat Kuat','var(--green)']];
  const [w,t,c] = levels[score] || levels[0];
  bar.style.width = w; bar.style.background = c || '#ccc';
  lbl.textContent = t; lbl.style.color = c || 'var(--text3)';
}

function checkMatch(){
  const p = document.getElementById('password').value;
  const c = document.getElementById('password_confirmation').value;
  const m = document.getElementById('matchMsg');
  if(!c) return m.textContent = '';
  if(p === c){ m.textContent = '✓ Password cocok'; m.style.color='var(--green)'; }
  else { m.textContent = '✗ Password tidak cocok'; m.style.color='var(--red)'; }
}
</script>
@endpush
@endsection
