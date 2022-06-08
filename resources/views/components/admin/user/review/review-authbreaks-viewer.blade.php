<div>
    @php $canreview = false; @endphp
    @can('review_user_resources_and_activities', [\App\Models\User::class])
        @php $canreview = true; @endphp
    @endcan

    @if($canreview)
        <h2 class="fs14 forum-color no-margin">User authorization breaks ({{$totalauthbreaks}})</h2>
        <p class="fs13 no-margin my4">The following records shows where the user breaks some authorization conditions and violate guidelines.</p>
        <style>
            .user-authbreak-record {
                padding: 8px;
                background-color: #f5f7f9;
                border: 1px solid #c5d1d7;
                border-radius: 4px;
            }
        </style>
        @foreach($authbreaks as $authbreak)
        <x-admin.user.authorizationbreak-component :authbreak="$authbreak"/>
        @endforeach
        @if(!$totalauthbreaks)
        <div class="full-center green-section-style" style="margin-top: 14px">
            <svg class="size12 mr4" fill="#236636" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
            <p class="bold fs12 no-margin">This user does not have any authorization break</p>
        </div>
        @endif
        @if($totalauthbreaks > 12)
        <div class="full-center py8" id="user-authbreaks-review-fetch-more">
            <svg class="spinner size24" fill="none" viewBox="0 0 16 16">
                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
            </svg>
            <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
        </div>
        @endif
    @else
    <div class="section-style flex align-center my8 width-max-content move-to-middle">
        <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
        <p class="fs12 bold lblack no-margin">You cannot review user resources and activities because you don't have permission to do so</p>
    </div>
    @endif
</div>