<div class="activity-thread-wrapper thread-container-box relative" style="background-color: white; padding: 0">
    <div class="thread-component">
        <div class="full-width">
            <div class="flex" style="padding: 10px">
                <div class="flex align-center height-max-content mr8">
                    <div class="flex flex-column align-center">
                        <div class="size48 rounded hidden-overflow mb8" style="min-width: 48px">
                            <a href="{{ $announcement->user->profilelink }}">
                                <img src="{{ asset($announcement->user->sizedavatar(100, '-h')) }}" class="handle-image-center-positioning" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="full-width">
                    <div class="flex space-between">
                        <div>
                            <a href="" class="block blue bold no-underline">{{ $owner->username }}</a>
                            <div class="flex align-center my4">
                                <span class="mr4 fs12 bold lblack">{{__('Forum')}} :</span>
                                <div class="flex align-center">
                                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        {!! $announcement->category->forum->icon !!}
                                    </svg>
                                    <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ __($forum->forum) }}</a>
                                    @if($announcement->type == 'poll')
                                        <span class="fs10 gray" style="margin: 0 4px 2px 4px">•</span>
                                        <div class="flex" title="{{ __('poll') }}">
                                            <svg class="size12" style="fill:#202020;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M302.16,471.18H216a14,14,0,0,1-14-14V53.47a14,14,0,0,1,14-14h86.18a14,14,0,0,1,14,14V457.15A14,14,0,0,1,302.16,471.18ZM162.78,458.53V146.85a14,14,0,0,0-14-14H62.57a14,14,0,0,0-14,14V458.53a14,14,0,0,0,14,14h86.17A14,14,0,0,0,162.78,458.53Zm300.69,0V220a14,14,0,0,0-14-14H363.26a14,14,0,0,0-14,14V458.53a14,14,0,0,0,14,14h86.17A14,14,0,0,0,463.47,458.53Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex height-max-content move-to-right">
                            <div class="simple-border-container">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style></defs><path class="cls-1" d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                                <p class="fs12 no-margin unselectable">{{ $announcement->view_count }} {{ __('views') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative flex align-center" style="margin-top: -2px">
                        <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Posted') }}: {{ $at_hummans }}</p>
                        <div class="tooltip tooltip-style-1">
                            {{ $at }}
                        </div>
                        <span class="fs10 gray" style="margin: 2px 4px">•</span>
                        <div class="size12" title="{{ $announcement->visibility->visibility }}">
                            <svg class="size12 thread-resource-visibility-icon" style="fill: #202020; margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                {!! $announcement->visibility->icon !!}
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="thread-content-section">
                @if($type == 'discussion')
                <div>
                    <a href="{{ $announcement->announcement_link }}" class="blue no-underline bold flex fs18" style="margin: 0 10px">{!! $announcement->subject !!}</a>
                    <div>
                        <div class="thread-content-box thread-content-box-max-height" style="margin: 4px 10px 4px 10px">
                            <div class="thread-content">{!! $content !!}</div>
                            <input type="hidden" class="expand-state" autocomplete="off" value="0">
                            <input type="hidden" class="expand-button-text" autocomplete="off" value="{{ __('see all') }}">
                            <input type="hidden" class="expand-button-collapse-text" autocomplete="off" value="{{ __('see less') }}">
                        </div>
                        <div class="expend-thread-content-button none">
                            <span class="btn-text">{{ __('see all') }}</span>
                            <svg class="size7 expand-arrow" style="margin-left: 5px; fill: #2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36">
                                <path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/>
                            </svg>
                            <input type="hidden" class="down-arr" value="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z">
                            <input type="hidden" class="up-arr" value="M286.93,223.05a17.5,17.5,0,0,1-12.84,5.38H18.27a17.58,17.58,0,0,1-12.85-5.38,18,18,0,0,1-.34-25.36l.34-.33L133.33,69.43a17.92,17.92,0,0,1,25.34-.36l.36.36,127.9,127.93a17.9,17.9,0,0,1,.36,25.32Z">
                        </div>
                    </div>
                </div>
                @elseif($type == 'poll')
                <div class="thread-content-padding" style="padding-bottom: 0">
                    <div class="expand-box" style="margin-bottom: 16px">
                        <span class="expandable-text bold lblack fs16">{!! $announcement->mediumslice !!}</span>
                        @if($announcement->mediumslice != $announcement->subject)
                        <input type="hidden" class="expand-slice-text" value="{{ $announcement->mediumslice }}">
                        <input type="hidden" class="expand-whole-text" value="{{ $announcement->subject }}">
                        <input type="hidden" class="expand-text-state" value="0">
                        <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                        <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                        <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                        @endif
                    </div>
                    <!-- poll-options -->
                    <div class="poll-options-wrapper option-add-pow">
                        <input type="hidden" class="uniqueness-pass" autocomplete="off" value="1">
                        <!-- messages -->
                        <input type="hidden" class="length-error" value="{{ __('Option must contains at least 1 character') }}">
                        <input type="hidden" class="uniqueness-error" value="{{ __('Option already exists') }} !">
                        <input type="hidden" class="owner-options-limit-error" value="{{ __('Poll could have only 30 options max') }} !">
                        <input type="hidden" class="notowner-options-limit-error" value='{{ __("You could only add one option in other people polls") }} !'>

                        <div class="mt8 thread-poll-options-container @if($multiple_choice) checkbox-group @else radio-group @endif">
                            <input type="hidden" class="total-poll-votes" autocomplete="off" value="{{ $poll_total_votes }}">
                            @foreach($options as $option)
                                @if($loop->index < 5)
                                <x-thread.poll-option-component
                                    :option="$option" 
                                    :multiplechoice="$multiple_choice" 
                                    :allowoptionscreation="$allow_options_creation"
                                    :totalpollvotes="$poll_total_votes" 
                                    :pollownerid="$owner->id"
                                    :totalpollvotes="$poll_total_votes"/>
                                @else
                                <x-thread.poll-option-component
                                    :option="$option"
                                    :multiplechoice="$multiple_choice"
                                    :allowoptionscreation="$allow_options_creation"
                                    :totalpollvotes="$poll_total_votes"
                                    :pollownerid="$owner->id"
                                    classes="none"/>
                                @endif
                            @endforeach
                            @if($options->count() > 5)
                            <div class="flat-button-style unselectable options-display-switch poll-options-vertical-inputs-style border-box" style="padding: 10px">
                                {{ __('Load more options') }}
                                <svg class="size7 mx4 more-ico" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                            </div>
                            @endif
                        </div>
                        @if($could_add_choice)
                        <div class="thread-add-poll-option-container poll-option-validation-box my8 poll-options-vertical-inputs-style">
                            <div class="simple-line-separator my8"></div>
                            <div class="my4 pr8 pt8 poll-option-input-error none">
                                <div class="flex align-center">
                                    <svg class="size12 mr4" style="fill: rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                    <span class="error fs12 bold no-margin"></span>
                                </div>
                            </div>
                            <div class="flex align-center dynamic-input-wrapper">
                                <span class="dynamic-label">{{ __('Add an option') }}</span>
                                <input type="text" maxlength="140" name="option" class="input-with-dynamic-label poll-option-validation poll-option-value full-width fs15" autocomplete="off">
                                <input type="hidden" class="poll-id" value="{{ $poll->id }}">
                                <input type="hidden" class="option-saved-message" value="{{ __('Your option is saved successfully') }} !">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                <!-- media content -->
                @if($type=='discussion' AND $announcement->has_media)
                <div class="thread-medias-container">
                    <input type="hidden" class="thread-id" value="{{ $announcement->id }}">
                    @php
                        $media_count = 0;
                        $mediaslength = count($medias);
                    @endphp
                    @foreach($medias as $media)
                        @if($media['type'] == 'image')
                        <div class="thread-media-container open-media-viewer relative pointer">
                            <div class="thread-image-options">
                                <p class="white"></p>
                            </div>
                            <div class="thread-image-zoomer-container">

                            </div>
                            <div class="fade-loading"></div>
                            <img data-src="{{ asset($media['frame']) }}" alt="" class="thread-media @if($mediaslength > 1) lazy-image @else handle-single-lazy-image-container-unbased @endif image-with-fade">
                            <div class="full-shadow-stretched none">
                                <p class="fs26 bold white unselectable">+<span class="thread-media-more-counter"></span></p>
                            </div>
                            <input type="hidden" class="media-type" value="{{ $media['type'] }}">
                            <input type="hidden" class="media-count" value="{{ $media_count }}">
                        </div>
                        @elseif($media['type'] == 'video')
                        <div class="thread-media-box thread-media-container relative" style="background-color: #0f0f0f">
                            <div class="thread-media-options full-center">
                                @if($announcement->has_media)
                                <svg class="size17 pointer open-media-viewer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0,180V56A23.94,23.94,0,0,1,24,32H148a12,12,0,0,1,12,12V84a12,12,0,0,1-12,12H64v84a12,12,0,0,1-12,12H12A12,12,0,0,1,0,180ZM288,44V84a12,12,0,0,0,12,12h84v84a12,12,0,0,0,12,12h40a12,12,0,0,0,12-12V56a23.94,23.94,0,0,0-24-24H300A12,12,0,0,0,288,44ZM436,320H396a12,12,0,0,0-12,12v84H300a12,12,0,0,0-12,12v40a12,12,0,0,0,12,12H424a23.94,23.94,0,0,0,24-24V332A12,12,0,0,0,436,320ZM160,468V428a12,12,0,0,0-12-12H64V332a12,12,0,0,0-12-12H12A12,12,0,0,0,0,332V456a23.94,23.94,0,0,0,24,24H148A12,12,0,0,0,160,468Z"/></svg>
                                @endif
                            </div>
                            <video class="thread-media full-height full-width" controls preload="none">
                                <source src="{{ asset($media['frame']) }}" type="{{ $media['mime'] }}">
                                {{ __('Your browser does not support the video tag') }}
                            </video>
                            <div class="full-shadow-stretched none">
                                <p class="fs26 bold white unselectable">+<span class="thread-media-more-counter"></span></p>
                            </div>
                            <input type="hidden" class="media-type" value="{{ $media['type'] }}">
                            <input type="hidden" class="media-count" value="{{ $media_count }}">
                        </div>
                        @endif
                        @php
                            $media_count++;
                        @endphp
                    @endforeach
                </div>
                @endif
            </div>
            <div class="flex align-center mt8" style="padding: 0 6px 6px 6px">
                <div class="thread-react-hover @auth like-resource like-resource-from-outside-viewer @endauth @guest login-signin-button @endguest">
                    <input type="hidden" class="likable-id" value="{{ $announcement->id }}">
                    <input type="hidden" class="likable-type" value="thread">
                    <svg class="size17 like-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84">
                        <path class="red-like @if(!$liked) none @endif" d="M285.26,35.53A107.1,107.1,0,0,1,391.84,142.11c0,107.62-195.92,214.2-195.92,214.2S0,248.16,0,142.11A106.58,106.58,0,0,1,106.58,35.53h0a105.54,105.54,0,0,1,89.34,48.06A106.57,106.57,0,0,1,285.26,35.53Z" style="fill:#d7453d"/>
                        <path class="grey-like @if($liked) none @endif" d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/>
                    </svg>
                    <p class="no-margin fs12 resource-likes-counter unselectable ml4">{{ $likes }}</p>
                    <p class="no-margin fs12 unselectable ml4">{{ __('like' . (($likes>1) ? 's' : '' )) }}</p>
                </div>
                <div class="flex align-center ml8">
                    <svg class="size16 mr4" style="fill:#1c1c1c" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                    <p class="fs12 no-margin unselectable">{{ $announcement->posts()->count() . __('replies') }}</p>
                </div>
                <p class="no-margin gray ml4 fs12">@if($announcement->replies_off) ({{ __('Replies disabled') }}) @endif</p>
            </div>
        </div>
    </div>
</div>