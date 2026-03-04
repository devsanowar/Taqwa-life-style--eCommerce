@if ($paginator->hasPages())
    <div class="pagination__area bg__gray--color">
        <nav class="pagination justify-content-center">
            <ul class="pagination__wrapper d-flex align-items-center justify-content-center">

                {{-- Previous --}}
                <li class="pagination__list">
                    @if ($paginator->onFirstPage())
                        <span class="pagination__item--arrow link disabled" aria-disabled="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48"
                                      d="M244 400L100 256l144-144M120 256h292"/>
                            </svg>
                            <span class="visually-hidden">pagination arrow</span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="pagination__item--arrow link" rel="prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48"
                                      d="M244 400L100 256l144-144M120 256h292"/>
                            </svg>
                            <span class="visually-hidden">pagination arrow</span>
                        </a>
                    @endif
                </li>

                {{-- Page Numbers (same design + smart dots) --}}
                @php
                    $current = $paginator->currentPage();
                    $last    = $paginator->lastPage();
                @endphp

                @for ($page = 1; $page <= $last; $page++)
                    @if ($last > 10)
                        @php
                            $show =
                                $page <= 3 ||
                                $page >= $last - 2 ||
                                ($page >= $current - 2 && $page <= $current + 2);
                        @endphp

                        @if ($show)
                            <li class="pagination__list">
                                @if ($page == $current)
                                    <span class="pagination__item pagination__item--current">{{ $page }}</span>
                                @else
                                    <a href="{{ $paginator->url($page) }}" class="pagination__item link">{{ $page }}</a>
                                @endif
                            </li>
                        @elseif ($page == 4 || $page == $last - 3)
                            <li class="pagination__list">
                                <span class="pagination__item link disabled" aria-disabled="true">...</span>
                            </li>
                        @endif
                    @else
                        <li class="pagination__list">
                            @if ($page == $current)
                                <span class="pagination__item pagination__item--current">{{ $page }}</span>
                            @else
                                <a href="{{ $paginator->url($page) }}" class="pagination__item link">{{ $page }}</a>
                            @endif
                        </li>
                    @endif
                @endfor

                {{-- Next --}}
                <li class="pagination__list">
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="pagination__item--arrow link" rel="next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48"
                                      d="M268 112l144 144-144 144M392 256H100"/>
                            </svg>
                            <span class="visually-hidden">pagination arrow</span>
                        </a>
                    @else
                        <span class="pagination__item--arrow link disabled" aria-disabled="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48"
                                      d="M268 112l144 144-144 144M392 256H100"/>
                            </svg>
                            <span class="visually-hidden">pagination arrow</span>
                        </span>
                    @endif
                </li>

            </ul>
        </nav>
    </div>
@endif
