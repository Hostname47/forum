<div id="faq-{{ $faq->id }}-box" class="faq-container mb4">
    <input type="hidden" class="faq-id" value="{{ $faq->id }}" autocomplete="off">
    <div class="faq-content-container flex">
        <svg class="size15 mr8 mt2" style="min-width: 16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119.08,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.88,199.88,0,0,1,256,456ZM363.24,200.8c0,67.05-72.42,68.08-72.42,92.86V300a12,12,0,0,1-12,12H233.18a12,12,0,0,1-12-12v-8.66c0-35.74,27.1-50,47.58-61.51,17.56-9.85,28.32-16.55,28.32-29.58,0-17.25-22-28.7-39.78-28.7-23.19,0-33.9,11-49,30a12,12,0,0,1-16.66,2.13l-27.83-21.1a12,12,0,0,1-2.64-16.37C184.85,131.49,214.94,112,261.79,112,310.86,112,363.24,150.3,363.24,200.8ZM298,368a42,42,0,1,1-42-42A42,42,0,0,1,298,368Z"></path></svg>
        <div class="toggle-box mt2">
            <div class="toggle-container-button pointer flex">
                <p class="no-margin fs12 bold question-text">{{ $faq->question }}</p>
                <svg class="toggle-arrow size7 mx8 mt4" style="min-width: 7px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/></svg>
            </div>
            <div class="toggle-container">
                <p class="no-margin fs12 lh15 mt4 answer-text">{!! $faq->answer !!}</p>
                @if($faq->live == 0)
                <p class="no-margin fs11 lh15 mt4 answer-text"><strong class="no-wrap">Description :</strong> {{ ($faq->desc) ? $faq->desc : '--' }}</p>
                @endif
                <p class="no-margin bold fs11 mt2">asked by : <a href="{{ route('admin.user.manage', ['uid'=>$faq->user->id]) }}" class="blue no-underline fs13">{{ $faq->user->username }}</a></p>
            </div>
        </div>
        <div class="move-to-right flex align-center height-max-content">
            <div class="gray height-max-content mx8 fs10">•</div>
            <div class="relative">
                <svg class="size16 mt2 button-with-suboptions pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"></path></svg>
                <div class="typical-suboptions-container suboptions-container width-max-content" style="right: 0; max-width: 150px;">
                    <!-- make faq live or unverified -->
                    @if($faq->live == 1)
                    <div class="typical-suboption flex mb2 change-faq-state">
                        <input type="hidden" class="state" value="0" autocomplete="off"> <!-- change state of faq to idle (unverified faqs) -->
                        <div class="relative size14 mr4" style="min-width: 14px;">
                            <svg class="flex size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M509.38,154.25c-7,14.45-19,24.74-30,35.79Q355.7,313.75,232,437.42c-22.66,22.66-43.61,22.66-66.28,0Q102.36,374.07,39,310.7c-20.49-20.51-20.54-42.45-.21-62.84q13-13.1,26.14-26.15c19-18.94,41.6-19,60.84,0,22.23,22,44.46,44,66.25,66.49,5.28,5.45,7.9,5.91,13.58.19q99.87-100.58,200.3-200.58,32-32,64.27.13c6.05,6,11.87,12.28,18.14,18.06,9.06,8.34,16.86,17.47,21.05,29.26ZM196.82,420c6.06-.22,8-3.47,10.35-5.85q62.7-62.6,125.32-125.28Q401.17,220.2,470,151.63c6.28-6.22,6.37-10.36-.09-16.15-8-7.17-15.27-15.1-22.87-22.68-8.86-8.84-9.37-8.85-18-.18L215.2,326.36c-12.57,12.56-20.15,12.58-32.65.11-26.61-26.55-53.34-53-79.67-79.8-5.89-6-9.85-5.93-15.4.16-8.08,8.86-16.71,17.24-25.43,25.48-5,4.7-5.24,8.4-.24,13.39q65.49,65.16,130.72,130.6C194.31,418.08,196,420.05,196.82,420ZM10.81,52.54c-3.33,4.07-2.16,9.85,1.8,13.94,5,5.14,10.12,10.16,15.19,15.23,11.9,11.9,23.77,23.84,35.74,35.68,1.84,1.81,1.85,2.86,0,4.69q-24.63,24.44-49.11,49c-7.24,7.25-7.22,13,.09,20.3l7.15,7.14c6.23,6.2,12.51,6.24,18.69.07C56.8,182.2,73.28,165.8,89.59,149.24c2.38-2.41,3.58-2.28,5.87,0,16.17,16.39,32.5,32.64,48.77,48.92,6.68,6.69,12.8,6.78,19.36.07,4.57-4.67,9.92-8.67,12.76-14.86l.24-1.52c-.65-4.93-3.43-8.26-6.62-11.43-16.16-16.08-32.21-32.25-48.4-48.29-1.94-1.92-1.89-3,0-4.89,15.8-15.66,31.49-31.44,47.24-47.15,3.3-3.29,6.65-6.5,7.91-11.39l-.26-1.9a50,50,0,0,0-21.15-21.11l-1.74-.23c-4.6,1.1-7.72,4.07-10.81,7.18C126,59.51,109.2,76.25,92.51,93.13,75.82,76.24,59,59.5,42.24,42.67c-2.9-2.92-5.86-5.68-10-7l-2.41.06C21.47,39.11,16.16,46,10.81,52.54Z"/></svg>
                            <svg class="spinner size14 opacity0 absolute" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="fs12 bold lblack unselectable block">Make it Idle</span>
                            <p class="fs11 lblack no-margin">Hide faq from users in faqs page, and move it to unverified faqs section</p>
                        </div>
                    </div>
                    @else
                    <div class="typical-suboption flex mb2 change-faq-state">
                        <input type="hidden" class="state" value="1" autocomplete="off"> <!-- change state of faq to live -->
                        <div class="relative size14 mr4 mt2 full-center" style="min-width: 14px;">
                            <svg class="flex size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M2.79,102.72c4.31-9.34,12.35-15.47,19.73-22C28.39,75.56,37,76.92,43.09,83c9.1,9,18.16,18,27.05,27.13,2.18,2.24,3.23,2.22,5.44,0Q115.69,69.72,156,29.55c8.05-8,16.89-8.1,24.91-.17,3.42,3.38,6.81,6.79,10.2,10.19,8.11,8.17,8.15,17,0,25.19Q142.55,113.35,94,161.87c-3.22,3.22-6.38,6.5-9.67,9.65-7,6.67-16.17,6.71-23-.08C43.46,153.7,25.72,135.84,7.87,118.1c-2.29-2.27-3.35-5.21-5.08-7.78ZM183.44,52.56c.11-1.57-.86-2.28-1.65-3.08-3.2-3.23-6.43-6.44-9.65-9.66-3.53-3.52-3.74-3.53-7.22,0L79.37,125.31c-5,5-8.06,5-13.07,0-10.56-10.53-21.18-21-31.61-31.67-2.59-2.66-4.31-2.6-6.71.09-3,3.39-6.3,6.57-9.65,9.65-2.27,2.1-2.32,3.69-.07,5.92q26,25.79,51.76,51.75c2.12,2.13,3.65,2,5.67-.06,5.46-5.62,11-11.11,16.59-16.66q44.25-44.25,88.48-88.51C181.8,54.8,183.18,54,183.44,52.56Z"/></svg>
                            <svg class="spinner size14 opacity0 absolute" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="fs12 bold lblack unselectable">Make it <span class="green">Live</span></span>
                            <p class="fs11 lblack no-margin">Once you review and handle i18n of this faq, you can make it public by clicking here</p>
                        </div>
                    </div>
                    @endif
                    <!-- Edit faq -->
                    <div class="typical-suboption flex align-center mb2 open-faq-edit-container">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.51,334.33l28.28-28.27a7.1,7.1,0,0,1,12.11,5V439.58A42.43,42.43,0,0,1,355.48,482H44.42A42.43,42.43,0,0,1,2,439.58V128.52A42.43,42.43,0,0,1,44.42,86.1H286.11a7.12,7.12,0,0,1,5,12.11l-28.28,28.28a7,7,0,0,1-5,2H44.42V439.58H355.48V339.28A7,7,0,0,1,357.51,334.33ZM495.9,156,263.84,388.06,184,396.9a36.5,36.5,0,0,1-40.29-40.3l8.83-79.88L384.55,44.66a51.58,51.58,0,0,1,73.09,0l38.17,38.17A51.76,51.76,0,0,1,495.9,156Zm-87.31,27.31L357.25,132,193.06,296.25,186.6,354l57.71-6.45Zm57.26-70.43L427.68,74.7a9.23,9.23,0,0,0-13.08,0L387.29,102l51.35,51.34,27.3-27.3A9.41,9.41,0,0,0,465.85,112.88Z"></path></svg>
                        <span class="fs12 bold lblack unselectable">Edit faq</span>
                    </div>
                    <!-- Delete faq -->
                    <div class="typical-suboption flex align-center mb2 open-faq-delete-container">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"></path></svg>
                        <span class="fs12 bold lblack unselectable">Delete faq</span>
                    </div>
                </div>
            </div>
            <div class="gray height-max-content mx8 fs10">•</div>
            <p class="no-margin fs11 bold lblack mr4 no-wrap">priority :</p>
            <input type="text" @if($faq->live == 0) disabled="disabled" @endif class="faq-priority styled-input fs11" value="{{ $faq->priority }}" autocomplete="off" style="padding: 3px 6px; width: 36px;">
        </div>
    </div>
    <div class="faq-edit-container none">
        <input type="hidden" class="original-faq-question" value="{{ $faq->question }}" autocomplete="off">
        <input type="hidden" class="original-faq-answer" value="{{ $faq->answer }}" autocomplete="off">

        <div class="mb8 error-container white-background flex align-center relative none" style="padding: 6px 10px">
            <svg class="size12 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
            <span class="error fs12 bold no-margin thread-edit-error"></span>

            <div class="open-revoke-role-dialog x-close-container-style close-parent" style="top: 4px; right: 8px">
                <span class="x-close unselectable">✖</span>
                <input type="hidden" class="uid" value="2" autocomplete="off">
            </div>
        </div>
        
        <label for="{{ 'faq-' . $faq->id }}" class="fs12 bold lblack flex mb2">Question</label>
        <input type="text" id="{{ 'faq-' . $faq->id }}" class="styled-input faq-question" value="{{ $faq->question }}" autocomplete="off" placeholder="Question here">

        <label for="{{ 'faqa-' . $faq->id }}" class="fs12 bold lblack flex mt8 mb2">Answer</label>
        <textarea id="{{ 'faqa-' . $faq->id }}" class="styled-input faq-answer faq-answer-input" placeholder="Answer to question here" autocomplete="off">{{ $faq->answer }}</textarea>

        <div class="flex align-center mt8">
            <div class="typical-button-style flex align-center mr8 update-faq">
                <div class="relative size14 mr4">
                    <svg class="size13 icon-above-spinner mr4" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"/><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"/></svg>
                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <div class="btn-text fs12 bold">Save changes</div>
                <input type="hidden" class="faq-id" value="{{ $faq->id }}" autocomplete="off">
            </div>
            <div class="pointer bblack bold fs12 discard-faq-update">cancel</div>
        </div>
    </div>
</div>