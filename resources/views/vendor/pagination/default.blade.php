@if ($paginator->hasPages())

    <div class="flex align-center">
        {{-- Previous Page Link --}}

        @php
            $current_page_number = $paginator->currentPage();
            $current_page_url = url()->full();
            $next_page_url = '';
            
            $pagesize = '';
            $tab = '';

            $previous_page_url = $paginator->url($current_page_number-1);
            $next_page_url = $paginator->url($current_page_number+1);

            if(request()->has('tab')) {
                $tab = request()->input('tab');
                $previous_page_url = $previous_page_url . "&tab=" . $tab;
                $next_page_url = $next_page_url . "&tab=" . $tab;
            }
            if(request()->has('pagesize')) {
                $pagesize = request()->input('pagesize');
                $previous_page_url = $previous_page_url . "&pagesize=" . $pagesize;
                $next_page_url = $next_page_url . "&pagesize=" . $pagesize;
            }
            if(request()->has('k')) {
                $k = request()->input('k');
                $previous_page_url = $previous_page_url . "&k=" . $k;
                $next_page_url = $next_page_url . "&k=" . $k;
            }

            // These checks for advanced search section
            if(request()->has('forum')) {
                $forum = request()->input('forum');
                $previous_page_url = $previous_page_url . "&forum=" . $forum;
                $next_page_url = $next_page_url . "&forum=" . $forum;
            }
            if(request()->has('category')) {
                $category = request()->input('category');
                $previous_page_url = $previous_page_url . "&category=" . $category;
                $next_page_url = $next_page_url . "&category=" . $category;
            }
            if(request()->has('threads_date')) {
                $threads_date = request()->input('threads_date');
                $previous_page_url = $previous_page_url . "&threads_date=" . $threads_date;
                $next_page_url = $next_page_url . "&threads_date=" . $threads_date;
            }
            if(request()->has('sorted_by')) {
                $sorted_by = request()->input('sorted_by');
                $previous_page_url = $previous_page_url . "&sorted_by=" . $sorted_by;
                $next_page_url = $next_page_url . "&sorted_by=" . $sorted_by;
            }
            if(request()->has('hasbestreply')) {
                $hasbestreply = request()->input('hasbestreply');
                $previous_page_url = $previous_page_url . "&hasbestreply=" . $hasbestreply;
                $next_page_url = $next_page_url . "&hasbestreply=" . $hasbestreply;
            }

        @endphp

        @if (!$paginator->onFirstPage())
            <a href="{{ $previous_page_url }}" class="pagination-item pag-active" rel="prev" aria-label="@lang('pagination.previous')">{{__('Back')}}</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="pagination-disabled pagination-item unselectable" aria-disabled="true">..</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @php
                        if(request()->has('tab')) {
                            $url = $url . "&tab=" . $tab;
                        }
                        if(request()->has('pagesize')) {
                            $url = $url . "&pagesize=" . $pagesize;
                        }
                        if(request()->has('k')) {
                            $url = $url . "&k=" . $k;
                        }
                        // Advanced search checks
                        if(request()->has('forum')) {
                            $url = $url . "&forum=" . $forum;
                        }
                        if(request()->has('category')) {
                            $url = $url . "&category=" . $category;
                        }
                        if(request()->has('threads_date')) {
                            $url = $url . "&threads_date=" . $threads_date;
                        }
                        if(request()->has('sorted_by')) {
                            $url = $url . "&sorted_by=" . $sorted_by;
                        }
                        if(request()->has('hasbestreply')) {
                            $url = $url . "&hasbestreply=" . $hasbestreply;
                        }
                    @endphp
                    @if ($page == $paginator->currentPage())
                        <a href="{{ $url }}" class="pagination-item-selected pagination-item" aria-current="page">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}" class="pagination-item pag-active" >{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $next_page_url }}" class="pagination-item pag-active" aria-disabled="true" aria-label="@lang('pagination.next')">{{__('Next')}}</a>
        @endif
    </div>
@endif

