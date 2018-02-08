@if ($paginator->hasPages())
    <div class="page">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="disabled">首页</span>
        @else
            <span><a href="{{ $paginator->previousPageUrl() }}" rel="prev">首页</a></span>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="disabled">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="" class="on">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            {{--<li>&raquo;</a></li>--}}
            <span><a href="{{ $paginator->nextPageUrl() }}" rel="next">尾页</a></span>
        @else
            <span class="disabled">尾页</span>
        @endif
    </div>
@endif
