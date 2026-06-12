@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div style="min-height:calc(100vh - 64px);display:grid;grid-template-columns:1fr 1fr">
  <div style="background:linear-gradient(135deg,#1E1260 0%,#3D1FAF 100%);padding:3rem;display:flex;flex-direction:column;justify-content:center">
    <div style="display:flex;align-items:center;gap:10px;font-weight:800;font-size:1.1rem;color:#fff;margin-bottom:2rem">
      <div class="nav-logo-icon">&lt;/&gt;</div> BuilderHub
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

      <form method="POST" action="{{ route('register.post') }}" novalidate aria-label="Form registrasi BuilderHub" id="registerForm">
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
          <div style="background:var(--blue-light);border:1px solid #BFDBFE;border-radius:var(--radius-sm);padding:.6rem .85rem;font-size:.78rem;color:#1E40AF;margin-bottom:1rem">
            ℹ️ Setelah daftar, upload dokumen legalitas (SIUP/NIB) di dashboard untuk mendapatkan badge <strong>UMKM Verified</strong>
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

@push('scripts')
<script>
const guides = {
  programmer: {title:'Hak Programmer', text:'Kerjakan project UMKM, dapatkan 20% komisi. Setelah memiliki 3 sertifikat & 3 portofolio, Anda jadi Top Programmer dan bisa membuat Course!'},
  umkm: {title:'Hak UMKM', text:'Posting project digital Anda (toko online, aplikasi mobile, dll), tunggu persetujuan Admin, lalu terima penawaran dari programmer.'},
  course: {title:'Hak Pelajar / Student', text:'Jelajahi berbagai course premium dari programmer berpengalaman untuk menguasai coding (seperti Udemy).'}
};
const activeRole = '{{ old('role', request('role', 'programmer')) }}';
if(activeRole) setTimeout(() => selectRole(activeRole), 100);

function selectRole(r){
  document.querySelectorAll('label[id^="label-"]').forEach(el=>{
    el.style.borderColor = 'var(--border)';
    el.style.background = 'var(--bg)';
  });
  const lbl = document.getElementById('label-'+r);
  if(lbl){ lbl.style.borderColor='var(--primary)'; lbl.style.background='var(--primary-light)'; }
  document.querySelector(`input[value="${r}"]`).checked = true;
  document.getElementById('umkmFields').style.display = r==='umkm' ? 'block' : 'none';
  document.getElementById('courseFields').style.display = r==='course' ? 'block' : 'none';
  const g = guides[r];
  if(g){
    document.getElementById('roleGuide').style.display='flex';
    document.getElementById('guideTitle').textContent = g.title;
    document.getElementById('guideText').textContent = g.text;
  }
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
