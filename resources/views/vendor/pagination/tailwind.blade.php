@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <div class="flex justify-center space-x-3">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed rounded-md opacity-50">
                    <span class="text-[0.65rem] mr-1 opacity-75 relative -top-[1px]">&lt;</span> Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-blue-600 hover:text-white hover:border-blue-600 focus:outline-none focus:ring focus:ring-blue-300 active:bg-blue-700 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5 hover:shadow-lg">
                    <span class="text-[0.65rem] mr-1 opacity-75 relative -top-[1px]">&lt;</span> Prev
                </a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-blue-600 hover:text-white hover:border-blue-600 focus:outline-none focus:ring focus:ring-blue-300 active:bg-blue-700 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5 hover:shadow-lg">
                    Next <span class="text-[0.65rem] ml-1 opacity-75 relative -top-[1px]">&gt;</span>
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed rounded-md opacity-50">
                    Next <span class="text-[0.65rem] ml-1 opacity-75 relative -top-[1px]">&gt;</span>
                </span>
            @endif
        </div>
    </nav>
@endif 