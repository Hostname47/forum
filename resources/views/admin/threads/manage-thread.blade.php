@extends('layouts.admin')

@section('title', 'Admin - Manage Thread')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.resource.management', 'subpage'=>'admin.user.thread.manage'])
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/threads/thread.js') }}" defer></script>
    <script src="{{ asset('js/admin/reports/report.js') }}" defer></script>
    <script src="{{ asset('js/admin/user.js') }}" defer></script>
    <script src="{{ asset('js/post.js') }}" defer></script>
@endpush

@section('content')
    @include('partials.admin.thread.thread-render')
    <style>
        #thread-media-viewer {
            z-index: 55556;
        }
    </style>
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="size20 mr8" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,17.11h97.27c11.82,0,15.64,3.73,15.64,15.34q0,75.07,0,150.16c0,11.39-3.78,15.13-15.22,15.13-2.64,0-5.3.12-7.93-.06a11.11,11.11,0,0,1-10.53-9.38c-.81-5.69,2-11,7.45-12.38,3.28-.84,3.52-2.36,3.51-5.06-.07-27.15-.11-54.29,0-81.43,0-3.68-1-4.69-4.68-4.68q-85.63.16-171.29,0c-3.32,0-4.52.68-4.5,4.33q.26,41,0,81.95c0,3.72,1.3,4.53,4.56,4.25a45.59,45.59,0,0,1,7.39.06,11.06,11.06,0,0,1,10.58,11c0,5.62-4.18,10.89-9.91,11.17-8.43.4-16.92.36-25.36,0-5.16-.23-8.82-4.31-9.68-9.66a33,33,0,0,1-.24-5.27q0-75.08,0-150.16c0-11.61,3.81-15.34,15.63-15.34Zm22.49,45.22c16.56,0,33.13,0,49.7,0,5.79,0,13.59,2,16.83-.89,3.67-3.31.59-11.25,1.19-17.13.4-3.92-1.21-4.54-4.73-4.51-19.21.17-38.42.08-57.63.08-22.73,0-45.47.11-68.21-.1-4,0-5.27,1-4.92,5a75.62,75.62,0,0,1,0,12.68c-.32,3.89.78,5,4.85,5C110.54,62.21,131.51,62.33,152.49,62.33ZM62.3,51.13c0-11.26,0-11.26-11.45-11.26h-.53c-10.47,0-10.47,0-10.47,10.71,0,11.75,0,11.75,11.49,11.75C62.3,62.33,62.3,62.33,62.3,51.13ZM102,118.66c25.79.3,18.21-2.79,36.49,15.23,18.05,17.8,35.89,35.83,53.8,53.79,7.34,7.35,7.3,12.82-.13,20.26q-14.94,15-29.91,29.87c-6.86,6.81-12.62,6.78-19.5-.09-21.3-21.28-42.53-42.64-63.92-63.84a16.11,16.11,0,0,1-5.24-12.62c.23-9.86,0-19.73.09-29.59.07-8.71,4.24-12.85,13-13C91.81,118.59,96.92,118.66,102,118.66ZM96.16,151c.74,2.85-1.53,6.66,1.41,9.6,17.66,17.71,35.39,35.36,53,53.11,1.69,1.69,2.59,1.48,4.12-.12,4.12-4.34,8.24-8.72,12.73-12.67,2.95-2.59,2.36-4-.16-6.49-15.68-15.46-31.4-30.89-46.63-46.79-4.56-4.76-9.1-6.73-15.59-6.35C96.18,141.8,96.16,141.41,96.16,151Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Manage Thread') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Manage thread') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box" style="margin-bottom: 30px">
        @include('partials.admin.user.remove-warning-from-user')
        @include('partials.admin.user.remove-strike-from-user')

        @if(Session::has('message'))
            <div class="green-message-container mb8">
                <p class="green-message">{{ Session::get('message') }}</p>
            </div>
        @endif
        <!-- search for a thread to manage -->
        @if(is_null($thread))
        <div class="flex flex-column align-center" style="margin-top: 30px">
            <label for="" class="my8 lblack">Search for a thread to manage and click enter button. (Search by ID or subject)</label>
            <div class="relative search-box" style="min-width: 600px; width: 600px;">
                <svg class="sfui-icon size14" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                <input type="text" name="k" value="{{ request()->get('k') }}" class="search-input-text-style search-for-threads-input full-width" autocomplete="off" placeholder="search for threads (ID or subject match)">
                <div class="search-result-container scrolly none">
                    <style>
                        .threadmanage-link {
                            padding: 0 6px;
                        }
                        .threadmanage-link:hover {
                            background-color: #f2f2f2;
                            border-radius: 6px;
                        }
                    </style>
                    <a href="{{ route('admin.thread.manage') }}" class="lblack no-underline threadmanage-link search-thread-record search-thread-record-skeleton none flex">
                        <div class="flex height-max-content my4">
                            <div class="flex align-center mr8 height-max-content my8" style="min-width: 80px">
                                <span class="bold">id</span>
                                :
                                <span class="thread-search-record-id ml4" style="">7558</span>
                            </div>
                            <div>
                                <p class="bold blue thread-seearch-record-subject my8">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus rerum.</p>
                                <p class="fs13 my4 thread-seearch-record-content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam natus nesciunt explicabo totam maxime enim, minus culpa officia excepturi, nobis deserunt fugit recusandae odit corrupti dignissimos adipisci? Harum, sequi rem.</p>
                            </div>
                        </div>
                    </a>
                    <div class="result-box">

                    </div>

                    <div class="flex search-result-faded none">
                        <div class="relative br3 mr8 hidden-overflow" style="width: 44px; height: 15px;">
                            <div class="fade-loading"></div>
                        </div>
                        <div class="full-width">
                            <div class="relative br3 hidden-overflow mb4" style="height: 15px; width: 160px;">
                                <div class="fade-loading"></div>
                            </div>
                            <div class="relative br3 hidden-overflow full-width" style="height: 30px;">
                                <div class="fade-loading"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex align-center justify-center pointer none" id="admin-thread-search-fetch-more" style="padding: 6px;">
                        <span class="blue bold fs13 mr4">fetch more</span>
                        <div class="spinner size14 opacity0">
                            <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path fill="#2ca0ff" d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                        </div>
                    </div>
                    <div class="full-center search-no-results none">
                        <p class="bold">no results for your search query</p>
                    </div>
                </div>
            </div>
        </div>
        @else
            <input type="hidden" id="thread-id" autocomplete="off" value="{{ $thread->id }}">
            <h2 class="no-margin mb4 forum-color fs15">Thread to manage :</h2>
            <!-- preview thread -->
            <div class="section-style" style="padding: 10px">
                <div>
                    <!-- thread owner -->
                    <div class="flex">
                        <img src="{{ $threadowner->sizedavatar(100, '-h') }}" class="rounded size40" alt="">
                        <div class="ml8">
                            <div class="flex align-center">
                                <a href="{{ $threadowner->profilelink }}" class="bold blue fs13 no-underline">{{ $threadowner->fullname }}</a>
                            </div>
                            <p class="lblack fs12 no-margin">{{ $threadowner->username }}</p>
                        </div>
                    </div>
                    <!-- thread forum - category -->
                    <div class="flex align-center full-width my8">
                        <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            {!! $thread->category->forum->icon !!}
                        </svg>
                        <div class="flex align-center fs11">
                            <div class="flex align-center">
                                <span>Forum :</span>
                                <a href="{{ route('forum.all.threads', ['forum'=>$thread->category->forum->slug]) }}" class="black-link path-blue-when-hover">{{ __($thread->category->forum->forum) }}</a>
                            </div>
                            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                            <div>
                                <span>Category :</span>
                                <a href="{{ $thread->category->link }}" class="black-link path-blue-when-hover">{{ __($thread->category->category) }}</a>
                            </div>
                        </div>                        
                    </div>
                    <div class="mt8">
                        <div class="flex align-center">
                            <div class="flex align-center">
                                <svg class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M143.07,255.58H115.63c-1.47-1.93-3.77-1.5-5.71-1.8A115.72,115.72,0,0,1,68.3,239c-34.6-20.48-56-50.43-61.72-90.34-6.69-47,8.7-86.63,45.66-116.2C89.37,2.76,131.66-3.41,176.08,13.73c38.41,14.82,63.1,43.15,75,82.64,2,6.63,2,13.66,4.7,20.07v28.42c-1.92.89-1.35,2.86-1.55,4.26A110.34,110.34,0,0,1,247,175.93q-23.64,57.1-82.86,74.95C157.2,253,149.88,253.09,143.07,255.58ZM130.61,32.19c-53.67-.25-97.8,43.5-98.28,97.44-.48,53.76,43.66,98.25,97.72,98.5,53.67.26,97.8-43.49,98.28-97.44C228.81,76.94,184.67,32.45,130.61,32.19Z"/><path d="M157.75,130.06a27.42,27.42,0,1,1-27.52-27.31A27.63,27.63,0,0,1,157.75,130.06Z"/></svg>
                                <p class="no-margin lblack fs13 bold">Thread status :</p>
                            </div>
                            @php 
                                $scolor = 'green';
                                if(in_array($threadstatus, ['closed','deleted-by-owner','deleted-by-an-admin',
                                    'closed-and-deleted-by-owner','closed-and-deleted-by-an-admin'])) 
                                    $scolor = 'red';
                            @endphp
                            <span class="bold fs13 {{ $scolor }} ml4">{{ $thread->status->status }}</span>
                        </div>
                        <div class="flex mt4">
                            <span class="bold fs13 gray mr4 no-wrap" style="margin-top: 3px">subject :</span>
                            <a href="{{ $thread->link }}" class="blue no-underline bold mt2">
                                <span class="fs14">{!! $thread->mediumslice !!}</span>
                            </a>
                        </div>
                        <div class="flex mt8">
                            <span class="bold fs13 gray mr4">content :</span>
                            <div class="mb4 expand-box">
                                <span class="thread-title-text html-entities-decode expandable-text block full-width">{{ $thread->mediumcontentslice }}</span>
                                @if($thread->content != $thread->mediumcontentslice)
                                <input type="hidden" class="expand-slice-text" value="{{ $thread->mediumcontentslice }}">
                                <input type="hidden" class="expand-whole-text" value="{{ $thread->content }}">
                                <input type="hidden" class="expand-text-state" value="0">
                                <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                                <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                                <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex align-center" style="margin: 8px 0">
                <h2 class="no-margin forum-color fs15">Thread management :</h2>
                <div class="button-small-size fs11 ml8 render-thread" style="padding: 3px 8px">
                    <div class="relative size14 full-center mr4">
                        <svg class="size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px; margin-top: 2px"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                        <svg class="spinner size12 absolute none" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="fs11 lblack bold">render thread</span>
                    <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                </div>
                <a href="{{ route('thread.edit', ['user'=>$threadowner->username, 'thread'=>$thread->id, 'forceedit'=>1]) }}" class="flex align-center no-underline ml8">
                    <svg class="mr4 size12" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.51,334.33l28.28-28.27a7.1,7.1,0,0,1,12.11,5V439.58A42.43,42.43,0,0,1,355.48,482H44.42A42.43,42.43,0,0,1,2,439.58V128.52A42.43,42.43,0,0,1,44.42,86.1H286.11a7.12,7.12,0,0,1,5,12.11l-28.28,28.28a7,7,0,0,1-5,2H44.42V439.58H355.48V339.28A7,7,0,0,1,357.51,334.33ZM495.9,156,263.84,388.06,184,396.9a36.5,36.5,0,0,1-40.29-40.3l8.83-79.88L384.55,44.66a51.58,51.58,0,0,1,73.09,0l38.17,38.17A51.76,51.76,0,0,1,495.9,156Zm-87.31,27.31L357.25,132,193.06,296.25,186.6,354l57.71-6.45Zm57.26-70.43L427.68,74.7a9.23,9.23,0,0,0-13.08,0L387.29,102l51.35,51.34,27.3-27.3A9.41,9.41,0,0,0,465.85,112.88Z"></path></svg>
                    <span class="fs11 blue bold">force edit</span>
                </a>
                <div class="fs10 mx8 gray" style="margin-top: -1px">•</div>
                <a href="{{ route('admin.user.manage') . '?uid=' . $thread->user_id }}" class="flex align-center no-underline">
                    <svg class="mr4 size12" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                    <span class="fs11 blue bold">manage thread owner</span>
                </a>
            </div>
            <div class="flex">
                <div class="half-width mr4">
                    <!-- open/close thread section -->
                    @if(in_array($threadstatus, ['live','closed','closed-and-deleted-by-owner','closed-and-deleted-by-an-admin']))
                    <div class="section-style white-background mb8">
                        @if($threadstatus == 'live')
                        <!-- close thread -->
                        <div class="thread-close-box">
                            <div class="flex align-center mb8">
                                <svg class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"></path></svg>
                                <h2 class="no-margin forum-color fs14">Close thread</h2>
                            </div>
                            <span class="fs13 lblack block mb8">If the thread does not respect the rules and guidelines, but it's okey to keep it available, you can close it; By closing the thread, it will no longer accept replies from community.</span>
                            <div class="section-style flex mb4">
                                <svg class="size13 mr8" style="min-width: 13px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="lblack fs12 no-margin lh15" style="margin-top: -1px">Don't forget to warn or strike the resource owner If the thread does not respect guidelines.</p>
                            </div>
                            <div>
                                <p class="no-margin fs13 lblack mr4 mb4 bold">reason for close :</p>
                                <div class="relative custom-dropdown-box">
                                    <input type="hidden" class="custom-dropdown-value closereason" autocomplete="off" value="{{ $reportwarningreasons->first()->id }}">
                                    <div class="typical-button button-with-suboptions custom-dropdown-selector" style="width: max-content; max-width: 380px;">
                                        <span class="custom-dropdown-selected-option-text">{{ $closereasons->first()->name }}</span>
                                        <svg class="size6 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M28.61,13.35l-11,9.39a4,4,0,0,1-5.18,0l-11-9.31A4,4,0,1,1,6.59,7.32L15,14.45l8.37-7.18a4,4,0,0,1,5.2,6.08Z"/></svg>
                                    </div>
                                    <div class="custom-dropdown-options-container suboptions-container typical-suboptions-container y-auto-overflow mb4" style="max-width: 380px; max-height: 270px;">
                                        @foreach($closereasons as $reason)
                                        <div class="typical-suboption custom-drop-down-option mb4">
                                            <span class="custom-dropdown-option-text block bold lblack fs13">{{ $reason->name }}</span>
                                            <span class="fs12">{{ $reason->reason }}</span>
                                            <input type="hidden" class="custom-dropdown-option-value" value="{{ $reason->id }}" autocomplete="off">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @php $canclose = auth()->user()->can('close_thread', [\App\Models\Thread::class]); @endphp

                                @if(!$canclose)
                                <div class="section-style flex align-center my8">
                                    <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                    <p class="fs12 bold lblack no-margin">You cannot close threads because you don't have permission to do so</p>
                                </div>
                                @endif

                                @if($canclose)
                                <div id="close-thread-button" class="typical-button-style flex align-center width-max-content mt8">
                                    <div class="relative size14 mr4">
                                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"></path></svg>
                                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="bold unselectable">Close thread</span>
                                    <input type="hidden" class="thread-id" autocomplete="off" value="{{ $thread->id }}">
                                    <input type="hidden" class="success-message" value="Thread has been closed successfully" autocomplete="off">
                                </div>
                                @else
                                <div class="typical-button-style disabled-typical-button-style flex align-center width-max-content mt8">
                                    <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"></path></svg>
                                    <span class="bold unselectable">Close thread</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- open closed thread -->
                        @else
                        <div class="thread-open-box">
                            <div class="flex align-center mb8">
                                <svg class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M143.07,255.58H115.63c-1.47-1.93-3.77-1.5-5.71-1.8A115.72,115.72,0,0,1,68.3,239c-34.6-20.48-56-50.43-61.72-90.34-6.69-47,8.7-86.63,45.66-116.2C89.37,2.76,131.66-3.41,176.08,13.73c38.41,14.82,63.1,43.15,75,82.64,2,6.63,2,13.66,4.7,20.07v28.42c-1.92.89-1.35,2.86-1.55,4.26A110.34,110.34,0,0,1,247,175.93q-23.64,57.1-82.86,74.95C157.2,253,149.88,253.09,143.07,255.58ZM130.61,32.19c-53.67-.25-97.8,43.5-98.28,97.44-.48,53.76,43.66,98.25,97.72,98.5,53.67.26,97.8-43.49,98.28-97.44C228.81,76.94,184.67,32.45,130.61,32.19Z"/><path d="M157.75,130.06a27.42,27.42,0,1,1-27.52-27.31A27.63,27.63,0,0,1,157.75,130.06Z"/></svg>
                                <h2 class="no-margin forum-color fs14">Open thread</h2>
                            </div>
                            <span class="fs13 lblack block mb8">If the thread changed or improved by the owner and it is currently acceptable, you can open it again.</span>
                            <div class="flex align-center fs13 lblack mb8">
                                <span class="mr4 bold no-wrap">closed by :</span>
                                <a href="{{ route('admin.user.manage', ['uid'=>$thread->threadclose->closedby->username]) }}" class="bold blue fs13 no-underline">{{ $thread->threadclose->closedby->username }}</a>
                            </div>
                            <div class="flex fs13 lblack mb8">
                                <span class="mr4 bold no-wrap">close reason :</span>
                                <div>
                                    <span class="bold block">{{ $thread->threadclose->reason->name }}</span>
                                    <span>{{ $thread->threadclose->reason->reason }}</span>
                                </div>
                            </div>
                            <div class="fs13 lblack section-style" style="padding: 10px">
                                <span class="block bold lblack fs13 mb4">clean warnings and/or strikes after opening</span>
                                <span>If you want to remove warnings and strikes the owner of this thread got, you have to do it manually in section at the right because warning and striking owner is done separately.</span>
                            </div>

                            @php $canopen = auth()->user()->can('open_thread', [\App\Models\Thread::class]); @endphp
                            @if(!$canopen)
                            <div class="section-style flex align-center my8">
                                <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="fs12 bold lblack no-margin">You cannot open closed threads because you don't have permission to do so</p>
                            </div>
                            @endif
                            @if($canopen)
                            <div id="open-thread-button" class="typical-button-style flex align-center width-max-content mt8">
                                <div class="relative size14 mr4">
                                    <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M143.07,255.58H115.63c-1.47-1.93-3.77-1.5-5.71-1.8A115.72,115.72,0,0,1,68.3,239c-34.6-20.48-56-50.43-61.72-90.34-6.69-47,8.7-86.63,45.66-116.2C89.37,2.76,131.66-3.41,176.08,13.73c38.41,14.82,63.1,43.15,75,82.64,2,6.63,2,13.66,4.7,20.07v28.42c-1.92.89-1.35,2.86-1.55,4.26A110.34,110.34,0,0,1,247,175.93q-23.64,57.1-82.86,74.95C157.2,253,149.88,253.09,143.07,255.58ZM130.61,32.19c-53.67-.25-97.8,43.5-98.28,97.44-.48,53.76,43.66,98.25,97.72,98.5,53.67.26,97.8-43.49,98.28-97.44C228.81,76.94,184.67,32.45,130.61,32.19Z"></path><path d="M157.75,130.06a27.42,27.42,0,1,1-27.52-27.31A27.63,27.63,0,0,1,157.75,130.06Z"></path></svg>
                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold unselectable">Open thread</span>
                                <input type="hidden" class="thread-id" autocomplete="off" value="{{ $thread->id }}">
                                <input type="hidden" class="success-message" value="Thread has been opened successfully" autocomplete="off">
                            </div>
                            @else
                            <div class="typical-button-style disabled-typical-button-style flex align-center width-max-content mt8">
                                <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M143.07,255.58H115.63c-1.47-1.93-3.77-1.5-5.71-1.8A115.72,115.72,0,0,1,68.3,239c-34.6-20.48-56-50.43-61.72-90.34-6.69-47,8.7-86.63,45.66-116.2C89.37,2.76,131.66-3.41,176.08,13.73c38.41,14.82,63.1,43.15,75,82.64,2,6.63,2,13.66,4.7,20.07v28.42c-1.92.89-1.35,2.86-1.55,4.26A110.34,110.34,0,0,1,247,175.93q-23.64,57.1-82.86,74.95C157.2,253,149.88,253.09,143.07,255.58ZM130.61,32.19c-53.67-.25-97.8,43.5-98.28,97.44-.48,53.76,43.66,98.25,97.72,98.5,53.67.26,97.8-43.49,98.28-97.44C228.81,76.94,184.67,32.45,130.61,32.19Z"></path><path d="M157.75,130.06a27.42,27.42,0,1,1-27.52-27.31A27.63,27.63,0,0,1,157.75,130.06Z"></path></svg>
                                <span class="bold unselectable">Open thread</span>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- delete/restore -->
                    @if(is_null($thread->deleted_at))
                    <div class="red-section-style white-background delete-thread-box">
                        <div class="flex align-center mb8">
                            <svg class="size12 mr4" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <h2 class="no-margin red fs14">Delete thread</h2>
                        </div>
                        <span class="block fs12 lblack mb4 lh15">If you find that this thread does not respect any guidelines and hurt the community, you can delete it by moving it to user archives. Notice that <strong>the thread will not be deleted permanently</strong>; It will be archived</span>
                        <span class="block fs12 lblack mb4 lh15">If you want to delete it permanently consider the next section</span>
                        <div class="section-style mb8" style="padding: 8px;">
                            <div class="flex">
                                <svg class="size14 mr8" style="min-width: 14px; margin-top: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <div>
                                    <span class="block fs12 lblack lh15">Choose whether you want to <strong>warn or strike the resource owner</strong> after deleting the thread as a way to show the user the deleted thread in warning/strikes page.</span>
                                    <div class="flex align-center mt4">
                                        <div class="flex align-center" style="margin-right: 14px">
                                            <input type="radio" checked="checked" name="ws-owner-after-deleting-thread" autocomplete="off" id="warn-owner-after-deleting-thread" class="ws-owner-after-deleting-thread no-margin mr4" value="warn">
                                            <label for="warn-owner-after-deleting-thread" class="fs12 bold lblack">warn owner after delete</label>
                                        </div>
                                        <div class="flex align-center">
                                            <input type="radio" name="ws-owner-after-deleting-thread" autocomplete="off" id="strike-owner-after-deleting-thread" class="ws-owner-after-deleting-thread no-margin mr4" value="strike">
                                            <label for="strike-owner-after-deleting-thread" class="fs12 bold lblack">strike owner after delete</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $candeletethread = auth()->user()->can('delete_thread', [\App\Models\Thread::class]); @endphp
                        @if(!$candeletethread)
                        <div class="section-style flex align-center my8">
                            <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="fs12 bold lblack no-margin">You cannot delete threads because you don't have permission to do so</p>
                        </div>
                        @endif
                        @if($candeletethread)
                        <div class="red-button-style flex align-center width-max-content delete-thread-button">
                            <div class="relative size14 mr4">
                                <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold">Delete thread</span>
                            <input type="hidden" class="thread-id" autocomplete="off" value="{{ $thread->id }}">
                            <input type="hidden" class="success-message" value="Thread has been deleted successfully">
                        </div>
                        @else
                        <div class="red-button-style disabled-red-button-style flex align-center width-max-content">
                            <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <span class="bold">Delete thread</span>
                        </div>
                        @endif
                    </div>
                    @else
                        <!-- deleted_at not null => thread deleted => means either the owner delete it or it is deleted by an admin -->
                        <!-- restore thread -->
                        @if(in_array($threadstatus, ['deleted-by-an-admin', 'closed-and-deleted-by-an-admin']))
                        <div class="section-style white-background lblack delete-thread-box">
                            <div class="flex align-center mb8">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                <h3 class="no-margin lblack fs14">Restore thread</h3>
                            </div>
                            <p class="no-margin fs13 lblack lh15">This thread was <strong class="bold">deleted by an admin</strong> due to guidelines violation.</p>
                            <span class="fs13 lblack lh15 mt4 block">If you think that this thread is fine to be restored, you can bring it back to public. Strikes and/or warnings the owner got for this thread will not be deleted; You have to do it manually in <strong>warnings & strikes</strong> section.</span>
                            <div class="section-style flex mt4" style="padding: 8px;">
                                <svg class="size12 mr8 mt2" style="min-width: 12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <span class="fs12 lblack">If the thread was already closed, it will not be opened after restoration. You have to do it manually afterwards in case you want to open it as well.</span>
                            </div>
                            @php $canrestorethread = auth()->user()->can('restore_thread', [\App\Models\Thread::class]); @endphp
                            @if(!$canrestorethread)
                            <div class="section-style flex align-center my8">
                                <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="fs12 bold lblack no-margin">You cannot restore deleted threads because you don't have permission to do so</p>
                            </div>
                            @endif
                            @if($canrestorethread)
                            <div id="restore-deleted-thread-button" class="typical-button-style flex align-center width-max-content mt8">
                                <div class="relative size14 mr4">
                                    <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold unselectable">Restore thread</span>
                                <input type="hidden" class="thread-id" autocomplete="off" value="{{ $thread->id }}">
                                <input type="hidden" class="success-message" value="Thread has been restored successfully" autocomplete="off">
                            </div>
                            @else
                            <div class="typical-button-style disabled-typical-button-style flex align-center width-max-content mt8">
                                <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                <span class="bold unselectable">Restore thread</span>
                            </div>
                            @endif
                        </div>
                        <!-- thread deleted by owner - force admin delete -->
                        @else
                        <div class="section-style white-background lblack delete-thread-box">
                            <div class="flex align-center mb8">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                <h3 class="no-margin fs14">Thread deleted</h3>
                            </div>
                            <p class="no-margin fs13 mb4 lh15">This thread <strong class="bold">had been deleted by its owner</strong> normally.</p>

                            <p class="no-margin fs13 lh15">If this thread does not respect rules and guidelines, you can force admin delete by changing the status from [deleted by owner] to [deleted by an admin] in order to <strong>prevent the owner from restoring it</strong> again.</p>
                            <div class="toggle-box mt8">
                                <div class="flex align-center pointer toggle-container-button">
                                    <span class="block bold">Force admin delete</span>
                                    <svg class="toggle-arrow size7 ml4" style="margin-top: 1px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                                </div>
                                <div class="toggle-container">
                                    <div class="mt8">
                                        <span class="block fs12 lblack lh15">Choose whether you want to <strong>warn or strike the owner</strong> after deleting the thread.</span>
                                        <div class="flex align-center mt4">
                                            <div class="flex align-center" style="margin-right: 14px">
                                                <input type="radio" checked="checked" name="ws-owner-after-deleting-thread" autocomplete="off" id="warn-owner-after-deleting-thread" class="ws-owner-after-deleting-thread no-margin mr4" value="warn">
                                                <label for="warn-owner-after-deleting-thread" class="fs12 bold lblack">warn owner after delete</label>
                                            </div>
                                            <div class="flex align-center">
                                                <input type="radio" name="ws-owner-after-deleting-thread" autocomplete="off" id="strike-owner-after-deleting-thread" class="ws-owner-after-deleting-thread no-margin mr4" value="strike">
                                                <label for="strike-owner-after-deleting-thread" class="fs12 bold lblack">strike owner after delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    @php $candeletethread = auth()->user()->can('delete_thread', [\App\Models\Thread::class]); @endphp
                                    @if(!$candeletethread)
                                    <div class="section-style flex align-center my8">
                                        <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                        <p class="fs12 bold lblack no-margin">You cannot delete threads because you don't have permission to do so</p>
                                    </div>
                                    @endif
                                    @if($candeletethread)
                                    <div class="red-button-style flex width-max-content delete-thread-button mt8">
                                        <div class="relative size14 mr4 mt2">
                                            <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="bold">Force admin delete</span>
                                            <span class="block fs11">change status to deleted by an admin</span>
                                        </div>
                                        <input type="hidden" class="thread-id" autocomplete="off" value="{{ $thread->id }}">
                                        <input type="hidden" class="success-message" value="Thread has been force deleted successfully">
                                    </div>
                                    @else
                                    <div class="red-button-style disabled-red-button-style flex width-max-content mt8">
                                        <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                        <div>
                                            <span class="bold">Force admin delete</span>
                                            <span class="block fs11">change status to deleted by an admin</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif

                    <!-- permanent delete -->
                    <div class="red-section-style toggle-box white-background mt8">
                        <div class="flex align-center toggle-container-button pointer">
                            <svg class="size12 mr4" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"/></svg>
                            <h2 class="no-margin red fs14">Delete thread permanently</h2>
                            <svg class="toggle-arrow size7 ml4" style="margin-top: 1px;" fill="#E43030" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                        </div>
                        <div class="toggle-container">
                            <div>
                                <div class="flex" style="padding: 8px">
                                    <svg class="size14 mr8" style="min-width: 14px; margin-top: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                    <div>
                                        <span class="block fs12 lblack mb4 lh15">If you find that this thread should be deleted permanently click on delete permanently button below. <strong>Once the thread is deleted all related resources including reports, replies, likes ..etc will get deleted as well</strong>.</span>
                                        <span class="block fs12 lblack mb4 lh15">After deleting the thread, you may want to warn and/or strike the owner in user management for guidelines violation.</span>
                                        <span class="block fs12 lblack lh15">If the thread has already warning or strikes they will still attached to the user, but the resource for them will mark as deleted in warning page.</span>
                                    </div>
                                </div>
                                @php $can_permanently_delete_thread = auth()->user()->can('delete_thread_permanently', [\App\Models\Thread::class]); @endphp
                                @if(!$can_permanently_delete_thread)
                                <div class="section-style flex my8">
                                    <svg class="size14 mr8 mt2" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                    <p class="fs12 bold lblack no-margin">You cannot delete threads permanently because you don't have permission to do so</p>
                                </div>
                                @endif
                                @if($can_permanently_delete_thread)
                                <div id="permanent-delete-thread-button" class="red-button-style flex align-center width-max-content">
                                    <div class="relative size14 mr4">
                                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"/></svg>
                                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="bold">Delete thread permanently</span>
                                    <input type="hidden" class="thread-id" autocomplete="off" value="{{ $thread->id }}">
                                    <input type="hidden" class="success-message" value="Thread has been deleted permanently with success">
                                </div>
                                @else
                                <div class="red-button-style disabled-red-button-style flex align-center width-max-content">
                                    <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"/></svg>
                                    <span class="bold">Delete thread permanently</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="half-width ml4">
                    <!-- reports section -->
                    @php $can_change_reports_review_state = auth()->user()->can('patch_resource_reports_review', [\App\Models\User::class]); false; @endphp
                    <div class="section-style white-background">
                        <div class="flex align-center mb4">
                            <div class="flex align-center">
                                <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"></path></svg>
                                <h3 class="fs14 lblack no-margin mr8 flex align-center">
                                    Reports
                                    @if($reportscount)
                                    <span class="flex align-center">
                                        <span class="fs8 mx4 mt4 gray unselectable">•</span>
                                        ({{ $reportscount }}) 
                                    </span>
                                    @endif
                                </h3>
                            </div>
                            @if($reportscount)
                            <div class="move-to-right review-reports-box">
                                <input type="hidden" class="report-id" value="{{ $reports->first()->id }}" autocomplete="off">
                                <!-- unreview button -->
                                <div class="flex align-center unreview-reports-section @if(!$reports_reviewed) none @endif">
                                    <div class="flex align-center">
                                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                                        <p class="bold no-margin fs11" style="color: #44a644">reports reviewed</p>
                                        @if($can_change_reports_review_state)
                                        <div class="flex align-center pointer ml8 change-resource-reports-review-status">
                                            <div class="relative size12 mr4">
                                                <svg class="size13 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"></path></svg>
                                                <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                </svg>
                                            </div>
                                            <span class="fs11 bold" style="margin-top: -1px">unreview</span>
                                            <input type="hidden" class="action-type" value="unreview" autocomplete="off">
                                            <input type="hidden" class="success-message" value="Resource reports unreviewed" autocomplete="off">
                                        </div>
                                        @else
                                        <div class="flex align-center cursor-not-allowed ml8">
                                            <svg class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"></path></svg>
                                            <span class="fs11 bold unselectable" style="margin-top: -1px">unreview</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- review button -->
                                @if($can_change_reports_review_state)
                                <div class="button-small-size change-resource-reports-review-status review-reports-section @if($reports_reviewed) none @endif">
                                    <div class="relative size12 mr4">
                                        <svg class="size12 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"></path></svg>
                                        <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="fs11 bold">mark reports as reviewed</span>
                                    <input type="hidden" class="action-type" value="review" autocomplete="off">
                                    <input type="hidden" class="success-message" value="Resource reports marked as reviewed" autocomplete="off">
                                </div>
                                @else
                                <div class="button-small-size cursor-not-allowed @if($reports_reviewed) none @endif">
                                    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"></path></svg>
                                    <span class="fs11 bold">mark reports as reviewed</span>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="ws-reporters-wrapper">
                            <input type="hidden" class="all-reporters-ids" value="{{ $all_reporters_ids }}" autocomplete="off">
                            <input type="hidden" class="all-reports-ids" value="{{ $all_reports_ids }}" autocomplete="off">
                            @if(!$can_change_reports_review_state)
                            <div class="section-style flex my4" style="padding: 6px 8px">
                                <svg class="size12 mr8 mt2" style="min-width: 12px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="fs11 lblack no-margin">You cannot mark resource reports as reviewed or unreviewed because you don't have permission to do so</p>
                            </div>
                            @endif
                            <span class="block fs12 lblack mb4 lh15">The following section includes all reportings the current resource got. If you find that one or multiple reportings are random or inconvenient, you can warn or strike the reporters</span>
                            <div id="resource-reports-box" class="section-style y-auto-overflow" style="padding: 10px; max-height: 212px;">
                                @if($reportscount)
                                    <div id="resource-reports-records-box">
                                        <div class="flex align-center custom-checkbox-button select-all-reporters pointer width-max-content move-to-right" style="margin-bottom: 10px;">
                                            <span class="fs11 bold lblack">select all ({{$reportscount}} reporters)</span>
                                            <div class="ml4">
                                                <div class="custom-checkbox size10" style="border-radius: 2px">
                                                    <svg class="size7 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                                                    <input type="hidden" class="checkbox-status" autocomplete="off" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        @foreach($reports as $report)
                                        <div class="flex resource-report-record" style="margin-bottom: 10px">
                                            <div class="flex height-max-content mt2" style="min-width: 175px; max-width: 175px;">
                                                <div class="custom-checkbox-button select-reporter-to-ws mr8" style="margin-top: 5px;">
                                                    <div class="custom-checkbox size14" style="border-radius: 2px">
                                                        <svg class="size10 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                                                        <input type="hidden" class="checkbox-status" autocomplete="off" value="0">
                                                        <input type="hidden" class="reporter-id" value="{{ $report->reporteruser->id }}" autocomplete="off">
                                                        <input type="hidden" class="report-id" value="{{ $report->id }}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <a href="{{ route('admin.user.manage') . '?uid=' . $report->reporteruser->id }}">
                                                    <img src="{{ $report->reporteruser->sizedavatar(36, '-l') }}" class="block size28 rounded mr4" alt="">
                                                </a>
                                                <div>
                                                    <p class="no-margin fs12 bold lblack">{{ $report->reporteruser->username }}</p>
                                                    <p class="no-margin fs11 gray">reported {{ $report->at_hummans }}</p>
                                                    @if($report->reporter_already_warned_about_this_report())
                                                    <p class="no-margin fs11 red reporter-already-warned">already <strong>warned</strong></p>
                                                    @endif
                                                    @if($report->reporter_already_striked_about_this_report())
                                                    <p class="no-margin fs11 dark-red reporter-already-striked">already <strong>striked</strong></p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="ml8" style="flex: 1;">
                                                <p class="no-margin bold fs12">{{ $report->type }}</p>
                                                @if($report->type=='moderator-intervention')
                                                <p class="fs12 no-margin lblack">{{ $report->body }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- fetch more -->
                                    @if($reportshasmore)
                                    <div id="fetch-more-resource-reports-data" class="flex justify-center">
                                        <input type="hidden" class="report-id" value="{{ $reports->first()->id }}" autocomplete="off">
                                        <svg class="spinner size20 black" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    @endif
                                    <!-- skeleton to clone -->
                                    <div class="flex resource-report-record resource-report-record-skeleton none" style="margin-bottom: 10px">
                                        <div class="flex height-max-content mt2" style="min-width: 175px; max-width: 175px;">
                                            <div class="custom-checkbox-button select-reporter-to-ws mr8" style="margin-top: 5px;">
                                                <div class="custom-checkbox size14" style="border-radius: 2px">
                                                    <svg class="size10 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                                                    <input type="hidden" class="checkbox-status" autocomplete="off" value="0">
                                                    <input type="hidden" class="reporter-id" value="" autocomplete="off">
                                                    <input type="hidden" class="report-id" value="" autocomplete="off">
                                                </div>
                                            </div>
                                            <a class="reporter-profile-link" href="">
                                                <img src="" class="reporter-avatar block size28 rounded mr4" alt="">
                                            </a>
                                            <div>
                                                <p class="no-margin fs12 bold lblack reporter-username"></p>
                                                <p class="no-margin fs11 gray">reported <span class="reported-at-hummans"></span></p>
                                                <p class="no-margin fs11 red reporter-already-warned none">already <strong>warned</strong></p>
                                                <p class="no-margin fs11 dark-red reporter-already-striked none">already <strong>striked</strong></p>
                                            </div>
                                        </div>
                                        <div class="ml8" style="flex: 1;">
                                            <p class="no-margin bold fs12 report-type"></p>
                                            <p class="fs12 no-margin lblack report-body"></p>
                                        </div>
                                    </div>
                                @else
                                <!-- thread is clean -->
                                <div class="flex align-center ml8">
                                    <p class="no-margin"><span class="bold">0</span> reports</p>
                                    <div class="flex align-center ml8">
                                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                                        <span class="green fs13 bold">clean thread</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="toggle-box" style="margin-top: 12px">
                                <div class="flex align-center mb4 pointer toggle-container-button">
                                    <span class="block lblack bold">Deal with reporters</span>
                                    <svg class="toggle-arrow size7 ml4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                                </div>
                                <div class="toggle-container">
                                    <span class="block fs12 lblack mb4">The following section concerns warning/striking reporters in case of inconvenient reports. you have to <strong>select at least one</strong> reporter</span>
                                    <div class="ws-toggler-box ws-wrapper">
                                        @php $can_warn_group = auth()->user()->can('warn_group_of_users', [\App\Models\User::class]); @endphp
                                        @php $can_strike_group = auth()->user()->can('strike_group_of_users', [\App\Models\User::class]); @endphp
                                        <div>
                                            <p class="fs12 lblack my4">Select whether you want to warn or strike the selected reporters</p>
                                            <div class="flex align-center my8">
                                                <div class="flex align-center" style="margin-right: 14px">
                                                    <input type="radio" @if(!$can_warn_group) disabled="disabled" @endif checked="checked" name="ws-toggler" autocomplete="off" id="warn-reporters-toggler" class="ws-toggler no-margin mr4" value="warn">
                                                    <label for="warn-reporters-toggler" class="fs12 bold">warn reporters</label>
                                                </div>
                                                <div class="flex align-center">
                                                    <input type="radio" @if(!$can_strike_group) disabled="disabled" @endif name="ws-toggler" autocomplete="off" id="strike-reporters-toggler" class="ws-toggler no-margin mr4" value="strike">
                                                    <label for="strike-reporters-toggler" class="fs12 bold">strike reporters</label>
                                                </div>
                                            </div>
                                            @if(!$can_warn_group || !$can_strike_group)
                                            <div class="section-style flex align-center my8">
                                                <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                                @if(!$can_warn_group && !$can_strike_group)
                                                <p class="fs12 bold lblack no-margin">You cannot warn or strike the selected reporters because you don't have permissions to do so</p>
                                                @elseif($can_warn_group && !$can_strike_group)
                                                <p class="fs12 bold lblack no-margin">You can only warn the selected reporters. For strike, you need to have the permission</p>
                                                @else
                                                <p class="fs12 bold lblack no-margin">You can only strike the selected reporters. For warning, you need to have the permission</p>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        <div class="section-style" style="padding: 8px;">
                                            <div class="ws-warning-box">
                                                <div class="flex align-center">
                                                    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                                    <span class="bold lblack fs13" class="mr4">warn reporters</span>
                                                </div>
                                                <p class="no-margin fs13 lblack my8">Select the warning reason you want to send to the selected reporters for the inconvenient reports</p>
                                                <div class="flex align-center my8">
                                                    <span class="lblack fs13 gray bold mr8 no-wrap">warning reason :</span>
                                                    <div class="relative custom-dropdown-box">
                                                        <!-- 
                                                            when a custom option is selected we set the custom dropdown value to the selected value 
                                                            and we also assign strikereason class to the value holder in order to get the reason directly from the
                                                            custom dropdown value
                                                        -->
                                                        <input type="hidden" class="custom-dropdown-value warningreason" autocomplete="off" value="{{ $reportwarningreasons->first()->id }}">
                                                        <div class="typical-button button-with-suboptions custom-dropdown-selector">
                                                            <span class="custom-dropdown-selected-option-text">{{ $reportwarningreasons->first()->name }}</span>
                                                            <svg class="size6 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M28.61,13.35l-11,9.39a4,4,0,0,1-5.18,0l-11-9.31A4,4,0,1,1,6.59,7.32L15,14.45l8.37-7.18a4,4,0,0,1,5.2,6.08Z"/></svg>
                                                        </div>
                                                        <div class="custom-dropdown-options-container suboptions-container typical-suboptions-container y-auto-overflow mb4" style="bottom: 100%; top: auto; width: max-content; max-width: 380px; max-height: 270px;">
                                                            @foreach($reportwarningreasons as $reason)
                                                            <div class="typical-suboption custom-drop-down-option mb4">
                                                                <span class="custom-dropdown-option-text block bold lblack fs13">{{ $reason->name }}</span>
                                                                <span class="fs12">{{ $reason->content }}</span>
                                                                <input type="hidden" class="custom-dropdown-option-value" value="{{ $reason->id }}" autocomplete="off">
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($can_warn_group)
                                                <div id="warn-selected-reporters" class="red-button-style disabled-red-button-style full-center">
                                                    <div class="relative size14 mr4">
                                                        <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="bold fs13 unselectable">warn selected reporters</span>
                                                    <input type="hidden" class="success-message" value="Selected reporters have been warned successfully" autocomplete="off">
                                                </div>
                                                @else
                                                <div class="red-button-style disabled-red-button-style full-center">
                                                    <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                                    <span class="bold fs13 unselectable">warn selected reporters</span>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="ws-striking-box none">
                                                <div class="flex align-center">
                                                    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                                                    <span class="bold lblack fs13" class="mr4">strike reporters</span>
                                                </div>
                                                <p class="no-margin fs13 lblack my8">Select the strike reason you want to send to the selected reporters for the inconvenient reports</p>
                                                <div class="flex align-center my8">
                                                    <span for="reporters-strike-reason" class="lblack fs13 gray bold mr8">strike reason :</span>
                                                    <div class="relative custom-dropdown-box">
                                                        <input type="hidden" class="custom-dropdown-value strikereason" value="{{ $reportstrikereasons->first()->id }}" autocomplete="off">
                                                        <div class="typical-button button-with-suboptions custom-dropdown-selector">
                                                            <span class="custom-dropdown-selected-option-text">{{ $reportstrikereasons->first()->name }}</span>
                                                            <svg class="size6 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M28.61,13.35l-11,9.39a4,4,0,0,1-5.18,0l-11-9.31A4,4,0,1,1,6.59,7.32L15,14.45l8.37-7.18a4,4,0,0,1,5.2,6.08Z"/></svg>
                                                        </div>
                                                        <div class="custom-dropdown-options-container suboptions-container typical-suboptions-container y-auto-overflow mb4" style="bottom: 100%; top: auto; width: max-content; max-width: 380px; max-height: 270px;">
                                                            @foreach($reportstrikereasons as $reason)
                                                            <div class="typical-suboption custom-drop-down-option mb4">
                                                                <span class="custom-dropdown-option-text block bold lblack fs13">{{ $reason->name }}</span>
                                                                <span class="fs12">{{ $reason->content }}</span>
                                                                <input type="hidden" class="custom-dropdown-option-value" value="{{ $reason->id }}" autocomplete="off">
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($can_strike_group)
                                                <div id="strike-selected-reporters" class="red-button-style disabled-red-button-style full-center">
                                                    <div class="relative size14 mr4">
                                                        <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                                                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="bold fs13 unselectable">strike selected reporters</span>
                                                    <input type="hidden" class="success-message" value="Selected reporters have been striked successfully" autocomplete="off">
                                                </div>
                                                @else
                                                <div class="red-button-style disabled-red-button-style full-center">
                                                    <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                                                    <span class="bold fs13 unselectable">strike selected reporters</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- warnings and strikes section -->
                    <div class="section-style white-background mt8">
                        <div class="flex align-center mb4">
                            <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                            <h3 class="fs14 lblack no-margin">Warning & Strikes</h3>
                        </div>
                        <span class="block fs12 lblack mb4 lh15">The following section dedicated to review warnings and strikes that the selected resource had as well as warning/striking resource owner.</span>
                        @if($resourcewarnings->count() OR $resourcestrikes->count())
                        <div class="section-style">
                            @if($resourcewarnings->count())
                                @php $canclearwarning = auth()->user()->can('clear_user_warning', [\App\Models\User::class]); @endphp
                                <div class="mb8">
                                    <div class="flex">
                                        <svg class="size11 mr4 mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                        <div>
                                            <p class="bold fs12 lblack no-margin">Thread owner is already warned for this thread</p>
                                            @if(!$canclearwarning)
                                            <p class="fs11 gray no-margin">you cannot clear user warnings because you don't have permission</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div style="margin-left: 14px">
                                        @foreach($resourcewarnings as $warning)
                                            <div class="flex my8">
                                                <div class="fs10 mr8 mt2 gray">•</div>
                                                <p class="no-margin fs13 warning-name">{{ $warning->reason->name }}</p>
                                                @if($canclearwarning)
                                                <div class="flex align-center pointer open-warning-remove-from-user-dialog height-max-content ml8 mt2">
                                                    <svg class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"></path></svg>
                                                    <span class="fs11 bold">remove</span>
                                                    <input type="hidden" class="warning-id" value="{{ $warning->id }}" autocomplete="off">
                                                </div>
                                                @else
                                                <div class="flex align-center pointer cursor-not-allowed height-max-content ml8 mt2">
                                                    <svg class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"></path></svg>
                                                    <span class="fs11 bold">remove</span>
                                                </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($resourcestrikes->count())
                                @php $canclearstrike = auth()->user()->can('clear_user_strike', [\App\Models\User::class]); @endphp
                                <div>
                                    <div class="flex">
                                        <svg class="size11 mr4 mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M6.19,144.31v-27c1.47-.52,1-1.87,1.11-2.87,1.67-11.65,4.54-23,9.59-33.63,19-40.1,50.14-65.08,94.22-71.63C157.76,2.25,197,17.72,226.2,54.57S261,133,244,176.58c-14.65,37.32-42.45,61.42-81,73-7.16,2.15-14.66,2.45-21.77,4.67H116.12c-.4-1.26-1.52-.94-2.39-1.06a120.16,120.16,0,0,1-29.21-7.6q-56.1-23.31-73.69-81.47C8.85,157.58,8.86,150.64,6.19,144.31ZM37,132.44c.14,16.35,5.15,33.28,15.18,48.78,1.74,2.69,2.59,2.68,4.78.48q61.74-61.9,123.67-123.62c2-2,2.1-2.84-.39-4.47a90.28,90.28,0,0,0-45-15.16C82,35.51,37.57,77.17,37,132.44Zm185.17-3.16c-.1-16.18-5.06-33.13-15.05-48.65-1.78-2.77-2.71-2.93-5.08-.55Q140.52,141.82,78.76,203.36c-2.11,2.1-2.43,3,.37,4.79a91.16,91.16,0,0,0,44.59,15C176.82,226.4,221.47,184.75,222.21,129.28Z" style="fill:#040205"/></svg>
                                        <div>
                                            <p class="bold fs12 lblack no-margin">Thread owner is already striked for this thread</p>
                                            @if(!$canclearstrike)
                                            <p class="fs11 gray no-margin">you cannot clear user strikes because you don't have permission</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div style="margin-left: 14px">
                                        @foreach($resourcestrikes as $strike)
                                            <div class="flex my8">
                                                <div class="fs10 mr8 mt2 gray">•</div>
                                                <p class="no-margin fs13 strike-name">{{ $strike->reason->name }}</p>
                                                @if($canclearstrike)
                                                <div class="flex align-center pointer open-strike-remove-from-user-dialog height-max-content ml8">
                                                    <svg class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"></path></svg>
                                                    <span class="fs11 bold">remove</span>
                                                    <input type="hidden" class="strike-id" value="{{ $strike->id }}" autocomplete="off">
                                                </div>
                                                @else
                                                <div class="flex align-center cursor-not-allowed height-max-content ml8">
                                                    <svg class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"></path></svg>
                                                    <span class="fs11 bold">remove</span>
                                                </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        @else
                        <!-- Thread is clean -->
                        <div class="flex align-center section-style" style="padding: 10px;">
                            <p class="no-margin ml8"><span class="bold">0</span> warnings</p>
                            <p class="no-margin ml8"><span class="bold">0</span> strikes</p>
                            <div class="flex align-center ml8">
                                <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                                <span class="green fs13 bold">clean with no warnings or strikes</span>
                            </div>
                        </div>
                        @endif
                        <!-- warn and strike thread owner -->
                        <div>
                            @php $canwarnuser = auth()->user()->can('warnuser', [\App\Models\Warning::class]); @endphp
                            @php $canstrikeuser = auth()->user()->can('strikeuser', [\App\Models\Strike::class]); @endphp
                            <h3 class="fs14 no-margin mt8 mb4 lblack">warn & strike resource owner</h3>
                            <span class="fs13 lblack">If thread does not repect our rules and guidelines, choose the right reason for warning or striking the owner of this resource.</span>
                            <div class="ws-toggler-box ws-wrapper">
                                <div>
                                    <p class="fs12 lblack my4">Select whether you want to warn or strike the selected reporters</p>
                                    <div class="flex align-center my8">
                                        <div class="flex align-center" style="margin-right: 14px">
                                            <input type="radio" checked="checked" name="thread-owner-ws-toggler" autocomplete="off" id="warn-thread-owner-toggler" class="ws-toggler no-margin mr4" value="warn">
                                            <label for="warn-thread-owner-toggler" class="fs12 bold">warn thread owner</label>
                                        </div>
                                        <div class="flex align-center">
                                            <input type="radio" name="thread-owner-ws-toggler" autocomplete="off" id="strike-thread-owner-toggler" class="ws-toggler no-margin mr4" value="strike">
                                            <label for="strike-thread-owner-toggler" class="fs12 bold">strike thread owner</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="section-style" style="padding: 8px;">
                                    <!-- warning thread owner -->
                                    <div class="ws-warning-box">
                                        <div class="flex align-center">
                                            <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                            <span class="bold lblack fs13" class="mr4">warn thread owner</span>
                                        </div>
                                        <p class="no-margin fs13 lblack my8">Select the reason for warning the thread owner</p>
                                        <div class="flex align-center my8">
                                            <span class="lblack fs13 gray bold mr8 no-wrap">warning reason :</span>
                                            <div class="relative custom-dropdown-box">
                                                <input type="hidden" class="custom-dropdown-value warningreason" autocomplete="off" value="{{ $threadwarningreasons->first()->id }}">
                                                <div class="typical-button button-with-suboptions custom-dropdown-selector">
                                                    <span class="custom-dropdown-selected-option-text">{{ $threadwarningreasons->first()->name }}</span>
                                                    <svg class="size6 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M28.61,13.35l-11,9.39a4,4,0,0,1-5.18,0l-11-9.31A4,4,0,1,1,6.59,7.32L15,14.45l8.37-7.18a4,4,0,0,1,5.2,6.08Z"/></svg>
                                                </div>
                                                <div class="custom-dropdown-options-container suboptions-container typical-suboptions-container y-auto-overflow mb4" style="bottom: 100%; top: auto; width: max-content; max-width: 380px; max-height: 270px;">
                                                    @foreach($threadwarningreasons as $reason)
                                                    <div class="typical-suboption custom-drop-down-option mb4 @if($loop->first) custom-dropdown-option-selected @endif">
                                                        <span class="custom-dropdown-option-text block bold lblack fs13">{{ $reason->name }}</span>
                                                        <span class="fs12">{{ $reason->content }}</span>
                                                        <input type="hidden" class="custom-dropdown-option-value" value="{{ $reason->id }}" autocomplete="off">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @if(!$canwarnuser)
                                        <div class="section-style flex align-center my8">
                                            <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                            <p class="fs12 bold lblack no-margin">You cannot warn user because you don't have permission to do so</p>
                                        </div>
                                        @endif
                                        @if($canwarnuser)
                                        <div class="red-button-style full-center width-max-content warn-user-button">
                                            <div class="relative size14 mr4">
                                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                </svg>
                                            </div>
                                            <span class="bold fs13 unselectable">warn thread owner</span>
                                            <input type="hidden" class="user-id" value="{{ $threadowner->id }}" autcomplete="off">
                                            <input type="hidden" class="resource-id" value="{{ $thread->id }}" autcomplete="off">
                                            <input type="hidden" class="resource-type" value="App\Models\Thread" autcomplete="off">
                                            <input type="hidden" class="success-message" value="Thread owner has been warned successfully" autocomplete="off">
                                        </div>
                                        @else
                                        <div class="red-button-style disabled-red-button-style full-center width-max-content">
                                            <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                            <span class="bold fs13 unselectable">warn thread owner</span>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- striking thread owner -->
                                    <div class="ws-striking-box none">
                                        <div class="flex align-center">
                                            <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                                            <span class="bold lblack fs13" class="mr4">strike thread owner</span>
                                        </div>
                                        <p class="no-margin fs13 lblack my8">Select the reason for striking the thread owner</p>
                                        <div class="flex align-center my8">
                                            <span for="reporters-strike-reason" class="lblack fs13 gray bold mr8">strike reason :</span>
                                            <div class="relative custom-dropdown-box">
                                                <input type="hidden" class="custom-dropdown-value strikereason" value="{{ $threadstrikereasons->first()->id }}" autocomplete="off">
                                                <div class="typical-button button-with-suboptions custom-dropdown-selector">
                                                    <span class="custom-dropdown-selected-option-text">{{ $threadstrikereasons->first()->name }}</span>
                                                    <svg class="size6 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M28.61,13.35l-11,9.39a4,4,0,0,1-5.18,0l-11-9.31A4,4,0,1,1,6.59,7.32L15,14.45l8.37-7.18a4,4,0,0,1,5.2,6.08Z"/></svg>
                                                </div>
                                                <div class="custom-dropdown-options-container suboptions-container typical-suboptions-container y-auto-overflow mb4" style="bottom: 100%; top: auto; width: max-content; max-width: 380px; max-height: 270px;">
                                                    @foreach($threadstrikereasons as $reason)
                                                    <div class="typical-suboption custom-drop-down-option mb4 @if($loop->first) custom-dropdown-option-selected @endif">
                                                        <span class="custom-dropdown-option-text block bold lblack fs13">{{ $reason->name }}</span>
                                                        <span class="fs12">{{ $reason->content }}</span>
                                                        <input type="hidden" class="custom-dropdown-option-value" value="{{ $reason->id }}" autocomplete="off">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @if(!$canstrikeuser)
                                        <div class="section-style flex align-center my8">
                                            <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                            <p class="fs12 bold lblack no-margin">You cannot strike user because you don't have permission to do so</p>
                                        </div>
                                        @endif
                                        @if($canstrikeuser)
                                        <div class="red-button-style full-center width-max-content strike-user-button">
                                            <div class="relative size14 mr4">
                                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                </svg>
                                            </div>
                                            <span class="bold fs13 unselectable">strike thread owner</span>
                                            <input type="hidden" class="user-id" value="{{ $threadowner->id }}" autcomplete="off">
                                            <input type="hidden" class="resource-id" value="{{ $thread->id }}" autcomplete="off">
                                            <input type="hidden" class="resource-type" value="App\Models\Thread" autcomplete="off">
                                            <input type="hidden" class="success-message" value="Selected reporters have been striked successfully" autocomplete="off">
                                        </div>
                                        @else
                                        <div class="red-button-style disabled-red-button-style full-center width-max-content">
                                            <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                                            <span class="bold fs13 unselectable">strike thread owner</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection