
@if ($paginator->hasPages())
<table cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <!-- Previous Page Link -->
            @if (!$paginator->onFirstPage())
                <td class="pagingIntact"><a href="{{ $paginator->previousPageUrl() }}">Quay lại</a></td>
            @endif
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <td class="pagingViewed">{{ $page }}</td>
                        @else
                            <td class="pagingIntact"><a href="{{ $url }}">{{ $page }}</a></td>
                        @endif
                    @endforeach
                @endif
                <td class="pagingSpace"></td>                
            @endforeach

            <!-- Next Page Link -->
            @if ($paginator->hasMorePages())
                <td class="pagingIntact"><a href="{{ $paginator->nextPageUrl() }}">Tiếp theo</a></td>
            @endif
        </tr>
    </tbody>
</table>
@endif

