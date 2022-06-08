@extends('layouts.app')

@section('title', 'Forums')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/forums.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/forums.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'forums'])
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path unselectable">{{ __('Forums') }}</span>
    </div>
    <div id="middle-container" class="middle-padding-1 flex" style="padding-top: 0">
        <div id="forums-section" style='padding-top: 0'>
            <div>
                @if(Session::has('message'))
                    <div class="green-message-container">
                        <p class="green-message">{{ Session::get('message') }}</p>
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="error-message-container">
                        <p class="error-message">{{ Session::get('error') }}</p>
                    </div>
                @endif
            </div>
            <div class="flex space-between align-end mb8">
                <h1 class="fs24 no-margin forum-color">{{ __('All forums') }}</h1>
                @auth
                <a href="{{ route('thread.add') }}" class="flex bblack no-underline">
                    <svg class="size14 mr4" fill="#181818" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.18,217.58a23.4,23.4,0,0,0-23.4,23.4V428.2a23.42,23.42,0,0,1-23.4,23.4H83.76a23.42,23.42,0,0,1-23.4-23.4V100.57a23.42,23.42,0,0,1,23.4-23.4H271a23.4,23.4,0,0,0,0-46.8H83.76a70.29,70.29,0,0,0-70.21,70.2V428.2a70.29,70.29,0,0,0,70.21,70.2H411.38a70.29,70.29,0,0,0,70.21-70.2V241A23.39,23.39,0,0,0,458.18,217.58Zm-302,56.25a11.86,11.86,0,0,0-3.21,6l-16.54,82.75a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L233,359.76a11.68,11.68,0,0,0,6-3.21L424.12,171.4,341.4,88.68ZM481.31,31.46a58.53,58.53,0,0,0-82.72,0L366.2,63.85l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72ZM155.72,273.08a11.86,11.86,0,0,0-3.21,6L136,361.8a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L232.48,359a11.68,11.68,0,0,0,6-3.21L423.62,170.65,340.9,87.93ZM480.81,30.71a58.53,58.53,0,0,0-82.72,0L365.7,63.1l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72Z"/></svg>
                    <span class="unselectable bold fs13">{{ __('Create a post') }}</span>
                </a>
                @endauth
            </div>
            <table id="forums-box" class="forums-table">
                <thead>
                    <tr class="flex">
                        <th class="forum-component-title forum-component-icon-section-width">
                            <div class="flex flex-column align-center">
                                <svg class="size14 mb2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M133.56,395.06a79.73,79.73,0,0,1-75.41-54.32l-.75-2.45a77.89,77.89,0,0,1-3.68-23.08V170L2.06,342.47A48.36,48.36,0,0,0,36,401.13L365.2,489.3a49.05,49.05,0,0,0,12.27,1.57c21.2,0,40.58-14.07,46-34.81l19.18-61Zm58.56-223.57a42.59,42.59,0,1,0-42.59-42.58A42.63,42.63,0,0,0,192.12,171.49Zm266.15-149H138.88A53.3,53.3,0,0,0,85.66,75.68V309.89a53.3,53.3,0,0,0,53.22,53.23H458.27a53.3,53.3,0,0,0,53.23-53.23V75.68A53.31,53.31,0,0,0,458.27,22.44ZM138.88,65H458.27a10.65,10.65,0,0,1,10.65,10.65V226.83l-67.27-78.49c-7.13-8.36-17.46-12.83-28.55-13.09a37.21,37.21,0,0,0-28.44,13.44l-79.09,94.92-25.76-25.7a37.35,37.35,0,0,0-52.8,0l-58.77,58.74v-201A10.65,10.65,0,0,1,138.88,65Z"/>
                                </svg>
                                {{ __('ICON') }}
                            </div>
                        </th>
                        <th class="forum-component-title forum-component-forum-section-width" style="justify-content: flex-start">
                            <div class="flex flex-column align-center">
                                <svg class="size14 mb2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M438.09,273.32h-39.6a102.92,102.92,0,0,1,6.24,35.4V458.37a44.18,44.18,0,0,1-2.54,14.79h65.46A44.4,44.4,0,0,0,512,428.81V347.23A74,74,0,0,0,438.09,273.32ZM107.26,308.73a102.94,102.94,0,0,1,6.25-35.41H73.91A74,74,0,0,0,0,347.23v81.58a44.4,44.4,0,0,0,44.35,44.35h65.46a44.17,44.17,0,0,1-2.55-14.78Zm194-73.91H210.74a74,74,0,0,0-73.91,73.91V458.38a14.78,14.78,0,0,0,14.78,14.78H360.39a14.78,14.78,0,0,0,14.78-14.78V308.73A74,74,0,0,0,301.26,234.82ZM256,38.84a88.87,88.87,0,1,0,88.89,88.89A89,89,0,0,0,256,38.84ZM99.92,121.69a66.44,66.44,0,1,0,66.47,66.47A66.55,66.55,0,0,0,99.92,121.69Zm312.16,0a66.48,66.48,0,1,0,66.48,66.47A66.55,66.55,0,0,0,412.08,121.69Z"/></svg>
                                {{ __('FORUM') }}
                            </div>
                        </th>
                        <th class="forum-component-title forum-component-threads-section-width">
                            <div class="flex flex-column align-center">
                                <svg class="size14 mb2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                                {{ __('POSTS') }}
                            </div>
                        </th>
                        <th class="forum-component-title forum-component-posts-section-width">
                            <div class="flex flex-column align-center">
                                <svg class="size14 mb2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                                {{ __('REPLIES') }}
                            </div>
                        </th>
                        <th class="forum-component-title forum-component-last-reply-section-width">
                            <div class="flex flex-column align-center">
                                <svg class="size14 mb2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M446.91,299.77c-5.87-76.36-41.42-124.21-72.78-166.44C345.08,94.24,320,60.48,320,10.69a10.68,10.68,0,0,0-5.79-9.49A10.53,10.53,0,0,0,303.13,2C256,35.71,216.72,92.52,203,146.73c-9.53,37.73-10.79,80.16-11,108.18-43.5-9.29-53.35-74.36-53.46-75.07a10.73,10.73,0,0,0-5.55-7.92,10.61,10.61,0,0,0-9.67-.17c-2.28,1.1-56,28.39-59.11,137.35C64,312.73,64,316.36,64,320c0,105.85,86.14,192,192,192a1.24,1.24,0,0,0,.43,0h.13C362.17,511.68,448,425.67,448,320,448,314.67,446.91,299.77,446.91,299.77ZM256,490.65c-35.29,0-64-30.58-64-68.17,0-1.28,0-2.57.08-4.16.43-15.85,3.44-26.67,6.74-33.87C205,397.74,216.07,410,234,410a10.66,10.66,0,0,0,10.67-10.67c0-15.18.31-32.7,4.09-48.51,3.37-14,11.41-28.94,21.6-40.9,4.53,15.52,13.36,28.08,22,40.34,12.34,17.54,25.1,35.68,27.34,66.6.14,1.84.27,3.68.27,5.66C320,460.07,291.29,490.65,256,490.65Z"/></svg>
                                {{ __('LAST POST') }}
                            </div>
                        </th>
                    </tr>
                </thead>
                @foreach($forums as $forum)
                    <x-forum-component :forum="$forum"/>
                @endforeach
                <tr id="fetch-more-forums">
                    <td colspan="5">
                        <div class="full-center flex-column py8">
                            <svg class="spinner size16 mb4" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                            <span class="block fs10 bold lblack">{{ __('loading more forums') }}..</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div id="right-panel">
            <x-right-panels.recentthreads/>
            @include('partials.right-panels.statistics')
        </div>
    </div>
@endsection