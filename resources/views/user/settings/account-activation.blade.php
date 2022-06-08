@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
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
                <h1 class="no-margin" style="margin-top: 24px;">{{__('Account Management')}}</h1>
                <div class="mt4">
                    <h2 class="my8 fs14">{{ __("Your account is currently deactivated") }}.</h2>
                    <p class="my8 fs13 lh15">{{ __("Your account and all your resources and activities are hidden from public until you activate it again by clicking on activate account button down below") }}.</p>
                    <p class="my8 fs13 lh15">{{ __("All website pages will be blocked until you activate your account") }}.</p>

                    <div id="activate-account-button" class="green-button-style flex align-center width-max-content">
                        <div class="relative size14 mr4">
                            <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M143.07,255.58H115.63c-1.47-1.93-3.77-1.5-5.71-1.8A115.72,115.72,0,0,1,68.3,239c-34.6-20.48-56-50.43-61.72-90.34-6.69-47,8.7-86.63,45.66-116.2C89.37,2.76,131.66-3.41,176.08,13.73c38.41,14.82,63.1,43.15,75,82.64,2,6.63,2,13.66,4.7,20.07v28.42c-1.92.89-1.35,2.86-1.55,4.26A110.34,110.34,0,0,1,247,175.93q-23.64,57.1-82.86,74.95C157.2,253,149.88,253.09,143.07,255.58ZM130.61,32.19c-53.67-.25-97.8,43.5-98.28,97.44-.48,53.76,43.66,98.25,97.72,98.5,53.67.26,97.8-43.49,98.28-97.44C228.81,76.94,184.67,32.45,130.61,32.19Z"/><path d="M157.75,130.06a27.42,27.42,0,1,1-27.52-27.31A27.63,27.63,0,0,1,157.75,130.06Z"/></svg>
                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="bold fs12" style="margin-top: 1px">{{ __('Activate account') }}</span>
                    </div>
                </div>
            </div>
            <div>
                @include('partials.settings.profile-right-side-menu', ['item'=>'user-account-settings'])
                <div class="ms-right-panel my8 toggle-box">
                    <a href="" class="black-link bold blue toggle-container-button" style="margin-bottom: 12px; margin-top: 0">Account activation <span class="toggle-arrow">▾</span></a>
                    <div class="toggle-container ml8 block" style="max-width: 280px">
                        <p class="fs12 my8">• {{ __("You can't access any web page unless you activate your account") }}.</p>
                        <p class="fs12 my8">• {{ __("Activate your account to make it accessible to the public") }}.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection