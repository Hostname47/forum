<!-- 
    post#id as class is used to delete component after the user delete the post 
    reason why class and not id : it could be the same post in thread show page and in media viewer as well
-->
<div class="relative post-container resource-container post{{ $post->id }}" id="@if($post->ticked){{'ticked-post'}}@endif">
    @php
        $canupdate = false;
        $candestroy = false;
    @endphp
    @can('able_to_update', $post)
        @php $canupdate = true; @endphp
    @endcan
    @can('able_to_delete', [$post, $thread_owner])
        @php $candestroy = true; @endphp
    @endcan
    <input type="hidden" class="post-id" value="{{ $post->id }}">
    <input type="hidden" class="likable-type" value="post">
    <input type="hidden" class="likable-id" value="{{ $post->id }}">
    <div class="show-post-container fs12 my8" style="border-radius: 6px; border: 1px solid #b9b9b9; padding: 12px;">
        {{ __('Reply hidden') }} <span class="show-post show-post-from-outside-viewer blue bold pointer unselectable">{{ __('click here to show it') }}</span>
    </div>
    
    <div class="flex post-main-component relative" style="@if($post->ticked) border: 2px solid #8dc48c; @endif">
        <div id="{{ $post->id }}" class="absolute" style="top: -65px"></div>
        <div class="vote-section post-vs relative">
            <div class="vote-box relative">
                <input type="hidden" class="lock" autocomplete="off" value="stable">
                <input type="hidden" class="from" autocomplete="off" value="outside-media-viewer">

                <input type="hidden" class="votable-id" value="{{ $post->id }}" autocomplete="off">
                <input type="hidden" class="votable-type" value="post" autocomplete="off">
                <svg class="size15 pointer @auth votable-up-vote @else login-signin-button @endauth" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                    <title>{{ __('UP') }}</title>
                    <path class="up-vote-filled @if(!$upvoted) none @endif" d="M63.89,55.78v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58H68.21a7.56,7.56,0,0,0,7.53-7.58V55.78ZM97.8,53.5,57.85,7.29A10.28,10.28,0,0,0,50,3.92a10.25,10.25,0,0,0-7.87,3.37L2.23,53.52A6.9,6.9,0,0,0,1,61.14c1.46,3.19,5,5.25,9.09,5.25h14V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53a1.61,1.61,0,0,1,.26,1.75,1.83,1.83,0,0,1-1.67,1H75.74v10.6H89.88c4.05,0,7.61-2.06,9.08-5.24A6.92,6.92,0,0,0,97.8,53.5Zm-16,1.24a1.83,1.83,0,0,1-1.67,1H63.89v28.3h-28V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53A1.61,1.61,0,0,1,81.83,54.74Z" style="fill:#28b1e7"/>
                    <path class="up-vote @if($upvoted) none @endif" d="M10.11,66.39c-4.06,0-7.63-2.06-9.09-5.25a6.9,6.9,0,0,1,1.21-7.62L42.11,7.29A10.25,10.25,0,0,1,50,3.92a10.28,10.28,0,0,1,7.87,3.37L97.8,53.5A6.92,6.92,0,0,1,99,61.13c-1.47,3.18-5,5.24-9.08,5.24H75.74V55.77h4.42a1.83,1.83,0,0,0,1.67-1A1.61,1.61,0,0,0,81.57,53L51.39,18A1.9,1.9,0,0,0,48.61,18L18.42,53a1.61,1.61,0,0,0-.26,1.75,1.83,1.83,0,0,0,1.67,1h4.26V66.39Zm58.1,29.69a7.56,7.56,0,0,0,7.53-7.58V55.78H63.89v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58Z" style="fill:#010202"/>
                </svg>

                <p class="bold fs16 no-margin text-center vote-counter" style="margin-bottom: 2px">{{ $votevalue }}</p>
                
                <svg class="size15 pointer @auth votable-down-vote @else login-signin-button @endauth" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                    <title>{{ __('DOWN') }}</title>
                    <path class="down-vote-filled @if(!$downvoted) none @endif" d="M63.89,44.22V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58H68.21a7.56,7.56,0,0,1,7.53,7.58V44.22ZM97.8,46.5,57.85,92.71A10.28,10.28,0,0,1,50,96.08a10.25,10.25,0,0,1-7.87-3.37L2.23,46.48A6.9,6.9,0,0,1,1,38.86c1.46-3.19,5-5.25,9.09-5.25h14V44.22H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47a1.61,1.61,0,0,0,.26-1.75,1.83,1.83,0,0,0-1.67-1H75.74V33.63H89.88c4.05,0,7.61,2.06,9.08,5.24A6.92,6.92,0,0,1,97.8,46.5Zm-16-1.24a1.83,1.83,0,0,0-1.67-1H63.89V15.92h-28v28.3H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47A1.61,1.61,0,0,0,81.83,45.26Z" style="fill:#28b1e7"/>
                    <path class="down-vote @if($downvoted) none @endif" d="M10.11,33.61c-4.06,0-7.63,2.06-9.09,5.25a6.9,6.9,0,0,0,1.21,7.62L42.11,92.71A10.25,10.25,0,0,0,50,96.08a10.28,10.28,0,0,0,7.87-3.37L97.8,46.5A6.92,6.92,0,0,0,99,38.87c-1.47-3.18-5-5.24-9.08-5.24H75.74v10.6h4.42a1.83,1.83,0,0,1,1.67,1A1.61,1.61,0,0,1,81.57,47L51.39,82a1.9,1.9,0,0,1-2.78,0L18.42,47a1.61,1.61,0,0,1-.26-1.75,1.83,1.83,0,0,1,1.67-1h4.26V33.61ZM68.21,3.92a7.56,7.56,0,0,1,7.53,7.58V44.22H63.89V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58Z" style="fill:#010202"/>
                </svg>

            </div>

            <div class="relative informer-box tick-post-container my4">
                <input type="hidden" value="{{ $post->id }}" class="post-id">
                @if(auth()->user() && auth()->user()->id == $thread_owner)
                <input type="hidden" class="remove-best-reply" value="{{ __('Remove best reply') }}">
                <input type="hidden" class="mark-best-reply" value="{{ __('Mark this reply as the best reply') }}">
                <div class="pointer post-tick-button @if(!$post->ticked && !$canbeticked) none @endif"
                    style="max-height: 20px" 
                    title="@if($post->ticked){{ __('Best reply. click to remove') }}@else{{ __('Mark this reply as the best reply') }}@endif">
                    <svg class="size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path class="green-tick @if(!$post->ticked) none @endif" d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/>
                        <path class="grey-tick @if($post->ticked) none @endif" d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#808080"/>
                    </svg>

                    <input type="hidden" class="ticked-message" value="{{ __('Reply chosen as best reply') }}" autocomplete="off">
                    <input type="hidden" class="unticked-message" value="{{ __('Best reply unticked') }}" autocomplete="off">
                </div>
                @else
                    @if($post->ticked)
                    <svg class="size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path class="green-tick" d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/>
                    </svg>
                    @endif
                @endcan
            </div>
        </div>
        <div class="post-main-section" style="@if($post->ticked) background-color: #e1ffe438; @endif">
            <div class="flex align-center space-between p4" style="background-color: #f2f2f2;">
                <div>
                    <div class="no-margin" style="max-height: 34px">
                        <div class="inline-block relative">
                            <div class="flex">
                                <div class="relative user-profile-card-box">
                                    <input type="hidden" class="user-card-container-index"> <!-- value will be initialized at run time by js, to identify each container with incremented index (go to depth.js file) -->
                                    <a href="{{ route('user.profile', ['user'=>$owner->username]) }}" class="user-profile-card-displayer block">
                                        <img src="{{ $owner->sizedavatar(36) }}" class="size34 mr4 rounded" alt="">
                                    </a>
                                    <!-- here we have to check first in the mouse enter if this is the first time the user mouse over the displayer if so wr send a request to fetch the user card and append it here -->
                                </div>
                                <div>
                                    <a href="{{ $owner->profilelink }}" class="no-margin bold blue no-underline">{{ $owner->fullname }}</a>
                                    <div class="flex align-center fs11">
                                        <a href="{{ route('user.profile', ['user'=>$owner->username]) }}" class="fs11 bold bblack no-underline">{{ $owner->username }}</a>
                                        <span class="fs10 gray mx4 unselectable">•</span>
                                        <div class="flex align-center gray">
                                            <span class="relative block">
                                                <span class="tooltip-section">{{ __('replied') }}: {{ $post_date }}</span>
                                                <span class="tooltip tooltip-style-1">{{ $post_created_at }}</span>
                                            </span>
                                            <span class="@if(!$post->is_updated) none @endif post-updated-text ml4">({{ __('edited') }})</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex align-center relative height-max-content">
                    <div class="thread-react-hover @auth like-resource like-resource-from-outside-viewer @endauth @guest login-signin-button @endguest">
                        <input type="hidden" class="lock" value="stable" autocomplete="off">
                        <input type="hidden" class="from" autocomplete="off" value="outside-media-viewer">
                        <input type="hidden" class="likable-id" value="{{ $post->id }}">
                        <input type="hidden" class="likable-type" value="post">
                        <svg class="size17 like-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84">
                            <path class="red-like @auth @if(!$liked) none @endif @else none @endauth" d="M285.26,35.53A107.1,107.1,0,0,1,391.84,142.11c0,107.62-195.92,214.2-195.92,214.2S0,248.16,0,142.11A106.58,106.58,0,0,1,106.58,35.53h0a105.54,105.54,0,0,1,89.34,48.06A106.57,106.57,0,0,1,285.26,35.53Z" style="fill:#d7453d"/>
                            <path class="gray-like @auth @if($liked) none @endif @endauth" d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/>
                        </svg>
                        <p class="no-margin mx4 fs13 bold unselectable likes-counter">{{ $likescount }}</p>
                    </div>
                    <p class="best-reply-ticket unselectable @if(!$post->ticked) none @endif">{{ __('BEST REPLY') }}</p>
                    <div>
                        <svg class="pointer button-with-suboptions size20 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
                        <div class="suboptions-container suboptions-container-right-style">
                            <div class="simple-suboption hide-post hide-post-from-outside-viewer flex align-center">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.03 490.03"><path d="M435.67,54.31a18,18,0,0,0-25.5,0l-64,64c-79.3-36-163.9-27.2-244.6,25.5C41.47,183,5,232.31,3.47,234.41a18.16,18.16,0,0,0,.5,22c34.2,42,70,74.7,106.6,97.5l-56.3,56.3a18,18,0,1,0,25.4,25.5l356-355.9A18.11,18.11,0,0,0,435.67,54.31ZM200.47,264a46.82,46.82,0,0,1-3.9-19,48.47,48.47,0,0,1,67.5-44.6Zm90.2-90.1a84.37,84.37,0,0,0-116.6,116.6L137,327.61c-32.5-18.8-64.5-46.6-95.6-82.9,13.3-15.6,41.4-45.7,79.9-70.8,66.6-43.4,132.9-52.8,197.5-28.1Zm195.4,59.7c-24.7-30.4-50.3-56-76.3-76.3a18.05,18.05,0,1,0-22.3,28.4c20.6,16.1,41.2,36.1,61.2,59.5a394.59,394.59,0,0,1-66,61.3c-60.1,43.7-120.8,59.5-180.3,46.9a18,18,0,0,0-7.4,35.2,224.08,224.08,0,0,0,46.8,4.9,237.92,237.92,0,0,0,71.1-11.1c31.1-9.7,62-25.7,91.9-47.5,50.4-36.9,80.5-77.6,81.8-79.3A18.16,18.16,0,0,0,486.07,233.61Z"/></svg>
                                {{ __('Hide reply') }}
                            </div>
                            @if($canupdate)
                            <div class="simple-suboption open-edit-post-container flex align-center">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.51,334.33l28.28-28.27a7.1,7.1,0,0,1,12.11,5V439.58A42.43,42.43,0,0,1,355.48,482H44.42A42.43,42.43,0,0,1,2,439.58V128.52A42.43,42.43,0,0,1,44.42,86.1H286.11a7.12,7.12,0,0,1,5,12.11l-28.28,28.28a7,7,0,0,1-5,2H44.42V439.58H355.48V339.28A7,7,0,0,1,357.51,334.33ZM495.9,156,263.84,388.06,184,396.9a36.5,36.5,0,0,1-40.29-40.3l8.83-79.88L384.55,44.66a51.58,51.58,0,0,1,73.09,0l38.17,38.17A51.76,51.76,0,0,1,495.9,156Zm-87.31,27.31L357.25,132,193.06,296.25,186.6,354l57.71-6.45Zm57.26-70.43L427.68,74.7a9.23,9.23,0,0,0-13.08,0L387.29,102l51.35,51.34,27.3-27.3A9.41,9.41,0,0,0,465.85,112.88Z"/></svg>
                                {{ __('Edit reply') }}
                            </div>
                            @endif
                            @if($candestroy)
                            <div class="simple-suboption open-delete-post-viewer flex align-center">
                                <div class="relative size17 mr4">
                                    <svg class="size17 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                    <svg class="spinner size17 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                {{ __('Delete reply') }}
                                <input type="hidden" class="success-message" value="{{ __('Your reply has been deleted successfully') }}.">
                            </div>
                            @endif
                            @if(auth()->user() && $post->user_id != auth()->user()->id)
                            <div class="simple-suboption flex align-center @auth @if($owner->id != auth()->user()->id) open-post-report @endif @endauth @guest login-signin-button @endguest">
                                <svg class="size17 mr4" style="fill: #242424" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M336.17,80C287,80,242.87,48,174.26,48A221.86,221.86,0,0,0,93.54,63.17,48,48,0,1,0,24,89.56V496a16,16,0,0,0,16,16H56a16,16,0,0,0,16-16V412.56C109.87,395.28,143.26,384,199.83,384c49.13,0,93.3,32,161.91,32,58.48,0,102-22.62,128.55-40A48,48,0,0,0,512,335.86V95.94c0-34.46-35.26-57.77-66.9-44.12C409.19,67.31,371.64,80,336.17,80ZM464,336c-21.78,15.41-60.82,32-102.26,32-59.95,0-102-32-161.91-32-43.36,0-96.38,9.4-127.83,24V128c21.78-15.41,60.82-32,102.26-32,60,0,102,32,161.91,32,43.28,0,96.32-17.37,127.83-32Z"/></svg>
                                {{ __('Report') }}
                                <input type="hidden" class="post-id" value="{{ $post->id }}">
                                <input type="hidden" class="already-reported" autocomplete="off" value="{{ $already_reported }}">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-line-separator" style="margin-bottom: 0 !important; background-color: #b9b9b9"></div>
            <!-- post content section -->
            <div>
                <div class="post-content-wrapper post-content-wrapper-max-height">
                    {{ $post->parsed_content }}
                </div>
                @if($canupdate)
                <div class="post-content-edit-container none" style="padding: 10px">
                    <input type="hidden" class="content-is-required-error-message" value="{{ __('Reply content is required') }}" autocomplete="off">
                    <div class="flex align-end space-between mb4">
                        <p class="fs12 bold no-margin">{{ __('Edit your reply') }} <span class="error fs13"></span></p>
                        <div class="flex align-center">
                            <div class="update-post-content wtypical-button-style flex align-center" style="padding: 5px 8px;">
                                <div class="relative size12 mr4">
                                    <svg class="flex size12 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"/><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"/></svg>
                                    <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold unselectable fs11">{{ __('Save changes') }}</span>
                                <input type="hidden" class="from" value="thread-show" autocomplete="off">
                                <input type="hidden" class="success-message" value="{{ __('Your reply has been updated successfully') }}" autocomplete="off">
                            </div>
                            <span class="exit-post-edit-changes fs12 bold lblack ml8 pointer unselectable">{{ __('cancel') }}</span>
                        </div>
                    </div>
                    <textarea class="post-edit-new-content-input"></textarea>
                    <input type="hidden" class="current-post-content" value="{{ $post->content }}">
                </div>
                @endif
                <div class="expend-post-content-button none">
                    <input type="hidden" class="status" value="contracted" autocomplete="off">
                    <span class="fs13 unselectable">• • •</span>
                </div>
            </div>
        </div>
    </div>
</div>