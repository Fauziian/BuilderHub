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
@endsection
