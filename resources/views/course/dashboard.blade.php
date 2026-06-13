@extends('layouts.app')
@section('title', 'Dashboard Course Manager')
@section('content')
<div style="background:linear-gradient(135deg,#065F46,#059669);color:#fff;padding:1.5rem 2rem">
  <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center">
    <div>
      <h1 style="font-size:1.25rem;font-weight:800;color:#fff">📚 Course Manager Dashboard</h1>
      <p style="font-size:.82rem;color:rgba(255,255,255,.7)">Kelola seluruh konten kursus BuilderHub</p>
    </div>
    <div style="display:flex;gap:.5rem;align-items:center">
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="btn" style="background:var(--red);color:#fff;border-color:var(--red);font-size:.82rem" aria-label="Keluar dari akun">Keluar 🚪</button>
      </form>
    </div>
  </div>
</div>
<div class="dash-layout">
  <div class="stats-grid">
    <div class="stat-card"><div class="stat-card-icon">📚</div><div class="stat-card-value">{{ $totalCourses }}</div><div class="stat-card-label">Total Course</div></div>
    <div class="stat-card"><div class="stat-card-icon">👥</div><div class="stat-card-value">{{ number_format($totalStudents) }}</div><div class="stat-card-label">Total Siswa</div></div>
    <div class="stat-card"><div class="stat-card-icon">💰</div><div class="stat-card-value">Rp {{ number_format($totalRevenue/1000000,1) }}M</div><div class="stat-card-label">Revenue Course</div></div>
    <div class="stat-card"><div class="stat-card-icon">✅</div><div class="stat-card-value">{{ $courses->where('is_published', true)->count() }}</div><div class="stat-card-label">Dipublikasikan</div></div>
  </div>

  <!-- Create Course Form -->
  <div class="card" style="margin-bottom:1.5rem">
    <div class="card-header"><span class="card-title">+ Tambah Course Baru</span></div>
    <form method="POST" action="{{ route('course.store') }}" aria-label="Form tambah course baru">
      @csrf
      @if($errors->any())<div class="alert alert-error">❌ {{ $errors->first() }}</div>@endif
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Judul Course <span class="required">*</span></label>
          <input name="title" class="form-input" placeholder="Contoh: Belajar Laravel dari Nol" required value="{{ old('title') }}" aria-label="Judul course">
        </div>
        <div class="form-group">
          <label class="form-label">Instruktur <span class="required">*</span></label>
          <select name="instructor_id" class="form-select" required aria-label="Pilih instruktur">
            <option value="">Pilih instruktur</option>
            @foreach(\App\Models\User::whereIn('role',['programmer','course','admin'])->get() as $u)
            <option value="{{ $u->id }}" {{ old('instructor_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ ucfirst($u->role) }})</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Deskripsi <span class="required">*</span></label>
        <textarea id="course-manager-desc" name="description" class="form-textarea" placeholder="Deskripsi kursus yang detail..." required>{{ old('description') }}</textarea>
        <div id="course-manager-desc-counter" style="font-size:0.78rem;margin-top:4px;font-weight:600;color:var(--text3)">
          Minimal 50 karakter (0/50)
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Level</label>
          <select name="level" class="form-select" aria-label="Level kursus">
            <option value="pemula">Pemula</option>
            <option value="menengah">Menengah</option>
            <option value="mahir">Mahir</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Kategori <span class="required">*</span></label>
          <input name="category" class="form-input" placeholder="Frontend, Backend, Mobile..." required value="{{ old('category') }}" aria-label="Kategori kursus">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Harga (Rp)</label>
          <input type="number" name="price" class="form-input" placeholder="0 untuk gratis" value="{{ old('price', 0) }}" min="0" aria-label="Harga kursus">
        </div>
        <div class="form-group">
          <label class="form-label">Durasi</label>
          <input name="duration" class="form-input" placeholder="Contoh: 8+ jam" value="{{ old('duration') }}" aria-label="Durasi kursus">
        </div>
      </div>
      <div style="display:flex;gap:1rem;margin-bottom:1rem">
        <label style="display:flex;align-items:center;gap:6px;font-size:.85rem;cursor:pointer"><input type="checkbox" name="is_free"> Gratis</label>
        <label style="display:flex;align-items:center;gap:6px;font-size:.85rem;cursor:pointer"><input type="checkbox" name="is_published"> Langsung Publish</label>
      </div>
      <button type="submit" class="btn btn-primary" aria-label="Simpan course baru">💾 Simpan Course</button>
    </form>
  </div>

  <!-- Course List -->
  <div class="card">
    <div class="card-header"><span class="card-title">📚 Semua Course ({{ $courses->total() }})</span></div>
    <div class="table-wrap">
      <table class="data-table">
        <thead><tr><th>Judul</th><th>Instruktur</th><th>Level</th><th>Harga</th><th>Siswa</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          @foreach($courses as $course)
          <tr>
            <td>
              <strong>{{ Str::limit($course->title, 30) }}</strong>
              <div style="font-size:.75rem;color:var(--text3)">{{ $course->total_videos }} video · {{ $course->duration }}</div>
            </td>
            <td style="font-size:.82rem">{{ $course->instructor->name }}</td>
            <td><span class="level-badge level-{{ $course->level }}" style="position:static;font-size:.7rem;font-weight:700;padding:2px 8px;border-radius:99px">{{ $course->level_label }}</span></td>
            <td style="font-size:.875rem;font-weight:600;color:{{ $course->is_free ? 'var(--green)' : 'var(--text)' }}">{{ $course->price_formatted }}</td>
            <td>{{ number_format($course->enrollments->count()) }}</td>
            <td>
              <span class="badge {{ $course->is_published ? 'badge-done' : 'badge-cancelled' }}">
                {{ $course->is_published ? 'Publik' : 'Draft' }}
              </span>
            </td>
            <td>
              <div style="display:flex;gap:.4rem">
                <form method="POST" action="{{ route('course.toggle-publish', $course) }}">
                  @csrf
                  <button type="submit" class="btn btn-sm {{ $course->is_published ? 'btn-ghost' : 'btn-success' }}" aria-label="{{ $course->is_published ? 'Sembunyikan' : 'Publik' }} course {{ $course->title }}">
                    {{ $course->is_published ? 'Sembunyikan' : '✅ Publish' }}
                  </button>
                </form>
                <button onclick="openVideoModal({{ $course->id }}, '{{ addslashes($course->title) }}')" class="btn btn-ghost btn-sm" aria-label="Tambah video ke {{ $course->title }}">+ Video</button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div style="margin-top:1rem">{{ $courses->links() }}</div>
  </div>
</div>

<!-- Add Video Modal -->
<div id="videoModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;padding:1rem">
  <div style="background:var(--bg);border-radius:var(--radius-xl);padding:2rem;max-width:480px;width:100%">
    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:.25rem">+ Tambah Video</h3>
    <p id="videoModalTitle" style="font-size:.85rem;color:var(--text2);margin-bottom:1.25rem"></p>
    <form id="videoForm" method="POST">
      @csrf
      <div class="form-group"><label class="form-label">Judul Video <span class="required">*</span></label><input name="title" class="form-input" placeholder="Contoh: Pengenalan Framework" required></div>
      <div class="form-group"><label class="form-label">URL Video (YouTube Embed) <span class="required">*</span></label><input name="video_url" type="url" class="form-input" placeholder="https://www.youtube.com/embed/..." required></div>
      <div class="form-group"><label class="form-label">Durasi</label><input name="duration" class="form-input" placeholder="Contoh: 45 menit"></div>
      <div style="display:flex;gap:.75rem">
        <button type="submit" class="btn btn-primary" style="flex:1">Tambah Video</button>
        <button type="button" onclick="closeVideoModal()" class="btn btn-ghost">Batal</button>
      </div>
    </form>
  </div>
</div>
@push('scripts')
<script>
function openVideoModal(id, title){
  document.getElementById('videoModal').style.display = 'flex';
  document.getElementById('videoModalTitle').textContent = title;
  document.getElementById('videoForm').action = `${window.APP_URL}/course-manager/course/${id}/video`;
}
function closeVideoModal(){ document.getElementById('videoModal').style.display = 'none'; }
document.getElementById('videoModal')?.addEventListener('click', e=>{ if(e.target===e.currentTarget) closeVideoModal(); });

// Description live counter
document.addEventListener('DOMContentLoaded', function() {
  const descTextarea = document.getElementById('course-manager-desc');
  const descCounter = document.getElementById('course-manager-desc-counter');
  if (descTextarea && descCounter) {
    const updateCount = () => {
      const len = descTextarea.value.length;
      if (len < 50) {
        descCounter.textContent = `Minimal 50 karakter (${len}/50)`;
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
