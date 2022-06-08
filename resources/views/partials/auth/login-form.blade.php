<div>
    <img id="login-top-logo" class="move-to-middle" src="{{ asset('assets/images/logos/header-logo.png') }}" load="lazy" alt="logo">
</div>
<h1 class="forum-color fs20 mb8">{{ __('Login') }}</h1>
<form method="POST" action="{{ route('login') }}" autocomplete="off" class="move-to-middle">
    @csrf
    <div class="input-container">
        @error('email')
            <div class="red-section-style my4 flex">
                <svg class="size14 mr8" style="min-width: 14px;" fill="rgb(68, 5, 5)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                <p class="fs12 dark-red no-margin">{{ $message }}</p>
            </div>
        @enderror
        <label for="email" class="flex fs12 lblack mb4">{{ __('Email address / Username') }}</label>
        <input type="text" id="email" name="email" class="full-width styled-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="false" placeholder="{{ __('Email address') }}">
    </div>

    <div class="input-container">
        <label for="password" class="flex fs12 lblack mb4">{{ __('Password') }} </label>
        <input type="password" id="password" name="password" class="full-width styled-input" required placeholder="{{ __('Password') }}" autocomplete="false">
    </div>
    
    <div class="input-container flex align-center">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="flex bold fs12 lblack ml4" for="remember">{{ __('Remember Me') }}</label>
    </div>

    <div class="input-container">
        <button type="submit" class="typical-button-style block full-width" style="margin-bottom: 8px; padding: 12px;">
            <span class="fs12 bold white" style="font-family: arial;">{{ __('Login') }}</span>
        </button>
        @if (Route::has('password.request'))
            <a class="link-style" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif
    </div>
</form>
<div class="line-separator"></div>
<div>
    <div class="my8 flex">
        <a href="{{ url('/login/google') }}" class="google-auth-button btn-style fs12 half-width full-center mr4">
            <svg class="size16 auth-buton-left-icon mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M113.47,309.41,95.65,375.94l-65.14,1.38a256.46,256.46,0,0,1-1.89-239h0l58,10.63L112,206.54a152.85,152.85,0,0,0,1.44,102.87Z" style="fill:#fbbb00"/><path d="M507.53,208.18a255.93,255.93,0,0,1-91.26,247.46l0,0-73-3.72-10.34-64.54a152.55,152.55,0,0,0,65.65-77.91H261.63V208.18h245.9Z" style="fill:#518ef8"/><path d="M416.25,455.62l0,0A256.09,256.09,0,0,1,30.51,377.32l83-67.91a152.25,152.25,0,0,0,219.4,77.95Z" style="fill:#28b446"/><path d="M419.4,58.94l-82.93,67.89A152.23,152.23,0,0,0,112,206.54l-83.4-68.27h0A256,256,0,0,1,419.4,58.94Z" style="fill:#f14336"/></svg>
            Google
        </a>
        <a href="{{ url('/login/facebook') }}" class="facebook-auth-button btn-style fs12 half-width full-center ml4">
            <svg class="size16 auth-buton-left-icon mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M456.25,1H54.75A54.75,54.75,0,0,0,0,55.75v401.5A54.75,54.75,0,0,0,54.75,512H211.3V338.27H139.44V256.5H211.3V194.18c0-70.89,42.2-110,106.84-110,31,0,63.33,5.52,63.33,5.52v69.58H345.8c-35.14,0-46.1,21.81-46.1,44.17v53.1h78.45L365.6,338.27H299.7V512H456.25A54.75,54.75,0,0,0,511,457.25V55.75A54.75,54.75,0,0,0,456.25,1Z" style="fill:#fff"/></svg>
            Facebook
        </a>
    </div>
    <!-- <a href="{{ url('/login/twitter') }}" class="twitter-auth-button btn-style full-width full-center ">
        <img src="{{ asset('assets/images/icons/twitter.png') }}" class="small-image auth-buton-left-icon mx8"/>
        Twitter
    </a> -->
</div>
<div class="line-separator"></div>
<div>
    <div class="flex">
        <span class="fs12 lblack">{{ __('Not a member') }}?</span>
        <a href="{{ route('register') }}" class="fs12 bold link-style no-underline ml4">{{ __('Signup now') }}</a>
    </div>
</div>