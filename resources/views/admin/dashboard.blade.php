@extends('layouts.admin')

@section('title', 'Admin - Dashboard')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.dashboard'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/admin-dashboard.js') }}" defer></script>
<script src="{{ asset('js/admin/visits.js') }}" defer></script>
@endpush

@section('content')
    <style>
        .dashboard-statistics-record-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 14px;
        }

        .dsf-selected, .vlf-selected {
            cursor: default;
            background-color: #f4f4f4;
        }
    </style>
    @include('partials.admin.thread.thread-render')
    @include('partials.admin.post.post-render')
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="mr8 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Dashboard') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Dashboard') }}</a>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box">
        <!-- review authorization breaks viewer -->
        <div id="authbreaks-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; width: 700px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs20 bold forum-color flex align-center">
                        <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M231,130.52c0,16.59-.13,33.19.06,49.78.08,6.24-2.44,10.4-7.77,13.46q-43.08,24.72-86,49.68c-5.52,3.21-10.45,3-16-.2Q78.8,218.46,36.1,194.09c-5.91-3.37-8.38-7.8-8.34-14.61q.3-49,0-98.1c0-6.63,2.49-10.93,8.2-14.19Q78.68,42.82,121.15,18c5.69-3.32,10.69-3.42,16.38-.1Q180,42.71,222.7,67.1c5.89,3.36,8.46,7.8,8.35,14.61C230.77,98,231,114.25,231,130.52Zm-179.67,0c0,44.84,33,78,77.83,78.16s78.37-33.05,78.39-78.08c0-44.88-32.93-78-77.83-78.14S51.32,85.49,51.29,130.55Z" style="fill:#020202"></path><path d="M129.35,150.13c-13.8,0-27.61,0-41.42,0-8.69,0-13.85-6-13.76-15.79.09-9.62,5.15-15.43,13.6-15.44q40,0,79.93,0c13.05,0,19,7.43,16.37,20.38-1.46,7.17-5.92,10.85-13.29,10.86C157,150.15,143.16,150.13,129.35,150.13Z" style="fill:#020202"></path></svg>
                        {{ __("Authorization breaks") }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div id="authbreaks-review-box" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; max-height: 450px; min-height: 200px;">
                        
                    </div>
                    <div class="loading-box flex-column full-center absolute" style="margin-top: -20px;">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="forum-color fs11 mt8">Fetching authorization breaks..</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- visitors viewer -->
        <div id="visitors-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; width: 400px;">
                <div class="full-center light-gray-border-bottom relative border-box" style="padding: 14px;">
                    <span class="fs16 bold forum-color flex align-center mt2">{{ __("Visitors") }}</span>
                    <div class="pointer fs20 close-global-viewer unselectable absolute" style="right: 16px">✖</div>
                </div>
                <div class="full-center relative">
                    <div id="visitors-box" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 120px; max-height: 358px">
                        
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
        <!-- new signups viewer -->
        <div id="new-signups-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="margin-top: -26px; width: 400px;">
                <div class="full-center light-gray-border-bottom relative border-box" style="padding: 14px;">
                    <span class="fs16 bold forum-color flex align-center mt2">{{ __("New registered users") }}</span>
                    <div class="pointer fs20 close-global-viewer unselectable absolute" style="right: 16px">✖</div>
                </div>
                <div class="full-center relative">
                    <div id="new-signups-box" class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 120px; max-height: 358px">
                        
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

        <div class="section-card full-width relative">
            <div class="flex align-center" style="margin-bottom: 10px">
                <div class="flex align-center">
                    <svg class="size16 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V80A48,48,0,0,0,400,32ZM160,368a16,16,0,0,1-16,16H112a16,16,0,0,1-16-16V240a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Zm96,0a16,16,0,0,1-16,16H208a16,16,0,0,1-16-16V144a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Zm96,0a16,16,0,0,1-16,16H304a16,16,0,0,1-16-16V304a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Z"/></svg>
                    <span class="bold">{{ __('Statistics') }}</span>
                </div>
                <div class="relative" style="margin-left: 10px">
                    <div class="flex align-center pointer button-with-suboptions">
                        <p class="no-margin lblack mr4 fs11">Date filter: <span class="bold fs12" id="dashboard-statistics-filter-selection-name">Today</span></p>
                        <svg class="size7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                    </div>
                    <div class="suboptions-container thread-add-suboptions-container" style="right: 0">
                        <div class="simple-suboption mb2 dashbaord-statistics-filter dsf-selected">
                            <div>
                                <p class="no-margin sort-by-val bold forum-color">{{ __('Today') }}</p>
                                <p class="no-margin fs12 gray">{{ __('Statistics of today') }}</p>
                                <input type="hidden" class="filter" value="today" autocomplete="off">
                                <input type="hidden" class="filter-name" value="Today" autocomplete="off">
                            </div>
                        </div>
                        <div class="simple-suboption mb2 thread-add-suboption dashbaord-statistics-filter">
                            <div>
                                <p class="no-margin sort-by-val bold forum-color">{{ __('Last week') }}</p>
                                <p class="no-margin fs12 gray">{{ __('Statistics of this week') }}</p>
                                <input type="hidden" class="filter" value="lastweek" autocomplete="off">
                                <input type="hidden" class="filter-name" value="Last week" autocomplete="off">
                            </div>
                        </div>
                        <div class="simple-suboption thread-add-suboption dashbaord-statistics-filter">
                            <div>
                                <p class="no-margin sort-by-val bold forum-color">{{ __('Last 30 days') }}</p>
                                <p class="no-margin fs12 gray">{{ __('Statistics of the past 30 days') }}</p>
                                <input type="hidden" class="filter" value="lastmonth" autocomplete="off">
                                <input type="hidden" class="filter-name" value="Last month" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex space-between relative" style="padding: 0 10px">
                <div id="dashboard-statistics-loading-strip" class="absolute full-center full-dimensions flex-column none" style="left:0; top:0; background-color: #F6F7F9;">
                    <svg class="spinner size16 ml4" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <div>
                    <span class="block fs11 bold blue mb8">{{ __('GENERAL STATS') }}</span>
                    <div class="flex align-center">
                        <div class="dashboard-statistics-record-wrapper">
                            <svg class="size28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M257.12,65.58c-1.66.53-1.36,2.18-1.64,3.3a52.78,52.78,0,0,1-14.38,25c-21.63,21.67-43.19,43.43-65,64.94-21,20.73-54,21.27-74.23,1.6-3.56-3.46-5-7.46-3.52-12.09,1.34-4.07,4.61-6.41,8.89-6.92s7.44,2.1,10.53,4.64c9.17,7.53,19.48,9.26,30.69,5.79,5.33-1.65,9.67-5,13.57-8.86,21.09-21.06,42.25-42,63.19-63.23,18.49-18.73,11.53-47.69-13-54.34-12.46-3.37-23.08.52-32,9.5Q163.84,51.3,147.51,67.62c-2.77,2.77-5.76,5.12-9.92,4.81a10.06,10.06,0,0,1-8.92-6.16c-1.85-4.15-1.28-8.33,1.9-11.51C144.23,41.05,156.86,26.13,172,14.12c30.66-24.28,75.29-7.43,84,31.13.2.87-.31,2.07,1.07,2.44ZM63.35,257.35c.16-.26.29-.74.47-.76,12.7-1.68,22.87-8,31.67-17,7.3-7.45,14.75-14.74,22.09-22.15,2.44-2.46,5.18-4.65,7-7.68a10.5,10.5,0,0,0-8.53-15.93c-3.93-.12-6.85,2-9.5,4.66-9,9-18,18.09-27,27-10.9,10.7-25,13.47-37.22,7.52-20.68-10.06-24.4-35.62-7.51-52.68,18.86-19,37.88-37.95,56.86-56.88a34.72,34.72,0,0,1,8.13-6.44c13.5-7.14,26-5.47,37.67,4.19,6,5,12.1,4.78,16.21-.1s3-10.9-2.58-16.1C131.77,87.2,100.44,86.4,81,104.71c-22.27,21-44.15,42.48-64.92,64.94-26.56,28.71-11.75,75.86,26.09,85.9,1.46.39,3.37,0,4.3,1.8Zm193.77-87.44c-2.84-6.16-7.75-8.25-14.35-8-8.75.3-17.52,0-26.28.09-7.57.07-12.27,4.27-12.2,10.71s4.52,10.28,11.94,10.37c9.09.12,18.2-.19,27.28.11,6.56.22,11.09-2.21,13.61-8.29Zm-82.48,87.44c6.08-2.51,8.51-7,8.29-13.6-.3-9.08,0-18.19-.1-27.28-.1-7.43-4.08-11.87-10.38-11.94s-10.64,4.62-10.71,12.19c-.08,8.77.21,17.54-.09,26.29-.23,6.6,1.86,11.51,8,14.34ZM73.22,58.47Q58,43.19,42.73,28c-2.54-2.51-5.56-4.05-9.32-3.6a10,10,0,0,0-8.62,6.51c-1.88,4.84-.18,9,3.37,12.54Q42.89,58.15,57.62,72.85a17.21,17.21,0,0,0,3.92,3c6.88,3.72,15.59-1.69,15.34-9.46A12.06,12.06,0,0,0,73.22,58.47Zm110.84,130.9c-2.15,4.76-.82,9,2.74,12.64,10,10.1,20,20.23,30.2,30.18,5.08,5,11.64,5.05,15.87.65s3.91-10.71-1.17-15.89c-9.75-9.91-19.64-19.68-29.47-29.52a12.73,12.73,0,0,0-8.82-4.15C189.23,183.51,185.85,185.42,184.06,189.37ZM77,29.5c0,5-.12,9.92,0,14.88.2,7,4.23,11.36,10.38,11.42S98,51.42,98.09,44.59q.25-15.14,0-30.26C98,7.57,93.34,2.93,87.39,3c-5.79.1-10.09,4.57-10.32,11.08-.19,5.12,0,10.25,0,15.38ZM44.21,98.34c6.86-.2,11.35-4.47,11.37-10.54s-4.33-10.39-11.3-10.51c-9.92-.17-19.84-.15-29.75,0-7.1.1-11.89,4.64-11.74,10.7S7.58,98.16,14.46,98.34c4.79.13,9.58,0,14.38,0C34,98.37,39.09,98.49,44.21,98.34Z" style="fill:#030303"/></svg>
                            <span class="flex section-card-title bold mt8">{{ __('REALTIME USERS') }}</span>
                            <span class="flex fs20 bold unselectable">{{ $online_users }}</span>
                        </div>
                        <div class="dashboard-statistics-record-wrapper" style="margin: 0 20px">
                            <svg class="size28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.27,248V31.14c3.12-6.17,8.38-8,14.92-7.72,6.74.24,13.51-.29,20.22.16,5.86.39,10.24-.44,12.52-6.79,1.27-3.54,4.62-5.89,7.59-8.27,3.87-3.09,8.69-4.1,13.06-6.1H81.47c7.87,2.52,16.34,5.35,19.88,13.07,3.73,8.14,9.39,8.68,16.49,8a6.19,6.19,0,0,1,1.49,0c7.1,1,12.38-.2,16-7.85S147.18,5.27,154.73,2.42h10.89c10,2.78,18.57,7.57,23.1,17.38,1.47,3.19,3.3,3.76,6.39,3.73,15.35-.13,30.69-.07,46-.06,10.91,0,14.56,3.64,14.56,14.44q0,101.75,0,203.47c0,11.06-3.46,14.55-14.43,14.55q-112.35,0-224.69.08C10,256,5.1,254.14,2.27,248Zm127-150.53c-33.81,0-67.62.07-101.43-.09-3.69,0-4.64.85-4.63,4.59q.23,64.09,0,128.19c0,4.14,1.36,4.78,5,4.78q100.7-.15,201.38,0c4.18,0,5.14-1.14,5.12-5.2q-.23-63.6,0-127.2c0-4-.8-5.22-5-5.19C196.24,97.57,162.76,97.48,129.28,97.48Zm-.43-21c33.82,0,67.63,0,101.44.07,3.4,0,4.58-.79,4.46-4.35-.27-7.75-.29-15.52,0-23.26.14-3.71-1.31-4.29-4.55-4.23-11.05.17-22.1.23-33.15,0-4.3-.1-7.57.17-9.06,5.12-.67,2.21-2.65,4.15-4.32,5.94a30.47,30.47,0,0,1-22.37,10,10.44,10.44,0,0,1-11-9.74c-.44-5.46,3.14-9.78,9.08-11,1.3-.26,2.59-.52,3.86-.85a9.56,9.56,0,0,0,7.46-7.63A9.75,9.75,0,0,0,167.07,26c-6.13-4.9-14.58-1.78-16.49,6.06-2.71,11.12-4.72,12.7-16.23,12.7-7.92,0-15.84.15-23.75-.07-3.17-.09-4.86.74-6.41,3.77C98.65,59.29,89.46,65,77.31,65.68,71,66,66.22,61.75,65.74,55.92c-.44-5.25,3.38-9.74,9.22-11a26.6,26.6,0,0,0,6.11-1.72A10.13,10.13,0,0,0,86.3,31.52a10.82,10.82,0,0,0-10.16-7.94c-5,0-9,3.52-10.28,9C63.5,42.92,61.27,44.72,50.79,44.73c-7.75,0-15.51.19-23.25-.08-3.6-.13-4.42,1.12-4.31,4.48.24,7.41.33,14.86,0,22.26-.21,4.19,1.11,5.17,5.19,5.14C61.88,76.37,95.37,76.44,128.85,76.44Zm46.38,53.75c-5.3-2.31-10-.46-14.09,5.64-10.34,15.45-20.78,30.83-30.83,46.47-2.58,4-3.88,3.7-6.8.52-5.57-6.06-11.53-11.77-17.42-17.53-5.53-5.4-11.64-5.8-16.19-1.26-4.39,4.4-4,10.83,1.3,16.15q14.6,14.77,29.36,29.37c6.15,6.07,13.11,5.49,17.88-1.62,13.58-20.21,27-40.5,40.52-60.78,1.46-2.2,2.74-4.5,2.65-6.17C181.51,135.28,179.41,132,175.23,130.19Z" style="fill:#010101"/></svg>
                            <span class="flex section-card-title bold mt8">{{ __('VISITORS') }}</span>
                            <span id="open-visitors-viewer" class="flex fs20 bold blue unselectable pointer dashboard-visitors-count">{{ $today_visitors }}</span>
                        </div>
                        <div class="dashboard-statistics-record-wrapper">
                            <svg class="size28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.56,208.74c2.19-2.66,1.75-6.06,2.5-9.12,8.33-33.47,28-57.51,59.42-71.91.6-.27,1.16-.62,2.14-1.16l-3.43-3.85a58,58,0,0,1-7.9-66c11.25-21,35.61-33.52,58.42-30,25,3.84,44.33,21.88,49.21,45.9,7.2,35.44-19.74,68.66-56.12,69.21C68,142.44,35.06,169.14,28,206.19c-.7,3.71-.29,4.6,3.65,4.57,24.61-.18,49.23-.12,73.84-.07,7.46,0,12.31,4.4,12.51,11s-4.32,11.56-11.15,11.76c-7.22.22-14.44.09-21.66.09-22.15,0-44.31-.21-66.45.13-7,.1-12-2-15.2-8.19ZM72.41,84.82A34.39,34.39,0,0,0,106.94,119c18.82-.12,34.4-15.92,34.18-34.65a34.36,34.36,0,1,0-68.71.46Z" style="fill:#020202"/><path d="M168.47,187.81c-5.09,0-10.18.14-15.26,0-7.13-.23-11.8-4.67-12-11.09-.2-6.7,4.34-11.64,11.67-11.85,10.17-.3,20.35-.2,30.51-.05,2.83.05,3.56-.83,3.52-3.57-.16-9.68-.11-19.36,0-29,0-8,4.57-13.11,11.49-13.13s11.37,5,11.45,13.08c.09,9.68.11,19.36,0,29-.05,2.77.78,3.66,3.58,3.62,9.84-.15,19.69-.21,29.53,0,9.67.2,15.42,8.21,11.76,16.14-2.34,5.07-6.64,6.93-12,6.91-9.68,0-19.36.12-29-.07-3-.06-3.91.79-3.85,3.83.19,9.51.13,19,.05,28.55-.06,8.49-4.48,13.47-11.65,13.35-6.93-.11-11.25-5.15-11.29-13.3-.05-9.35-.16-18.71.07-28.05.08-3.31-.57-4.67-4.21-4.4C178,188.08,173.22,187.82,168.47,187.81Z" style="fill:#040404"/></svg>
                            <span class="flex section-card-title bold mt8">{{ __('NEW SIGNUPS') }}</span>
                            <span id="open-newsignups-viewer" class="flex fs20 bold blue unselectable pointer dashboard-signups-count">{{ $today_signups }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="block fs11 blue bold mb8">{{ __('RESOURCES STATISTICS') }}</span>
                    <div>
                        <div class="my8">
                            <div class="flex align-center">
                                <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,17.11h97.27c11.82,0,15.64,3.73,15.64,15.34q0,75.07,0,150.16c0,11.39-3.78,15.13-15.22,15.13-2.64,0-5.3.12-7.93-.06a11.11,11.11,0,0,1-10.53-9.38c-.81-5.69,2-11,7.45-12.38,3.28-.84,3.52-2.36,3.51-5.06-.07-27.15-.11-54.29,0-81.43,0-3.68-1-4.69-4.68-4.68q-85.63.16-171.29,0c-3.32,0-4.52.68-4.5,4.33q.26,41,0,81.95c0,3.72,1.3,4.53,4.56,4.25a45.59,45.59,0,0,1,7.39.06,11.06,11.06,0,0,1,10.58,11c0,5.62-4.18,10.89-9.91,11.17-8.43.4-16.92.36-25.36,0-5.16-.23-8.82-4.31-9.68-9.66a33,33,0,0,1-.24-5.27q0-75.08,0-150.16c0-11.61,3.81-15.34,15.63-15.34Zm22.49,45.22c16.56,0,33.13,0,49.7,0,5.79,0,13.59,2,16.83-.89,3.67-3.31.59-11.25,1.19-17.13.4-3.92-1.21-4.54-4.73-4.51-19.21.17-38.42.08-57.63.08-22.73,0-45.47.11-68.21-.1-4,0-5.27,1-4.92,5a75.62,75.62,0,0,1,0,12.68c-.32,3.89.78,5,4.85,5C110.54,62.21,131.51,62.33,152.49,62.33ZM62.3,51.13c0-11.26,0-11.26-11.45-11.26h-.53c-10.47,0-10.47,0-10.47,10.71,0,11.75,0,11.75,11.49,11.75C62.3,62.33,62.3,62.33,62.3,51.13ZM102,118.66c25.79.3,18.21-2.79,36.49,15.23,18.05,17.8,35.89,35.83,53.8,53.79,7.34,7.35,7.3,12.82-.13,20.26q-14.94,15-29.91,29.87c-6.86,6.81-12.62,6.78-19.5-.09-21.3-21.28-42.53-42.64-63.92-63.84a16.11,16.11,0,0,1-5.24-12.62c.23-9.86,0-19.73.09-29.59.07-8.71,4.24-12.85,13-13C91.81,118.59,96.92,118.66,102,118.66ZM96.16,151c.74,2.85-1.53,6.66,1.41,9.6,17.66,17.71,35.39,35.36,53,53.11,1.69,1.69,2.59,1.48,4.12-.12,4.12-4.34,8.24-8.72,12.73-12.67,2.95-2.59,2.36-4-.16-6.49-15.68-15.46-31.4-30.89-46.63-46.79-4.56-4.76-9.1-6.73-15.59-6.35C96.18,141.8,96.16,141.41,96.16,151Z"></path></svg>
                                <span class="flex lblack bold fs13">{{ __('Threads') }} : <span class="ml4 black fs14 dashboard-threads-count" style="margin-top: -1px">{{ $todaythreads }}</span></span>
                            </div>
                        </div>
                        <div class="my8">
                            <div class="flex align-center">
                                <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" fill="#1c1c1c" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"></path></svg>
                                <span class="flex lblack bold fs13">{{ __('Replies') }} : <span class="ml4 black fs14 dashboard-posts-count" style="margin-top: -1px">{{ $todayposts }}</span></span>
                            </div>
                        </div>
                        <div class="my8">
                            <div class="flex align-center">
                                <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path class="up-vote " d="M10.11,66.39c-4.06,0-7.63-2.06-9.09-5.25a6.9,6.9,0,0,1,1.21-7.62L42.11,7.29A10.25,10.25,0,0,1,50,3.92a10.28,10.28,0,0,1,7.87,3.37L97.8,53.5A6.92,6.92,0,0,1,99,61.13c-1.47,3.18-5,5.24-9.08,5.24H75.74V55.77h4.42a1.83,1.83,0,0,0,1.67-1A1.61,1.61,0,0,0,81.57,53L51.39,18A1.9,1.9,0,0,0,48.61,18L18.42,53a1.61,1.61,0,0,0-.26,1.75,1.83,1.83,0,0,0,1.67,1h4.26V66.39Zm58.1,29.69a7.56,7.56,0,0,0,7.53-7.58V55.78H63.89v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58Z" style="fill:#010202"></path></svg>
                                <span class="flex lblack bold fs13">{{ __('Votes') }} : <span class="ml4 black fs14 dashboard-votes-count" style="margin-top: -1px">{{ $todayvotes }}</span></span>
                            </div>
                        </div>
                        <div class="my8">
                            <div class="flex align-center">
                                <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84"><path class="grey-like " d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:60px"></path></svg>
                                <span class="flex lblack bold fs13">{{ __('Likes') }} : <span class="ml4 black fs14 dashboard-likes-count" style="margin-top: -1px">{{ $todaylikes }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="block fs11 bold blue mb8">{{ __('OTHERS') }}</span>
                    <div class="my8">
                        <div>
                            <div class="flex align-center">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM397.4,397.4A200,200,0,1,1,114.6,114.6,200,200,0,1,1,397.4,397.4ZM336,224a32,32,0,1,0-32-32A32,32,0,0,0,336,224Zm-160,0a32,32,0,1,0-32-32A32,32,0,0,0,176,224Zm194.4,64H141.6a13.42,13.42,0,0,0-13.5,15c7.5,59.2,58.9,105,121.1,105h13.6c62.2,0,113.6-45.8,121.1-105a13.42,13.42,0,0,0-13.5-15Z"/></svg>
                                <span class="flex lblack bold fs13">{{ __('Emojis') }}</span>
                            </div>
                            <div class="flex align-center mt4">
                                <svg class="size12 mx8" fill="#868686" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                                <div class="flex align-center mx4">
                                    <div class="flex flex-column align-center">
                                        <span class="fs10 mb2 bold dashboard-emoji-sad-count">{{ $emojisresult['sad'] }}</span>
                                        <svg class="mx4 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448C145.7,456,56,366.3,56,256S145.7,56,256,56s200,89.7,200,200S366.3,456,256,456Zm8-152a24,24,0,0,0,0,48,80.17,80.17,0,0,1,61.6,28.8,24,24,0,1,0,36.9-30.7A128.11,128.11,0,0,0,264,304Zm-88-64a32,32,0,1,0-32-32A32,32,0,0,0,176,240Zm160-64a32,32,0,1,0,32,32A32,32,0,0,0,336,176ZM170.4,274.8C159,290.1,134,325.4,134,342.9c0,22.7,18.8,41.1,42,41.1s42-18.4,42-41.1c0-17.5-25-52.8-36.4-68.1a7,7,0,0,0-11.2,0Z"/></svg>
                                    </div>
                                </div>
                                <div class="flex align-center mx4">
                                    <div class="flex flex-column align-center">
                                        <span class="fs10 mb2 bold dashboard-emoji-sceptic-count">{{ $emojisresult['sceptic'] }}</span>
                                        <svg class="mx4 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448C145.7,456,56,366.3,56,256S145.7,56,256,56s200,89.7,200,200S366.3,456,256,456ZM176,240a32,32,0,1,0-32-32A32,32,0,0,0,176,240Zm160-64a32,32,0,1,0,32,32A32,32,0,0,0,336,176ZM256,304a134.84,134.84,0,0,0-103.8,48.6,24,24,0,0,0,36.9,30.7,87,87,0,0,1,133.8,0,24,24,0,1,0,36.9-30.7A134.84,134.84,0,0,0,256,304Z"/></svg>
                                    </div>
                                </div>
                                <div class="flex align-center mx4">
                                    <div class="flex flex-column align-center">
                                        <span class="fs10 mb2 bold dashboard-emoji-soso-count">{{ $emojisresult['so-so'] }}</span>
                                        <svg class="mx4 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448C145.7,456,56,366.3,56,256S145.7,56,256,56s200,89.7,200,200S366.3,456,256,456ZM176,240a32,32,0,1,0-32-32A32,32,0,0,0,176,240Zm160-64a32,32,0,1,0,32,32A32,32,0,0,0,336,176Zm8,144H168a24,24,0,0,0,0,48H344a24,24,0,0,0,0-48Z"/></svg>
                                    </div>
                                </div>
                                <div class="flex align-center mx4">
                                    <div class="flex flex-column align-center">
                                        <span class="fs10 mb2 bold dashboard-emoji-happy-count">{{ $emojisresult['happy'] }}</span>
                                        <svg class="mx4 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448C145.7,456,56,366.3,56,256S145.7,56,256,56s200,89.7,200,200S366.3,456,256,456ZM176,240a32,32,0,1,0-32-32A32,32,0,0,0,176,240Zm160,0a32,32,0,1,0-32-32A32,32,0,0,0,336,240Zm4,72.6a109.24,109.24,0,0,1-168,0,24,24,0,0,0-36.9,30.7,157.42,157.42,0,0,0,241.8,0A24,24,0,1,0,340,312.6Z"/></svg>
                                    </div>
                                </div>
                                <div class="flex align-center mx4">
                                    <div class="flex flex-column align-center">
                                        <span class="fs10 mb2 bold dashboard-emoji-veryhappy-count">{{ $emojisresult['veryhappy'] }}</span>
                                        <svg class="mx4 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM397.4,397.4A200,200,0,1,1,114.6,114.6,200,200,0,1,1,397.4,397.4ZM336,224a32,32,0,1,0-32-32A32,32,0,0,0,336,224Zm-160,0a32,32,0,1,0-32-32A32,32,0,0,0,176,224Zm194.4,64H141.6a13.42,13.42,0,0,0-13.5,15c7.5,59.2,58.9,105,121.1,105h13.6c62.2,0,113.6-45.8,121.1-105a13.42,13.42,0,0,0-13.5-15Z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my8">
                        <div class="flex align-center">
                            <svg class="size16 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M128,132,57.22,238.11,256,470,454.78,238.11,384,132Zm83,90H104l35.65-53.49Zm-30-60H331l-75,56.25Zm60,90V406.43L108.61,252Zm30,0H403.39L271,406.43Zm30-30,71.32-53.49L408,222ZM482,72V42H452V72H422v30h30v30h30V102h30V72ZM60,372H30v30H0v30H30v30H60V432H90V402H60ZM0,282H30v30H0Zm482-90h30v30H482Z"/></svg>
                            <span class="flex lblack bold fs13">{{ __('Feedbacks') }} : <span class="ml4 black fs14 dashboard-feedbackmessages-count" style="margin-top: -1px">{{ $todayfeedbacks }}</span></span>
                        </div>
                    </div>
                    <div class="my8">
                        <div class="flex align-center">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                            <span class="flex lblack bold fs13">{{ __('Contact messages') }} : <span class="ml4 black fs14 dashboard-contactmessages-count" style="margin-top: -1px">{{ $todaycmessages }}</span></span>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="block fs11 bold blue mb8 opacity0 default-cursor">others</span>
                    <div>
                        <div class="my8">
                            <div class="flex align-center my8">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M42.63,256.9c-6.13-2.82-8-7.72-8-14.28q.2-112.38.08-224.77A19.71,19.71,0,0,1,35.48,11,10.49,10.49,0,0,1,46.2,4a10.09,10.09,0,0,1,9.23,8.82,83,83,0,0,1,.24,12.32c-.13,2.76.76,4.1,3.39,5,20.76,7.23,41.37,7.51,61.38-2.13,17.11-8.25,34.6-14.22,53.91-13.41A107.44,107.44,0,0,1,217.51,25.5c4.82,2.35,7,6,7,11.39-.06,34.25,0,68.51,0,102.76,0,9.87-7.5,14.49-16.48,10.29-24.26-11.36-48.53-12-72.64.19-24.91,12.6-50.63,15.48-77.46,7.37a13.42,13.42,0,0,0-2.16-.25v59.92c0,8.73-.23,17.47.07,26.18.23,6.54-2.19,11.05-8.24,13.55ZM55.74,51.26c0,27.25.06,53.91-.07,80.58,0,3.43,2.43,3.58,4.41,4.25,21,7.11,41.62,6.67,61.83-3,4.88-2.33,9.76-4.74,14.82-6.63a97,97,0,0,1,62.43-2.26c3.18.93,4.45.7,4.42-3.24-.18-25-.13-50.05,0-75.07,0-2.66-.56-4.15-3.3-5.07a95.09,95.09,0,0,0-28-5.27c-15.06-.36-28.72,4.53-41.94,11.12a93.58,93.58,0,0,1-28.11,8.64C86.65,57.68,71.41,56.07,55.74,51.26Z" style="fill:#010101"/></svg>
                                <span class="flex lblack bold fs13">{{ __('Resources Reports') }} : <span class="ml4 black fs14 dashboard-reports-count" style="margin-top: -1px">{{ $todayreports }}</span></span>
                            </div>
                            <div class="flex my8">
                                <svg class="size14 mr4" style="margin-top: 1px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M231,130.52c0,16.59-.13,33.19.06,49.78.08,6.24-2.44,10.4-7.77,13.46q-43.08,24.72-86,49.68c-5.52,3.21-10.45,3-16-.2Q78.8,218.46,36.1,194.09c-5.91-3.37-8.38-7.8-8.34-14.61q.3-49,0-98.1c0-6.63,2.49-10.93,8.2-14.19Q78.68,42.82,121.15,18c5.69-3.32,10.69-3.42,16.38-.1Q180,42.71,222.7,67.1c5.89,3.36,8.46,7.8,8.35,14.61C230.77,98,231,114.25,231,130.52Zm-179.67,0c0,44.84,33,78,77.83,78.16s78.37-33.05,78.39-78.08c0-44.88-32.93-78-77.83-78.14S51.32,85.49,51.29,130.55Z" style="fill:#020202"></path><path d="M129.35,150.13c-13.8,0-27.61,0-41.42,0-8.69,0-13.85-6-13.76-15.79.09-9.62,5.15-15.43,13.6-15.44q40,0,79.93,0c13.05,0,19,7.43,16.37,20.38-1.46,7.17-5.92,10.85-13.29,10.86C157,150.15,143.16,150.13,129.35,150.13Z" style="fill:#020202"></path></svg>
                                <div>
                                    <span class="flex lblack bold fs13">{{ __('Authorization breaks') }} : <span class="ml4 black fs14 dashboard-authbreaks-count">{{ $todayunauthoritylogs }}</span></span>
                                    <span id="open-auth-breaks-viewer" class="fs12 bold blue pointer flex">review all</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex" style="margin-top: 10px">
            <div id="visits-box" class="section-card y-auto-overflow" style="flex: 1; max-height: 306px; margin-right: 10px;">
                <style>
                    table td, table th {
                        border: 1px solid #c6c6c6;
                    }
                </style>
                <div class="flex align-center" style="margin-bottom: 10px">
                    <div class="flex align-center">
                        <svg class="size16 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.55,60.69c8,0,16,.06,24-.13,2.82-.06,4.05.4,3.92,3.66-.28,7-.16,14,0,21.08,0,2.19-.38,3.24-2.91,3.17-8.33-.22-16.66-.22-25-.3Z"/><path d="M3.55,116.64c8.16,0,16.33,0,24.49-.17,2.35,0,3.51.34,3.43,3.13q-.3,10.79,0,21.57c.08,2.79-1.08,3.17-3.43,3.13-8.16-.15-16.33-.13-24.49-.17Z"/><path d="M3.55,172.6c8.32-.09,16.65-.08,25-.3,2.53-.07,2.94,1,2.91,3.17-.1,7.19-.17,14.39,0,21.58.07,2.76-1,3.18-3.41,3.14-8.17-.13-16.34-.09-24.51-.11Z"/><path d="M59.5,256c0-8,.07-16-.12-24-.07-2.82.39-4,3.65-3.92,7,.29,14,.16,21.08,0,2.19,0,3.24.39,3.17,2.92-.22,8.32-.21,16.65-.3,25Z"/><path d="M115.45,256c0-8.17,0-16.33-.17-24.5,0-2.35.34-3.5,3.13-3.43q10.78.31,21.57,0c2.79-.07,3.17,1.08,3.13,3.43-.15,8.17-.13,16.33-.17,24.5Z"/><path d="M171.41,256c-.09-8.33-.08-16.66-.3-25-.07-2.53,1-2.95,3.17-2.92,7.19.11,14.39.17,21.57,0,2.77-.08,3.19,1,3.15,3.4-.14,8.17-.09,16.35-.11,24.52Z"/><path d="M3.55,228.55c8.43-.86,16.89-.12,25.34-.39,1.88-.06,2.6.65,2.53,2.54-.27,8.44.47,16.9-.39,25.34H25.14c-.53-1.53-2.07-1.38-3.19-1.8A28.18,28.18,0,0,1,6.41,240.33c-1-1.94-.77-4.49-2.86-5.89Z" style="fill:#020202"/><path d="M3.55,26.33c2.28-1.85,2.18-4.87,3.57-7.21,4.71-8,11.59-12.5,20.6-14.11,2.58-.46,3.86-.12,3.76,3-.23,7.16-.1,14.34-.05,21.51,0,1.8-.09,3.16-2.52,3.07-8.45-.31-16.92.46-25.36-.4Z" style="fill:#020202"/><path d="M227.36,256c-.86-8.44-.1-16.91-.4-25.36-.09-2.41,1.24-2.53,3-2.52,7.17,0,14.34.16,21.51,0,3.08-.09,3.42,1.09,3.07,3.73a27.46,27.46,0,0,1-21.88,23.24c-.67.12-1.26.17-1.42,1Z" style="fill:#020202"/><path d="M3.55,234.44c2.09,1.4,1.84,3.95,2.86,5.89A28.18,28.18,0,0,0,22,254.24c1.12.42,2.66.27,3.19,1.8-6.38,0-12.76-.12-19.14.06-2.12.06-2.58-.4-2.52-2.52C3.66,247.21,3.55,240.82,3.55,234.44Z" style="fill:#fafafa"/><path d="M59.44,130.39c0-21.92.06-43.84-.07-65.76,0-3.07.61-4.1,3.94-4.09q66,.18,132,0c3.13,0,3.72.91,3.71,3.83q-.14,66,0,132c0,2.9-.54,3.85-3.69,3.85q-66-.18-132,0c-3.3,0-4-1-4-4.08C59.5,174.23,59.44,152.31,59.44,130.39Zm27.79-.53c0,12.75.13,25.49-.08,38.23-.06,3.5,1,4.35,4.4,4.33q37.74-.19,75.48,0c3.1,0,4.22-.65,4.2-4q-.21-38,0-76c0-3.27-1-4.09-4.14-4.08-25.16.12-50.32.17-75.48,0-3.93,0-4.51,1.34-4.45,4.78C87.35,105.35,87.23,117.61,87.23,129.86Z"/><path d="M73.26,4.74c3.75,0,7.51.1,11.25,0,2.13-.09,2.8.6,2.77,2.74-.12,7.5-.08,15,0,22.51,0,1.73-.32,2.69-2.38,2.67q-11.49-.13-23,0c-2,0-2.49-.69-2.47-2.55.07-7.66.09-15.33,0-23,0-2.06.85-2.42,2.61-2.37C65.76,4.8,69.51,4.74,73.26,4.74Z"/><path d="M115.32,18.62c0-3.59.18-7.18-.06-10.75-.18-2.69.87-3.23,3.32-3.19,7.17.15,14.34.14,21.51,0,2.31-.05,3.08.57,3,3q-.23,11,0,22c0,2.4-.77,3-3.07,3q-11-.18-22,0c-2.13,0-2.86-.64-2.77-2.77C115.43,26.12,115.32,22.37,115.32,18.62Z"/><path d="M184.65,32.59c-3.59,0-7.18-.11-10.76,0-2.16.08-2.8-.7-2.77-2.8.1-7.5.13-15,0-22.51C171.06,5,172,4.68,174,4.7c7.33.09,14.67.13,22,0,2.36,0,3,.66,3,3-.15,7.34-.17,14.68,0,22,.06,2.52-.87,3-3.11,2.93C192.16,32.47,188.4,32.59,184.65,32.59Z"/><path d="M240.61,88c-4.37,0-10.09,1.68-12.73-.45S227.19,79.36,227,75c-.15-3.74.13-7.51-.09-11.25-.15-2.66.87-3.25,3.34-3.2,7.17.15,14.35.13,21.52,0,2.21,0,3.16.38,3.11,2.89-.17,7.34-.16,14.68,0,22,.05,2.4-.68,3.1-3,3-3.74-.19-7.5,0-11.25,0Z"/><path d="M254.84,130.87c0,3.42-.18,6.86.06,10.26.18,2.7-.87,3.23-3.33,3.18q-10.5-.23-21,0c-2.61.06-3.72-.49-3.63-3.41.21-7,.21-14,0-21-.09-2.92,1-3.48,3.63-3.42q10.5.23,21,0c2.45,0,3.5.47,3.33,3.17C254.66,123.36,254.84,127.12,254.84,130.87Z"/><path d="M241.78,172.35c3.71.38,9.7-1.95,12.28.88,2.23,2.44.74,8.35.76,12.72,0,4.54,1.61,10.61-.68,13.23-2.64,3-8.85.78-13.51.92-4.36.12-10.24,1.5-12.72-.72-2.86-2.57-.71-8.55-.89-13-.15-3.74.07-7.5-.07-11.25-.08-2.15.69-2.84,2.8-2.77C233.5,172.45,237.25,172.35,241.78,172.35Z"/><path d="M239.83,32.59c-3.59-.34-9.25,1.87-12-.78s-.68-8.35-.85-12.7c-.14-3.75.14-7.52-.08-11.26C226.77,5,228,4.68,230.39,5c12.12,1.36,22.68,11.9,24.23,24.09.36,2.86-.39,3.76-3.24,3.59C247.8,32.43,244.19,32.59,239.83,32.59Z" style="fill:#020202"/></svg>
                        <span class="bold">{{ __('Top links visited') }}</span>
                    </div>
                    <div class="relative" style="margin-left: 10px">
                        <div class="flex align-center pointer button-with-suboptions">
                            <p class="no-margin lblack mr4 fs11">Date filter: <span class="bold fs12" id="visits-filter-selection-name">Today</span></p>
                            <svg class="size7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                        </div>
                        <div class="suboptions-container thread-add-suboptions-container" style="right: 0">
                            <div class="pointer no-underline thread-add-suboption visits-links-filter vlf-selected">
                                <div class="flex align-center">
                                    <p class="no-margin bold forum-color">{{ __('Today') }}</p>
                                    <svg class="spinner size12 opacity0 ml4" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <p class="no-margin fs12 gray">{{ __('Statistics of today') }}</p>
                                <input type="hidden" class="filter" value="today">
                                <input type="hidden" class="filter-name" value="Today">
                            </div>
                            <div class="pointer no-underline thread-add-suboption visits-links-filter">
                                <div class="flex align-center">
                                    <p class="no-margin bold forum-color">{{ __('This week') }}</p>
                                    <svg class="spinner size12 opacity0 ml4" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <p class="no-margin fs12 gray">{{ __('Statistics of the past 7 days') }}</p>
                                <input type="hidden" class="filter" value="lastweek">
                                <input type="hidden" class="filter-name" value="Last 7 days">
                            </div>
                            <div class="pointer no-underline thread-add-suboption visits-links-filter">
                                <div class="flex align-center">
                                    <p class="no-margin bold forum-color">{{ __('This month') }}</p>
                                    <svg class="spinner size12 opacity0 ml4" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <p class="no-margin fs12 gray">{{ __('Statistics of the past 30 days') }}</p>
                                <input type="hidden" class="filter" value="lastmonth">
                                <input type="hidden" class="filter-name" value="Last 30 days">
                            </div>
                        </div>
                    </div>
                </div>
                <table id="visits-table">
                    <tr>
                        <th class="lblack full-width">
                            <div class="flex align-center">
                                <svg class="mx8 size13" fill="#1c1c1c" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M326.61,185.39A151.92,151.92,0,0,1,327,400l-.36.37-67.2,67.2c-59.27,59.27-155.7,59.26-215,0s-59.27-155.7,0-215l37.11-37.1c9.84-9.84,26.78-3.3,27.29,10.6a184.45,184.45,0,0,0,9.69,52.72,16.08,16.08,0,0,1-3.78,16.61l-13.09,13.09c-28,28-28.9,73.66-1.15,102a72.07,72.07,0,0,0,102.32.51L270,343.79A72,72,0,0,0,270,242a75.64,75.64,0,0,0-10.34-8.57,16,16,0,0,1-6.95-12.6A39.86,39.86,0,0,1,264.45,191l21.06-21a16.06,16.06,0,0,1,20.58-1.74,152.65,152.65,0,0,1,20.52,17.2ZM467.55,44.45c-59.26-59.26-155.69-59.27-215,0l-67.2,67.2L185,112A152,152,0,0,0,205.91,343.8a16.06,16.06,0,0,0,20.58-1.73L247.55,321a39.81,39.81,0,0,0,11.69-29.81,16,16,0,0,0-6.94-12.6A75,75,0,0,1,242,270a72,72,0,0,1,0-101.83L309.16,101a72.07,72.07,0,0,1,102.32.51c27.75,28.3,26.87,73.93-1.15,102l-13.09,13.09a16.08,16.08,0,0,0-3.78,16.61,184.45,184.45,0,0,1,9.69,52.72c.5,13.9,17.45,20.44,27.29,10.6l37.11-37.1c59.27-59.26,59.27-155.7,0-215Z"/></svg>
                                <span>visited links</span> <span class="normal-weight fs12 gray ml4">(ordered by most popular)</span>
                            </div>
                        </th>
                        <th class="lblack">hits</th>
                    </tr>
                    @foreach($visits as $visit)
                    <tr class="visit-row">
                        <td class="lblack">{{ $visit->url }}</td>
                        <td class="lblack bold">{{ $visit->hits }}</td>
                    </tr>
                    @endforeach
                    <tr id="visits-fetch-more" class="@if(!$visits_hasmore) none no-fetch @endif">
                        <td colspan="2">
                            <input type="hidden" class="current-filter" value="today" autocomplete="off">
                            <div class="full-center">
                                <svg class="spinner size16" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                        </td>
                    </tr>
                    <tr id="visits-empty" class="@if(count($visits)) none @endif">
                        <td colspan="2">
                            <div class="full-center">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="bold lblack fs12">No visits for the selected date filter. Select an older one</p>
                            </div>
                        </td>
                    </tr>
                    <tr class="visit-row visit-row-skeleton none">
                        <td class="lblack visit-url"></td>
                        <td class="lblack bold visit-hits"></td>
                    </tr>
                </table>
                
            </div>
            <div class="section-card y-auto-overflow" style="flex: 1; max-height: 306px">
                <link rel="stylesheet" href="{{ asset('css/admin/contactmessages.css') }}">
                <div class="flex space-between">
                    <div class="flex align-center" style="margin-bottom: 10px">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                        <span class="bold flex align-center">{{ __('Contact messages') }} <span class="fs11 gray ml4">({{ $unreadmessages }} unread)</span></span>
                    </div>
                    <a href="{{ route('admin.contactmessages') }}" class="blue bold no-underline mr8">{{ __('see all') }}</a>
                </div>
                <div>
                    @foreach($contactmessages as $message)
                        <x-admin.contactmessage.cmessage :message="$message" :onlymessage="true" :data="['canread'=>true, 'candelete'=>true]"/>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@endsection