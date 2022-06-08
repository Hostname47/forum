@if($followers->count())
    @foreach($followers as $follower)
        <x-user.follower :follower="$follower"/>
    @endforeach
    @if($totalfollowerscount > 10)
    <div class="fetch-more full-center flex-column py8">
        <input type="hidden" class="status" value="stable" autocomplete="off">
        <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
        <svg class="spinner size16 mb4" fill="none" viewBox="0 0 16 16">
            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
        </svg>
        <span class="block fs10 bold lblack">{{ __('loading more followers') }}..</span>
    </div>
    @endif
@endif
<div class="flex @if($followers->count()) none @endif no-followers-box flex-column align-center px8">
    <div class="size36 sprite sprite-2-size nofollow36-icon" style="margin-top: 16px"></div>
    @if(auth()->user() && $user->id == auth()->user()->id)
    <p class="bold fs17 gray mb8 unselectable text-center">{{ __("You don't have any followers at that time") }}</h2>
    <p class="no-margin forum-color unselectable text-center">{{ __("Try to follow people, create more useful posts, and react to other people's postes to get more followers") }}.</p>
    @else
    <p class="bold fs17 gray my8 unselectable">{{ $user->username . ' ' . __("has no followers") }}</h2>
    <p class="no-margin forum-color unselectable text-center">{{ __("Be his first follower") }}</p>
    @endif
</div>