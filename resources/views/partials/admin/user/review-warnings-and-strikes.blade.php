<div id="user-warnings-and-strikes-review-viewer" class="global-viewer full-center none">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="global-viewer-content-box viewer-box-style-2" style="margin-top: -46px;">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color flex align-center">
                <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                {{ __('Review user warnings and strikes') }}
            </span>
            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div id="review-warnings-and-strikes-content-box" class="scrolly" style="max-height: 430px; padding: 10px">
            <div id="review-warnings-and-strikes-content">
                @if(!$strikes->count() && !$warnings->count())
                    <div class="full-center" style="margin: 28px 0">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                        <p class="bold my4" style="color: #44a644">{{ __("Profile is clean ! no strikes or warnings.") }}</p>
                    </div>
                @else
                    @if($warnings->count())
                    <div class="flex align-center">
                        <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                        <h2 class="my8 fs16 lblack">{{ __('Warnings') }}</h2>
                    </div>
                    <table style="margin-bottom: 16px">
                        <thead>
                            <tr>
                                <th id="strike-col">{{__('Warning')}}</th>
                                <th id="resource-col">{{__('Resource')}}</th>
                                <th id="strike-date">{{__('Warning date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($warnings as $warning)
                            <x-user.warning-component :warning="$warning"/>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    @if($strikes->count())
                    <div class="flex align-center">
                        <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                        <h2 class="my8 fs16 lblack">{{ __('Strikes') }}</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th id="strike-col">{{__('Strike')}}</th>
                                <th id="resource-col">{{__('Resource')}}</th>
                                <th id="strike-date">{{__('Strike date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($strikes as $strike)
                            <x-user.strike-component :strike="$strike"/>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                @endif
            </div>
        </div>
    </div>
</div>