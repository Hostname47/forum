@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
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
        <input type="hidden" class="password-required-error-message" value="{{ __('Password field is required') }}" autocomplete="off">
        <section class="flex">
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page' => 'settings'])
                <div class="mb4" style="margin-top: 16px">
                    <h1 class="no-margin lblack fs19">{{__('Account settings')}}</h1>
                    <p class="no-margin lblack mb8 fs12 lh15"><strong>{{ __('Your email') }} :</strong> {{ $user->email }}</p>
                </div>

                @if($banned)
                <div class="red-section-style my8">
                    <div class="flex">
                        <svg class="size15 mr4" style="min-width: 15px;" fill="rgb(68, 5, 5)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M133.28,5.08h5.82c9.12,3.68,11.64,7.49,11.63,17.56q0,41.69,0,83.36a33.18,33.18,0,0,0,.09,4.35c.31,2.52,1.7,4.18,4.37,4.33,2.94.17,4.49-1.56,5-4.22a23.31,23.31,0,0,0,.13-4.35q0-37.8,0-75.6c0-9.49,5.91-15.89,14.48-15.79,8.25.09,14.27,6.68,14.25,15.71q-.06,42.41-.18,84.8a27.74,27.74,0,0,0,.18,4.83c.48,2.7,2.11,4.43,5,4.2,2.58-.2,4-1.82,4.27-4.43.08-.8.07-1.61.07-2.42q0-28.35-.08-56.7c0-4.12.44-8.06,2.94-11.5A14.34,14.34,0,0,1,217.17,44c6.35,2,10.1,7.94,10.09,16q-.06,61.06-.12,122.13a121.16,121.16,0,0,1-.74,13c-3.19,28.63-19.47,47.82-47.27,55.18-16.37,4.33-33,3.7-49.46.47-20-3.93-36.55-13.65-48.09-30.64-15.76-23.21-31-46.74-46.51-70.16a20.9,20.9,0,0,1-2.13-4.32c-4.68-12.84,4.91-25.12,18.14-23.18,5.55.81,9.81,3.87,13.1,8.36,6.31,8.63,12.63,17.25,19.68,26.87,0-16.64,0-31.95,0-47.25q0-35.13,0-70.27c0-7.58,3.18-12.62,9.24-15,10.31-4,19.76,3.91,19.66,16.09-.19,22.29-.11,44.58-.16,66.87,0,3.33.51,6.46,4.68,6.48s4.75-3.09,4.75-6.42c0-28.11.2-56.22-.13-84.33C121.79,14.87,124.51,8.36,133.28,5.08Z"/></svg>
                        <div>
                            <p class="no-margin fs14 dark-red bold">{{ __('Your account has been banned temporarily') }}.</p>
                            <p class="no-margin fs12 dark-red mt4"><strong>{{ __('Reason') }}</strong> : {{ $banreason }}</p>
                            <div class="flex align-center">
                                <p class="no-margin fs12 dark-red mt4"><strong>{{ __('Ban duration') }}</strong> : {{ $banduration }}</p>
                                <div class="gray height-max-content mx8 fs10">•</div>
                                <p class="no-margin fs12 dark-red mt4"><strong>{{ __('Ban starts') }}</strong> : {{ $ban->bandate }}</p>
                            </div>
                            <p class="no-margin fs12 dark-red mt4"><strong>{{ __('Time remaining') }}</strong> : {{ $timeremaining }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if(Session::has('error'))
                <div class="error-container">
                    <p class="error-message">{{ Session::get('error') }}</p>
                </div>
                @endif
                @if(Session::has('message'))
                    <div class="green-message-container">
                        <p class="green-message">{{ Session::get('message') }}</p>
                    </div>
                @endif
                @if($errors->any())
                <div class="error-container">
                    <p class="error-message">{{$errors->first()}}</p>
                </div>
                @endif

                <!-- Deactivating account -->
                <div id="account-deactivation-box" class="my8">
                    <div class="flex align-center" style="margin-top: 16px">
                        <svg class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                        <h2 class="fs15 no-margin lblack">{{__('Account deactivation')}}</h2>
                    </div>
                    <div class="red-section-style flex align-center error-container none my8">
                        <svg class="size14 mr8" style="min-width: 14px; fill: rgb(68, 5, 5);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size14 mr8"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                        <p class="no-margin fs12 bold dark-red error-text"></p>
                    </div>
                    <p class="my8 fs13 lh15">{{ __("By deactivating your account, all your posts and activities will be hidden from public, and you (and anyone else) will not be able to access your account until you activate it again") }}.</p>
                    @if(is_null($user->password))
                    <div class="section-style flex my8">
                        <svg class="size14 mt2 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size14 mr8"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                        <p class="no-margin fs12 lh15">{{ __("Deactivating account require your account to have an associated password to confirm and make sure you are the one who take this action") }}. <a href="{{ route('user.passwords.settings') }}" class="blue bold fs12 no-underline">{{ __('Click here') }}</a> {{ __('to create a password for your account') }}</p>
                    </div>
                    @else
                    <div id="deactivate-account-container">
                        <div style="margin-top: 14px;">
                            <label for="deactivate-password" class="block fs12 bold mb4 lblack">{{ __('Current password') }}</label>
                            <input type="password" class="styled-input" id="deactivate-password" autocomplete="new-password" placeholder="{{ __('Your current password') }}">
                        </div>
                        <!-- confirmation -->
                        <div style="margin-top: 12px;">
                            <label for="deactivate-account-confirm-input" class="block fs13 mb4 bold forum-color">{{__('Confirmation')}}</label>
                            <p class="no-margin mb4 fs13 lblack">{{__('Please type')}} <strong>{{ auth()->user()->username }}::{{ __('deactivate-account') }}</strong> {{__('to confirm')}}.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width input-style-1" id="deactivate-account-confirm-input" style="padding: 8px 10px" placeholder="{{__('confirmation')}}">
                                <input type="hidden" id="deactivate-account-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::{{ __('deactivate-account') }}">
                            </div>
                        </div>

                        <div id="deactivate-account-button" class="typical-button-style disabled-typical-button-style flex align-center width-max-content mt8">
                            <div class="relative size14 mr4">
                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold fs12 unselectable" style="margin-top: 1px">{{ __('Deactivate account') }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Delete account -->
                <div class="simple-line-separator" style="margin: 14px 20px"></div>
                <div id="account-deletion-box" class="my8">
                    <div class="flex align-center" style="margin-top: 16px">
                        <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"></path></svg>
                        <h2 class="fs15 no-margin lblack">{{__('Account deletion')}}</h2>
                    </div>
                    <div class="red-section-style flex align-center error-container none my8">
                        <svg class="size14 mr8" style="min-width: 14px; fill: rgb(68, 5, 5);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size14 mr8"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                        <p class="no-margin fs12 bold dark-red error-text"></p>
                    </div>
                    <div class="my8 section-style white-background">
                        <div class="flex">
                            <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="no-margin bold lblack fs12">{{ __("This will permanently, irreversibly remove content from your account and close it permanently") }}.</p>
                        </div>
                        <p class="no-margin lblack fs12 mt8">{{ __("Once the account is deleted, all your posts, replies and activities will be removed from our system permanently. Your username will remain reserved to prevent future impersonations") }}.</p>
                    </div>
                    @if(is_null($user->password))
                    <div class="section-style flex my8">
                        <svg class="size14 mt2 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size14 mr8"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                        <p class="no-margin fs12 lh15">{{ __("Deleting account require your account to have an associated password to confirm and make sure you are the one who take this action") }}. <a href="{{ route('user.passwords.settings') }}" class="blue bold fs12 no-underline">{{ __('Click here') }}</a> {{ __('to create a password for your account') }}</p>
                    </div>
                    @else
                    <div id="delete-account-container">
                        <p class="no-margin mb4 fs13">{{ __("Please make sure you want to delete your account by confirming your password") }}.</p>
                        <div style="margin-top: 14px;">
                            <label for="delete-account-password" class="block fs12 bold mb4 lblack">{{ __('Current password') }}</label>
                            <input type="password" class="styled-input" id="delete-account-password" autocomplete="new-password" placeholder="{{ __('Your current password') }}">
                        </div>
                        <!-- confirmation -->
                        <div style="margin-top: 12px;">
                            <label for="delete-account-confirm-input" class="block fs13 mb4 bold forum-color">{{__('Confirmation')}}</label>
                            <p class="no-margin mb4 fs13 lblack">{{__('Please type')}} <strong>{{ auth()->user()->username }}::{{ __('delete-my-account') }}</strong> {{__('to confirm')}}.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width input-style-1" id="delete-account-confirm-input" style="padding: 8px 10px" placeholder="{{__('confirmation')}}">
                                <input type="hidden" id="delete-account-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::{{ __('delete-my-account') }}">
                            </div>
                        </div>

                        <div id="delete-account-button" class="red-button-style disabled-red-button-style flex align-center width-max-content mt8">
                            <div class="relative size14 mr4">
                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"></path></svg>
                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold fs12 unselectable" style="margin-top: 1px">{{ __('Delete account') }}</span>
                            <input type="hidden" class="success-message" value="{{ __('Your account has been deleted successfully') }}" autocomplete="off">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <div id="right-panel" class="pt8">
            @include('partials.settings.profile-right-side-menu', ['item'=>'user-account-settings'])
            <div class="ms-right-panel my8 toggle-box">
                <a href="" class="black-link bold blue toggle-container-button" style="margin-bottom: 12px; margin-top: 0">{{__('Account deletion')}} <span class="toggle-arrow">▾</span></a>
                <div class="toggle-container ml8 block" style="max-width: 280px">
                    <p class="fs12 my8">• {{ __("Your password must be set If you want to deactivate or delete your account") }}.</p>
                    <p class="fs12 my8">• {{ __("If you delete your account all your posts and activities will be deleted as well") }}.</p>
                    <p class="fs12 my8">• {{ __("You could just deactivate you account. All your data and activities will be hidden from public") }}.</p>
                </div>
            </div>
        </div>
    </div>
@endsection