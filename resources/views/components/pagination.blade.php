@php
$currentPage = $paginator->currentPage();
$totalPages = $paginator->lastPage();

function getVisiblePages($current, $total) {
    $pages = [];
    
    if ($total <= 5) {
        for ($i = 1; $i <= $total; $i++) $pages[] = $i;
    } elseif ($current <= 4) {
        for ($i = 1; $i <= 5; $i++) $pages[] = $i;
        $pages[] = 'ellipsis';
        $pages[] = $total;
    } elseif ($current >= $total - 3) {
        $pages[] = 1;
        $pages[] = 'ellipsis';
        for ($i = $total - 4; $i <= $total; $i++) $pages[] = $i;
    } else {
        $pages[] = 1;
        $pages[] = 'ellipsis';
        $pages[] = $current - 1;
        $pages[] = $current;
        $pages[] = $current + 1;
        $pages[] = 'ellipsis';
        $pages[] = $total;
    }
    
    return $pages;
}
@endphp

@if ($totalPages > 1)
    <div class="pagination">
        <button 
            type="button"
            class="page-btn page-arrow" 
            @if ($currentPage === 1) disabled @endif 
            onclick="window.location.href='{{ $paginator->previousPageUrl() }}'"
            {{ $currentPage === 1 ? 'disabled' : '' }}
        >
            <svg width="9" height="15" viewBox="0 0 9 15" fill="none">
                <path d="M0.292793 8.07112C-0.0977311 7.6806 -0.0977311 7.04743 0.292793 6.65691L6.65675 0.292946C7.04728 -0.0975785 7.68044 -0.0975785 8.07097 0.292946C8.46149 0.68347 8.46149 1.31664 8.07097 1.70716L2.41411 7.36401L8.07097 13.0209C8.46149 13.4114 8.46149 14.0446 8.07097 14.4351C7.68044 14.8256 7.04728 14.8256 6.65675 14.4351L0.292793 8.07112Z" fill="black"/>
            </svg>
        </button>

        @foreach (getVisiblePages($currentPage, $totalPages) as $page)
            @if ($page === 'ellipsis')
                <span class="page-btn page-ellipsis">…</span>
            @elseif ($page === $currentPage)
                <button type="button" class="page-btn active">{{ $page }}</button>
            @else
                @php $url = $paginator->url($page); @endphp
                <button type="button" class="page-btn" onclick="window.location.href='{{ $url }}'">{{ $page }}</button>
            @endif
        @endforeach

        <button 
            type="button"
            class="page-btn page-arrow" 
            @if ($currentPage === $totalPages) disabled @endif 
            onclick="window.location.href='{{ $paginator->nextPageUrl() }}'"
            {{ $currentPage === $totalPages ? 'disabled' : '' }}
        >
            <svg width="9" height="15" viewBox="0 0 9 15" fill="none">
                <path d="M8.07098 8.07112C8.4615 7.6806 8.4615 7.04743 8.07098 6.65691L1.70702 0.292946C1.31649 -0.0975785 0.683326 -0.0975785 0.292802 0.292946C-0.0977225 0.68347 -0.0977225 1.31664 0.292802 1.70716L5.94966 7.36401L0.292802 13.0209C-0.0977225 13.4114 -0.0977225 14.0446 0.292802 14.4351C0.683326 14.8256 1.31649 14.8256 1.70702 14.4351L8.07098 8.07112Z" fill="black"/>
            </svg>
        </button>
    </div>
@endif