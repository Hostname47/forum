<div>
    <div>
        <div class="right-panel-header-container space-between">
            <div class="flex align-center">
                <svg class="small-image mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 397.15 397.15"><path d="M390.88,12.37c-4.14-4.15-10.13-6.25-17.78-6.25-26.78,0-70.16,26-93.64,41.55l-1.91,1.27-5.28,41.68-14-28.34-4.81,3.52a763.05,763.05,0,0,0-85.75,73.26c-4.62,4.62-9.16,9.31-13.5,13.94l-.93,1-18.7,82.35-9.86-49.17L118,196.36c-3.84,5.26-7.46,10.53-10.78,15.65l-.62,1-8,62.92L86.17,250.56,82.63,263.1c-4.3,15.28-4.5,28.32-.67,38.5l-80,80a5.52,5.52,0,0,0-1.55,6.22A5.21,5.21,0,0,0,5.24,391a6.85,6.85,0,0,0,2.46-.49l36.94-14a15.23,15.23,0,0,0,5.11-3.41l49.61-52.77A44.27,44.27,0,0,0,118,324h0a82.94,82.94,0,0,0,22.18-3.4l12.54-3.54-25.33-12.49,62.92-8,.95-.62c5.12-3.31,10.39-6.94,15.66-10.79l9.19-6.7-49.17-9.86,82.34-18.71,1-.92c4.64-4.35,9.33-8.89,13.94-13.5,35.17-35.17,70.11-78.39,95.85-118.59l3-4.7L338.24,100,373,95.59l1.23-2.2C397.46,51.81,403.07,24.56,390.88,12.37Z"/></svg>
                <p class="no-margin bold bblack unselectable">{{ __('Author') }}</p>
            </div>
            <a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="blue no-underline bold">{{ __('Profile') }}</a>
        </div>
        <div class="relative us-user-media-container mx8 my8">
            <div class="us-cover-container full-center" style="height: 90px">
                <img src="{{ $user->cover }}"  class="us-cover" alt="">
            </div>
            <div class="us-after-cover-section flex" style="margin-left: 20px; margin-top: -40px">
                <div style="padding: 6px; background-color: white;" class="rounded">
                    <a href="{{ route('user.profile', ['user'=>$user->username]) }}">
                        <div class="image-size-1 full-center rounded hidden-overflow">
                            <img src="{{ $user->sizedavatar(100) }}" class="handle-image-center-positioning" alt="">
                        </div>
                    </a>
                </div>
                <div class="ms-profile-infos-container" style="margin-top: 45px">
                    <div class="flex align-center">
                        <a href="{{ $user->profilelink }}" class="fs17 bold blue no-underline flex align-center">
                            {{ $user->firstname . ' ' . $user->lastname }}
                        </a>
                        <div class="ml4" style='margin-top: 1px'>
                            @php
                                $ustatus = Cache::has('user-is-online-' . $user->id) ? 'active' : 'inactive';
                            @endphp
                            <div class="flex align-center" title="@if($ustatus == 'active') {{ __('Online') }} @else {{ __('Offline') }} @endif">
                                <svg class="tiny-image mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    @if($ustatus == 'active')
                                    <path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Z" style="fill:#25BD54"/>
                                    @else
                                    <path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Z" style="fill:#919191"/>
                                    @endif
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="fs12 bold no-margin">[{{ $user->username }}]</p>
                </div>
            </div>
            <div class="my8">
                <p class="fs12 gray no-margin flex align-center">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 559.98 559.98"><path d="M280,0C125.6,0,0,125.6,0,280S125.6,560,280,560s280-125.6,280-280S434.38,0,280,0Zm0,498.78C159.35,498.78,61.2,400.63,61.2,280S159.35,61.2,280,61.2,498.78,159.35,498.78,280,400.63,498.78,280,498.78Zm24.24-218.45V163a23.72,23.72,0,0,0-47.44,0V287.9c0,.38.09.73.11,1.1a23.62,23.62,0,0,0,6.83,17.93l88.35,88.33a23.72,23.72,0,1,0,33.54-33.54Z"/></svg>
                    <span class="bold mr4">{{ __('Join Date') }} :</span>
                    <span class="black">{{ (new \Carbon\Carbon($thread->created_at))->isoFormat("dddd D MMM YYYY - H:mm A") }}</span>
                </p>
            </div>
        </div>
    </div>
    <div>
        <div class="border-box mt8">
            <div>
                <div class="right-panel-header-container">
                    <p class="bold no-margin fs15 bblack">{{ __("Not the post you're looking for ?") }}</p>
                </div>
                <div class="px8 mx8">
                    <p class="fs12"><span class="bold mr4">+</span>{{ __("Use the") }} <a href="{{ route('advanced.search') }}" class="blue bold no-underline">{{ __('advanced search') }}</a> {{ __("by specifying the forum and category (or select [all] option to search in all categories of all forums)") }}.</p>
                    <p class="fs12"><span class="bold mr4">+</span>{{ __("Or you can") }} <a href="{{ route('thread.add') }}" class="blue bold no-underline">{{ __("create") }}</a> {{ __('your own post') }}</p>
                </div>
            </div>
        </div>
        <div class="mt8 py8">
            <div class="toggle-box">
                <div class="right-panel-header-container space-between">
                    <div class="flex align-center">
                        <p class="bold no-margin fs15 bblack">{{ __('Replying Guidelines') }}</p>
                    </div>
                    <a href="{{ route('guidelines') }}" class="bold blue no-underline fs12">{{ __('Guidelines page') }}</a>
                </div>
                <div class="mx8 px8">
                    <p class="fs12 my8 flex"><strong class="mr4">I.</strong> {{ __('Treat people with respect if you want to be respected') }}.</strong></p>
                    <p class="fs12 my8 flex"><strong class="mr4">II.</strong> {{ __('Stick to the topic when replying to posts or replies created by others') }}.</p>
                    <p class="fs12 my8 flex"><strong class="mr4">III.</strong> {{ __('Due to the multinational nature of the forum, you are free to use any language. If you’d like to use a different language (by way of an external link, for example), consider providing a translation of the relevant portion in your topic/reply. It could even be a machine translation (Google Translate, for example), as long as the point comes across correctly') }}.</p>
                </div>
            </div>
        </div>
    </div>
</div>