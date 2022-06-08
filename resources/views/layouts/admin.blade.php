<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ URL::asset('assets/images/logos/IC.png') }}" type="image/x-icon"/>

    <title>@yield('title', 'Moroccan Gladiator')</title>
    
    @auth
    <link rel="preload" as="image" href="{{ auth()->user()->sizedavatar(100, '-h') }}">
    @endauth
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script type="text/javascript" src="{{ asset('js/imagesloaded.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/core.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/admin/core.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    @stack('styles')
    @stack('scripts')
</head>
<body>
    <div id="app">
        <input type="hidden" class="uid" autocomplete="off" value="@auth{{ auth()->user()->id }}@endauth">
        <main class="relative">
            @yield('left-panel')
            <div class="flex relative">
                <div id="admin-content-box" class="relative">
                    @yield('content')  
                </div>
            </div>
        </main>
        @include('partials.shared-components')
    </div>
</body>
</html>