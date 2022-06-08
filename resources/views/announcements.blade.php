@extends('layouts.app')

@section('title', 'Announcements')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    @include('partials.header', ['globalpage'=>'announcements'])
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'announcements'])
    <style>
        #middle-padding {
            padding: 0px 46px 16px 46px;
        }
        #heading {
            color: #1e2027;
            letter-spacing: 5px;
            margin: 10px 0;
        }
    </style>
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path unselectable">{{ __('Announcements') }}</span>
    </div>
    <div id="middle-padding">
        <div>
            <div class="flex align-center">
                <svg class="size28 mr8 mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M497,241H452a15,15,0,0,0,0,30h45a15,15,0,0,0,0-30Zm-19.39,94.39-30-30a15,15,0,0,0-21.22,21.22l30,30a15,15,0,0,0,21.22-21.22Zm0-180a15,15,0,0,0-21.22,0l-30,30a15,15,0,0,0,21.22,21.22l30-30A15,15,0,0,0,477.61,155.39ZM347,61a45.08,45.08,0,0,0-44.5,38.28L288.82,113C265,136.78,229.93,151,195,151H105a45.06,45.06,0,0,0-42.42,30H60a60,60,0,0,0,0,120h2.58A45.25,45.25,0,0,0,90,328.42V406a45,45,0,0,0,90,0V331h15c34.93,0,70,14.22,93.82,38l13.68,13.69A45,45,0,0,0,392,376V106A45.05,45.05,0,0,0,347,61ZM60,271a30,30,0,0,1,0-60Zm90,135a15,15,0,0,1-30,0V331h30Zm30-105H105a15,15,0,0,1-15-15V196a15,15,0,0,1,15-15h75Zm122,39.35c-25.34-21.94-57.92-35.56-92.1-38.67V180.32c34.18-3.11,66.76-16.73,92.1-38.67ZM362,376a15,15,0,0,1-15,15h0a15,15,0,0,1-15-15V106a15,15,0,0,1,30,0Z"/></svg>
                <h1 id="heading">{{__('Announcements')}}</h1>
            </div>
            <div>
                @foreach($announcements as $announcement)
                    <x-thread.announcement :announcement="$announcement"/>
                @endforeach
            </div>
            <div class="flex my8">
                <div class="move-to-right">
                    {{ $announcements->onEachSide(0)->links() }}
                </div>
            </div>
        </div>
    </div>
    <div id="right-panel">
        <x-right-panels.forumslist/>
        @include('partials.right-panels.statistics')
    </div>
@endsection