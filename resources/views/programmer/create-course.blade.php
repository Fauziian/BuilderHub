@extends('layouts.app')
@section('title', 'Buat Course Baru')
@section('content')
<div class="dash-layout" style="max-width:800px">
  <div style="margin-bottom:1.5rem">
    <a href="{{ route('programmer.dashboard') }}#courses" style="color:var(--text2);font-size:.875rem">← Kembali ke Dashboard</a>
  </div>
  <div class="card">
    <h1 style="font-size:1.2rem;font-weight:800;margin-bottom:.5rem">🎓 Buat Course Baru</h1>
    <p style="font-size:.875rem;color:var(--text2);margin-bottom:1.5rem">Bagikan keahlian Anda kepada pengguna BuilderHub dan dapatkan penghasilan tambahan.</p>
    <div class="imk-guide">
      <div class="imk-guide-icon">💡</div>
      <div>
        <div class="imk-guide-title">Tips Membuat Course yang Baik</div>
        <div class="imk-guide-text">Judul yang jelas, deskripsi detail, dan sertakan <strong>Link YouTube</strong> materi utama. Video akan langsung bisa ditonton oleh pelajar setelah mendaftar!</div>
      </div>
    </div>
    @if($errors->any())<div class="alert alert-error">❌ {{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('programmer.store-course') }}" enctype="multipart/form-data" aria-label="Form buat course baru">
      @csrf
      <div class="form-group">
        <label for="title" class="form-label">Judul Course <span class="required">*</span></label>
        <input type="text" id="title" name="title" class="form-input" placeholder="Contoh: Belajar React.js dari Nol untuk Pemula" required value="{{ old('title') }}">
      </div>
      <div class="form-group">
        <label for="description" class="form-label">Deskripsi <span class="required">*</span></label>
        <textarea id="description" name="description" class="form-textarea" style="min-height:120px" required placeholder="Jelaskan apa yang akan dipelajari siswa, siapa target peserta, dan apa yang membuat course Anda unik...">{{ old('description') }}</textarea>
        <div id="desc-char-count" style="font-size:0.78rem;margin-top:4px;font-weight:600;color:var(--text3)">
          Minimal 20 karakter (0/20)
        </div>
      </div>

      {{-- Cover / Logo Course Field --}}
      <div class="form-group" style="margin-top:1.5rem">
        <label class="form-label" style="font-weight:700;font-size:1rem;margin-bottom:.5rem">🖼️ Cover / Logo Course</label>
        <div class="form-hint" style="margin-bottom:0.75rem">Pilih bagaimana tampilan kartu course Anda akan terlihat. Anda bisa memilih preset logo teknologi atau mengunggah gambar kustom.</div>
        
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1rem">
          {{-- Preset Option --}}
          <div style="border:1px solid var(--border);border-radius:var(--radius-sm);padding:1rem;background:var(--bg2)">
            <label style="display:flex;align-items:center;gap:8px;font-weight:700;font-size:0.85rem;margin-bottom:0.5rem;cursor:pointer">
              <input type="radio" name="thumbnail_type" value="preset" checked id="type-preset">
              Preset Logo Teknologi
            </label>
            <select name="logo_preset" class="form-select" id="logo-preset-select" style="width:100%">
              <option value="auto">— Deteksi Otomatis dari Judul —</option>
              <option value="html">HTML5</option>
              <option value="css">CSS3</option>
              <option value="js">JavaScript (JS)</option>
              <option value="php">PHP</option>
              <option value="mysql">MySQL</option>
              <option value="laravel">Laravel</option>
              <option value="react">React.js</option>
              <option value="node">Node.js</option>
              <option value="flutter">Flutter</option>
              <option value="git">Git</option>
            </select>
          </div>

          {{-- Custom Image Option --}}
          <div style="border:1px solid var(--border);border-radius:var(--radius-sm);padding:1rem;background:var(--bg2)">
            <label style="display:flex;align-items:center;gap:8px;font-weight:700;font-size:0.85rem;margin-bottom:0.5rem;cursor:pointer">
              <input type="radio" name="thumbnail_type" value="upload" id="type-upload">
              Unggah Gambar Kustom
            </label>
            <input type="file" name="thumbnail_img" class="form-input" id="thumbnail-file-input" accept="image/*" style="padding:4px" disabled>
          </div>
        </div>
        @error('thumbnail_img')<div class="field-error">⚠ {{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top:1.5rem">
        <label class="form-label" style="font-weight:700;font-size:1rem;margin-bottom:.5rem">🎬 Video Pembelajaran (YouTube) <span class="required">*</span></label>
        <div class="form-hint" style="margin-bottom:1rem">Tambahkan minimal 1 video materi pembelajaran. Anda dapat menambahkan beberapa video sekaligus.</div>
        
        <div id="video-container">
          @php
            $oldVideos = old('videos', [[]]);
          @endphp
          @foreach($oldVideos as $index => $oldVid)
            <div class="video-row card" style="padding:1rem;border:1.5px solid var(--border);background:var(--bg2);position:relative;margin-bottom:0.75rem;border-radius:var(--radius-sm)">
              <button type="button" class="btn-remove-video" style="position:absolute;top:0.5rem;right:0.5rem;background:var(--red-light);color:var(--red);border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:bold;border:1px solid rgba(239,68,68,.2);cursor:pointer" title="Hapus video ini">&times;</button>
              
              <div style="font-size:0.85rem;font-weight:700;margin-bottom:0.75rem;color:var(--primary);display:flex;align-items:center;gap:4px">
                <span>📹 Video #</span><span class="video-index">{{ $index + 1 }}</span>
              </div>

              <div class="form-group" style="margin-bottom:0.75rem">
                <label class="form-label">Judul Video <span class="required">*</span></label>
                <input type="text" name="videos[{{ $index }}][title]" class="form-input video-title-input" placeholder="Contoh: Pengenalan HTML & CSS Dasar" required value="{{ $oldVid['title'] ?? '' }}">
              </div>

              <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                  <label class="form-label">Link YouTube <span class="required">*</span></label>
                  <input type="url" name="videos[{{ $index }}][video_url]" class="form-input video-url-input" placeholder="https://www.youtube.com/watch?v=..." required value="{{ $oldVid['video_url'] ?? '' }}">
                </div>
                <div class="form-group" style="margin-bottom:0">
                  <label class="form-label">Durasi Video</label>
                  <input type="text" name="videos[{{ $index }}][duration]" class="form-input video-duration-input" placeholder="Contoh: 15 menit" value="{{ $oldVid['duration'] ?? '15 menit' }}">
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <button type="button" class="btn btn-ghost btn-sm" id="btn-add-video" style="border:1px dashed var(--primary);color:var(--primary);background:var(--primary-light);font-weight:600;margin-top:.5rem">
          ➕ Tambah Video Baru
        </button>
        @error('videos')<div class="field-error">⚠ {{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Level</label>
          <select name="level" class="form-select">
            <option value="pemula">Pemula</option>
            <option value="menengah">Menengah</option>
            <option value="mahir">Mahir</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Kategori <span class="required">*</span></label>
          <input name="category" class="form-input" placeholder="Contoh: Frontend, Backend, Mobile" required value="{{ old('category') }}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Harga (Rp)</label>
          <input type="number" name="price" class="form-input" placeholder="0" min="0" value="{{ old('price', 0) }}">
          <div class="form-hint">Isi 0 atau centang "Gratis" untuk kursus gratis</div>
        </div>
        <div class="form-group">
          <label class="form-label">Estimasi Durasi</label>
          <input name="duration" class="form-input" placeholder="Contoh: 8+ jam" value="{{ old('duration') }}">
        </div>
      </div>
      <div style="margin-bottom:1rem">
        <label style="display:flex;align-items:center;gap:8px;font-size:.875rem;cursor:pointer">
          <input type="checkbox" name="is_free" value="1" {{ old('is_free') ? 'checked' : '' }}> Kursus ini gratis
        </label>
      </div>
      <div style="background:var(--orange-light);border:1px solid rgba(245,158,11,.3);border-radius:var(--radius);padding:.75rem 1rem;font-size:.82rem;color:#92400E;margin-bottom:1rem">
        ⏳ Course akan ditinjau oleh admin sebelum dipublikasikan. Proses review biasanya 1-2 hari kerja.
      </div>
      <div style="display:flex;gap:.75rem">
        <button type="submit" class="btn btn-primary" aria-label="Submit course baru">🚀 Kirim untuk Review</button>
        <a href="{{ route('programmer.dashboard') }}" class="btn btn-ghost">Batal</a>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const container = document.getElementById('video-container');
  const btnAdd = document.getElementById('btn-add-video');

  function reindexVideos() {
    const rows = container.querySelectorAll('.video-row');
    rows.forEach((row, index) => {
      row.querySelector('.video-index').textContent = index + 1;
      row.querySelector('.video-title-input').name = `videos[${index}][title]`;
      row.querySelector('.video-url-input').name = `videos[${index}][video_url]`;
      row.querySelector('.video-duration-input').name = `videos[${index}][duration]`;
      
      const removeBtn = row.querySelector('.btn-remove-video');
      if (rows.length === 1) {
        removeBtn.style.display = 'none';
      } else {
        removeBtn.style.display = 'flex';
      }
    });
  }

  btnAdd.addEventListener('click', function() {
    const index = container.querySelectorAll('.video-row').length;
    const template = `
      <div class="video-row card" style="padding:1rem;border:1.5px solid var(--border);background:var(--bg2);position:relative;margin-bottom:0.75rem;border-radius:var(--radius-sm);opacity:0;transform:translateY(8px);transition:all 0.2s ease">
        <button type="button" class="btn-remove-video" style="position:absolute;top:0.5rem;right:0.5rem;background:var(--red-light);color:var(--red);border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:bold;border:1px solid rgba(239,68,68,.2);cursor:pointer" title="Hapus video ini">&times;</button>
        
        <div style="font-size:0.85rem;font-weight:700;margin-bottom:0.75rem;color:var(--primary);display:flex;align-items:center;gap:4px">
          <span>📹 Video #</span><span class="video-index">${index + 1}</span>
        </div>

        <div class="form-group" style="margin-bottom:0.75rem">
          <label class="form-label">Judul Video <span class="required">*</span></label>
          <input type="text" name="videos[${index}][title]" class="form-input video-title-input" placeholder="Contoh: Pengenalan HTML & CSS Dasar" required>
        </div>

        <div class="form-row">
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Link YouTube <span class="required">*</span></label>
            <input type="url" name="videos[${index}][video_url]" class="form-input video-url-input" placeholder="https://www.youtube.com/watch?v=..." required>
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Durasi Video</label>
            <input type="text" name="videos[${index}][duration]" class="form-input video-duration-input" placeholder="Contoh: 15 menit" value="15 menit">
          </div>
        </div>
      </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
    
    // Animate in
    const newRow = container.lastElementChild;
    setTimeout(() => {
      newRow.style.opacity = '1';
      newRow.style.transform = 'translateY(0)';
    }, 10);

    reindexVideos();
  });

  container.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-remove-video')) {
      const row = e.target.closest('.video-row');
      row.style.opacity = '0';
      row.style.transform = 'translateY(8px)';
      setTimeout(() => {
        row.remove();
        reindexVideos();
      }, 200);
    }
  });

  // Initial call to hide delete button if only 1 row
  reindexVideos();

  // Description live counter
  const descTextarea = document.getElementById('description');
  const descCounter = document.getElementById('desc-char-count');
  if (descTextarea && descCounter) {
    const updateCount = () => {
      const len = descTextarea.value.length;
      if (len < 20) {
        descCounter.textContent = `Minimal 20 karakter (${len}/20)`;
        descCounter.style.color = '#EF4444';
      } else {
        descCounter.textContent = `${len} karakter ✓`;
        descCounter.style.color = '#10B981';
      }
    };
    descTextarea.addEventListener('input', updateCount);
    updateCount();
  }

  // Cover/Logo Selection logic
  const typePreset = document.getElementById('type-preset');
  const typeUpload = document.getElementById('type-upload');
  const presetSelect = document.getElementById('logo-preset-select');
  const fileInput = document.getElementById('thumbnail-file-input');

  if (typePreset && typeUpload && presetSelect && fileInput) {
    function updateInputs() {
      if (typePreset.checked) {
        presetSelect.disabled = false;
        fileInput.disabled = true;
      } else {
        presetSelect.disabled = true;
        fileInput.disabled = false;
      }
    }

    typePreset.addEventListener('change', updateInputs);
    typeUpload.addEventListener('change', updateInputs);
    updateInputs();
  }
});
</script>
@endpush
@endsection
