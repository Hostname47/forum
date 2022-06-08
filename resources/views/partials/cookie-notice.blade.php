<div class="cookie-notice-box none opacity0">
    <style>
        .cookie-notice-box {
            position: fixed;
            bottom: 0;
            left: 0;
            display: flex;
            align-items: center;
            width: 100%;
            box-sizing: border-box;
            background-color: #111;
            color: #f0f0f0;
            padding: 12px;
        }
        
        .nohover {
            background-color: white;
        }
    </style>
    <div class="full-width p8">
        <div class="flex align-center space-between">
            <p class="bold fs20 no-margin mt4 mb8">{{ __('Notice') }}</p>
            <div class="close-button-style-1 unselectable close-cookie-notice-and-save" style="background-color: unset; font-size: 18px;">✖</div>
        </div>
        <div class="flex align-end space-between">
            <div style="margin-right: 42px">
                <p class="fs13 my4">{{ __('This website or its third party tools use cookies, which are neccessary for its functioning and required to achieve the purposes illustrated in the') }} <a href="{{ route('privacy') }}" class="blue bold no-underline">{{ __('privacy policy') }}</a> {{ __('page') }}.</p>
                <p class="fs13 my4">{{ __("We use cookies to provide you with the best possible experience. They also allow us to analyze user behavior in order to constantly improve the website for you. You accept the use of cookies by closing, canceling or dismissing this notice") }}.</p>
            </div>
            <div class="flex align-center mr8">
                <div class="pointer white fs13 bold close-cookie-notice-and-save" style="margin-right: 12px">{{ __('Cancel') }}</div>
                <input type="button" class="button-style close-cookie-notice-and-save" style="background-color: white; color: black;" value="{{ __('Accept cookies') }}">
            </div>
        </div>
    </div>
</div>