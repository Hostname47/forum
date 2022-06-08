@extends('layouts.app')

@section('title', 'FAQs')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/faqs.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'faqs'])
    <style>
        .contactus-text {
            font-size: 13px;
            min-width: 300px;
            line-height: 1.7;
            letter-spacing: 1.4px;
            margin: 0 0 16px 0;
            color: #1e2027;
        }
        #cu-heading {
            color: #1e2027;
            letter-spacing: 5px;
            margin: 20px 0 14px 0;
        }
        #contact-us-form-wrapper {
            width: 70%;
            min-width: 320px;
        }
        #middle-padding {
            width: 74%;
            min-width: 300px;
            margin: 0 auto;
        }

        .text {
            font-size: 15px;
            line-height: 1.5;
            margin: 0;
        }

        #left-panel {
            width: 250px;
        }
        .qa-wrapper {
            background-color: #f0f6ffc2;
            border: 1px solid #d4deee;
            border-radius: 3px;
            margin-bottom: 8px;
        }

        .question-header {
            cursor: pointer;
            padding: 10px;
        }
        .qa-wrapper:hover {
            background-color: #ebf5ff;
        }
        .faq-answer {
            display: flex;
            padding: 0 10px 10px 10px;
            font-size: 15px;
            line-height: 1.5;
            margin: 0;
        }
    </style>
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path unselectable">{{__('FAQs')}}</span>
    </div>
    <div id="middle-padding">
        <!-- title -->
        <div class="full-center move-to-middle">
            <svg class="size28 mr8 mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M316,71a74.93,74.93,0,0,0-60,30.05,74.93,74.93,0,0,0-60-30H0V381H21v60H491V381h21V71ZM51,411V381H196a45.07,45.07,0,0,1,42.42,30Zm190-45a74.59,74.59,0,0,0-45-15H30V101H196a45.05,45.05,0,0,1,45,45ZM359,101h50V203.73l-25-12.5-25,12.5ZM461,411H273.58A45.06,45.06,0,0,1,316,381H461Zm21-60H316a74.59,74.59,0,0,0-45,15V146a45.05,45.05,0,0,1,45-45h13V252.27l55-27.5,55,27.5V101h43ZM139,139a45.05,45.05,0,0,0-45,45h30a15,15,0,1,1,15,15H124v50h30V226.43A45,45,0,0,0,139,139ZM124,279h30v30H124Z"/></svg>
            <h1 id="cu-heading">{{__('FAQs')}}</h1>
        </div>
        <div class="flex justify-center">
            <em class="fs16 bold flex">{{ __("Frequently Asked Questions") }}</em>
        </div>
        <div style="margin: 20px 0 10px 0;">
            <em class="fs15">{{ __("Below you’ll find answers to our most commonly asked questions. If you don’t find the answer you are looking for, you could ask a question using the form at the bottom") }}</em>
        </div>
        <!-- FAQs -->
        @if(Session::has('message'))
            <div class="green-message-container full-width border-box flex align-center" style="margin: 16px 0">
                <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:rgb(67, 172, 67)"/></svg>
                <p class="green-message">{{ Session::get('message') }}</p>
            </div>
        @endif
        <div class="flex align-end space-between" style="margin: 28px 0 10px 0">
            <h2 class="no-margin forum-color">{{ __('TOP FAQs') }}</h2>
            {{ $faqs->onEachSide(0)->links() }}
        </div>
        @foreach($faqs as $faq)
        <div class="qa-wrapper">
            <div class="flex align-center space-between question-header">
                <div class="flex align-center">
                    <svg class="size18 mr8 mt2" style="min-width: 20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119.08,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.88,199.88,0,0,1,256,456ZM363.24,200.8c0,67.05-72.42,68.08-72.42,92.86V300a12,12,0,0,1-12,12H233.18a12,12,0,0,1-12-12v-8.66c0-35.74,27.1-50,47.58-61.51,17.56-9.85,28.32-16.55,28.32-29.58,0-17.25-22-28.7-39.78-28.7-23.19,0-33.9,11-49,30a12,12,0,0,1-16.66,2.13l-27.83-21.1a12,12,0,0,1-2.64-16.37C184.85,131.49,214.94,112,261.79,112,310.86,112,363.24,150.3,363.24,200.8ZM298,368a42,42,0,1,1-42-42A42,42,0,0,1,298,368Z"/></svg>
                    <p class="no-margin fs16 bold unselectable">{{ __("$faq->question") }}</p>
                </div>
                <svg class="size12 ml4 mt2 faq-toggled-arrow" style='min-width: 12px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 350"><path d="M192,271.31l136-136a23.9,23.9,0,0,0,.1-33.8.94.94,0,0,1-.1-.1l-22.6-22.6a23.9,23.9,0,0,0-33.8-.1l-.1.1L175,175.11,78.6,78.7a23.91,23.91,0,0,0-33.8-.1l-.1.1L22,101.3a23.9,23.9,0,0,0-.1,33.8l.1.1,136,136a23.94,23.94,0,0,0,33.84.26l.16-.16Z"/></svg>
            </div>
            <div class="faq-answer none">
                <svg class="size12 mr8" style="min-width: 12px; margin-top: 6px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                <p class="text">{!! __($faq->answer) !!}</p>
            </div>
        </div>
        @endforeach
        <div class="simple-line-separator" style="margin: 26px 0;"></div>
        <!-- send a question -->
        <div>
            <p class="my8 fs18 bold">{{ __("Your question does not exist? Use the form below to ask your question") }}</p>
            <div style="width: 70%; min-width: 280px">
                <div class="my8 error-container faqs-error-container none">
                    <div class="flex">
                        <svg class="size14 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(68, 5, 5)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                        <span class="dark-red fs13 bold no-margin faqs-error"></span>
                    </div>
                </div>
                <div style="margin: 12px 0">
                    <input type="hidden" class="question-required" value="* {{ __('Question is required') }}">
                    <input type="hidden" class="question-length-error" value="* {{ __('Question must contain at least 10 characters') }}">
                    <label for="question" class="flex align-center bold forum-color mb4">{{ __('Question') }}<span class="error none fs12" style="font-weight: 400; margin: 0"></span></label>
                    <input type="text" id="question" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Your question") }}'>
                </div>
                <div class="input-container">
                    <span class="error frt-error"></span>
                    <label for="desc" class="flex align-center align-center bold forum-color mb4">{{ __('Description of your question') }} <span style="font-weight: 400; margin-left: 2px; font-size: 12px">({{__('optional')}})</span></label>
                    <div class="countable-textarea-container">
                        <textarea 
                            id="desc"
                            class="styled-textarea move-to-middle countable-textarea"
                            style="margin: 0; width: 100%"
                            maxlength="800"
                            spellcheck="false"
                            autocomplete="off"
                            form="profile-edit-form" 
                            placeholder="{{ __('More informations about your question') }}"></textarea>
                        <p class="block my4 mr4 unselectable fs12 gray textarea-counter-box move-to-right width-max-content"><span class="textarea-chars-counter">0</span>/800</p>
                        <input type="hidden" class="max-textarea-characters" value="800">
                    </div>
                </div>
                <div class="typical-button-style flex align-center width-max-content @auth faq-question-send @else login-signin-button @endauth" style="margin-bottom: 28px">
                    <div class="relative size14 mr4">
                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"></path></svg>
                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="bold fs12 unselectable" style="margin-top: 1px">{{ __('Submit Question') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection