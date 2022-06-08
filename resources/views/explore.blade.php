@extends('layouts.app')

@section('title', 'Explore')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/explore.js') }}" defer></script>
    <script src="{{ asset('js/simplemde.js') }}" defer></script>
    <script src="{{ asset('js/post.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header', ['globalpage'=>'explore'])
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'explore'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex align-center">
            <a href="/" class="link-path flex align-center unselectable">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                {{ __('Board index') }}
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <span class="current-link-path unselectable">{{ __('Explore') }}</span>
        </div>
    </div>
    <div class="index-middle-width middle-container-style">
        @if(Session::has('errors'))
            <div class="error-container mb8">
                <p class="error-message">{{ Session::get('errors')->first() }}</p>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="error-container mb8">
                <p class="error-message">{{ Session::get('error') }}</p>
            </div>
        @endif
        <!-- from and to variables respresent hours to subracted from today date in order to fetch threads -->
        <input type="hidden" autocomplete="off" id="hours_interval_from" value="{{ $hours_from }}">
        <!--
            hours_interval_to is initialized with 0 because we begin from current hour (wich means subtractHours(0) gives us current hour
            because we are using Carbon package to get current time based on hours subtraction) when page is loaded th first time
        -->
        <input type="hidden" autocomplete="off" id="hours_interval_to" value="0">
        <!-- 
            This is useful when hours interval contains too many threads we track how many items are precessed
            This is initialized with threads count which is the same as pagesize because the first time the user
            open this page it will get number of threads (e.g 8 in this case which is pagesize value)
        -->
        <input type="hidden" autocomplete="off" id="skip" value="{{ $skip }}">
        <input type="hidden" autocomplete="off" id="sort" value="{{ $sortby }}">
        @if(Session::has('message'))
            <div class="green-message-container mb8">
                <p class="green-message">{{ Session::get('message') }}</p>
            </div>
        @endif
        <h1 class="fs24 forum-color no-margin mb8">{{ __("Popular posts across all forums") }}</h1>
        <div class="flex space-between stick-after-header">
            <div class="relative">
                <div class="flex align-center forum-color button-with-suboptions pointer fs13">
                    <span class="mr4 gray">{{ __('Sort by') }}:</span>
                    <svg class="size14 sort-by-icon mr4" fill="#262626" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="{{ $sort_icon }}"/>
                    </svg>
                    <span class="forum-color">{{ $sort_title }}</span>
                    <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                </div>
                <div class="suboptions-container typical-suboptions-container" style="width: 250px">
                    <div class="thread-add-suboption sort-by-option flex @if($sortby == 'popular-and-recent') typical-suboption-selected @endif">
                        <svg class="size17 mr4" style="margin-top: 1px; min-width: 17px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M380.27,162.56l-16-13-7.47,19.26c-.14.37-14.48,36.62-36.5,30A15.58,15.58,0,0,1,310,190c-5.47-11.72-3.14-32.92,5.93-54,12.53-29.18,7-59.75-15.88-88.41a161.1,161.1,0,0,0-36.32-32.88L240.23,0l.52,27.67c0,.49.52,49.65-35.88,67.67-22.3,11-38.26,29.31-45,51.43a79,79,0,0,0,7.21,62.09c4.44,7.67,5.78,14.19,4,19.35-2.55,7.38-10.79,11.18-13.25,12.17-26,10.45-43-24.44-43.74-25.88l-11.87-25.33-14.54,23.9A196.29,196.29,0,0,0,59.18,315.19c0,107.73,87,195.51,194.46,196.78.78,0,1.57,0,2.36,0h0c108.53,0,196.82-88.29,196.82-196.81a196.15,196.15,0,0,0-72.55-152.63ZM194.44,420.43v-.19c-.15-11.94,2.13-24.75,6.78-38.22l37,10.82.37-19.63c.57-30.07,17.53-48.52,31.08-58.51a135.37,135.37,0,0,0,16.38,40.84c8.53,13.92,16.61,25.72,24.06,36.39,4.79,6.87,7.51,17.24,7.45,28.44v.08A61.52,61.52,0,0,1,256,482h0a61.63,61.63,0,0,1-61.55-61.55ZM338.62,460a91.08,91.08,0,0,0,9-39.56c.08-17.5-4.48-33.73-12.85-45.73s-15.42-22.39-23.08-34.89c-8.54-14-13.68-30.42-15.7-50.3l-2-19.44L275.7,277c-1.72.65-17.19,6.75-33.06,21.14-16.82,15.26-27.68,34.14-32,55.33l-26.84-7.85-5.29,12.08c-9.59,21.87-14.34,43-14.11,62.78a91,91,0,0,0,9.05,39.57,166.81,166.81,0,0,1-71-210.09c1.33,1.47,2.75,2.94,4.25,4.39,18.39,17.7,40.54,22.62,62.38,13.85,14.76-5.92,25.85-16.94,30.44-30.23,3.27-9.46,4.81-24.8-6.38-44.17a48.12,48.12,0,0,1-4.46-38.38c4.26-14.1,14.75-25.89,29.53-33.22C249.31,106.83,262,77.9,267.22,56A117.11,117.11,0,0,1,277,66.83c15.42,19.56,19.23,38.82,11.3,57.26-12.67,29.49-14.74,58.86-5.55,78.57a45.48,45.48,0,0,0,28.87,24.93c20.6,6.18,40.75-1,56.73-20.25a98.36,98.36,0,0,0,6.64-9A166.76,166.76,0,0,1,338.62,460Z"/>
                        </svg>
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('Popular and recent') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get most recent posts and sort by views') }}</p>
                            <input type="hidden" class="sort-by-key" value="popular-and-recent">
                        </div>
                    </div>
                    <div class="typical-suboption sort-by-option flex @if($sortby == 'replies-and-likes') typical-suboption-selected @endif">
                        <svg class="size17 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/>
                        </svg>
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('Replies and likes') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Sort by most liked and replied posts') }}</p>
                            <input type="hidden" class="sort-by-key" value="replies-and-likes">
                        </div>
                    </div>
                    <div class="typical-suboption sort-by-option flex @if($sortby == 'votes') typical-suboption-selected @endif">
                        <svg class="size15 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M50.25,340.54c-21,0-39.37-10.63-46.89-27.09-6.1-13.32-3.82-27.63,6.24-39.27L215.27,35.67c9.53-11.06,24.34-17.4,40.62-17.4S287,24.61,296.5,35.67l206.09,238.4c9.95,11.66,12.13,26,6,39.36-7.57,16.41-25.95,27-46.82,27h-73V285.76h22.81a9.4,9.4,0,0,0,8.61-5.32,8.34,8.34,0,0,0-1.34-9L263.19,91.07a9.92,9.92,0,0,0-7.28-3.24,9.73,9.73,0,0,0-7.06,3L93.08,271.49a8.31,8.31,0,0,0-1.33,9,9.4,9.4,0,0,0,8.61,5.34h22v54.72ZM350,493.73a39,39,0,0,0,38.81-39.15V285.82H327.68v146H183.33v-146h-61V454.58a39,39,0,0,0,38.81,39.15Z" style="fill:#010202"/>
                        </svg>
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('Top votes') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get most voted posts') }}</p>
                            <input type="hidden" class="sort-by-key" value="votes">
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('advanced.search') }}" class="fs13 bold no-underline blue flex align-center">
                <svg class="size12 mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512,28.48A28.27,28.27,0,0,0,484,0H28.06A27.71,27.71,0,0,0,11.92,5.19,28.75,28.75,0,0,0,5.11,44.87L170.4,283.44,170.87,457A55.72,55.72,0,0,0,180,487.44a53.81,53.81,0,0,0,75.32,15.29l59-40a57.19,57.19,0,0,0,25-47.66l-.6-130.63L506.8,45A28.85,28.85,0,0,0,512,28.48ZM282.54,266.39l.68,149L227,453.45l-.5-188.1L82.09,57H429.51Z"/></svg>
                {{ __('Adv. search') }}
            </a>
        </div>
        <div id="threads-global-container" class="mt8">
            @foreach($threads as $thread)
                <x-index-resource :thread="$thread"/>
            @endforeach
        </div>
        @include('partials.thread.faded-thread', ['classes'=>'explore-more'])
    </div>

    <div id="right-panel">
        <x-right-panels.forumslist/>
        <x-right-panels.recentthreads/>
        @include('partials.right-panels.statistics')
        @include('partials.right-panels.feedback')
    </div>
@endsection