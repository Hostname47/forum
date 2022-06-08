@extends('layouts.app')

@section('content')
<div class="auth-card relative">
    <a href="/login" class="back-to-login link-style">{{ __('< Back to login') }}</a>
    <div>
        <a href="../"><img id="login-top-logo" class="move-to-middle" src="/assets/images/logos/b-large-logo.png" alt="logo"></a>
    </div>
    <h1>{{ __('Reset Password') }}</h1>
    @if (session('status'))    
        <div class="green-message-container">
            <p class="green-message">{{ session('status') }}</p>
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}" class="move-to-middle">
        @csrf

        <div class="input-container">
            <label for="email" class="label-style">{{ __('Email address') }} @error('email') <span class="error">*</span> @enderror</label>

            <input type="email" id="email" name="email" class="full-width input-style @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
            @error('email')
                <p class="error" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div class="input-container">
            <input type="submit" class="button-style block full-width" style="margin-bottom: 8px" value="{{ __('Send Password Reset Link') }}">
        </div>
    </form>
</div>
@endsection
