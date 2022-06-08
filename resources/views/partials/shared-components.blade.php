<!-- Top message informer notification -->
<div class="full-width full-center top-informer-box none">
    <div class="top-informer-container">
        <div class="flex align-center">
            <div style="max-height: 14px" class="top-informer-icon-box none">
                <svg class="top-informer-error-icon tiei-icon size13 mr8 none" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
            </div>
            <p class="no-margin unselectable top-informer-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
        </div>
        <div class="remove-top-informer-container x-close-style" style="top: 8px;">
            <svg class="size12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 298.67 298.67"><polygon points="298.67 30.19 268.48 0 149.33 119.15 30.19 0 0 30.19 119.15 149.33 0 268.48 30.19 298.67 149.33 179.52 268.48 298.67 298.67 268.48 179.52 149.33 298.67 30.19"/></svg>
        </div>
    </div>
</div>

<!-- Left-bottom notification -->
<a href="" class="bl-notification-container relative link-wraper none flex">
    <input type="hidden" class="notification-id" autocomplete="off">
    <div class='flex'>
        <div class="mr8 relative" style="height: max-content">
            <img src="" class="bl-notification-image size56 rounded" alt="">
            <div class="bl-notification-action-icon rounded sprite sprite-2-size icon-type-throw-lot-of-uranium"></div>
        </div>
        <div>
            <div style="margin-bottom: 3px">
                <strong class="bl-notification-bold">Mouad Nassri</strong>
                <span class="inline bl-notification-content">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vitae, suscipit</span>
            </div>
            <p class="no-margin blue fs12 bold">{{ __('Just now') }}</p>
        </div>
    </div>
    <div class="x-close-container x-close-container-style">
        <span class="x-close">✖</span>
    </div>
</a>

<!-- basic notification component -->
<div class="basic-notification-container none">
    <svg class="size15 mt2 mr8 basic-notification-round-tick none" style="min-width: 15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 384"><path d="M192,0C86,0,0,86,0,192S86,384,192,384s192-86,192-192S298,0,192,0Zm0,341.33A149.33,149.33,0,1,1,341.33,192,149.33,149.33,0,0,1,192,341.33Zm0-298.66A149.33,149.33,0,1,0,341.33,192,149.33,149.33,0,0,0,192,42.67ZM171.8,274.31,95.63,201.2l29.55-30.78,44.27,42.49,88.61-99.13,31.81,28.44Z" style="fill:#52e668"/></svg>
    <p class="no-margin basic-notification-content">Thread saved successfully.</p>
</div>

<!-- absolute scrollbar -->
<div id="abs-scrollbar" class="none"></div>

<!-- image viewer -->
<div id="image-viewer" class="global-viewer full-center none" style="background-color: #16171cf0; z-index: 555555">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <style>
        .image-container {
            width: 800px;
            max-width: 800px;
            height: 510px;
            max-height: 510px;
        }
    </style>
    <div class="image-container full-center">
        <img src="" class="image" alt="">
    </div>
</div>