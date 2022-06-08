@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/post.js') }}" defer></script>
    <script src="{{ asset('js/thread/announcement-show.js') }}" defer></script>
    <script src="{{ asset('js/simplemde.js') }}"></script>
@endpush


@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    @include('partials.header')
@endsection
@section('content')
    @include('partials.left-panel', ['page' => 'announcement-show'])
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('announcements') }}" class="link-path">{{ __('Announcement') }}</a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="link-path flex align-center">
            <svg class="small-image-size mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                {!! $forum->icon !!}
            </svg>
            {{ $forum->forum }}
        </a>
    </div>
    <div id="middle-container" class="middle-padding-1" style="width: 75%; margin: 0 auto;">
        <input type="hidden" class="page" value="announcement-show">
        <div class="flex">
            <div class="full-width">
                <x-thread.announcementshow :announcement="$announcement"/>
                @if($announcement->replies_off)
                    <div style="margin-top: 20px">
                        <svg class="size40 move-to-middle flex mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="286.31" cy="273.61" r="20.21"/><circle cx="205.48" cy="273.61" r="20.21"/><circle cx="124.65" cy="273.61" r="20.21"/><path d="M437.87,249.45v44.37H377.24V262.45A130.67,130.67,0,0,1,336.83,255V374.65H160.62l-13.74,40.42-13.74-40.42h-59V172.58h182a131.13,131.13,0,0,1-6.64-40.42H155V71.54H263.84A131.48,131.48,0,0,1,287.36,39,4.66,4.66,0,0,0,284,31.13H152.13a37.58,37.58,0,0,0-37.58,37.58v63.45H70.09a36.57,36.57,0,0,0-36.37,36.38V378.69a36.57,36.57,0,0,0,36.37,36.38h34l19.2,52.33a28.08,28.08,0,0,0,24.25,13.74h5a28.48,28.48,0,0,0,22.63-20.2l14.55-45.87H340.87a36.57,36.57,0,0,0,36.37-36.38V334.24H440.7a37.59,37.59,0,0,0,37.58-37.59V230.49a4.67,4.67,0,0,0-7.89-3.37A131.55,131.55,0,0,1,437.87,249.45Z"/><path d="M422.66,69A75.55,75.55,0,0,0,318,173.66ZM444,90.34A75.55,75.55,0,0,1,339.34,195ZM381,26.25A105.75,105.75,0,1,1,275.25,132,105.76,105.76,0,0,1,381,26.25Z" style="fill-rule:evenodd"/></svg>
                        <p class="text-center my4">{{ $announcement->user->username }} {{ __('turned off replies on this announcement') }}</p>
                    </div>
                @else
                <div>
                    <div class="share-post-form">
                        <div class="input-container">
                            <div class="fs14" style="margin: 20px 0 8px 0">
                                <div class="relative">
                                    <span class="absolute" id="reply-site" style="margin-top: -70px"></span>
                                </div>
                                <label for="reply-content" class="flex bold fs16">
                                    {{__('Your reply')}} 
                                    <span class="error frt-error reply-content-error">  *</span>
                                </label>
                            </div>
                            <p class="error frt-error reply-content-error" id="global-error" role="alert"></p>
                            <textarea name="subject" class="reply-content" id="post-reply" placeholder="{{ __('Your feedback on this announcement') }}"></textarea>
                            <style>
                                .CodeMirror,
                                .CodeMirror-scroll {
                                    max-height: 120px;
                                    min-height: 120px;
                                    border-color: #dbdbdb;
                                }
                                .CodeMirror-scroll:focus {
                                    border-color: #64ceff;
                                    box-shadow: 0 0 0px 3px #def2ff;
                                }
                                .editor-toolbar {
                                    padding: 0 4px;
                                    opacity: 0.8;
                                    height: 38px;
                                    border-top-color: #dbdbdb;
                                    background-color: #f2f2f2;
                                    display: flex;
                                    align-items: center;
                                }
                                .editor-toolbar .fa-arrows-alt, .editor-toolbar .fa-columns, 
                                .fa-question-circle, .fa-link, .fa-picture-o, .fa-link,
                                .share-post-form .separator:nth-of-type(2), .editor-statusbar {
                                    display: none !important;
                                }
                        </style>
                        </div>
                        <input type="hidden" name="thread_id" class="thread_id" value="{{ $announcement->id }}">
                        <input type='button' class="inline-block button-style @auth share-post @endauth @guest login-signin-button @endguest" value="Post your reply">
                    </div>
                </div>
                @endif
                    
                <div class="flex space-between align-end replies_header_after_thread @if(!$tickedPost && $posts->count() == 0) none @endif" id="thread-show-replies-section">
                    <p class="bold fs20" style="margin-top: 30px"><span class="thread-replies-number thread-replies-counter">@if($tickedPost) {{ $posts->total() + 1 }} @else {{ $posts->total() }} @endif</span> Replies</p>
                    <div>
                        {{ $posts->onEachSide(0)->links() }}
                    </div>
                </div>
                <div id="replies-container" style="margin-bottom: 30px">
                    @if($tickedPost)
                    <x-post-component :post="$tickedPost"/>
                    @endif
                    @foreach($posts as $post)
                        <x-post-component :post="$post" :threadownerid="$owner->id"/>
                    @endforeach
                    @if($posts->count() > 10)
                    <div class="flex">
                        <div class="move-to-right">
                            {{ $posts->onEachSide(0)->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div id="right-panel">
        <x-right-panels.forumslist/>
        <x-right-panels.recentthreads/>
        @include('partials.right-panels.statistics')
    </div>
@endsection