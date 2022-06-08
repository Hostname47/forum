<div class="disable-record-container">
    <div class="flex space-between">
        <p class="no-margin lblack fs12 mr4"><strong>{{ __('disable date') }}</strong> : {{ $disable->disabled_at }}</p>
        <div class="enable-disabled-notification-button typical-button-style flex align-center height-max-content" style="padding: 6px 10px;">
            <div class="relative size12 mr4">
                <svg class="flex size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
            <span class="bold unselectable fs11">{{__('Enable')}}</span>
            <input type="hidden" class="status" autocomplete="off" value="stable">
            <input type="hidden" class="disable-id" autocomplete="off" value="{{ $disable->id }}" autocomplete="off">
            <input type="hidden" class="success-message" value="Thread has been restored successfully" autocomplete="off">
        </div>
    </div>
    <div class="mt4">
        @switch($disable->disabled_action)
            @case('thread-like')
            @case('thread-vote')
            @case('thread-reply')
            @case('poll-vote')
            @case('poll-option-add')
                <p class="fs12 lblack no-margin mb4 bold lblack">{{ __('resource') }} :</p>
                @php
                    $thread = \App\Models\Thread::withoutGlobalScopes()->find($disable->resource_id);
                @endphp
                @if(is_null($thread))
                    <div class="section-style flex">
                        <svg class="size14 mr8" style="min-width: 14px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="no-margin bold lblack fs12 lh15">{{ __("Resource not available") }}</p>
                    </div>
                @else
                <div class="section-style">
                    <x-thread.thread-simple-render :thread="$thread"/>
                </div>
                @endif
                @break;
            @case('post-vote')
            @case('post-like')
                <p class="fs12 lblack no-margin mb4 bold lblack">{{ __('disabled resource notifications') }} :</p>
                @php
                    $post = \App\Models\Post::withoutGlobalScopes()->find($disable->resource_id);
                @endphp
                @if(is_null($post))
                    <div class="section-style flex">
                        <svg class="size14 mr8" style="min-width: 14px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="no-margin bold lblack fs12 lh15">{{ __("Resource not available") }}</p>
                    </div>
                @else
                <div class="section-style">
                    <x-post.post-simple-render :post="$post"/>
                </div>
                @endif
                @break;
            @case('user-follow')
                <div class="section-style flex">
                    <svg class="size14 mr8" style="min-width: 14px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="no-margin bold lblack fs12 lh15">{{ __("You are currently disabling notifications on follows and you will not get any notification about new follows you get. You can enable this again to start get notifications about new follows.") }}</p>
                </div>
                @break;
            @case('post-tick')
                <div class="section-style flex">
                    <svg class="size14 mr8" style="min-width: 14px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="no-margin bold lblack fs12 lh15">{{ __("You are currently disabling notifications when other users mark your replies as best reply. You can enable this to start get this type of notifications again.") }}</p>
                </div>
                @break;
            @case('user-avatar-change')
                @php
                    $user = \App\Models\User::withoutGlobalScopes()->find($disable->resource_id);
                @endphp
                <div class="section-style flex mt4">
                    @if(is_null($user))
                    <svg class="size14 mr8" style="min-width: 14px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="no-margin bold lblack fs12 lh15">{{ __("User not available") }}</p>
                    @else
                    <img src="{{ asset($user->sizedavatar(100, '-l')) }}" class="size36 rounded" alt="">
                    <div class="ml8">
                        <h3 class="no-margin fs14 lblack">{{ $user->fullname }}</h3>
                        <span class="block no-margin fs11 lblack">{{ $user->username }}</span>
                    </div>
                    @endif
                </div>
                @break
            @case('thread-share')
                @php
                    $user = \App\Models\User::withoutGlobalScopes()->find($disable->resource_id);
                @endphp
                <div class="section-style flex mt4">
                    @if(is_null($user))
                    <svg class="size14 mr8" style="min-width: 14px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="no-margin bold lblack fs12 lh15">{{ __("User not available") }}</p>
                    @else
                    <img src="{{ asset($user->sizedavatar(100, '-l')) }}" class="size36 rounded" alt="">
                    <div class="ml8">
                        <h3 class="no-margin fs14 lblack">{{ $user->fullname }}</h3>
                        <span class="block no-margin fs11 lblack">{{ $user->username }}</span>
                    </div>
                    @endif
                </div>
                @break
        @endswitch
    </div>
</div>