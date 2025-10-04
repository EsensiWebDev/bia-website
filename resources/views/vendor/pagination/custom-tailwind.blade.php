@if ($paginator->hasPages())
    <nav class="flex items-center justify-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-4 py-2 bg-[#203B6E] text-white rounded-md hover:bg-[#7DB8D8] transition">Prev</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-4 py-2 text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="px-4 py-2 bg-[#7DB8D8] text-white font-semibold rounded-md">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-[#7DB8D8] hover:text-white transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="px-4 py-2 bg-[#203B6E] text-white rounded-md hover:bg-[#7DB8D8] transition">Next</a>
        @else
            <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">Next</span>
        @endif
    </nav>
@endif
