@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('js/jq-plugins/country-picker-flags/build/css/countrySelect.min.css') }}"><link rel="stylesheet" href="{{ asset('js/jq-plugins/country-picker-flags/build/css/countrySelect.min.css') }}">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
    <script src="{{ asset('js/jq-plugins/country-picker-flags/build/js/countrySelect.min.js') }}" defer></script>
    <script src="{{ asset('js/settings.js') }}" defer></script>
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
            .user-warning-record {
                border: 1px solid #cbd3d9;
                padding: 12px;
                background-color: white;
                border-radius: 3px;
            }
            .user-strike-record {
                border: 1px solid #cbd3d9;
                padding: 12px;
                background-color: #fff1f1;
                border-radius: 3px;
            }

            #user-warnings-box, #user-strikes-box {
                overflow-y: auto;
                max-height: 350px;
                padding: 8px;
                border: 1px solid #b6c3ca;
                border-radius: 4px;
                background-color: white;
            }

            .section-style {
                border-color: #b6c3ca;
            }
        </style>
        <div class="full-width">
            @include('partials.user-space.basic-header', ['page' => 'settings'])
            <h1 class="no-margin lblack mb4 fs19" style="margin-top: 16px">{{ __('Warnings & Strikes') }}</h1>
            <p class="no-margin lblack mb8">{{ __("This page lists all warnings and strikes you got due to guidelines violation and website misuse") }}.</p>
            <!-- user warnings section -->
            @if($warnings->count())
            <div class="section-style white-background" style="padding: 10px;">
                <div class="flex align-center">
                    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                    <h2 class="no-margin fs14 lblack">{{ __('warnings') }} - {{ $warningscount }}</h2>
                </div>
                <p class="no-margin fs12 lblack my4">{{ __('warnings are sorted by the newest ones first') }}</p>
                <div id="user-warnings-box">
                    @foreach($warnings as $warning)
                    <x-user.warning-component :warning="$warning"/>
                    @endforeach
    
                    @if($warningscount > $warnings->count())
                    <div class="full-center py8" id="user-warnings-fetch-more">
                        <svg class="spinner size24" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                    </div>
                    @endif
                </div>
            </div>
            @endif
            <!-- user strikes section -->
            @if($strikes->count())
            <div class="section-style white-background mt8" style="padding: 10px;">
                <div class="flex align-center">
                    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M133.28,5.08h5.82c9.12,3.68,11.64,7.49,11.63,17.56q0,41.69,0,83.36a33.18,33.18,0,0,0,.09,4.35c.31,2.52,1.7,4.18,4.37,4.33,2.94.17,4.49-1.56,5-4.22a23.31,23.31,0,0,0,.13-4.35q0-37.8,0-75.6c0-9.49,5.91-15.89,14.48-15.79,8.25.09,14.27,6.68,14.25,15.71q-.06,42.41-.18,84.8a27.74,27.74,0,0,0,.18,4.83c.48,2.7,2.11,4.43,5,4.2,2.58-.2,4-1.82,4.27-4.43.08-.8.07-1.61.07-2.42q0-28.35-.08-56.7c0-4.12.44-8.06,2.94-11.5A14.34,14.34,0,0,1,217.17,44c6.35,2,10.1,7.94,10.09,16q-.06,61.06-.12,122.13a121.16,121.16,0,0,1-.74,13c-3.19,28.63-19.47,47.82-47.27,55.18-16.37,4.33-33,3.7-49.46.47-20-3.93-36.55-13.65-48.09-30.64-15.76-23.21-31-46.74-46.51-70.16a20.9,20.9,0,0,1-2.13-4.32c-4.68-12.84,4.91-25.12,18.14-23.18,5.55.81,9.81,3.87,13.1,8.36,6.31,8.63,12.63,17.25,19.68,26.87,0-16.64,0-31.95,0-47.25q0-35.13,0-70.27c0-7.58,3.18-12.62,9.24-15,10.31-4,19.76,3.91,19.66,16.09-.19,22.29-.11,44.58-.16,66.87,0,3.33.51,6.46,4.68,6.48s4.75-3.09,4.75-6.42c0-28.11.2-56.22-.13-84.33C121.79,14.87,124.51,8.36,133.28,5.08Z"/></svg>
                    <h2 class="no-margin fs14 lblack">{{ __('strikes') }} - {{ $strikescount }}</h2>
                </div>
                <p class="no-margin fs12 lblack my4">{{ __('strikes are sorted by the newest ones first') }}</p>
                <div id="user-strikes-box">
                    @foreach($strikes as $strike)
                    <x-user.strike-component :strike="$strike"/>
                    @endforeach
    
                    @if($strikescount > $strikes->count())
                    <div class="full-center py8" id="user-strikes-fetch-more">
                        <svg class="spinner size24" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                    </div>
                    @endif
                </div>
            </div>
            @endif
            <!-- no warnings & no strikes -> account's clean -->
            @if(!$strikes->count() && !$warnings->count())
                <div class="full-center green-section-style" style="margin-top: 20px">
                    <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                    <p class="bold my4" style="color: #44a644">{{ __("You don't have any strikes or warnings.") }}</p>
                </div>
            @endif
        </div>
        <div id="right-panel" class="pt8">
            @include('partials.settings.profile-right-side-menu', ['item'=>'strikes-and-warnings'])
        </div>
    </div>
@endsection