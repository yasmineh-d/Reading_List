@if ($paginator->hasPages())
    <nav class="flex items-center justify-center space-x-2" role="navigation" aria-label="Pagination">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-50 text-gray-300 cursor-not-allowed">
                <i data-lucide="chevrons-left" class="w-5 h-5"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-50 text-gray-500 hover:bg-gray-100 transition-colors">
                <i data-lucide="chevrons-left" class="w-5 h-5"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-600 text-white font-semibold text-base shadow-sm">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-transparent text-gray-600 hover:bg-gray-50 transition-colors text-base font-medium">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-50 text-gray-500 hover:bg-gray-100 transition-colors">
                <i data-lucide="chevrons-right" class="w-5 h-5"></i>
            </a>
        @else
            <span class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-50 text-gray-300 cursor-not-allowed">
                <i data-lucide="chevrons-right" class="w-5 h-5"></i>
            </span>
        @endif
    </nav>
@endif