<div id="post-delete-viewer" class="global-viewer flex justify-center none">
    <input type="hidden" class="post-id" autocomplete="off"> <!-- initialized dynamically -->
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="global-viewer-content-box viewer-box-style-1 vbs-margin-1">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color flex align-center">
                <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                {{ __('Delete reply') }}
            </span>
            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div style="padding: 14px">
            <h2 class="no-margin fs16 forum-color">{{ __('Please make sure you want to delete this reply') }} !</h2>
            <p class="fs13 no-margin mt4" style="line-height: 1.5">{{ __('All associated votes and likes will be deleted along with the reply') }}.</p>

            <div class="flex section-style">
                <p class="no-margin fs14 lblack"><strong class="no-wrap mr8">{{ __('Reply') }} :</strong></p>
                <div class="post-deleted-content">
                    
                </div>
                <style>
                    .post-deleted-content * {
                        margin: 0
                    }
                </style>
            </div>
            <div class="flex" style="margin-top: 14px">
                <div class="move-to-right">
                    <div class="flex align-center">
                        <div id="delete-post-button" class="red-button-style flex align-center mr8">
                            <input type="hidden" class="thread-id">
                            <div class="relative size14 mr4">
                                <svg class="size13 icon-above-spinner mr4" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <div class="btn-text fs12 bold">{{ __('Delete reply') }}</div>
                            <input type="hidden" class="success-message" value="{{ __('Your reply has been deleted successfully') }}.">
                            <input type="hidden" class="error-message" value="{{ __('Oops something went wrong') }}.">
                        </div>
                        <div class="pointer close-global-viewer bblack bold">{{ __('Cancel') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>