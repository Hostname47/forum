@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/simplemde.js') }}"></script>
<script src="{{ asset('js/thread/show.js') }}" defer></script>
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
    @if(auth()->user() && auth()->user()->id != $thread->user_id)
        @include('partials.thread.report.thread-report')
    @endif
    @include('partials.thread.report.post-report')
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="link-path">{{ __($forum->forum) . ' ' . __('Forum') }}</a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('category.threads', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="link-path">{{ __($category->category) }}</a>
    </div>
    <div id="middle-container" class="index-middle-width" style="margin-bottom: 50px">
        <input type="hidden" class="page" value="thread-show" autocomplete="off">
        <div class="flex">
            <div class="full-width">
                <style>
                    .thread-container-box {
                        border-bottom: 1px solid #b7c0c6;
                    }

                    #close-info-box {
                        padding: 10px;
                        border-radius: 2px;
                        background-color: #7c868f0f;
                        border: 1px solid #7c868f2b;
                        margin-bottom: 10px;
                    }
                </style>
                @php $status = $thread->status->slug; @endphp
                @if($status == 'closed')
                <div id="close-info-box">
                    <div class="flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.94,199.94,0,0,1,256,456ZM357.8,193.8,295.6,256l62.2,62.2a12,12,0,0,1,0,17l-22.6,22.6a12,12,0,0,1-17,0L256,295.6l-62.2,62.2a12,12,0,0,1-17,0l-22.6-22.6a12,12,0,0,1,0-17L216.4,256l-62.2-62.2a12,12,0,0,1,0-17l22.6-22.6a12,12,0,0,1,17,0L256,216.4l62.2-62.2a12,12,0,0,1,17,0l22.6,22.6a12,12,0,0,1,0,17Z"/></svg>
                        <span class="fs15 bold lblack">{{__('Post Closed')}}</span>
                    </div>
                    <p class="my4 lblack" style="line-height: 1.5">{{ __($thread->threadclose->reason->reason) }}</p>
                </div>
                @endif
                <x-index-resource :thread="$thread" :data="['postscount'=>$totalpostscount, 'ticked'=>$ticked]"/>

                @if($status == 'closed')
                <p class="fs13 text-center">{{ __('Post closed') }}</p>
                @elseif($thread->replies_off)
                    <p class="fs13 text-center">{{ __('The owner of this post turned off replies') }}</p>
                @else
                <div class="share-post-box" style="margin: 20px 0 8px 0">
                    <input type="hidden" class="selected-thread-posts-count" value="{{ $totalpostscount }}" autocomplete="off">
                    <input type="hidden" class="content-required" value="{{ __('Reply content is required') }}" autocomplete="off">
                    <input type="hidden" class="thread-id" value="{{ $thread->id }}" autocomplete="off">
                    <div class="flex red-section-style error-container my8 none">
                        <svg class="size12 mr8 mt2" style="min-width: 12px;" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                        <span class="error fs13 bold no-margin error"></span>
                    </div>
                    <div class="input-container">
                        <label for="reply-content" class="fs14 block bblack bold fs14 mb8">{{__('Your reply')}}</label>
                        <textarea name="subject" class="post-input" id="post-reply" placeholder="{{ __('Your reply here') }}.."></textarea>
                    </div>
                    <div class="typical-button-style flex align-center width-max-content @auth share-post @else login-signin-button @endauth">
                        <div class="relative size14 mr4">
                            <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M201.05,3.07c8.23,2.72,16.28,5.55,23,11.56,18.11,16.18,19.44,44.44,2.63,63.18-15.58,17.37-43.73,18.58-61,2.32-3.22-3-5.24-3.16-8.9-.81-12.46,8-25.25,15.52-37.83,23.35-2.31,1.44-3.62,1.53-4.7-1.19a24.77,24.77,0,0,0-2.4-4.25c-3.53-5.4-3.54-5.38,2.16-8.86,12.22-7.48,24.42-15,36.69-22.41,2-1.22,3.23-2.23,2.32-4.93-8.35-24.77,7.61-50.71,30.61-56.36.94-.23,2.38-.15,2.75-1.6Zm22.63,173.39c-18.11-15.47-41.43-15-58.9,1.2-2.5,2.31-4.1,2.5-6.93.7C147,171.46,136,164.82,125,158.12c-2.89-1.76-5.92-4.75-8.81-4.66-2.47.08-2.92,5-5,7.28-.11.12-.15.3-.27.41-2.76,2.69-2.35,4.38,1.1,6.42,12.77,7.52,25.29,15.47,38,23,2.84,1.7,3.94,3.2,2.65,6.51-2.57,6.57-2.39,13.51-1.28,20.28,3.49,21.33,24.74,38.21,45.44,36.42,24.16-2.08,42.07-21.18,41.82-44.6C238.39,196.12,233.64,185,223.68,176.46Zm-161-92c-24-.28-44.23,19.81-44.27,44a44.34,44.34,0,0,0,43.71,44.11c24,.28,44.22-19.81,44.27-44A44.36,44.36,0,0,0,62.68,84.43Z"/></svg>
                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="bold fs12 unselectable" style="margin-top: 1px">{{ __('Share your reply') }}</span>
                        <input type="hidden" class="success-message" value="{{ __('Your reply has been created') }}" autocomplete="off">
                        <input type="hidden" class="from" value="thread-show" autocomplete="off">
                    </div>
                </div>
                @endif
                
                <div class="flex space-between align-end" style="margin: 30px 0 0 0">
                    <p class="thread-show-posts-counter-text bold forum-color fs18 no-margin @if($posts->count() == 0) none @endif"><span id="thread-show-posts-count">{{ $totalpostscount }}</span> {{__('Replies')}}</p>
                    {{ $posts->onEachSide(0)->links() }}
                </div>
                @if($missed_ticked_post)
                <div class="my8 section-style flex missed-ticked-post-notice">
                    <svg class="size14 mr8 mt2" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <div>
                        <p class="no-margin fs12 lblack lh15">{{ __("This post had already a ticked reply, and It seems to be not available either because the owner's account is deactivated or the reply is hidden by admins") }}.</p>
                        @if(auth()->user() && auth()->user()->id == $thread->user_id)
                        <div>
                            <span class="block mt4 fs11 bold lblack">{{ __('Hint to post owner') }} ;</span>
                            <p class="no-margin fs11">{{ __("You can delete the tick from the missed reply by clicking on remove tick in post options button") }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                <div id="thread-show-posts-container" style="margin-bottom: 30px">
                    @foreach($posts as $post)
                        <x-post-component :post="$post" :data="['thread-owner-id'=>$threadownerid, 'can-be-ticked'=>!$ticked]"/>
                    @endforeach
                    @if($posts->count() > $posts_per_page)
                    <div class="flex">
                        <div class="move-to-right">
                            {{ $posts->onEachSide(0)->links() }}
                        </div>
                    </div>
                    @endif
                </div>
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
                    .editor-statusbar {
                        display: none !important;
                    }
                </style>
            </div>
        </div>
    </div>
    <div id="right-panel">
        @include('partials.thread.right-panel', ['user'=>$thread->user])
    </div>
@endsection