@extends('layouts.app')

@section('content')
<div class="auth-card relative">
    <a href="/login" class="back-to-login link-style">{{ __('< Back to login') }}</a>
    <div>
        <a href="../"><img id="login-top-logo" class="move-to-middle" src="/assets/images/logos/b-large-logo.png" alt="logo"></a>
    </div>
    <h1>{{ __('Update your password') }}</h1>
    <form method="POST" action="{{ route('password.update') }}" class="move-to-middle">
        @csrf

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div class="input-container">
            <label for="email" class="label-style">{{ __('Email address') }} @error('email') <span class="error">*</span> @enderror</label>

            <input type="email" id="email" name="email" class="full-width input-style @error('email') is-invalid @enderror" value="{{ request()->get('email') ?? old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
            @error('email')
                <p class="error" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div class="input-container">
            <label for="password" class="label-style">{{ __('Password') }} </label>

            <input type="password" id="password" name="password" class="full-width input-style" required placeholder="{{ __('Password') }}" autocomplete="new-password">
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="input-container">
            <label for="password-confirm" class="label-style">{{ __('Confirm your password') }} </label>

            <input type="password" id="password-confirm" name="password_confirmation" class="full-width input-style" required placeholder="{{ __('Re-enter password') }}" autocomplete="new-password">
            @error('password-confirm')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="input-container">
            <input type="submit" class="button-style block full-width" style="margin-bottom: 8px" value="{{ __('Reset Password') }}">
        </div>
    </form>
</div>
@endsection
