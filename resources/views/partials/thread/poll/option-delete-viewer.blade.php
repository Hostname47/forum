<div id="poll-option-deletion-viewer" class="global-viewer flex justify-center none">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="global-viewer-content-box viewer-box-style-1 vbs-margin-1">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color">{{ __('Delete Option') }}</span>
            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div style="padding: 14px" class="lblack">
            <p class="no-margin mb8 fs14"><strong>{{ __('option to be deleted') }} :</strong> <span class="option-content"></span></p>
            <div class="section-style flex mb8">
                <svg class="size13 mr8 mt2" style="min-width: 13px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                <p class="no-margin lblack fs13">{{ __('Once the option gets deleted, all votes associated to it will be deleted as well. Are you sure you want to delete this option from the poll') }} ?</p>
            </div>
            <div class="flex align-center">
                <div id="delete-poll-option" class="typical-button-style flex align-center move-to-right mr8">
                    <div class="relative size14 mr4">
                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M142.35,257h-25.7c-3.4-2.26-7.46-1.73-11.2-2.56C73.24,247.37,47.5,230.5,27.84,204c-31-41.75-31.65-103-1.32-145.2C61.88,9.58,120.39-8.82,176.78,13.17,215.43,28.24,240.32,57,252.3,96.82c2.06,6.86,2.17,14.11,4.71,20.82v26.69c-1.3.39-1,1.55-1.1,2.44a124.68,124.68,0,0,1-7.69,29.42q-24,58-84.1,76.11C157,254.46,149.44,254.69,142.35,257ZM193.18,88.64c-.8-.92-1.48-1.79-2.25-2.57-5.23-5.25-10.61-10.36-15.66-15.78-2.26-2.43-3.51-2.19-5.73.07-11.77,12-23.83,23.69-35.52,35.74-2.94,3-4.4,2.74-7.2-.14C115.24,94,103.3,82.43,91.65,70.56c-2.31-2.36-3.65-2.79-6.09-.13C80.9,75.53,76,80.42,70.9,85.1c-2.73,2.51-3.05,4-.13,6.81,12.06,11.69,23.76,23.75,35.76,35.5,2.44,2.39,2.52,3.7,0,6.13-12.12,11.87-24,24-36.1,35.87-2.51,2.46-2.47,3.77.06,6.1,5.2,4.79,10.23,9.8,15,15,2.39,2.62,3.72,2.35,6.09-.06,11.75-12,23.82-23.7,35.5-35.76,2.86-2.95,4.29-2.42,6.84.17,11.76,12,23.77,23.75,35.55,35.72,2.17,2.21,3.42,2.63,5.72.14q7.2-7.8,15-15c2.62-2.41,2.89-3.77.13-6.46-12-11.7-23.74-23.77-35.76-35.5-2.63-2.56-2.73-3.87,0-6.49,12-11.72,23.82-23.69,35.69-35.58C191.21,90.76,192.09,89.79,193.18,88.64Z"></path></svg>
                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="bold unselectable">{{__('Delete Option')}}</span>
                    <input type="hidden" class="option-id" autocomplete="off">
                    <input type="hidden" class="success-message" value="Option has been removed successfully" autocomplete="off">
                </div>
                <div class="pointer close-global-viewer forum-color bold">{{ __('Cancel') }}</div>
            </div>
        </div>
    </div>
</div>