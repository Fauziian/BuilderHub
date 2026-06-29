@if ($paginator->hasPages())
<style>
  .pagination-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 2rem;
    padding: .75rem 0;
    flex-wrap: wrap;
    gap: 1rem;
    width: 100%;
    position: relative;
  }
  .pagination-spacer {
    flex: 1;
    min-width: 200px;
  }
  .pagination-pages {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .25rem;
  }
  .pagination-info {
    flex: 1;
    min-width: 200px;
    text-align: right;
    font-size: .8rem;
    color: #6B7280;
  }
  @media (max-width: 991px) {
    .pagination-container {
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 1rem;
    }
    .pagination-spacer {
      display: none;
    }
    .pagination-info {
      text-align: center;
      flex: none;
      width: 100%;
    }
  }
</style>

<div class="pagination-container">

  {{-- Left spacer to balance the right info and keep the pages centered --}}
  <div class="pagination-spacer"></div>

  {{-- ══ PAGINATION ROW (centered) ══ --}}
  <div class="pagination-pages">

    {{-- ‹ Sebelumnya --}}
    @if ($paginator->onFirstPage())
      <span style="padding:6px 14px;border-radius:8px;border:1px solid #E5E7EB;background:#F9FAFB;color:#D1D5DB;font-size:.82rem;font-weight:500;cursor:not-allowed;user-select:none;white-space:nowrap">
        ‹ Sebelumnya
      </span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
        style="padding:6px 14px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#374151;font-size:.82rem;font-weight:500;text-decoration:none;white-space:nowrap;transition:all .15s"
        onmouseover="this.style.borderColor='#4F46E5';this.style.color='#4F46E5'"
        onmouseout="this.style.borderColor='#E5E7EB';this.style.color='#374151'">
        ‹ Sebelumnya
      </a>
    @endif

    {{-- Page numbers (Smart sliding window with dynamic ellipsis placement) --}}
    @php
      $current = $paginator->currentPage();
      $last = $paginator->lastPage();
      
      $elements = [];
      
      if ($last <= 5) {
          for ($i = 1; $i <= $last; $i++) {
              $elements[] = $i;
          }
      } else {
          if ($current <= 3) {
              $x = 2;
          } elseif ($current >= $last - 2) {
              $x = $last - 3;
          } else {
              $x = $current - 1;
          }
          $y = $x + 1;
          $z = $x + 2;
          
          if ($x < $last - 3) {
              $elements[] = 1;
              $elements[] = $x;
              $elements[] = $y;
              $elements[] = $z;
              $elements[] = '...';
              $elements[] = $last;
          } else {
              $elements[] = 1;
              $elements[] = '...';
              $elements[] = $x;
              $elements[] = $y;
              $elements[] = $z;
              $elements[] = $last;
          }
      }
    @endphp

    {{-- Render page elements --}}
    @foreach ($elements as $element)
      @if ($element === '...')
        <span style="width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;font-size:.82rem;color:#9CA3AF">…</span>
      @elseif ($element == $current)
        <span aria-current="page"
          style="width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;background:#4F46E5;color:#fff;font-size:.85rem;font-weight:700;box-shadow:0 2px 8px rgba(79,70,229,.4);cursor:default">
          {{ $element }}
        </span>
      @else
        <a href="{{ $paginator->url($element) }}"
          style="width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#374151;font-size:.85rem;font-weight:500;text-decoration:none;transition:all .15s"
          onmouseover="this.style.background='#EEF2FF';this.style.borderColor='#4F46E5';this.style.color='#4F46E5'"
          onmouseout="this.style.background='#fff';this.style.borderColor='#E5E7EB';this.style.color='#374151'">
          {{ $element }}
        </a>
      @endif
    @endforeach

    {{-- Selanjutnya › --}}
    @if ($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}" rel="next"
        style="padding:6px 14px;border-radius:8px;border:1px solid #E5E7EB;background:#fff;color:#374151;font-size:.82rem;font-weight:500;text-decoration:none;white-space:nowrap;transition:all .15s"
        onmouseover="this.style.borderColor='#4F46E5';this.style.color='#4F46E5'"
        onmouseout="this.style.borderColor='#E5E7EB';this.style.color='#374151'">
        Selanjutnya ›
      </a>
    @else
      <span style="padding:6px 14px;border-radius:8px;border:1px solid #E5E7EB;background:#F9FAFB;color:#D1D5DB;font-size:.82rem;font-weight:500;cursor:not-allowed;user-select:none;white-space:nowrap">
        Selanjutnya ›
      </span>
    @endif
  </div>

  {{-- ══ Result info — right aligned ══ --}}
  <div class="pagination-info">
    Menampilkan <strong style="color:#111827">{{ $paginator->firstItem() ?? 0 }}</strong>–<strong style="color:#111827">{{ $paginator->lastItem() ?? 0 }}</strong> dari <strong style="color:#111827">{{ $paginator->total() }}</strong> hasil
  </div>

</div>
@endif
