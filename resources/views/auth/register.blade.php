@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/auth/register.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/auth/register.js') }}" defer></script>
@endpush

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div id="typical-register-notice-viewer" class="global-viewer full-center none">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="viewer-box-style-1" style="margin-top: -26px; width: 486px;">
        <div class="full-center light-gray-border-bottom relative border-box" style="padding: 14px;">
            <div class="flex align-center mt2">
                <svg class="size14 mr4" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M113.53,3.53c-1.24-.19-2.69.41-3.77-.56a36.31,36.31,0,0,1-4.49-.34H92.81a17.18,17.18,0,0,1-3,.27c-.32,0-.63,0-1,0s-.61,0-.92,0h-.11c-4.53,1-9.1,1.81-13.51,3.17C34.79,18.27,11.43,44.89,4,85.59c-.1.55.09,1.25-.22,1.74a22.72,22.72,0,0,1-.21,2.32,24,24,0,0,1-.35,3c0,.61,0,1.23-.1,1.85V109c.25.9.47,1.83.65,2.79.93,2.27.88,4.78,1.39,7.13a96.65,96.65,0,0,0,99.7,76.58C152,193,190.75,156.11,195.5,109.25,200.76,57.4,165.14,11.5,113.53,3.53ZM99.16,171.46A72.36,72.36,0,1,1,172,99.28,72.42,72.42,0,0,1,99.16,171.46ZM111.68,81c0,5.89.06,11.78,0,17.67-.09,7.23-5.38,12.58-12.22,12.49-6.67-.09-11.83-5.42-11.87-12.47q-.09-17.67,0-35.35c0-7.24,5.34-12.56,12.21-12.47,6.68.09,11.79,5.4,11.88,12.45C111.74,69.21,111.68,75.11,111.68,81ZM99.79,147.33a12.05,12.05,0,1,1,11.88-12A12.16,12.16,0,0,1,99.79,147.33Z"/></svg>
                <span class="fs16 bold forum-color flex align-center">{{ __("Typical registration not allowed") }}</span>
            </div>
            <div class="pointer fs20 close-global-viewer unselectable absolute" style="right: 16px">✖</div>
        </div>
        <div class="full-center relative">
            <div class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 120px; max-height: 358px">
                <h3 class="fs14 lblack no-margin">{{__('Reason for not allowing typical registration')}}</h3>
                <p class="my8 fs13 lblack">{{ __("We are currently accept new users registration using their social accounts only to make sure we have verified emails to identify users") }}.</p>
                <p class="my8 fs13 lblack">{{ __("Typical registration actually works, but we don't have email verification service to verify emails. If we allow users to register using typical form, we'll end up with fake emails or impersonation issues.") }}</p>
                <p class="my8 fs13 lblack">{{ __("We will add this feature as soon as we can, by inform our users in announcements page") }}</p>

                <div class="red-section-style white-background flex">
                    <svg class="size14 mr4" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129,233.33h-108c-13.79,0-18.82-8.86-11.87-20.89q54-93.6,108.12-187.2c7.34-12.71,17.14-12.64,24.55.17,36,62.4,71.95,124.88,108.27,187.13,7.05,12.07-.9,21.28-12.37,21.06C201.43,232.88,165.21,233.33,129,233.33Zm91.36-24L129.4,51.8,38.5,209.3Zm-79-103.77c-.13-7.56-5.28-13-12-12.85s-11.77,5.58-11.82,13.1q-.13,20.58,0,41.18c.05,7.68,4.94,13,11.69,13.14,6.92.09,12-5.48,12.15-13.39.09-6.76,0-13.53,0-20.29C141.35,119.45,141.45,112.49,141.32,105.53Zm-.15,70.06a12.33,12.33,0,0,0-10.82-10.26,11.29,11.29,0,0,0-12,7.71,22.1,22.1,0,0,0,0,14A11.82,11.82,0,0,0,131.4,195c6.53-1.09,9.95-6.11,9.81-14.63A31.21,31.21,0,0,0,141.17,175.59Z"></path></svg>
                    <p class="no-margin fs13 lblack">{{ __("Please, notice that when you use one of your social accounts to login, we don't have your password or access to your account. We only get informations like your name, email and avatar.") }} <a href="{{ route('privacy') . '?move-to=data-we-collect' }}" target="_blank" class="link-path">{{ __('click here') }}</a> {{ __('to see more in privacy policy page') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="register-section" class="full-center">
    <div id="auth-viewer-box" class="viewer-box-style-1">
        <div class="flex align-center space-between">
            <div>
                <div class="flex align-center register-type-switch">
                    <svg class="size12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                    <span class="fs10 bold ml4 unselectable">{{ __('typical') }}</span>
                    <input type="hidden" class="register-type" value="typical" autocomple="off">
                </div>
                <div class="flex align-center mt4 register-type-switch register-type-switch-selected">
                    <svg class="size12 blue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M201.05,3.07c8.23,2.72,16.28,5.55,23,11.56,18.11,16.18,19.44,44.44,2.63,63.18-15.58,17.37-43.73,18.58-61,2.32-3.22-3-5.24-3.16-8.9-.81-12.46,8-25.25,15.52-37.83,23.35-2.31,1.44-3.62,1.53-4.7-1.19a24.77,24.77,0,0,0-2.4-4.25c-3.53-5.4-3.54-5.38,2.16-8.86,12.22-7.48,24.42-15,36.69-22.41,2-1.22,3.23-2.23,2.32-4.93-8.35-24.77,7.61-50.71,30.61-56.36.94-.23,2.38-.15,2.75-1.6Zm22.63,173.39c-18.11-15.47-41.43-15-58.9,1.2-2.5,2.31-4.1,2.5-6.93.7C147,171.46,136,164.82,125,158.12c-2.89-1.76-5.92-4.75-8.81-4.66-2.47.08-2.92,5-5,7.28-.11.12-.15.3-.27.41-2.76,2.69-2.35,4.38,1.1,6.42,12.77,7.52,25.29,15.47,38,23,2.84,1.7,3.94,3.2,2.65,6.51-2.57,6.57-2.39,13.51-1.28,20.28,3.49,21.33,24.74,38.21,45.44,36.42,24.16-2.08,42.07-21.18,41.82-44.6C238.39,196.12,233.64,185,223.68,176.46Zm-161-92c-24-.28-44.23,19.81-44.27,44a44.34,44.34,0,0,0,43.71,44.11c24,.28,44.22-19.81,44.27-44A44.36,44.36,0,0,0,62.68,84.43Z"></path></svg>
                    <span class="fs10 bold ml4 unselectable">{{ __('social') }}</span>
                    <input type="hidden" class="register-type" value="social" autocomple="off">
                </div>
            </div>
            <!-- logo -->
            <a href="{{ route('home') }}"><img id="login-top-logo" class="move-to-middle" src="{{ asset('assets/images/logos/header-logo.png') }}" alt="logo"></a>
            <!-- back to login page -->
            <a href="{{ route('login') }}" class="link-style flex align-center mb4">
                <svg class="mr4 size12" fill="#2ca0ff" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M31.7,239l136-136a23.9,23.9,0,0,1,33.8-.1l.1.1,22.6,22.6a23.91,23.91,0,0,1,.1,33.8l-.1.1L127.9,256l96.4,96.4a23.91,23.91,0,0,1,.1,33.8l-.1.1L201.7,409a23.9,23.9,0,0,1-33.8.1l-.1-.1L31.8,273a23.93,23.93,0,0,1-.26-33.84l.16-.16Z"/></svg>
                <span class="bold blue fs12">{{ __('Login') }}</span>
            </a>
        </div>
        <h1 class="forum-color fs15">{{ __('SIGNUP') }}</h1>
        <div id="social-register-box">
            <div class="section-style my8">
                <p class="fs12 text-center bold lblack lh15 no-margin">{{ __('In order to prevent abuse we require users to sign up using social login') }}</p>
            </div>
            <div>
                <a href="{{ url('/login/google') }}" class="my8 google-auth-button btn-style full-width full-center">
                    <svg class="size14 mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M113.47,309.41,95.65,375.94l-65.14,1.38a256.46,256.46,0,0,1-1.89-239h0l58,10.63L112,206.54a152.85,152.85,0,0,0,1.44,102.87Z" style="fill:#fbbb00"/><path d="M507.53,208.18a255.93,255.93,0,0,1-91.26,247.46l0,0-73-3.72-10.34-64.54a152.55,152.55,0,0,0,65.65-77.91H261.63V208.18h245.9Z" style="fill:#518ef8"/><path d="M416.25,455.62l0,0A256.09,256.09,0,0,1,30.51,377.32l83-67.91a152.25,152.25,0,0,0,219.4,77.95Z" style="fill:#28b446"/><path d="M419.4,58.94l-82.93,67.89A152.23,152.23,0,0,0,112,206.54l-83.4-68.27h0A256,256,0,0,1,419.4,58.94Z" style="fill:#f14336"/></svg>
                    <span class="fs13 lblack bold">Google</span>
                </a>
                <a href="{{ url('/login/facebook') }}" class="facebook-auth-button btn-style full-width full-center">
                    <svg class="size14 mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M456.25,1H54.75A54.75,54.75,0,0,0,0,55.75v401.5A54.75,54.75,0,0,0,54.75,512H211.3V338.27H139.44V256.5H211.3V194.18c0-70.89,42.2-110,106.84-110,31,0,63.33,5.52,63.33,5.52v69.58H345.8c-35.14,0-46.1,21.81-46.1,44.17v53.1h78.45L365.6,338.27H299.7V512H456.25A54.75,54.75,0,0,0,511,457.25V55.75A54.75,54.75,0,0,0,456.25,1Z" style="fill:#fff"/></svg>
                    <span class="fs13 bold white">Facebook</span>
                </a>
                <!-- <a href="{{ url('/login/twitter') }}" class="my8 twitter-auth-button btn-style full-width full-center">
                    <img src="{{ asset('assets/images/icons/twitter.png') }}" class="small-image auth-buton-left-icon mx8"/>
                    Twitter
                </a> -->
            </div>
        </div>
        <div id="typical-register-box" class="none">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="flex">
                    <div class="half-width mr8">
                        <label for="firstname" class="fs12 lblack flex mb2">{{ __('Firstname') }} @error('firstname') <span class="error">*</span> @enderror</label>
                        <input id="firstname" type="text" class="styled-input @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="given-name" autofocus placeholder="Firstname">
                    </div>
                    <div class="half-width">
                        <label for="lastname" class="fs12 lblack flex mb2">{{ __('Lastname') }} @error('lastname') <span class="error">*</span> @enderror</label>
                        <input id="lastname" type="text" class="styled-input @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="family-name" autofocus placeholder="Lastname">
                    </div>
                </div>

                <div class="my8">
                    <label for="username" class="fs12 lblack flex mb2">{{ __('Username') }} @error('username') <span class="error">*</span> @enderror</label>
                    <input id="username" type="text" class="styled-input full-width @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="name" autofocus placeholder="Username">
                </div>

                <div class="my8">
                    <label for="email" class="fs12 lblack flex mb2">{{ __('Email address') }} @error('email') <span class="error">*</span> @enderror</label>
                    <input type="email" id="email" name="email" class="styled-input full-width @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
                </div>

                <div class="my8">
                    <label for="password" class="fs12 lblack flex mb2">{{ __('Password') }}</label>
                    <input type="password" id="password" name="password" class="styled-input full-width" required placeholder="{{ __('Password') }}" autocomplete="current-password">
                </div>

                <div class="my8">
                    <label for="password-confirm" class="fs12 lblack flex mb2">{{ __('Confirm your password') }} </label>
                    <input type="password" id="password-confirm" name="password_confirmation" class="styled-input full-width" required placeholder="{{ __('Re-enter password') }}">
                </div>
                
                <!-- <button type="submit" class="typical-button-style disabled-typical-button-style full-width cursor-not-allowed"> -->
                <div class="section-style flex my8">
                    <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129,233.33h-108c-13.79,0-18.82-8.86-11.87-20.89q54-93.6,108.12-187.2c7.34-12.71,17.14-12.64,24.55.17,36,62.4,71.95,124.88,108.27,187.13,7.05,12.07-.9,21.28-12.37,21.06C201.43,232.88,165.21,233.33,129,233.33Zm91.36-24L129.4,51.8,38.5,209.3Zm-79-103.77c-.13-7.56-5.28-13-12-12.85s-11.77,5.58-11.82,13.1q-.13,20.58,0,41.18c.05,7.68,4.94,13,11.69,13.14,6.92.09,12-5.48,12.15-13.39.09-6.76,0-13.53,0-20.29C141.35,119.45,141.45,112.49,141.32,105.53Zm-.15,70.06a12.33,12.33,0,0,0-10.82-10.26,11.29,11.29,0,0,0-12,7.71,22.1,22.1,0,0,0,0,14A11.82,11.82,0,0,0,131.4,195c6.53-1.09,9.95-6.11,9.81-14.63A31.21,31.21,0,0,0,141.17,175.59Z"></path></svg>
                    <p class="no-margin lblack fs12">{{ __('We cannot register users using typical registration form for couple of reasons.') }} <span class="bold blue pointer open-typical-register-notice-viewer">{{ __('click here') }}</span> {{ __('to see more') }}</p>
                </div>
                <div class="typical-button-style disabled-typical-button-style full-width full-center" style="cursor: not-allowed !important;">
                    <span class="fs12 bold white" style="font-family: arial;">{{ __('Register') }}</span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
