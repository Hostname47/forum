@extends('layouts.admin')

@section('title', 'Admin - Announcement management')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.announcements', 'subpage'=>'threads.announcement.manage'])
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/announcement/manage.js') }}" defer></script>
@endpush

@section('content')
    <style>
        table {
            border-collapse: collapse;
            box-sizing: border-box;
        }

        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table td {
            vertical-align: top;
        }

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #eee;
        }

        #author-col {
            max-width: 140px; 
        }

        #announcement-col {
            width: 100%;
        }

        #ops-col, #stats-col {
            min-width: 120px;
        }

        .button-with-left-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 3px;
            border-radius: 4px;
            background-color: #f0f0f0;
            border: 1px solid #cecece;
            transition: background-color 0.2s ease;
        }

        .button-with-left-icon:hover {
            background-color: #e8e8e8;
        }
    </style>
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="mr8 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"></path></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Manage Announcements') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Dashboard') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Manage announcements') }}</span>
            </div>
        </div>
    </div>
    <div id="announcement-delete-viewer" class="global-viewer full-center none">
        <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
        <div class="viewer-box-style-1">
            <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                <span class="fs20 bold forum-color flex align-center">
                    <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                    {{ __('Delete announcement') }}
                </span>
                <div class="pointer fs20 close-global-viewer unselectable">✖</div>
            </div>
            <div class="full-center relative">
                <div class="global-viewer-content-box" style="padding: 14px; min-height: 200px;">
                    
                </div>
                <!-- loading -->
                <svg class="loading-viewer-spinner size30 absolute black" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box">
        <div>
            <div class="flex space-between mb8">
                <div class="flex align-center">
                    <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M497,241H452a15,15,0,0,0,0,30h45a15,15,0,0,0,0-30Zm-19.39,94.39-30-30a15,15,0,0,0-21.22,21.22l30,30a15,15,0,0,0,21.22-21.22Zm0-180a15,15,0,0,0-21.22,0l-30,30a15,15,0,0,0,21.22,21.22l30-30A15,15,0,0,0,477.61,155.39ZM347,61a45.08,45.08,0,0,0-44.5,38.28L288.82,113C265,136.78,229.93,151,195,151H105a45.06,45.06,0,0,0-42.42,30H60a60,60,0,0,0,0,120h2.58A45.25,45.25,0,0,0,90,328.42V406a45,45,0,0,0,90,0V331h15c34.93,0,70,14.22,93.82,38l13.68,13.69A45,45,0,0,0,392,376V106A45.05,45.05,0,0,0,347,61ZM60,271a30,30,0,0,1,0-60Zm90,135a15,15,0,0,1-30,0V331h30Zm30-105H105a15,15,0,0,1-15-15V196a15,15,0,0,1,15-15h75Zm122,39.35c-25.34-21.94-57.92-35.56-92.1-38.67V180.32c34.18-3.11,66.76-16.73,92.1-38.67ZM362,376a15,15,0,0,1-15,15h0a15,15,0,0,1-15-15V106a15,15,0,0,1,30,0Z"></path></svg>
                    <p class="no-margin bold fs16 lblack">{{ __('Announcements') }}</p>
                    <div class="gray height-max-content mx4 fs10">•</div>
                    <span class="flex fs12 lblack mr4">select a forum :</span>
                    <div class="relative flex align-center">
                        <div class="forum-color button-with-suboptions wtypical-button-style" style="padding: 5px 9px;">
                            @if($selectedforum == 'all')
                            <svg class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.67,0H53.33A53.39,53.39,0,0,0,0,53.33V458.67A53.39,53.39,0,0,0,53.33,512H458.67A53.39,53.39,0,0,0,512,458.67V53.33A53.39,53.39,0,0,0,458.67,0Zm10.66,53.33V234.67h-192v-192H458.67A10.68,10.68,0,0,1,469.33,53.33Zm-416-10.66H234.67v192h-192V53.33A10.68,10.68,0,0,1,53.33,42.67Zm-10.66,416V277.33h192v192H53.33A10.68,10.68,0,0,1,42.67,458.67Zm416,10.66H277.33v-192h192V458.67A10.68,10.68,0,0,1,458.67,469.33Z"/></svg>
                            @else
                            <svg class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">{!! $forum->icon !!}</svg>
                            @endif
                            <span class="fs12 bold">{{ ($selectedforum == 'all') ? 'All forums' : $forum->forum }}</span>
                            <svg class="size6 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M28.61,13.35l-11,9.39a4,4,0,0,1-5.18,0l-11-9.31A4,4,0,1,1,6.59,7.32L15,14.45l8.37-7.18a4,4,0,0,1,5.2,6.08Z"></path></svg>
                        </div>
                        <div class="suboptions-container typical-suboptions-container y-auto-overflow" style="max-height: 236px; width: 180px;">
                            <a href="{{ route('admin.announcements.manage') }}" class="typical-suboption @if($selectedforum == 'all') typical-suboption-selected @endif no-underline lblack flex align-center">
                                <svg class="size13 forum-icon mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.67,0H53.33A53.39,53.39,0,0,0,0,53.33V458.67A53.39,53.39,0,0,0,53.33,512H458.67A53.39,53.39,0,0,0,512,458.67V53.33A53.39,53.39,0,0,0,458.67,0Zm10.66,53.33V234.67h-192v-192H458.67A10.68,10.68,0,0,1,469.33,53.33Zm-416-10.66H234.67v192h-192V53.33A10.68,10.68,0,0,1,53.33,42.67Zm-10.66,416V277.33h192v192H53.33A10.68,10.68,0,0,1,42.67,458.67Zm416,10.66H277.33v-192h192V458.67A10.68,10.68,0,0,1,458.67,469.33Z"/></svg>
                                <span class="forum-name fs12 bold">{{ __('All forums') }}</span>
                                <input type="hidden" class="forum-id" value="0" autocomplete="off">
                                <input type="hidden" class="forum-slug" value="all" autocomplete="off">
                            </a>
                            <div class="simple-line-separator" style="margin: 2px 0"></div>
                            @foreach($forums as $forum)
                                <a href="?forum={{ $forum->slug }}" class="typical-suboption @if($selectedforum == $forum->slug) typical-suboption-selected @endif no-underline flex">
                                    <svg class="size13 forum-icon mr8" style="min-width: 13px; margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        {!! $forum->icon !!}
                                    </svg>
                                    <span class="forum-name fs12 lblack bold">{{ __($forum->forum) }}</span>
                                    <input type="hidden" class="forum-id" value="{{ $forum->id }}">
                                    <input type="hidden" class="forum-slug" value="{{ $forum->slug }}">
                                </a>
                            @endforeach
                        </div>
                        <svg class="spinner size16 opacity0 blue ml8" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex">
                    <div class="move-to-right">
                        {{ $announcements->onEachSide(0)->links() }}
                    </div>
                </div>
            </div>
            <table>
                <tr>
                    <th id="author-col">Author</th>
                    <th id="announcement-col">Announcement</th>
                    <th id="ops-col">Operations</th>
                    <th id="stats-col">Stats</th>
                </tr>
                @foreach($announcements as $announcement)
                    <x-admin.thread.announcement_manage :announcement="$announcement"/>
                @endforeach
                @if(!$announcements->count())
                <tr>
                    <td colspan="4">
                        <div class="full-center">
                            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="fs13 bold">No announcements found for the selected forum</p>
                        </div>
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <div class="flex">
            <div class="move-to-right flex my8">
                <div class="move-to-right">
                    {{ $announcements->onEachSide(0)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection