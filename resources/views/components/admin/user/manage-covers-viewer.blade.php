<div>
    <div class="mb8 flex align-center">
        <p class="no-margin bold fs13 lblack">covers :</p>
        <div class="ucv-counter-box ml4">
            <span class="lblack bold fs12"><span id="ucv-selection-counter">{{ ($coverscount) ? 1 : 0 }}</span> / <span id="ucv-covers-label-length">{{ $coverscount }}</span></span>
        </div>
    </div>
    <div class="flex align-center">
        <div id="ucv-left-nav" class="full-center pointer @if($coverscount) ucv-left-nav-button @endif">
            <svg class="size10" fill="#4a4a4a" style="transform: rotate(180deg);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">  
                <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
            </svg>
        </div>
        <div id="ucv-cover-container" class="mx8 relative flex">
            <div id="ucv-cover-fade" class="fade-loading none"></div>
            @if($coverscount)
            <img src="{{ asset($covers[0]) }}" id="ucv-cover-image" class="handle-image-center-positioning unselectable open-image-on-image-viewer pointer" alt="">
            @else
            <span class="white move-to-middle self-center">This user does not have any cover</span>
            @endif
        </div>
        <div id="ucv-right-nav" class="full-center pointer @if($coverscount) ucv-right-nav-button @endif">
            <svg class="size10" fill="#4a4a4a" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">  
                <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
            </svg>
        </div>
        <input type="hidden" id="ucv-covers-length" autocomplete="off" value="{{ $coverscount }}">
        <div class="ucv-links-container">
            @foreach($covers as $cover)
            <input type="hidden" value="{{ asset($cover) }}" class="ucv-cover-link">
            @endforeach
        </div>
    </div>
    <div>
        @if(is_null($user->cover))
        <div class="section-style flex mt8" style="padding: 8px">
            <svg class="size14 mr8" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
            <p class="fs12 no-margin bold">This user does not use any cover for the moment.</p>
        </div>
        @endif
        @if(!$coverscount && !$trashedcovers)
        <div class="section-style flex mt8" style="padding: 8px">
            <svg class="size14 mr8" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
            <p class="fs12 no-margin bold">This user have not used any cover image since registered.</p>
        </div>
        @endif
        <div id="ucv-manage-cover-section" class="delete-user-cover-box" style="margin-top: 12px;">
            @if(count($covers))
            <div class="toggle-box">
                <div class="lblack my4 fs12 lh15">
                    <span>Cover doesn't respect rules and guidelines ?</span>
                    <div class="inline-block">
                        <span class="bold black pointer flex align-center toggle-container-button">
                            <span>Delete cover</span>
                            <svg class="toggle-arrow size7 ml4" style="margin-top: 1px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02" style="transform: rotate(0deg);"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                        </span>
                    </div>
                </div>
                <div class="toggle-container">
                    @php $candeletecovers = false; @endphp
                    @can('delete_user_cover', [\App\Models\User::class])
                        @php $candeletecovers = true; @endphp
                    @endcan
                    <div class="my4">
                        <p class="fs12 my8 lblack">Select whether to warn or strike the cover's owner after delete</p>
                        <div class="flex align-center my8">
                            <div class="flex align-center mr8">
                                <input type="radio" checked="checked" name="user-cover-delete-ws" autocomplete="off" id="user-cover-delete-warn" class="user-cover-delete-ws" value="warn">
                                <label for="user-cover-delete-warn" class="fs13 bold">warn cover owner</label>
                            </div>
                            <div class="flex align-center mr8">
                                <input type="radio" name="user-cover-delete-ws" autocomplete="off" id="user-cover-delete-strike" class="user-cover-delete-ws" value="strike">
                                <label for="user-cover-delete-strike" class="fs13 bold">strike cover owner</label>
                            </div>
                        </div>
                    </div>
                    @if(!$candeletecovers)
                    <div class="section-style flex align-center my8">
                        <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="fs12 bold lblack no-margin">You cannot delete users covers because you don't have permission to do so</p>
                    </div>
                    @endif

                    @if($candeletecovers)
                    <div id="delete-user-cover" class="red-button-style flex width-max-content">
                        <div class="relative size14 mr4">
                            <svg class="size14 icon-above-spinner mt2" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="block bold fs13 unselectable">delete cover</span>
                            <span class="block fs12">cover index: <span class="delete-cover-th">1</span></span>
                        </div>
                        <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                        <input type="hidden" class="success-message" value="Cover deleted successfully" autocomplete="off">
                    </div>
                    @else
                    <div class="red-button-style disabled-red-button-style flex width-max-content">
                        <svg class="size14 mr4 mt2" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <div>
                            <span class="block bold fs13 unselectable">delete cover</span>
                            <span class="block fs12">cover index: <span class="delete-cover-th">1</span></span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            @if(count($trashedcovers))
            <span class="block mb4 bold lblack fs13" style="margin-top: 12px;">Covers deleted by admins ({{ count($trashedcovers) }})</span>
            <p class="no-margin fs12 lblack">the following covers includes the ones that are deleted by admins for guidelines violation.</p>
            <div class="mt4">
                <div class="flex x-auto-overflow br3" style="background-color: #eee; border: 1px solid #d7d7d7; padding: 4px;">
                    @foreach($trashedcovers as $trashedcover)
                    <img src="{{ asset($trashedcover) }}" class="open-image-on-image-viewer pointer size60 mr4 br3" style="min-width: 60px; min-height: 60px;">
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>