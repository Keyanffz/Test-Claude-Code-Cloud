@if ($paginator->hasPages())
    <nav class="flex items-center justify-between gap-4" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="label-mono text-muted/50">← Newer</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="label-mono hover:text-signal">← Newer</a>
        @endif

        <span class="label-mono tabular-nums text-muted">Page {{ $paginator->currentPage() }}{{ method_exists($paginator, 'lastPage') ? ' of '.$paginator->lastPage() : '' }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="label-mono hover:text-signal">Older →</a>
        @else
            <span class="label-mono text-muted/50">Older →</span>
        @endif
    </nav>
@endif
