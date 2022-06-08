<div class="flex">
    <div class="flex align-center">
        <div id="uav-left-nav" class="full-center pointer @if(count($avatars)) uav-left-nav-button @endif">
            <svg class="size10" fill="#4a4a4a" style="transform: rotate(180deg);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">  
                <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
            </svg>
        </div>
        <div id="uav-avatar-container" class="full-center mx8 relative">
            <div id="uav-avatar-fade" class="fade-loading none"></div>
            @if(count($avatars))
            <img src="{{ asset($avatars[0]['avatarlink']) }}" id="uav-avatar-image" class="open-image-on-image-viewer pointer unselectable handle-image-center-positioning" alt="">
            @else
            <img src="{{ $user->sizedavatar(300, '-h') }}" id="uav-avatar-image" class="unselectable full-dimensions" alt="">
            @endif
        </div>
        <div id="uav-right-nav" class="full-center pointer @if(count($avatars)) uav-right-nav-button @endif">
            <svg class="size10" fill="#4a4a4a" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">  
                <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
            </svg>
        </div>
        <!-- 
            we're going to have a variable hold te current id of avatar displayed, so that when the admin
            click on next or previous we handle that id along with the links
        -->
        <input type="hidden" id="default-avatar-link" autocomplete="off" value="{{ $defaultavatar }}">
        <input type="hidden" id="uav-avatars-length" autocomplete="off" value="{{ $avatarscount }}">
        <div class="uav-links-container">
            @foreach($avatars as $avatar)
                <div>
                    <input type="hidden" class="avatar-can-be-managed" value="{{ $avatar['canbemanaged'] }}">
                    <input type="hidden" value="{{ asset($avatar['avatarlink']) }}" class="uav-avatar-link">
                </div>
            @endforeach
        </div>
    </div>
    <div class="full-width ml8"> <!-- take all the remaining width -->
        <div class="flex align-center">
            <span class="fs11 lblack mr4">avatars :</span>
            <div class="uav-counter-box">
                <span class="lblack bold fs12"><span id="uav-selection-counter">1</span> / <span id="uav-avatars-label-length">{{ $avatarscount }}</span></span>
            </div>
        </div>
        <div>
            @if(is_null($user->avatar) AND is_null($user->provider_avatar))
            <div class="section-style flex mt8" style="padding: 8px">
                <svg class="size14 mr8" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                <p class="fs12 no-margin bold">This user does not use any avatar for the moment.</p>
            </div>
            @endif
            @if(!count($avatars) && !count($trashedavatars))
            <div class="section-style flex mt8" style="padding: 8px">
                <svg class="size14 mr8" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                <p class="fs12 no-margin bold">This user doesn't have any avatar since registered.</p>
            </div>
            @endif

            @if(count($avatars) || count($trashedavatars))
            <div id="uav-manage-avatar-section" class="delete-user-avatar-box @if((count($avatars) AND !$avatars[0]['canbemanaged']) OR !count($avatars)) none @endif"> <!-- we add class none if the first item is not mnaged or if there are no avatars at all -->
                <p class="lblack my4 fs12">Avatar doesn't respect rules and guidelines ? You can delete the avatar and choose whether to <strong>warn or strike</strong> this user for this avatar</p>
                <div class="toggle-box">
                    <div class="flex align-center toggle-container-button pointer">
                        <h2 class="no-margin lblack fs13">Delete avatar</h2>
                        <svg class="toggle-arrow size7 ml4" style="margin-top: 1px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                    </div>
                    <div class="toggle-container">
                        @php $candeleteavatars = false; @endphp
                        @can('delete_user_avatar', [\App\Models\User::class])
                            @php $candeleteavatars = true; @endphp
                        @endcan
                        <div class="my4">
                            <p class="fs12 my8 lblack">Select whether to warn or strike the avatar's owner after delete</p>
                            <div class="flex align-center my8">
                                <div class="flex align-center mr8">
                                    <input type="radio" checked="checked" name="user-avatar-delete-ws" autocomplete="off" id="user-avatar-delete-warn" class="user-avatar-delete-ws" value="warn">
                                    <label for="user-avatar-delete-warn" class="fs13 bold">warn avatar owner</label>
                                </div>
                                <div class="flex align-center mr8">
                                    <input type="radio" name="user-avatar-delete-ws" autocomplete="off" id="user-avatar-delete-strike" class="user-avatar-delete-ws" value="strike">
                                    <label for="user-avatar-delete-strike" class="fs13 bold">strike avatar owner</label>
                                </div>
                            </div>
                        </div>
                        @if(!$candeleteavatars)
                        <div class="section-style flex align-center my8">
                            <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="fs12 bold lblack no-margin">You cannot delete users avatars because you don't have permission to do so</p>
                        </div>
                        @endif

                        @if($candeleteavatars)
                        <div id="delete-user-avatar" class="red-button-style full-center">
                            <div class="relative size14 mr4">
                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold fs13 unselectable">delete avatar</span>
                            <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                            <input type="hidden" class="success-message" value="Avatar deleted successfully" autocomplete="off">
                        </div>
                        @else
                        <div class="red-button-style disabled-red-button-style full-center">
                            <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <span class="bold fs13 unselectable">delete avatar</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @if(count($trashedavatars))
            <span class="block mt8 mb4 bold lblack fs13">Trashed avatars ({{ count($trashedavatars) }})</span>
            <p class="no-margin fs12 lblack">the following avatars includes the ones that are removed by admins as well as by owner.</p>
            <div class="mt4">
                <div class="flex x-auto-overflow br3" style="max-width: 300px; background-color: #eee; border: 1px solid #d7d7d7; padding: 4px;">
                    @foreach($trashedavatars as $trashedavatar)
                    <img src="{{ asset($trashedavatar) }}" class="open-image-on-image-viewer pointer size60 mx4 br3" style="min-width: 60px; min-height: 60px;">
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>