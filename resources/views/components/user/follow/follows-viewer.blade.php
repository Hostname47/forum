@if($follows->count())
    @foreach($follows as $followeduser)
        <x-user.follows :followeduser="$followeduser"/>
    @endforeach
    @if($totalfollowscount > 10)
    <div class="fetch-more full-center flex-column py8">
        <input type="hidden" class="status" value="stable" autocomplete="off">
        <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
        <svg class="spinner size16 mb4" fill="none" viewBox="0 0 16 16">
            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
        </svg>
        <span class="block fs10 bold lblack">{{ __('loading more follows') }}..</span>
    </div>
    @endif
@else
    <div class="flex flex-column align-center px8">
        <div class="size36 sprite sprite-2-size nofollow36-icon" style="margin-top: 16px"></div>
        @if(auth()->user() && $user->id == auth()->user()->id)
        <p class="bold fs15 gray mb8 unselectable text-center">{{ __("You don't follow any one at the moment") }}</h2>
        <p class="no-margin fs13 forum-color unselectable text-center px8">{{ __("tip: Try to follow people in order to get notifications about their activities and see their posts") }}.</p>
        @else
        <p class="bold fs15 gray my8 unselectable text-center">{{ $user->username . ' ' . __("doesn't follow anyone") }}</h2>
        @endif
    </div>
@endif