
<div id="login-viewer" class="global-viewer full-center @if(!Session::has('auth-error')) none @endif" style="z-index: 66666">
    <div class="close-button-style-1 close-global-viewer unselectable" style="right: 28px; top: 26px;">✖</div>
    <div id="auth-viewer-box" class="viewer-box-style-1">
        @include('partials.auth.login-form')
    </div>
</div>