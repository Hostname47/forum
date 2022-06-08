@extends('layouts.admin')

@section('title', 'Admin - Announcement create')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.announcements', 'subpage'=>'threads.announcement.create'])
@endsection

@push('styles')
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/admin/announcement/create.js') }}" defer></script>
<script src="{{ asset('js/simplemde.js') }}"></script>
<script src="{{ asset('js/thread/create.js') }}" defer></script>
@endpush

@section('content')
    <style>
        .dashboard-statistics-record-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 14px;
        }
    </style>
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="mr8 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M497,241H452a15,15,0,0,0,0,30h45a15,15,0,0,0,0-30Zm-19.39,94.39-30-30a15,15,0,0,0-21.22,21.22l30,30a15,15,0,0,0,21.22-21.22Zm0-180a15,15,0,0,0-21.22,0l-30,30a15,15,0,0,0,21.22,21.22l30-30A15,15,0,0,0,477.61,155.39ZM347,61a45.08,45.08,0,0,0-44.5,38.28L288.82,113C265,136.78,229.93,151,195,151H105a45.06,45.06,0,0,0-42.42,30H60a60,60,0,0,0,0,120h2.58A45.25,45.25,0,0,0,90,328.42V406a45,45,0,0,0,90,0V331h15c34.93,0,70,14.22,93.82,38l13.68,13.69A45,45,0,0,0,392,376V106A45.05,45.05,0,0,0,347,61ZM60,271a30,30,0,0,1,0-60Zm90,135a15,15,0,0,1-30,0V331h30Zm30-105H105a15,15,0,0,1-15-15V196a15,15,0,0,1,15-15h75Zm122,39.35c-25.34-21.94-57.92-35.56-92.1-38.67V180.32c34.18-3.11,66.76-16.73,92.1-38.67ZM362,376a15,15,0,0,1-15,15h0a15,15,0,0,1-15-15V106a15,15,0,0,1,30,0Z"></path></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Create Announcement') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Dashboard') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Create announcement') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box" class="border-box">
        <input type="hidden" id="forum-id" autocomplete="off" value="{{ $forums->first()->id }}">

        <div id="thread-add-container-size" style="max-width: 62%; margin: 16px auto">
            <div class="thread-add-container" id="thread-add-wrapper">
                <input type="hidden" class="forum" autocomplete="off" value="{{ $forums->first()->id }}">
                <input type="hidden" class="thread-type-value" autocomplete="off" value="discussion">
                <div class="thread-add-header flex align-center">
                    <div class="size28 rounded hidden-overflow mr4 relative">
                        <img src="{{ auth()->user()->sizedavatar(36, '-l') }}" class="size28" alt="">
                    </div>
                    <!-- forums -->
                    <div class="relative">
                        <div>
                            <div class="flex align-center forum-color button-with-suboptions pointer thread-add-posted-to fs12">
                                <span class="mr4">{{ __('Forum') }}:</span>
                                <svg class="size14 announcement-forum-selected-icon mr4" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <polygon points="207.22 174.76 309.32 0 457.57 0 355.48 174.76 207.22 174.76" style="fill:#f1543f"/><polygon points="58.46 0 160.55 174.76 308.81 174.76 206.72 0 58.46 0" style="fill:#ff7058"/><circle cx="258.02" cy="323.63" r="188.37" style="fill:#f8b64c"/><circle cx="258.02" cy="323.63" r="148.86" style="fill:#ffd15c"/><circle cx="258.02" cy="323.63" r="112.68" style="fill:#f8b64c"/><polygon points="258.02 244.31 283.82 296.52 341.37 304.88 299.74 345.5 309.52 402.95 258.02 375.84 206.51 402.95 216.29 345.5 174.66 304.88 232.21 296.52 258.02 244.31" style="fill:#ffd15c"/>
                                </svg>
                                <span class="announcement-forum-selected-forum">{{ __($forums->first()->forum) }}</span>
                                <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                            </div>
                            <div class="suboptions-container thread-add-suboptions-container" style="max-height: 236px; overflow-y: scroll">
                                @foreach($forums as $forum)
                                    <div class="thread-add-suboption announcement-forum-select flex align-center">
                                        <svg class="size14 forum-ico mr4" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            {!! $forum->icon !!}
                                        </svg>
                                        <span class="thread-add-forum-title">{{ __($forum->forum) }}</span>
                                        <input type="hidden" class="forum-id" value="{{ $forum->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- settings: visibility and thread type (disc or poll) -->
                    <div class="relative move-to-right flex">
                        <div class="flex align-center pointer button-with-suboptions">
                            <svg class="size16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"></path></svg>
                            <span class="fs12 bold ml4">settings</span>
                        </div>
                        <div class="suboptions-container suboptions-container-right-style">
                            <div class="relative flex align-center">
                                <div class="flex align-center" style="width: 74px">
                                    <svg class="mr4 size12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                                    <p class="no-margin fs12 gray bold">{{__('Visibility')}}:</p>
                                </div>
                                <div class="audience-button flex align-center pointer">
                                    <svg class="size14 thread-add-visibility-icon" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z"/></svg>
                                    <span class="bold lblack fs12 ml4">{{__('public')}}</span>
                                </div>
                            </div>
                            <div class="simple-line-separator my4"></div>
                            <!-- THREAD TYPE -->
                            <div class="relative flex align-center">
                                <div class="flex align-center" style="width: 74px">
                                    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M255,395H80A80.09,80.09,0,0,1,0,315V197a80.09,80.09,0,0,1,80-80H255a20,20,0,1,1,0,40H80a40,40,0,0,0-40,40V315a40,40,0,0,0,40,40H255a20,20,0,1,1,0,40ZM432,117H414a20,20,0,0,0,0,40h18a40,40,0,0,1,40,40V315a40,40,0,0,1-40,40H414a20,20,0,0,0,0,40h18a80.09,80.09,0,0,0,80-80V197A80.09,80.09,0,0,0,432,117ZM414,472a60.07,60.07,0,0,1-60-60V100a60.07,60.07,0,0,1,60-60,20,20,0,0,0,0-40,99.91,99.91,0,0,0-80,40.07A99.91,99.91,0,0,0,254,0a20,20,0,0,0,0,40,60.07,60.07,0,0,1,60,60V412a60.07,60.07,0,0,1-60,60,20,20,0,0,0,0,40,99.91,99.91,0,0,0,80-40.07A99.91,99.91,0,0,0,414,512a20,20,0,0,0,0-40Z"/></svg>
                                    <p class="no-margin fs12 gray bold">{{__('Type')}}:</p>
                                </div>
                                <div class="relative">
                                    <div class="audience-button nested-soc-button button-with-suboptions flex align-center pointer">
                                        <svg class="size18 thread thread-add-type-icon" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"/></svg>
                                        <span class="lblack bold fs12 ml4" id="thread-add-type-selected-name">{{__('post')}}</span>
                                        <svg class="size7 ml4 faq-toggled-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 350"><path d="M192,271.31l136-136a23.9,23.9,0,0,0,.1-33.8.94.94,0,0,1-.1-.1l-22.6-22.6a23.9,23.9,0,0,0-33.8-.1l-.1.1L175,175.11,78.6,78.7a23.91,23.91,0,0,0-33.8-.1l-.1.1L22,101.3a23.9,23.9,0,0,0-.1,33.8l.1.1,136,136a23.94,23.94,0,0,0,33.84.26l.16-.16Z"></path></svg>
                                    </div>
                                    <div class="nested-soc thread-add-suboptions-container" style="left: 0; width: max-content; min-width: unset">
                                        <div class="thread-add-suboption thread-add-type-change tap-discussion flex align-center mb2" style="background-color: #dfdfdf; cursor: default;">
                                            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" style="fill: #202020" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"/></svg>
                                            <span class="fs12 bold lblack">{{ __('Post') }}</span>
                                            <input type="hidden" class="thread-type-name" value="{{__('post')}}" autocomplete="off">
                                            <input type="hidden" class="thread-type" value="discussion" autocomplete="off">
                                            <input type="hidden" class="selected-icon-path" value="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z">
                                        </div>
                                        <div class="thread-add-suboption thread-add-type-change tap-poll flex align-center">
                                            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" style="fill: #202020" viewBox="0 0 512 512"><path d="M302.16,471.18H216a14,14,0,0,1-14-14V53.47a14,14,0,0,1,14-14h86.18a14,14,0,0,1,14,14V457.15A14,14,0,0,1,302.16,471.18ZM162.78,458.53V146.85a14,14,0,0,0-14-14H62.57a14,14,0,0,0-14,14V458.53a14,14,0,0,0,14,14h86.17A14,14,0,0,0,162.78,458.53Zm300.69,0V220a14,14,0,0,0-14-14H363.26a14,14,0,0,0-14,14V458.53a14,14,0,0,0,14,14h86.17A14,14,0,0,0,463.47,458.53Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                                            <span class="fs12 bold lblack">{{ __('Poll') }}</span>
                                            <input type="hidden" class="thread-type-name" value="{{__('poll')}}" autocomplete="off">
                                            <input type="hidden" class="thread-type" value="poll" autocomplete="off">
                                            <input type="hidden" class="selected-icon-path" value="M302.16,471.18H216a14,14,0,0,1-14-14V53.47a14,14,0,0,1,14-14h86.18a14,14,0,0,1,14,14V457.15A14,14,0,0,1,302.16,471.18ZM162.78,458.53V146.85a14,14,0,0,0-14-14H62.57a14,14,0,0,0-14,14V458.53a14,14,0,0,0,14,14h86.17A14,14,0,0,0,162.78,458.53Zm300.69,0V220a14,14,0,0,0-14-14H363.26a14,14,0,0,0-14,14V458.53a14,14,0,0,0,14,14h86.17A14,14,0,0,0,463.47,458.53Z" style="stroke:#fff;stroke-miterlimit:10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px8 pt8 thread-add-error-container none">
                    <div class="flex">
                        <svg class="size14 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                        <span class="error fs13 bold no-margin thread-add-error"></span>
                    </div>
                </div>
                <div class="px8 py8">
                    <div class="flex space-between">
                        <label for="subject" class="flex align-center bold forum-color mb4">{{ __('Announcement Title') }}<span class="error asterisk-error ml4 none">*</span></label>
                        <div class="move-to-right flex align-center relative mb4">
                            <!-- this button will be displayed only to other users and not to the activities profile owner -->
                            <svg class="size17 pointer button-with-suboptions" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <div class="suboptions-container thread-add-notice-container-style">
                                <span class="mb4 block bold">{{ __('Title') }}</span>
                                <p class="no-margin fs13">{{ __('Title should be clear, concise and to the point') }}.</p>
                                <span class="mb4 mt8 block bold">{{ __('Content') }}</span>
                                <div class="flex">
                                    <span class="bold mr8 fs20">❝</span>
                                    <div>
                                        <p class="no-margin fs13">{{ __('If you choose to insert a quote or a list of options and you decide to finish the list or end the quote, you have to click enter button twice') }}.</p>
                                        <p class="no-margin mt8 fs13">{{ __('If you want to insert a quote inside another quote you have to insert > sign twice with space after each one like following:') }}.</p>
                                        <p class="no-margin fs12 bold block mt4">> {{__('quote include another quote')}} : > > {{ __('nested quote here') }}</p>
                                    </div>
                                </div>
                                <div class="simple-line-separator" style="width: 40%; margin: 10px 0"></div>
                                <div class="flex mb8">
                                    <p class="no-margin fs13">{{ __('You can preview your content temporarily by clicking on the eye button to check the format of content. To get the editor back just click on the eye button again') }}.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="required-text" value="{{ __('Announcement title field is required') }}">
                    <input type="text" id="subject" name="subject" class="styled-input" required autocomplete="off" placeholder='{{ __("Be specific and imagine you’re talking to another person") }}'>
                </div>
                <div id="thread-add-discussion">
                    <div>
                        <div class="flex align-center space-between mb4 mx8">
                            <label for="content" class="flex align-center bold forum-color">{{ __('Announcement Content') }}<span class="error ml4 none">*</span></label>
                            <div class="custom-checkbox-button pointer disable-announcement-replies flex align-center">
                                <div class="custom-checkbox size10 mr4" style='border-radius: 2px;'>
                                    <svg class="size8 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                                    <input type="hidden" class="checkbox-status" id="replies-disable" autocomplete="off" value="0">
                                </div>
                                <p class="no-margin fs12 bold unselectable">{{ __('disable replies') }}</p>
                            </div>
                        </div>
                        <input type="hidden" class="required-text" value="{{ __('Announcement content field is required') }}">
                        <textarea name="content" id="content" placeholder="{{ __('Announcement content') }}.."></textarea>
                    </div>
                    <div class="thread-add-media-section px8">
                        <div class="thread-add-media-error px8 my8">
                            <p class="error tame-image-type none">* {{ __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported') }}.</p>
                            <p class="error tame-image-limit none">* {{ __('You could only upload 20 images max per post') }}.</p>
                            <p class="error tame-video-type none">* {{ __('Only .MP4, .WEBM, .MPG, .MP2, .MPEG, .MPE, .MPV, .OGG, .M4P, .M4V, .AVI video formats are supported') }}.</p>
                            <p class="error tame-video-limit none">* {{ __('You could only upload 4 videos max per post') }}.</p>
                        </div>
                        <div class="flex align-end">
                            <div class="flex">
                                <div class="flex align-center thread-add-button-hover-style mr4 relative">
                                    <svg class="size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M395.3,76H116.72C94.26,76,76,95.47,76,119.46V392.59c0,24,18.26,43.41,40.72,43.41H395.3c22.46,0,40.7-19.45,40.7-43.41V119.46C436,95.47,417.76,76,395.3,76Zm-86.5,64.63c21.71,0,39.32,18.79,39.32,42s-17.61,42-39.32,42-39.33-18.79-39.33-42S287.07,140.63,308.8,140.63Zm73.73,255.22H135.1c-10.86,0-15.7-8.38-10.81-18.73l67.5-142.61c4.89-10.34,14.21-11.26,20.81-2.06l67.87,94.61c6.6,9.21,18.13,10,25.77,1.75l16.6-17.94c7.63-8.24,18.87-7.22,25.1,2.27l43,65.51C397.14,388.15,393.4,395.85,382.53,395.85Z" style="fill:#010002"/></svg>
                                    <p class="no-margin fs12 lblack">{{__('Include Images')}}</p>
                                    <input type="file" name="images[]" id="thread-photos" style="height: 60px; bottom: 0;" class="thread-add-file-input" multiple accept=".jpg,.jpeg,.png,.bmp,.gif">
                                </div>
                                <div class="flex align-center thread-add-button-hover-style relative">
                                    <svg class="size20" style="margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,56C145.52,56,56,145.52,56,256s89.52,200,200,200,200-89.52,200-200S366.48,56,256,56Zm93.31,219.35L207.37,356.81a19.39,19.39,0,0,1-28.79-16.94V172.13a19.41,19.41,0,0,1,28.79-16.94l141.94,86.29C362.53,248.9,362.53,268,349.31,275.35Z"/></svg>
                                    <p class="no-margin fs13">{{__('Include Video')}}</p>
                                    <input type="file" name="videos[]" id="thread-videos" style="height: 60px; bottom: 0;" class="thread-add-file-input" multiple accept=".mp4,.webm,.mpg,.mp2,.mpeg,.mpe,.mpv,.ogg,.mp4,.m4p,.m4v,.avi">
                                </div>
                            </div>
                            <div class="progress-bar-box none full-width pb4" style="margin-left: 18px">
                                <input type="hidden" class="upload-finish-text" value="{{ __('Upload finishes ! Please wait') }}..">
                                <input type="hidden" class="uploading-text" value="{{ __('Uploading media to your post') }}..">
                                <p class="no-margin fs11 bold bblack mb2 text-above-progress-bar">{{ __('Uploading media to your post') }}..</p>
                                <div class="progress-bar-container relative flex align-center">
                                    <span class="fs12 bold progress-bar-percentage"><span class="progress-bar-percentage-counter">0</span>%</span>
                                    <div class="progress-bar flex align-center justify-center"></div>
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
                        <div id="thread-uploads-wrapper" class="thread-add-uploaded-medias-container x-auto-overflow flex my4" >
                            <input type="hidden" class="uploaded-images-counter" value="0" autocomplete="off">
                            <input type="hidden" class="uploaded-videos-counter" value="0" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div id="thread-add-poll" class="poll-box none">
                    <input type="hidden" class="allow-multiple-choices" autocomplete="off" value="no">
                    <input type="hidden" class="allow-people-to-add-options" autocomplete="off" value="no">
                    <!-- errors -->
                    <input type="hidden" id="options-length-limit-error" value="{{ __('You could only add 30 options maximum') }}" autocomplete="off">
                    <input type="hidden" id="options-length-required" value="{{ __('Poll requires at least 2 options') }}" autocomplete="off">
                    <input type="hidden" id="options-length-fillables-required" value="{{ __('Your poll should have at least 2 fillable options') }}" autocomplete="off">
                    <input type="hidden" id="options-should-be-unique-error" value="{{ __('Poll options must be unique') }}" autocomplete="off">

                    <div class="flex align-end space-between mb8">
                        <div class="flex">
                            <svg class="size15 mr8" style="margin-top: 1px; fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M302.16,471.18H216a14,14,0,0,1-14-14V53.47a14,14,0,0,1,14-14h86.18a14,14,0,0,1,14,14V457.15A14,14,0,0,1,302.16,471.18ZM162.78,458.53V146.85a14,14,0,0,0-14-14H62.57a14,14,0,0,0-14,14V458.53a14,14,0,0,0,14,14h86.17A14,14,0,0,0,162.78,458.53Zm300.69,0V220a14,14,0,0,0-14-14H363.26a14,14,0,0,0-14,14V458.53a14,14,0,0,0,14,14h86.17A14,14,0,0,0,463.47,458.53Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                            <div>
                                <span class="block bold forum-color fs15">{{ __('Poll Creation') }}</span>
                                <p class="fs13 lblack no-margin">{{ __('Specify poll options below.') }}</p>
                            </div>
                        </div>
                        <div class="flex align-center">
                            <div class="wtypical-button-style poll-add-option mr8 unselectable fs13">
                                <svg class="size10 mr4" style="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect x="40.44" width="19.13" height="100" rx="4"/><rect x="40.37" y="0.06" width="19.26" height="100" rx="4" transform="translate(-0.06 100.06) rotate(-90)"/></svg>
                                <span class="fs12 bold">{{ __('Add option') }}</span>
                            </div>
                            <div class="relative">
                                <div class="wtypical-button-style button-with-suboptions unselectable">
                                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                                    <span class="fs12 bold">{{ __('Poll options') }}</span>
                                </div>
                                <div class="suboptions-container thread-add-suboptions-container" style="right: 0; width: max-content">
                                    <div class="custom-checkbox-button thread-add-suboption flex align-center space-between">
                                        <span class="unselectable fs13 lblack">{{ __('Allow people to choose multiple options') }}</span>
                                        <div class="custom-checkbox size16 br2" style="margin-left: 12px">
                                            <svg class="size10 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                                            <input type="hidden" class="checkbox-status poll-allow-multiple-voting" autocomplete="off" value="0">
                                        </div>
                                    </div>
                                    <div class="toggle-box">
                                        <div class="custom-checkbox-button thread-add-suboption flex align-center space-between toggle-container-button">
                                            <span class="unselectable fs13 lblack">{{ __('Allow anyone to add options') }}</span>
                                            <div class="custom-checkbox size16 br2" style="margin-left: 12px">
                                                <svg class="size10 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                                                <input type="hidden" class="checkbox-status allow-others-to-add-options" autocomplete="off" value="0">
                                            </div>
                                        </div>
                                        <div class="toggle-container mb8" style="margin-left: 15px;">
                                            <div class="flex align-center">
                                                <svg class="size14 mr8" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                                                <span class="fs11 lblack mt8">{{ __('maximum options per user') }} :</span>
                                                <select id="poll-options-per-user-limit" class="mt8 ml8 basic-dropdown" style="padding: 1px 3px;">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- thread-add option factory (used for clonning) -->
                    <div class="poll-option-box thread-poll-option-container poll-option-validation-box thread-add-poll-option-factory my8 none">
                        <div class="my4 pr8 pt8 poll-option-input-error none">
                            <div class="flex">
                                <svg class="size14 mr4" style="fill: rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                <span class="error fs13 bold no-margin"></span>
                            </div>
                        </div>
                        <div class="flex align-center dynamic-input-wrapper">
                            <span class="dynamic-label">{{ __('Option') }} <span class="ta-option-index">2</span></span>
                            <input type="text" maxlength="140" name="options[]" class="input-with-dynamic-label poll-option-value poll-option-validation full-width fs15" autocomplete="off">
                            <svg class="mx8 size12 remove-poll-option simple-icon-button-style" style="padding:6px; margin-bottom: 2px" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 95.94 95.94"><path d="M62.82,48,95.35,15.44a2,2,0,0,0,0-2.83l-12-12A2,2,0,0,0,81.92,0,2,2,0,0,0,80.5.59L48,33.12,15.44.59a2.06,2.06,0,0,0-2.83,0l-12,12a2,2,0,0,0,0,2.83L33.12,48,.59,80.5a2,2,0,0,0,0,2.83l12,12a2,2,0,0,0,2.82,0L48,62.82,80.51,95.35a2,2,0,0,0,2.82,0l12-12a2,2,0,0,0,0-2.83Z"></path></svg>
                        </div>
                    </div>
                    <div id="thread-add-poll-options-box" class="poll-options-wrapper">
                        <input type="hidden" class="uniqueness-pass" autocomplete="off" value="1">
                        <!-- errors -->
                        <input type="hidden" class="length-error" value="{{ __('Option must contains at least 1 character') }}">
                        <input type="hidden" class="uniqueness-error" value="{{ __('Option already exists') }} !">
                        <input type="hidden" class="owner-options-limit-error" value="{{ __('Poll could have only 30 options max') }} !">

                        <div class="poll-option-box thread-poll-option-container poll-option-validation-box">
                            <div class="my4 pr8 pt8 poll-option-input-error none">
                                <div class="flex">
                                    <svg class="size14 mr4" style="fill: rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                    <span class="error fs13 bold no-margin"></span>
                                </div>
                            </div>
                            <div class="flex align-center dynamic-input-wrapper">
                                <span class="dynamic-label">{{ __('Option') }} <span class="ta-option-index">1</span></span>
                                <input type="text" maxlength="140" name="options[]" class="input-with-dynamic-label poll-option-value poll-option-validation full-width fs15" autocomplete="off">
                                <svg class="mx8 size12 remove-poll-option simple-icon-button-style" style="padding:6px; margin-bottom: 2px" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 95.94 95.94"><path d="M62.82,48,95.35,15.44a2,2,0,0,0,0-2.83l-12-12A2,2,0,0,0,81.92,0,2,2,0,0,0,80.5.59L48,33.12,15.44.59a2.06,2.06,0,0,0-2.83,0l-12,12a2,2,0,0,0,0,2.83L33.12,48,.59,80.5a2,2,0,0,0,0,2.83l12,12a2,2,0,0,0,2.82,0L48,62.82,80.51,95.35a2,2,0,0,0,2.82,0l12-12a2,2,0,0,0,0-2.83Z"></path></svg>
                            </div>
                        </div>
                        <div class="poll-option-box thread-poll-option-container poll-option-validation-box my8">
                            <div class="my4 pr8 pt8 poll-option-input-error none">
                                <div class="flex">
                                    <svg class="size14 mr4" style="fill: rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                    <span class="error fs13 bold no-margin"></span>
                                </div>
                            </div>
                            <div class="flex align-center dynamic-input-wrapper">
                                <span class="dynamic-label">{{ __('Option') }} <span class="ta-option-index">2</span></span>
                                <input type="text" maxlength="140" name="options[]" class="input-with-dynamic-label poll-option-value poll-option-validation full-width fs15" autocomplete="off">
                                <svg class="mx8 size12 remove-poll-option simple-icon-button-style" style="padding:6px; margin-bottom: 2px" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 95.94 95.94"><path d="M62.82,48,95.35,15.44a2,2,0,0,0,0-2.83l-12-12A2,2,0,0,0,81.92,0,2,2,0,0,0,80.5.59L48,33.12,15.44.59a2.06,2.06,0,0,0-2.83,0l-12,12a2,2,0,0,0,0,2.83L33.12,48,.59,80.5a2,2,0,0,0,0,2.83l12,12a2,2,0,0,0,2.82,0L48,62.82,80.51,95.35a2,2,0,0,0,2.82,0l12-12a2,2,0,0,0,0-2.83Z"></path></svg>
                            </div>
                        </div>
                        <div class="poll-option-box thread-poll-option-container poll-option-validation-box my8">
                            <div class="my4 pr8 pt8 poll-option-input-error none">
                                <div class="flex">
                                    <svg class="size14 mr4" style="fill: rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                    <span class="error fs13 bold no-margin"></span>
                                </div>
                            </div>
                            <div class="flex align-center dynamic-input-wrapper">
                                <span class="dynamic-label">{{ __('Option') }} <span class="ta-option-index">3</span></span>
                                <input type="text" maxlength="140" name="options[]" class="input-with-dynamic-label poll-option-value poll-option-validation full-width fs15" autocomplete="off">
                                <svg class="mx8 size12 remove-poll-option simple-icon-button-style" style="padding:6px; margin-bottom: 2px" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 95.94 95.94"><path d="M62.82,48,95.35,15.44a2,2,0,0,0,0-2.83l-12-12A2,2,0,0,0,81.92,0,2,2,0,0,0,80.5.59L48,33.12,15.44.59a2.06,2.06,0,0,0-2.83,0l-12,12a2,2,0,0,0,0,2.83L33.12,48,.59,80.5a2,2,0,0,0,0,2.83l12,12a2,2,0,0,0,2.82,0L48,62.82,80.51,95.35a2,2,0,0,0,2.82,0l12-12a2,2,0,0,0,0-2.83Z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
                @can('create_announcement', [\App\Models\Thread::class])
                <div class="announcement-add-share typical-button-style full-center border-box" style="padding: 12px 0; margin: 10px;">
                    <div class="relative size14 mr4">
                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M201.05,3.07c8.23,2.72,16.28,5.55,23,11.56,18.11,16.18,19.44,44.44,2.63,63.18-15.58,17.37-43.73,18.58-61,2.32-3.22-3-5.24-3.16-8.9-.81-12.46,8-25.25,15.52-37.83,23.35-2.31,1.44-3.62,1.53-4.7-1.19a24.77,24.77,0,0,0-2.4-4.25c-3.53-5.4-3.54-5.38,2.16-8.86,12.22-7.48,24.42-15,36.69-22.41,2-1.22,3.23-2.23,2.32-4.93-8.35-24.77,7.61-50.71,30.61-56.36.94-.23,2.38-.15,2.75-1.6Zm22.63,173.39c-18.11-15.47-41.43-15-58.9,1.2-2.5,2.31-4.1,2.5-6.93.7C147,171.46,136,164.82,125,158.12c-2.89-1.76-5.92-4.75-8.81-4.66-2.47.08-2.92,5-5,7.28-.11.12-.15.3-.27.41-2.76,2.69-2.35,4.38,1.1,6.42,12.77,7.52,25.29,15.47,38,23,2.84,1.7,3.94,3.2,2.65,6.51-2.57,6.57-2.39,13.51-1.28,20.28,3.49,21.33,24.74,38.21,45.44,36.42,24.16-2.08,42.07-21.18,41.82-44.6C238.39,196.12,233.64,185,223.68,176.46Zm-161-92c-24-.28-44.23,19.81-44.27,44a44.34,44.34,0,0,0,43.71,44.11c24,.28,44.22-19.81,44.27-44A44.36,44.36,0,0,0,62.68,84.43Z"/></svg>
                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="bold unselectable">{{ __('Share announcement post') }}</span>
                    <input type="hidden" class="success-message" value="{{ __('Announcement has been shared successfully') }}" autocomplete="off">
                </div>
                @else
                <div class="section-style flex align-center my4 mx8">
                    <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="fs12 bold lblack no-margin">You cannot create annoncements because you don't have permission to do so</p>
                </div>
                <div class="disabled-typical-button-style full-center border-box" style="padding: 12px 0; margin: 10px;">
                    <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M201.05,3.07c8.23,2.72,16.28,5.55,23,11.56,18.11,16.18,19.44,44.44,2.63,63.18-15.58,17.37-43.73,18.58-61,2.32-3.22-3-5.24-3.16-8.9-.81-12.46,8-25.25,15.52-37.83,23.35-2.31,1.44-3.62,1.53-4.7-1.19a24.77,24.77,0,0,0-2.4-4.25c-3.53-5.4-3.54-5.38,2.16-8.86,12.22-7.48,24.42-15,36.69-22.41,2-1.22,3.23-2.23,2.32-4.93-8.35-24.77,7.61-50.71,30.61-56.36.94-.23,2.38-.15,2.75-1.6Zm22.63,173.39c-18.11-15.47-41.43-15-58.9,1.2-2.5,2.31-4.1,2.5-6.93.7C147,171.46,136,164.82,125,158.12c-2.89-1.76-5.92-4.75-8.81-4.66-2.47.08-2.92,5-5,7.28-.11.12-.15.3-.27.41-2.76,2.69-2.35,4.38,1.1,6.42,12.77,7.52,25.29,15.47,38,23,2.84,1.7,3.94,3.2,2.65,6.51-2.57,6.57-2.39,13.51-1.28,20.28,3.49,21.33,24.74,38.21,45.44,36.42,24.16-2.08,42.07-21.18,41.82-44.6C238.39,196.12,233.64,185,223.68,176.46Zm-161-92c-24-.28-44.23,19.81-44.27,44a44.34,44.34,0,0,0,43.71,44.11c24,.28,44.22-19.81,44.27-44A44.36,44.36,0,0,0,62.68,84.43Z"/></svg>
                    <span class="bold unselectable white">{{ __('Share announcement post') }}</span>
                </div>
                @endif
                <style>
                    .CodeMirror,
                    .CodeMirror-scroll {
                        max-height: 200px;
                        min-height: 200px;
                        border-radius: 0;
                        border-left: none;
                        border-right: none;
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
                        border-left: none;
                        border-right: none;
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
        </div>
        </div>
    </div>
@endsection