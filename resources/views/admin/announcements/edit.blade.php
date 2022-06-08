@extends('layouts.admin')

@section('title', 'Admin - Announcement edit')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.announcements', 'subpage'=>'threads.announcement.manage'])
@endsection

@push('styles')
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/simplemde.js') }}"></script>
<script src="{{ asset('js/thread/create.js') }}" defer></script>
<script src="{{ asset('js/thread/edit.js') }}" defer></script>
<script src="{{ asset('js/admin/announcement/edit.js') }}" defer></script>
@endpush

@section('content')
<div class="flex align-center space-between top-page-title-box">
    <input type="hidden" id="thread-id" value="{{ $announcement->id }}" autocomplete="off">
    <div class="flex align-center">
        <svg class="mr8 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"></path></svg>
        <h1 class="fs22 no-margin lblack">{{ __('Announcement management') }}</h1>
    </div>
    <div class="flex align-center height-max-content">
        <div class="flex align-center">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"/></svg>
            <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Dashboard') }}</a>
        </div>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('announcements') }}" class="link-path">{{ __('Announcements') }}</a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <div class="flex align-center">
            <span class="fs13 bold">{{ __('Edit announcements') }}</span>
        </div>
    </div>
</div>
<div class="full-width middle-padding-1" style="padding-top: 0; margin-bottom: 20px">
    <div class="flex align-center" style="margin: 12px 0">
        <h1 class="fs26 no-margin forum-color">{{ __('Edit Announcement') }}</h1>
        <a href="{{ route('announcement.show', ['forum'=>$forum->slug, 'announcement'=>$announcement->id]) }}" class="link-path flex align-center move-to-right unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M31.7,239l136-136a23.9,23.9,0,0,1,33.8-.1l.1.1,22.6,22.6a23.91,23.91,0,0,1,.1,33.8l-.1.1L127.9,256l96.4,96.4a23.91,23.91,0,0,1,.1,33.8l-.1.1L201.7,409a23.9,23.9,0,0,1-33.8.1l-.1-.1L31.8,273a23.93,23.93,0,0,1-.26-33.84l.16-.16Z"/></svg>
            {{ __('Return to announcement') }}
        </a>
    </div>

    @php $canupdate = false; @endphp
    @can('update_announcement', [\App\Models\Thread::class, $announcement])
        @php $canupdate = true; @endphp
    @endcan

    @if($announcement->type == 'poll')
    <div class="section-style flex align-center">
        <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
        <p class="no-margin fs13">This is a poll announcement. Content is hidden and options could not be modified. You can add and delete options by clicking on <strong>return to announcement</strong> button</p>
    </div>
    @endif 
    <div class="my8 thread-edit-error-container none">
        <div class="flex">
            <svg class="size14 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
            <span class="error fs13 bold no-margin thread-edit-error"></span>
        </div>
    </div>
    <div>
        <!-- validation errors messages -->
        <input type="hidden" class="subject-required-error" value="{{ __('Title field is required') }}">
        <input type="hidden" class="content-required-error" value="{{ __('Content field is required') }}">
    </div>
    <div class="input-container">
        <label for="subject" class="label-style-1" style="margin: 0">{{ __('Title') }} <span class="error ml4 none">*</span></label>
        <div class="flex space-between align-end">
            <p class="mini-label my4">{{ __('Be specific and imagine you’re talking to another person') }}</p>
        </div>
        <input type="text" id="subject" name="subject" class="full-width styled-input html-entities-decode" value="{{ $announcement->subject }}" required autocomplete="off" placeholder="{{ __('Update your title here') }}">
        @error('subject')
            <p class="error" role="alert">{{ $message }}</p>
        @enderror
    </div>
    <div class="input-container content-container @if($announcement->type == 'poll') none @endif" style='margin-top: 10px'>
        <label for="content" class="label-style-1">{{ __('Content') }} <span class="error ml4 none">*</span></label>
        <p class="mini-label" style='margin-bottom: 6px'>{{ __('Include all the information someone would need to understand the announcement') }}</p>
        <textarea name="content" id="content" placeholder="{{ __('Update your announcement content') }}">{!! $announcement->content !!}</textarea>
        <style>
            .CodeMirror,
            .CodeMirror-scroll {
                max-height: 220px;
                min-height: 220px;
                border-radius: 0;
                border-color: #b9b9b9;
            }
            .CodeMirror-scroll:focus {
                border-color: #64ceff;
                box-shadow: 0 0 0px 3px #def2ff;
            }
            .editor-toolbar {
                padding: 0 4px;
                opacity: 0.8;
                height: 38px;
                border-radius: 0;
                border-top-color: #b9b9b9;
                background-color: rgb(244, 244, 244);

                display: flex;
                align-items: center;
            }
            .editor-toolbar .fa-arrows-alt, .editor-toolbar .fa-columns,
            .share-post-form .separator:nth-of-type(2), .editor-statusbar {
                display: none !important;
            }
        </style>
    </div>
    <div>
        <div class="flex">
            <input type="checkbox" id="thread-resplies-disable" class="no-margin height-max-content mt2 mr4" style="margin-top: 1px;" @if($announcement->replies_off) checked @endif>
            <div>
                <label for="thread-resplies-disable" class="flex bold lblack mb2">{{ __('Disable replies') }} <span class="error ml4 none">*</span></label>
                <p class="no-margin fs12 lblack">Disable replies for this announcement</p>
            </div>
        </div>
    </div>
    <div class="input-container @if($announcement->type == 'poll') none @endif" style="margin-top: 20px">
        <label for="category" class="label-style-1">{{ __('Medias') }}</label>
        <div class="thread-add-media-section">
            <div class="thread-add-media-error px8 my8">
                <p class="error tame-image-type none">* {{ __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported') }}.</p>
                <p class="error tame-image-limit none">* {{ __('You could only upload 20 images max per post') }}.</p>
                <p class="error tame-video-type none">* {{ __('Only .MP4, .WEBM, .MPG, .MP2, .MPEG, .MPE, .MPV, .OGG, .M4P, .M4V, .AVI video formats are supported') }}.</p>
                <p class="error tame-video-limit none">* {{ __('You could only upload 4 videos max per post') }}.</p>
            </div>
            <div class="flex align-center">
                <div class="flex align-center thread-add-button-hover-style mr8 relative">
                    <svg class="size24" style="margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M395.3,76H116.72C94.26,76,76,95.47,76,119.46V392.59c0,24,18.26,43.41,40.72,43.41H395.3c22.46,0,40.7-19.45,40.7-43.41V119.46C436,95.47,417.76,76,395.3,76Zm-86.5,64.63c21.71,0,39.32,18.79,39.32,42s-17.61,42-39.32,42-39.33-18.79-39.33-42S287.07,140.63,308.8,140.63Zm73.73,255.22H135.1c-10.86,0-15.7-8.38-10.81-18.73l67.5-142.61c4.89-10.34,14.21-11.26,20.81-2.06l67.87,94.61c6.6,9.21,18.13,10,25.77,1.75l16.6-17.94c7.63-8.24,18.87-7.22,25.1,2.27l43,65.51C397.14,388.15,393.4,395.85,382.53,395.85Z" style="fill:#010002"/></svg>
                    <p class="no-margin fs13">{{__('Include photos')}}</p>
                    <input type="file" name="images[]" id="thread-photos" class="thread-add-file-input" multiple accept=".jpg,.jpeg,.png,.bmp,.gif">
                </div>
                <div class="flex align-center thread-add-button-hover-style relative">
                    <svg class="size20" style="margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,56C145.52,56,56,145.52,56,256s89.52,200,200,200,200-89.52,200-200S366.48,56,256,56Zm93.31,219.35L207.37,356.81a19.39,19.39,0,0,1-28.79-16.94V172.13a19.41,19.41,0,0,1,28.79-16.94l141.94,86.29C362.53,248.9,362.53,268,349.31,275.35Z"/></svg>
                    <p class="no-margin fs13">{{__('Include Video')}}</p>
                    <input type="file" name="videos[]" id="thread-videos" style="height: 60px; bottom: 0;" class="thread-add-file-input" multiple accept=".mp4,.webm,.mpg,.mp2,.mpeg,.mpe,.mpv,.ogg,.mp4,.m4p,.m4v,.avi">
                </div>
            </div>
        </div>
        <!-- the following div will be used to clone uploaded images -->
        <div class="thread-add-uploaded-media relative none thread-add-uploaded-media-projection-model">
            <img src="" class="thread-add-uploaded-image move-to-middle none" alt="">
            <div class="close-thread-media-upload x-close-container-style remove">
                <span class="x-close unselectable">✖</span>
            </div>
            <div class="thread-add-video-indicator full-center none">
                <svg class="size36" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 271.95 271.95"><path d="M136,272A136,136,0,1,0,0,136,136,136,0,0,0,136,272ZM250.2,136A114.22,114.22,0,1,1,136,21.76,114.35,114.35,0,0,1,250.2,136ZM112.29,205a21.28,21.28,0,0,0,8.24,1.66,21.65,21.65,0,0,0,15.34-6.37l48.93-49a21.75,21.75,0,0,0,0-30.77L135.84,71.64a21.78,21.78,0,0,0-15.4-6.37,20.81,20.81,0,0,0-8.15,1.66A21.58,21.58,0,0,0,99,87v97.91A21.6,21.6,0,0,0,112.29,205Zm8.5-116.42V87l49,48.95-48.95,49Z"/></svg>
            </div>
            <input type="hidden" class="uploaded-media-index" value="-1">
            <input type="hidden" class="uploaded-media-genre" value="">
        </div>
        <div id="thread-uploads-wrapper" class="thread-add-uploaded-medias-container flex my4 x-auto-overflow">
            <input type="hidden" class="uploaded-images-counter" value="0" autocomplete="off">
            <input type="hidden" class="uploaded-videos-counter" value="0" autocomplete="off">
            @php $count = 0; @endphp
            @if($announcement->has_media)
                @foreach($medias as $media)
                    <div class="thread-add-uploaded-media relative">
                        <img src="@if($media['type'] == 'image'){{ asset($media['frame']) }}@endif" class="thread-add-uploaded-image move-to-middle" id="media{{ $count }}" alt="">
                        <div class="close-thread-media-upload-edit x-close-container-style remove">
                            <span class="x-close unselectable">✖</span>
                        </div>
                        @if($media['type'] == 'video')
                        <div class="thread-add-video-indicator full-center">
                            <svg class="size36" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 271.95 271.95"><path d="M136,272A136,136,0,1,0,0,136,136,136,0,0,0,136,272ZM250.2,136A114.22,114.22,0,1,1,136,21.76,114.35,114.35,0,0,1,250.2,136ZM112.29,205a21.28,21.28,0,0,0,8.24,1.66,21.65,21.65,0,0,0,15.34-6.37l48.93-49a21.75,21.75,0,0,0,0-30.77L135.84,71.64a21.78,21.78,0,0,0-15.4-6.37,20.81,20.81,0,0,0-8.15,1.66A21.58,21.58,0,0,0,99,87v97.91A21.6,21.6,0,0,0,112.29,205Zm8.5-116.42V87l49,48.95-48.95,49Z"/></svg>
                        </div>
                        @endif
                        <input type="hidden" class="uploaded-media-index" value="-1">
                        <input type="hidden" class="uploaded-media-genre" value="{{ $media['type'] }}">
                        <input type="hidden" class="uploaded-media-url" value="{{ asset($media['frame']) }}">
                    </div>
                    @php $count++; @endphp
                @endforeach
            @endif
        </div>
    </div>
    <div style="margin-top: 16px">
        @if(!$canupdate)
        <div class="section-style flex align-center my8">
            <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
            <p class="fs12 bold lblack no-margin">You cannot update this announcement either because you don't have permission or because you don't own it</p>
        </div>
        @endif
        <div class="flex align-center">
            @if($canupdate)
            <div id="update-announcement-button" class="typical-button-style flex align-center">
                <div class="relative size14 mr4">
                    <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"/><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"/></svg>
                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <span class="bold fs12">Update announcement</span>
            </div>
            @else
            <div class="disabled-typical-button-style typical-button-style flex align-center">
                <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"/><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"/></svg>
                <span class="bold fs12">Update announcement</span>
            </div>
            @endif
            <a href="{{ route('announcement.show', ['forum'=>$forum->slug, 'announcement'=>$announcement->id]) }}" class="bold no-underline forum-color pointer ml8">return to announcement</a>
        </div>
    </div>
</div>
@endsection
