@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/settings.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.settings'])
    <div id="middle-container" class="middle-padding-1">
        <!-- inputs and messages -->
        <input type="hidden" autocomplete="off" value="0" id="cover-removed" autocomplete="off">
        <input type="hidden" autocomplete="off" value="0" id="avatar-removed" autocomplete="off">
        <input type="hidden" id="cover-image-type-error-message" value="{{ __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported for cover image') }}" autocomplete="off">
        <input type="hidden" id="avatar-image-type-error-message" value="{{ __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported for avatar') }}" autocomplete="off">
        <input type="hidden" id="firstname-required-error-message" value="{{ __('Firstname field is required') }}" autocomplete="off">
        <input type="hidden" id="lastname-required-error-message" value="{{ __('Lastname field is required') }}" autocomplete="off">
        <input type="hidden" id="username-required-error-message" value="{{ __('Username field is required') }}" autocomplete="off">
        <input type="hidden" id="about-required-error-message" value="{{ __('About field is required') }}" autocomplete="off">

        <!-- remove used avatar viewer (in case of cover the viewer is integrated with cover container) -->
        @if($user->hasavatar)
        <div id="remove-user-avatar-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; width: 370px;">
                <div class="full-center light-gray-border-bottom relative border-box" style="padding: 14px;">
                    <div class="flex align-center mt2">
                        <svg class="size16 mr4" style="min-width: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"></path></svg>
                        <span class="fs16 bold forum-color">{{ __("Remove avatar") }}</span>
                    </div>
                    <div class="pointer fs20 close-global-viewer unselectable absolute" style="right: 16px">✖</div>
                </div>
                <div class="flex" style="padding: 14px;">
                    <img src="{{ $user->sizedavatar(300, '-h') }}" style="width: 150px; height: 150px;" alt="">
                    <div class="ml8">
                        <p class="no-margin mb4 bold fs15 lblack">{{__('Remove current avatar')}}</p>
                        <p class="no-margin mb4 fs13 lblack lh15">{{ __('Are you sure you want to remove this avatar') }} ? {{ __("Click on remove button and save the changes") }}</p>
                        <div class="flex align-center mt8">
                            <div class="red-button-style flex align-center remove-avatar-button">
                                <svg class="size13 mr4" fill="white" style="min-width: 13px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"></path></svg>
                                <span class="flex fs12 bold">{{ __('Remove') }}</span>
                            </div>
                            <div class="pointer fs13 close-global-viewer ml8">{{ __('cancel') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <section class="flex">
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page' => 'settings'])
                <h1 class="fs19 forum-color" style="margin-top: 16px 0 12px 0;">{{__('Update Profile & Settings')}}</h1>

                @if($errors->any())
                <div class="red-section-style error-container" style="margin-bottom: 28px;">
                    <p class="error-message">{{ $errors->first() }}</p>
                </div>
                @endif
                @if(Session::has('message'))
                    <div class="green-message-container" style="margin-bottom: 28px;">
                        <p class="green-message">{{ Session::get('message') }}</p>
                    </div>
                @endif
                <div class="us-user-media-container" style="overflow: unset;">
                    <div class="red-section-style flex align-center error-container none mt8" style="margin-bottom: 28px;">
                        <svg class="size14 mr8" style="min-width: 14px; fill: rgb(68, 5, 5);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size14 mr8"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                        <p class="no-margin fs12 bold dark-red error-text"></p>
                    </div>
                    <div class="full-center relative update-cover-box">
                        <!-- cover options menu -->
                        <div class="absolute flex align-center" style="top: -22px; right: 4px">
                            <div class="relative">
                                <div class="flex align-center button-with-suboptions pointer">
                                    <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M496,384H160V368a16,16,0,0,0-16-16H112a16,16,0,0,0-16,16v16H16A16,16,0,0,0,0,400v32a16,16,0,0,0,16,16H96v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V448H496a16,16,0,0,0,16-16V400A16,16,0,0,0,496,384Zm0-160H416V208a16,16,0,0,0-16-16H368a16,16,0,0,0-16,16v16H16A16,16,0,0,0,0,240v32a16,16,0,0,0,16,16H352v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V288h80a16,16,0,0,0,16-16V240A16,16,0,0,0,496,224Zm0-160H288V48a16,16,0,0,0-16-16H240a16,16,0,0,0-16,16V64H16A16,16,0,0,0,0,80v32a16,16,0,0,0,16,16H224v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V128H496a16,16,0,0,0,16-16V80A16,16,0,0,0,496,64Z"></path></svg>
                                    <span class="fs12 ml4 bold lblack unselectable">{{ __('cover image settings') }}</span>
                                </div>
                                <div class="suboptions-container typical-suboptions-container width-max-content" style='right: 0; top: calc(100% + 6px);'>
                                    <div class="typical-suboption flex align-center hidden-overflow relative">
                                        <svg class="size16 mr4" style="min-width: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M217.14,121.14c-4.55-.89-8.39-1.9-12.29-2.32-2.95-.31-3.65-1.43-3.63-4.33.14-20.13.08-40.27.07-60.4,0-6.76-.51-7.26-7.38-7.26H34.5c-6.95,0-7.47.49-7.47,7.19V174.33c0,6.73.47,7.17,7.48,7.17,33,0,66,.06,99-.08,3.43,0,5.29.62,5.16,4.35a15,15,0,0,0,.44,3.44c.53,2.56,2.44,6.36,1.44,7.38-1.89,1.95-5.52.72-8.41.73q-53,.08-105.94,0c-10.8,0-15-4.18-15-14.88V45.82C11.19,35.13,15.4,31,26.25,31H202c11.11,0,15.14,4.06,15.15,15.23ZM155.66,88.56c-6.79-8.14-14.77-8.12-21.56,0-11.48,13.81-23,27.63-34.3,41.55-1.93,2.37-2.84,2.83-4.92.1-5.29-6.94-10.92-13.63-16.45-20.38-6.54-8-14.5-8.14-21.34-.38S43.75,125,37,132.61a7.87,7.87,0,0,0-2,5.78c.09,10.22.2,20.45,0,30.67-.09,3.56.65,4.65,4.48,4.63q47-.28,94,0c3.63,0,4.94-.88,5.5-4.6,3.1-20.5,14.21-35.38,32.59-44.82,3.17-1.63,6.59-2.76,10.24-4.27C172.84,109.33,164.29,98.91,155.66,88.56ZM248.81,178a51.48,51.48,0,1,0-51.59,51C225.4,229.13,248.7,206.1,248.81,178Zm-63.3,2.7c.13-2.6-.68-3.59-3.27-3.25a20,20,0,0,1-4,0c-4.31-.29-6-3.15-3.6-6.64,6.15-8.93,12.47-17.76,18.88-26.52,2.47-3.38,5.09-3.35,7.59.07q9.48,12.93,18.62,26.1c2.61,3.77,1,6.68-3.53,7a9.28,9.28,0,0,1-2.47,0c-4.14-.81-4.74,1.27-4.64,4.85.24,8.23,0,16.47.13,24.7.1,4.42-1.61,6.38-6.1,6.16-4.11-.19-8.23-.1-12.35,0-3.7.08-5.47-1.54-5.39-5.32.1-4.61,0-9.22,0-13.83C185.45,189.61,185.3,185.16,185.51,180.73ZM115,76.81A16.14,16.14,0,0,0,99,60.74a15.84,15.84,0,0,0,.07,31.67A16,16,0,0,0,115,76.81Z"/></svg>
                                        <span class="fs12 bold lblack unselectable">{{ __('Upload new cover') }}</span>
                                        <input type="file" id="cover" class="absolute full-width pointer cover-upload-button" style="bottom: 0; height: 100px;" autocomplete="off">
                                    </div>
                                    @if($user->cover)
                                    <div class="typical-suboption flex align-center mt2 open-remove-cover-dialog">
                                        <svg class="size16 mr4" style="min-width: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                        <span class="fs12 bold lblack unselectable">{{ __('Remove used cover') }}</span>
                                    </div>
                                    @endif
                                    <div class="typical-suboption flex align-center mt2 restore-original-cover none">
                                        <svg class="size15 mr4" style="min-width: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                        <span class="fs12 bold lblack unselectable">{{ __('Restore original cover') }}</span>
                                    </div>
                                    <div class="typical-suboption flex align-center mt2 discard-uploaded-cover none">
                                        <svg class="size15 mr4" style="min-width: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.94,199.94,0,0,1,256,456ZM357.8,193.8,295.6,256l62.2,62.2a12,12,0,0,1,0,17l-22.6,22.6a12,12,0,0,1-17,0L256,295.6l-62.2,62.2a12,12,0,0,1-17,0l-22.6-22.6a12,12,0,0,1,0-17L216.4,256l-62.2-62.2a12,12,0,0,1,0-17l22.6-22.6a12,12,0,0,1,17,0L256,216.4l62.2-62.2a12,12,0,0,1,17,0l22.6,22.6a12,12,0,0,1,0,17Z"/></svg>
                                        <span class="fs12 bold lblack unselectable">{{ __('Discard uploaded cover') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="us-settings-cover-container flex">
                            <!-- remove cover viewer -->
                            <div class="absolute full-shadowed remove-cover-dialog full-center flex-column br4" style="transition: all 0.2s ease">
                                <p class="no-margin mb4 white bold fs15 text-center">{{__('Remove cover')}}</p>
                                <p class="no-margin mb4 white fs13 text-center">{{__('Are you sure you want to remove this cover')}} ?</p>
                                <div class="flex align-center mt8">
                                    <div class="red-button-style remove-cover-button" style="padding: 5px 11px;">
                                        <span class="flex fs12 bold">{{ __('Remove') }}</span>
                                    </div>
                                    <div class="white pointer fs13 close-shadowed-view-button ml8">{{ __('cancel') }}</div>
                                </div>
                            </div>
                            <!-- notice to tell user to add cover -->
                            <div class="full-center full-dimensions add-cover-notice @if($user->cover) none @endif">
                                <div class="flex align-center">
                                    <svg class="size20 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464,64H48A48,48,0,0,0,0,112V400a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V112A48,48,0,0,0,464,64Zm-6,336H54a6,6,0,0,1-6-6V118a6,6,0,0,1,6-6H458a6,6,0,0,1,6,6V394A6,6,0,0,1,458,400ZM128,152a40,40,0,1,0,40,40A40,40,0,0,0,128,152ZM96,352H416V272l-87.52-87.51a12,12,0,0,0-17,0L192,304l-39.51-39.52a12,12,0,0,0-17,0L96,304Z" style="fill:#fff"/></svg>
                                    <p class="no-margin ml4 fs14 white unselectable">{{__('ADD COVER')}}</p>
                                </div>
                            </div>
                            <img src="@if($user->cover) {{ $user->cover }} @endif" class="cover-image full-width self-center @if(is_null($user->cover)) none @endif" alt="">
                            <input type="hidden" class="original-cover" value="{{ $user->cover }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="flex mb8" style='margin-top: 12px;'>
                        <div class="relative full-center" id="settings-avatar-area">
                            <div class="user-avatar-settings-button-container"> <!-- this is absolute -->
                                <svg class="user-avatar-settings-button button-with-suboptions" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M496,384H160V368a16,16,0,0,0-16-16H112a16,16,0,0,0-16,16v16H16A16,16,0,0,0,0,400v32a16,16,0,0,0,16,16H96v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V448H496a16,16,0,0,0,16-16V400A16,16,0,0,0,496,384Zm0-160H416V208a16,16,0,0,0-16-16H368a16,16,0,0,0-16,16v16H16A16,16,0,0,0,0,240v32a16,16,0,0,0,16,16H352v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V288h80a16,16,0,0,0,16-16V240A16,16,0,0,0,496,224Zm0-160H288V48a16,16,0,0,0-16-16H240a16,16,0,0,0-16,16V64H16A16,16,0,0,0,0,80v32a16,16,0,0,0,16,16H224v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V128H496a16,16,0,0,0,16-16V80A16,16,0,0,0,496,64Z"></path></svg>
                                <div class="suboptions-container typical-suboptions-container width-max-content">
                                    <div class="typical-suboption flex align-center hidden-overflow relative">
                                        <svg class="size16 mr4" style="min-width: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M217.14,121.14c-4.55-.89-8.39-1.9-12.29-2.32-2.95-.31-3.65-1.43-3.63-4.33.14-20.13.08-40.27.07-60.4,0-6.76-.51-7.26-7.38-7.26H34.5c-6.95,0-7.47.49-7.47,7.19V174.33c0,6.73.47,7.17,7.48,7.17,33,0,66,.06,99-.08,3.43,0,5.29.62,5.16,4.35a15,15,0,0,0,.44,3.44c.53,2.56,2.44,6.36,1.44,7.38-1.89,1.95-5.52.72-8.41.73q-53,.08-105.94,0c-10.8,0-15-4.18-15-14.88V45.82C11.19,35.13,15.4,31,26.25,31H202c11.11,0,15.14,4.06,15.15,15.23ZM155.66,88.56c-6.79-8.14-14.77-8.12-21.56,0-11.48,13.81-23,27.63-34.3,41.55-1.93,2.37-2.84,2.83-4.92.1-5.29-6.94-10.92-13.63-16.45-20.38-6.54-8-14.5-8.14-21.34-.38S43.75,125,37,132.61a7.87,7.87,0,0,0-2,5.78c.09,10.22.2,20.45,0,30.67-.09,3.56.65,4.65,4.48,4.63q47-.28,94,0c3.63,0,4.94-.88,5.5-4.6,3.1-20.5,14.21-35.38,32.59-44.82,3.17-1.63,6.59-2.76,10.24-4.27C172.84,109.33,164.29,98.91,155.66,88.56ZM248.81,178a51.48,51.48,0,1,0-51.59,51C225.4,229.13,248.7,206.1,248.81,178Zm-63.3,2.7c.13-2.6-.68-3.59-3.27-3.25a20,20,0,0,1-4,0c-4.31-.29-6-3.15-3.6-6.64,6.15-8.93,12.47-17.76,18.88-26.52,2.47-3.38,5.09-3.35,7.59.07q9.48,12.93,18.62,26.1c2.61,3.77,1,6.68-3.53,7a9.28,9.28,0,0,1-2.47,0c-4.14-.81-4.74,1.27-4.64,4.85.24,8.23,0,16.47.13,24.7.1,4.42-1.61,6.38-6.1,6.16-4.11-.19-8.23-.1-12.35,0-3.7.08-5.47-1.54-5.39-5.32.1-4.61,0-9.22,0-13.83C185.45,189.61,185.3,185.16,185.51,180.73ZM115,76.81A16.14,16.14,0,0,0,99,60.74a15.84,15.84,0,0,0,.07,31.67A16,16,0,0,0,115,76.81Z"/></svg>
                                        <span class="fs12 bold lblack unselectable">{{ __('Upload new avatar') }}</span>
                                        <input type="file" id="avatar" class="absolute full-width pointer avatar-upload-button" style="bottom: 0; height: 100px;" autocomplete="off">
                                    </div>
                                    @if($user->hasavatar)
                                    <div class="typical-suboption flex align-center mt2 open-remove-avatar-dialog">
                                        <svg class="size16 mr4" style="min-width: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                        <span class="fs12 bold lblack unselectable">{{ __('Remove used avatar') }}</span>
                                    </div>
                                    @endif
                                    <div class="typical-suboption flex align-center mt2 restore-original-avatar none">
                                        <svg class="size15 mr4" style="min-width: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                        <span class="fs12 bold lblack unselectable">{{ __('Restore original avatar') }}</span>
                                    </div>
                                    <div class="typical-suboption flex align-center mt2 discard-uploaded-avatar none">
                                        <svg class="size15 mr4" style="min-width: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.94,199.94,0,0,1,256,456ZM357.8,193.8,295.6,256l62.2,62.2a12,12,0,0,1,0,17l-22.6,22.6a12,12,0,0,1-17,0L256,295.6l-62.2,62.2a12,12,0,0,1-17,0l-22.6-22.6a12,12,0,0,1,0-17L216.4,256l-62.2-62.2a12,12,0,0,1,0-17l22.6-22.6a12,12,0,0,1,17,0L256,216.4l62.2-62.2a12,12,0,0,1,17,0l22.6,22.6a12,12,0,0,1,0,17Z"/></svg>
                                        <span class="fs12 bold lblack unselectable">{{ __('Discard uploaded avatar') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="us-settings-avatar-container flex">
                                <img src="{{ $user->sizedavatar(100, '-h') }}" class="avatar-image us-settings-avatar" alt="">
                            </div>
                            <input type="hidden" class="default-avatar" value="{{ $user->sizeddefaultavatar(100, '-h') }}" autocomplete="off">
                            <input type="hidden" class="original-avatar" value="{{ $user->sizedavatar(100, '-h') }}" autocomplete="off">
                        </div>
                        <div class="full-width" style="margin-left: 18px;">
                            <h2 class="no-margin fs19 lblack">{{ $user->fullname }}</h2>
                            <span class="no-margin fs12 lblack block">{{ $user->username }}</span>
                            <!-- firstname & lastname -->
                            <div class="flex">
                                <div class="input-container full-width" style="margin-right: 8px">
                                    <label for="firstname" class="block fs12 bold mb4 gray">{{ __('Firstname') }}</label>
                                    <input type="text" id="firstname" name="firstname" form="profile-edit-form" class="full-width styled-input" value="@if(@old('firstname')){{@old('firstname')}}@else{{$user->firstname}}@endif" required autocomplete="off" placeholder="{{__('Firstname')}}">
                                </div>

                                <div class="input-container full-width">
                                    <label for="lastname" class="block fs12 bold mb4 gray">{{ __('Lastname') }}</label>
                                    <input type="text" id="lastname" name="lastname" form="profile-edit-form" class="full-width styled-input" value="@if(@old('lastname')){{@old('lastname')}}@else{{$user->lastname}}@endif" required autocomplete="off" placeholder="{{__('Lastname')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- username -->
                    <div style="margin-top: 12px">
                        <div class="flex align-center mb4">
                            <label for="username" class="fs12 bold gray mr4">{{ __('Change username') }} </label>
                            <div class="wtypical-button-style check-username ml4 mr8" style="padding: 3px 8px">
                                <div class="relative size11 mr4">
                                    <svg class="flex size11 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
                                    <svg class="spinner size11 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="fs11 bold lblack button-text">{{ __('check availability') }}</span>
                                <input type="hidden" class="button-text-ing" value="{{ __('checking') }}.." autocomplete="off">
                                <input type="hidden" class="button-text-no-ing" value="{{ __('check availability') }}" autocomplete="off">
                            </div>
    
                            <div class="align-center red-box none">
                                <svg class="size10 mx4" fill="#ff5959" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 95.94 95.94"><path d="M62.82,48,95.35,15.44a2,2,0,0,0,0-2.83l-12-12A2,2,0,0,0,81.92,0,2,2,0,0,0,80.5.59L48,33.12,15.44.59a2.06,2.06,0,0,0-2.83,0l-12,12a2,2,0,0,0,0,2.83L33.12,48,.59,80.5a2,2,0,0,0,0,2.83l12,12a2,2,0,0,0,2.82,0L48,62.82,80.51,95.35a2,2,0,0,0,2.82,0l12-12a2,2,0,0,0,0-2.83Z"/></svg>
                                <span class="error fs12"></span>
                            </div>
                            <div class="align-center green-box none">
                                <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                                <span class="green fs12"></span>
                            </div>
                        </div>
                        <div class="flex align-center">
                            <input type="text" id="username" name="username" form="profile-edit-form" class="styled-input" value="@if(@old('username')){{@old('username')}}@else{{$user->username}}@endif" required autocomplete="off" placeholder="{{__('Username')}}">
                        </div>
                    </div>
                    <!-- about -->
                    <div style="margin-top: 12px">
                        <label for="about" class="flex fs12 bold mb4 gray mr4">{{ __('About me') }} </label>
                        <div class="countable-textarea-container">
                            <textarea name="about" id="about" class="block styled-textarea move-to-middle countable-textarea" style="width: 100%;" maxlength="1400" spellcheck="false" autocomplete="off" form="profile-edit-form" placeholder="{{ __('Something about you') }}">{{ $user->about }}</textarea>
                            <p class="block my4 mr4 unselectable fs12 gray textarea-counter-box move-to-right width-max-content"><span class="textarea-chars-counter"></span>/1400</p>
                            <input type="hidden" class="max-textarea-characters" value="1400">
                        </div>
                    </div>
                    <!-- save user informations button -->
                    <div id="save-user-profile-informations" class="typical-button-style flex align-center width-max-content mt8">
                        <div class="relative size14 mr4">
                            <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"/><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"/></svg>
                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="bold fs12" style="margin-top: 1px">{{ __('Save Profile Informations') }}</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="right-panel" style="padding-top: 8px">
        @include('partials.settings.profile-right-side-menu', ['item'=>'settings-general'])
        <div class="ms-right-panel my8">
            <div>
                <div class="flex align-center">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                    <div class="bold bblack">{{ __('Settings rules') }}</div>
                </div>
                <div class="ml8 block">
                    <p class="bold forum-color fs13" style="margin-bottom: 12px;">Cover</p>
                    <p class="fs12 my4">• {{__('Supported types')}}: PNG, BMP, GIF or JPG. {{__('At most')}} 5MB.</p>
                    <p class="fs12 my4">• {{ __('Maximum dimensions') }} :</p>
                    <div class="ml8">
                        <p class="fs12 my4">* {{__('Height')}}: 1280px {{__('max')}}</p>
                        <p class="fs12 my4">* {{__('Width')}}: 2050px {{__('max')}}</p>
                    </div>
                </div>
                <div class="ml8 block">
                    <p class="bold forum-color fs13" style="margin-bottom: 12px;">Avatar</p>
                    <p class="fs12 my4">• {{__('Supported types')}}: PNG, BMP, GIF or JPG. {{__('At most')}} 5MB.</p>
                    <p class="fs12 my4">• {{ __('Maximum dimensions') }} :</p>
                    <div class="ml8">
                        <p class="fs12 my4">* {{__('Height')}}: 1000px max</p>
                        <p class="fs12 my4">* {{__('Width')}}: 1000px max</p>
                    </div>
                </div>
                <div class="ml8 block">
                    <p class="bold forum-color fs13" style="margin-bottom: 12px;">{{__('Username')}}</p>
                    <p class="fs12 my4">• {{ __('Should be unique(check it before saving your changes)') }}.</p>
                    <p class="fs12 my4">• {{ __('Should contain at least 6 characters') }}.</p>
                    <p class="fs12 my4">• {{ __('Only contains characters, numbers, dashes or underscores') }}.</p>
                </div>
            </div>
        </div>
    </div>
@endsection