@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'home'])
    <div class="full-center" style="height: 460px">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <svg style="height: 80px; width: 80px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M136,271a45,45,0,0,0-15,87.42V421h30V358.42A45,45,0,0,0,136,271Zm0,60a15,15,0,1,1,15-15A15,15,0,0,1,136,331Zm272.58,30a45,45,0,1,0,0-30H256V301H367.21l34.4-34.4a45,45,0,1,0-21.21-21.21L354.79,271H256V181H376V91H256V0H16V512H256V422h98.79l25.61,25.61a45,45,0,1,0,21.21-21.21L367.21,392H256V361ZM451,331a15,15,0,1,1-15,15A15,15,0,0,1,451,331ZM421,211a15,15,0,1,1-15,15A15,15,0,0,1,421,211Zm0,241a15,15,0,1,1-15,15A15,15,0,0,1,421,452ZM346,151H179.32L175,158.49a45,45,0,1,1,0-45l4.33,7.49H346ZM46,482V30H226V91H196a75,75,0,1,0,0,90h30V482Z"/></svg>
            <h1 class="fs26 no-margin my8">{{__('This account is currently deactivated')}}</h1>
            <p class="fs15 no-margin gray">{{ __('Every activity of this user is hidden from public access') }}</p>
        </div>
    </div>
@endsection