<div id="user-posts-review-viewer" class="global-viewer full-center none">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="global-viewer-content-box viewer-box-style-2" style="margin-top: -46px;">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color flex align-center">
                <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                {{ __('Replies Review') }}
            </span>
            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div id="posts-review-content-box" class="scrolly" style="max-height: 430px; padding: 10px">
            <div id="posts-review-content">
                @foreach($posts as $post)
                <x-admin.post.post-review-component :post="$post"/>
                @endforeach
            </div>
            @if($hasmorethreads)
            <div class="posts-review-load-more" style="padding: 5px;">
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