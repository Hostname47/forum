<div class="contact-message-component">
    <input type="hidden" class="mid" autocomplete="off" value="{{ $message->id }}">
    <div class="none cmessage-hidden-box">
        <div class="cmessage-display-switch fs12 bold lblack pointer p8">message hidden. click here to display it again</div>
    </div>
    <div class="flex mb8 contact-message-box">
        <div class="size48 br4 hidden-overflow" style="border: 1px solid #cacaca; min-width: 48px; margin-right: 10px">
            @if(is_null($message->user))
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
            <div class="contact-message-content">
                <!-- contact message owner name and username -->
                <div class="flex align-center mb2">
                    @if(!is_null($message->user))
                    <div class="bold fs13 flex align-center">
                        <a href="{{ $owner->profilelink }}" class="fs14 blue no-underline mr4">{{ $owner->fullname }}</a>
                        <span class="gray fs11">&lt;{{ $owner->username }}&gt;</span>
                    </div>
                    @else
                    <div class="bold fs13">
                        <span class="fs14 lblack no-underline mr4">guest</span>
                        <span class="lblack"><{{ $message->ip }}></span>
                    </div>
                    @endif
                    @if(!$onlymessage)
                    <!-- mark message as read -->
                    <div class="ml8 cm-read-box">
                        @if($message->read)
                        <div title="read">
                            <svg class="size16" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.79,71.38q-34.33,34.22-68.67,68.44Q158,168.88,129,198c-2.32,2.33-3.56,2.71-6.08.15q-27.33-27.69-55-55c-2-2-2.59-3.2-.15-5.34a104.45,104.45,0,0,0,10.09-10.09c2.19-2.53,3.38-1.78,5.34.2,12.92,13.08,26.06,25.94,38.9,39.1,2.89,3,4.33,3.36,7.5.13C165,131.2,200.51,95.49,235.85,59.56c3-3.05,4.56-3.27,7.6-.15,3.82,3.93,7.46,8.19,12.34,11ZM124.06,137.51c1.5,1.52,2.34,1.45,3.86-.07q32-32.11,64.05-64.06c1.53-1.52,2.14-2.47.2-4.25C188.3,65.58,184.61,61.83,181,58c-1.73-1.85-2.73-1.4-4.3.17-21.9,22-43.85,43.87-66.14,66.12C115.2,128.77,119.7,133.07,124.06,137.51Zm-106.53-11C13.35,130.71,9.23,134.93,5,139c-1.78,1.73-.24,2.52.74,3.5Q33.88,170.71,62,198.91c1.94,2,3,1.56,4.63-.17,3.37-3.58,6.79-7.13,10.44-10.41,2.18-2,1.79-3.08-.11-5q-28.09-27.87-56-55.92c-.67-.66-1.38-1.28-2.08-1.94A16.78,16.78,0,0,0,17.53,126.54Z"/></svg>
                        </div>
                        @else
                            @if($can_read)
                            <div title="mark as read">
                                <svg class="size16 pointer cm-mark-as-read" fill="#313131" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.79,71.38q-34.33,34.22-68.67,68.44Q158,168.88,129,198c-2.32,2.33-3.56,2.71-6.08.15q-27.33-27.69-55-55c-2-2-2.59-3.2-.15-5.34a104.45,104.45,0,0,0,10.09-10.09c2.19-2.53,3.38-1.78,5.34.2,12.92,13.08,26.06,25.94,38.9,39.1,2.89,3,4.33,3.36,7.5.13C165,131.2,200.51,95.49,235.85,59.56c3-3.05,4.56-3.27,7.6-.15,3.82,3.93,7.46,8.19,12.34,11ZM124.06,137.51c1.5,1.52,2.34,1.45,3.86-.07q32-32.11,64.05-64.06c1.53-1.52,2.14-2.47.2-4.25C188.3,65.58,184.61,61.83,181,58c-1.73-1.85-2.73-1.4-4.3.17-21.9,22-43.85,43.87-66.14,66.12C115.2,128.77,119.7,133.07,124.06,137.51Zm-106.53-11C13.35,130.71,9.23,134.93,5,139c-1.78,1.73-.24,2.52.74,3.5Q33.88,170.71,62,198.91c1.94,2,3,1.56,4.63-.17,3.37-3.58,6.79-7.13,10.44-10.41,2.18-2,1.79-3.08-.11-5q-28.09-27.87-56-55.92c-.67-.66-1.38-1.28-2.08-1.94A16.78,16.78,0,0,0,17.53,126.54Z"/></svg>
                            </div>
                            @else
                            <div title="You cannot mark messages as read due to lack of permission">
                                <svg class="size16 cursor-not-allowed" fill="#313131" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.79,71.38q-34.33,34.22-68.67,68.44Q158,168.88,129,198c-2.32,2.33-3.56,2.71-6.08.15q-27.33-27.69-55-55c-2-2-2.59-3.2-.15-5.34a104.45,104.45,0,0,0,10.09-10.09c2.19-2.53,3.38-1.78,5.34.2,12.92,13.08,26.06,25.94,38.9,39.1,2.89,3,4.33,3.36,7.5.13C165,131.2,200.51,95.49,235.85,59.56c3-3.05,4.56-3.27,7.6-.15,3.82,3.93,7.46,8.19,12.34,11ZM124.06,137.51c1.5,1.52,2.34,1.45,3.86-.07q32-32.11,64.05-64.06c1.53-1.52,2.14-2.47.2-4.25C188.3,65.58,184.61,61.83,181,58c-1.73-1.85-2.73-1.4-4.3.17-21.9,22-43.85,43.87-66.14,66.12C115.2,128.77,119.7,133.07,124.06,137.51Zm-106.53-11C13.35,130.71,9.23,134.93,5,139c-1.78,1.73-.24,2.52.74,3.5Q33.88,170.71,62,198.91c1.94,2,3,1.56,4.63-.17,3.37-3.58,6.79-7.13,10.44-10.41,2.18-2,1.79-3.08-.11-5q-28.09-27.87-56-55.92c-.67-.66-1.38-1.28-2.08-1.94A16.78,16.78,0,0,0,17.53,126.54Z"/></svg>
                            </div>
                            @endif
                        @endif
                    </div>
                    @endif
                </div>
                <!-- company and phone -->
                <div class="flex align-center mb2">
                    <div class="fs11">
                        <span class="bold lblack">Company :</span>
                        @if(is_null($message->company))
                            <em class="gray">Not defined</em>
                        @else
                            <span>{{ $message->company }}</span>
                        @endif
                    </div>
                    <span class="mx8 fs10">•</span>
                    <div class="fs11">
                        <span class="bold lblack">Phone :</span>
                        @if(is_null($message->phone))
                            <em class="gray">Not defined</em>
                        @else
                            <span>{{ $message->phone }}</span>
                        @endif
                    </div>
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
                        {{ $message->mediumslice }}
                    </span>
                    @if($message->message != $message->mediumslice)
                    <input type="hidden" class="expand-slice-text" value="{{ $message->mediumslice }}" autocomplete="off">
                    <input type="hidden" class="expand-whole-text" value="{{ $message->message }}" autocomplete="off">
                    <input type="hidden" class="expand-text-state" value="0" autocomplete="off">
                    <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                    <input type="hidden" class="expand-text" value="{{ __('see all') }}" autocomplete="off">
                    <input type="hidden" class="collapse-text" value="{{ __('see less') }}" autocomplete="off">
                    @endif
                </div>
            </div>
        </div>
        @if(!$onlymessage)
        <div class="flex flex-column align-center relative height-max-content ml8">
            <div class="relative">
                <svg class="pointer button-with-suboptions size16 mt8 more-button-style-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
                <div class="suboptions-container suboptions-container-right-style">
                    <div class="simple-suboption cmessage-display-switch flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.03 490.03"><path d="M435.67,54.31a18,18,0,0,0-25.5,0l-64,64c-79.3-36-163.9-27.2-244.6,25.5C41.47,183,5,232.31,3.47,234.41a18.16,18.16,0,0,0,.5,22c34.2,42,70,74.7,106.6,97.5l-56.3,56.3a18,18,0,1,0,25.4,25.5l356-355.9A18.11,18.11,0,0,0,435.67,54.31ZM200.47,264a46.82,46.82,0,0,1-3.9-19,48.47,48.47,0,0,1,67.5-44.6Zm90.2-90.1a84.37,84.37,0,0,0-116.6,116.6L137,327.61c-32.5-18.8-64.5-46.6-95.6-82.9,13.3-15.6,41.4-45.7,79.9-70.8,66.6-43.4,132.9-52.8,197.5-28.1Zm195.4,59.7c-24.7-30.4-50.3-56-76.3-76.3a18.05,18.05,0,1,0-22.3,28.4c20.6,16.1,41.2,36.1,61.2,59.5a394.59,394.59,0,0,1-66,61.3c-60.1,43.7-120.8,59.5-180.3,46.9a18,18,0,0,0-7.4,35.2,224.08,224.08,0,0,0,46.8,4.9,237.92,237.92,0,0,0,71.1-11.1c31.1-9.7,62-25.7,91.9-47.5,50.4-36.9,80.5-77.6,81.8-79.3A18.16,18.16,0,0,0,486.07,233.61Z"/></svg>
                        <div class="fs12 bold">{{ __('Hide message') }}</div>
                    </div>
                    @if($can_delete)
                    <div class="simple-suboption delete-cmessage flex align-center">
                        <div class="relative size14 mr4">
                            <svg class="size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <div class="spinner size14 opacity0 absolute" fill="#2ca0ff" style="top: 0; left: 0">
                                <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                            </div>
                        </div>
                        <div class="fs12 bold">{{ __('Delete message') }}</div>
                        <input type="hidden" class="message-after-delete" value="Message delete successfully.">
                    </div>
                    @else
                    <div class="simple-suboption cursor-not-allowed flex">
                        <svg class="size14 mr4 mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <div>
                            <p class="no-margin fs12 bold">{{ __('Delete message') }}</p>
                            <p class="no-margin fs11 button-text">{{ __('You cannot delete messages due to lack of permission') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="custom-checkbox-button">
                <div class="custom-checkbox select-cm-checkbox mt8 size16" style="border-radius: 2px">
                    <svg class="size12 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                    <input type="hidden" class="checkbox-status" autocomplete="off" value="0">
                    <input type="hidden" class="mid" value="{{ $message->id }}" autocomplete="off">
                    <input type="hidden" class="cm-read" value="{{ $message->read }}" autocomplete="off">
                </div>
            </div>
        </div>
        @endif
    </div>
</div>