@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/simplemde.js') }}" defer></script>
    <script src="{{ asset('js/fetch/forum-threads-fetch.js') }}" defer></script>
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
        <span class="current-link-path unselectable">{{ __('All categories') }}</span>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path unselectable">{{ __('Posts') }}</span>
    </div>
    <div class="index-middle-width middle-container-style">
        @php $forumstatus = $forum->status->slug; @endphp
        <input type="hidden" class="current-threads-count" autocomplete="off" value="{{ $pagesize }}">
        <input type="hidden" class="date-tab" autocomplete="off" value="{{ $tab }}">
        <input type="hidden" id="forum-id" autocomplete="off" value="{{ $forum->id }}">
        @if(Session::has('message'))
            <div class="green-message-container mb8">
                <p class="green-message">{{ Session::get('message') }}</p>
            </div>
        @endif
        <div class="full-width">
            <input type="hidden" id="forum-slug" value="{{ request('forum')->slug }}">
            <div class="flex align-center" style="margin: 16px 0">
                <svg class="size30 mr8" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    {!! $forum->icon !!}
                </svg>
                <h1 class="forum-color fs30 no-margin">{{ __(request()->forum->forum) . ' ' . __('Forum') }} @if($forumstatus=='closed') - <span class="red">{{ __('CLOSED') }}</span> @endif</h1>
            </div>
            @if($forum->status->slug == 'closed')
            <style>
                .section-style {
                    background-color: #f7f7f7;
                    padding: 12px;
                    border-radius: 4px;
                    border: 1px solid #d7d7d7;
                }
            </style>
            <div class="section-style my8">
                <div class="flex align-center">
                    <span class="fs15 bold lblack">{{__('Notice')}}</span>
                </div>
                <p class="fs13 my4 lblack">{{__("This forum has been closed by admins. We shared an announcement to clarify this decision If you want to know the reason for the close")}}.</p>
                <p class="fs13 my4 lblack">{{__("You cannot add new posts to this forum or its categories anymore. However you can see all previous posts and activities and react to other people posts")}}.</p>
            </div>
            @endif

            @if($announcements->count() != 0)
                <div class="flex align-center space-between">
                    <h2 class="fs22 blue unselectable my8 flex align-center">{{ __('Announcements') }}</h2>
                    @if($announcements->count() > 2)
                    <a href="{{ route('announcements') }}" class="blue no-underline bold">{{ __('See all') }}</a>
                    @endif
                </div>
                @foreach($announcements as $announcement)
                    <x-thread.announcement :announcement="$announcement"/>
                @endforeach
                <div class="simple-line-separator" style="margin: 14px 0"></div>
            @endif
            <h2 class="fs22 blue unselectable my8 flex align-center">{{ __('Posts') }}</h2>
            <div class="flex align-center space-between mb2">
                <div class="flex align-center">
                    <div class="flex align-center">
                        <p class="no-margin fs12 gray">{{ __('Category') }} </p>
                        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                        <div class="relative">
                            <div class="flex align-center forum-color button-with-suboptions pointer fs12">
                                <span class="fs13 bold">{{ __('All categories') }}</span>
                                <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                            </div>
                            <div class="suboptions-container thread-add-suboptions-container width-max-content" style="width: max-content; max-height: 236px; overflow-y: scroll">
                                <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="block-click thread-add-suboption black no-underline flex align-center" style="background-color: #e1e1e1; cursor: default">
                                    <span>{{ __('All categories') }}</span>
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('category.threads', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="thread-add-suboption black no-underline flex align-center">
                                        <span>{{ __($category->category) }}</span>
                                    </a>
                                @endforeach
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
            <style>
                .thread-container-box {
                    border: none;
                }
            </style>
            <div class="full-center thread-container-box" style="margin-top: 20px; padding: 20px">
                <div class="flex flex-column align-center">
                    <svg class="size48 my8" viewBox="0 0 442 442"><path d="M442,268.47V109.08a11.43,11.43,0,0,0-.1-1.42,2.51,2.51,0,0,0,0-.27,10.11,10.11,0,0,0-.29-1.3v0c-.1-.31-.21-.62-.34-.92l-.12-.26-.15-.32c-.17-.34-.36-.67-.56-1a.57.57,0,0,1-.08-.13,10.33,10.33,0,0,0-.81-1l-.17-.18a8,8,0,0,0-.84-.81l-.14-.12a9.65,9.65,0,0,0-1.05-.76l-.26-.15a8.61,8.61,0,0,0-1.05-.53.67.67,0,0,0-.12-.06l-236-99-.06,0-.28-.1a10,10,0,0,0-4.4-.61h-.08a10.59,10.59,0,0,0-1.94.39l-.12,0c-.27.09-.55.18-.82.29l0,0-69.22,29a10,10,0,0,0,0,18.44L186,74.73v88.16L6.13,238.37l-.36.17-.36.17c-.28.15-.55.31-.82.48l-.13.07s0,0,0,0a9.86,9.86,0,0,0-1,.72l-.09.08c-.25.23-.49.46-.72.71l-.2.22a8.19,8.19,0,0,0-.53.67c-.07.08-.13.17-.19.25-.18.27-.34.54-.5.81l-.09.15c-.17.33-.32.67-.46,1,0,.09-.07.19-.1.28-.09.26-.18.53-.25.79l-.09.35c-.06.28-.12.55-.16.83,0,.1,0,.19,0,.28A11.87,11.87,0,0,0,0,247.62V333a10,10,0,0,0,6.13,9.22l235.92,99a9.8,9.8,0,0,0,1.95.6l.19,0c.26.05.52.09.79.12s.66.05,1,.05.67,0,1-.05.53-.07.79-.12l.19,0a9.8,9.8,0,0,0,2-.6l186-78A10,10,0,0,0,442,354V268.47ZM330.23,300.4l-63.15-26.49a10,10,0,0,0-7.74,18.44l45,18.9L246,335.75,137.62,290.29l58.4-24.5,35.53,14.9a10,10,0,1,0,7.74-18.44l-33.27-14V184.58l200.13,84ZM186,248.29l-74.25,31.16L35.85,247.59l150.17-63v63.71ZM196,20.84,406.15,109l-43.37,18.2L200,58.89l-.09,0L152.65,39Zm162.82,126.4a10,10,0,0,0,7.81,0L422,124.05V253.51L206,162.89V83.13ZM20,262.63l216,90.62V417L20,326.34ZM422,347.3,256,417V353.25l166-69.66Z"/></svg>
                    <p class="fs20 bold gray text-center" style="margin: 10px 0 16px 0">{{ __("There are no posts at the moment try out later or change the category or date filter") }}.</p>
                    <p class="my4 text-center">{{ __("Or create your own post") }} <a href="{{ route('thread.add') }}" class="link-path">{{__('here')}}</a></p>
                </div>
            </div>
            @else
                @if($hasmore)
                    @include('partials.thread.faded-thread', ['classes'=>'forum-threads-fetch-more'])
                @else
                    <style>
                        .thread-container-box:last-child {
                            border-bottom: 1px solid #b7c0c6;
                        }
                    </style>
                @endif
            @endif
        </div>
    </div>
    <div id="right-panel">
        <x-right-panels.forumslist/>
        <x-right-panels.recentthreads/>
        <div class="sticky" style="top: 70px">
            @include('partials.right-panels.feedback')
        </div>
    </div>
@endsection