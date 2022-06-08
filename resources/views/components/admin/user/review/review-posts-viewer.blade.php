<div>
    @php $canreview = false; @endphp
    @can('review_user_resources_and_activities', [\App\Models\User::class])
        @php $canreview = true; @endphp
    @endcan

    @if($canreview)
        @if($posts->count())
            <h2 class="fs14 forum-color no-margin">All user replies ({{ $poststotalcount }})</h2>
            <p class="fs13 no-margin my4">The following replies include all user replies including deleted ones as well</p>
            <div class="posts-container">
                @foreach($user->userposts()->withoutGlobalScopes()->orderBy('created_at', 'desc')->take(10)->get() as $post)
                <x-admin.post.post-review-component :post="$post"/>
                @endforeach
            </div>

            @if($user->userposts()->count() > 10)
            <div class="full-center py8" id="user-posts-review-fetch-more">
                <svg class="spinner size28" style="color: #197ed0" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
                <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
            </div>
            @endif
        @else
            <div class="full-center" style="margin-top: 20px;">
                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                <span class="bold lblack fs12">This user does not have any replies since registered</span>
            </div>
        @endif
    @else
    <div class="section-style flex align-center my8">
        <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
        <p class="fs12 bold lblack no-margin">You cannot review user resources and activities because you don't have permission to do so</p>
    </div>
    @endif
</div>