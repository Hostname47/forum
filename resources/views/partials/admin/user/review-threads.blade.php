<div id="user-threads-review-viewer" class="global-viewer full-center none">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="global-viewer-content-box viewer-box-style-2" style="margin-top: -46px;">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color flex align-center">
                <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                {{ __('Threads Review') }}
            </span>
            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div id="threads-review-content-box" class="scrolly" style="max-height: 430px; padding: 10px">
            <div id="threads-review-content">
                @foreach($threads as $thread)
                <x-admin.thread.thread-review-component :thread="$thread"/>
                @endforeach
            </div>
            @if($hasmorethreads)
            <div class="threads-review-load-more" style="padding: 5px;">
                <input type="hidden" class="uid" value="{{ $user->id }}">
                <div class="flex align-center">
                    <div class="relative size13 rounded hidden-overflow">
                        <div class="fade-loading"></div>
                    </div>
                    <div class="relative br3 hidden-overflow mx4" style="width: 80px; height: 16px;">
                        <div class="fade-loading"></div>
                    </div>
                    <div class="relative br3 hidden-overflow" style="width: 10px; height: 10px;">
                        <div class="fade-loading"></div>
                    </div>
                    <div class="relative br3 hidden-overflow mx4" style="width: 80px; height: 16px;">
                        <div class="fade-loading"></div>
                    </div>
                </div>
                <div class="relative br3 hidden-overflow mt8" style="width: 100%; height: 24px;">
                    <div class="fade-loading"></div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>