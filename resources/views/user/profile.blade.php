@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/simplemde.js') }}"></script>
    <script src="{{ asset('js/post.js') }}" defer></script>
    <script src="{{ asset('js/profile.js') }}" defer></script>
    <script src="{{ asset('js/fetch/profile-threads-fetch.js') }}" defer></script>
@endpush

@section('title', $user->username)

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.profile'])
    
    <!-- followers -->
    <div id="user-followers-viewer" class="global-viewer full-center none">
        <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
        <div class="viewer-box-style-1" style="margin-top: -26px; width: 400px;">
            <div class="full-center light-gray-border-bottom relative border-box" style="padding: 14px;">
                <span class="fs16 bold forum-color flex align-center mt2">{{ __("Followers") }} ({{ $followerscount }})</span>
                <div class="pointer fs20 close-global-viewer unselectable absolute" style="right: 16px">✖</div>
            </div>
            <div class="full-center relative">
                <div id="user-followers-container" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 120px; max-height: 358px">
                    
                </div>
                <div class="loading-box flex-column full-center absolute" style="margin-top: -20px">
                    <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                    <span class="forum-color fs11 mt8">{{ __('please wait') }}..</span>
                </div>
            </div>
        </div>
    </div>
    <!-- follows -->
    <div id="user-follows-viewer" class="global-viewer full-center none">
        <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
        <div class="viewer-box-style-1" style="margin-top: -26px; width: 400px;">
            <div class="full-center light-gray-border-bottom relative border-box" style="padding: 14px;">
                <span class="fs16 bold forum-color flex align-center mt2">{{ __("Follows") }} ({{ $followscount }})</span>
                <div class="pointer fs20 close-global-viewer unselectable absolute" style="right: 16px">✖</div>
            </div>
            <div class="full-center relative">
                <div id="user-follows-container" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 120px; max-height: 358px;">
                    
                </div>
                <div class="loading-box flex-column full-center absolute" style="margin-top: -20px">
                    <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                    <span class="forum-color fs11 mt8">{{ __('please wait') }}..</span>
                </div>
            </div>
        </div>
    </div>

    <div id="middle-container" class="middle-padding-1" style="padding-bottom: unset">
        <input type="hidden" id="page" value="userprofile" autocomplete="off">
        <input type="hidden" id="profile-user-id" value="{{ $user->id }}" autocomplete="off">
        <section class="flex">  
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page' => 'profile'])
                <div class="relative us-user-media-container">
                    <div class="us-cover-container full-center">
                        @if(!$user->cover)
                            @if(auth()->user() && $user->id == auth()->user()->id)
                            <a href="{{ route('user.settings') }}" class="no-underline change-cover full-center full-width full-height">
                                <div class="flex align-center">
                                    <svg class="size20 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464,64H48A48,48,0,0,0,0,112V400a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V112A48,48,0,0,0,464,64Zm-6,336H54a6,6,0,0,1-6-6V118a6,6,0,0,1,6-6H458a6,6,0,0,1,6,6V394A6,6,0,0,1,458,400ZM128,152a40,40,0,1,0,40,40A40,40,0,0,0,128,152ZM96,352H416V272l-87.52-87.51a12,12,0,0,0-17,0L192,304l-39.51-39.52a12,12,0,0,0-17,0L96,304Z" style="fill:#fff"/></svg>
                                    <p class="fs17 white">{{ __('Add a cover image') }}</p>
                                </div>
                            </a>
                            @endif
                        @else
                            <img src="{{ $user->cover }}"  class="us-cover open-image-on-image-viewer pointer" alt="">
                        @endif
                    </div>
                    <div class="us-after-cover-section flex">
                        <div style="padding: 7px; background-color: #F0F2F559" class="rounded">
                            <div class="us-profile-picture-container full-center rounded">
                                <img src="{{ $user->sizedavatar(400, '-h') }}" class="us-profile-picture handle-image-center-positioning open-image-on-image-viewer pointer" alt="">
                            </div>
                        </div>
                        <div class="ms-profile-infos-container flex full-width">
                            <div style="max-width: 220px">
                                <h2 class="no-margin flex align-center">{{ $user->firstname . ' ' . $user->lastname }}</h2>
                                <p class="bold forum-color no-margin"><span style="margin-right: 2px">@</span>{{ $user->username }} @if($user->username == 'hostname47') - <span class="blue unselectable bold fs12">Site Owner</span> @endif</p>
                            </div>
                            <div class="move-to-right flex align-center height-max-content follow-box">
                                <div class="flex align-center">
                                    <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                                    <div id="open-followers-dialog" class="flex align-center px8 py4 pointer br4 light-grey-hover">
                                        <div class="forum-color fs13">{{ __('Followers') }} :<span class="bold followers-counter ml4 black">{{ $followerscount }}</span></div>
                                    </div>
                                    <div class="gray height-max-content mx8 fs10 unselectable">•</div>
                                    <div id="open-follows-dialog" class="flex align-center px8 py4 pointer br4 light-grey-hover mr8">
                                        <div class="forum-color fs13">{{ __('Follows') }} :<span class="bold follows-counter ml4 black">{{ $followscount }}</span></div>
                                    </div>
                                </div>
                                @if(!(auth()->user() && $user->id == auth()->user()->id))
                                <!-- follow-profile-owner class is used to add/remove follower component once current user follow him -->
                                <div class="wtypical-button-style @auth follow-user follow-button-with-icon follow-profile-owner adjust-counter @else login-signin-button @endauth" style="padding: 5px 8px">
                                    <div class="relative size14 mr4">
                                        <svg class="size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path class="followed-icon @if(!$followed) none @endif" d="M446.26,288.77l-115.32,129a11.26,11.26,0,0,1-15.9.87l-.28-.26L266,371.62a11.23,11.23,0,0,0-15.89.31h0l-28,29.13a11.26,11.26,0,0,0,.33,15.91l95.72,91.89a11.26,11.26,0,0,0,15.91-.33l.27-.29L493.14,330.68a11.26,11.26,0,0,0-.89-15.89l-30.11-26.91A11.25,11.25,0,0,0,446.26,288.77ZM225,149.1a87.1,87.1,0,1,0,87.1,87.09A87.12,87.12,0,0,0,225,149.1Zm0,130.64a43.55,43.55,0,1,1,43.55-43.55A43.56,43.56,0,0,1,225,279.74ZM208.43,470l24,25.28a9.89,9.89,0,0,1-7.18,16.7H225C100.87,512,.27,411.57,0,287.5S101,62,225,62c100.49,0,185.55,65.82,214.45,156.72a11.55,11.55,0,0,1-2.38,11.17L421,248a11.62,11.62,0,0,1-20-5C381.38,164.17,309.93,105.55,225,105.55,124.93,105.55,43.55,186.93,43.55,287A180.16,180.16,0,0,0,77.39,392.15c22.23-28.49,56.43-47.09,95.35-47.09h.06a6.35,6.35,0,0,1,6.2,6.4v31.31a6.4,6.4,0,0,1-8.23,6.14l-.66-.21A78.15,78.15,0,0,0,107,424.54,180.6,180.6,0,0,0,202.48,467,9.88,9.88,0,0,1,208.43,470Z"/>
                                            <g class="follow-icon @if($followed) none @endif">
                                                <path d="M146.9,234.19A87.1,87.1,0,1,0,234,147.1,87.12,87.12,0,0,0,146.9,234.19Zm130.65,0A43.55,43.55,0,1,1,234,190.65,43.56,43.56,0,0,1,277.55,234.19Z"/>
                                                <path d="M329.48,70.28A21.37,21.37,0,0,0,305,91.47h0c0,10.09,8.16,19.61,18.13,21.16a90.1,90.1,0,0,1,75,75c1.55,10,11.07,18.13,21.16,18.13h0a21.37,21.37,0,0,0,21.19-24.48A133.06,133.06,0,0,0,329.48,70.28Z"/>
                                                <path d="M425.85,254.82a9.8,9.8,0,0,0-11.45,10.75,180.29,180.29,0,0,1-32.79,124.58c-22.14-28.49-56.34-47.09-95.35-47.09-9.26,0-23.59,8.71-52.26,8.71s-43-8.71-52.26-8.71c-38.92,0-73.12,18.6-95.35,47.09A180.14,180.14,0,0,1,52.62,279.91c2.66-96,80.45-173.7,176.4-176.29q6.63-.18,13.16.11a9.8,9.8,0,0,0,10.13-11.17A158.17,158.17,0,0,0,246.4,66.9,9.83,9.83,0,0,0,237.24,60h-.06C112.7,58.3,9,160.44,9,284.93,9,426,138.59,536.67,285.24,504.35a221.36,221.36,0,0,0,168-167.67,234.77,234.77,0,0,0,5.32-66,9.77,9.77,0,0,0-6.3-8.52A156.61,156.61,0,0,0,425.85,254.82ZM234,466.45a180.39,180.39,0,0,1-118-43.91,78.15,78.15,0,0,1,63.14-35.84C198,392.51,216,395.41,234,395.41a181.65,181.65,0,0,0,54.89-8.71A78.37,78.37,0,0,1,352,422.54,180.39,180.39,0,0,1,234,466.45Z"/><path d="M329.87,4.77A21.05,21.05,0,0,0,306.5,26.09h0A21.46,21.46,0,0,0,326,47.41,158.69,158.69,0,0,1,468.46,189.86a21.46,21.46,0,0,0,21.32,19.51h0A21,21,0,0,0,511.1,186C502.05,90.26,425.62,13.82,329.87,4.77Z"/>
                                            </g>
                                        </svg>
                                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <p class="no-margin fs11 bold button-text unselectable">@if($followed){{ __('Followed') }}@else{{ __('Follow') }}@endif</p>
                                    
                                    <input type="hidden" autocomplete="off" class="follow-text" value="{{ __('Follow') }}">
                                    <input type="hidden" autocomplete="off" class="following-text" value="{{ __('Following') }}..">
                                    <input type="hidden" autocomplete="off" class="followed-text" value="{{ __('Followed') }}">
                                    <input type="hidden" autocomplete="off" class="unfollowing-text" value="{{ __('Unfollowing') }}..">
                                    <input type="hidden" autocomplete="off" class="follow-success" value="{{ __('User followed successfully') }}">
                                    <input type="hidden" autocomplete="off" class="unfollow-success" value="{{ __('User unfollowed successfully') }}">
                                    
                                    <input type="hidden" autocomplete="off" class="user-id" value="{{ $user->id }}">
                                    @php $follow_status = ($followed) ? 'followed' : 'not-followed'; @endphp
                                    <input type="hidden" autocomplete="off" class="status" value="{{ $follow_status }}" autocomplete="off">
                                    <input type="hidden" autocomplete="off" class="lock" value="stable" autocomplete="off">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px" class="index-middle-width">
                    @if($user->status->slug == 'deactivated')
                        <h2 class="text-center">{{__('DEACTIVATED ACCOUNT')}}</h2>
                    @else
                        @if($threads->count())
                            <div class="forum-color mb8">
                                @if(auth()->user() && $user->id == auth()->user()->id)
                                <div class="flex align-end space-between">
                                    <h2 class="no-margin">{{ __('Your Posts') }}</h2>
                                    <a href="{{ route('thread.add') }}" class="flex bblack no-underline">
                                        <svg class="size14 mr4" fill="#181818" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.18,217.58a23.4,23.4,0,0,0-23.4,23.4V428.2a23.42,23.42,0,0,1-23.4,23.4H83.76a23.42,23.42,0,0,1-23.4-23.4V100.57a23.42,23.42,0,0,1,23.4-23.4H271a23.4,23.4,0,0,0,0-46.8H83.76a70.29,70.29,0,0,0-70.21,70.2V428.2a70.29,70.29,0,0,0,70.21,70.2H411.38a70.29,70.29,0,0,0,70.21-70.2V241A23.39,23.39,0,0,0,458.18,217.58Zm-302,56.25a11.86,11.86,0,0,0-3.21,6l-16.54,82.75a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L233,359.76a11.68,11.68,0,0,0,6-3.21L424.12,171.4,341.4,88.68ZM481.31,31.46a58.53,58.53,0,0,0-82.72,0L366.2,63.85l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72ZM155.72,273.08a11.86,11.86,0,0,0-3.21,6L136,361.8a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L232.48,359a11.68,11.68,0,0,0,6-3.21L423.62,170.65,340.9,87.93ZM480.81,30.71a58.53,58.53,0,0,0-82.72,0L365.7,63.1l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72Z"/></svg>
                                        <span class="unselectable bold fs13">{{ __('Create a post') }}</span>
                                    </a>
                                </div>
                                @else
                                <h2 class="no-margin">{{ __('Posts') }}</h2>
                                @endif
                            </div>
                            <input type="hidden" class="current-threads-count" autocomplete="off" value="{{ $threads->count() }}">
                            <div id="threads-global-container">
                                @foreach($threads as $thread)
                                    <x-index-resource :thread="$thread"/>
                                @endforeach
                            </div>

                            @if($hasmore)
                                @include('partials.thread.faded-thread', ['classes'=>'profile-fetch-more'])
                            @endif
                        @else
                            <div class="full-center" style="margin-bottom: 36px">
                                <div class="flex flex-column align-center">
                                    <svg class="size48 my4" viewBox="0 0 442 442"><path d="M442,268.47V109.08a11.43,11.43,0,0,0-.1-1.42,2.51,2.51,0,0,0,0-.27,10.11,10.11,0,0,0-.29-1.3v0c-.1-.31-.21-.62-.34-.92l-.12-.26-.15-.32c-.17-.34-.36-.67-.56-1a.57.57,0,0,1-.08-.13,10.33,10.33,0,0,0-.81-1l-.17-.18a8,8,0,0,0-.84-.81l-.14-.12a9.65,9.65,0,0,0-1.05-.76l-.26-.15a8.61,8.61,0,0,0-1.05-.53.67.67,0,0,0-.12-.06l-236-99-.06,0-.28-.1a10,10,0,0,0-4.4-.61h-.08a10.59,10.59,0,0,0-1.94.39l-.12,0c-.27.09-.55.18-.82.29l0,0-69.22,29a10,10,0,0,0,0,18.44L186,74.73v88.16L6.13,238.37l-.36.17-.36.17c-.28.15-.55.31-.82.48l-.13.07s0,0,0,0a9.86,9.86,0,0,0-1,.72l-.09.08c-.25.23-.49.46-.72.71l-.2.22a8.19,8.19,0,0,0-.53.67c-.07.08-.13.17-.19.25-.18.27-.34.54-.5.81l-.09.15c-.17.33-.32.67-.46,1,0,.09-.07.19-.1.28-.09.26-.18.53-.25.79l-.09.35c-.06.28-.12.55-.16.83,0,.1,0,.19,0,.28A11.87,11.87,0,0,0,0,247.62V333a10,10,0,0,0,6.13,9.22l235.92,99a9.8,9.8,0,0,0,1.95.6l.19,0c.26.05.52.09.79.12s.66.05,1,.05.67,0,1-.05.53-.07.79-.12l.19,0a9.8,9.8,0,0,0,2-.6l186-78A10,10,0,0,0,442,354V268.47ZM330.23,300.4l-63.15-26.49a10,10,0,0,0-7.74,18.44l45,18.9L246,335.75,137.62,290.29l58.4-24.5,35.53,14.9a10,10,0,1,0,7.74-18.44l-33.27-14V184.58l200.13,84ZM186,248.29l-74.25,31.16L35.85,247.59l150.17-63v63.71ZM196,20.84,406.15,109l-43.37,18.2L200,58.89l-.09,0L152.65,39Zm162.82,126.4a10,10,0,0,0,7.81,0L422,124.05V253.51L206,162.89V83.13ZM20,262.63l216,90.62V417L20,326.34ZM422,347.3,256,417V353.25l166-69.66Z"/></svg>
                                    @if(auth()->user() && $user->id == auth()->user()->id)
                                    <p class="fs20 bold" style="margin: 2px 0">{{ __("You don't have any post for the moment !") }}</p>
                                    <div class="flex align-center">
                                        <p class="my4 text-center">{{ __("If you want to create a new post or question, click on the button above") }}</p>
                                    </div>
                                    @else
                                    <p class="fs20 bold" style="margin: 2px 0">{{ __("This user has no posts for the moment !") }}</p>
                                    <div class="flex align-center">
                                        <p class="my4 text-center">{{ __("Check out his activities") }} <a href="{{ route('user.activities', ['user'=>$user->username]) }}" class="link-path">{{ _('here') }}</a></p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div id="right-panel">
                <x-user.right-panel-user-card :user="$user" withcover="0" :data="['threadscount'=>$threadscount]"/>
                @include('partials.user-space.user-personal-infos', ['user'=>$user])
            </div>
        </section>
    </div>
@endsection