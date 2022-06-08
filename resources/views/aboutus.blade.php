@extends('layouts.app')

@section('title', 'About')

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
    @include('partials.left-panel', ['page' => 'about'])
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

        em:first-letter {
            margin-left: 10px;
        }
        .text {
            font-size: 15px;
            line-height: 1.8;
            margin: 0;
        }
        .bordered-guideline {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            background-color: #fbfbfb;
        }
        .table-left-grid {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
        }
        p {
            font-size: 15px;
        }
        #left-panel {
            width: 250px;
        }
    </style>
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path unselectable">{{ __('About Us') }}</span>
    </div>
    <div id="middle-padding">
        <div>
            @if(Session::has('message'))
                <div class="green-message-container full-width border-box flex align-center" style="margin-top: 16px">
                    <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:rgb(67, 172, 67)"/></svg>
                    <p class="green-message">{{ Session::get('message') }}</p>
                </div>
            @endif
            <div class="full-center move-to-middle">
                <svg class="size24 mr8 mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23.63 23.63"><path d="M11.81,0A11.82,11.82,0,1,0,23.63,11.81,11.81,11.81,0,0,0,11.81,0Zm2.46,18.31c-.61.24-1.09.42-1.45.54a3.81,3.81,0,0,1-1.27.19,2.49,2.49,0,0,1-1.71-.54,1.71,1.71,0,0,1-.61-1.36,4.87,4.87,0,0,1,0-.66,6.75,6.75,0,0,1,.15-.76L10.18,13c.07-.26.12-.5.17-.73a3,3,0,0,0,.07-.63,1,1,0,0,0-.21-.72,1.27,1.27,0,0,0-.82-.2,2.18,2.18,0,0,0-.6.09,4.61,4.61,0,0,0-.53.18l.2-.83c.5-.21,1-.38,1.43-.52a4.16,4.16,0,0,1,1.29-.22,2.46,2.46,0,0,1,1.69.53,1.74,1.74,0,0,1,.6,1.37c0,.12,0,.33,0,.62a3.75,3.75,0,0,1-.16.81l-.75,2.68a5.83,5.83,0,0,0-.17.74,3.61,3.61,0,0,0-.07.62.9.9,0,0,0,.24.73,1.29,1.29,0,0,0,.82.2,2.63,2.63,0,0,0,.63-.1,2.79,2.79,0,0,0,.5-.17ZM14.14,7.43a1.92,1.92,0,0,1-2.56,0,1.61,1.61,0,0,1,0-2.39,1.84,1.84,0,0,1,1.28-.5,1.81,1.81,0,0,1,1.28.5,1.61,1.61,0,0,1,0,2.39Z" style="fill:#030104"/></svg>
                <h1 id="cu-heading">{{__('ABOUT US')}}</h1>
            </div>
            <div class="flex justify-center">
                <em class="fs15 flex">{{ __("Together to take sports to the next level") }}</em>
            </div>
            <p class="text bordered-guideline text-center" style="margin: 20px 0 10px 0">
                {{ __("As part of seeking to rise and promote the educational sports in our arabic countries (Morocco in particular), we place among the dear members this forum to build a great and fantastic sports community with sublime goals and purposes") }}.
            </p>
            <h3 class="no-margin fs20 mb4" style='margin-top: 20px'>{{ __('OUR PURPOSE') }}</h3>
            <p class="text">{{ __("Everything in this forum is rooted to sport. Sport plays an increasingly important role in more and more people’s lives, on and off the field of play. It is central to every culture and society and is core to our health and happiness") }}.</p>
            <p class="text">{{ __("Our purpose, ‘through sport, we have the power to change lives’, guides the way we run this forum, how we interact, manage and engage with our members. We will always strive to expand the limits of human possibilities, to include and unite people in sport, and to create a more sustainable culture") }}.</p>
            <h3 class="no-margin fs20 mb4" style='margin-top: 20px'>{{ __('OUR MISSION') }}</h3>
            <p class="text">{{ __("Athletes do not settle for average. And neither do we. We have a clear mission: To be the best sports forum in the world. Every day, we come to work to add new features, and fix website bugs and problems, and to offer the best service and user experience – and to do it all in a sustainable way. We are the best when we are the credible, inclusive, and sustainable leader in our industry") }}.</p>
            <h3 class="no-margin fs20 mb4" style='margin-top: 20px'>{{ __('OUR ATTITUDE') }}</h3>
            <p class="text" style="margin-bottom: 20px">{{ __("We are rebellious optimists driven by action, with a desire to shape a better athletic culture. We see the world of sport and culture with possibility where others only see the impossible. ‘Impossible is Nothing’ is not a tagline for us. By being optimistic and knowing the power of sport, we see endless possibilities to apply this power and push all people forward with action") }}.</p>
        </div>
    </div>
@endsection