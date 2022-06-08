@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/search.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'search', 'subpage'=>'advanced-search'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex align-center space-between">
            <div class="flex align-center">
                <a href="/" class="link-path flex align-center unselectable">
                    <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                    {{ __('Board index') }}
                </a>
                <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                <span class="current-link-path">{{ __('Advanced search') }}</span>
            </div>
            <a href="{{ route('users.search') }}" class="blue no-underline fs13 bold flex align-center move-to-right">
                <svg class="size15 mr4" fill="#2ca0ff" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                {{ __('Users Search') }}
            </a>
        </div>
        <div class="full-width">
            <h1 class="fs24 forum-color" style="margin: 12px 0 8px 0">{{ __('Advanced search') }}</h1>
            <div>
                <form action="{{ route('advanced.search.results') }}" method='get' class="full-width">
                    <div class="full-width">
                        <label for='main-srch' class="fs12 no-margin flex mb4">{{ __('Search for posts by putting its keywords in the textbox down bellow') }}</label>
                        <input type="text" id="main-srch" name="k" class="input-style-1 full-width" value="{{ request()->input('k') }}" placeholder="{{__('Search keywords')}}" style="padding: 8px 12px" required>
                    </div>
                    @if(Session::has('errors'))
                        <div class="error-container my8">
                            <p class="error-message">{{ Session::get('errors')->first() }}</p>
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="error-container my8">
                            <p class="error-message">{{ Session::get('error') }}</p>
                        </div>
                    @endif
                    <div class="my8">
                        <p class="no-margin mb2 bold fs15 lblack">{{__('Filters')}}</p>
                        <span class="fs13">{{ __("Use the following filters to target precisely your search") }}</span>
                    </div>
                    <!-- forum selection -->
                    <div id="forum-filter-box" class="full-width flex align-center mb8" style="margin-top: 14px;">
                        <label class="mr8 fs12 bold"  style="width: 160px">{{__('Forum')}} @error('forum')<span class="error">*</span>@enderror</label>
                        <span class="bold mx8">:</span>
                        <input type="hidden" name="forum" id="forum" autocomplete="off" value='all'>
                        <!-- select forum dropdown -->
                        <div class="relative flex align-center">
                            <div class="forum-color button-with-suboptions wtypical-button-style" style="padding: 5px 9px;">
                                <svg id="selected-forum-icon" class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.67,0H53.33A53.39,53.39,0,0,0,0,53.33V458.67A53.39,53.39,0,0,0,53.33,512H458.67A53.39,53.39,0,0,0,512,458.67V53.33A53.39,53.39,0,0,0,458.67,0Zm10.66,53.33V234.67h-192v-192H458.67A10.68,10.68,0,0,1,469.33,53.33Zm-416-10.66H234.67v192h-192V53.33A10.68,10.68,0,0,1,53.33,42.67Zm-10.66,416V277.33h192v192H53.33A10.68,10.68,0,0,1,42.67,458.67Zm416,10.66H277.33v-192h192V458.67A10.68,10.68,0,0,1,458.67,469.33Z"/></svg>
                                <span id="selected-forum-name" class="fs12 bold">{{ __('All forums') }}</span>
                                <svg class="size6 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M28.61,13.35l-11,9.39a4,4,0,0,1-5.18,0l-11-9.31A4,4,0,1,1,6.59,7.32L15,14.45l8.37-7.18a4,4,0,0,1,5.2,6.08Z"></path></svg>
                            </div>
                            <div class="suboptions-container typical-suboptions-container y-auto-overflow" style="max-height: 236px; width: 180px;">
                                <div class="typical-suboption typical-suboption-selected select-forum flex align-center">
                                    <svg class="size13 forum-icon mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.67,0H53.33A53.39,53.39,0,0,0,0,53.33V458.67A53.39,53.39,0,0,0,53.33,512H458.67A53.39,53.39,0,0,0,512,458.67V53.33A53.39,53.39,0,0,0,458.67,0Zm10.66,53.33V234.67h-192v-192H458.67A10.68,10.68,0,0,1,469.33,53.33Zm-416-10.66H234.67v192h-192V53.33A10.68,10.68,0,0,1,53.33,42.67Zm-10.66,416V277.33h192v192H53.33A10.68,10.68,0,0,1,42.67,458.67Zm416,10.66H277.33v-192h192V458.67A10.68,10.68,0,0,1,458.67,469.33Z"/></svg>
                                    <span class="forum-name fs12 bold">{{ __('All forums') }}</span>
                                    <input type="hidden" class="forum-id" value="0" autocomplete="off">
                                    <input type="hidden" class="forum-slug" value="all" autocomplete="off">
                                </div>
                                <div class="simple-line-separator" style="margin: 2px 0"></div>
                                @foreach($forums as $forum)
                                    <div class="typical-suboption select-forum flex">
                                        <svg class="size13 forum-icon mr8" style="min-width: 13px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            {!! $forum->icon !!}
                                        </svg>
                                        <span class="forum-name fs12 bold">{{ __($forum->forum) }}</span>
                                        <input type="hidden" class="forum-id" value="{{ $forum->id }}">
                                        <input type="hidden" class="forum-slug" value="{{ $forum->slug }}">
                                    </div>
                                @endforeach
                            </div>
                            <svg class="spinner size16 opacity0 blue ml8" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- categories -->
                    <div class="full-width flex align-center mt8">
                        <label for="category-filter" class="mr8 fs12 bold" style="width: 160px">{{ __('Category') }}</label>
                        <span class="bold mx8">:</span>
                        <select name="category" id="category-filter" class="dropdown-style" style="width: 180px">
                            <option value="all">{{ __("All categories") }}</option>
                        </select>
                    </div>
                    <!-- has only ticked reply -->
                    <div class="full-width flex mt8">
                        <div class="flex align-center mr8" style="width: 160px">
                            <label for="only-ticked-posts-filter" class="mr8 fs12 bold">{{ __('Only ticked posts') }}</label>
                            <svg class="size12 ml4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
                        </div>
                        <span class="bold mx8">:</span>
                        <input type="checkbox" id="only-ticked-posts-filter" name="tickedposts" autocomplete="off" class="height-max-content">
                    </div>
                    <!-- date filter -->
                    <div class="full-width flex align-center mt8">
                        <label for="threads-date-filter" class="mr8 fs12 bold" style="width: 160px">{{ __('Posts Creation Date') }}</label>
                        <span class="bold mx8">:</span>
                        <select name="threads-date-filter" id="threads_date" class="dropdown-style">
                            <option value="anytime">{{ __("anytime") }}</option>
                            <option value="past24hours">{{ __("Past 24 hours") }}</option>
                            <option value="pastweek">{{ __("Last week") }}</option>
                            <option value="pastmonth">{{ __("Last month") }}</option>
                        </select>
                    </div>
                    <!-- sort by -->
                    <div class="full-width flex  align-center mt8">
                        <label for="sorted-by" class="mr8 fs12 bold" style="width: 160px">{{ __('Sorted by') }}</label>
                        <span class="bold mx8">:</span>
                        <select name="sorted-by" id="sorted-by" class="dropdown-style">
                            <option selected value="created_at_desc">{{ __("Creation date (new to old)") }}</option>
                            <option value="created_at_asc">{{ __("Creation date (old to new)") }}</option>
                            <option value="views">{{ __("Number of views") }}</option>
                            <option value="votes">{{ __("Number of votes") }}</option>
                            <option value="likes">{{ __("number of likes") }}</option>
                        </select>
                    </div>

                    <button type="submit" class="typical-button-style flex align-center" style="margin: 14px 0">
                        <svg class="size14 mr4" fill="#fff" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                        {{ __('Search') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div id="right-panel">
        <x-right-panels.forumslist/>
        <div class="mb8">
            <div>
                <div class="right-panel-header-container">
                    <p class="bold no-margin unselectable my4">{{ __('Advanced Search Rules') }}</p>
                </div>
                <div class="ml8 block">
                    <p class="bold forum-color fs13" style="margin-bottom: 12px;">{{ __('Resource type') }}</p>
                    <p class="fs12 my4">• {{__('This section is for posts advanced search only. If you decide to search for a user click on the users search link on very top right corner')}}.</p>
                </div>
            </div>
            <div>
                <p class="bold forum-color fs13 ml8 pointer" style="margin-bottom: 12px;">{{__('Posts Filters')}}</p>
                <div class="ml8">
                    <p class="fs12 my4">• {{ __('Select the forum where you want to search, or select all forums to search in the entire forums') }}.</p>
                    <p class="fs12 my4">• {{ __("Select the category where you want to search, or select all categories to search in all the forum or all the forums") }}.</p>
                    <p class="fs12 my4">• {{ __('If you want to return only the posts where the owner mark as best reply, check the Select only posts with best reply checkbox') }}.</p>
                </div>
            </div>
            <div>
                <p class="bold forum-color fs13 ml8 pointer" style="margin-bottom: 12px;">{{__('Users Search')}}</p>
                <div class="ml8">
                    <p class="fs12 my4">• {{ __('If you want to search for a user, go to') }} <a href="{{ route('users.search') }}" class="link-path">{{ __('users search') }}</a> {{ __('page') }}.</p>
                </div>
            </div>
        </div>
    </div>
@endsection