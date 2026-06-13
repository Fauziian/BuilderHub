@extends('layouts.app')
@section('title', 'Edit Course — ' . $course->title)
@section('content')
<div class="dash-layout" style="max-width:800px">
  <div style="margin-bottom:1.5rem">
    <a href="{{ route('programmer.dashboard') }}#courses" style="color:var(--text2);font-size:.875rem">← Kembali ke Dashboard</a>
  </div>
  <div class="card">
    <h1 style="font-size:1.2rem;font-weight:800;margin-bottom:.5rem">✏️ Edit Course</h1>
    <p style="font-size:.875rem;color:var(--text2);margin-bottom:1.5rem">Perbarui informasi course Anda. Video materi dapat dikelola dari tab Course Saya.</p>
    @if($errors->any())<div class="alert alert-error">❌ {{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('programmer.course.update', $course) }}" aria-label="Form edit course">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="title" class="form-label">Judul Course <span class="required">*</span></label>
        <input type="text" id="title" name="title" class="form-input" required value="{{ old('title', $course->title) }}">
      </div>
      <div class="form-group">
        <label for="description" class="form-label">Deskripsi <span class="required">*</span></label>
        <textarea id="description" name="description" class="form-textarea" style="min-height:120px" required>{{ old('description', $course->description) }}</textarea>
        <div id="desc-char-count" style="font-size:0.78rem;margin-top:4px;font-weight:600;color:var(--text3)">
          Minimal 20 karakter (0/20)
        </div>
      </div>
      <div class="form-group" style="margin-top:1.5rem">
        <label class="form-label" style="font-weight:700;font-size:1rem;margin-bottom:.5rem">🎬 Video Pembelajaran (YouTube) <span class="required">*</span></label>
        <div class="form-hint" style="margin-bottom:1rem">Kelola video materi pembelajaran. Anda dapat mengubah, menghapus, atau menambah video di bawah ini.</div>
        
        <div id="video-container">
          @php
            $oldVideos = old('videos');
            if (is_null($oldVideos)) {
                $oldVideos = [];
                foreach ($course->videos as $v) {
                    $oldVideos[] = [
                        'title' => $v->title,
                        'video_url' => $v->video_url,
                        'duration' => $v->duration,
                    ];
                }
            }
            if (empty($oldVideos)) {
                $oldVideos = [[]];
            }
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
            @foreach(['pemula' => 'Pemula', 'menengah' => 'Menengah', 'mahir' => 'Mahir'] as $val => $label)
            <option value="{{ $val }}" {{ old('level', $course->level) === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Kategori <span class="required">*</span></label>
          <input name="category" class="form-input" required value="{{ old('category', $course->category) }}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Harga (Rp)</label>
          <input type="number" name="price" class="form-input" min="0" value="{{ old('price', $course->price) }}">
          <div class="form-hint">Isi 0 atau centang "Gratis"</div>
        </div>
        <div class="form-group">
          <label class="form-label">Estimasi Durasi</label>
          <input name="duration" class="form-input" placeholder="Contoh: 8+ jam" value="{{ old('duration', $course->duration) }}">
        </div>
      </div>
      <div style="margin-bottom:1rem">
        <label style="display:flex;align-items:center;gap:8px;font-size:.875rem;cursor:pointer">
          <input type="checkbox" name="is_free" value="1" {{ ($course->is_free || old('is_free')) ? 'checked' : '' }}> Kursus ini gratis
        </label>
      </div>
      <div style="display:flex;gap:.75rem">
        <button type="submit" class="btn btn-primary" aria-label="Simpan perubahan course">💾 Simpan Perubahan</button>
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
});
</script>
@endpush
@endsection
