@extends('layouts.admin')

@section('title', 'Admin - Threads Reportings')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.manage.users', 'subpage'=>'admin.manage.users.dashboard'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/search.js') }}" defer></script>
@endpush

@push('scripts')
<link rel="stylesheet" href="{{ asset('css/admin/user.css') }}">
@endpush

@section('content')
    <div id="admin-main-content-box">
        <div class="flex space-between">
            <div class="flex align-center mb8">
                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                <h1 class="fs22 no-margin lblack">{{ __('Users management - Dashboard') }}</h1>
            </div>
            <div class="flex align-center height-max-content">
                <div class="flex align-center">
                    <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                    <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
                </div>
                <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                <div class="flex align-center">
                    <span class="fs13 bold">{{ __('User Management') }}</span>
                </div>
            </div>
        </div>
        <div>
            <p class="my4 fs13 lblack">Search for users to manage</p>
            <div class="relative search-box" style="min-width: 490px; width: 490px;">
                <svg class="sfui-icon size14" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                <input type="text" name="k" value="{{ request()->get('k') }}" class="search-for-users-input full-width" autocomplete="off" placeholder="search for users by username">
                <div class="isearch-button search-for-users-button">
                    <span style="margin-top: -2px" class="block">search</span>
                </div>
                <div class="search-result-container none scrolly">
                    <a href="{{ route('admin.user.manage') }}" class="no-underline us-usermanage-link search-user-record search-user-record-skeleton none flex">
                        <div class="flex">
                            <img src="" class="us-avatar size28 mr8 br4" alt="">
                            <div class="">
                                <span class="us-fullname block blue bold fs15" style="margin-top: -2px">Mouad Nassri</span>
                                <span class="us-username block bold gray fs12">Hostname47</span>
                            </div>
                        </div>
                    </a>
                    <div class="result-box">

                    </div>
                    <div class="flex search-result-faded none">
                        <div class="relative br4 mr8 size28 hidden-overflow">
                            <div class="fade-loading"></div>
                        </div>
                        <div>
                            <div class="relative br3 hidden-overflow" style="height: 15px; width: 160px; margin-bottom: 2px">
                                <div class="fade-loading"></div>
                            </div>
                            <div class="relative br3 hidden-overflow" style="height: 12px; width: 60px">
                                <div class="fade-loading"></div>
                            </div>
                        </div>
                    </div>
                    <div class="full-center search-no-results none">
                        <p class="bold">no results for your search query</p>
                    </div>
                </div>
            </div>
        </div>
        <div>
            
        </div>
    </div>
@endsection