@extends('layouts.admin')

@section('title', 'Add a forum')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.forums-and-categories', 'subpage'=>'forums-and-categories-forum-add'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/forums-and-categories/fac.js') }}" defer></script>
<script src="{{ asset('js/admin/forums-and-categories/forum.js') }}" defer></script>
@endpush

@section('content')
    <div class="flex space-between align-center top-page-title-box">
        <div class="flex align-center">
            <svg class="mr8 size24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M109,246.71c-21.62,0-43.24,0-64.86,0-18.65,0-29.81-11.19-29.82-29.86q0-65.11,0-130.22c0-18.81,11.34-30,30.28-30,11.77,0,11.77,0,11.79-11.56,0-19.26,11.18-30.5,30.32-30.51q64.86,0,129.72,0c19,0,30.07,11.06,30.08,30.07q0,64.88,0,129.73c0,19.13-11.28,30.28-30.52,30.32-11.54,0-11.54,0-11.55,11.31,0,19.57-11.13,30.75-30.58,30.77Q141.4,246.74,109,246.71Zm-73.65-94.8q0,32.43,0,64.84c0,6.79,2.07,8.91,8.75,8.91q65.09,0,130.17,0c6.88,0,8.85-1.92,8.85-8.76q0-65.09,0-130.17c0-7.09-1.72-8.84-8.7-8.84q-65.09,0-130.17,0c-7.13,0-8.9,1.86-8.9,9.18Q35.32,119.5,35.32,151.91Zm190.13-42.09V45.48c0-8.14-1.76-9.94-9.71-9.94H87.55c-.82,0-1.65,0-2.47,0-5,.17-7.23,2.27-7.4,7.21-.1,3.13.27,6.3-.1,9.39-.46,3.9,1.12,4.53,4.66,4.51,29.86-.14,59.72-.08,89.58-.08,21.86,0,32.59,10.65,32.59,32.35v82.65c0,11.86,0,11.86,12.09,11.75,7.14-.06,8.94-1.88,8.94-9.17Q225.47,142,225.45,109.82Zm-105.73.5c-.15-6.83-4.32-11.33-10.38-11.38s-10.57,4.7-10.63,11.7c-.07,8.57-.28,17.15.09,25.71.19,4.31-1.26,5.14-5.23,5-8.39-.31-16.81-.15-25.22-.07-7.13.06-11.88,4.27-11.93,10.37-.06,6.33,4.81,10.61,12.23,10.65,8.24,0,16.49.23,24.72-.08,4.08-.16,5.72.54,5.46,5.18-.48,8.22-.16,16.48-.13,24.72,0,7.51,4.13,12.38,10.42,12.48s10.55-4.8,10.61-12.23c.07-8.57.17-17.14-.07-25.71-.09-3.36.66-4.56,4.27-4.44,8.72.28,17.47.13,26.2.07,7.07,0,11.85-4.28,11.93-10.42s-4.56-10.51-11.69-10.59c-8.74-.09-17.48-.16-26.21,0-3.33.08-4.75-.67-4.49-4.3.32-4.43.07-8.9.07-13.35S119.82,114.77,119.72,110.32Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Add a Forum') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Add a forum') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box">
        <!-- messages (errors) -->
        <div>
            <input type="hidden" id="icon-required-error-message" value="icon field is required" autocomplete="off">
            <input type="hidden" id="name-required-error-message" value="name field is required" autocomplete="off">
            <input type="hidden" id="slug-required-error-message" value="slug field is required" autocomplete="off">
            <input type="hidden" id="description-required-error-message" value="description field is required" autocomplete="off">
        </div>

        <div>
            <style>
                .notice-box {
                    padding: 10px;
                    border-radius: 2px;
                    background-color: #7c868f0f;
                    border: 1px solid #7c868f2b;
                    margin-bottom: 10px;
                }
            </style>
            <div class="notice-box">
                <div class="flex align-center">
                    <span class="fs14 bold lblack">Notice</span>
                </div>
                <p class="fs13 no-margin mt4 lblack">When a new forum is added, it will not be available directly. Instead, It'll be set under review for super admins to review it and then approve the addition.</p>
                <p class="fs13 no-margin mt4 lblack">The forums under review will be shown in dashboard for super admins to review.</p>
            </div>
            <div class="my8 none" id="forum-add-error-container">
                <div class="flex">
                    <svg class="size14 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                    <span class="error fs13 bold no-margin" id="forum-add-error"></span>
                </div>
            </div>
            <div>
                <div class="mb8">
                    <label for="forum-name" class="flex align-center bold forum-color mb4">{{ __('Name') }}<span class="ml4 err red none fs12">*</span></label>
                    <input type="text" id="forum-name" class="styled-input" maxlength="255" autocomplete="off" placeholder='{{ __("Forum name here") }}'>
                </div>
                <div class="mb8">
                    <label for="forum-slug" class="flex align-center bold forum-color mb4">{{ __('Slug') }}<span class="ml4 err red none fs12">*</span></label>
                    <input type="text" id="forum-slug" class="styled-input" maxlength="255" autocomplete="off" placeholder='{{ __("Forum slug here") }}'>
                </div>
                <div class="mb8">
                    <label for="forum-description" class="flex align-center bold forum-color mb4">{{ __('Description') }}<span class="ml4 err red none fs12">*</span></label>
                    <textarea id="forum-description" class="styled-textarea fs14"
                        style="margin: 0; padding: 8px; width: 100%; min-height: 110px; max-height: 110px;"
                        maxlength="800"
                        spellcheck="false"
                        autocomplete="off"
                        placeholder="{{ __('Forum description here') }}"></textarea>
                </div>
                <div class="mb8">
                    <label for="forum-icon" class="flex align-center bold forum-color mb2">
                        {{ __('Icon') }}
                        @if($issuperadmin)
                        <span class="fs12 ml4" style="font-weight: 400">(optional)</span>
                        @else
                        <span class="fs12 ml4" style="font-weight: 400">(you don't have permission to include icon. Super admins and site owners will take this step after review)</span>
                        @endif
                    </label>
                    <div class="flex align-center space-between">
                        <p class="fs12 gray my4">The icon store the content of svg tag. (Be careful, the viewport of svg should be : 0 . 0 . 512 . 512)</p>
                        <div class="relative">
                            <div class="flex align-center pointer py4 render-forum-icon button-with-suboptions">
                                <div class="size14 mr4 relative">
                                    <svg class="mr4 size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px; margin-top: 1px"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"></path></svg>
                                    <div class="spinner size14 opacity0 absolute" fill="#2ca0ff" style="top: 0; left: 0">
                                        <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                                    </div>
                                </div>
                                <span class="mr4 fs13 bold">render</span>
                            </div>
                            <style>
                                .forum-icon-viewer {
                                    height: 85px;
                                    width: 105px;
                                    bottom: -40px;
                                    right: calc(100% + 8px);
                                    background-color: #ececec;
                                    border: 1px solid #ccc;
                                    border-radius: 4px; 
                                }
                            </style>
                            <div class="absolute forum-icon-viewer suboptions-container">
                                <div class="full-dimensions full-center">
                                    <svg class="size60 mr4" id="forum-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <textarea id="forum-icon" class="styled-textarea fs14"
                        style="margin: 0; padding: 8px; width: 100%; min-height: 110px; max-height: 110px; line-height: 1.5;"
                        spellcheck="false"
                        autocomplete="off"
                        @if(!$issuperadmin)
                        disabled="disabled"
                        @endif
                        placeholder="{{ __('The content of logo svg\'s tag content') }}"></textarea>
                </div>
            </div>
            @if($can_add_forum)
            <div class="notice-box">
                <span class="fs14 bold lblack">Note</span>
                <p class="no-margin fs13 mt4 lblack">Please review the forum credentials carefuly before add, because once the forum is created, you can't change anything unless one of super admins review it.</p>
            </div>
            @else
            <div class="section-style flex align-center my8">
                <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                <p class="fs12 bold lblack no-margin">You cannot propose forums for the moment because you do not have the permission</p>
            </div>
            @endif
            <div class="flex align-center" style="margin: 20px 0">
                @if($can_add_forum)
                <div class="forum-add-button flex align-center typical-button-style mr8">
                    <div class="size14 relative mr8">
                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M13.69,108.9q0-41,0-81.91c0-9.64,3.42-13.07,13-13.07q81.66,0,163.31,0c9.46,0,13.11,3.66,13.11,13.15q0,81.42,0,162.82c0,9.58-3.89,13.49-13.44,13.49q-81.41,0-162.82,0c-9.54,0-13.18-3.62-13.19-13.08Q13.66,149.6,13.69,108.9Zm168.24-.5c0-23-.09-46,.1-69.05,0-3.7-.87-4.57-4.55-4.55q-69.3.21-138.6,0c-3.43,0-4.31.78-4.3,4.27q.2,69.3,0,138.59c0,3.62.74,4.61,4.51,4.6q69.3-.24,138.59,0c3.43,0,4.37-.81,4.34-4.3C181.85,154.76,181.93,131.58,181.93,108.4Zm63.17,23.19q0-31.56,0-63.14c0-8.8-3.81-12.49-12.67-12.6-1.15,0-2.31-.07-3.46,0-5,.34-11.72-2.2-14.58,1.08-2.49,2.85-.45,9.41-.94,14.27-.48,4.7.93,6.83,5.81,5.86,4.21-.84,5,1,5,5q-.22,68.8,0,137.62c0,3.94-1.08,4.75-4.84,4.74q-68.31-.19-136.63.05c-5,0-6.82-1.21-5.92-6.09.65-3.54-.56-5.08-4.45-4.74a69.44,69.44,0,0,1-12.32,0c-3.93-.35-4.74,1.23-4.51,4.76.29,4.59,0,9.21.07,13.81.06,9.43,3.7,13.09,13.18,13.09q81.63,0,163.27,0c9.59,0,13-3.45,13-13.1q0-41,0-81.88ZM118.73,123.4c-.2-3.38.74-4.56,4.31-4.47,9.2.26,18.42-.05,27.62.16,3.3.08,4.72-.57,4.43-4.21a91.42,91.42,0,0,1,0-12.82c.19-3.14-.65-4.2-4-4.11-9.37.24-18.75-.09-28.12.17-3.58.1-4.35-1.05-4.27-4.41.24-9-.06-18.1.16-27.13.09-3.47-.5-5.15-4.48-4.79a84.27,84.27,0,0,1-12.81,0c-3.08-.19-3.91.8-3.84,3.84.19,9.53,0,19.07.14,28.61.06,2.93-.53,3.94-3.71,3.86-9.37-.24-18.75,0-28.12-.16-3.26-.07-4.77.52-4.47,4.2a89.92,89.92,0,0,1,0,12.82c-.22,3.29.89,4.19,4.14,4.11,9.37-.21,18.75.08,28.11-.15,3.32-.08,4.12.94,4,4.13-.21,9.53,0,19.08-.14,28.61,0,2.68.54,3.77,3.47,3.62,4.75-.25,9.54-.2,14.3,0,2.57.11,3.43-.66,3.33-3.29-.19-4.92-.06-9.86,0-14.79C118.8,132.6,119,128,118.73,123.4Z"/></svg>
                        <div class="spinner size14 opacity0 absolute" style="top: 0; left: 0">
                            <svg class="size14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                    </div>
                    <span class="fs12 bold white unselectable">Add forum</span>
                </div>
                @else
                <div class="flex align-center typical-button-style disabled-typical-button-style mr8">
                    <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M13.69,108.9q0-41,0-81.91c0-9.64,3.42-13.07,13-13.07q81.66,0,163.31,0c9.46,0,13.11,3.66,13.11,13.15q0,81.42,0,162.82c0,9.58-3.89,13.49-13.44,13.49q-81.41,0-162.82,0c-9.54,0-13.18-3.62-13.19-13.08Q13.66,149.6,13.69,108.9Zm168.24-.5c0-23-.09-46,.1-69.05,0-3.7-.87-4.57-4.55-4.55q-69.3.21-138.6,0c-3.43,0-4.31.78-4.3,4.27q.2,69.3,0,138.59c0,3.62.74,4.61,4.51,4.6q69.3-.24,138.59,0c3.43,0,4.37-.81,4.34-4.3C181.85,154.76,181.93,131.58,181.93,108.4Zm63.17,23.19q0-31.56,0-63.14c0-8.8-3.81-12.49-12.67-12.6-1.15,0-2.31-.07-3.46,0-5,.34-11.72-2.2-14.58,1.08-2.49,2.85-.45,9.41-.94,14.27-.48,4.7.93,6.83,5.81,5.86,4.21-.84,5,1,5,5q-.22,68.8,0,137.62c0,3.94-1.08,4.75-4.84,4.74q-68.31-.19-136.63.05c-5,0-6.82-1.21-5.92-6.09.65-3.54-.56-5.08-4.45-4.74a69.44,69.44,0,0,1-12.32,0c-3.93-.35-4.74,1.23-4.51,4.76.29,4.59,0,9.21.07,13.81.06,9.43,3.7,13.09,13.18,13.09q81.63,0,163.27,0c9.59,0,13-3.45,13-13.1q0-41,0-81.88ZM118.73,123.4c-.2-3.38.74-4.56,4.31-4.47,9.2.26,18.42-.05,27.62.16,3.3.08,4.72-.57,4.43-4.21a91.42,91.42,0,0,1,0-12.82c.19-3.14-.65-4.2-4-4.11-9.37.24-18.75-.09-28.12.17-3.58.1-4.35-1.05-4.27-4.41.24-9-.06-18.1.16-27.13.09-3.47-.5-5.15-4.48-4.79a84.27,84.27,0,0,1-12.81,0c-3.08-.19-3.91.8-3.84,3.84.19,9.53,0,19.07.14,28.61.06,2.93-.53,3.94-3.71,3.86-9.37-.24-18.75,0-28.12-.16-3.26-.07-4.77.52-4.47,4.2a89.92,89.92,0,0,1,0,12.82c-.22,3.29.89,4.19,4.14,4.11,9.37-.21,18.75.08,28.11-.15,3.32-.08,4.12.94,4,4.13-.21,9.53,0,19.08-.14,28.61,0,2.68.54,3.77,3.47,3.62,4.75-.25,9.54-.2,14.3,0,2.57.11,3.43-.66,3.33-3.29-.19-4.92-.06-9.86,0-14.79C118.8,132.6,119,128,118.73,123.4Z"/></svg>
                    <span class="fs12 bold white unselectable">Add forum</span>
                </div>
                @endif
                <a href="{{ route('admin.forum.and.categories.dashboard') }}" class="fs12 no-underline lblack bold">{{ __('Return to dashboard') }}</a>
            </div>
        </div>
    </div>
@endsection