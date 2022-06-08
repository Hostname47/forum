<div id="viewer-infos-section-box">
    <input type="hidden" class="thread-id" value="{{ $thread->id }}" autocomplete="off">
    <div class="thread-media-viewer-infos-header">
        <div class="flex">
            <a href="{{ $threadowner->profilelink }}" class="relative hidden-overflow rounded">
                <img src="{{ $threadowner->sizedavatar(100) }}" class="size40 rounded">
            </a>
            <div class="ml8">
                <div class="flex align-end">
                    <a href="{{ $threadowner->profilelink }}" class="bold no-underline blue fs15 mr4">{{ $threadowner->fullname }}</a>
                    @if(auth()->user() && $threadowner->id != auth()->user()->id)
                    <span class="fs10 gray" style="margin: 0 4px 3px 0">•</span>
                    <div class="follow-box thread-component-follow-box flex align-center">
                        <!-- buttons labels -->
                        <input type="hidden" class="follow-text" autocomplete="off" value="{{ __('Follow') }}">
                        <input type="hidden" class="following-text" autocomplete="off" value="{{ __('Following') }}..">
                        <input type="hidden" class="unfollow-text" autocomplete="off" value="{{ __('Unfollow') }}">
                        <input type="hidden" class="unfollowing-text" autocomplete="off" value="{{ __('Unfollowing') }}..">
                        <input type="hidden" class="follow-success-text" autocomplete="off" value="{{ __('User followed successfully') }} !">
                        <input type="hidden" class="unfollow-success-text" autocomplete="off" value="{{ __('User unfollowed successfully') }} !">
                        <div class="pointer @guest login-signin-button @endguest">
                            <div class="size14 relative follow-options-container @if(!$followed) none @endif">
                                <svg class="size14 button-with-suboptions" style="fill: #1e1e1e;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,512a64,64,0,0,0,64-64H192A64,64,0,0,0,256,512ZM471.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C150.56,68.1,96.08,130.3,96.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,32,384c.11,16.4,13,32,32.1,32H447.9c19.12,0,32-15.6,32.1-32A31.23,31.23,0,0,0,471.39,362.29Z"/></svg>
                                <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:max-content">
                                    <div class="pointer follow-user follow-button-with-toggle-bell simple-suboption flex align-center">
                                        <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234,147.1h0a87.1,87.1,0,1,0,87.1,87.11A87.12,87.12,0,0,0,234,147.1Zm0,130.65a43.55,43.55,0,1,1,0-87.1h0a43.55,43.55,0,0,1,0,87.1Zm224.55-7.07a9.77,9.77,0,0,0-6.3-8.52,156.94,156.94,0,0,0-26.41-7.34,9.79,9.79,0,0,0-11.36,7.94,9.46,9.46,0,0,0-.09,2.81,180.26,180.26,0,0,1-32.79,124.58c-22.14-28.49-56.34-47.09-95.35-47.09-9.26,0-23.59,8.71-52.26,8.71s-43-8.71-52.26-8.71c-38.92,0-73.12,18.6-95.35,47.09A180.17,180.17,0,0,1,52.62,279.91c2.66-96,80.45-173.7,176.4-176.29q6.63-.18,13.16.11a9.8,9.8,0,0,0,10.22-9.36,9.94,9.94,0,0,0-.09-1.81A157.76,157.76,0,0,0,246.4,66.9a9.83,9.83,0,0,0-9.16-6.9h-.06C112.7,58.3,9,160.44,9,284.93,9,426,138.59,536.67,285.24,504.35a221.37,221.37,0,0,0,168-167.67A235,235,0,0,0,458.56,270.68ZM234,466.45a180.41,180.41,0,0,1-118-43.91,78.14,78.14,0,0,1,63.14-35.84C198,392.51,216,395.41,234,395.41a181.65,181.65,0,0,0,54.89-8.71A78.38,78.38,0,0,1,352,422.54,180.41,180.41,0,0,1,234,466.45ZM444.34,98,510.8,31.53a4.07,4.07,0,0,0,0-5.77L486.25,1.2a4.08,4.08,0,0,0-5.78,0L414,67.66,347.54,1.2a4.19,4.19,0,0,0-5.78,0L317.2,25.76a4.09,4.09,0,0,0,0,5.77L383.67,98,317.2,164.46a4.1,4.1,0,0,0,0,5.78l24.56,24.56a4.08,4.08,0,0,0,5.78,0L414,128.33l66.47,66.47a4.08,4.08,0,0,0,5.78,0l24.55-24.56a4.08,4.08,0,0,0,0-5.78Z"/></svg>
                                        <div class="fs12 button-text unfollow-button-text">{{ __('Unfollow') }}</div>
                                        <input type="hidden" class="user-id" value="{{ $threadowner->id }}" autocomplete="off">
                                        <input type="hidden" class="lock" value="stable" autocomplete="off">
                                        <input type="hidden" class="status" value="followed" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="@if($followed) none @endif @auth follow-user follow-button-with-toggle-bell follow-button-textual @else login-signin-button @endauth">
                                <p class="no-margin fs12 bold button-text follow-button-text bblack unselectable">{{ __('Follow') }}</p>
                                <input type="hidden" class="user-id" value="{{ $threadowner->id }}" autocomplete="off">
                                <input type="hidden" class="lock" value="stable" autocomplete="off">
                                <input type="hidden" class="status" value="not-followed" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <p class="no-margin gray fs13">{{ $threadowner->username }}</p>
            </div>
        </div>
        <div class="relative">
            <svg class="pointer button-with-suboptions size20 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
            <div class="suboptions-container suboptions-container-right-style" style="width:max-content">
                <div class="pointer simple-suboption @auth save-thread @else login-signin-button @endauth flex align-center">
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
                    <input type="hidden" class="status" value="@if($saved) saved @else not-save @endif" autocomplete="off">
                    <input type="hidden" class="from" value="media-viewer" autocomplete="off">
                    <input type="hidden" class="save-text" value="{{ __('Save post') }}">
                    <input type="hidden" class="unsave-text" value="{{ __('Unsave post') }}">
                    <input type="hidden" class="saved-message" value="{{ __('Post saved successfully') }}">
                    <input type="hidden" class="unsaved-message" value="{{ __('Post unsaved successfully') }}">
                </div>
                @if(auth()->user() && auth()->user()->id == $thread->user_id)
                <a href="{{ $edit_link }}" class="no-underline simple-suboption flex align-center">
                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.51,334.33l28.28-28.27a7.1,7.1,0,0,1,12.11,5V439.58A42.43,42.43,0,0,1,355.48,482H44.42A42.43,42.43,0,0,1,2,439.58V128.52A42.43,42.43,0,0,1,44.42,86.1H286.11a7.12,7.12,0,0,1,5,12.11l-28.28,28.28a7,7,0,0,1-5,2H44.42V439.58H355.48V339.28A7,7,0,0,1,357.51,334.33ZM495.9,156,263.84,388.06,184,396.9a36.5,36.5,0,0,1-40.29-40.3l8.83-79.88L384.55,44.66a51.58,51.58,0,0,1,73.09,0l38.17,38.17A51.76,51.76,0,0,1,495.9,156Zm-87.31,27.31L357.25,132,193.06,296.25,186.6,354l57.71-6.45Zm57.26-70.43L427.68,74.7a9.23,9.23,0,0,0-13.08,0L387.29,102l51.35,51.34,27.3-27.3A9.41,9.41,0,0,0,465.85,112.88Z"/></svg>
                    <div class="black">{{ __('Edit post') }}</div>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="thread-media-viewer-infos-content">
        <div class="px8 py8">
            <div class="flex space-between">
                <div class="flex align-center mb8">
                    <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        {!! $thread->category->forum->icon !!}
                    </svg>
                    <div class="flex align-center">
                        <a href="{{ route('forum.all.threads', ['forum'=>$thread->category->forum->slug]) }}" class="fs11 black-link">{{ __($thread->category->forum->forum) }}</a>
                        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                        <a href="{{ route('category.threads', ['forum'=>$thread->category->forum->slug,'category'=>$thread->category->slug]) }}" class="fs11 black-link">{{ __($thread->category->category) }}</a>
                    </div>
                </div>

                <svg class="size14" style="fill: #202020; margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    {!! $thread->visibility->icon !!}
                </svg>
            </div>
            <div class="expand-box mb8">
                <span><a href="{{ $thread->link }}" class="expandable-text bold fs20 blue no-underline my4">{{ $thread->mediumslice }}</a></span>
                @if($thread->mediumslice != $thread->subject)
                <input type="hidden" class="expand-slice-text" value="{{ $thread->mediumslice }}">
                <input type="hidden" class="expand-whole-text" value="{{ $thread->subject }}">
                <input type="hidden" class="expand-text-state" value="0">
                <span class="pointer expand-button fs12 inline-block">{{ __('see all') }}</span>
                <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                @endif
            </div>
            <div class="mb8 thread-content">
                <div class="thread-content-box thread-content-box-max-height">
                    <div class="thread-content">{!! $content !!}</div>
                    <input type="hidden" class="expand-state" autocomplete="off" value="0">
                    <input type="hidden" class="expand-button-text" autocomplete="off" value="{{ __('see all') }}">
                    <input type="hidden" class="expand-button-collapse-text" autocomplete="off" value="{{ __('see less') }}">
                </div>
            </div>
        </div>
        <div class="expend-media-viewer-thread-content none">
            <input type="hidden" class="status" value="contracted" autocomplete="off">
            <span class="fs13 unselectable">• • •</span>
        </div>
        <div class="simple-line-separator mb4"></div>
        <div class="flex align-center thread-viewer-react-container px8">
            <div class="relative vote-box">
                <div class="flex align-center mx4 pr8" style="border-right: 1px solid #c1c1c1">
                    <input type="hidden" class="lock" autocomplete="off" value="stable">
                    <input type="hidden" class="from" autocomplete="off" value="inside-media-viewer">

                    <input type="hidden" class="votable-type" value="thread">
                    <input type="hidden" class="votable-id" value="{{ $thread->id }}">
                    <svg class="size15 pointer @auth votable-up-vote @endauth @guest login-signin-button @endguest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                        <title>{{ __('UP') }}</title>
                        <path class="up-vote-filled @if(!$upvoted) none @endif" d="M63.89,55.78v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58H68.21a7.56,7.56,0,0,0,7.53-7.58V55.78ZM97.8,53.5,57.85,7.29A10.28,10.28,0,0,0,50,3.92a10.25,10.25,0,0,0-7.87,3.37L2.23,53.52A6.9,6.9,0,0,0,1,61.14c1.46,3.19,5,5.25,9.09,5.25h14V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53a1.61,1.61,0,0,1,.26,1.75,1.83,1.83,0,0,1-1.67,1H75.74v10.6H89.88c4.05,0,7.61-2.06,9.08-5.24A6.92,6.92,0,0,0,97.8,53.5Zm-16,1.24a1.83,1.83,0,0,1-1.67,1H63.89v28.3h-28V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53A1.61,1.61,0,0,1,81.83,54.74Z" style="fill:#28b1e7"/>
                        <path class="up-vote @if($upvoted) none @endif" d="M10.11,66.39c-4.06,0-7.63-2.06-9.09-5.25a6.9,6.9,0,0,1,1.21-7.62L42.11,7.29A10.25,10.25,0,0,1,50,3.92a10.28,10.28,0,0,1,7.87,3.37L97.8,53.5A6.92,6.92,0,0,1,99,61.13c-1.47,3.18-5,5.24-9.08,5.24H75.74V55.77h4.42a1.83,1.83,0,0,0,1.67-1A1.61,1.61,0,0,0,81.57,53L51.39,18A1.9,1.9,0,0,0,48.61,18L18.42,53a1.61,1.61,0,0,0-.26,1.75,1.83,1.83,0,0,0,1.67,1h4.26V66.39Zm58.1,29.69a7.56,7.56,0,0,0,7.53-7.58V55.78H63.89v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58Z" style="fill:#1c1c1c"/>
                    </svg>
                    <p class="bold text-center vote-counter no-margin mx8" style="color: #1c1c1c">{{ $votevalue }}</p>
                    <svg class="size15 pointer @auth votable-down-vote @endauth @guest login-signin-button @endguest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                        <title>{{ __('DOWN') }}</title>
                        <path class="down-vote-filled @if(!$downvoted) none @endif" d="M63.89,44.22V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58H68.21a7.56,7.56,0,0,1,7.53,7.58V44.22ZM97.8,46.5,57.85,92.71A10.28,10.28,0,0,1,50,96.08a10.25,10.25,0,0,1-7.87-3.37L2.23,46.48A6.9,6.9,0,0,1,1,38.86c1.46-3.19,5-5.25,9.09-5.25h14V44.22H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47a1.61,1.61,0,0,0,.26-1.75,1.83,1.83,0,0,0-1.67-1H75.74V33.63H89.88c4.05,0,7.61,2.06,9.08,5.24A6.92,6.92,0,0,1,97.8,46.5Zm-16-1.24a1.83,1.83,0,0,0-1.67-1H63.89V15.92h-28v28.3H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47A1.61,1.61,0,0,0,81.83,45.26Z" style="fill:#28b1e7"/>
                        <path class="down-vote @if($downvoted) none @endif" d="M10.11,33.61c-4.06,0-7.63,2.06-9.09,5.25a6.9,6.9,0,0,0,1.21,7.62L42.11,92.71A10.25,10.25,0,0,0,50,96.08a10.28,10.28,0,0,0,7.87-3.37L97.8,46.5A6.92,6.92,0,0,0,99,38.87c-1.47-3.18-5-5.24-9.08-5.24H75.74v10.6h4.42a1.83,1.83,0,0,1,1.67,1A1.61,1.61,0,0,1,81.57,47L51.39,82a1.9,1.9,0,0,1-2.78,0L18.42,47a1.61,1.61,0,0,1-.26-1.75,1.83,1.83,0,0,1,1.67-1h4.26V33.61ZM68.21,3.92a7.56,7.56,0,0,1,7.53,7.58V44.22H63.89V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58Z" style="fill:#1c1c1c"/>
                    </svg>
                </div>

            </div>
            <div class="thread-react-hover @auth like-resource viewer-thread-like like-resource-from-viewer @endauth @guest login-signin-button @endguest">
                <input type="hidden" class="lock" value="stable" autocomplete="off">
                <input type="hidden" class="from" autocomplete="off" value="inside-media-viewer">
                <input type="hidden" class="likable-type" value="thread" autocomplete="off">
                <input type="hidden" class="likable-id" value="{{ $thread->id }}" autocomplete="off">
                <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84">
                    <path class="red-like @if(!$liked) none @endif" d="M285.26,35.53A107.1,107.1,0,0,1,391.84,142.11c0,107.62-195.92,214.2-195.92,214.2S0,248.16,0,142.11A106.58,106.58,0,0,1,106.58,35.53h0a105.54,105.54,0,0,1,89.34,48.06A106.57,106.57,0,0,1,285.26,35.53Z" style="fill:#d7453d"/>
                    <path class="gray-like @if($liked) none @endif" d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/>
                </svg>
                <p class="gray no-margin fs12 bold likes-counter unselectable ml4">{{ $likescount }}</p>
            </div>
            <div class="thread-react-hover move-to-thread-viewer-reply flex align-center">
                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" fill="#1c1c1c" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                <p class="no-margin unselectable fs12"><span class="posts-count bold">{{ $posts_count }}</span> {{__('replies')}}</p>
            </div>
            <div class="flex align-center move-to-right mr4">
                <svg class="mr4 size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                <p class="no-margin fs12 bold unselectable">{{ $thread->view_count }}</p>
            </div>
        </div>
        <div class="simple-line-separator my4"></div>
        @auth
            @if($thread->replies_off)
                <p class="fs13 text-center">{{ __('The owner of this post turned off replies') }}</p>
            @else
            <div id="viewer-reply-container" class="share-post-box my4">
                <input type="hidden" class="selected-thread-posts-count" value="{{ $posts_count }}" autocomplete="off">
                <input type="hidden" class="content-required" value="{{ __('Reply content is required') }}" autocomplete="off">
                <input type="hidden" class="thread-id" value="{{ $thread->id }}" autocomplete="off">
                <div class="flex red-section-style error-container none" style="padding: 7px; margin: 8px;">
                    <svg class="size11 mr8 mt2" style="min-width: 11px;" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                    <span class="error fs11 bold no-margin"></span>
                </div>
                <div class="flex space-between my8 px8">
                    <p class="bold fs13 my4 forum-color" id="viewer-reply-text-label">{{ __('Your reply') }}</p>
                    <div class="typical-button-style flex align-center width-max-content @auth share-post @else login-signin-button @endauth" style="padding: 5px 8px;">
                        <div class="relative size13 mr4">
                            <svg class="size13 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M201.05,3.07c8.23,2.72,16.28,5.55,23,11.56,18.11,16.18,19.44,44.44,2.63,63.18-15.58,17.37-43.73,18.58-61,2.32-3.22-3-5.24-3.16-8.9-.81-12.46,8-25.25,15.52-37.83,23.35-2.31,1.44-3.62,1.53-4.7-1.19a24.77,24.77,0,0,0-2.4-4.25c-3.53-5.4-3.54-5.38,2.16-8.86,12.22-7.48,24.42-15,36.69-22.41,2-1.22,3.23-2.23,2.32-4.93-8.35-24.77,7.61-50.71,30.61-56.36.94-.23,2.38-.15,2.75-1.6Zm22.63,173.39c-18.11-15.47-41.43-15-58.9,1.2-2.5,2.31-4.1,2.5-6.93.7C147,171.46,136,164.82,125,158.12c-2.89-1.76-5.92-4.75-8.81-4.66-2.47.08-2.92,5-5,7.28-.11.12-.15.3-.27.41-2.76,2.69-2.35,4.38,1.1,6.42,12.77,7.52,25.29,15.47,38,23,2.84,1.7,3.94,3.2,2.65,6.51-2.57,6.57-2.39,13.51-1.28,20.28,3.49,21.33,24.74,38.21,45.44,36.42,24.16-2.08,42.07-21.18,41.82-44.6C238.39,196.12,233.64,185,223.68,176.46Zm-161-92c-24-.28-44.23,19.81-44.27,44a44.34,44.34,0,0,0,43.71,44.11c24,.28,44.22-19.81,44.27-44A44.36,44.36,0,0,0,62.68,84.43Z"/></svg>
                            <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="bold fs11 unselectable">{{ __('Share your reply') }}</span>
                        <input type="hidden" class="success-message" value="{{ __('Your reply has been created') }}" autocomplete="off">
                        <input type="hidden" class="from" value="media-viewer" autocomplete="off">
                    </div>
                </div>
                <textarea name="content" id="viewer-reply-input" class="post-input" placeholder="{{ __('Your reply here') }}"></textarea>
                <style>
                    .thread-media-viewer-infos-content .editor-toolbar {
                        background-color: #f4f4f4;
                    }
                    .thread-media-viewer-infos-content .fa-arrows-alt, .thread-media-viewer-infos-content .fa-columns {
                        display: none !important;
                    }
                    .thread-media-viewer-infos-content .separator:last-of-type {
                        display: none !important;
                    }
                    .thread-media-viewer-infos-content .CodeMirror,
                    .thread-media-viewer-infos-content .CodeMirror-scroll {
                        max-height: 100px !important;
                        min-height: 100px !important;
                        border-radius: 0;
                        border-left: none;
                        border-right: none;
                        border-color: #dbdbdb;
                    }
                    .thread-media-viewer-infos-content .CodeMirror-scroll:focus {
                        border-color: #64ceff;
                        box-shadow: 0 0 0px 3px #def2ff;
                    }
                    .thread-media-viewer-infos-content .editor-toolbar {
                        padding: 0 4px;
                        opacity: 0.8;
                        height: 38px;
                        border-radius: 0;
                        border-left: none;
                        border-right: none;
                        border-top-color: #dbdbdb;

                        display: flex;
                        align-items: center;
                    }
                    .thread-media-viewer-infos-content .editor-statusbar {
                        display: none !important;
                    }
                    
                    .viewer-post-container .CodeMirror {
                        border-left: 1px solid #dbdbdb;
                        border-right: 1px solid #dbdbdb;
                        border-color: #dbdbdb;
                    }

                    .viewer-post-container .editor-toolbar {
                        border-left: 1px solid #dbdbdb;
                        border-right: 1px solid #dbdbdb;
                        border-top-color: #dbdbdb;
                    }
                </style>
            </div>
            @endif
        @endauth
        <div id="media-viewer-posts-count" class="forum-color bold mt8 ml8 @if(!$posts_count) none @endif">{{__('Replies')}} (<span class="posts-count">{{ $posts_count }}</span>)</div>
        <div class="mx8" style="margin-bottom: 12px">
            @if($missed_ticked_post)
            <div class="my8 section-style flex">
                <svg class="size14 mr8 mt2" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                <div>
                    <p class="no-margin fs12 lblack lh15">{{ __("This post had already a ticked reply, and It seems to be not available either because the owner's account is deactivated or the reply is hidden by admins") }}.</p>
                    @if(auth()->user() && auth()->user()->id == $thread->user_id)
                    <div>
                        <span class="block mt4 fs11 bold lblack">{{ __('Hint to post owner') }} ;</span>
                        <p class="no-margin fs11">{{ __("You can delete the tick from the missed reply by clicking on remove tick in post options button") }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            <div id="viewer-posts-container" class="mt8">
            @if($posts_count)
                @foreach($posts as $post)
                    <x-thread.viewer-reply :post="$post" :data="['thread-owner-id'=>$threadowner->id]"/>
                @endforeach
                @if($posts_count > ($ticked ? 7 : 6))
                <div id="viewer-posts-fetch-more">
                    <div class="full-center">
                        <svg class="spinner size24 py8" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                </div>
                @endif
            @endif
            </div>
        </div>
    </div>
</div>