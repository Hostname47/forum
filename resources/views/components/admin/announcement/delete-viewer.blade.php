<div>
    @php $candelete = false; @endphp
    @can('delete_announcement', [\App\Models\Thread::class, $announcement])
        @php $candelete = true; @endphp
    @endcan
    <h2 class="no-margin fs18 forum-color">{{ __('Please make sure you want to delete this announcement') }} !</h2>
    <div class="section-style my8">
        <div class="flex mt4">
            <p class="no-margin fs12" style="line-height: 1.5"><span class="bold fs13">Important :</span> The following announcement will be <strong>deleted permanently</strong> along with all its resources once you click on delete button. Please make sure it is the right announcement before proceeding</p>
        </div>
    </div>
    <p class="no-margin mt4 fs12 bold lblack mb4">Announcement post :</p>
    <div class="section-style mt8">
        <x-thread.thread-simple-render :thread="$announcement"/>
    </div>

    @if(!$candelete)
    <div class="red-section-style flex align-center my8">
        <svg class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
        <p class="fs12 no-margin">You cannot delete this announcement because you don't have permission to do so.</p>
    </div>
    @endif

    <div class="flex" style="margin-top: 14px">
        <div class="move-to-right">
            <div class="flex align-center">
                @if($candelete)
                <div id="delete-announcement-button" class="red-button-style flex align-center">
                    <div class="relative size14 mr4">
                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="bold">Delete announcement</span>
                    <input type="hidden" class="announcement-id" value="{{ $announcement->id }}" autocomplete="off">
                    <input type="hidden" class="deleted-successfully" value="Announcement deleted successfully" autocomplete="off">
                </div>
                @else
                <div class="disabled-red-button-style red-button-style flex align-center">
                    <div class="relative size14 mr4">
                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                    </div>
                    <span class="bold">Delete announcement</span>
                </div>
                @endif
                <span class="bold no-underline forum-color pointer close-global-viewer ml8">cancel</span>
            </div>
        </div>
    </div>
</div>