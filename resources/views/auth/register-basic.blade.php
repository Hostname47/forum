@extends('layouts.app')

<style>
    #avatar-preview {
        margin: 8px 0;
        width: 260px;
        height: 260px;

        background-color: gray;
    }

    .auth-card {
        border: 1px solid #d7d7d7;
    }
</style>

@section('content')
    <div class="auth-card relative">
        <a href="/login" class="back-to-login link-style">{{ __('< Back to login') }}</a>
        <div>
            <a href="../"><img id="login-top-logo" class="move-to-middle" src="/assets/images/logos/b-large-logo.png" alt="logo"></a>
        </div>
        <h1>{{ __('Register') }}</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-container">
                <label for="firstname" class="label-style">{{ __('Firstname') }} @error('firstname') <span class="error">*</span> @enderror</label>

                <input id="firstname" type="text" class="full-width input-style @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="given-name" autofocus placeholder="Firstname">
                @error('firstname')
                    <p class="error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-container">
                <label for="lastname" class="label-style">{{ __('Lastname') }} @error('lastname') <span class="error">*</span> @enderror</label>

                <input id="lastname" type="text" class="full-width input-style @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="family-name" autofocus placeholder="Lastname">
                @error('lastname')
                    <p class="error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-container">
                <label for="username" class="label-style">{{ __('Username') }} @error('username') <span class="error">*</span> @enderror</label>

                <input id="username" type="text" class="full-width @error('username') is-invalid @enderror input-style" name="username" value="{{ old('username') }}" required autocomplete="name" autofocus placeholder="Username">
                @error('username')
                    <p class="error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-container">
                <label for="email" class="label-style">{{ __('Email address') }} @error('email') <span class="error">*</span> @enderror</label>

                <input type="email" id="email" name="email" class="full-width input-style @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
                @error('email')
                    <p class="error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-container">
                <label for="password" class="label-style">{{ __('Password') }} </label>

                <input type="password" id="password" name="password" class="full-width input-style" required placeholder="{{ __('Password') }}" autocomplete="current-password">
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-container">
                <label for="password-confirm" class="label-style">{{ __('Confirm your password') }} </label>

                <input type="password" id="password-confirm" name="password_confirmation" class="full-width input-style" required placeholder="{{ __('Re-enter password') }}">
                @error('password-confirm')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <input type="submit" class="button-style block full-width" style="margin-bottom: 8px" value="{{ __('Register') }}">
        </form>
    </div>
@endsection
