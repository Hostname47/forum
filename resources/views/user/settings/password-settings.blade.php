@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/passwords.js') }}" defer></script>
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
                <h1 class="no-margin lblack mb4 fs19" style="margin-top: 16px">{{ __('Password Settings') }}</h1>

                <input type="hidden" id="password-required-validation-error" value="{{ __('Password fields are required') }}" autocomplete="off">
                <input type="hidden" id="password-uppercase-validation-error" value="{{ __('The password must contains at least one uppercase character') }}" autocomplete="off">
                <input type="hidden" id="password-lowercase-validation-error" value="{{ __('The password must contains at least one lowercase character') }}" autocomplete="off">
                <input type="hidden" id="password-numeric-validation-error" value="{{ __('The password must contains at least one digit') }}" autocomplete="off">
                <input type="hidden" id="password-length-validation-error" value="{{ __('The password must contain at least 8 characters') }}" autocomplete="off">
                <input type="hidden" id="password-confirmation-validation-error" value="{{ __('The password confirmation should match password value') }}" autocomplete="off">

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

                <!-- 
                    Here we split the view into two sections : first is where user has already set his first password
                    because the register type for now is OAuth only.
                    The second section is where the user already set the first password, so we need to show him password 
                    change section.
                -->
                <div class="my8">
                    <div class="red-section-style flex align-center error-container none my8">
                        <svg class="size14 mr8" style="min-width: 14px; fill: rgb(68, 5, 5);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size14 mr8"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                        <p class="no-margin fs12 bold dark-red error-text"></p>
                    </div>
                    @if(is_null($user->password))
                    <div class="section-style mb8">
                        <p class="no-margin lblack fs13 lh15">{{ __("You are currently logged in using :oauth_provider service, and your account has no associated password. You can attach a new password to your account using the form below", ['oauth_provider'=>$user->provider]) }}.</p>
                    </div>
                    <p class="no-margin lblack mb8 fs13 lh15"><strong>{{ __('Your email') }} :</strong> {{ $user->email }}</p>
                    <p class="no-margin lblack mb8 fs13 lh15">{{ __("For now, the only way you can log in is to use your social login because you are not associating any password to this account. However, If you create a new password, you will be able to login using your email and password, and also use remember me feature which allows you to keep your account logged in even after closing your browser or your device") }}.</p>

                    <!-- set password box -->
                    <div>
                        <h2 class="forum-color no-margin fs15">{{ __('Create a password for your account') }}</h2>
                        <p class="fs12 gray mt2 mb8">{{ __('Enter the password you want to attach to this account and make sure it matches the rules explained in the right panel') }}.</p>
                        <div>
                            <label for="password" class="block fs12 bold mb4 lblack">{{ __('Password') }}</label>
                            <input type="password" class="styled-input" id="password" autocomplete="new-password" placeholder="{{ __('Your password') }}">
                        </div>
                        <div style="margin-top: 14px;">
                            <label for="password_confirmation" class="block fs12 bold mb4 lblack">{{ __('Confirm password') }}</label>
                            <input type="password" class="styled-input" id="password_confirmation" autocomplete="new-password" placeholder="{{ __('Confirm your password') }}">
                        </div>

                        <p class="fs11 gray mb4 mt8">{{ __('Please remember this password because some actions require password to perform like changing password require your current password') }}</p>
                        <div id="set-first-password-button" class="typical-button-style flex align-center width-max-content">
                            <div class="relative size14 mr4">
                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"/><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"/></svg>
                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold fs12" style="margin-top: 1px">{{ __('Create password') }}</span>
                        </div>
                    </div>
                    @else
                    <!-- change password box -->
                    <div>
                        <p class="no-margin mb8 fs13 lblack lh15">{{ __('If you forgot your password, unfortunately you will not be able to change the password, because we do not have password reset functionality available at this moment. However you still be able to login using your :oauth_provider account', ['oauth_provider'=>$user->provider]) }}.</p>

                        <div class="section-style flex mb8">
                            <svg class="size14 mr8 mt2" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size14 mr8"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                            <p class="no-margin fs13 lblack lh15">{{ __("The reason we cannot restore forgotten password is because we are not currently using any email service to send email verification to account owner. We'll add this feature as soon as we can to make password reset much easier and secured") }}.</p>
                        </div>

                        <p class="no-margin mb8 fs12 lblack lh15"><strong>{{__('Your email')}} :</strong> {{ $user->email }}</p>
                        <h2 class="forum-color no-margin fs15">{{ __('Change Password') }}</h2>
                        <div style="margin-top: 12px;">
                            <label for="current-password" class="block fs12 bold mb4 lblack">{{ __('Current password') }}</label>
                            <input type="password" class="styled-input" id="current-password" autocomplete="new-password" placeholder="{{ __('Current password') }}">
                        </div>
                        <div style="margin-top: 12px;">
                            <label for="new-password" class="block fs12 bold mb4 lblack">{{ __('New password') }}</label>
                            <input type="password" class="styled-input" id="new-password" autocomplete="new-password" placeholder="{{ __('Enter your new password') }}">
                        </div>
                        <div style="margin-top: 12px;">
                            <label for="new-password-confirmation" class="block fs12 bold mb4 lblack">{{ __('Confirm new password') }}</label>
                            <input type="password" class="styled-input" id="new-password-confirmation" autocomplete="new-password" placeholder="{{ __('Confirm your new password') }}">
                        </div>

                        <div id="change-password-button" class="typical-button-style flex align-center width-max-content" style="margin-top: 12px;">
                            <div class="relative size14 mr4">
                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"/><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"/></svg>
                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold fs12" style="margin-top: 1px">{{ __('Change password') }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <div id="right-panel" class="pt8">
            @include('partials.settings.profile-right-side-menu', ['item'=>'settings-password'])
            <div class="ms-right-panel my8 toggle-box">
                <a href="" class="black-link bold blue toggle-container-button" style="margin-bottom: 12px; margin-top: 0">{{__('Password rules')}} <span class="toggle-arrow">▾</span></a>
                <div class="toggle-container ml8 block" style="max-width: 280px">
                    <p class="fs12 my8">• {{ __("Password must contains at least 8 characters") }}.</p>
                    <p class="fs12 my8">• {{ __("Password must contains at least one lowercase character") }}. (a - z)</p>
                    <p class="fs12 my8">• {{ __("Password must contains at least one uppercasecase character") }}. (A - Z)</p>
                    <p class="fs12 my8">• {{ __("Password must contains at least one digit") }}.</p>
                </div>
            </div>
        </div>
    </div>
@endsection