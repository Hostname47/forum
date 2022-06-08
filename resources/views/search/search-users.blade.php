@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'search', 'subpage'=>'users-search'])
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="/search" class="link-path">{{ __('Search') }}</a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path">{{ __('Users Search') }}</span>
    </div>
    <div class="index-middle-width">
        <h1 id="page-title" class="my8 fs28 forum-color">{{ __('Users Search') }}</h1>
        <div>
            <form action="{{ route('users.search') }}" method='get' class="flex align-end full-width">
                <div class="full-width">
                    <label for='main-srch' class="fs12 no-margin flex mb4">{{ __('Search For Users (name or username)') }}</label>

                    <input type="text" id="main-srch" name="k" class="input-style-1 full-width" value="{{ request()->input('k') }}" placeholder="{{__('Search everything')}}.." required>
                </div>
                <button type="submit" class="button-style-1 flex align-center ml8">
                    <svg class="size15 mr4" fill="#fff" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                    {{ __('Search') }}
                </button>
            </form>
        </div>
        @if($keyword != "")
        <h2 class="fs20 flex align-center gray" style="margin: 16px 0 6px 0">{{ __('Users search results for') }} : </h2>
        <h3 class="fs18 flex align-center no-margin ml8 gray">"<span class="black">{{ $keyword }}</span>" ({{$users->total()}} {{__('found')}})</h3>
        @endif
        <div class="simple-line-separator my8"></div>
        <div style='margin-bottom: 16px'>
            @if($users->count())
                <div class="flex space-between align-center my8">
                    <a href="{{ route('users.search') }}" class="fs20 blue bold no-underline my4 flex align-center">{{ __('Users') }}<span class="gray fs14 ml4 @if($keyword == '') none @endif">({{$users->total()}} {{__('found')}})</span></a>
                    <div class="move-to-right">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
                <div class="flex flex-wrap space-between">
                    @foreach($users as $user)
                        <x-search.user :user="$user" class="half-width" style="width: calc(50% - 6px)"/>
                        <div class="simple-line-separator"></div>
                    @endforeach
                </div>
            @endif
        </div>
        @if(!$users->count())
            <div class="full-center">
                <div class="full-center flex-column">
                    <div class="size36 sprite sprite-2-size notfound36-icon" style="margin-top: 16px"></div>
                    <p class="fs20 bold gray my4">{{ __("No Users found with your search keywords") }} !</p>
                    <p class="my4 text-center">{{ __("Search for users using firstname, lastname or username") }} </p>
                </div>
            </div>
        @endif
    </div>
    <div id="right-panel">
        <x-right-panels.forumslist/>
        <x-right-panels.recentthreads/>
    </div>
@endsection