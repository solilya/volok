@if ($paginator->hasPages())
   <BR>
   <center> 
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())

                <span aria-hidden="true">&lt;</span>

        @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lt;</a>&nbsp;
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
               <span>{{ $element }}&nbsp;</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span>{{ $page }}&nbsp;</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>&nbsp;
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&gt;</a>
        @else
                          <span aria-hidden="true">&gt;</span>
            
        @endif
</center>
@endif
