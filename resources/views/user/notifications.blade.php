@extends('layouts.app')

@prepend('scripts')
    <script src="{{ asset('js/notifications.js') }}" defer></script>
@endprepend

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    <input type="hidden" id="page" value="notifications-page">
    @include('partials.left-panel', ['page' => '', 'subpage'=>''])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex">
            <div class="notifications-wrapper">
                <h1 id="page-title" style="margin-bottom: 16px">{{__('Notifications')}}</h1>
                <div class="flex flex-column notifs-box">
                    @foreach($notifications as $notification)
                        <x-user.header-notification :notification="$notification"/>
                    @endforeach
                    @if($hasmore)
                        <div class="notifications-fetch-more">
                            <div class="flex" style="padding: 6px">
                                <div class="size48 rounded hidden-overflow mr8 relative" style="min-width: 48px">
                                    <div class="fade-loading"></div>
                                </div>
                                <div class="full-width">
                                    <div class="flex align-center">
                                        <div class="relative br3 hidden-overflow mr4" style="width: 80px; height: 10px">
                                            <div class="fade-loading"></div>
                                        </div>
                                        <div class="relative br3 hidden-overflow" style="width: 100%; height: 10px">
                                            <div class="fade-loading"></div>
                                        </div>
                                    </div>
                                    <div class="relative br3 hidden-overflow my4" style="width: 100%; height: 24px">
                                        <div class="fade-loading"></div>
                                    </div>
                                    <div class="relative br3 hidden-overflow" style="width: 80px; height: 8px">
                                        <div class="fade-loading"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex" style="padding: 6px">
                                <div class="size48 rounded hidden-overflow mr8 relative" style="min-width: 48px">
                                    <div class="fade-loading"></div>
                                </div>
                                <div class="full-width">
                                    <div class="flex align-center">
                                        <div class="relative br3 hidden-overflow mr4" style="width: 80px; height: 10px">
                                            <div class="fade-loading"></div>
                                        </div>
                                        <div class="relative br3 hidden-overflow" style="width: 100%; height: 10px">
                                            <div class="fade-loading"></div>
                                        </div>
                                    </div>
                                    <div class="relative br3 hidden-overflow my4" style="width: 100%; height: 24px">
                                        <div class="fade-loading"></div>
                                    </div>
                                    <div class="relative br3 hidden-overflow" style="width: 80px; height: 8px">
                                        <div class="fade-loading"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="notification-empty-box my8 @if($notifications->count()) none @endif">
                    <svg class="flex size28 move-to-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 438.53 438.53"><path d="M431.4,211l-68-157.6A25.47,25.47,0,0,0,353,41.4q-7.56-4.86-15-4.86H100.5q-7.43,0-15,4.86a25.52,25.52,0,0,0-10.42,12L7.14,211A91.85,91.85,0,0,0,0,246.1V383.72a17.59,17.59,0,0,0,5.42,12.85A17.61,17.61,0,0,0,18.27,402h402a18.51,18.51,0,0,0,18.26-18.27V246.1A91.84,91.84,0,0,0,431.4,211ZM292.07,237.54,265,292.36H173.59l-27.12-54.82H56.25a12.85,12.85,0,0,0,.71-2.28,13.71,13.71,0,0,1,.72-2.29L118.2,91.37H320.34L380.86,233c.2.58.43,1.34.71,2.29s.53,1.7.72,2.28Z"/></svg>
                    <h3 class="my4 fs17 text-center">{{__('Notifications box is empty')}}</h3>
                    <p class="my4 fs13 gray text-center">{{ __("Try to create more posts and react to other users' posts to get notifications") }}.</p>
                </div>
            </div>
        </div>
    </div>
@endsection