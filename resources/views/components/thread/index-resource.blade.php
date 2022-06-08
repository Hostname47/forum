<div id="thread{{ $thread->id }}" class="resource-container thread-container-box relative shadow-contained-box">
    @php
        $canupdate = false;
    @endphp
    @can('able_to_edit', $thread)
        @php $canupdate = true; @endphp
    @endcan
    <input type="hidden" class="thread-add-visibility-slug" value="public">
    <input type="hidden" class="thread-type" autocomplete="off" value="{{ $type }}">
    <div class="hidden-thread-section none px8 py8">
        <p class="my4 fs12">{{__('Post hidden. If you want to show it again')}} <span class="pointer blue thread-display-button">{{ __('click here') }}</span></p>
    </div>
    <div class="flex thread-component">
        <div class="thread-vote-section">
            <div class="vote-box full-center flex-column relative">
                <input type="hidden" class="lock" autocomplete="off" value="stable">
                <input type="hidden" class="from" autocomplete="off" value="outside-media-viewer">

                <input type="hidden" class="votable-type" autocomplete="off" value="thread">
                <input type="hidden" class="votable-id" autocomplete="off" value="{{ $thread->id }}">
                <svg class="size15 pointer @auth votable-up-vote @endauth @guest login-signin-button @endguest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                    <title>{{ __('UP') }}</title>
                    <path class="up-vote-filled @unless($upvoted) none @endunless" d="M63.89,55.78v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58H68.21a7.56,7.56,0,0,0,7.53-7.58V55.78ZM97.8,53.5,57.85,7.29A10.28,10.28,0,0,0,50,3.92a10.25,10.25,0,0,0-7.87,3.37L2.23,53.52A6.9,6.9,0,0,0,1,61.14c1.46,3.19,5,5.25,9.09,5.25h14V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53a1.61,1.61,0,0,1,.26,1.75,1.83,1.83,0,0,1-1.67,1H75.74v10.6H89.88c4.05,0,7.61-2.06,9.08-5.24A6.92,6.92,0,0,0,97.8,53.5Zm-16,1.24a1.83,1.83,0,0,1-1.67,1H63.89v28.3h-28V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53A1.61,1.61,0,0,1,81.83,54.74Z" style="fill:#28b1e7"/>
                    <path class="up-vote @if($upvoted) none @endif" d="M10.11,66.39c-4.06,0-7.63-2.06-9.09-5.25a6.9,6.9,0,0,1,1.21-7.62L42.11,7.29A10.25,10.25,0,0,1,50,3.92a10.28,10.28,0,0,1,7.87,3.37L97.8,53.5A6.92,6.92,0,0,1,99,61.13c-1.47,3.18-5,5.24-9.08,5.24H75.74V55.77h4.42a1.83,1.83,0,0,0,1.67-1A1.61,1.61,0,0,0,81.57,53L51.39,18A1.9,1.9,0,0,0,48.61,18L18.42,53a1.61,1.61,0,0,0-.26,1.75,1.83,1.83,0,0,0,1.67,1h4.26V66.39Zm58.1,29.69a7.56,7.56,0,0,0,7.53-7.58V55.78H63.89v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58Z" style="fill:#010202"/>
                </svg>
                <p class="bold fs15 text-center vote-counter" style="margin: 1px 0 2px 0">{{ $votevalue }}</p>
                <svg class="size15 pointer @auth votable-down-vote @endauth @guest login-signin-button @endguest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                    <title>{{ __('DOWN') }}</title>
                    <path class="down-vote-filled @unless($downvoted) none @endunless" d="M63.89,44.22V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58H68.21a7.56,7.56,0,0,1,7.53,7.58V44.22ZM97.8,46.5,57.85,92.71A10.28,10.28,0,0,1,50,96.08a10.25,10.25,0,0,1-7.87-3.37L2.23,46.48A6.9,6.9,0,0,1,1,38.86c1.46-3.19,5-5.25,9.09-5.25h14V44.22H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47a1.61,1.61,0,0,0,.26-1.75,1.83,1.83,0,0,0-1.67-1H75.74V33.63H89.88c4.05,0,7.61,2.06,9.08,5.24A6.92,6.92,0,0,1,97.8,46.5Zm-16-1.24a1.83,1.83,0,0,0-1.67-1H63.89V15.92h-28v28.3H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47A1.61,1.61,0,0,0,81.83,45.26Z" style="fill:#28b1e7"/>
                    <path class="down-vote @if($downvoted) none @endif" d="M10.11,33.61c-4.06,0-7.63,2.06-9.09,5.25a6.9,6.9,0,0,0,1.21,7.62L42.11,92.71A10.25,10.25,0,0,0,50,96.08a10.28,10.28,0,0,0,7.87-3.37L97.8,46.5A6.92,6.92,0,0,0,99,38.87c-1.47-3.18-5-5.24-9.08-5.24H75.74v10.6h4.42a1.83,1.83,0,0,1,1.67,1A1.61,1.61,0,0,1,81.57,47L51.39,82a1.9,1.9,0,0,1-2.78,0L18.42,47a1.61,1.61,0,0,1-.26-1.75,1.83,1.83,0,0,1,1.67-1h4.26V33.61ZM68.21,3.92a7.56,7.56,0,0,1,7.53,7.58V44.22H63.89V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58Z" style="fill:#010202"/>
                </svg>

            </div>
            <div class="@if(!$ticked) none @endif thread-component-tick" title="{{ __('This post has a best reply') }}">
                <svg class="size20 mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
            </div>
        </div>
        <div class="thread-main-section">
            <!-- thread header section -->
            <div class="thread-header-section space-between">
                <div class="flex">
                    <div class="relative flex user-profile-card-box">
                        <a href="{{ $owner->profilelink }}" class="size36 relative rounded mr4 hidden-overflow has-lazy pointer user-profile-card-displayer fetch-user-card">
                            <div class="fade-loading"></div>
                            <img data-src="{{ $owner->sizedavatar(36, '-l') }}" class="thread-owner-avatar size36 flex lazy-image image-with-fade" alt="">
                        </a>
                        <input type="hidden" class="user-card-container-index">
                        <input type="hidden" class="uid" value="{{ $owner->id }}" autocomplete="off">
                        <!-- user card component -->
                        @include('partials.user-space.faded-card')
                        <div>
                            <div class="flex align-center" style="height: 18px">
                                <a href="{{ route('user.profile', ['user'=>$owner->username]) }}" class="fs15 blue no-underline bold"><span class="thread-owner-name">{{ $owner->fullname }}</span></a>
                                @if(!(auth()->user() && $owner->id == auth()->user()->id))
                                <!-- thread-component-follow-box class is used in profile page to delete following user from profile page -->
                                <div class="follow-box thread-component-follow-box flex align-center">
                                    <!-- buttons labels -->
                                    <input type="hidden" class="follow-text" autocomplete="off" value="{{ __('Follow') }}">
                                    <input type="hidden" class="following-text" autocomplete="off" value="{{ __('Following') }}..">
                                    <input type="hidden" class="unfollow-text" autocomplete="off" value="{{ __('Unfollow') }}">
                                    <input type="hidden" class="unfollowing-text" autocomplete="off" value="{{ __('Unfollowing') }}..">
                                    <input type="hidden" class="follow-success-text" autocomplete="off" value="{{ __('User followed successfully') }} !">
                                    <input type="hidden" class="unfollow-success-text" autocomplete="off" value="{{ __('User unfollowed successfully') }} !">
                                    <span class="fs10 gray mx4">•</span>
                                    <div class="pointer @guest login-signin-button @endguest">
                                        <div class="size14 relative follow-options-container @if(!$followed) none @endif">
                                            <svg class="size14 button-with-suboptions" style="fill: #1e1e1e;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,512a64,64,0,0,0,64-64H192A64,64,0,0,0,256,512ZM471.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C150.56,68.1,96.08,130.3,96.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,32,384c.11,16.4,13,32,32.1,32H447.9c19.12,0,32-15.6,32.1-32A31.23,31.23,0,0,0,471.39,362.29Z"/></svg>
                                            <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:max-content">
                                                <div class="pointer follow-user follow-button-with-toggle-bell simple-suboption flex align-center">
                                                    <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234,147.1h0a87.1,87.1,0,1,0,87.1,87.11A87.12,87.12,0,0,0,234,147.1Zm0,130.65a43.55,43.55,0,1,1,0-87.1h0a43.55,43.55,0,0,1,0,87.1Zm224.55-7.07a9.77,9.77,0,0,0-6.3-8.52,156.94,156.94,0,0,0-26.41-7.34,9.79,9.79,0,0,0-11.36,7.94,9.46,9.46,0,0,0-.09,2.81,180.26,180.26,0,0,1-32.79,124.58c-22.14-28.49-56.34-47.09-95.35-47.09-9.26,0-23.59,8.71-52.26,8.71s-43-8.71-52.26-8.71c-38.92,0-73.12,18.6-95.35,47.09A180.17,180.17,0,0,1,52.62,279.91c2.66-96,80.45-173.7,176.4-176.29q6.63-.18,13.16.11a9.8,9.8,0,0,0,10.22-9.36,9.94,9.94,0,0,0-.09-1.81A157.76,157.76,0,0,0,246.4,66.9a9.83,9.83,0,0,0-9.16-6.9h-.06C112.7,58.3,9,160.44,9,284.93,9,426,138.59,536.67,285.24,504.35a221.37,221.37,0,0,0,168-167.67A235,235,0,0,0,458.56,270.68ZM234,466.45a180.41,180.41,0,0,1-118-43.91,78.14,78.14,0,0,1,63.14-35.84C198,392.51,216,395.41,234,395.41a181.65,181.65,0,0,0,54.89-8.71A78.38,78.38,0,0,1,352,422.54,180.41,180.41,0,0,1,234,466.45ZM444.34,98,510.8,31.53a4.07,4.07,0,0,0,0-5.77L486.25,1.2a4.08,4.08,0,0,0-5.78,0L414,67.66,347.54,1.2a4.19,4.19,0,0,0-5.78,0L317.2,25.76a4.09,4.09,0,0,0,0,5.77L383.67,98,317.2,164.46a4.1,4.1,0,0,0,0,5.78l24.56,24.56a4.08,4.08,0,0,0,5.78,0L414,128.33l66.47,66.47a4.08,4.08,0,0,0,5.78,0l24.55-24.56a4.08,4.08,0,0,0,0-5.78Z"/></svg>
                                                    <div class="fs12 button-text unfollow-button-text">{{ __('Unfollow') }}</div>
                                                    <input type="hidden" class="user-id" value="{{ $owner->id }}" autocomplete="off">
                                                    <input type="hidden" class="lock" value="stable" autocomplete="off">
                                                    <input type="hidden" class="status" value="followed" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="@if($followed) none @endif @auth follow-user follow-button-with-toggle-bell follow-button-textual @else login-signin-button @endauth">
                                            <p class="no-margin fs12 bold button-text follow-button-text bblack unselectable">{{ __('Follow') }}</p>
                                            <input type="hidden" class="user-id" value="{{ $owner->id }}" autocomplete="off">
                                            <input type="hidden" class="lock" value="stable" autocomplete="off">
                                            <input type="hidden" class="status" value="not-followed" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="flex align-center">
                                <span class="thread-owner-username bblack fs12 bold">{{ $owner->username }}</span>
                                <div class="gray height-max-content mx4 fs10">•</div>
                                <div class="relative height-max-content">
                                    <p class="no-margin fs11 flex align-center tooltip-section gray">{{ $at_hummans }}</p>
                                    <div class="tooltip tooltip-style-1">
                                        {{ $at }}
                                    </div>
                                </div>
                                <div class="gray height-max-content mx4 fs10">•</div>
                                <div class="visibility-box">
                                    <div class="relative">
                                        @if($canupdate)
                                        <div class="flex align-center pointer button-with-suboptions thread-visibility-changer">
                                            <svg class="size13 thread-resource-visibility-icon" style="fill: #202020; margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                {!! $thread->visibility->icon !!}
                                            </svg>
                                            <span class="gray fs12" style="margin-top: 1px">▾</span>
                                            <input type="hidden" class="message-after-change" value="{{ __('Your post visibility has been changed successfully') }}.">
                                        </div>
                                        <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:max-width">
                                            <p class="fs13 bold ml8 my8">{{ __('Post visibility') }}</p>
                                            <div class="pointer simple-suboption flex align-center thread-visibility-button" title="{{ __('Public') }}">
                                                <div class="relative size14 mr4">
                                                    <svg class="size14 icon-above-spinner" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z"/></svg>
                                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                    </svg>
                                                </div>
                                                <div class="fs12">{{ __('Public') }}</div>
                                                <input type="hidden" class="thread-visibility-slug" value="public">
                                                <input type="hidden" class="icon-path-when-selected" value="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z">
                                            </div>
                                            <div class="pointer simple-suboption flex align-center thread-visibility-button" title="{{ __('Followers Only') }}">
                                                <div class="relative size14 mr4">
                                                    <svg class="size14 icon-above-spinner" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234.07,471.13H60.39a20,20,0,0,1-19-26.09c19.73-61.34,79.91-104.19,146.34-104.19a149.32,149.32,0,0,1,85.84,26.92A20,20,0,0,0,296.4,335a189.62,189.62,0,0,0-39.82-21.26,101.61,101.61,0,0,0,33.05-67,150.31,150.31,0,0,1,190.54-15.57A20,20,0,1,0,503,198.4a189.62,189.62,0,0,0-39.82-21.26,101.81,101.81,0,1,0-137.1-.22c-2.78,1.07-5.55,2.21-8.29,3.42a188.79,188.79,0,0,0-35.17,20.18A101.8,101.8,0,1,0,119.3,313.38c-54.15,20.29-98,63.87-115.93,119.44a59.91,59.91,0,0,0,57,78.24H234.07a20,20,0,0,0,0-39.93Zm160.7-431.2a61.89,61.89,0,1,1-61.88,61.88A62,62,0,0,1,394.77,39.93ZM188.15,176.55a61.89,61.89,0,1,1-61.88,61.89A62,62,0,0,1,188.15,176.55ZM503.22,326.08a20,20,0,0,0-27.86,4.61L377,468.14a11.39,11.39,0,0,1-16.41.85l-63.7-61.17a20,20,0,0,0-27.66,28.8L333,497.85A51.48,51.48,0,0,0,368.37,512c1.13,0,2.26,0,3.39-.11a51.46,51.46,0,0,0,36.6-19.06c.23-.29.45-.59.67-.89l98.8-138A20,20,0,0,0,503.22,326.08Z"/></svg>
                                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                    </svg>
                                                </div>
                                                <div class="fs12">{{ __('Followers Only') }}</div>
                                                <input type="hidden" class="thread-visibility-slug" value="followers-only">
                                                <input type="hidden" class="icon-path-when-selected" value="M234.07,471.13H60.39a20,20,0,0,1-19-26.09c19.73-61.34,79.91-104.19,146.34-104.19a149.32,149.32,0,0,1,85.84,26.92A20,20,0,0,0,296.4,335a189.62,189.62,0,0,0-39.82-21.26,101.61,101.61,0,0,0,33.05-67,150.31,150.31,0,0,1,190.54-15.57A20,20,0,1,0,503,198.4a189.62,189.62,0,0,0-39.82-21.26,101.81,101.81,0,1,0-137.1-.22c-2.78,1.07-5.55,2.21-8.29,3.42a188.79,188.79,0,0,0-35.17,20.18A101.8,101.8,0,1,0,119.3,313.38c-54.15,20.29-98,63.87-115.93,119.44a59.91,59.91,0,0,0,57,78.24H234.07a20,20,0,0,0,0-39.93Zm160.7-431.2a61.89,61.89,0,1,1-61.88,61.88A62,62,0,0,1,394.77,39.93ZM188.15,176.55a61.89,61.89,0,1,1-61.88,61.89A62,62,0,0,1,188.15,176.55ZM503.22,326.08a20,20,0,0,0-27.86,4.61L377,468.14a11.39,11.39,0,0,1-16.41.85l-63.7-61.17a20,20,0,0,0-27.66,28.8L333,497.85A51.48,51.48,0,0,0,368.37,512c1.13,0,2.26,0,3.39-.11a51.46,51.46,0,0,0,36.6-19.06c.23-.29.45-.59.67-.89l98.8-138A20,20,0,0,0,503.22,326.08Z">
                                            </div>
                                            <div class="pointer simple-suboption flex align-center thread-visibility-button" title="{{ __('Only Me') }}">
                                                <div class="relative size14 mr4">
                                                    <svg class="size14 icon-above-spinner" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M412.45,245.72a26.43,26.43,0,0,0-19.42-8H383.9V182.91q0-52.53-37.68-90.22T256,55q-52.55,0-90.22,37.69t-37.69,90.22v54.82H119a27.28,27.28,0,0,0-27.41,27.41V429.59A27.28,27.28,0,0,0,119,457H393a27.28,27.28,0,0,0,27.41-27.41V265.14A26.4,26.4,0,0,0,412.45,245.72Zm-83.36-8H182.91V182.91q0-30.27,21.41-51.68T256,109.82q30.27,0,51.68,21.41t21.41,51.68Z"/></svg>
                                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                                    </svg>
                                                </div>
                                                <div class="fs12">{{ __('Only Me') }}</div>
                                                <input type="hidden" class="thread-visibility-slug" value="private">
                                                <input type="hidden" class="icon-path-when-selected" value="M412.45,245.72a26.43,26.43,0,0,0-19.42-8H383.9V182.91q0-52.53-37.68-90.22T256,55q-52.55,0-90.22,37.69t-37.69,90.22v54.82H119a27.28,27.28,0,0,0-27.41,27.41V429.59A27.28,27.28,0,0,0,119,457H393a27.28,27.28,0,0,0,27.41-27.41V265.14A26.4,26.4,0,0,0,412.45,245.72Zm-83.36-8H182.91V182.91q0-30.27,21.41-51.68T256,109.82q30.27,0,51.68,21.41t21.41,51.68Z">
                                            </div>
                                            <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                                        </div>
                                        @else
                                        <div class="flex align-center" title="{{ $thread->visibility->visibility }}">
                                            <svg class="size13 thread-resource-visibility-icon" style="fill: #202020; margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                {!! $thread->visibility->icon !!}
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex align-center">
                    <div class="simple-border-container mr8 flex align-center" title="{{ __('views') }}">
                        <svg class="mr4 size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                        <p class="no-margin fs12 unselectable" style="margin-top: 1px">{{ $views }}</p>
                    </div>
                    <div class="relative" style="height: 20px">
                        <svg class="pointer path-blue-when-hover button-with-suboptions size20 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
                        <div class="suboptions-container suboptions-container-right-style" style="max-width: 220px;">
                            @if(auth()->user())
                            <div class="pointer simple-suboption save-thread flex align-center">
                                <div class="relative size17 mr4">
                                    <svg class="size17 icon-above-spinner mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path class="save-icon @if(!$saved) none @endif" d="M424.5,230.48V480.67L256,382.38,87.5,480.67V73.46a42.13,42.13,0,0,1,42.13-42.13H324.42a55.81,55.81,0,0,0-9.88,7.46c-6.09,5.74-11,13-15.4,20.08a25.43,25.43,0,0,0-3.92,14.59H134.89a5.26,5.26,0,0,0-5.26,5.26V407.33L256,333.61l126.38,73.72V238.2a26.69,26.69,0,0,0,14.2-.22,52.38,52.38,0,0,0,5.45-1.91c7.38.45,14.78-1.75,21.32-5ZM507.06,127A121.06,121.06,0,1,1,386,5.94,121,121,0,0,1,507.06,127Zm-23.43,0A97.63,97.63,0,1,0,386,224.63,97.6,97.6,0,0,0,483.63,127ZM435.69,96.64a5.85,5.85,0,0,0,0-8.3l-11-11a5.85,5.85,0,0,0-8.3,0L386,107.67,355.64,77.31a5.85,5.85,0,0,0-8.3,0l-11,11a5.85,5.85,0,0,0,0,8.3L366.67,127l-30.36,30.36a5.85,5.85,0,0,0,0,8.3l11,11a5.85,5.85,0,0,0,8.3,0L386,146.33l30.36,30.36a5.85,5.85,0,0,0,8.3,0l11-11a5.85,5.85,0,0,0,0-8.3L405.33,127l30.36-30.36Z"/>
                                        <path class="unsave-icon @if($saved) none @endif" d="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z"/>
                                    </svg>
                                    <svg class="spinner size17 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <div class="button-text">
                                    @if($saved) {{ __('Unsave post') }} @else {{ __('Save post') }} @endif
                                </div>
                                <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                                <input type="hidden" class="status" value="@if($saved) saved @else not-saved @endif" autocomplete="off">
                                <input type="hidden" class="from" value="thread-component" autocomplete="off">
                                <input type="hidden" class="save-text" value="{{ __('Save post') }}">
                                <input type="hidden" class="unsave-text" value="{{ __('Unsave post') }}">
                                <input type="hidden" class="saved-message" value="{{ __('Post saved successfully') }}">
                                <input type="hidden" class="unsaved-message" value="{{ __('Post unsaved successfully') }}">
                            </div>
                            @endif
                            @if($canupdate)
                                @if($type == 'discussion')
                                <a href="{{ $edit_link }}" class="no-underline simple-suboption flex align-center">
                                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.51,334.33l28.28-28.27a7.1,7.1,0,0,1,12.11,5V439.58A42.43,42.43,0,0,1,355.48,482H44.42A42.43,42.43,0,0,1,2,439.58V128.52A42.43,42.43,0,0,1,44.42,86.1H286.11a7.12,7.12,0,0,1,5,12.11l-28.28,28.28a7,7,0,0,1-5,2H44.42V439.58H355.48V339.28A7,7,0,0,1,357.51,334.33ZM495.9,156,263.84,388.06,184,396.9a36.5,36.5,0,0,1-40.29-40.3l8.83-79.88L384.55,44.66a51.58,51.58,0,0,1,73.09,0l38.17,38.17A51.76,51.76,0,0,1,495.9,156Zm-87.31,27.31L357.25,132,193.06,296.25,186.6,354l57.71-6.45Zm57.26-70.43L427.68,74.7a9.23,9.23,0,0,0-13.08,0L387.29,102l51.35,51.34,27.3-27.3A9.41,9.41,0,0,0,465.85,112.88Z"/></svg>
                                    <div class="black">{{ __('Edit post') }}</div>
                                </a>
                                @endif
                                <div class="pointer simple-suboption flex align-center open-thread-delete-viewer">
                                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                    <div class="no-underline black">{{ __('Delete post') }}</div>
                                    <input type="hidden" class="thread-id" value="{{ $thread->id }}" autocomplete="off">
                                </div>
                                <div class="simple-suboption flex align-center open-thread-replies-switch">
                                    @php $action = ($thread->replies_off) ? 'on' : 'off'; @endphp
                                    <div class="pointer small-image-2 sprite sprite-2-size icon @if($action == 'off') turnoffreplies17-icon @else turnonreplies17-icon @endif mr4"></div>
                                    <div class="button-text">{{ __('Turn ' . $action .  ' replies') }}</div>
                                    <input type="hidden" class="thread-id" value="{{ $thread->id }}" autocomplete="off">
                                    <input type="hidden" class="action" value="{{ $action }}" autocomplete="off">
                                </div>
                                <div class="pointer simple-suboption remove-tick-from-thread flex @if(!$ticked) none @endif">
                                    <div class="relative size17 mr4 full-center" style="min-width: 17px;">
                                        <svg class="flex size17 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M509.38,154.25c-7,14.45-19,24.74-30,35.79Q355.7,313.75,232,437.42c-22.66,22.66-43.61,22.66-66.28,0Q102.36,374.07,39,310.7c-20.49-20.51-20.54-42.45-.21-62.84q13-13.1,26.14-26.15c19-18.94,41.6-19,60.84,0,22.23,22,44.46,44,66.25,66.49,5.28,5.45,7.9,5.91,13.58.19q99.87-100.58,200.3-200.58,32-32,64.27.13c6.05,6,11.87,12.28,18.14,18.06,9.06,8.34,16.86,17.47,21.05,29.26ZM196.82,420c6.06-.22,8-3.47,10.35-5.85q62.7-62.6,125.32-125.28Q401.17,220.2,470,151.63c6.28-6.22,6.37-10.36-.09-16.15-8-7.17-15.27-15.1-22.87-22.68-8.86-8.84-9.37-8.85-18-.18L215.2,326.36c-12.57,12.56-20.15,12.58-32.65.11-26.61-26.55-53.34-53-79.67-79.8-5.89-6-9.85-5.93-15.4.16-8.08,8.86-16.71,17.24-25.43,25.48-5,4.7-5.24,8.4-.24,13.39q65.49,65.16,130.72,130.6C194.31,418.08,196,420.05,196.82,420ZM10.81,52.54c-3.33,4.07-2.16,9.85,1.8,13.94,5,5.14,10.12,10.16,15.19,15.23,11.9,11.9,23.77,23.84,35.74,35.68,1.84,1.81,1.85,2.86,0,4.69q-24.63,24.44-49.11,49c-7.24,7.25-7.22,13,.09,20.3l7.15,7.14c6.23,6.2,12.51,6.24,18.69.07C56.8,182.2,73.28,165.8,89.59,149.24c2.38-2.41,3.58-2.28,5.87,0,16.17,16.39,32.5,32.64,48.77,48.92,6.68,6.69,12.8,6.78,19.36.07,4.57-4.67,9.92-8.67,12.76-14.86l.24-1.52c-.65-4.93-3.43-8.26-6.62-11.43-16.16-16.08-32.21-32.25-48.4-48.29-1.94-1.92-1.89-3,0-4.89,15.8-15.66,31.49-31.44,47.24-47.15,3.3-3.29,6.65-6.5,7.91-11.39l-.26-1.9a50,50,0,0,0-21.15-21.11l-1.74-.23c-4.6,1.1-7.72,4.07-10.81,7.18C126,59.51,109.2,76.25,92.51,93.13,75.82,76.24,59,59.5,42.24,42.67c-2.9-2.92-5.86-5.68-10-7l-2.41.06C21.47,39.11,16.16,46,10.81,52.54Z"/></svg>
                                        <svg class="spinner size14 opacity0 absolute" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span>{{ __('Remove best reply tick') }}</span>
                                        <p class="fs11 no-margin gray">{{ __('This post has already a best reply. Click here to remove best reply tick') }}</p>
                                    </div>
                                    <input type="hidden" class="thread-id" value="{{ $thread->id }}" autocomplete="off">
                                </div>
                            @endif
                            <div class="pointer simple-suboption thread-display-button flex align-center">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.03 490.03"><path d="M435.67,54.31a18,18,0,0,0-25.5,0l-64,64c-79.3-36-163.9-27.2-244.6,25.5C41.47,183,5,232.31,3.47,234.41a18.16,18.16,0,0,0,.5,22c34.2,42,70,74.7,106.6,97.5l-56.3,56.3a18,18,0,1,0,25.4,25.5l356-355.9A18.11,18.11,0,0,0,435.67,54.31ZM200.47,264a46.82,46.82,0,0,1-3.9-19,48.47,48.47,0,0,1,67.5-44.6Zm90.2-90.1a84.37,84.37,0,0,0-116.6,116.6L137,327.61c-32.5-18.8-64.5-46.6-95.6-82.9,13.3-15.6,41.4-45.7,79.9-70.8,66.6-43.4,132.9-52.8,197.5-28.1Zm195.4,59.7c-24.7-30.4-50.3-56-76.3-76.3a18.05,18.05,0,1,0-22.3,28.4c20.6,16.1,41.2,36.1,61.2,59.5a394.59,394.59,0,0,1-66,61.3c-60.1,43.7-120.8,59.5-180.3,46.9a18,18,0,0,0-7.4,35.2,224.08,224.08,0,0,0,46.8,4.9,237.92,237.92,0,0,0,71.1-11.1c31.1-9.7,62-25.7,91.9-47.5,50.4-36.9,80.5-77.6,81.8-79.3A18.16,18.16,0,0,0,486.07,233.61Z"/></svg>
                                <div>{{ __('Hide post') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- thread main content -->
            <div class="thread-content-section">
                <!-- textual content -->
                <div>
                    <div>
                        <!-- forum and category header -->
                        <div class="flex align-center full-width" style="padding: 10px 10px 0px 10px">
                            <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                {!! $forum->icon !!}
                            </svg>
                            <div class="flex align-center path-blue-when-hover">
                                <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ __($forum->forum) }}</a>
                                <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                                <a href="{{ $category_threads_link }}" class="fs11 black-link">{{ __($category->category) }}</a>
                            </div>
                            @if($type == 'poll')
                                <span class="fs10 gray" style="margin: 0 4px 2px 4px">•</span>
                                <div class="flex" title="{{ __('poll') }}">
                                    <svg class="size12" style="fill:#202020;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M302.16,471.18H216a14,14,0,0,1-14-14V53.47a14,14,0,0,1,14-14h86.18a14,14,0,0,1,14,14V457.15A14,14,0,0,1,302.16,471.18ZM162.78,458.53V146.85a14,14,0,0,0-14-14H62.57a14,14,0,0,0-14,14V458.53a14,14,0,0,0,14,14h86.17A14,14,0,0,0,162.78,458.53Zm300.69,0V220a14,14,0,0,0-14-14H363.26a14,14,0,0,0-14,14V458.53a14,14,0,0,0,14,14h86.17A14,14,0,0,0,463.47,458.53Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                                </div>

                                <div class="flex align-center move-to-right">
                                    <a href="{{ $thread->link }}" class="link-style flex align-center">
                                        <svg class="size14 mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352,289V416H64V128h96V64H32A32,32,0,0,0,0,96V448a32,32,0,0,0,32,32H384a32,32,0,0,0,32-32V289Z"/><path d="M505.6,131.2l-128-96A16,16,0,0,0,352,48V96H304C206.94,96,128,175,128,272a16,16,0,0,0,12.32,15.59A16.47,16.47,0,0,0,144,288a16,16,0,0,0,14.3-8.83l3.78-7.52A143.2,143.2,0,0,1,290.88,192H352v48a16,16,0,0,0,25.6,12.8l128-96a16,16,0,0,0,0-25.6Z"/></svg>
                                        {{ __('See poll post') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        @if($type == 'discussion')
                        <div class="mt8 mb4 expand-box" style="margin: 10px 10px 0px 10px">
                            <span><a href="{{ $thread->link }}" class="thread-title-text html-entities-decode expandable-text bold fs18 blue no-underline block full-width">{{ $thread->mediumslice }}</a></span>
                            @if($thread->mediumslice != $thread->subject)
                            <input type="hidden" class="expand-slice-text" value="{{ $thread->mediumslice }}">
                            <input type="hidden" class="expand-whole-text" value="{{ $thread->subject }}">
                            <input type="hidden" class="expand-text-state" value="0">
                            <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                            <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                            <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                            @endif
                        </div>
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
                        @else
                        <div class="thread-content-padding" style="padding-bottom: 0">
                            <div class="expand-box" style="margin-bottom: 16px">
                                <span class="expandable-text fs16">{{ $thread->mediumslice }}</span>
                                @if($thread->mediumslice != $thread->subject)
                                <input type="hidden" class="expand-slice-text" value="{{ $thread->mediumslice }}">
                                <input type="hidden" class="expand-whole-text" value="{{ $thread->subject }}">
                                <input type="hidden" class="expand-text-state" value="0">
                                <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                                <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                                <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                                @endif
                            </div>
                            <!-- poll-options -->
                            <div class="poll-options-wrapper">
                                <div class="mt8 thread-poll-options-container @if($allow_multiple_voting) checkbox-group @else radio-group @endif">
                                    <input type="hidden" class="total-poll-votes" autocomplete="off" value="{{ $poll_total_votes }}">
                                    @foreach($options as $option)
                                        <x-thread.poll-option-component
                                            :option="$option" 
                                            :multiplevoting="$allow_multiple_voting"
                                            :totalpollvotes="$poll_total_votes"
                                            :pollownerid="$owner->id"/>
                                    @endforeach
                                    @if($hasmoreoptions)
                                    <div class="flat-button-style unselectable poll-options-vertical-inputs-style border-box fetch-remaining-poll-options mb8" style="padding: 10px">
                                        {{ __('Load more options') }}
                                        <div class="relative size7 ml4 full-center">
                                            <svg class="flex size7 icon-above-spinner mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                                            <svg class="spinner size10 opacity0 absolute mt2" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                        <input type="hidden" class="thread-id" value="{{ $thread->id }}" autocomplete="off">
                                        <input type="hidden" class="scroll-by-put-thread-into-bottom-of-viewport" value="0" autocomplete="off">
                                    </div>
                                    @endif
                                </div>
                                @if($current_user_could_add_option || (auth()->user() && auth()->user()->id == $thread->user_id))
                                <div class="poll-option-propose my8 poll-options-vertical-inputs-style">
                                    <input type="hidden" class="length-error" value="{{ __('Option content field is required') }}" autocomplete="off">
                                    <div class="simple-line-separator my8"></div>
                                    @if($poll->options_add_limit)
                                    <p class="no-margin fs11 gray mb4">{{ __("original poster allows users to add :n :m maximum", ['n'=>$poll->options_add_limit, "m"=>(($poll->options_add_limit == 1) ? __('option') : __('options'))]) }}</p>
                                    @endif
                                    <div class="my4 pr8 pt8 poll-option-input-error none">
                                        <div class="flex align-center">
                                            <svg class="size12 mr4" style="fill: rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                            <span class="error fs12 bold no-margin"></span>
                                        </div>
                                    </div>
                                    <div class="flex align-center dynamic-input-wrapper">
                                        <span class="dynamic-label">{{ __('Add an option') }}</span>
                                        <input type="text" maxlength="140" name="option" class="input-with-dynamic-label poll-option-value full-width fs15" autocomplete="off">
                                        <input type="hidden" class="poll-id" value="{{ $poll->id }}" autocomplete="off">
                                        <input type="hidden" class="success-message" value="{{ __('Your option is saved successfully') }} !" autocomplete="off">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- media content -->
                @if($type=='discussion' AND $thread->hasmedias)
                <div class="thread-medias-container">
                    <input type="hidden" class="thread-id" value="{{ $thread->id }}">
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
                            <div class="fade-loading"></div>
                            <img data-src="{{ asset($media['src']) }}" alt="" class="thread-media @if($mediaslength > 1) lazy-image @else handle-single-lazy-image-container-unbased @endif image-with-fade">
                            <div class="full-shadow-stretched none">
                                <p class="fs26 bold white unselectable">+<span class="thread-media-more-counter"></span></p>
                            </div>
                            <input type="hidden" class="media-type" value="{{ $media['type'] }}">
                            <input type="hidden" class="media-count" value="{{ $media_count }}">
                        </div>
                        @elseif($media['type'] == 'video')
                        <div class="thread-media-box thread-media-container relative" style="background-color: #0f0f0f">
                            <div class="thread-media-options full-center">
                                @if($thread->has_media)
                                <svg class="size17 pointer open-media-viewer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0,180V56A23.94,23.94,0,0,1,24,32H148a12,12,0,0,1,12,12V84a12,12,0,0,1-12,12H64v84a12,12,0,0,1-12,12H12A12,12,0,0,1,0,180ZM288,44V84a12,12,0,0,0,12,12h84v84a12,12,0,0,0,12,12h40a12,12,0,0,0,12-12V56a23.94,23.94,0,0,0-24-24H300A12,12,0,0,0,288,44ZM436,320H396a12,12,0,0,0-12,12v84H300a12,12,0,0,0-12,12v40a12,12,0,0,0,12,12H424a23.94,23.94,0,0,0,24-24V332A12,12,0,0,0,436,320ZM160,468V428a12,12,0,0,0-12-12H64V332a12,12,0,0,0-12-12H12A12,12,0,0,0,0,332V456a23.94,23.94,0,0,0,24,24H148A12,12,0,0,0,160,468Z"/></svg>
                                @endif
                            </div>
                            <video class="thread-media full-height full-width" controls preload="none">
                                <source src="{{ asset($media['src']) }}" type="{{ $media['mime'] }}">
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
            <!-- thread bottom section -->
            <div class="thread-bottom-section space-between">
                <div class="flex align-center">
                    <div class="thread-react-hover @auth like-resource @endauth @guest login-signin-button @endguest">
                        <input type="hidden" class="lock" value="stable" autocomplete="off">
                        <input type="hidden" class="from" autocomplete="off" value="outside-media-viewer">

                        <input type="hidden" class="likable-id" value="{{ $thread->id }}">
                        <input type="hidden" class="likable-type" value="thread">
                        <svg class="size17 like-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84">
                            <path class="red-like @if(!$liked) none @endif" d="M285.26,35.53A107.1,107.1,0,0,1,391.84,142.11c0,107.62-195.92,214.2-195.92,214.2S0,248.16,0,142.11A106.58,106.58,0,0,1,106.58,35.53h0a105.54,105.54,0,0,1,89.34,48.06A106.57,106.57,0,0,1,285.26,35.53Z" style="fill:#d7453d"/>
                            <path class="gray-like @if($liked) none @endif" d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/>
                        </svg>
                        <p class="no-margin fs12 bold likes-counter unselectable ml4">{{ $likes }}</p>
                        <p class="no-margin fs12 unselectable ml4">{{ __('like' . (($likes>1) ? 's' : '' )) }}</p>
                    </div>
                    @if(Route::currentRouteName() == 'thread.show')
                    <div class="thread-react-hover move-to-thread-replies thread-show-replies flex align-center pointer black">
                        <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                        <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" fill="#1c1c1c" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                        <p class="no-margin unselectable fs12"><span class="posts-count bold">{{ $replies }}</span> {{__('replies')}}</p>
                    </div>
                    @else
                    <a href="{{ $thread->link }}?action=move-to-replies-section" class="thread-react-hover move-to-thread-replies flex align-center no-underline black">
                        <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                        <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" fill="#1c1c1c" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                        <p class="no-margin unselectable fs12"><span class="posts-count bold">{{ $replies }}</span> {{__('replies')}}</p>
                    </a>
                    @endif
                </div>
                <div class="flex align-center">
                    <div class="relative">
                        <div class="flex align-center pointer button-with-suboptions copy-container-button thread-react-hover" style="margin: 0">
                            <svg class="mr4 size12" fill="#1c1c1c" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M326.61,185.39A151.92,151.92,0,0,1,327,400l-.36.37-67.2,67.2c-59.27,59.27-155.7,59.26-215,0s-59.27-155.7,0-215l37.11-37.1c9.84-9.84,26.78-3.3,27.29,10.6a184.45,184.45,0,0,0,9.69,52.72,16.08,16.08,0,0,1-3.78,16.61l-13.09,13.09c-28,28-28.9,73.66-1.15,102a72.07,72.07,0,0,0,102.32.51L270,343.79A72,72,0,0,0,270,242a75.64,75.64,0,0,0-10.34-8.57,16,16,0,0,1-6.95-12.6A39.86,39.86,0,0,1,264.45,191l21.06-21a16.06,16.06,0,0,1,20.58-1.74,152.65,152.65,0,0,1,20.52,17.2ZM467.55,44.45c-59.26-59.26-155.69-59.27-215,0l-67.2,67.2L185,112A152,152,0,0,0,205.91,343.8a16.06,16.06,0,0,0,20.58-1.73L247.55,321a39.81,39.81,0,0,0,11.69-29.81,16,16,0,0,0-6.94-12.6A75,75,0,0,1,242,270a72,72,0,0,1,0-101.83L309.16,101a72.07,72.07,0,0,1,102.32.51c27.75,28.3,26.87,73.93-1.15,102l-13.09,13.09a16.08,16.08,0,0,0-3.78,16.61,184.45,184.45,0,0,1,9.69,52.72c.5,13.9,17.45,20.44,27.29,10.6l37.11-37.1c59.27-59.26,59.27-155.7,0-215Z"/></svg>
                            <div class="fs12 bold unselectable">{{__('link')}}</div>
                        </div>
                        <div class="absolute button-simple-container suboptions-container mt4" style="z-index: 1;right: 0; background-color: white; border: 1px solid gray">
                            <div class="flex">
                                <input type="text" value="{{ $thread->link }}" autocomplete="off" class="simple-input" style="width: 280px; padding: 3px 8px 3px 8px; height: 28px; background-color: #f4f4f4; border: 1px solid #d0d0d0">
                                <div class="pointer input-button-style flex align-center copy-thread-link bold unselectable" style="height: 28px; background-color: #373737; color: white; fill: white; border: unset; padding: 2px 10px">
                                    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352.8 352.8"><path d="M318.54,57.28H270.89V15a15,15,0,0,0-15-15H34.26a15,15,0,0,0-15,15V280.52a15,15,0,0,0,15,15H81.92V337.8a15,15,0,0,0,15,15H318.54a15,15,0,0,0,15-15V72.28A15,15,0,0,0,318.54,57.28ZM49.26,265.52V30H240.89V57.28h-144a15,15,0,0,0-15,15V265.52ZM303.54,322.8H111.92V87.28H303.54Z"/></svg>
                                    {{ __('copy') }}
                                    <input type="hidden" class="copied" value="{{__('link copied to your clipboard')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Only display report button in thread show page -->
                    @if(request()->route()->getName() == 'thread.show' && auth()->user() && auth()->user()->id != $owner->id)
                    <div class="flex align-center ml4 report-thread-button-container">
                        <div class="@auth @if(auth()->user()->id != $owner->id) open-thread-report-container @endif @endauth @guest login-signin-button @endguest thread-react-hover" style="margin-right: 0px">
                            <svg class="size12 mr4" style="fill: #242424" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"/></svg>
                            <div class="fs12 bold unselectable">{{__('Report')}}</div>
                            <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>