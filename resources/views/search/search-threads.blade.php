@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.js"></script>
    <script src="{{ asset('js/post.js') }}" defer></script>
    <script src="{{ asset('js/search.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'search', 'subpage'=>'threads-search'])
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="/search" class="link-path">{{ __('Search') }}</a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path">{{ __('Posts Search') }}</span>
    </div>
    <div class="full-width index-middle-width middle-container-style">
        @if(Session::has('message'))
            <div class="green-message-container mb8">
                <p class="green-message">{{ Session::get('message') }}</p>
            </div>
        @endif
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
        <h1 id="page-title" class="my8 fs28 forum-color">{{ __('Posts Search') }}</h1>
        <div>
            <form action="{{ route('threads.search') }}" method='get' class="flex align-end full-width">
                <div class="full-width">
                    <div class="flex align-end space-between mb4">
                        <label for='main-srch' class="fs12 no-margin mt8">{{ __('Search for posts') }}</label>
                        <a href="{{ route('advanced.search') }}" class="link-path flex align-center">
                            <svg class="size14 mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511 511">
                                <path d="M492,0H21A20,20,0,0,0,1,20,195,195,0,0,0,66.37,165.55l87.42,77.7a71.1,71.1,0,0,1,23.85,53.12V491a20,20,0,0,0,31,16.6l117.77-78.51a20,20,0,0,0,8.89-16.6V296.37a71.1,71.1,0,0,1,23.85-53.12l87.41-77.7A195,195,0,0,0,512,20,20,20,0,0,0,492,0ZM420.07,135.71l-87.41,77.7a111.1,111.1,0,0,0-37.25,83V401.82l-77.85,51.9V296.37a111.1,111.1,0,0,0-37.25-83L92.9,135.71A155.06,155.06,0,0,1,42.21,39.92H470.76A155.06,155.06,0,0,1,420.07,135.71Z"/>
                            </svg>
                            {{__("Advanced search")}}
                        </a>
                    </div>
                    <input type="text" id="main-srch" name="k" class="input-style-1 full-width" value="{{ request()->input('k') }}" placeholder="{{ __('Search for posts') }}" required>
                </div>
                <button type="submit" class="button-style-1 flex align-center ml8">
                    <svg class="size15 mr4" fill="#fff" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                    {{ __('Search') }}
                </button>
            </form>
        </div>
        @if($keyword != "")
            <h2 class="fs20 flex align-center gray" style="margin: 14px 0 4px 0">{{__('Posts search results for')}}:</h2>
            <h2 class="no-margin fs16 flex align-center gray">"<span class="black">{{ $keyword }}</span>" <span class="fs13 ml4 bold">({{$threads->total()}} {{__('found')}})</span></h2>
            @if(isset($filters) && count($filters))
            <style>
                .adv-search-filter-item {
                    position: relative;
                    display: flex;
                    align-items: center;
                    flex-wrap: wrap;
                    padding: 4px 26px 4px 8px;
                    margin: 3px;
                    border-radius: 3px;
                    background-color: #eee;
                    border: 1px solid #d5d5d5;

                    transition: background-color 1s ease;
                }

                .adv-search-filter-item:hover {
                    background-color: #d5d5d5;
                }

                .adv-search-remove-filter {
                    position: absolute;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    right: 4px;
                    border-radius: 50%;
                    cursor: pointer;

                    background-color: #353535;
                    color: white;
                }
            </style>
            <div style="margin-top: 10px">
                <div class="flex align-center">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511 511"><path d="M492,0H21A20,20,0,0,0,1,20,195,195,0,0,0,66.37,165.55l87.42,77.7a71.1,71.1,0,0,1,23.85,53.12V491a20,20,0,0,0,31,16.6l117.77-78.51a20,20,0,0,0,8.89-16.6V296.37a71.1,71.1,0,0,1,23.85-53.12l87.41-77.7A195,195,0,0,0,512,20,20,20,0,0,0,492,0ZM420.07,135.71l-87.41,77.7a111.1,111.1,0,0,0-37.25,83V401.82l-77.85,51.9V296.37a111.1,111.1,0,0,0-37.25-83L92.9,135.71A155.06,155.06,0,0,1,42.21,39.92H470.76A155.06,155.06,0,0,1,420.07,135.71Z"/></svg>
                    <p class="bold gray my4">{{ __('Your search filters') }} :</p>
                </div>
                <div class="ml8 flex flex-wrap">
                    @foreach($filters as $filter)
                    <div class="adv-search-filter-item">
                        <p class="no-margin fs12 bold blue unselectable">{{ $filter[0] }}</p>
                        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                        <p class="no-margin fs12 bold unselectable">{{ $filter[1] }}</p>
                        <input type="hidden" class="removed-filter" autocomplete="off" value="{{ $filter[2] }}">
                        <div class="size17 adv-search-remove-filter">
                            <span class="fs12">✖</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endif
        <div class="simple-line-separator my8"></div>
        <div>
            <h2 class="fs20 blue unselectable my4 flex align-center">{{ __('Posts') }}</h2>
            <div class="flex align-end space-between mb4">
                <div class="relative mr4">
                    <div class="flex align-center forum-color button-with-suboptions pointer fs13">
                        <span class="mr4 gray unselectable">{{ __('Filter by date') }}:</span>
                        <span class="forum-color fs13 bold unselectable">{{ __($tab_title) }}</span>
                        <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                    </div>
                    <div class="suboptions-container typical-suboptions-container" style="width: 220px">
                        @php
                            $appendings = '';
                            if($keyword != '') {
                                $appendings = '&k=' . $keyword;
                            }
                            if(request()->has('pagesize')) {
                                $appendings .= '&pagesize=' . request()->get('pagesize');
                            }
                        @endphp
                        <a href="?tab=all{{ $appendings }}" class="no-underline typical-suboption sort-by-option flex @if($tab=='all' || $tab == '') typical-suboption-selected @endif">
                            <div>
                                <p class="no-margin sort-by-val bold forum-color">{{ __('All') }}</p>
                                <p class="no-margin fs12 gray">{{ __('Get search results for all posts at any time') }}</p>
                                <input type="hidden" class="tab" value="all">
                            </div>
                            <div class="loading-dots-anim ml4 none">•</div>
                        </a>
                        <a href="?tab=today{{ $appendings }}" class="no-underline typical-suboption sort-by-option flex @if($tab=='today') typical-suboption-selected @endif">
                            <div>
                                <p class="no-margin sort-by-val bold forum-color">{{ __('Today') }}</p>
                                <p class="no-margin fs12 gray">{{ __('Get search results for only posts created today. (This will be sorted by number of views)') }}</p>
                                <input type="hidden" class="tab" value="today">
                            </div>
                            <div class="loading-dots-anim ml4 none">•</div>
                        </a>
                        <a href="?tab=thisweek{{ $appendings }}" class="no-underline typical-suboption sort-by-option flex @if($tab=='thisweek') typical-suboption-selected @endif">
                            <div>
                                <p class="no-margin sort-by-val bold forum-color">{{ __('This week') }}</p>
                                <p class="no-margin fs12 gray">{{ __('Get search results for only posts created this week. (This will be sorted by number of views)') }}</p>
                                <input type="hidden" class="sort-by-key" value="votes">
                            </div>
                            <div class="loading-dots-anim ml4 none">•</div>
                        </a>
                    </div>
                </div>
                <div>
                    @if($threads->count() >= 6)
                    <div class="flex">
                        <div class="flex align-center my4 move-to-right">
                            <label for="search-page-size-dropdown" class="mr4 fs13 gray">{{ __('posts') }}/{{ __('page') }} :</label>
                            <select id="search-page-size-dropdown" class="basic-dropdown row-num-changer" autocomplete="off" style="width: 50px;">
                                <option value="6" @if($pagesize == 6) selected @endif>6</option>
                                <option value="10" @if($pagesize == 10) selected @endif>10</option>
                                <option value="16" @if($pagesize == 16) selected @endif>16</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    {{ $threads->onEachSide(0)->links() }}
                </div>
            </div>
            <div id="threads-global-container">
                <style>
                    .thread-container-box:last-child {
                        border-bottom: 1px solid #b7c0c6;
                    }
                </style>
                @foreach($threads as $thread)
                    <x-index-resource :thread="$thread"/>
                @endforeach
            </div>
            @if(!$threads->count())
                <div class="full-center">
                    <div>
                        <div class="size36 sprite sprite-2-size notfound36-icon" style="margin: 16px auto 6px auto"></div>
                        <p class="fs20 bold gray my4">{{ __("No posts matched your search") }}</p>
                        <p class="my4 text-center">{{ __("create a new") }} <a href="{{ route('thread.add') }}" class="link-path">{{__('post')}}</a></p>
                    </div>
                </div>
            @endif
        </div>
        @if($threads->count())
        <div class="flex my8">
            <div class="move-to-right">
                {{ $threads->onEachSide(0)->links() }}
            </div>
        </div>
        @endif
    </div>
    <div id="right-panel">
        <x-right-panels.forumslist/>
        <x-right-panels.recentthreads/>
    </div>
@endsection