<div class="follow-box-item follow-box">
    <div class="flex align-center">
        <img src="{{ $user->sizedavatar(36) }}" class="size34 rounded mr8" alt="{{ $user->username . ' ' . __('avatar') }}">
        <div>
            <a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="bold no-underline blue">{{ $user->username }}</a>
            <p class="fs11 gray no-margin">{{ $user->fullname }}</p>
        </div>
    </div>
    @unless(auth()->user() && $user->id == auth()->user()->id)
    <div class="wtypical-button-style height-max-content @auth follow-user follow-button-with-icon @else login-signin-button @endauth" style="padding: 5px 8px">
        <div class="relative size14 mr4">
            <svg class="size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path class="followed-icon @if(!$followed) none @endif" d="M446.26,288.77l-115.32,129a11.26,11.26,0,0,1-15.9.87l-.28-.26L266,371.62a11.23,11.23,0,0,0-15.89.31h0l-28,29.13a11.26,11.26,0,0,0,.33,15.91l95.72,91.89a11.26,11.26,0,0,0,15.91-.33l.27-.29L493.14,330.68a11.26,11.26,0,0,0-.89-15.89l-30.11-26.91A11.25,11.25,0,0,0,446.26,288.77ZM225,149.1a87.1,87.1,0,1,0,87.1,87.09A87.12,87.12,0,0,0,225,149.1Zm0,130.64a43.55,43.55,0,1,1,43.55-43.55A43.56,43.56,0,0,1,225,279.74ZM208.43,470l24,25.28a9.89,9.89,0,0,1-7.18,16.7H225C100.87,512,.27,411.57,0,287.5S101,62,225,62c100.49,0,185.55,65.82,214.45,156.72a11.55,11.55,0,0,1-2.38,11.17L421,248a11.62,11.62,0,0,1-20-5C381.38,164.17,309.93,105.55,225,105.55,124.93,105.55,43.55,186.93,43.55,287A180.16,180.16,0,0,0,77.39,392.15c22.23-28.49,56.43-47.09,95.35-47.09h.06a6.35,6.35,0,0,1,6.2,6.4v31.31a6.4,6.4,0,0,1-8.23,6.14l-.66-.21A78.15,78.15,0,0,0,107,424.54,180.6,180.6,0,0,0,202.48,467,9.88,9.88,0,0,1,208.43,470Z"/>
                <g class="follow-icon @if($followed) none @endif">
                    <path d="M146.9,234.19A87.1,87.1,0,1,0,234,147.1,87.12,87.12,0,0,0,146.9,234.19Zm130.65,0A43.55,43.55,0,1,1,234,190.65,43.56,43.56,0,0,1,277.55,234.19Z"/>
                    <path d="M329.48,70.28A21.37,21.37,0,0,0,305,91.47h0c0,10.09,8.16,19.61,18.13,21.16a90.1,90.1,0,0,1,75,75c1.55,10,11.07,18.13,21.16,18.13h0a21.37,21.37,0,0,0,21.19-24.48A133.06,133.06,0,0,0,329.48,70.28Z"/>
                    <path d="M425.85,254.82a9.8,9.8,0,0,0-11.45,10.75,180.29,180.29,0,0,1-32.79,124.58c-22.14-28.49-56.34-47.09-95.35-47.09-9.26,0-23.59,8.71-52.26,8.71s-43-8.71-52.26-8.71c-38.92,0-73.12,18.6-95.35,47.09A180.14,180.14,0,0,1,52.62,279.91c2.66-96,80.45-173.7,176.4-176.29q6.63-.18,13.16.11a9.8,9.8,0,0,0,10.13-11.17A158.17,158.17,0,0,0,246.4,66.9,9.83,9.83,0,0,0,237.24,60h-.06C112.7,58.3,9,160.44,9,284.93,9,426,138.59,536.67,285.24,504.35a221.36,221.36,0,0,0,168-167.67,234.77,234.77,0,0,0,5.32-66,9.77,9.77,0,0,0-6.3-8.52A156.61,156.61,0,0,0,425.85,254.82ZM234,466.45a180.39,180.39,0,0,1-118-43.91,78.15,78.15,0,0,1,63.14-35.84C198,392.51,216,395.41,234,395.41a181.65,181.65,0,0,0,54.89-8.71A78.37,78.37,0,0,1,352,422.54,180.39,180.39,0,0,1,234,466.45Z"/><path d="M329.87,4.77A21.05,21.05,0,0,0,306.5,26.09h0A21.46,21.46,0,0,0,326,47.41,158.69,158.69,0,0,1,468.46,189.86a21.46,21.46,0,0,0,21.32,19.51h0A21,21,0,0,0,511.1,186C502.05,90.26,425.62,13.82,329.87,4.77Z"/>
                </g>
            </svg>
            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
            </svg>
        </div>
        <p class="no-margin fs11 bold button-text unselectable">@if($followed){{ __('Followed') }}@else{{ __('Follow') }}@endif</p>
        
        <input type="hidden" autocomplete="off" class="follow-text" value="{{ __('Follow') }}">
        <input type="hidden" autocomplete="off" class="following-text" value="{{ __('Following') }}..">
        <input type="hidden" autocomplete="off" class="followed-text" value="{{ __('Followed') }}">
        <input type="hidden" autocomplete="off" class="unfollowing-text" value="{{ __('Unfollowing') }}..">
        <input type="hidden" autocomplete="off" class="follow-success" value="{{ __('User followed successfully') }}">
        <input type="hidden" autocomplete="off" class="unfollow-success" value="{{ __('User unfollowed successfully') }}">
        
        <input type="hidden" autocomplete="off" class="user-id" value="{{ $user->id }}">
        @php $follow_status = ($followed) ? 'followed' : 'not-followed'; @endphp
        <input type="hidden" autocomplete="off" class="status" value="{{ $follow_status }}" autocomplete="off">
        <input type="hidden" autocomplete="off" class="lock" value="stable" autocomplete="off">
    </div>
    @endunless
    <input type="hidden" class="followable-id" value="{{ $user->id }}">
    <input type="hidden" class="followable-type" value="user">
</div>