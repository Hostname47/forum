<div id="auth-breaks-review-viewer" class="global-viewer full-center none" style="z-index: 55555">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="global-viewer-content-box viewer-box-style-2" style="margin-top: -26px; max-height: 90%; width: 580px; overflow-y: scroll">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color flex align-center">
                <svg class="size24 mr8" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M231,130.52c0,16.59-.13,33.19.06,49.78.08,6.24-2.44,10.4-7.77,13.46q-43.08,24.72-86,49.68c-5.52,3.21-10.45,3-16-.2Q78.8,218.46,36.1,194.09c-5.91-3.37-8.38-7.8-8.34-14.61q.3-49,0-98.1c0-6.63,2.49-10.93,8.2-14.19Q78.68,42.82,121.15,18c5.69-3.32,10.69-3.42,16.38-.1Q180,42.71,222.7,67.1c5.89,3.36,8.46,7.8,8.35,14.61C230.77,98,231,114.25,231,130.52Zm-179.67,0c0,44.84,33,78,77.83,78.16s78.37-33.05,78.39-78.08c0-44.88-32.93-78-77.83-78.14S51.32,85.49,51.29,130.55Z" style="fill:#020202"/><path d="M129.35,150.13c-13.8,0-27.61,0-41.42,0-8.69,0-13.85-6-13.76-15.79.09-9.62,5.15-15.43,13.6-15.44q40,0,79.93,0c13.05,0,19,7.43,16.37,20.38-1.46,7.17-5.92,10.85-13.29,10.86C157,150.15,143.16,150.13,129.35,150.13Z" style="fill:#020202"/></svg>
                {{ __('Authorization breaks review') }}
            </span>
            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div style="padding: 14px;">
            @foreach($authbreaks as $ab)
            <div class="flex align-center my8">
                <span class="fs13 gray mr4">break :</span>
                <span class="bold fs13 lblack mr4">{{ $ab->type }}</span>
                <div class="relative move-to-right">
                    <span class="gray fs12 mr4">at :</span>
                    <span class="bold lblack fs12">{{ $ab->break_date }}</span>
                </div>
            </div>
            @endforeach
            @if(!count($authbreaks))
                <div class="full-center" style="margin: 28px 0">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                    <p class="bold my4" style="color: #44a644">{{ __("This user has no authorization breaks.") }}</p>
                </div>
            @endif
        </div>
    </div>
</div>