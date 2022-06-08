@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/simplemde.js') }}" defer></script>
    <script src="{{ asset('js/fetch/category-threads-fetch.js') }}" defer></script>
    <script src="{{ asset('js/post.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'threads'])
    <style>
        .section-style {
            background-color: #f7f7f7;
            padding: 12px;
            border-radius: 4px;
            border: 1px solid #d7d7d7;
        }
    </style>
    <input type="hidden" id="forum-slug" value="{{ request('forum')->slug }}">
    <input type="hidden" class="current-threads-count" autocomplete="off" value="{{ $pagesize }}">
    <input type="hidden" class="date-tab" autocomplete="off" value="{{ $tab }}">
    <input type="hidden" id="forum-id" value="{{ $forum->id }}">
    <input type="hidden" id="category-id" value="{{ $category->id }}">
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="link-path flex align-center">
            <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                {!! $forum->icon !!}
            </svg>
            {{ __($forum->forum) }}
        </a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('category.threads', ['forum'=>request()->forum->slug, 'category'=>$category->slug]) }}" class="link-path">{{ __($category->category) }}</a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path">{{ __('Posts') }}</span>
    </div>
    <div class="index-middle-width middle-container-style">
        @php
            $forumstatus = $forum->status->slug;
            $categorystatus = $category->status->slug;
        @endphp
        <div class="flex" style="margin: 16px 0">
            <svg class="size30 mr8" style="margin-top: 2px" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                {!! $forum->icon !!}
            </svg>
            <div>
                <h1 class="forum-color fs30 no-margin">{{ __(request()->forum->forum) . __(' Forum') }}</h1>
                <h2 class="forum-color fs15 no-margin">{{ __('Category') . " : " . __($category->category) }}</h2>
            </div>
        </div>
        <!-- display close notice if the forum or category is closed -->
        @if($forumstatus == 'closed')
        <div class="section-style my8">
            <div class="flex align-center">
                <span class="fs15 bold lblack">{{__('Notice')}}</span>
            </div>
            <p class="fs13 my4 lblack">{{__("The forum that this category blongs to has been closed by admins. We shared an announcement to clarify this decision If you want to know the reason for the close")}}.</p>
            <p class="fs13 my4 lblack">{{__("You cannot add new posts to this category anymore. However you can see all previous posts and activities and react to old posts")}}.</p>
        </div>
        @elseif($categorystatus == 'closed')
        <div class="section-style my8">
            <div class="flex align-center">
                <span class="fs15 bold lblack">{{__('Notice')}}</span>
            </div>
            <p class="fs13 my4 lblack">{{__("This category has been closed by admins. We shared an announcement to clarify this decision If you want to know the reason for the close")}}.</p>
            <p class="fs13 my4 lblack">{{__("You can't share posts to this category anymore. However you can see all previous posts and activities and react to old posts")}}.</p>
        </div>
        @endif
        <div class="flex align-center">
            <form action="{{ route('advanced.search.results') }}" class="flex full-width">
                <input type="hidden" name="forum" value="{{ request()->forum->id }}">
                <input type="hidden" name="category" value="{{ $category->id }}">
                <input type="text" name="k" class="input-style-1 full-width" placeholder="{{ __('Search in this category') }}" required>
                <button type="submit" class="button-style-1 flex align-center ml4">
                    <svg class="size15 mr4" fill="#fff" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                    {{ __('Search') }}
                </button>
            </form>
            <a href="{{ route('advanced.search') }}" class="link-path flex align-center mr4 ml8">
                <svg class="size12 mr4" style="min-width: 14px; fill: #2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511 511"><path d="M492,0H21A20,20,0,0,0,1,20,195,195,0,0,0,66.37,165.55l87.42,77.7a71.1,71.1,0,0,1,23.85,53.12V491a20,20,0,0,0,31,16.6l117.77-78.51a20,20,0,0,0,8.89-16.6V296.37a71.1,71.1,0,0,1,23.85-53.12l87.41-77.7A195,195,0,0,0,512,20,20,20,0,0,0,492,0ZM420.07,135.71l-87.41,77.7a111.1,111.1,0,0,0-37.25,83V401.82l-77.85,51.9V296.37a111.1,111.1,0,0,0-37.25-83L92.9,135.71A155.06,155.06,0,0,1,42.21,39.92H470.76A155.06,155.06,0,0,1,420.07,135.71Z"/></svg>
                <span class="width-max-content">{{ __('Adv. search') }}</span>
            </a>
        </div>
        <div class="simple-line-separator my8"></div>
        <h2 class="fs22 blue unselectable my8 flex align-center">{{ __('Posts') }}</h2>
        <div class="flex align-end space-between mb2">
            <div class="mb4">
                <div class="flex align-center">
                    <p class="no-margin gray fs12 unselectable">{{__('Forum')}}</p>
                    <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                    <div class="relative">
                        <div class="flex align-center forum-color button-with-suboptions pointer fs12">
                            <svg class="small-image-size thread-add-forum-icon mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                {!! $forum->icon !!}
                            </svg>
                            <span class="thread-add-selected-forum">{{ __($forum->forum) }}</span>
                            <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                        </div>
                        <div class="suboptions-container thread-add-suboptions-container" style="max-height: 236px; overflow-y: scroll">
                            @foreach($forums as $f)
                                <a href="{{ route('forum.all.threads', ['forum'=>$f->slug]) }}" class="@if($f->id == $forum->id) block-click @endif thread-add-suboption black no-underline flex align-center" style="@if($f->id == $forum->id) background-color: #e1e1e1; cursor: default @endif">
                                    <svg class="small-image-size forum-ico mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        {!! $f->icon !!}
                                    </svg>
                                    <span>{{ __($f->forum) }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex" style="margin-left: 17px">
                    <svg class="size14 mr8" style="margin-top: 3px" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                    <div class="flex align-center mt8">
                        <p class="no-margin fs12 gray">{{ __('Category') }} </p>
                        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                        <div class="relative">
                            <div class="flex align-center forum-color button-with-suboptions pointer fs12">
                                <span class="fs13 bold">{{ __($category->category) }}</span>
                                <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                            </div>
                            <div class="suboptions-container thread-add-suboptions-container width-max-content" style="width: max-content; max-height: 236px; overflow-y: scroll">
                                <a href="{{ route('forum.all.threads', ['forum'=>$category->forum->slug]) }}" class="thread-add-suboption black no-underline flex align-center">
                                    <span>{{ __('All categories') }}</span>
                                </a>
                                @foreach($categories as $c)
                                    <a href="{{ route('category.threads', ['forum'=>$c->forum->slug, 'category'=>$c->slug]) }}" class="@if($c->id == $category->id) block-click @endif thread-add-suboption black no-underline flex align-center" style="@if($c->id == $category->id) background-color: #e1e1e1; cursor: default @endif">
                                        <span>{{ __($c->category) }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="relative mr4">
                <div class="flex align-center forum-color button-with-suboptions pointer fs13 py4">
                    <span class="mr4 gray unselectable">{{ __('Filter by date') }}:</span>
                    <span class="forum-color fs13 bold unselectable">{{ __($tab_title) }}</span>
                    <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                </div>
                <div class="suboptions-container thread-add-suboptions-container" style="width: 220px">
                    <a href="?tab=all" class="no-underline thread-add-suboption sort-by-option flex">
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('All') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get all posts sorted by the newest created') }}</p>
                            <input type="hidden" class="tab" value="all">
                        </div>
                        <div class="loading-dots-anim ml4 none">•</div>
                    </a>
                    <a href="?tab=today" class="no-underline thread-add-suboption sort-by-option flex">
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('Today') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get only posts created today. (This will be sorted by number of views)') }}</p>
                            <input type="hidden" class="tab" value="today">
                        </div>
                        <div class="loading-dots-anim ml4 none">•</div>
                    </a>
                    <a href="?tab=thisweek" class="no-underline thread-add-suboption sort-by-option flex">
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('This week') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get only posts created this week. (This will be sorted by number of views)') }}</p>
                            <input type="hidden" class="sort-by-key" value="votes">
                        </div>
                        <div class="loading-dots-anim ml4 none">•</div>
                    </a>
                </div>
            </div>
        </div>
        <div id="threads-global-container">
            @foreach($threads as $thread)
                <x-index-resource :thread="$thread"/>
            @endforeach
        </div>

        @if(!$threads->count())
        <div class="full-center thread-container-box" style="margin-top: 20px; padding: 20px">
            <style>
                .thread-container-box {
                    border: none;
                }
            </style>
            <div class="flex flex-column align-center">
                <svg class="size48 my8" viewBox="0 0 442 442"><path d="M442,268.47V109.08a11.43,11.43,0,0,0-.1-1.42,2.51,2.51,0,0,0,0-.27,10.11,10.11,0,0,0-.29-1.3v0c-.1-.31-.21-.62-.34-.92l-.12-.26-.15-.32c-.17-.34-.36-.67-.56-1a.57.57,0,0,1-.08-.13,10.33,10.33,0,0,0-.81-1l-.17-.18a8,8,0,0,0-.84-.81l-.14-.12a9.65,9.65,0,0,0-1.05-.76l-.26-.15a8.61,8.61,0,0,0-1.05-.53.67.67,0,0,0-.12-.06l-236-99-.06,0-.28-.1a10,10,0,0,0-4.4-.61h-.08a10.59,10.59,0,0,0-1.94.39l-.12,0c-.27.09-.55.18-.82.29l0,0-69.22,29a10,10,0,0,0,0,18.44L186,74.73v88.16L6.13,238.37l-.36.17-.36.17c-.28.15-.55.31-.82.48l-.13.07s0,0,0,0a9.86,9.86,0,0,0-1,.72l-.09.08c-.25.23-.49.46-.72.71l-.2.22a8.19,8.19,0,0,0-.53.67c-.07.08-.13.17-.19.25-.18.27-.34.54-.5.81l-.09.15c-.17.33-.32.67-.46,1,0,.09-.07.19-.1.28-.09.26-.18.53-.25.79l-.09.35c-.06.28-.12.55-.16.83,0,.1,0,.19,0,.28A11.87,11.87,0,0,0,0,247.62V333a10,10,0,0,0,6.13,9.22l235.92,99a9.8,9.8,0,0,0,1.95.6l.19,0c.26.05.52.09.79.12s.66.05,1,.05.67,0,1-.05.53-.07.79-.12l.19,0a9.8,9.8,0,0,0,2-.6l186-78A10,10,0,0,0,442,354V268.47ZM330.23,300.4l-63.15-26.49a10,10,0,0,0-7.74,18.44l45,18.9L246,335.75,137.62,290.29l58.4-24.5,35.53,14.9a10,10,0,1,0,7.74-18.44l-33.27-14V184.58l200.13,84ZM186,248.29l-74.25,31.16L35.85,247.59l150.17-63v63.71ZM196,20.84,406.15,109l-43.37,18.2L200,58.89l-.09,0L152.65,39Zm162.82,126.4a10,10,0,0,0,7.81,0L422,124.05V253.51L206,162.89V83.13ZM20,262.63l216,90.62V417L20,326.34ZM422,347.3,256,417V353.25l166-69.66Z"/></svg>
                <p class="fs20 bold gray text-center" style="margin: 10px 0 16px 0">{{ __("There are no posts at the moment try out later or change the category or date filter") }}.</p>
                <p class="my4 text-center">{{ __("Or create your own post") }} <a href="{{ route('thread.add') }}" class="link-path">{{__('here')}}</a></p>
            </div>
        </div>
        @else
            @if($hasmore)
                @include('partials.thread.faded-thread', ['classes'=>'category-threads-fetch-more'])
            @else
                <style>
                    .thread-container-box:last-child {
                        border-bottom: 1px solid #b7c0c6;
                    }
                </style>
            @endif
        @endif

    </div>
    <div id="right-panel">
        <x-right-panels.forumslist/>
        <x-right-panels.recentthreads/>
        <div class="sticky" style="top: 70px">
            @include('partials.right-panels.feedback')
        </div>
    </div>
@endsection