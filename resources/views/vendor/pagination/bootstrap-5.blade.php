@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link"><small class="arrow">&lt;</small> Prev</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><small class="arrow">&lt;</small> Prev</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next <small class="arrow">&gt;</small></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">Next <small class="arrow">&gt;</small></span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .pagination {
            gap: 10px;
        }
        .page-link {
            border-radius: 4px !important;
            padding: 8px 16px !important;
            border: 1px solid #dee2e6;
            background-color: white;
            color: #6c757d;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .page-link .arrow {
            font-size: 70%;
            vertical-align: middle;
            position: relative;
            top: -1px;
            opacity: 0.75;
        }
        .page-link:hover {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
        }
        .page-item.disabled .page-link {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #adb5bd;
            pointer-events: none;
        }
    </style>
@endif 