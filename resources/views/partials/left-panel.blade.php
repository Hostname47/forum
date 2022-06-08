<div id="left-panel" class="flex flex-column">
    <div>
        <div class="flex relative mb8">
            <a href="/" class="left-panel-item p8 @if($page == 'home') {{ 'lp-selected bold white white' }} @endif">{{ __('Home') }}</a>
            @if($page == 'home')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="relative toggle-box pb8">
            <a href="" class="left-panel-item toggle-container-button simple-suboption-button lp-wpadding @if($page == 'search') {{ 'lp-selected bold white white' }} @endif">
                <svg class="size17 mr4" fill="#FFFFFF" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                {{__('Search')}}
                <svg class="toggle-arrow mx4 size7" style="margin-top: 1px; @if($page == 'search') transform: rotate(90deg) @endif" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                    <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                </svg>
            </a>
            <div class="toggle-container" @isset($subpage) @if($page == 'search') style="display: block;" @endif @endisset>
                <div class="relative">
                    <a href="{{ route('search') }}" @isset($subpage) @if($subpage == 'search') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'search') {{ 'lp-selected' }} @endif">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'search') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M27.31,363.3l96-96a16,16,0,0,0,0-22.62l-96-96C17.27,138.66,0,145.78,0,160V352C0,366.31,17.33,373.3,27.31,363.3ZM432,416H16A16,16,0,0,0,0,432v32a16,16,0,0,0,16,16H432a16,16,0,0,0,16-16V432A16,16,0,0,0,432,416Zm3.17-128H204.83A12.82,12.82,0,0,0,192,300.81v38.36A12.82,12.82,0,0,0,204.81,352H435.17A12.82,12.82,0,0,0,448,339.19V300.83A12.82,12.82,0,0,0,435.19,288Zm0-128H204.83A12.82,12.82,0,0,0,192,172.81v38.36A12.82,12.82,0,0,0,204.81,224H435.17A12.82,12.82,0,0,0,448,211.19V172.83A12.82,12.82,0,0,0,435.19,160ZM432,32H16A16,16,0,0,0,0,48V80A16,16,0,0,0,16,96H432a16,16,0,0,0,16-16V48A16,16,0,0,0,432,32Z"/></svg>
                        {{__('Search Index')}}
                    </a>
                    @isset($subpage)
                        @if($subpage == 'search')
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('threads.search') }}" @isset($subpage) @if($subpage == 'threads-search') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'search') {{ 'lp-selected' }} @endif">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'threads-search') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.29,4.9H14.35a1.19,1.19,0,1,0,0,2.38h5.94a1.19,1.19,0,0,1,1.19,1.19V20L19.61,18.3a1.14,1.14,0,0,0-.8-.32H8.4a1.19,1.19,0,0,1-1.19-1.19V14.41a1.19,1.19,0,0,0-2.38,0v2.38A3.57,3.57,0,0,0,8.4,20.36h9.94l3.57,3.24a1.16,1.16,0,0,0,.76.32,1.36,1.36,0,0,0,.48-.09,1.2,1.2,0,0,0,.71-1.1V8.47A3.57,3.57,0,0,0,20.29,4.9ZM7.89,9.66l2.05,2.05a1.19,1.19,0,0,0,1.68,0h0a1.19,1.19,0,0,0,0-1.68h0L9.59,8a5.06,5.06,0,0,0,.77-2.68A5.12,5.12,0,1,0,7.89,9.66ZM2.46,5.27a2.78,2.78,0,0,1,4.71-2l0,.05a2.75,2.75,0,0,1,.07,3.88l-.07.07a2.75,2.75,0,0,1-4.75-2Z"/></svg>
                        {{__('Posts Search')}}
                    </a>
                    @isset($subpage)
                        @if($subpage == 'threads-search')
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('users.search') }}" @isset($subpage) @if($subpage == 'users-search') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'search') {{ 'lp-selected' }} @endif">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'users-search') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511 511">
                            <path d="M413.88,250.22A126.79,126.79,0,0,0,256.09,52.27a126.85,126.85,0,0,0-158,198A180.21,180.21,0,0,0,1.94,410.37v54.44A18.15,18.15,0,0,0,20.09,483H491.92a18.15,18.15,0,0,0,18.14-18.15V410.37A180.21,180.21,0,0,0,413.88,250.22ZM328.59,65.57A90.61,90.61,0,0,1,365.88,238.8c-1.4.64-2.79,1.22-4.21,1.82a90.14,90.14,0,0,1-13.81,4.3c-.91.2-1.81.31-2.74.49a90.08,90.08,0,0,1-16,1.61c-2.41,0-4.84-.18-7.26-.4a13.87,13.87,0,0,1-2.72-.18,91.7,91.7,0,0,1-29.67-8.74c-.35-.17-.75-.15-1.09-.29-1.81-.88-3.63-1.64-5.24-2.62.14-.18.23-.38.38-.56A127.24,127.24,0,0,0,303,198.82l.56-1.52a128,128,0,0,0,4.81-18.68c.17-.92.29-1.81.44-2.81a127.46,127.46,0,0,0,1.65-19.51,127.05,127.05,0,0,0-1.65-19.47c-.15-.94-.27-1.81-.44-2.81a126.76,126.76,0,0,0-4.81-18.68l-.56-1.52a127.39,127.39,0,0,0-19.43-35.41c-.15-.18-.24-.38-.38-.56A90.15,90.15,0,0,1,328.59,65.57ZM92.67,156.3A90.5,90.5,0,0,1,245.82,90.76c1.05,1,2.09,2,3.1,3.08a93.61,93.61,0,0,1,8.61,10.44c.79,1.12,1.52,2.32,2.26,3.48A87.92,87.92,0,0,1,266.45,120c.46,1,.8,2.09,1.2,3.12a88.72,88.72,0,0,1,4.5,14.52c.13.54.17,1.09.27,1.65a85.37,85.37,0,0,1,0,34.15c-.11.56-.14,1.11-.27,1.65a88.72,88.72,0,0,1-4.5,14.52c-.4,1-.74,2.09-1.2,3.12A88.76,88.76,0,0,1,259.79,205c-.74,1.16-1.47,2.36-2.26,3.49a93.5,93.5,0,0,1-8.61,10.43c-1,1.05-2,2.07-3.1,3.09a90.6,90.6,0,0,1-25.06,16.91c-1.47.67-3,1.29-4.47,1.81a90.38,90.38,0,0,1-13.46,4.18c-1.14.25-2.32.4-3.48.6a90.28,90.28,0,0,1-14.94,1.5h-2a90.16,90.16,0,0,1-14.93-1.5c-1.16-.2-2.34-.35-3.49-.6a90.74,90.74,0,0,1-13.46-4.18c-1.51-.59-3-1.21-4.46-1.81A90.75,90.75,0,0,1,92.67,156.3ZM328.59,446.66H38.23V410.37a144.28,144.28,0,0,1,96.51-136.76,126.62,126.62,0,0,0,97.34,0,145.88,145.88,0,0,1,17.68,7.82c3.77,1.94,7.26,4.16,10.89,6.39,2.36,1.47,4.75,2.9,7,4.52,3.5,2.48,6.8,5.19,10.05,8,2.09,1.82,4.16,3.63,6.12,5.45,3,2.83,5.81,5.82,8.51,8.89,1.94,2.21,3.83,4.46,5.63,6.79,2.37,3.05,4.64,6.17,6.75,9.38,1.81,2.72,3.43,5.55,5,8.38,1.82,3.12,3.49,6.25,5,9.49s2.87,6.81,4.17,10.28c1.15,3,2.36,6,3.31,9.07,1.27,4.21,2.16,8.56,3.05,12.92.54,2.58,1.25,5.1,1.65,7.71a151.69,151.69,0,0,1,1.65,21.71v36.29Zm145.18,0H364.88V410.37c0-5.68-.32-11.31-.83-16.88-.15-1.63-.4-3.25-.58-4.88-.49-4-1.05-8-1.82-11.92-.32-1.69-.67-3.37-1-5.07q-1.31-6.06-3-12c-.38-1.31-.73-2.63-1.13-3.92a179.83,179.83,0,0,0-21.86-45.86l-.71-1q-4.68-7-10-13.45l-.13-.16a164.86,164.86,0,0,0-11.7-13h.74a126.65,126.65,0,0,0,15.45,1.09h1a128.88,128.88,0,0,0,14.3-.92c1.49-.18,3-.46,4.45-.69q5.79-.88,11.43-2.31c1.07-.27,2.16-.52,3.25-.83a121.66,121.66,0,0,0,14.52-4.94,144.28,144.28,0,0,1,96.58,136.8v36.29Z"/>
                        </svg>
                        {{__('Users Search')}}
                    </a>
                    @isset($subpage)
                        @if($subpage == 'users-search')
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('advanced.search') }}" @isset($subpage) @if($subpage == 'advanced-search') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'search') {{ 'lp-selected' }} @endif">
                        <svg class="size14 mr4" fill="@isset($subpage) @if($subpage == 'advanced-search') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511 511"><path d="M492,0H21A20,20,0,0,0,1,20,195,195,0,0,0,66.37,165.55l87.42,77.7a71.1,71.1,0,0,1,23.85,53.12V491a20,20,0,0,0,31,16.6l117.77-78.51a20,20,0,0,0,8.89-16.6V296.37a71.1,71.1,0,0,1,23.85-53.12l87.41-77.7A195,195,0,0,0,512,20,20,20,0,0,0,492,0ZM420.07,135.71l-87.41,77.7a111.1,111.1,0,0,0-37.25,83V401.82l-77.85,51.9V296.37a111.1,111.1,0,0,0-37.25-83L92.9,135.71A155.06,155.06,0,0,1,42.21,39.92H470.76A155.06,155.06,0,0,1,420.07,135.71Z"/></svg>
                        {{__('Advanced Search')}}
                    </a>
                    @isset($subpage)
                        @if($subpage == 'advanced-search')
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
        @php
            $same_user = false;
            if(auth()->user()) {
                if(request()->user) {
                    $same_user = (request()->user instanceof \App\Models\User && auth()->user()->username == request()->user->username) ? true : false;

                } else {
                    if(isset($subpage)) {
                        if($subpage == 'user.settings') {
                            $same_user = true;
                        }
                    }
                }
            }
        @endphp
        @auth
        <div class="relative toggle-box pb8">
            <a href="" class="left-panel-item toggle-container-button simple-suboption-button lp-wpadding @if($page == 'user' && $same_user) {{ 'lp-selected bold white white' }} @endif">
                <div class="relative size24 mr8 rounded hidden-overflow">
                    <img src="{{ auth()->user()->sizedavatar(36, '-l') }}" class="size24" style='background-color: #10151e' alt="{{ __('your profile picture') }}">
                </div>
                <span>{{ auth()->user()->lightusername }}</span>
                <svg class="toggle-arrow mx4 size7" style="margin-top: 1px; @if($page == 'user' && $same_user) transform: rotate(90deg) @endif" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                    <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                </svg>
            </a>
            <div class="toggle-container" @isset($subpage) @if($same_user) style="display: block;" @endif @endisset>
                <div class="relative">
                    <a href="{{ route('user.profile', ['user'=>auth()->user()->username]) }}" @isset($subpage) @if($subpage == 'user.profile' && $same_user) style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'user' && $same_user) {{ 'lp-selected' }} @endif">
                        <svg class="size14 mr4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="@isset($subpage) @if($same_user && $subpage == 'user.profile') #2ca0ff @else #fff @endif @else #fff @endisset" d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                        {{__('Profile')}}
                    </a>
                    @isset($subpage)
                        @if($subpage == 'user.profile' && $same_user)
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('user.activities', ['user'=>auth()->user()->username]) }}" @isset($subpage) @if($subpage == 'user.activities' && $same_user) style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'user' && $same_user) {{ 'lp-selected' }} @endif">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="@isset($subpage) @if($same_user && $subpage == 'user.activities') #2ca0ff @else #fff @endif @else #fff @endisset" d="M80,368H16A16,16,0,0,0,0,384v64a16,16,0,0,0,16,16H80a16,16,0,0,0,16-16V384A16,16,0,0,0,80,368ZM80,48H16A16,16,0,0,0,0,64v64a16,16,0,0,0,16,16H80a16,16,0,0,0,16-16V64A16,16,0,0,0,80,48Zm0,160H16A16,16,0,0,0,0,224v64a16,16,0,0,0,16,16H80a16,16,0,0,0,16-16V224A16,16,0,0,0,80,208ZM496,384H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V400A16,16,0,0,0,496,384Zm0-320H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V80A16,16,0,0,0,496,64Zm0,160H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V240A16,16,0,0,0,496,224Z"/></svg>
                        {{__('Activities')}}
                    </a>
                    @isset($subpage)
                        @if($subpage == 'user.activities' && $same_user)
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('user.settings') }}" @isset($subpage) @if($subpage == 'user.settings') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'user' && $same_user) {{ 'lp-selected' }} @endif">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path fill="@isset($subpage) @if($subpage == 'user.settings') #2ca0ff @else #fff @endif @else #fff @endisset" d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                        {{__('Settings')}}
                    </a>
                    @isset($subpage)
                        @if($subpage == 'user.settings')
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
        <div class="flex relative">
            <div class="flex align-center full-width">
                @php
                    $add_thread_link = route('thread.add');
                @endphp
                <a href="{{ $add_thread_link }}" class="left-panel-item lp-padding @if($page == 'add-thread') {{ 'lp-selected bold white white' }} @endif">
                    <svg class="size17" fill="#FFFFFF" style="margin-right: 6px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.18,217.58a23.4,23.4,0,0,0-23.4,23.4V428.2a23.42,23.42,0,0,1-23.4,23.4H83.76a23.42,23.42,0,0,1-23.4-23.4V100.57a23.42,23.42,0,0,1,23.4-23.4H271a23.4,23.4,0,0,0,0-46.8H83.76a70.29,70.29,0,0,0-70.21,70.2V428.2a70.29,70.29,0,0,0,70.21,70.2H411.38a70.29,70.29,0,0,0,70.21-70.2V241A23.39,23.39,0,0,0,458.18,217.58Zm-302,56.25a11.86,11.86,0,0,0-3.21,6l-16.54,82.75a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L233,359.76a11.68,11.68,0,0,0,6-3.21L424.12,171.4,341.4,88.68ZM481.31,31.46a58.53,58.53,0,0,0-82.72,0L366.2,63.85l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72ZM155.72,273.08a11.86,11.86,0,0,0-3.21,6L136,361.8a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L232.48,359a11.68,11.68,0,0,0,6-3.21L423.62,170.65,340.9,87.93ZM480.81,30.71a58.53,58.53,0,0,0-82.72,0L365.7,63.1l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72Z"/></svg>
                    {{__('Create a post')}}
                </a>
            </div>
            @if($page == 'add-thread')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        @endauth
        <div>
            <p class="left-panel-label">{{ __('PUBLIC') }}</p>
            <div class="flex relative">
                <div class="flex align-center full-width relative">
                    <a href="{{ route('explore') }}" class="left-panel-item lp-padding @if($page == 'explore') {{ 'lp-selected bold white' }} @endif">
                        <svg class="small-image mr8" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510 510"><path d="M255,227A28.05,28.05,0,1,0,283.05,255,28.3,28.3,0,0,0,255,227ZM255,0C114.75,0,0,114.75,0,255S114.75,510,255,510,510,395.25,510,255,395.25,0,255,0Zm56.1,311.1L102,408l96.9-209.1L408,102Z"/></svg>
                        {{__('Explore')}}
                    </a>
                </div>
                @if($page == 'explore')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <div class="flex align-center full-width relative">
                    <a href="/forums" class="left-panel-item lp-padding @if($page == 'forums') {{ 'lp-selected bold white' }} @endif">
                        <svg class="small-image mr8" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M438.09,273.32h-39.6a102.92,102.92,0,0,1,6.24,35.4V458.37a44.18,44.18,0,0,1-2.54,14.79h65.46A44.4,44.4,0,0,0,512,428.81V347.23A74,74,0,0,0,438.09,273.32ZM107.26,308.73a102.94,102.94,0,0,1,6.25-35.41H73.91A74,74,0,0,0,0,347.23v81.58a44.4,44.4,0,0,0,44.35,44.35h65.46a44.17,44.17,0,0,1-2.55-14.78Zm194-73.91H210.74a74,74,0,0,0-73.91,73.91V458.38a14.78,14.78,0,0,0,14.78,14.78H360.39a14.78,14.78,0,0,0,14.78-14.78V308.73A74,74,0,0,0,301.26,234.82ZM256,38.84a88.87,88.87,0,1,0,88.89,88.89A89,89,0,0,0,256,38.84ZM99.92,121.69a66.44,66.44,0,1,0,66.47,66.47A66.55,66.55,0,0,0,99.92,121.69Zm312.16,0a66.48,66.48,0,1,0,66.48,66.47A66.55,66.55,0,0,0,412.08,121.69Z"/></svg>
                        {{__('Forums')}}
                    </a>
                </div>
                @if($page == 'forums')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <div class="flex align-center full-width relative">
                    <a href="" class="left-panel-item block-click lp-padding @if($page == 'chat') {{ 'lp-selected bold white' }} @endif" style="cursor: default">
                        <svg class="small-image mr8" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"/></svg>
                        {{ __('Chats') }}
                        <span class="fs12" style="margin-left: 3px; color: rgb(187, 187, 187)">({{__('soon')}})</span>
                    </a>
                </div>
                @if($page == 'chat')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <!-- <div class="flex relative">
                <div class="flex align-center full-width relative">
                    <a href="" class="left-panel-item block-click lp-padding @if($page == 'market') {{ 'lp-selected bold white' }} @endif" style="cursor: default">
                        <svg class="small-image mr8" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 456.03 456.03"><path d="M345.6,338.86a53.25,53.25,0,1,0,53.25,53.25C398.34,362.93,374.78,338.86,345.6,338.86ZM439.3,84.91c-1,0-2.56-.51-4.1-.51H112.64l-5.12-34.31A45.85,45.85,0,0,0,62,10.67H20.48a20.48,20.48,0,0,0,0,41H62a5.44,5.44,0,0,1,5.12,4.61L98.82,272.3a56.12,56.12,0,0,0,55.29,47.62h213c26.63,0,49.67-18.95,55.3-45.06l33.28-166.4A20.24,20.24,0,0,0,439.3,84.91ZM215,389.55c-1-28.16-24.58-50.69-52.74-50.69a53.56,53.56,0,0,0-51.2,55.3,52.49,52.49,0,0,0,52.23,50.69h1C193.54,443.31,216.58,418.73,215,389.55Z"/></svg>
                        {{ __('Market place') }}
                        <span class="fs12" style="margin-left: 3px; color: rgb(187, 187, 187)">({{__('soon')}})</span>
                    </a>
                </div>
                @if($page == 'market')
                    <div class="selected-colored-slice"></div>
                @endif
            </div> -->
        </div>
        <div>
            <p class="left-panel-label">{{__('MORE')}}</p>
            <div class="flex relative">
                <a href="{{ route('guidelines') }}" class="left-panel-item lp-wpadding @if($page == 'guidelines') {{ 'lp-selected bold white' }} @endif">{{__('Guidelines')}}</a>
                @if($page == 'guidelines')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <a href="{{ route('about') }}" class="left-panel-item lp-wpadding @if($page == 'about') {{ 'lp-selected bold white' }} @endif">{{__('About Us')}}</a>
                @if($page == 'about')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <a href="{{ route('faqs') }}" class="left-panel-item lp-wpadding @if($page == 'faqs') {{ 'lp-selected bold white' }} @endif" title="Frequently Asked Questions">{{ __('FAQs') }}</a>
                @if($page == 'faqs')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <a href="{{ route('privacy') }}" class="left-panel-item lp-wpadding @if($page == 'privacy') {{ 'lp-selected bold white' }} @endif" title="Frequently Asked Questions">{{ __('Privacy Policy') }}</a>
                @if($page == 'privacy')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
        </div>
    </div>
    <div class="move-to-bottom" style="margin-bottom: 12px">
        <div class="flex align-center fs13">
            <p class="unselectable fs13">Designed with</p>
            <div style="max-height: 19px; height: 19px; max-width: 19px; width: 19px" class="full-center mx4" title="{{ __('LOVE') }}">
                <svg class="heart-beating" fill="#FF0000" style="width: 16px; stroke: #331010; stroke-width: 5px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 94.5"><path d="M86.82,26.63v-7.3H78.64V12H62.27v7.29H54.09v7.3H45.91v-7.3H37.73V12H21.36v7.29H13.18v7.3H5V48.5h8.18v7.29h8.18v7.29h8.19v7.29h8.18v7.3h8.18V85h8.18V77.67h8.18v-7.3h8.18V63.08h8.19V55.79h8.18V48.5H95V26.63Z"/></svg>
            </div>
            <p class="unselectable fs13">by<a href="https://www.mouad-dev.com" target="_blank" class="no-underline mx4 bold" style="color: rgb(58, 186, 236)">mouad</a></p>
        </div>
    </div>
</div>