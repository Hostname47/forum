@extends('layouts.app')

@section('content')
    <div class="auth-card relative">
        <div style="margin-bottom: 8px">
            <a href="../"><img id="login-top-logo" class="move-to-middle" src="/assets/images/logos/b-large-logo.png" alt="logo"></a>
        </div>
        @if (session('status'))
            <div class="green-message-container">
                <p class="green-message">{{ session('status') }}</p>
            </div>
        @endif

        <h1>{{ __('Please check your email box for a verification link.') }}</h1>
        <p>Don't get a verification link? </p>
        <form method="POST" action="{{ route('verification.send') }}" class="move-to-middle">
            @csrf

            <input type="submit" class="button-style block full-width" style="margin-bottom: 8px" value="{{ __('Resend the verification link') }}">
        </form>
    </div>        
@endsection
