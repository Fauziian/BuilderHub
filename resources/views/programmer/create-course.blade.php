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
    <form method="POST" action="{{ route('programmer.store-course') }}" aria-label="Form buat course baru">
      @csrf
      <div class="form-group">
        <label for="title" class="form-label">Judul Course <span class="required">*</span></label>
        <input type="text" id="title" name="title" class="form-input" placeholder="Contoh: Belajar React.js dari Nol untuk Pemula" required value="{{ old('title') }}">
      </div>
      <div class="form-group">
        <label for="description" class="form-label">Deskripsi <span class="required">*</span></label>
        <textarea id="description" name="description" class="form-textarea" style="min-height:120px" required placeholder="Jelaskan apa yang akan dipelajari siswa, siapa target peserta, dan apa yang membuat course Anda unik...">{{ old('description') }}</textarea>
      </div>
      <div class="form-group">
        <label for="video_url" class="form-label">🎬 Link YouTube Materi Pembelajaran <span class="required">*</span></label>
        <input type="url" id="video_url" name="video_url" class="form-input" placeholder="https://www.youtube.com/watch?v=..." required value="{{ old('video_url') }}">
        <div class="form-hint">Link YouTube video materi utama yang akan langsung ditonton oleh pelajar yang mendaftar. Bisa berupa playlist atau video singkat.</div>
        @error('video_url')<div class="field-error">⚠ {{ $message }}</div>@enderror
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
@endsection
