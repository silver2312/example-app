@if ($paginator->hasPages())
<nav aria-label="Page navigation example">
    <ul class="pagination">

        @if ($paginator->onFirstPage())
            <li class="disabled page-item"><span class="sr-only"><i class="fa fa-angle-left"></i>Previous</span></li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                    <i class="fa fa-angle-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        @endif



        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="sr-only">{{ $element }}</span>
                </li>
            @endif



            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ $page }}<span class="sr-only">(current)</span></a>
                        </li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach



        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                  <i class="fa fa-angle-right"></i>
                  <span class="sr-only">Next</span>
                </a>
            </li>
        @else
            <li class="page-item disable">
                <i class="fa fa-angle-right"></i>
                <span class="sr-only">Next</span>
            </li>
        @endif
    </ul>
</nav>
@endif
