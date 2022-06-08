<div class="signup-record-container">
    <div class="flex">
        <img src="{{ $user->sizedavatar(36, '-h') }}" class="rounded size32" alt="">
        <div class="ml8">
            <div class="flex align-center">
                <a href="{{ $user->profilelink }}" class="bold blue fs13 no-underline">{{ $user->minified_name }}</a>
                <div class="gray height-max-content mx8 fs10">•</div>
                <div class="relative height-max-content">
                    <p class="no-margin fs11 flex align-center tooltip-section lblack">signed up : {{ $signed_at_humans }}</p>
                    <div class="tooltip tooltip-style-1" style="right: 0; left: auto;">
                        {{ $signed_at }}
                    </div>
                </div>
            </div>
            <p class="lblack fs11 bold no-margin">{{ $user->username }}</p>
        </div>
    </div>
</div>