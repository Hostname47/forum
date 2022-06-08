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
        <section class="flex">
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page' => 'settings'])
                <h1 class="fs19 forum-color" style="margin-top: 16px 0 12px 0;">{{__('Update personal informations')}}</h1>

                @if($errors->any())
                <div class="error-container my8">
                    <p class="error-message">{{$errors->first()}}</p>
                </div>
                @endif
                @if(Session::has('message'))
                    <div class="green-message-container my8">
                        <p class="green-message">{{ Session::get('message') }}</p>
                    </div>
                @endif

                <div class="red-section-style flex align-center error-container none my8">
                    <svg class="size14 mr8" style="min-width: 14px; fill: rgb(68, 5, 5);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size14 mr8"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                    <p class="no-margin fs12 bold dark-red error-text"></p>
                </div>

                <div class="flex">
                    <div class="half-width mr8">
                        <!-- birth -->
                        <div class="mb8">
                            <label for="datepicker" class="block fs12 bold lblack mb4">{{ __('Birth') }}</label>
                            <input type="text" id="datepicker" class="styled-input birth-input" value="{{ $user->personal->birth }}" class="basic-input" placeholder="{{__('birth')}}">
                        </div>
                        <!-- country (if user already set country, we handle setting it in settings.js file) -->
                        <div class="mb8">
                            <label for="subject" class="block fs12 bold lblack mb4">{{ __('Country') }}</label>
                            <input id="country_selector" class="styled-input country-input" type="text" class="basic-input">
                            <style>
                                .country-select {
                                    width: 100% !important;
                                }
                            </style>
                            <input type="hidden" id="user-personal-country" value="{{ $user->personal->country }}">
                        </div>
                        <!-- city -->
                        <div class="mb8">
                            <label for="city" class="block fs12 bold lblack mb4">{{ __('City') }}</label>
                            <input type="text" id="city" value="{{ $user->personal->city }}" class="full-width styled-input city-input" autocomplete="off" placeholder="{{ __('your city') }}">
                        </div>
                        <!-- phone -->
                        <div class="mb8">
                            <label for="phone" class="block fs12 bold lblack mb4">{{ __('Phone') }}</label>
                            <input type="text" id="phone" value="{{ $user->personal->phone }}" class="full-width styled-input phone-input" autocomplete="off" placeholder="{{ __('phone number') }}">
                        </div>
                    </div>
                    <div class="half-width ml8">
                        <!-- facebook -->
                        <div>
                            <div class="flex align-center mb4">
                                <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M483.74,0H28.24A28.26,28.26,0,0,0,0,28.26v455.5A28.26,28.26,0,0,0,28.26,512H273.5V314H207V236.5h66.5v-57c0-66.14,40.38-102.14,99.38-102.14,28.26,0,52.54,2.11,59.62,3.05V149.5H391.82c-32.11,0-38.32,15.25-38.32,37.64V236.5h76.75l-10,77.5H353.5V512H483.74A28.25,28.25,0,0,0,512,483.75V28.24A28.26,28.26,0,0,0,483.74,0Z" style="fill:#4267b2"/><path d="M353.5,187.14V236.5h76.75l-10,77.5H353.5V512h-80V314H207V236.5h66.5v-57c0-66.14,40.38-102.14,99.38-102.14,28.26,0,52.54,2.11,59.62,3.05V149.5H391.82C359.71,149.5,353.5,164.75,353.5,187.14Z" style="fill:#fff"/></svg>
                                <label for="facebook" class="block fs12 bold lblack mt2">{{ __('Facebook') }}</label>
                            </div>
                            <input type="text" id="facebook" value="{{ $user->personal->facebook }}" class="full-width styled-input" autocomplete="off" placeholder="{{ __('Your facebook account url') }}">
                        </div>
                        <!-- instagram -->
                        <div class="input-container" style="margin-top: 13px">
                            <div class="flex align-center mb4">
                                <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><defs><linearGradient id="linear-gradient" x1="42.97" y1="42.97" x2="469.03" y2="469.04" gradientTransform="matrix(1, 0, 0, -1, 0, 512)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ffd600"/><stop offset="0.5" stop-color="#ff0100"/><stop offset="1" stop-color="#d800b9"/></linearGradient><linearGradient id="linear-gradient-2" x1="163.04" y1="163.05" x2="348.95" y2="348.96" gradientTransform="matrix(1, 0, 0, -1, 0, 512)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ff6400"/><stop offset="0.5" stop-color="#ff0100"/><stop offset="1" stop-color="#fd0056"/></linearGradient><linearGradient id="linear-gradient-3" x1="370.93" y1="370.93" x2="414.37" y2="414.38" gradientTransform="matrix(1, 0, 0, -1, 0, 512)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#f30072"/><stop offset="1" stop-color="#e50097"/></linearGradient></defs><path d="M510.46,150.45c-1.25-27.25-5.57-45.86-11.9-62.14A125.58,125.58,0,0,0,469,43a125.52,125.52,0,0,0-45.34-29.54C407.4,7.11,388.8,2.79,361.55,1.55S325.52,0,256,0,177.75.3,150.45,1.54,104.6,7.11,88.31,13.44A125.58,125.58,0,0,0,43,43,125.52,125.52,0,0,0,13.43,88.31C7.11,104.59,2.79,123.2,1.55,150.45S0,186.47,0,256s.3,78.25,1.55,105.55,5.57,45.85,11.9,62.14A125.43,125.43,0,0,0,43,469a125.38,125.38,0,0,0,45.35,29.52c16.28,6.34,34.89,10.66,62.14,11.91S186.48,512,256,512s78.25-.3,105.55-1.54,45.86-5.57,62.14-11.91a130.87,130.87,0,0,0,74.87-74.86c6.33-16.29,10.65-34.9,11.9-62.14S512,325.52,512,256,511.7,177.75,510.46,150.45Zm-46.08,209c-1.14,25-5.31,38.51-8.81,47.53A84.79,84.79,0,0,1,407,455.57c-9,3.5-22.57,7.68-47.53,8.81-27,1.24-35.09,1.5-103.45,1.5s-76.46-.26-103.45-1.5c-25-1.13-38.51-5.31-47.53-8.81a79.45,79.45,0,0,1-29.44-19.15A79.37,79.37,0,0,1,56.43,407c-3.5-9-7.68-22.57-8.81-47.53-1.23-27-1.49-35.09-1.49-103.45s.26-76.45,1.49-103.45c1.14-25,5.31-38.51,8.81-47.53A79.45,79.45,0,0,1,75.58,75.58,79.45,79.45,0,0,1,105,56.43c9-3.5,22.57-7.67,47.53-8.81,27-1.23,35.09-1.49,103.45-1.49h0c68.35,0,76.45.26,103.45,1.49,25,1.14,38.51,5.31,47.53,8.81a79.34,79.34,0,0,1,29.43,19.15A79.21,79.21,0,0,1,455.56,105c3.51,9,7.68,22.57,8.82,47.53,1.23,27,1.49,35.09,1.49,103.45S465.61,332.45,464.38,359.45Z" style="fill:url(#linear-gradient)"/><path d="M256,124.54A131.46,131.46,0,1,0,387.46,256,131.46,131.46,0,0,0,256,124.54Zm0,216.79A85.34,85.34,0,1,1,341.33,256,85.32,85.32,0,0,1,256,341.33Z" style="fill:url(#linear-gradient-2)"/><path d="M423.37,119.35a30.72,30.72,0,1,1-30.72-30.72A30.72,30.72,0,0,1,423.37,119.35Z" style="fill:url(#linear-gradient-3)"/></svg>
                                <label for="instagram" class="block fs12 bold lblack">{{ __('Instagram') }}</label>
                            </div>
                            <input type="text" id="instagram" value="{{ $user->personal->instagram }}" class="full-width styled-input" autocomplete="off" placeholder="{{ __('Your instagram username') }}">
                        </div>
                        <!-- twitter -->
                        <div class="input-container" style="margin-top: 13px">
                            <div class="flex align-center mb4">
                                <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512,97.25a218.64,218.64,0,0,1-60.48,16.57,104.36,104.36,0,0,0,46.18-58,210,210,0,0,1-66.56,25.41A105,105,0,0,0,249.57,153,108,108,0,0,0,252,176.93C164.74,172.67,87.52,130.85,35.65,67.14A105,105,0,0,0,67.9,207.42,103.69,103.69,0,0,1,20.48,194.5v1.15a105.43,105.43,0,0,0,84.1,103.13,104.65,104.65,0,0,1-27.52,3.46,92.77,92.77,0,0,1-19.88-1.79c13.6,41.57,52.2,72.13,98.08,73.12A210.93,210.93,0,0,1,25.12,418.34,197.72,197.72,0,0,1,0,416.9,295.54,295.54,0,0,0,161,464c193.16,0,298.76-160,298.76-298.69,0-4.64-.16-9.12-.39-13.57A209.29,209.29,0,0,0,512,97.25Z" style="fill:#03a9f4"/></svg>
                                <label for="twitter" class="block fs12 bold lblack">{{ __('Twitter') }}</label>
                            </div>
                            <input type="text" id="twitter" value="{{ $user->personal->twitter }}" class="full-width styled-input" autocomplete="off" placeholder="{{ __('Your twitter account url') }}">
                        </div>
                    </div>
                </div>
                <!-- save user personal informations button -->
                <div id="save-user-personal-informations" class="typical-button-style flex align-center width-max-content mt8">
                    <div class="relative size14 mr4">
                        <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"/><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"/></svg>
                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="bold fs12" style="margin-top: 1px">{{ __('Save personal informations') }}</span>
                </div>
            </div>
        </section>
        <div id="right-panel" class="pt8">
            @include('partials.settings.profile-right-side-menu', ['item'=>'settings-personal'])
        </div>
    </div>
@endsection