<div class="feedback-component">
    <input type="hidden" class="feedback-id" autocomplete="off" value="{{ $feedback->id }}">
    <div class="none feedback-hidden-box">
        <div class="feedback-display-switch fs12 bold lblack pointer p8">message hidden. click here to display it again</div>
    </div>
    <div class="flex mb8 feedback-box">
        <div class="size48 br4 hidden-overflow" style="border: 1px solid #cacaca; min-width: 48px; margin-right: 10px">
            @if(is_null($feedback->user_id))
            <div class="full-dimensions full-center" style="background-color: white">
                <span class="fs12 gray bold unselectable">guest</span>
            </div>
            @else
            <a href="{{ $owner->profilelink }}">
                <img src="{{ $owner->sizedavatar(100, '-l') }}" class="handle-image-center-positioning" alt="">
            </a>
            @endif
        </div>
        <div>
            <div class="feedback-message-content">
                <!-- feedback owner name and username -->
                <div class="flex align-center mb2">
                    @if(!is_null($feedback->user_id))
                    <div class="bold fs13 flex align-center">
                        <a href="{{ $owner->profilelink }}" class="fs14 blue no-underline mr4">{{ $owner->fullname }}</a>
                        <span class="gray fs11">&lt;{{ $owner->username }}&gt;</span>
                    </div>
                    @else
                    <div class="bold fs13">
                        <span class="fs14 lblack no-underline mr4">guest</span>
                        <span class="lblack"><{{ $feedback->ip }}></span>
                    </div>
                    @endif
                </div>
                <!-- date -->
                <div class="relative height-max-content">
                    <p class="no-margin fs11 tooltip-section gray width-max-content"><span class="bold lblack mr4">Date :</span>{{ $at_hummans }}</p>
                    <div class="tooltip tooltip-style-1">
                        {{ $at }}
                    </div>
                </div>
                <!-- contact message content -->
                <div class="expand-box mt8">
                    <span class="black fs15 no-underline expandable-text full-width" style="line-height: 1.4">
                        {{ $feedback->mediumslice }}
                    </span>
                    @if($feedback->feedback != $feedback->mediumslice)
                    <input type="hidden" class="expand-slice-text" value="{{ $feedback->mediumslice }}" autocomplete="off">
                    <input type="hidden" class="expand-whole-text" value="{{ $feedback->feedback }}" autocomplete="off">
                    <input type="hidden" class="expand-text-state" value="0" autocomplete="off">
                    <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                    <input type="hidden" class="expand-text" value="{{ __('see all') }}" autocomplete="off">
                    <input type="hidden" class="collapse-text" value="{{ __('see less') }}" autocomplete="off">
                    @endif
                </div>
            </div>
        </div>
        <div class="flex flex-column align-center relative height-max-content ml8">
            <div class="relative">
                <svg class="pointer button-with-suboptions size16 mt8 more-button-style-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
                <div class="suboptions-container suboptions-container-right-style" style="max-width: 200px">
                    <div class="simple-suboption feedback-display-switch flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.03 490.03"><path d="M435.67,54.31a18,18,0,0,0-25.5,0l-64,64c-79.3-36-163.9-27.2-244.6,25.5C41.47,183,5,232.31,3.47,234.41a18.16,18.16,0,0,0,.5,22c34.2,42,70,74.7,106.6,97.5l-56.3,56.3a18,18,0,1,0,25.4,25.5l356-355.9A18.11,18.11,0,0,0,435.67,54.31ZM200.47,264a46.82,46.82,0,0,1-3.9-19,48.47,48.47,0,0,1,67.5-44.6Zm90.2-90.1a84.37,84.37,0,0,0-116.6,116.6L137,327.61c-32.5-18.8-64.5-46.6-95.6-82.9,13.3-15.6,41.4-45.7,79.9-70.8,66.6-43.4,132.9-52.8,197.5-28.1Zm195.4,59.7c-24.7-30.4-50.3-56-76.3-76.3a18.05,18.05,0,1,0-22.3,28.4c20.6,16.1,41.2,36.1,61.2,59.5a394.59,394.59,0,0,1-66,61.3c-60.1,43.7-120.8,59.5-180.3,46.9a18,18,0,0,0-7.4,35.2,224.08,224.08,0,0,0,46.8,4.9,237.92,237.92,0,0,0,71.1-11.1c31.1-9.7,62-25.7,91.9-47.5,50.4-36.9,80.5-77.6,81.8-79.3A18.16,18.16,0,0,0,486.07,233.61Z"/></svg>
                        <div class="fs12 bold">{{ __('Hide feedback') }}</div>
                    </div>
                    @if($can_delete)
                    <div class="simple-suboption delete-feedback flex align-center">
                        <div class="flex relative size12 mr4">
                            <svg class="size12 icon-above-spinner" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <div class="fs12 bold">{{ __('Delete feedback') }}</div>
                    </div>
                    @else
                    <div class="simple-suboption flex cursor-not-allowed">
                        <svg class="size12 mr4 mt2" style="min-width: 12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <div>
                            <div class="fs12 bold">{{ __('Delete feedback') }}</div>
                            <p class="no-margin fs11 gray">{{ __('You cannot delete feedbacks due to lack of permission') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="custom-checkbox-button">
                <div class="custom-checkbox select-feedback-checkbox mt8 size16" style="border-radius: 2px">
                    <svg class="size12 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                    <input type="hidden" class="checkbox-status" autocomplete="off" value="0">
                    <input type="hidden" class="fid" value="{{ $feedback->id }}" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
</div>