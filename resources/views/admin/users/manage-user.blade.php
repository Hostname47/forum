@extends('layouts.admin')

@section('title', 'Admin - Manage User')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.resource.management', 'subpage'=>'admin.manage.users.manage'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/search.js') }}" defer></script>
<script src="{{ asset('js/admin/user.js') }}" defer></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/user.css') }}">
@endpush

@section('content')
    <div class="flex space-between align-center top-page-title-box">
        <div class="flex align-center">
            <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Manage user') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('User Management') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box">
        @if(Session::has('message'))
            <div class="green-message-container mb8">
                <p class="green-message">{{ Session::get('message') }}</p>
            </div>
        @endif
        @if(!$user)
        <div class="flex flex-column align-center" style="margin-top: 30px">
            <p class="my8 fs13 lblack">Search for users to manage and click enter button</p>
            <div class="relative search-box" style="min-width: 490px; width: 490px;">
                <svg class="sfui-icon size14" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                <input type="text" name="k" value="{{ request()->get('k') }}" class="search-for-users-input full-width" autocomplete="off" placeholder="search for users by username">
                <div class="search-result-container none scrolly">
                    <a href="{{ route('admin.user.manage') }}" class="no-underline us-usermanage-link search-user-record search-user-record-skeleton none flex">
                        <div class="flex">
                            <img src="" class="us-avatar size28 mr8 br4" alt="">
                            <div class="">
                                <span class="us-fullname block blue bold fs15" style="margin-top: -2px">Mouad Nassri</span>
                                <span class="us-username block bold gray fs12">Hostname47</span>
                            </div>
                        </div>
                    </a>
                    <div class="result-box">

                    </div>
                    <div class="flex align-center justify-center pointer none" id="admin-user-search-fetch-more" style="padding: 6px;">
                        <span class="blue bold fs13 mr4">fetch more</span>
                        <div class="spinner size14 opacity0">
                            <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path fill="#2ca0ff" d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                        </div>
                    </div>
                    <div class="flex search-result-faded none">
                        <div class="relative br4 mr8 size28 hidden-overflow">
                            <div class="fade-loading"></div>
                        </div>
                        <div>
                            <div class="relative br3 hidden-overflow" style="height: 15px; width: 160px; margin-bottom: 2px">
                                <div class="fade-loading"></div>
                            </div>
                            <div class="relative br3 hidden-overflow" style="height: 12px; width: 60px">
                                <div class="fade-loading"></div>
                            </div>
                        </div>
                    </div>
                    <div class="full-center search-no-results none">
                        <p class="bold">no results for your search query</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        @include('partials.admin.thread.thread-render')
        @include('partials.admin.post.post-render')
        @php
            $ascolor = 'green';
            if(in_array($accountstatus->slug, ['deactivated', 'deleted'])) $ascolor = 'gray';
            elseif(in_array($accountstatus->slug, ['temp-banned', 'banned'])) $ascolor = 'red';
        @endphp
        <!-- manage user avatars -->
        <div id="review-user-avatars-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; max-height: 90%; width: 700px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs20 bold forum-color flex align-center">
                        <svg class="size20 mr8" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464,64H48A48,48,0,0,0,0,112V400a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V112A48,48,0,0,0,464,64Zm-6,336H54a6,6,0,0,1-6-6V118a6,6,0,0,1,6-6H458a6,6,0,0,1,6,6V394A6,6,0,0,1,458,400ZM128,152a40,40,0,1,0,40,40A40,40,0,0,0,128,152ZM96,352H416V272l-87.52-87.51a12,12,0,0,0-17,0L192,304l-39.51-39.52a12,12,0,0,0-17,0L96,304Z"/></svg>
                        {{ __("Review user's avatars") }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">
                        
                    </div>
                    <div class="loading-box flex-column full-center absolute" style="margin-top: -20px">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="forum-color fs11 mt8">fetching avatars..</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- manage user covers -->
        <div id="review-user-covers-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; max-height: 90%; width: 700px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs20 bold forum-color flex align-center">
                        <svg class="size20 mr8" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464,64H48A48,48,0,0,0,0,112V400a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V112A48,48,0,0,0,464,64Zm-6,336H54a6,6,0,0,1-6-6V118a6,6,0,0,1,6-6H458a6,6,0,0,1,6,6V394A6,6,0,0,1,458,400ZM128,152a40,40,0,1,0,40,40A40,40,0,0,0,128,152ZM96,352H416V272l-87.52-87.51a12,12,0,0,0-17,0L192,304l-39.51-39.52a12,12,0,0,0-17,0L96,304Z"/></svg>
                        {{ __("Review user's covers") }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">
                        
                    </div>
                    <div class="loading-box flex-column full-center absolute" style="margin-top: -20px">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="forum-color fs11 mt8">fetching covers..</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- review user threads viewer -->
        <div id="review-user-threads-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; max-height: 90%; width: 700px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs20 bold forum-color flex align-center">
                        <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,17.11h97.27c11.82,0,15.64,3.73,15.64,15.34q0,75.07,0,150.16c0,11.39-3.78,15.13-15.22,15.13-2.64,0-5.3.12-7.93-.06a11.11,11.11,0,0,1-10.53-9.38c-.81-5.69,2-11,7.45-12.38,3.28-.84,3.52-2.36,3.51-5.06-.07-27.15-.11-54.29,0-81.43,0-3.68-1-4.69-4.68-4.68q-85.63.16-171.29,0c-3.32,0-4.52.68-4.5,4.33q.26,41,0,81.95c0,3.72,1.3,4.53,4.56,4.25a45.59,45.59,0,0,1,7.39.06,11.06,11.06,0,0,1,10.58,11c0,5.62-4.18,10.89-9.91,11.17-8.43.4-16.92.36-25.36,0-5.16-.23-8.82-4.31-9.68-9.66a33,33,0,0,1-.24-5.27q0-75.08,0-150.16c0-11.61,3.81-15.34,15.63-15.34Zm22.49,45.22c16.56,0,33.13,0,49.7,0,5.79,0,13.59,2,16.83-.89,3.67-3.31.59-11.25,1.19-17.13.4-3.92-1.21-4.54-4.73-4.51-19.21.17-38.42.08-57.63.08-22.73,0-45.47.11-68.21-.1-4,0-5.27,1-4.92,5a75.62,75.62,0,0,1,0,12.68c-.32,3.89.78,5,4.85,5C110.54,62.21,131.51,62.33,152.49,62.33ZM62.3,51.13c0-11.26,0-11.26-11.45-11.26h-.53c-10.47,0-10.47,0-10.47,10.71,0,11.75,0,11.75,11.49,11.75C62.3,62.33,62.3,62.33,62.3,51.13ZM102,118.66c25.79.3,18.21-2.79,36.49,15.23,18.05,17.8,35.89,35.83,53.8,53.79,7.34,7.35,7.3,12.82-.13,20.26q-14.94,15-29.91,29.87c-6.86,6.81-12.62,6.78-19.5-.09-21.3-21.28-42.53-42.64-63.92-63.84a16.11,16.11,0,0,1-5.24-12.62c.23-9.86,0-19.73.09-29.59.07-8.71,4.24-12.85,13-13C91.81,118.59,96.92,118.66,102,118.66ZM96.16,151c.74,2.85-1.53,6.66,1.41,9.6,17.66,17.71,35.39,35.36,53,53.11,1.69,1.69,2.59,1.48,4.12-.12,4.12-4.34,8.24-8.72,12.73-12.67,2.95-2.59,2.36-4-.16-6.49-15.68-15.46-31.4-30.89-46.63-46.79-4.56-4.76-9.1-6.73-15.59-6.35C96.18,141.8,96.16,141.41,96.16,151Z"></path></svg>
                        {{ __("Review user threads") }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div id="user-threads-review-box" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">
                        
                    </div>
                    <div class="loading-box flex-column full-center absolute" style="margin-top: -20px">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="forum-color fs11 mt8">fetching threads..</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- review user replies viewer -->
        <div id="review-user-posts-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; max-height: 90%; width: 700px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs20 bold forum-color flex align-center">
                        <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                        {{ __("Review user replies") }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div id="user-posts-review-box" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">
                        
                    </div>
                    <div class="loading-box flex-column full-center absolute" style="margin-top: -20px">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="forum-color fs11 mt8">fetching user replies..</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- review user votes viewer -->
        <div id="review-user-votes-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; width: 700px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs20 bold forum-color flex align-center">
                        <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g id="Layer_1_copy" data-name="Layer 1 copy"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"></path></g></svg>
                        {{ __("Review user votes") }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div id="user-votes-review-box" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">
                        
                    </div>
                    <div class="loading-box flex-column full-center absolute" style="margin-top: -20px">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="forum-color fs11 mt8">fetching user votes..</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- review user visits viewer -->
        <div id="review-user-visits-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; width: 700px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs20 bold forum-color flex align-center">
                        <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M326.61,185.39A151.92,151.92,0,0,1,327,400l-.36.37-67.2,67.2c-59.27,59.27-155.7,59.26-215,0s-59.27-155.7,0-215l37.11-37.1c9.84-9.84,26.78-3.3,27.29,10.6a184.45,184.45,0,0,0,9.69,52.72,16.08,16.08,0,0,1-3.78,16.61l-13.09,13.09c-28,28-28.9,73.66-1.15,102a72.07,72.07,0,0,0,102.32.51L270,343.79A72,72,0,0,0,270,242a75.64,75.64,0,0,0-10.34-8.57,16,16,0,0,1-6.95-12.6A39.86,39.86,0,0,1,264.45,191l21.06-21a16.06,16.06,0,0,1,20.58-1.74,152.65,152.65,0,0,1,20.52,17.2ZM467.55,44.45c-59.26-59.26-155.69-59.27-215,0l-67.2,67.2L185,112A152,152,0,0,0,205.91,343.8a16.06,16.06,0,0,0,20.58-1.73L247.55,321a39.81,39.81,0,0,0,11.69-29.81,16,16,0,0,0-6.94-12.6A75,75,0,0,1,242,270a72,72,0,0,1,0-101.83L309.16,101a72.07,72.07,0,0,1,102.32.51c27.75,28.3,26.87,73.93-1.15,102l-13.09,13.09a16.08,16.08,0,0,0-3.78,16.61,184.45,184.45,0,0,1,9.69,52.72c.5,13.9,17.45,20.44,27.29,10.6l37.11-37.1c59.27-59.26,59.27-155.7,0-215Z"></path></svg>
                        {{ __("Review user visits") }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div id="user-visits-review-box" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; max-height: 450px; min-height: 200px;">
                        
                    </div>
                    <div class="loading-box flex-column full-center absolute" style="margin-top: -20px;">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="forum-color fs11 mt8">fetching user visits..</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- review user authorization breaks viewer -->
        <div id="review-user-authbreaks-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; width: 700px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs20 bold forum-color flex align-center">
                        <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M231,130.52c0,16.59-.13,33.19.06,49.78.08,6.24-2.44,10.4-7.77,13.46q-43.08,24.72-86,49.68c-5.52,3.21-10.45,3-16-.2Q78.8,218.46,36.1,194.09c-5.91-3.37-8.38-7.8-8.34-14.61q.3-49,0-98.1c0-6.63,2.49-10.93,8.2-14.19Q78.68,42.82,121.15,18c5.69-3.32,10.69-3.42,16.38-.1Q180,42.71,222.7,67.1c5.89,3.36,8.46,7.8,8.35,14.61C230.77,98,231,114.25,231,130.52Zm-179.67,0c0,44.84,33,78,77.83,78.16s78.37-33.05,78.39-78.08c0-44.88-32.93-78-77.83-78.14S51.32,85.49,51.29,130.55Z" style="fill:#020202"></path><path d="M129.35,150.13c-13.8,0-27.61,0-41.42,0-8.69,0-13.85-6-13.76-15.79.09-9.62,5.15-15.43,13.6-15.44q40,0,79.93,0c13.05,0,19,7.43,16.37,20.38-1.46,7.17-5.92,10.85-13.29,10.86C157,150.15,143.16,150.13,129.35,150.13Z" style="fill:#020202"></path></svg>
                        {{ __("Review user authorization breaks") }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div id="user-authbreaks-review-box" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; max-height: 450px; min-height: 200px;">
                        
                    </div>
                    <div class="loading-box flex-column full-center absolute" style="margin-top: -20px;">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="forum-color fs11 mt8">Fetching user authorization breaks..</span>
                    </div>
                </div>
            </div>
        </div>
        @if($userstats['warnings']) @include('partials.admin.user.remove-warning-from-user') @endif
        @if($userstats['strikes']) @include('partials.admin.user.remove-strike-from-user') @endif
        <!-- review user warnings breaks viewer -->
        <div id="review-user-warnings-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; width: 700px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs20 bold forum-color flex align-center">
                        <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129,233.33h-108c-13.79,0-18.82-8.86-11.87-20.89q54-93.6,108.12-187.2c7.34-12.71,17.14-12.64,24.55.17,36,62.4,71.95,124.88,108.27,187.13,7.05,12.07-.9,21.28-12.37,21.06C201.43,232.88,165.21,233.33,129,233.33Zm91.36-24L129.4,51.8,38.5,209.3Zm-79-103.77c-.13-7.56-5.28-13-12-12.85s-11.77,5.58-11.82,13.1q-.13,20.58,0,41.18c.05,7.68,4.94,13,11.69,13.14,6.92.09,12-5.48,12.15-13.39.09-6.76,0-13.53,0-20.29C141.35,119.45,141.45,112.49,141.32,105.53Zm-.15,70.06a12.33,12.33,0,0,0-10.82-10.26,11.29,11.29,0,0,0-12,7.71,22.1,22.1,0,0,0,0,14A11.82,11.82,0,0,0,131.4,195c6.53-1.09,9.95-6.11,9.81-14.63A31.21,31.21,0,0,0,141.17,175.59Z" style="fill:#020202"></path></svg>
                        {{ __("Review user warnings") }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div id="user-warnings-review-box" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; max-height: 450px; min-height: 200px;">
                        
                    </div>
                    <div class="loading-box flex-column full-center absolute" style="margin-top: -20px;">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="forum-color fs11 mt8">Fetching user warnings..</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- review user strikes breaks viewer -->
        <div id="review-user-strikes-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; width: 700px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs20 bold forum-color flex align-center">
                        <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M6.19,144.31v-27c1.47-.52,1-1.87,1.11-2.87,1.67-11.65,4.54-23,9.59-33.63,19-40.1,50.14-65.08,94.22-71.63C157.76,2.25,197,17.72,226.2,54.57S261,133,244,176.58c-14.65,37.32-42.45,61.42-81,73-7.16,2.15-14.66,2.45-21.77,4.67H116.12c-.4-1.26-1.52-.94-2.39-1.06a120.16,120.16,0,0,1-29.21-7.6q-56.1-23.31-73.69-81.47C8.85,157.58,8.86,150.64,6.19,144.31ZM37,132.44c.14,16.35,5.15,33.28,15.18,48.78,1.74,2.69,2.59,2.68,4.78.48q61.74-61.9,123.67-123.62c2-2,2.1-2.84-.39-4.47a90.28,90.28,0,0,0-45-15.16C82,35.51,37.57,77.17,37,132.44Zm185.17-3.16c-.1-16.18-5.06-33.13-15.05-48.65-1.78-2.77-2.71-2.93-5.08-.55Q140.52,141.82,78.76,203.36c-2.11,2.1-2.43,3,.37,4.79a91.16,91.16,0,0,0,44.59,15C176.82,226.4,221.47,184.75,222.21,129.28Z" style="fill:#040205"></path></svg>
                        {{ __("Review user strikes") }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div id="user-strikes-review-box" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; max-height: 450px; min-height: 200px;">
                        
                    </div>
                    <div class="loading-box flex-column full-center absolute" style="margin-top: -20px;">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="forum-color fs11 mt8">Fetching user strikes..</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex" style="margin-bottom: 14px;">
            <div style="flex: 1;">
                <!-- avatar & cover preview -->
                <div>
                    <div id="open-covers-manage-dialog" class="um-cover-container pointer">
                        @if($user->cover)
                        <img src="{{ $user->cover }}" class="um-cover" alt="">
                        @endif
                    </div>
                    <div class="um-after-cover flex">
                        <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                        <img src="{{ $user->sizedavatar(100, '-h') }}" class="um-avatar pointer" id="open-avatars-manage-dialog" alt="">
                        <div class="flex space-between full-width height-max-content">
                            <div class="ml8 mt4">
                                <a href="{{ $user->profilelink }}" class="no-underline blue bold no-margin lblack fs18">{{ $user->fullname }}</a>
                                <p class="no-margin lblack fs13">username: <span class="bold">{{ $user->username }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- operations menu -->
                <div style="margin-top: 12px">
                    <h2 class="fs14 no-margin forum-color mb8">Review user activities & resources</h2>
                    <div class="flex flex-wrap">
                        <div class="flex align-center wtypical-button-style" id="open-user-threads-dialog">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,17.11h97.27c11.82,0,15.64,3.73,15.64,15.34q0,75.07,0,150.16c0,11.39-3.78,15.13-15.22,15.13-2.64,0-5.3.12-7.93-.06a11.11,11.11,0,0,1-10.53-9.38c-.81-5.69,2-11,7.45-12.38,3.28-.84,3.52-2.36,3.51-5.06-.07-27.15-.11-54.29,0-81.43,0-3.68-1-4.69-4.68-4.68q-85.63.16-171.29,0c-3.32,0-4.52.68-4.5,4.33q.26,41,0,81.95c0,3.72,1.3,4.53,4.56,4.25a45.59,45.59,0,0,1,7.39.06,11.06,11.06,0,0,1,10.58,11c0,5.62-4.18,10.89-9.91,11.17-8.43.4-16.92.36-25.36,0-5.16-.23-8.82-4.31-9.68-9.66a33,33,0,0,1-.24-5.27q0-75.08,0-150.16c0-11.61,3.81-15.34,15.63-15.34Zm22.49,45.22c16.56,0,33.13,0,49.7,0,5.79,0,13.59,2,16.83-.89,3.67-3.31.59-11.25,1.19-17.13.4-3.92-1.21-4.54-4.73-4.51-19.21.17-38.42.08-57.63.08-22.73,0-45.47.11-68.21-.1-4,0-5.27,1-4.92,5a75.62,75.62,0,0,1,0,12.68c-.32,3.89.78,5,4.85,5C110.54,62.21,131.51,62.33,152.49,62.33ZM62.3,51.13c0-11.26,0-11.26-11.45-11.26h-.53c-10.47,0-10.47,0-10.47,10.71,0,11.75,0,11.75,11.49,11.75C62.3,62.33,62.3,62.33,62.3,51.13ZM102,118.66c25.79.3,18.21-2.79,36.49,15.23,18.05,17.8,35.89,35.83,53.8,53.79,7.34,7.35,7.3,12.82-.13,20.26q-14.94,15-29.91,29.87c-6.86,6.81-12.62,6.78-19.5-.09-21.3-21.28-42.53-42.64-63.92-63.84a16.11,16.11,0,0,1-5.24-12.62c.23-9.86,0-19.73.09-29.59.07-8.71,4.24-12.85,13-13C91.81,118.59,96.92,118.66,102,118.66ZM96.16,151c.74,2.85-1.53,6.66,1.41,9.6,17.66,17.71,35.39,35.36,53,53.11,1.69,1.69,2.59,1.48,4.12-.12,4.12-4.34,8.24-8.72,12.73-12.67,2.95-2.59,2.36-4-.16-6.49-15.68-15.46-31.4-30.89-46.63-46.79-4.56-4.76-9.1-6.73-15.59-6.35C96.18,141.8,96.16,141.41,96.16,151Z"></path></svg>
                            <span class="fs12 bold">threads ({{ $userstats['threads'] }})</span>
                            <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                        </div>
                        <div class="flex align-center wtypical-button-style ml4" id="open-user-posts-dialog">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                            <span class="fs12 bold">replies ({{ $userstats['posts'] }})</span>
                            <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                        </div>
                        <div class="flex align-center wtypical-button-style ml4" id="open-user-votes-dialog">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g id="Layer_1_copy" data-name="Layer 1 copy"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"/></g></svg>
                            <span class="fs12 bold">all votes ({{ $userstats['votes'] }})</span>
                            <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                        </div>
                        <div class="flex align-center wtypical-button-style ml4" id="open-user-visits-dialog">
                            <svg class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M326.61,185.39A151.92,151.92,0,0,1,327,400l-.36.37-67.2,67.2c-59.27,59.27-155.7,59.26-215,0s-59.27-155.7,0-215l37.11-37.1c9.84-9.84,26.78-3.3,27.29,10.6a184.45,184.45,0,0,0,9.69,52.72,16.08,16.08,0,0,1-3.78,16.61l-13.09,13.09c-28,28-28.9,73.66-1.15,102a72.07,72.07,0,0,0,102.32.51L270,343.79A72,72,0,0,0,270,242a75.64,75.64,0,0,0-10.34-8.57,16,16,0,0,1-6.95-12.6A39.86,39.86,0,0,1,264.45,191l21.06-21a16.06,16.06,0,0,1,20.58-1.74,152.65,152.65,0,0,1,20.52,17.2ZM467.55,44.45c-59.26-59.26-155.69-59.27-215,0l-67.2,67.2L185,112A152,152,0,0,0,205.91,343.8a16.06,16.06,0,0,0,20.58-1.73L247.55,321a39.81,39.81,0,0,0,11.69-29.81,16,16,0,0,0-6.94-12.6A75,75,0,0,1,242,270a72,72,0,0,1,0-101.83L309.16,101a72.07,72.07,0,0,1,102.32.51c27.75,28.3,26.87,73.93-1.15,102l-13.09,13.09a16.08,16.08,0,0,0-3.78,16.61,184.45,184.45,0,0,1,9.69,52.72c.5,13.9,17.45,20.44,27.29,10.6l37.11-37.1c59.27-59.26,59.27-155.7,0-215Z"></path></svg>
                            <span class="fs12 bold">visits</span>
                            <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                        </div>
                        <div class="flex align-center wtypical-button-style ml4" id="open-user-authbreaks-dialog">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M231,130.52c0,16.59-.13,33.19.06,49.78.08,6.24-2.44,10.4-7.77,13.46q-43.08,24.72-86,49.68c-5.52,3.21-10.45,3-16-.2Q78.8,218.46,36.1,194.09c-5.91-3.37-8.38-7.8-8.34-14.61q.3-49,0-98.1c0-6.63,2.49-10.93,8.2-14.19Q78.68,42.82,121.15,18c5.69-3.32,10.69-3.42,16.38-.1Q180,42.71,222.7,67.1c5.89,3.36,8.46,7.8,8.35,14.61C230.77,98,231,114.25,231,130.52Zm-179.67,0c0,44.84,33,78,77.83,78.16s78.37-33.05,78.39-78.08c0-44.88-32.93-78-77.83-78.14S51.32,85.49,51.29,130.55Z" style="fill:#020202"></path><path d="M129.35,150.13c-13.8,0-27.61,0-41.42,0-8.69,0-13.85-6-13.76-15.79.09-9.62,5.15-15.43,13.6-15.44q40,0,79.93,0c13.05,0,19,7.43,16.37,20.38-1.46,7.17-5.92,10.85-13.29,10.86C157,150.15,143.16,150.13,129.35,150.13Z" style="fill:#020202"></path></svg>
                            <span class="fs12 bold">auth breaks</span>
                            <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                        </div>
                    </div>
                </div>

                <!-- Account management section -->
                <div class="section-style white-background" style="margin-top: 12px; padding: 10px;">
                    <div class="flex align-center mb4">
                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                        <h2 class="fs13 no-margin lblack">User account</h2>
                    </div>
                    <div>
                        <div class="ml8">
                            <p class="no-margin fs12 mt8 lblack"><strong>Register date :</strong> {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
                            <p class="no-margin fs12 mt4 lblack flex align-center">
                                <strong class="mr4">Register type :</strong>
                                @if(!is_null($user->provider))
                                OAuth
                                <svg class="size6 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                                {{ ucfirst($user->provider) }}
                                @else
                                    <span>typical register</span>
                                @endif
                            </p>
                            <p class="no-margin fs12 mt4 lblack bold">Account status : <span class="{{ $ascolor }} ml4">{{ $accountstatus->status }}</span></p>
                        </div>

                        <div class="toggle-box" style="margin-top: 12px">
                            <div class="flex align-center pointer toggle-container-button">
                                <h3 class="no-margin fs13 red">Ban section</h3>
                                <svg class="toggle-arrow size6 ml4" style="margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                            </div>
                            <div class="toggle-container">
                                <!-- user ban history -->
                                <div class="mt4 toggle-box">
                                    <p class="no-margin fs12 mb4">The following box includes all bans that the user got for guidelines violation and website misuse</p>
                                    <div class="flex align-center pointer @if($bans->count()) toggle-container-button @endif">
                                        <h4 class="no-margin lblack fs12">ban history</h4>
                                        @if($bans->count())
                                        <div class="flex align-center ml4">
                                            <span class="block bold fs11 unselectable">@if($totaluserbans) ({{ $totaluserbans }} bans) @endif</span>
                                            <svg class="toggle-arrow size6 ml4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                                        </div>
                                        @endif
                                    </div>
                                    @if($bans->count())
                                    <div class="toggle-box mt4">
                                        <div id="user-bans-box" class="y-auto-overflow toggle-container">
                                            @foreach($bans as $b)
                                            <div class="user-ban-record fs12 lblack mb8">
                                                <p class="no-margin bold">Ban type : <span class="red">{{ ucfirst($b->type) }}</span></p>
                                                <p class="no-margin mt4"><strong>Banned by</strong> : <a href="{{ route('admin.user.manage', ['uid'=>$b->bannedby->id]) }}" class="blue bold no-underline">{{ $b->bannedby->username }}</a></p>
                                                <p class="no-margin mt4"><strong>Ban reason</strong> : {{ $b->reason->reason }}</p>
                                                <p class="no-margin mt4"><strong>banned at :</strong> {{ $b->bandate }}</p>
                                                @if($b->type == 'temporary')
                                                <div class="temporary-infos-container">
                                                    <p class="no-margin mt4"><strong>ban duration :</strong> {{ $b->ban_duration_hummans }}</p>
                                                    <p class="no-margin my4"><strong>expired at :</strong> {{ $b->expired_at }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            @endforeach
        
                                            @if($totaluserbans > 3)
                                            <div class="full-center" style="padding: 8px 0 16px 0" id="user-bans-fetch-more">
                                                <svg class="spinner size24" fill="none" viewBox="0 0 16 16">
                                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                </svg>
                                                <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @else
                                    <div class="section-style flex align-center mt8 width-max-content">
                                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#181818"/></svg>
                                        <p class="bold lblack fs12 no-margin">This user does not have any ban history</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="mt8">
                                    @php $can_unban_user = false; @endphp
                                    @can('unban_user', [\App\Models\User::class]) @php $can_unban_user = true; @endphp @endcan
                                    <div>
                                        @if($banned)
                                            <div class="section-style white-background" style="color: #181818;">
                                                <!-- permanently banned -->
                                                @if($ban->type == 'permanent')
                                                <h4 class="no-margin mb2 fs13 lblack">User banned <strong>permanently</strong></h4>
                                                <p class="no-margin mb8 fs12">This user is currently parmanently banned and cannot access the website anymore</p>
                                                <!-- temporarily banned -->
                                                @else
                                                    <h4 class="no-margin mb2 fs13 lblack">User banned <strong>temorarily</strong></h4>
                                                    <p class="no-margin mb8 fs12">This user is currently banned temporarily for {{ $ban->ban_duration_hummans }}</p>
                                                @endif
        
                                                <p class="no-margin fs12"><strong>banned by :</strong> <a href="{{ route('admin.user.manage', ['uid'=>$ban->bannedby->username]) }}" class="blue bold no-underline">{{ $ban->bannedby->username }}</a></p>
                                                <p class="no-margin fs12 mt4"><strong>reason for ban :</strong> {{ $ban->reason->reason }}</p>
                                                <!-- Only show duration and expiration if the ban is temporary -->
                                                @if($ban->type == 'temporary')
                                                <p class="no-margin fs12 mt4"><strong>ban duration :</strong> {{ $ban->ban_duration_hummans }}</p>
                                                <p class="no-margin fs12 mt4"><strong>banned at :</strong> {{ $ban->bandate }}</p>
                                                <p class="no-margin fs12 my4"><strong>expired at :</strong> {{ $ban->expired_at }}</p>
                                                @endif
                                                
                                                @if(!$can_unban_user)
                                                <div class="section-style flex align-center my8">
                                                    <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                                    <p class="fs12 bold lblack no-margin">You cannot unban users because you don't have permission to do so</p>
                                                </div>
                                                @endif

                                                <p class="no-margin fs12 gray mt8 mb4">If this ban was random, performed by mistake, or you decide to unban this user, press unban button below. This will make user account to live but keep ban records history.</p>
                                                
                                                @if($can_unban_user)
                                                <div id="unban-user-button" class="typical-button-style flex align-center width-max-content">
                                                    <div class="relative size14 mr4">
                                                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.22,214.12a4.7,4.7,0,0,1,4.22-4.69c12.34-1.16,23.78-11.69,25.38-24.57.43-3.47,1.27-5,5-4.58,3.08.37,6.61-.72,9.26.42,2.87,1.25,1.36,5.3,2.31,8,4.13,11.79,12.09,19,24.46,20.77,3,.45,4.58,1.24,4,4.47a6.53,6.53,0,0,0,0,1c0,3,.73,6.27-.35,8.78-1.18,2.72-5,1.3-7.59,2.16-12.24,4.07-19.57,12.2-21.33,25-.36,2.6-1,4-3.87,3.58a10.41,10.41,0,0,0-1.48,0c-3,0-6.26.73-8.78-.35-2.72-1.18-1.4-5-2.2-7.58-3.62-11.73-13.56-20.11-24.9-21.22a4.67,4.67,0,0,1-4.14-4.68Zm85.73-11c9.07,19.26,23.66,31.67,44.88,35.55,2.65.49,3.85,1.41,3.31,4.07-.86,4.27,1.28,5.9,5.15,7.11,27.62,8.63,56.87-.32,74.69-23.28,6.78-8.72,11.91-18.47,16.91-28.31,1.77-3.48.7-4.29-2.31-5.37q-44.46-16-88.84-32.34c-3.22-1.19-4.3-.54-5.78,2.41-6.78,13.57-17.81,21.47-32.82,24.13-7.29,1.3-14.41-.75-22.39-.38C83.34,192.66,85.52,198,88,203.13Zm56.59-62.94c-1.47,3.76-1.3,5.53,3,7,12.45,4.16,24.72,8.85,37.05,13.34,17.43,6.35,34.84,12.73,52.29,19,1.16.41,3,2.48,4-.29,2-5.38,4.24-10.69,3-16.71-2-9.76-8.1-15.59-17.35-18.22-3.64-1-5.5-2.74-5.77-6.63a14.74,14.74,0,0,0-4.64-9.59c-2.47-2.34-2.44-4.38-1.33-7.34q18.66-50.06,37.11-100.2c3.4-9.18,3.31-8.92-5.47-12.57-4.38-1.81-5.67-.53-7.16,3.57C226.62,46.38,213.67,81.14,200.92,116c-1,2.78-2.28,4.31-5.43,4.48a15.76,15.76,0,0,0-10.56,4.81c-2.4,2.49-4.53,2.44-7.37,1.18-3.61-1.6-7.38-2.79-9.95-2.81C156.3,123.68,148.63,129.76,144.54,140.19ZM121.36,124.1c.21-2.28-.71-3-3-3.4C102.68,118.09,95,110.37,92,94c-.63-3.48-2.94-2.94-4.68-2.49-3.54.9-9.42-3.16-10.45,2.41C74,109.49,65.48,118.57,49.81,120.77c-4.58.64-2.75,4.22-2.42,6.11.53,3.06-3.17,7.89,2.34,9.1,16.85,3.7,23.69,10.18,26.79,26.92.64,3.43,2.9,3,4.68,2.53,3.54-.92,8.22,3,10.68-2.42a3.8,3.8,0,0,0,.11-1c2.06-14.33,11.52-23.79,26.2-25.83,2.6-.37,3.41-1.32,3.17-3.73-.13-1.3,0-2.63,0-3.94C121.34,127.06,121.23,125.57,121.36,124.1Z"/></svg>
                                                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="bold unselectable fs13">Unban user</span>
                                                    <input type="hidden" class="user-id" autocomplete="off" value="{{ $user->id }}">
                                                    <input type="hidden" class="success-message" value="User has been unbanned successfully" autocomplete="off">
                                                </div>
                                                @else
                                                <div class="typical-button-style disabled-typical-button-style flex align-center width-max-content">
                                                    <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.22,214.12a4.7,4.7,0,0,1,4.22-4.69c12.34-1.16,23.78-11.69,25.38-24.57.43-3.47,1.27-5,5-4.58,3.08.37,6.61-.72,9.26.42,2.87,1.25,1.36,5.3,2.31,8,4.13,11.79,12.09,19,24.46,20.77,3,.45,4.58,1.24,4,4.47a6.53,6.53,0,0,0,0,1c0,3,.73,6.27-.35,8.78-1.18,2.72-5,1.3-7.59,2.16-12.24,4.07-19.57,12.2-21.33,25-.36,2.6-1,4-3.87,3.58a10.41,10.41,0,0,0-1.48,0c-3,0-6.26.73-8.78-.35-2.72-1.18-1.4-5-2.2-7.58-3.62-11.73-13.56-20.11-24.9-21.22a4.67,4.67,0,0,1-4.14-4.68Zm85.73-11c9.07,19.26,23.66,31.67,44.88,35.55,2.65.49,3.85,1.41,3.31,4.07-.86,4.27,1.28,5.9,5.15,7.11,27.62,8.63,56.87-.32,74.69-23.28,6.78-8.72,11.91-18.47,16.91-28.31,1.77-3.48.7-4.29-2.31-5.37q-44.46-16-88.84-32.34c-3.22-1.19-4.3-.54-5.78,2.41-6.78,13.57-17.81,21.47-32.82,24.13-7.29,1.3-14.41-.75-22.39-.38C83.34,192.66,85.52,198,88,203.13Zm56.59-62.94c-1.47,3.76-1.3,5.53,3,7,12.45,4.16,24.72,8.85,37.05,13.34,17.43,6.35,34.84,12.73,52.29,19,1.16.41,3,2.48,4-.29,2-5.38,4.24-10.69,3-16.71-2-9.76-8.1-15.59-17.35-18.22-3.64-1-5.5-2.74-5.77-6.63a14.74,14.74,0,0,0-4.64-9.59c-2.47-2.34-2.44-4.38-1.33-7.34q18.66-50.06,37.11-100.2c3.4-9.18,3.31-8.92-5.47-12.57-4.38-1.81-5.67-.53-7.16,3.57C226.62,46.38,213.67,81.14,200.92,116c-1,2.78-2.28,4.31-5.43,4.48a15.76,15.76,0,0,0-10.56,4.81c-2.4,2.49-4.53,2.44-7.37,1.18-3.61-1.6-7.38-2.79-9.95-2.81C156.3,123.68,148.63,129.76,144.54,140.19ZM121.36,124.1c.21-2.28-.71-3-3-3.4C102.68,118.09,95,110.37,92,94c-.63-3.48-2.94-2.94-4.68-2.49-3.54.9-9.42-3.16-10.45,2.41C74,109.49,65.48,118.57,49.81,120.77c-4.58.64-2.75,4.22-2.42,6.11.53,3.06-3.17,7.89,2.34,9.1,16.85,3.7,23.69,10.18,26.79,26.92.64,3.43,2.9,3,4.68,2.53,3.54-.92,8.22,3,10.68-2.42a3.8,3.8,0,0,0,.11-1c2.06-14.33,11.52-23.79,26.2-25.83,2.6-.37,3.41-1.32,3.17-3.73-.13-1.3,0-2.63,0-3.94C121.34,127.06,121.23,125.57,121.36,124.1Z"/></svg>
                                                    <span class="bold unselectable fs13">Unban user</span>
                                                </div>
                                                @endif
                                            </div>
                                        @else
                                            <!-- Here is an important note :
                                                The user account status could be not banned, in case temporarly ban duration expires
                                                but the user does not any page in the website after the duration is comleted; in this case the middleware
                                                responsible to remove the pan record if duration is expire DOES NOT BE TRIGGERED.
                                                The user should access a page to make the status active again. In this case, the user account is not banned
                                                but it still has temp-banned status. we'll check that below and inform the admin -->
                                            @if($accountstatus->slug == 'temp-banned')
                                                @php $ban = $user->ban; @endphp
                                                <div class="section-style flex">
                                                    <svg class="size13 mt2 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                                    <div class="lblack">
                                                        <p class="no-margin fs13">This user <strong>is not currently banned</strong>, but he still has temporary ban status and he needs to access any page to trigger the middleware responsible to check account status and remove the expired temporary ban record and set its account status to active again</p>
                                                        <p class="no-margin fs13 mt4">You can force this action by clean the expired temp ban record, and make the user account live again by pressing clean button below</p>
                                                        <div class="simple-line-separator my8"></div>
                                                        <p class="no-margin fs12"><strong>reason for ban :</strong> {{ $ban->reason->reason }}</p>
                                                        <p class="no-margin fs12 mt4"><strong>ban duration :</strong> {{ $ban->ban_duration_hummans }}</p>
                                                        <p class="no-margin fs12 mt4"><strong>banned at :</strong> {{ $ban->bandate }}</p>
                                                        <p class="no-margin fs12 my4"><strong>expired at :</strong> {{ $ban->expired_at }}</p>
                                                        @if(!$can_unban_user)
                                                        <div class="section-style flex align-center my8">
                                                            <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                                            <p class="fs12 bold lblack no-margin">You cannot perform this action because you don't have permission to unban users</p>
                                                        </div>
                                                        @endif

                                                        @if($can_unban_user)
                                                        <div id="clean-expired-ban-button" class="typical-button-style flex align-center width-max-content mt8">
                                                            <div class="relative size14 mr4">
                                                                <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.22,214.12a4.7,4.7,0,0,1,4.22-4.69c12.34-1.16,23.78-11.69,25.38-24.57.43-3.47,1.27-5,5-4.58,3.08.37,6.61-.72,9.26.42,2.87,1.25,1.36,5.3,2.31,8,4.13,11.79,12.09,19,24.46,20.77,3,.45,4.58,1.24,4,4.47a6.53,6.53,0,0,0,0,1c0,3,.73,6.27-.35,8.78-1.18,2.72-5,1.3-7.59,2.16-12.24,4.07-19.57,12.2-21.33,25-.36,2.6-1,4-3.87,3.58a10.41,10.41,0,0,0-1.48,0c-3,0-6.26.73-8.78-.35-2.72-1.18-1.4-5-2.2-7.58-3.62-11.73-13.56-20.11-24.9-21.22a4.67,4.67,0,0,1-4.14-4.68Zm85.73-11c9.07,19.26,23.66,31.67,44.88,35.55,2.65.49,3.85,1.41,3.31,4.07-.86,4.27,1.28,5.9,5.15,7.11,27.62,8.63,56.87-.32,74.69-23.28,6.78-8.72,11.91-18.47,16.91-28.31,1.77-3.48.7-4.29-2.31-5.37q-44.46-16-88.84-32.34c-3.22-1.19-4.3-.54-5.78,2.41-6.78,13.57-17.81,21.47-32.82,24.13-7.29,1.3-14.41-.75-22.39-.38C83.34,192.66,85.52,198,88,203.13Zm56.59-62.94c-1.47,3.76-1.3,5.53,3,7,12.45,4.16,24.72,8.85,37.05,13.34,17.43,6.35,34.84,12.73,52.29,19,1.16.41,3,2.48,4-.29,2-5.38,4.24-10.69,3-16.71-2-9.76-8.1-15.59-17.35-18.22-3.64-1-5.5-2.74-5.77-6.63a14.74,14.74,0,0,0-4.64-9.59c-2.47-2.34-2.44-4.38-1.33-7.34q18.66-50.06,37.11-100.2c3.4-9.18,3.31-8.92-5.47-12.57-4.38-1.81-5.67-.53-7.16,3.57C226.62,46.38,213.67,81.14,200.92,116c-1,2.78-2.28,4.31-5.43,4.48a15.76,15.76,0,0,0-10.56,4.81c-2.4,2.49-4.53,2.44-7.37,1.18-3.61-1.6-7.38-2.79-9.95-2.81C156.3,123.68,148.63,129.76,144.54,140.19ZM121.36,124.1c.21-2.28-.71-3-3-3.4C102.68,118.09,95,110.37,92,94c-.63-3.48-2.94-2.94-4.68-2.49-3.54.9-9.42-3.16-10.45,2.41C74,109.49,65.48,118.57,49.81,120.77c-4.58.64-2.75,4.22-2.42,6.11.53,3.06-3.17,7.89,2.34,9.1,16.85,3.7,23.69,10.18,26.79,26.92.64,3.43,2.9,3,4.68,2.53,3.54-.92,8.22,3,10.68-2.42a3.8,3.8,0,0,0,.11-1c2.06-14.33,11.52-23.79,26.2-25.83,2.6-.37,3.41-1.32,3.17-3.73-.13-1.3,0-2.63,0-3.94C121.34,127.06,121.23,125.57,121.36,124.1Z"/></svg>
                                                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                                </svg>
                                                            </div>
                                                            <span class="bold unselectable">Clean expired ban & active account</span>
                                                            <input type="hidden" class="user-id" autocomplete="off" value="{{ $user->id }}">
                                                            <input type="hidden" class="success-message" value="Expired ban record has been cleaned successfully" autocomplete="off">
                                                        </div>
                                                        @else
                                                        <div class="typical-button-style disabled-typical-button-style flex align-center width-max-content mt8">
                                                            <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.22,214.12a4.7,4.7,0,0,1,4.22-4.69c12.34-1.16,23.78-11.69,25.38-24.57.43-3.47,1.27-5,5-4.58,3.08.37,6.61-.72,9.26.42,2.87,1.25,1.36,5.3,2.31,8,4.13,11.79,12.09,19,24.46,20.77,3,.45,4.58,1.24,4,4.47a6.53,6.53,0,0,0,0,1c0,3,.73,6.27-.35,8.78-1.18,2.72-5,1.3-7.59,2.16-12.24,4.07-19.57,12.2-21.33,25-.36,2.6-1,4-3.87,3.58a10.41,10.41,0,0,0-1.48,0c-3,0-6.26.73-8.78-.35-2.72-1.18-1.4-5-2.2-7.58-3.62-11.73-13.56-20.11-24.9-21.22a4.67,4.67,0,0,1-4.14-4.68Zm85.73-11c9.07,19.26,23.66,31.67,44.88,35.55,2.65.49,3.85,1.41,3.31,4.07-.86,4.27,1.28,5.9,5.15,7.11,27.62,8.63,56.87-.32,74.69-23.28,6.78-8.72,11.91-18.47,16.91-28.31,1.77-3.48.7-4.29-2.31-5.37q-44.46-16-88.84-32.34c-3.22-1.19-4.3-.54-5.78,2.41-6.78,13.57-17.81,21.47-32.82,24.13-7.29,1.3-14.41-.75-22.39-.38C83.34,192.66,85.52,198,88,203.13Zm56.59-62.94c-1.47,3.76-1.3,5.53,3,7,12.45,4.16,24.72,8.85,37.05,13.34,17.43,6.35,34.84,12.73,52.29,19,1.16.41,3,2.48,4-.29,2-5.38,4.24-10.69,3-16.71-2-9.76-8.1-15.59-17.35-18.22-3.64-1-5.5-2.74-5.77-6.63a14.74,14.74,0,0,0-4.64-9.59c-2.47-2.34-2.44-4.38-1.33-7.34q18.66-50.06,37.11-100.2c3.4-9.18,3.31-8.92-5.47-12.57-4.38-1.81-5.67-.53-7.16,3.57C226.62,46.38,213.67,81.14,200.92,116c-1,2.78-2.28,4.31-5.43,4.48a15.76,15.76,0,0,0-10.56,4.81c-2.4,2.49-4.53,2.44-7.37,1.18-3.61-1.6-7.38-2.79-9.95-2.81C156.3,123.68,148.63,129.76,144.54,140.19ZM121.36,124.1c.21-2.28-.71-3-3-3.4C102.68,118.09,95,110.37,92,94c-.63-3.48-2.94-2.94-4.68-2.49-3.54.9-9.42-3.16-10.45,2.41C74,109.49,65.48,118.57,49.81,120.77c-4.58.64-2.75,4.22-2.42,6.11.53,3.06-3.17,7.89,2.34,9.1,16.85,3.7,23.69,10.18,26.79,26.92.64,3.43,2.9,3,4.68,2.53,3.54-.92,8.22,3,10.68-2.42a3.8,3.8,0,0,0,.11-1c2.06-14.33,11.52-23.79,26.2-25.83,2.6-.37,3.41-1.32,3.17-3.73-.13-1.3,0-2.63,0-3.94C121.34,127.06,121.23,125.57,121.36,124.1Z"/></svg>
                                                            <span class="bold unselectable">Clean expired ban & active account</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    
                                                </div>
                                            @endif
                                            <!-- ban user section -->
                                            <div class="um-ban-type-box" style="margin-top: 10px">
                                                <div class="flex align-center">
                                                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M133.28,5.08h5.82c9.12,3.68,11.64,7.49,11.63,17.56q0,41.69,0,83.36a33.18,33.18,0,0,0,.09,4.35c.31,2.52,1.7,4.18,4.37,4.33,2.94.17,4.49-1.56,5-4.22a23.31,23.31,0,0,0,.13-4.35q0-37.8,0-75.6c0-9.49,5.91-15.89,14.48-15.79,8.25.09,14.27,6.68,14.25,15.71q-.06,42.41-.18,84.8a27.74,27.74,0,0,0,.18,4.83c.48,2.7,2.11,4.43,5,4.2,2.58-.2,4-1.82,4.27-4.43.08-.8.07-1.61.07-2.42q0-28.35-.08-56.7c0-4.12.44-8.06,2.94-11.5A14.34,14.34,0,0,1,217.17,44c6.35,2,10.1,7.94,10.09,16q-.06,61.06-.12,122.13a121.16,121.16,0,0,1-.74,13c-3.19,28.63-19.47,47.82-47.27,55.18-16.37,4.33-33,3.7-49.46.47-20-3.93-36.55-13.65-48.09-30.64-15.76-23.21-31-46.74-46.51-70.16a20.9,20.9,0,0,1-2.13-4.32c-4.68-12.84,4.91-25.12,18.14-23.18,5.55.81,9.81,3.87,13.1,8.36,6.31,8.63,12.63,17.25,19.68,26.87,0-16.64,0-31.95,0-47.25q0-35.13,0-70.27c0-7.58,3.18-12.62,9.24-15,10.31-4,19.76,3.91,19.66,16.09-.19,22.29-.11,44.58-.16,66.87,0,3.33.51,6.46,4.68,6.48s4.75-3.09,4.75-6.42c0-28.11.2-56.22-.13-84.33C121.79,14.87,124.51,8.36,133.28,5.08Z"/></svg>
                                                    <h3 class="no-margin lblack fs13">ban user</h3>
                                                </div>
                                                <p class="no-margin fs12 mt4 mb4">First select whether you want to ban user temporarily or permanently</p>
                                                <div class="flex align-center fs12 my8">
                                                    <div class="flex">
                                                        <div class="flex align-center">
                                                            <input type="radio" name="user-ban-type" id="um-temporarily-ban" class="um-ban-type-switch no-margin" checked="checked" autocomplete="off" value="temporary">
                                                            <label for="um-temporarily-ban" class="bold ml4 lblack">Temporary ban</label>
                                                        </div>
                                                        <div class="flex align-center" style="margin-left: 12px">
                                                            <input type="radio" name="user-ban-type" id="um-permanent-ban" class="um-ban-type-switch no-margin" autocomplete="off" value="permanent">
                                                            <label for="um-permanent-ban" class="bold ml4 lblack">Permanent ban</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="section-style" style="padding: 8px">
                                                    <!-- temporary ban box -->
                                                    <div class="temporary-ban-box">
                                                        <h4 class="no-margin lblack fs13 mb4">Temporary ban</h4>
                                                        <span class="fs13">This type of ban will prevent the user from doing all activities for a selected period of time.</span>
                                                        <div class="flex align-center mt4">
                                                            <p class="no-margin bold fs11 lblack mr8">Select duration for ban :</span>
                                                            <div class="relative custom-dropdown-box">
                                                                <input type="hidden" class="custom-dropdown-value ban-duration" autocomplete="off" value="7">
                                                                <div class="typical-button button-with-suboptions custom-dropdown-selector" style="padding: 3px 9px;">
                                                                    <span class="custom-dropdown-selected-option-text fs12">7 days</span>
                                                                    <svg class="size6 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M28.61,13.35l-11,9.39a4,4,0,0,1-5.18,0l-11-9.31A4,4,0,1,1,6.59,7.32L15,14.45l8.37-7.18a4,4,0,0,1,5.2,6.08Z"/></svg>
                                                                </div>
                                                                <div class="custom-dropdown-options-container suboptions-container typical-suboptions-container y-auto-overflow mb4" style="width: max-content; max-width: 380px; max-height: 270px;">
                                                                    <div class="typical-suboption custom-drop-down-option custom-dropdown-option-selected mb4">
                                                                        <span class="custom-dropdown-option-text block lblack fs12">7 days</span>
                                                                        <input type="hidden" class="custom-dropdown-option-value" value="7" autocomplete="off">
                                                                    </div>
                                                                    <div class="typical-suboption custom-drop-down-option mb4">
                                                                        <span class="custom-dropdown-option-text block lblack fs12">14 days</span>
                                                                        <input type="hidden" class="custom-dropdown-option-value" value="14" autocomplete="off">
                                                                    </div>
                                                                    <div class="typical-suboption custom-drop-down-option mb4">
                                                                        <span class="custom-dropdown-option-text block lblack fs12">1 month</span>
                                                                        <input type="hidden" class="custom-dropdown-option-value" value="30" autocomplete="off">
                                                                    </div>
                                                                    <div class="typical-suboption custom-drop-down-option mb4">
                                                                        <span class="custom-dropdown-option-text block lblack fs12">2 month</span>
                                                                        <input type="hidden" class="custom-dropdown-option-value" value="60" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- permanent ban box -->
                                                    <div class="permanent-ban-box none">
                                                        <h4 class="no-margin lblack fs13 mb4">Permanent ban</h4>
                                                        <span class="fs13">This type of ban will prevent the user from doing all activities permanently and the user will not be able login anymore.</span>
                                                    </div>
        
                                                    <p class="mt8 mb4 bold fs11 lblack">Select reason for ban :</span>
                                                    <div class="relative custom-dropdown-box width-max-content">
                                                        <input type="hidden" class="custom-dropdown-value ban-reason" autocomplete="off" value="{{ $banreasons->first()->id }}">
                                                        <div class="typical-button button-with-suboptions custom-dropdown-selector">
                                                            <span class="custom-dropdown-selected-option-text">{{ $banreasons->first()->name }}</span>
                                                            <svg class="size6 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M28.61,13.35l-11,9.39a4,4,0,0,1-5.18,0l-11-9.31A4,4,0,1,1,6.59,7.32L15,14.45l8.37-7.18a4,4,0,0,1,5.2,6.08Z"/></svg>
                                                        </div>
                                                        <div class="custom-dropdown-options-container suboptions-container typical-suboptions-container y-auto-overflow mb4" style="width: max-content; max-width: 380px; max-height: 270px;">
                                                            @foreach($banreasons as $reason)
                                                            <div class="typical-suboption custom-drop-down-option mb4">
                                                                <span class="custom-dropdown-option-text block bold lblack fs13">{{ $reason->name }}</span>
                                                                <span class="fs12">{{ $reason->reason }}</span>
                                                                <input type="hidden" class="custom-dropdown-option-value" value="{{ $reason->id }}" autocomplete="off">
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @php
                                                        $can_ban_temporarily = false;
                                                        $can_ban_permanently = false;
                                                    @endphp

                                                    @can('ban_user_temporarily', [\App\Models\User::class])
                                                        @php $can_ban_temporarily = true; @endphp
                                                    @endcannot

                                                    @can('ban_user_permanently', [\App\Models\User::class])
                                                        @php $can_ban_permanently = true; @endphp
                                                    @endcannot

                                                    @if(!$can_ban_temporarily OR !$can_ban_permanently)
                                                    <div class="section-style flex align-center my8">
                                                        <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                                        @if(!$can_ban_temporarily && !$can_ban_permanently)                                                        
                                                        <p class="fs12 bold lblack no-margin">You cannot ban users because you don't have permissions to do so</p>
                                                        @else
                                                            @if($can_ban_temporarily && !$can_ban_permanently)
                                                            <p class="fs12 bold lblack no-margin">You can only ban users temporarily. For permanent ban, you need permission</p>
                                                            @else
                                                            <p class="fs12 bold lblack no-margin">You can only ban users permanently. For temporarily ban, you need permission</p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    @endif

                                                    @if($can_ban_temporarily OR $can_ban_permanently)
                                                    <div id="ban-user-button" class="red-button-style full-center width-max-content mt8">
                                                        <div class="relative size14 mr4">
                                                            <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                                                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="bold unselectable">Ban user</span>
                                                        <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                                                        <input type="hidden" class="success-message" value="User has been banned successfully" autocomplete="off">
                                                    </div>
                                                    @else
                                                    <div class="red-button-style disabled-red-button-style full-center width-max-content mt8">
                                                        <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                                                        <span class="bold unselectable">Ban user</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- warnings and strikes -->
                <div class="section-style white-background" style="margin-top: 12px; padding: 10px;">
                    <div class="flex align-center mb4">
                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"></path></svg>
                        <h2 class="fs13 no-margin lblack">Warnings and strikes</h2>
                        @if($userstats['warnings'])
                        <div id="open-user-warnings-dialog" class="wtypical-button-style ml8" style="padding: 4px 8px;">
                            <svg class="size11 mr4" style="margin-top: 1px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129,233.33h-108c-13.79,0-18.82-8.86-11.87-20.89q54-93.6,108.12-187.2c7.34-12.71,17.14-12.64,24.55.17,36,62.4,71.95,124.88,108.27,187.13,7.05,12.07-.9,21.28-12.37,21.06C201.43,232.88,165.21,233.33,129,233.33Zm91.36-24L129.4,51.8,38.5,209.3Zm-79-103.77c-.13-7.56-5.28-13-12-12.85s-11.77,5.58-11.82,13.1q-.13,20.58,0,41.18c.05,7.68,4.94,13,11.69,13.14,6.92.09,12-5.48,12.15-13.39.09-6.76,0-13.53,0-20.29C141.35,119.45,141.45,112.49,141.32,105.53Zm-.15,70.06a12.33,12.33,0,0,0-10.82-10.26,11.29,11.29,0,0,0-12,7.71,22.1,22.1,0,0,0,0,14A11.82,11.82,0,0,0,131.4,195c6.53-1.09,9.95-6.11,9.81-14.63A31.21,31.21,0,0,0,141.17,175.59Z" style="fill:#020202"></path></svg>
                            <span class="flex fs11 bold">review warnings</span>
                            <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                        </div>
                        @endif
                        @if($userstats['strikes'])
                        <div id="open-user-strikes-dialog" class="wtypical-button-style ml8" style="padding: 4px 8px;">
                            <svg class="size11 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M6.19,144.31v-27c1.47-.52,1-1.87,1.11-2.87,1.67-11.65,4.54-23,9.59-33.63,19-40.1,50.14-65.08,94.22-71.63C157.76,2.25,197,17.72,226.2,54.57S261,133,244,176.58c-14.65,37.32-42.45,61.42-81,73-7.16,2.15-14.66,2.45-21.77,4.67H116.12c-.4-1.26-1.52-.94-2.39-1.06a120.16,120.16,0,0,1-29.21-7.6q-56.1-23.31-73.69-81.47C8.85,157.58,8.86,150.64,6.19,144.31ZM37,132.44c.14,16.35,5.15,33.28,15.18,48.78,1.74,2.69,2.59,2.68,4.78.48q61.74-61.9,123.67-123.62c2-2,2.1-2.84-.39-4.47a90.28,90.28,0,0,0-45-15.16C82,35.51,37.57,77.17,37,132.44Zm185.17-3.16c-.1-16.18-5.06-33.13-15.05-48.65-1.78-2.77-2.71-2.93-5.08-.55Q140.52,141.82,78.76,203.36c-2.11,2.1-2.43,3,.37,4.79a91.16,91.16,0,0,0,44.59,15C176.82,226.4,221.47,184.75,222.21,129.28Z" style="fill:#040205"></path></svg>
                            <span class="flex fs11 bold">review strikes</span>
                            <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                        </div>
                        @endif
                    </div>
                    <p class="lblack no-margin fs13">Warnings and strikes that this user got for guidelines violation and website misuse by admins.</p>
                    <!-- warnings -->
                    @if($userstats['warnings'])
                    <div class="toggle-box mt8">
                        <div class="flex align-center pointer toggle-container-button">
                            <h2 class="bold fs12 lblack no-margin">warnings : ({{ $userstats['warnings'] }})</h2>
                            <svg class="toggle-arrow size6 ml4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                        </div>
                        <div class="toggle-container ml4">
                            @foreach($user->warnings()->with(['reason'])->orderBy('created_at', 'desc')->take(3)->get() as $warning)
                            <div class="flex my8">
                                <div class="fs10 mr8 mt2 gray">•</div>
                                <div>
                                    <p class="no-margin fs13 warning-name">{{ $warning->reason->name }}</p>
                                    <div class="relative width-max-content">
                                        <p class="no-margin fs11 gray tooltip-section">warned : {{ $warning->athummans }}</p>
                                        <div class="tooltip tooltip-style-1">
                                            {{ $warning->warningdate }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if($userstats['warnings'] > 3)
                                <span class="bold fs11">+ {{ $userstats['warnings'] - 3 }} others</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <!-- strikes -->
                    @if($userstats['strikes'])
                    <div class="toggle-box mt8">
                        <div class="flex align-center pointer toggle-container-button">
                            <h2 class="bold fs12 lblack no-margin">strikes : ({{ $userstats['strikes'] }})</h2>
                            <svg class="toggle-arrow size6 ml4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                        </div>
                        <div class="toggle-container ml4">
                            @foreach($user->strikes()->with(['reason'])->orderBy('created_at', 'desc')->take(3)->get() as $strike)
                            <div class="flex my8">
                                <div class="fs10 mr8 mt2 gray">•</div>
                                <div>
                                    <p class="no-margin fs13 strike-name">{{ $strike->reason->name }}</p>
                                    <div class="relative width-max-content">
                                        <p class="no-margin fs11 gray tooltip-section">striked : {{ $strike->athummans }}</p>
                                        <div class="tooltip tooltip-style-1">
                                            {{ $strike->strikedate }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if($userstats['strikes'] > 3)
                                <span class="bold fs11">+ {{ $userstats['strikes'] - 3 }} others</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if(!$userstats['warnings'] && !$userstats['strikes'])
                    <div class="green-section-style flex align-center mt8 width-max-content">
                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                        <p class="bold green fs12 no-margin">This user does not have any warning or strike</p>
                    </div>
                    @endif
                </div>
                <!-- roles and permissions -->
                <div class="section-style white-background" style="margin-top: 12px; padding: 10px;">
                    <div class="flex align-center mb4">
                        <svg class="mr4 size12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M74.87,257.35c-6.23-6.1-12.61-12.06-18.62-18.36-2.34-2.45-3.6-2.13-5.63.14-3.09,3.43-6.41,6.66-9.77,9.83-4.06,3.81-8.2,3.8-12.2-.1-6.26-6.11-12.4-12.34-18.55-18.56-5.15-5.2-5.19-8.73,0-13.92Q34.21,192.2,58.42,168.1c14.25-14.23,28.44-28.52,42.81-42.61,2.42-2.36,2.72-4.11,1.31-7.16-19.18-41.47-2.48-87.75,38.54-107.18C188.48-11.31,246,19.72,253.29,71.68c6.35,45.17-23.62,85.28-68.64,91.35a75.39,75.39,0,0,1-44.71-7.26c-3-1.5-4.72-1.33-7.14,1.14Q110.6,179.52,88,201.74c-2.16,2.14-2.71,3.41-.14,5.75,5.12,4.66,9.9,9.7,14.76,14.64,4.66,4.74,4.75,8.6.23,13.19q-9.19,9.36-18.55,18.56a47.87,47.87,0,0,1-4.49,3.47Zm139-173.46a39.61,39.61,0,0,0-79.22-.14c-.09,21.48,18,39.61,39.62,39.75S213.85,105.64,213.89,83.89Z"></path></svg>
                        <h2 class="fs13 no-margin forum-color">User roles and permissions</h2>
                    </div>
                    <p class="lblack no-margin fs13">Roles and permissions acquired by this user. To manage roles and permissions of this user <a href="{{ route('admin.rap.manage.user') . '?uid=' . $user->id }}" class="bold blue no-underline fs12 ml4">click here</a></p>
                    @if($rolescount = $user->roles()->count())
                        <span class="bold block fs12 lblack mt8">Roles : ({{ $rolescount }})</span>
                        <div class="flex mt4">
                            @foreach($user->roles->sortBy('priority') as $role)
                            <div class="wtypical-button-style mr8">
                                @if($loop->first)
                                <span class="fs11 lblack flex bold"><span class="blue mr4">high role</span> : {{ $role->role }}</span>
                                @else
                                <span class="fs11 lblack flex bold">{{ $role->role }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                    <div class="flex align-center mt8" style="padding: 4px">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="bold lblack fs12 no-margin">This user does not have any role - <em class="gray normal-weight">normal user</em></p>
                    </div>
                    @endif

                    @if($permissionscount = $user->permissions()->count())
                    <div class="toggle-box mt8">
                        <div class="pointer toggle-container-button flex align-center">
                            <span class="bold block fs12 lblack pointer toggle-container-button">Permissions : ({{ $permissionscount }})</span>
                            <svg class="toggle-arrow size6 ml4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                        </div>
                        <div class="mt4 toggle-container">
                            <div class="flex flex-wrap">
                                @foreach($user->permissions()->orderBy('scope')->take(8)->get() as $permission)
                                <div class="wtypical-button-style mr8 mb8">
                                    <span class="fs11 lblack flex">{{ $permission->permission }}</span>
                                </div>
                                @endforeach
                                @if($permissionscount > 8)
                                <span class="flex bold blue fs12 height-max-content self-center mb8">+ {{ $permissionscount - 6 }} other permissions</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="flex align-center mt4" style="padding: 4px">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="bold lblack fs12 no-margin">This user does not have any permission</p>
                    </div>
                    @endif
                </div>
            </div>
            <div id="admin-um-right-panel" style="margin-left: 14px">
                <div class="flex align-center" style="margin-bottom: 12px">
                    <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                    <h3 class="fs15 bold no-margin lblack">User informations</h3>
                </div>
                <div>
                    <p class="lblack no-margin fs12 mb8"> <span class="bold">fullname</span> : {{ $user->fullname }}</p>
                    <p class="lblack no-margin fs12 mb8"> <span class="bold">username</span> : {{ $user->username }}</p>
                    <p class="lblack no-margin fs12 mb8"> <span class="bold">email</span> : {{ $user->email }}</p>
                    <p class="lblack no-margin fs12 mb8"> <span class="bold">about</span> : @if($user->about) {{ $user->about }} @else <em class="gray fs11">empty</em> @endif</p>
                    <p class="lblack no-margin fs12 mb8"> <span class="bold">birth</span> : @if($user->personal->birth) {{ $user->personal->birth }} @else <em class="gray fs11">empty</em> @endif</p>
                    <p class="lblack no-margin fs12 mb8"> <span class="bold">country - city</span> : 
                    @if($user->personal->country) {{ $user->personal->country }} @else <em class="gray fs11">empty</em> @endif - 
                    @if($user->personal->city) {{ $user->personal->city }} @else <em class="gray fs11">empty</em> @endif</p>
                    <p class="lblack no-margin fs12 mb8"> <span class="bold">phone</span> : @if($phone = $user->personal->phone) {{ $phone }} @else <em class="gray fs11">empty</em> @endif</p>
                    
                    <div class="simple-line-separator my8"></div>
                    <div class="flex align-center" style="margin-bottom: 12px">
                        <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V80A48,48,0,0,0,400,32ZM160,368a16,16,0,0,1-16,16H112a16,16,0,0,1-16-16V240a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Zm96,0a16,16,0,0,1-16,16H208a16,16,0,0,1-16-16V144a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Zm96,0a16,16,0,0,1-16,16H304a16,16,0,0,1-16-16V304a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Z"/></svg>
                        <h3 class="fs15 bold no-margin lblack">Statistics</h3>
                    </div>
                    <div class="flex align-center mb8">
                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 559.98 559.98"><path d="M280,0C125.6,0,0,125.6,0,280S125.6,560,280,560s280-125.6,280-280S434.38,0,280,0Zm0,498.78C159.35,498.78,61.2,400.63,61.2,280S159.35,61.2,280,61.2,498.78,159.35,498.78,280,400.63,498.78,280,498.78Zm24.24-218.45V163a23.72,23.72,0,0,0-47.44,0V287.9c0,.38.09.73.11,1.1a23.62,23.62,0,0,0,6.83,17.93l88.35,88.33a23.72,23.72,0,1,0,33.54-33.54Z"/></svg>
                        <p class="lblack no-margin fs13"> <span class="bold">Join Date</span> : {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
                    </div>
                    <div class="flex height-max-content">
                        <svg class="size14 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <g>
                                <path d="M146.9,234.19A87.1,87.1,0,1,0,234,147.1,87.12,87.12,0,0,0,146.9,234.19Zm130.65,0A43.55,43.55,0,1,1,234,190.65,43.56,43.56,0,0,1,277.55,234.19Z"/>
                                <path d="M329.48,70.28A21.37,21.37,0,0,0,305,91.47h0c0,10.09,8.16,19.61,18.13,21.16a90.1,90.1,0,0,1,75,75c1.55,10,11.07,18.13,21.16,18.13h0a21.37,21.37,0,0,0,21.19-24.48A133.06,133.06,0,0,0,329.48,70.28Z"/>
                                <path d="M425.85,254.82a9.8,9.8,0,0,0-11.45,10.75,180.29,180.29,0,0,1-32.79,124.58c-22.14-28.49-56.34-47.09-95.35-47.09-9.26,0-23.59,8.71-52.26,8.71s-43-8.71-52.26-8.71c-38.92,0-73.12,18.6-95.35,47.09A180.14,180.14,0,0,1,52.62,279.91c2.66-96,80.45-173.7,176.4-176.29q6.63-.18,13.16.11a9.8,9.8,0,0,0,10.13-11.17A158.17,158.17,0,0,0,246.4,66.9,9.83,9.83,0,0,0,237.24,60h-.06C112.7,58.3,9,160.44,9,284.93,9,426,138.59,536.67,285.24,504.35a221.36,221.36,0,0,0,168-167.67,234.77,234.77,0,0,0,5.32-66,9.77,9.77,0,0,0-6.3-8.52A156.61,156.61,0,0,0,425.85,254.82ZM234,466.45a180.39,180.39,0,0,1-118-43.91,78.15,78.15,0,0,1,63.14-35.84C198,392.51,216,395.41,234,395.41a181.65,181.65,0,0,0,54.89-8.71A78.37,78.37,0,0,1,352,422.54,180.39,180.39,0,0,1,234,466.45Z"/><path d="M329.87,4.77A21.05,21.05,0,0,0,306.5,26.09h0A21.46,21.46,0,0,0,326,47.41,158.69,158.69,0,0,1,468.46,189.86a21.46,21.46,0,0,0,21.32,19.51h0A21,21,0,0,0,511.1,186C502.05,90.26,425.62,13.82,329.87,4.77Z"/>
                            </g>
                        </svg>
                        <div class="flex align-center fs13">
                            <span class="bold lblack">followers :</span>
                            <span class="ml4">{{ $userstats['followers'] }}</span>
                        </div>
                        <div class="gray height-max-content mx8 mt2 fs10 unselectable">•</div>
                        <div class="flex align-center fs13">
                            <span class="bold lblack">followings :</span>
                            <span class="ml4">{{ $userstats['follows'] }}</span>
                        </div>
                    </div>
                    <div class="flex align-center my8">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,17.11h97.27c11.82,0,15.64,3.73,15.64,15.34q0,75.07,0,150.16c0,11.39-3.78,15.13-15.22,15.13-2.64,0-5.3.12-7.93-.06a11.11,11.11,0,0,1-10.53-9.38c-.81-5.69,2-11,7.45-12.38,3.28-.84,3.52-2.36,3.51-5.06-.07-27.15-.11-54.29,0-81.43,0-3.68-1-4.69-4.68-4.68q-85.63.16-171.29,0c-3.32,0-4.52.68-4.5,4.33q.26,41,0,81.95c0,3.72,1.3,4.53,4.56,4.25a45.59,45.59,0,0,1,7.39.06,11.06,11.06,0,0,1,10.58,11c0,5.62-4.18,10.89-9.91,11.17-8.43.4-16.92.36-25.36,0-5.16-.23-8.82-4.31-9.68-9.66a33,33,0,0,1-.24-5.27q0-75.08,0-150.16c0-11.61,3.81-15.34,15.63-15.34Zm22.49,45.22c16.56,0,33.13,0,49.7,0,5.79,0,13.59,2,16.83-.89,3.67-3.31.59-11.25,1.19-17.13.4-3.92-1.21-4.54-4.73-4.51-19.21.17-38.42.08-57.63.08-22.73,0-45.47.11-68.21-.1-4,0-5.27,1-4.92,5a75.62,75.62,0,0,1,0,12.68c-.32,3.89.78,5,4.85,5C110.54,62.21,131.51,62.33,152.49,62.33ZM62.3,51.13c0-11.26,0-11.26-11.45-11.26h-.53c-10.47,0-10.47,0-10.47,10.71,0,11.75,0,11.75,11.49,11.75C62.3,62.33,62.3,62.33,62.3,51.13ZM102,118.66c25.79.3,18.21-2.79,36.49,15.23,18.05,17.8,35.89,35.83,53.8,53.79,7.34,7.35,7.3,12.82-.13,20.26q-14.94,15-29.91,29.87c-6.86,6.81-12.62,6.78-19.5-.09-21.3-21.28-42.53-42.64-63.92-63.84a16.11,16.11,0,0,1-5.24-12.62c.23-9.86,0-19.73.09-29.59.07-8.71,4.24-12.85,13-13C91.81,118.59,96.92,118.66,102,118.66ZM96.16,151c.74,2.85-1.53,6.66,1.41,9.6,17.66,17.71,35.39,35.36,53,53.11,1.69,1.69,2.59,1.48,4.12-.12,4.12-4.34,8.24-8.72,12.73-12.67,2.95-2.59,2.36-4-.16-6.49-15.68-15.46-31.4-30.89-46.63-46.79-4.56-4.76-9.1-6.73-15.59-6.35C96.18,141.8,96.16,141.41,96.16,151Z"></path></svg>
                        <p class="bblack no-margin fs13"> <span class="bold">Threads</span> : {{ $userstats['threads'] }}</p>
                    </div>
                    <div class="flex align-center my8">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                        <p class="bblack no-margin fs13"> <span class="bold">Replies</span> : {{ $userstats['posts'] }}</p>
                    </div>
                    <div class="flex align-center my8">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g id="Layer_1_copy" data-name="Layer 1 copy"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"/></g></svg>
                        <p class="bblack no-margin fs13"> <span class="bold">All resources votes</span> : {{ $userstats['votes'] }}</p>
                    </div>
                </div>
                <div class="simple-line-separator my8"></div>
                <div class="flex align-center" style="margin-bottom: 12px">
                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                    <h3 class="fs15 bold no-margin lblack">Account</h3>
                </div>
                <div>
                    <div class="flex align-center mb8">
                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M29.07,250.65c-3.72-2.81-4.37-6.57-4.14-11,2.27-43.53,32.32-79.77,75.31-86.63,26.75-4.27,54.58-6.14,80.35,5.68,35.09,16.11,53.55,44.14,55.71,82.82.22,4-1.46,6.72-4.19,9.17Z"/><path d="M67.17,73.58a63.42,63.42,0,1,1,63.76,63.34A63.52,63.52,0,0,1,67.17,73.58Z"/></svg>
                        <p class="bblack no-margin fs13"> <span class="bold">Account status</span> : {{ $accountstatus->status }}</p>
                    </div>
                    <div class="flex align-center mb8">
                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                        <p class="bblack no-margin fs13"> <span class="bold">Warnings</span> : {{ $userstats['warnings'] }}</p>
                    </div>
                    <div class="flex align-center mb8">
                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M6.19,144.31v-27c1.47-.52,1-1.87,1.11-2.87,1.67-11.65,4.54-23,9.59-33.63,19-40.1,50.14-65.08,94.22-71.63C157.76,2.25,197,17.72,226.2,54.57S261,133,244,176.58c-14.65,37.32-42.45,61.42-81,73-7.16,2.15-14.66,2.45-21.77,4.67H116.12c-.4-1.26-1.52-.94-2.39-1.06a120.16,120.16,0,0,1-29.21-7.6q-56.1-23.31-73.69-81.47C8.85,157.58,8.86,150.64,6.19,144.31ZM37,132.44c.14,16.35,5.15,33.28,15.18,48.78,1.74,2.69,2.59,2.68,4.78.48q61.74-61.9,123.67-123.62c2-2,2.1-2.84-.39-4.47a90.28,90.28,0,0,0-45-15.16C82,35.51,37.57,77.17,37,132.44Zm185.17-3.16c-.1-16.18-5.06-33.13-15.05-48.65-1.78-2.77-2.71-2.93-5.08-.55Q140.52,141.82,78.76,203.36c-2.11,2.1-2.43,3,.37,4.79a91.16,91.16,0,0,0,44.59,15C176.82,226.4,221.47,184.75,222.21,129.28Z" style="fill:#040205"/></svg>
                        <p class="bblack no-margin fs13"> <span class="bold">Strikes</span> : {{ $userstats['strikes'] }}</p>
                    </div>
                    <div class="flex align-center mb8">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M231,130.52c0,16.59-.13,33.19.06,49.78.08,6.24-2.44,10.4-7.77,13.46q-43.08,24.72-86,49.68c-5.52,3.21-10.45,3-16-.2Q78.8,218.46,36.1,194.09c-5.91-3.37-8.38-7.8-8.34-14.61q.3-49,0-98.1c0-6.63,2.49-10.93,8.2-14.19Q78.68,42.82,121.15,18c5.69-3.32,10.69-3.42,16.38-.1Q180,42.71,222.7,67.1c5.89,3.36,8.46,7.8,8.35,14.61C230.77,98,231,114.25,231,130.52Zm-179.67,0c0,44.84,33,78,77.83,78.16s78.37-33.05,78.39-78.08c0-44.88-32.93-78-77.83-78.14S51.32,85.49,51.29,130.55Z" style="fill:#020202"/><path d="M129.35,150.13c-13.8,0-27.61,0-41.42,0-8.69,0-13.85-6-13.76-15.79.09-9.62,5.15-15.43,13.6-15.44q40,0,79.93,0c13.05,0,19,7.43,16.37,20.38-1.46,7.17-5.92,10.85-13.29,10.86C157,150.15,143.16,150.13,129.35,150.13Z" style="fill:#020202"/></svg>
                        <div class="flex align-center">
                            <p class="bblack no-margin fs13"><span class="bold">Authorization breaks</span> : {{ $userstats['authbreaks'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection