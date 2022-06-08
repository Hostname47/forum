@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/notifications.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.settings'])
    <div id="middle-container" class="middle-padding-1">
        <style>
            .disable-container {
                margin-bottom: 6px;
                padding: 8px;
                background-color: #eef1f2;
                border: 1px solid #dce2e3;
                border-radius: 3px;
            }

            .disable-records-container {
                padding: 10px;
                background-color: white;
                overflow-y: auto;
                max-height: 300px;
                border-radius: 4px;
                border: 1px solid #d2d9dd;
            }

            .disable-record-container {
                margin-top: 6px;
                padding: 8px;
                background-color: white;
                border: 1px solid #dce2e3;
                border-radius: 3px;
            }
        </style>
        <section class="flex">
            <input type="hidden" id="notification-enabled-success-message" value="{{ __('Notifications enabled successfully') }}" autocomplete="off">
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page' => 'settings'])
                @if($errors->any())
                <div class="error-container">
                    <p class="error-message">{{ $errors->first() }}</p>
                </div>
                @endif
                @if(Session::has('message'))
                    <div class="green-message-container">
                        <p class="green-message">{{ Session::get('message') }}</p>
                    </div>
                @endif

                <div class="flex align-center" style="margin: 16px 0 12px 0">
                    <svg class="size16 mt2 mr8" fill='#202020' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,512a64,64,0,0,0,64-64H192A64,64,0,0,0,256,512ZM471.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C150.56,68.1,96.08,130.3,96.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,32,384c.11,16.4,13,32,32.1,32H447.9c19.12,0,32-15.6,32.1-32A31.23,31.23,0,0,0,471.39,362.29Z"></path></svg>
                    <h1 class="forum-color no-margin">{{__('Notifications settings')}}</h1>
                </div>

                <div class="margin-top: 12px">
                    <div class="flex align-center">
                        <svg class="size16 mr4" style="margin-top: 1px; min-width: 16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M183.28,204.66c-5.94,0-11.88.08-17.81,0-2.32-.05-3.24.36-3.62,3.08-2.33,16.88-15.21,28.48-31.31,28.61s-29.15-11.56-31.65-28.8c-.35-2.39-1-3.18-3.28-2.86a6.4,6.4,0,0,1-1,0c-7.59,0-15.78-1.72-22.59.6s-11,10.07-16.51,15.22a40.46,40.46,0,0,1-3.28,3,10.5,10.5,0,0,1-14.76-14.65,29.9,29.9,0,0,1,3-3.27q82.4-82.44,164.82-164.85a33.16,33.16,0,0,1,2.51-2.38c4.61-3.81,10.24-3.72,14.31.2a10.06,10.06,0,0,1,.44,14.63c-6.3,6.75-12.91,13.22-19.51,19.68-1.83,1.79-2.51,3.25-1.63,6,2.31,7.09,2.93,14.51,3,22,0,8.41.09,16.83,0,25.24a42.59,42.59,0,0,0,6.34,23c3.57,5.93,7.18,11.82,10.65,17.8,10.32,17.79-.68,37.32-21.28,37.81C194.5,204.77,188.89,204.66,183.28,204.66Zm-85.59-25a2.16,2.16,0,0,0,1.52,3.7h0c31.67,0,63.33,0,95-.08,3.13,0,7.22,1.76,9.26-1.4,2.33-3.61-1.44-6.52-3.28-9.05C186.63,154.1,181.09,133.35,183,110.4a105.5,105.5,0,0,0,.15-11.12,2.17,2.17,0,0,0-3.7-1.48Zm32.71,25c-2.46,0-4.94.15-7.39,0-3-.23-3.4,1.19-2.47,3.51,1.51,3.78,4.2,6.22,8.35,6.74a10,10,0,0,0,10.47-4.94c.87-1.4,1.86-3.08,1-4.57s-2.69-.59-4.09-.67C134.35,204.57,132.38,204.66,130.4,204.66Zm-52-114.48C85.53,51.1,129,33.54,161.75,56.38c6.3,4.39,12.36,4,16.17-1.11,3.94-5.26,2.51-11.45-3.88-16.05C158.4,28,141,23.62,121.81,25.5,88.83,28.72,60.12,57.27,57,90.18c-1.11,11.69-.55,23.4-.57,35.1a45.62,45.62,0,0,1-6.77,24.4C47,154,44.27,158.35,42,162.9a10.19,10.19,0,0,0,3.85,13.39c4.61,2.89,10.65,2.23,13.68-2.39,7.41-11.26,14.91-22.58,17.15-36.31,1.4-8.51,1-17.11,1-26.47C77.87,104.66,77.05,97.36,78.36,90.18Z" style="fill:#050505"/></svg>
                        <h2 class="no-margin fs15 lblack">{{ __('Disabled notifications') }}</h2>
                    </div>
                    @if($totaldisablescount)
                        <p class="no-margin lblack my4 fs13">{{ __("The following notifications disableds are grouped by the type of resource and action of notifications disabled by you. You can enable them again to start get notifications as usual") }}.</p>
                        <div>
                        @foreach($disables as $disable)
                            <div class="disable-container">
                                <div class="flex align-center pointer get-disables-by-type">
                                    <div class="flex align-center pointer">
                                        <div class="flex">
                                            <p class="bold no-margin gray unselectable">{{ __('Action disabled') }} : <span class="lblack">{{ $disable['infos']['title'] }} ({{ $disable['count'] }})</span></p>
                                        </div>

                                        <div class="relative full-center size10 ml4">
                                            <svg class="flex icon-above-spinner size6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                                            <svg class="spinner size10 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <input type="hidden" class="action-type" value="{{ $disable['action'] }}" autocomplete="off">
                                    <input type="hidden" class="status" value="not-fetched" autocomplete="off">
                                </div>
                                <div class="disable-records-container mt4 none">
                                    <p class="no-margin lblack fs13 unselectable">{{ $disable['infos']['desc'] }}</p>
                                    <div class="disabled-actions-fetch-more none no-fetch">
                                        <input type="hidden" class="fetch-status" value="stable" autocomplete="off">
                                        <input type="hidden" class="action-type" value="{{ $disable['action'] }}" autocomplete="off">
                                        <div class="full-center" style="padding: 12px 0;">
                                            <svg class="spinner size14" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @endif
                    @if($totaldisablescount == 0)
                    <div class="section-style flex mt8">
                        <svg class="size14 mr8" style="min-width: 14px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="no-margin bold lblack fs12 lh15">{{ __("You don't have any disabled notifications for the moment. If you don't want to receive a type of notification you can go to notifications page or notifications in header and disable it to stop receiving notifications about specific action or resource.") }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <div id="right-panel" class="pt8">
            @include('partials.settings.profile-right-side-menu', ['item'=>'notifications-settings'])
        </div>
    </div>
@endsection