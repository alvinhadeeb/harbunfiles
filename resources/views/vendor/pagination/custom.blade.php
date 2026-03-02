@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center mt-8">
        <div class="flex items-center gap-2 flex-wrap justify-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-5 py-3 text-sm font-semibold text-gray-400 bg-gray-100 border-2 border-gray-200 rounded-xl cursor-not-allowed shadow-sm">
                    ← Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-5 py-3 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-purple-50 hover:border-[#8280af] transition duration-300 shadow-sm hover:shadow-md" style="hover:color: #8280af;">
                    ← Sebelumnya
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="hidden sm:flex items-center gap-2">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="px-3 py-2 text-sm font-medium text-gray-500">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-4 py-3 text-sm font-bold text-white border-2 rounded-xl shadow-md" style="background-color: #8280af; border-color: #8280af;">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-3 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-purple-50 transition duration-300 shadow-sm hover:shadow-md hover:border-[#8280af]">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Mobile: Current Page Indicator --}}
            <div class="flex sm:hidden items-center px-5 py-3 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl shadow-sm">
                <span>Halaman {{ $paginator->currentPage() }}</span>
                <span class="mx-2 text-gray-400">dari</span>
                <span>{{ $paginator->lastPage() }}</span>
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-5 py-3 text-sm font-semibold text-white border-2 rounded-xl transition duration-300 shadow-md hover:shadow-lg hover:opacity-90" style="background-color: #8280af; border-color: #8280af;">
                    Selanjutnya →
                </a>
            @else
                <span class="px-5 py-3 text-sm font-semibold text-gray-400 bg-gray-100 border-2 border-gray-200 rounded-xl cursor-not-allowed shadow-sm">
                    Selanjutnya →
                </span>
            @endif
        </div>
    </nav>
@endif
