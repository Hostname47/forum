<div id="admin-left-panel" class="fs13 flex flex-column">
    <style>
        .admin-left-panel-button {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }
    </style>
    <div class="full-center" style="margin-bottom: 12px">
        <a href="/admin/dashboard">
            <div class="flex align-center">
                <img src='{{ asset("assets/images/logos/header-logo.png") }}' alt="logo" style="height: 57px; margin: 0 4px 0 0;" id="header-logo">
                <img src='{{ asset("assets/images/logos/admin-panel.png") }}' alt="logo" style="height: 50px; margin: 0;" id="header-logo">
            </div>
        </a>

    </div>
    <style>
        .current-admin-profile-container {
            display: flex;
            width: calc(100% + 12px);
            margin-left: -12px;
            padding: 12px 6px;
            box-sizing: border-box;
            background-color: #14191e;
        }
    </style>
    <div class="current-admin-profile-container relative">
        <img src="{{ auth()->user()->sizedavatar(100, '-h') }}" class="flex size40 rounded" alt="">
        <div class="ml8">
            <div class="flex align-center">
                <h3 class="no-margin">{{ auth()->user()->fullname }}</h3>
                <span class="mx4 fs10">-</span>
                <span class="bold fs11" style="color: #6ed6ff">{{ auth()->user()->high_role()->role }}</span>
            </div>
            <span class="block fs12">{{ auth()->user()->username }}</span>
            <div class="relative admin-status-set-box mt2">
                @php
                    $status = auth()->user()->adminstatus();
                @endphp
                <!-- select admin status -->
                <div class="flex align-center button-with-suboptions width-max-content pointer">
                    <div class="selected-admin-status-icon flex mr4" style="min-width: 8px;">
                        <svg class="size8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">{!! $status['icon'] !!}</svg>
                    </div>
                    <span class="fs10 unselectable selected-admin-status-name">{{ $status['name'] }}</span>
                    <svg class="size5 ml4" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"></path></svg>
                </div>
                <!-- status container -->
                <div id="user-status-suboptions" class="suboptions-container typical-suboptions-container">
                    <div class="typical-suboption flex align-center set-admin-status">
                        <div class="relative size10 mr8" style="min-width: 10px;">
                            <svg class="flex status-icon size10" style="fill:#44ee6e;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M100,3a97,97,0,1,0,97,97A97,97,0,0,0,100,3Z"/></svg>
                            <svg class="spinner size10 opacity0 absolute" style="top: 0; left: 0;" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="fs11 bold unselectable status-name">Online</span>
                        <input type="hidden" class="admin-status" value="online" autocomplete="off">
                        <input type="hidden" class="success-message" value="Your account status has been set to <strong class='blue'>online</strong>" autocomplete="off">
                    </div>
                    <div class="typical-suboption flex align-center set-admin-status">
                        <div class="relative size10 mr8" style="min-width: 10px;">
                            <svg class="flex status-icon size10" style="fill:#f0ed0f;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M100,3a97,97,0,1,0,97,97A97,97,0,0,0,100,3Z"/></svg>
                            <svg class="spinner size10 opacity0 absolute" style="top: 0; left: 0;" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="fs11 bold unselectable status-name">Away</span>
                        <input type="hidden" class="admin-status" value="away" autocomplete="off">
                        <input type="hidden" class="success-message" value="Your account status has been set to <strong class='blue'>away</strong>" autocomplete="off">
                    </div>
                    <div class="typical-suboption flex align-center set-admin-status">
                        <div class="relative size10 mr8" style="min-width: 10px;">
                            <svg class="flex status-icon size10" style="fill:#ff6969;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M197,88.51c0-.36,0-.72-.05-1.08-.22-.76-.4-1.55-.55-2.35-1.75-4.22-2-8.88-3.37-13.23C179.36,28.49,135.38-.64,91.17,4.57c-47.5,5.6-84.28,43.56-87,89.79-2.77,47.09,28.11,89.29,73.34,100.48,2,.5,4.31.4,6.22,1.34.48.09.94.2,1.41.31a26.65,26.65,0,0,1,4.45.63c.88.07,1.75.16,2.6.31l.45,0a26.79,26.79,0,0,1,3.61.26h8.23a17.84,17.84,0,0,1,3-.26,19.87,19.87,0,0,1,3.17-.47,19.26,19.26,0,0,1,4.33-.75,14,14,0,0,1,4.36-.49,18.62,18.62,0,0,1,3-.44C160.51,185,184.75,161,195,122.66c.42-1.55.11-3.49.87-5a19.94,19.94,0,0,1,.83-7.4,20,20,0,0,1,.78-4.78v-14A27.7,27.7,0,0,1,197,88.51Zm-60.86,44.15c-7.73,8.59-21,15.65-32.81,15.65-13.09,0-24.26-3.87-34.27-12.14-9.76-8.06-14.46-20.57-15.65-32.81-1.15-11.79,4.34-25.61,12.14-34.27s21-15.65,32.81-15.65c13.09,0,24.26,3.87,34.27,12.14,9.76,8.06,14.46,20.57,15.65,32.81C149.46,110.18,144,124,136.17,132.66Z"/></svg>
                            <svg class="spinner size10 opacity0 absolute" style="top: 0; left: 0;" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="fs11 bold unselectable status-name">Busy</span>
                        <input type="hidden" class="admin-status" value="busy" autocomplete="off">
                        <input type="hidden" class="success-message" value="Your account status has been set to <strong class='blue'>busy</strong>" autocomplete="off">
                    </div>
                    <div class="typical-suboption flex set-admin-status">
                        <div class="relative size10 mr8 mt4" style="min-width: 10px;">
                            <svg class="flex status-icon size10" style="fill:#aaa;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M197,88.51c0-.36,0-.72-.05-1.08-.22-.76-.4-1.55-.55-2.35-1.75-4.22-2-8.88-3.37-13.23C179.36,28.49,135.38-.64,91.17,4.57c-47.5,5.6-84.28,43.56-87,89.79-2.77,47.09,28.11,89.29,73.34,100.48,2,.5,4.31.4,6.22,1.34.48.09.94.2,1.41.31a26.65,26.65,0,0,1,4.45.63c.88.07,1.75.16,2.6.31l.45,0a26.79,26.79,0,0,1,3.61.26h8.23a17.84,17.84,0,0,1,3-.26,19.87,19.87,0,0,1,3.17-.47,19.26,19.26,0,0,1,4.33-.75,14,14,0,0,1,4.36-.49,18.62,18.62,0,0,1,3-.44C160.51,185,184.75,161,195,122.66c.42-1.55.11-3.49.87-5a19.94,19.94,0,0,1,.83-7.4,20,20,0,0,1,.78-4.78v-14A27.7,27.7,0,0,1,197,88.51Zm-60.86,44.15c-7.73,8.59-21,15.65-32.81,15.65-13.09,0-24.26-3.87-34.27-12.14-9.76-8.06-14.46-20.57-15.65-32.81-1.15-11.79,4.34-25.61,12.14-34.27s21-15.65,32.81-15.65c13.09,0,24.26,3.87,34.27,12.14,9.76,8.06,14.46,20.57,15.65,32.81C149.46,110.18,144,124,136.17,132.66Z"/></svg>
                            <svg class="spinner size10 opacity0 absolute" style="top: 0; left: 0;" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="fs11 bold unselectable status-name">Appear offline</span>
                            <p class="fs10 no-margin unselectable">You will not appear online to other admins, but you will have full access to the panel.</p>
                        </div>
                        <input type="hidden" class="admin-status" value="appear-offline" autocomplete="off">
                        <input type="hidden" class="success-message" value="Your account status has been set to <strong class='blue'>offline</strong>" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>

        <!-- go to app -->
        <div class="flex align-center go-to-app">
            <svg class="size13 mr8" fill="#02070B" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
            <a href="{{ route('home') }}" target="_blank" class="flex no-underline" style="margin-top: 11px">
                <svg class="size13" fill="white" style="min-width: 13px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M102.56,37.42c36.05.8,66.59,16.09,89,47.05,7.47,10.3,7.64,22.42.1,32.65q-29.1,39.48-78,44.67c-28.56,3-55.19-2.41-79.15-18.83A105.7,105.7,0,0,1,8.11,116.91c-7-9.83-7.17-21.15-.36-31.17C30,53,61.49,38,102.56,37.42ZM103,58.29C69.89,58.67,44.61,69.85,26.24,95c-3.78,5.18-3.76,7,.21,11.94,21.29,26.57,49.47,37,82.76,34.33,26.73-2.14,48.57-13.77,64.86-35.4,2.57-3.4,2.69-6.21.16-9.73C156.1,71,131.35,58.82,103,58.29ZM124.28,100a24.3,24.3,0,1,0-24.15,24.34A24.19,24.19,0,0,0,124.28,100Z"/></svg>
                <span class="fs10 bold flex ml4" style="color: white;">go to live application</span>
            </a>
        </div>
    </div>
    <div style="margin-top: 30px; padding-left: 16px; color: rgb(223, 223, 223)">
        <div class="flex relative">
            <div class="flex align-center full-width relative">
                <a href="{{ route('admin.dashboard') }}" class="admin-panel-button @if($page == 'admin.dashboard') {{ 'bold blue admin-panel-button-focused' }} @endif unselectable">
                    <svg class="size15 mr8" fill="@if($page=='admin.dashboard') #2ca0ff @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"/></svg>
                    Dashboard
                </a>
            </div>
            @if($page == 'admin.dashboard')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="relative toggle-box @if($page=='admin.announcements') admin-panel-button-focused @endif">
            <div class="flex align-center full-width relative pointer toggle-container-button">
                <div class="admin-panel-button @if($page == 'admin.announcements') {{ 'bold white' }} @endif unselectable">
                    <svg class="size15 mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M497,241H452a15,15,0,0,0,0,30h45a15,15,0,0,0,0-30Zm-19.39,94.39-30-30a15,15,0,0,0-21.22,21.22l30,30a15,15,0,0,0,21.22-21.22Zm0-180a15,15,0,0,0-21.22,0l-30,30a15,15,0,0,0,21.22,21.22l30-30A15,15,0,0,0,477.61,155.39ZM347,61a45.08,45.08,0,0,0-44.5,38.28L288.82,113C265,136.78,229.93,151,195,151H105a45.06,45.06,0,0,0-42.42,30H60a60,60,0,0,0,0,120h2.58A45.25,45.25,0,0,0,90,328.42V406a45,45,0,0,0,90,0V331h15c34.93,0,70,14.22,93.82,38l13.68,13.69A45,45,0,0,0,392,376V106A45.05,45.05,0,0,0,347,61ZM60,271a30,30,0,0,1,0-60Zm90,135a15,15,0,0,1-30,0V331h30Zm30-105H105a15,15,0,0,1-15-15V196a15,15,0,0,1,15-15h75Zm122,39.35c-25.34-21.94-57.92-35.56-92.1-38.67V180.32c34.18-3.11,66.76-16.73,92.1-38.67ZM362,376a15,15,0,0,1-15,15h0a15,15,0,0,1-15-15V106a15,15,0,0,1,30,0Z"/></svg>
                    Announcements
                    <svg class="toggle-arrow size7 move-to-right" style="@if($page == 'admin.announcements') transform: rotate(90deg) @endif" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                        <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                    </svg>
                </div>
            </div>
            <div class="relative toggle-container" style="margin-left: 26px; @isset($subpage) @if($page == 'admin.announcements') display: block; @endif @endisset">
                <div>
                    <div class="relative">
                        <a href="{{ route('admin.announcements.create') }}" class="flex align-center white no-underline @isset($subpage) @if($subpage == 'threads.announcement.create') blue @else white @endif @else white @endisset fs12" style="padding: 8px 0">
                            <svg class="mr4 size13" fill="@isset($subpage) @if($subpage == 'threads.announcement.create') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M13.69,108.9q0-41,0-81.91c0-9.64,3.42-13.07,13-13.07q81.66,0,163.31,0c9.46,0,13.11,3.66,13.11,13.15q0,81.42,0,162.82c0,9.58-3.89,13.49-13.44,13.49q-81.41,0-162.82,0c-9.54,0-13.18-3.62-13.19-13.08Q13.66,149.6,13.69,108.9Zm168.24-.5c0-23-.09-46,.1-69.05,0-3.7-.87-4.57-4.55-4.55q-69.3.21-138.6,0c-3.43,0-4.31.78-4.3,4.27q.2,69.3,0,138.59c0,3.62.74,4.61,4.51,4.6q69.3-.24,138.59,0c3.43,0,4.37-.81,4.34-4.3C181.85,154.76,181.93,131.58,181.93,108.4Zm63.17,23.19q0-31.56,0-63.14c0-8.8-3.81-12.49-12.67-12.6-1.15,0-2.31-.07-3.46,0-5,.34-11.72-2.2-14.58,1.08-2.49,2.85-.45,9.41-.94,14.27-.48,4.7.93,6.83,5.81,5.86,4.21-.84,5,1,5,5q-.22,68.8,0,137.62c0,3.94-1.08,4.75-4.84,4.74q-68.31-.19-136.63.05c-5,0-6.82-1.21-5.92-6.09.65-3.54-.56-5.08-4.45-4.74a69.44,69.44,0,0,1-12.32,0c-3.93-.35-4.74,1.23-4.51,4.76.29,4.59,0,9.21.07,13.81.06,9.43,3.7,13.09,13.18,13.09q81.63,0,163.27,0c9.59,0,13-3.45,13-13.1q0-41,0-81.88ZM118.73,123.4c-.2-3.38.74-4.56,4.31-4.47,9.2.26,18.42-.05,27.62.16,3.3.08,4.72-.57,4.43-4.21a91.42,91.42,0,0,1,0-12.82c.19-3.14-.65-4.2-4-4.11-9.37.24-18.75-.09-28.12.17-3.58.1-4.35-1.05-4.27-4.41.24-9-.06-18.1.16-27.13.09-3.47-.5-5.15-4.48-4.79a84.27,84.27,0,0,1-12.81,0c-3.08-.19-3.91.8-3.84,3.84.19,9.53,0,19.07.14,28.61.06,2.93-.53,3.94-3.71,3.86-9.37-.24-18.75,0-28.12-.16-3.26-.07-4.77.52-4.47,4.2a89.92,89.92,0,0,1,0,12.82c-.22,3.29.89,4.19,4.14,4.11,9.37-.21,18.75.08,28.11-.15,3.32-.08,4.12.94,4,4.13-.21,9.53,0,19.08-.14,28.61,0,2.68.54,3.77,3.47,3.62,4.75-.25,9.54-.2,14.3,0,2.57.11,3.43-.66,3.33-3.29-.19-4.92-.06-9.86,0-14.79C118.8,132.6,119,128,118.73,123.4Z"></path></svg>
                            Create announcement
                        </a>
                        @isset($subpage) @if($subpage=='threads.announcement.create')
                            <div class="selected-colored-slice"></div>
                        @endif @endisset
                    </div>
                    <div class="relative">
                        <a href="{{ route('admin.announcements.manage') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'threads.announcement.manage') blue @else white @endif @else white @endisset" style="padding: 8px 0">
                            <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'threads.announcement.manage') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"></path></svg>
                            Manage announcements
                        </a>
                        @isset($subpage) @if($subpage=='threads.announcement.manage')
                            <div class="selected-colored-slice"></div>
                        @endif @endisset
                    </div>
                </div>
            </div>
        </div>
        <div class="flex relative">
            <div class="flex align-center full-width relative">
                <a href="{{ route('admin.reports.review') }}" class="admin-panel-button @if($page == 'admin.reports.review') {{ 'bold blue admin-panel-button-focused' }} @endif unselectable">
                    <svg class="size13 mr8" fill="@if($page=='admin.reports.review') #2ca0ff @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"></path></svg>
                    Resources Reportings
                </a>
            </div>
            @if($page == 'admin.reports.review')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="relative toggle-box @if($page=='admin.resource.management') admin-panel-button-focused @endif">
            <div class="flex align-center full-width relative pointer toggle-container-button">
                <div class="admin-panel-button @if($page == 'admin.resource.management') {{ 'bold white' }} @endif unselectable">
                    <svg class="size15 mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M71.91,6.06h182c0,13.39-.08,26.77.06,40.15,0,2.7-.66,3.56-3.43,3.49-7.25-.2-14.52.09-21.77-.14-3.11-.1-4,.71-4,3.92.17,17.09.13,34.19,0,51.28a7.46,7.46,0,0,0,2.42,5.89c8.18,8,16.18,16.2,24.39,24.18,1.91,1.86,2,2.91,0,4.82-8.21,8-16.25,16.13-24.36,24.2-1.37,1.37-2.51,2.61-2.48,4.89.13,13.06.11,26.12,0,39.18,0,2.22.65,3.11,2.91,3.36a39.62,39.62,0,0,1,15.48,5.09c14.17,8.13,14.31,23,.26,31.33-7.84,4.64-16.53,6.16-25.5,6.19-18.55.07-37.1,0-55.64,0-28.71,0-57.41-.08-86.12.1-3.66,0-4.59-.9-4.43-4.49.31-6.92,0-13.87.16-20.79.09-3-.6-4-3.83-4.21-14.5-.86-28.83-2.79-42.49-8.19C17.21,213,10,208.3,6.06,199.69V60.28c4.31-9.55,12.57-14.14,21.84-17.51,13-4.72,26.56-6.56,40.26-7.33,3.27-.18,3.87-1.26,3.81-4.21C71.78,22.84,71.91,14.45,71.91,6.06ZM182.4,239.38c-2-14,2.13-20.86,15.59-25.77a35.81,35.81,0,0,1,8.87-2.21c3-.27,3.59-1.56,3.56-4.29q-.19-18.88,0-37.75a6.9,6.9,0,0,0-2.35-5.44c-7.7-7.58-15.18-15.4-23-22.83-3-2.83-3.6-4.43-.18-7.59,7.93-7.32,15.36-15.2,23-22.8a6.93,6.93,0,0,0,2.52-5.36q-.18-26.13,0-52.27c0-2.66-.59-3.58-3.41-3.5-7.41.2-14.84,0-22.26.12-2.68.07-3.57-.61-3.5-3.41.2-7.58,0-15.17.12-22.75,0-2.28-.56-3-2.93-3-29.69.08-59.37,0-89.06.07-1,0-2.73-.59-2.82.92-.24,4.18-.19,8.39,0,12.58.06,1.65,1.69,1.06,2.69,1.17,5.77.62,11.57,1,17.31,1.79,12,1.72,23.79,4.27,34.35,10.6,6.83,4.1,11.48,9.53,11.46,18.23q-.18,64.13,0,128.25A18.53,18.53,0,0,1,145.5,209a42.57,42.57,0,0,1-12,7.09c-13.3,5.39-27.29,7.67-41.48,8.27-5.18.22-5.84,2.09-5.67,6.48.32,8.59.09,8.59,8.93,8.59Zm-44.65-68.55c-39.34,13.49-78.16,13.48-117.16,0v15.1c0,12.69.49,13.37,12.68,17.76.9.32,1.81.66,2.73.93,24,6.85,48.27,7.25,72.73,3.22,8.59-1.42,17-3.47,24.63-8,2.34-1.38,4.55-2.76,4.45-6.2C137.6,186.08,137.75,178.51,137.75,170.83Zm0-87.62c-39.2,13.52-78,13.59-117.16-.06v12.7c0,15.59.81,16.69,15.86,21.35.31.09.63.13.94.22,24.39,6.53,49,6.71,73.72,2.36,7.61-1.34,15-3.42,21.87-7.23,3.35-1.87,5.15-4.23,4.88-8.49C137.43,97.16,137.75,90.21,137.75,83.21Zm-117.16,44v13.38c0,14.28.43,14.87,14.26,19.55.91.31,1.82.61,2.75.86,24.39,6.52,49,6.68,73.7,2.28,7.62-1.36,15.09-3.36,21.82-7.33,2.12-1.25,4.66-2.41,4.64-5.63,0-7.7,0-15.39,0-23.07C98.61,140.72,59.77,140.79,20.59,127.23ZM81.85,49.61c-14.76,0-27.11,1.08-39.25,3.94-6.91,1.62-13.69,3.66-19.6,7.83-2.67,1.88-2.75,3.57,0,5.51A40.46,40.46,0,0,0,35.58,72.8c26,7.39,52.16,7.63,78.5,2.28,7.44-1.52,14.66-3.68,21.06-8,2.93-2,3-3.78,0-5.82a42.42,42.42,0,0,0-9.92-4.9C110.45,51.18,95.08,49.89,81.85,49.61Zm135.54-14.5h11.13c11.28,0,11.18,0,11-11.39,0-2.54-.73-3.22-3.24-3.19-9.83.14-19.67.06-29.51.06-11.27,0-11.18,0-11,11.38,0,2.55.73,3.26,3.24,3.19C205.13,35,211.27,35.11,217.39,35.11Zm.08,117.57a5.93,5.93,0,0,0,1.2-.7q6.87-6.81,13.69-13.66c1.22-1.22.18-1.94-.6-2.72-4.1-4.1-8.27-8.14-12.26-12.36-1.52-1.59-2.41-1.36-3.81.09q-5.87,6.11-12,12c-1.45,1.39-1.7,2.28-.09,3.8,4.21,4,8.24,8.17,12.35,12.27C216.43,151.82,216.94,152.22,217.47,152.68Zm.33,86.76c6.59-.32,13.1-1.07,18.95-4.65,2.75-1.69,3.11-3.18.21-5.25-8.52-6.08-29.76-6.13-38.48-.11-3.2,2.2-2.7,3.75.24,5.5C204.61,238.43,211.11,239.17,217.8,239.44Z"/></svg>
                    Manage Resources
                    <svg class="toggle-arrow move-to-right size7" style="margin-top: 2px; @if($page == 'admin.resource.management') transform: rotate(90deg) @endif" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                        <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                    </svg>
                </div>
            </div>
            <div class="relative toggle-container" style="margin-left: 26px; @isset($subpage) @if($page == 'admin.resource.management') display: block; @endif @endisset">
                <div class="relative">
                    <a href="{{ route('admin.user.manage') }}" class="flex align-center white no-underline @isset($subpage) @if($subpage == 'admin.manage.users.manage') blue @else white @endif @else white @endisset fs12" style="padding: 8px 0">
                        <svg class="size15 mr8" fill="@isset($subpage) @if($subpage == 'admin.manage.users.manage') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 400.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm201.2 226.5c-2.3-1.2-4.6-2.6-6.8-3.9l-7.9 4.6c-6 3.4-12.8 5.3-19.6 5.3-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-5.5-17.7 1.9-36.4 17.9-45.7l7.9-4.6c-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-16-9.2-23.4-28-17.9-45.7.9-2.9 2.2-5.8 3.2-8.7-3.8-.3-7.5-1.2-11.4-1.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c10.1 0 19.5-3.2 27.2-8.5-1.2-3.8-2-7.7-2-11.8v-9.2z"></path></svg>
                        manage user
                    </a>
                    @isset($subpage) @if($subpage=='admin.manage.users.manage')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.thread.manage') }}" class="flex align-center white no-underline @isset($subpage) @if($subpage == 'admin.user.thread.manage') blue @else white @endif @else white @endisset fs12" style="padding: 8px 0">
                        <svg class="size15 mr8" fill="@isset($subpage) @if($subpage == 'admin.user.thread.manage') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,17.11h97.27c11.82,0,15.64,3.73,15.64,15.34q0,75.07,0,150.16c0,11.39-3.78,15.13-15.22,15.13-2.64,0-5.3.12-7.93-.06a11.11,11.11,0,0,1-10.53-9.38c-.81-5.69,2-11,7.45-12.38,3.28-.84,3.52-2.36,3.51-5.06-.07-27.15-.11-54.29,0-81.43,0-3.68-1-4.69-4.68-4.68q-85.63.16-171.29,0c-3.32,0-4.52.68-4.5,4.33q.26,41,0,81.95c0,3.72,1.3,4.53,4.56,4.25a45.59,45.59,0,0,1,7.39.06,11.06,11.06,0,0,1,10.58,11c0,5.62-4.18,10.89-9.91,11.17-8.43.4-16.92.36-25.36,0-5.16-.23-8.82-4.31-9.68-9.66a33,33,0,0,1-.24-5.27q0-75.08,0-150.16c0-11.61,3.81-15.34,15.63-15.34Zm22.49,45.22c16.56,0,33.13,0,49.7,0,5.79,0,13.59,2,16.83-.89,3.67-3.31.59-11.25,1.19-17.13.4-3.92-1.21-4.54-4.73-4.51-19.21.17-38.42.08-57.63.08-22.73,0-45.47.11-68.21-.1-4,0-5.27,1-4.92,5a75.62,75.62,0,0,1,0,12.68c-.32,3.89.78,5,4.85,5C110.54,62.21,131.51,62.33,152.49,62.33ZM62.3,51.13c0-11.26,0-11.26-11.45-11.26h-.53c-10.47,0-10.47,0-10.47,10.71,0,11.75,0,11.75,11.49,11.75C62.3,62.33,62.3,62.33,62.3,51.13ZM102,118.66c25.79.3,18.21-2.79,36.49,15.23,18.05,17.8,35.89,35.83,53.8,53.79,7.34,7.35,7.3,12.82-.13,20.26q-14.94,15-29.91,29.87c-6.86,6.81-12.62,6.78-19.5-.09-21.3-21.28-42.53-42.64-63.92-63.84a16.11,16.11,0,0,1-5.24-12.62c.23-9.86,0-19.73.09-29.59.07-8.71,4.24-12.85,13-13C91.81,118.59,96.92,118.66,102,118.66ZM96.16,151c.74,2.85-1.53,6.66,1.41,9.6,17.66,17.71,35.39,35.36,53,53.11,1.69,1.69,2.59,1.48,4.12-.12,4.12-4.34,8.24-8.72,12.73-12.67,2.95-2.59,2.36-4-.16-6.49-15.68-15.46-31.4-30.89-46.63-46.79-4.56-4.76-9.1-6.73-15.59-6.35C96.18,141.8,96.16,141.41,96.16,151Z"/></svg>
                        manage thread
                    </a>
                    @isset($subpage) @if($subpage=='admin.user.thread.manage')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.post.manage') }}" class="flex align-center white no-underline @isset($subpage) @if($subpage == 'admin.user.post.manage') blue @else white @endif @else white @endisset fs12" style="padding: 8px 0">
                        <svg class="size15 mr8" fill="@isset($subpage) @if($subpage == 'admin.user.post.manage') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                        manage reply
                    </a>
                    @isset($subpage) @if($subpage=='admin.user.post.manage')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
            </div>
        </div>
        <div class="relative toggle-box @if($page=='admin.feedbacks-and-messages') admin-panel-button-focused @endif">
            <div class="flex align-center full-width relative pointer toggle-container-button">
                <div class="admin-panel-button @if($page == 'admin.feedbacks-and-messages') {{ 'bold white' }} @endif unselectable" style="align-items: flex-start;">
                    <svg class="size15 mr8 mt2" style="min-width: 15px;" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M128,132,57.22,238.11,256,470,454.78,238.11,384,132Zm83,90H104l35.65-53.49Zm-30-60H331l-75,56.25Zm60,90V406.43L108.61,252Zm30,0H403.39L271,406.43Zm30-30,71.32-53.49L408,222ZM482,72V42H452V72H422v30h30v30h30V102h30V72ZM60,372H30v30H0v30H30v30H60V432H90V402H60ZM0,282H30v30H0Zm482-90h30v30H482Z"/></svg>
                    Feedback, Messages and Faqs
                    <svg class="toggle-arrow move-to-right size7 mt4" style="@if($page == 'admin.feedbacks-and-messages') transform: rotate(90deg) @endif" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                        <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                    </svg>
                </div>
            </div>
            <div class="relative toggle-container" style="margin-left: 26px; @if($page == 'admin.feedbacks-and-messages') display: block; @endif">
                <div>
                    <div class="relative">
                        <a href="{{ route('admin.contactmessages') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'contactmessages') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                            <svg class="mr8 size14" fill="@isset($subpage) @if($subpage == 'contactmessages') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path d="M39.24,33.2c-6.6.76-13.23.18-19.85.34-3.07.07-6.15,0-9.22,0C9,33.52,7.63,34,7,32.6s.68-2.12,1.46-2.93c2.56-2.63,5-5.36,7.78-7.78,1.81-1.6,1.42-2.48-.13-3.89-2.85-2.6-5.51-5.42-8.26-8.15C7.19,9.21,6.55,8.58,7,7.55c.31-.81,1-.88,1.72-.88q14.58,0,29.16,0a8.6,8.6,0,0,1,1.41.22ZM11.66,30.3H34.34c-2.55-2.44-4.6-4.3-6.52-6.29-1.18-1.22-2.14-2.41-3.64-.39a1.28,1.28,0,0,1-2.08.23c-1.89-2.52-3-.67-4.32.6C16,26.23,14.08,28,11.66,30.3ZM33.55,9.92H12.24c3.44,3.45,6.59,6.58,9.7,9.73.62.64,1.09,1,1.88.18C27,16.58,30.14,13.38,33.55,9.92ZM36,27.84V11.51c-2.61,2.76-4.67,5-6.82,7.19C28.4,19.5,27.94,20,29,21,31.37,23.2,33.61,25.49,36,27.84ZM4.55,21.58a12.17,12.17,0,0,0,1.48,0c.8-.1,1.59-.31,1.68-1.32.07-.77-.21-1.47-1-1.5-1.81-.07-3.74-.81-5.34.62A1.06,1.06,0,0,0,1.49,21a2.81,2.81,0,0,0,1.3.59,10.33,10.33,0,0,0,1.76,0Zm5-7.27c0-2.05-2-1.26-3.31-1.4a8.74,8.74,0,0,0-1.77,0A1.42,1.42,0,0,0,3,14.49a1.38,1.38,0,0,0,1.32,1.35c.59.06,1.19,0,2.13,0C7.4,15.63,9.58,16.65,9.52,14.31ZM6.25,27.2a13,13,0,0,0,2.07,0,1.34,1.34,0,0,0,1.25-1.67C9.27,24,8,24.16,7,24.26c-1.37.13-3.13-.76-3.9,1.14-.36.88.27,1.55,1.12,1.75a9.42,9.42,0,0,0,2.06,0Z"/></svg>
                            Contact Messages
                        </a>
                        @isset($subpage) @if($subpage=='contactmessages')
                            <div class="selected-colored-slice"></div>
                        @endif @endisset
                    </div>
                    <div class="relative">
                        <a href="{{ route('admin.feedbacks') }}" class="flex align-center white no-underline @isset($subpage) @if($subpage == 'feedbacks') blue bold @else white @endif @else white @endisset fs12" style="padding: 8px 0">
                            <svg class="mr8 size13" fill="@isset($subpage) @if($subpage == 'feedbacks') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM397.4,397.4A200,200,0,1,1,114.6,114.6,200,200,0,1,1,397.4,397.4ZM336,224a32,32,0,1,0-32-32A32,32,0,0,0,336,224Zm-160,0a32,32,0,1,0-32-32A32,32,0,0,0,176,224Zm194.4,64H141.6a13.42,13.42,0,0,0-13.5,15c7.5,59.2,58.9,105,121.1,105h13.6c62.2,0,113.6-45.8,121.1-105a13.42,13.42,0,0,0-13.5-15Z"/></svg>
                            Feedbacks
                        </a>
                        @isset($subpage) @if($subpage=='feedbacks')
                            <div class="selected-colored-slice"></div>
                        @endif @endisset
                    </div>
                    <div class="relative">
                        <a href="{{ route('admin.faqs') }}" class="flex align-center white no-underline @isset($subpage) @if($subpage == 'faqs') blue bold @else white @endif @else white @endisset fs12" style="padding: 8px 0">
                            <svg class="mr8 size13" fill="@isset($subpage) @if($subpage == 'faqs') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M172,197.68H26c-.18-.8-.89-.74-1.47-.91-11-3.28-18.21-10.39-21.3-21.53-.13-.5-.23-1-.8-1.13V26.62c1.27-.76,1-2.2,1.42-3.32A29.25,29.25,0,0,1,31.39,3.11q68.41-.12,136.83,0a29,29,0,0,1,28.84,28.81q.19,68.4,0,136.8c0,11.76-6,20.32-16.32,25.9C178,196.13,174.82,196.4,172,197.68ZM99.58,178.1q33.08,0,66.15,0c8.69,0,11.83-3.17,11.84-12q0-65.76,0-131.51c0-8.79-3.16-12-11.84-12q-66,0-131.91,0c-8.7,0-11.85,3.19-11.85,12q0,65.76,0,131.52c0,8.79,3.15,12,11.84,12Q66.69,178.12,99.58,178.1Zm7.85-61c3.14-.87,5.22-2.92,5.21-6.17,0-2.74,1.41-3.54,3.56-4.47,11.86-5.17,19.24-14,20-27.14A35,35,0,0,0,110.7,43.61C93.47,38.71,75.17,45.29,67.23,60c-6.88,12.7-5.68,17.26,8.94,21.75,6,1.84,9.24,0,11.55-5.9,2.82-7.2,6-9.23,13.77-8.87,5.59.26,8.42,2.22,9.76,6.75,1.64,5.5.36,9.44-4.09,12.66-2.5,1.82-5.43,2.62-8.26,3.71-6.13,2.34-10,6.46-11,13.25-1.6,10.93,1.42,14.65,12.34,14.54A26.08,26.08,0,0,0,107.43,117.1ZM85.35,144.17c0,.76,0,1.52,0,2.27.2,8.27,3,11.28,11.32,12.1a36,36,0,0,0,9.45-.38,8.54,8.54,0,0,0,7.5-7,31.91,31.91,0,0,0,.44-10.93c-.73-7.14-3.78-10-11-10.42a51.5,51.5,0,0,0-8,.17c-6.13.57-9,3.51-9.66,9.63a43.13,43.13,0,0,0,0,4.55Z"/></svg>
                            FAQs
                        </a>
                        @isset($subpage) @if($subpage=='faqs')
                            <div class="selected-colored-slice"></div>
                        @endif @endisset
                    </div>
                </div>
            </div>
        </div>
        <div class="relative toggle-box @if($page=='admin.forums-and-categories') admin-panel-button-focused @endif">
            <div class="flex align-center full-width relative pointer toggle-container-button">
                <div class="admin-panel-button @if($page == 'admin.forums-and-categories') {{ 'bold white' }} @endif unselectable">
                    <svg class="size15 mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M438.09,273.32h-39.6a102.92,102.92,0,0,1,6.24,35.4V458.37a44.18,44.18,0,0,1-2.54,14.79h65.46A44.4,44.4,0,0,0,512,428.81V347.23A74,74,0,0,0,438.09,273.32ZM107.26,308.73a102.94,102.94,0,0,1,6.25-35.41H73.91A74,74,0,0,0,0,347.23v81.58a44.4,44.4,0,0,0,44.35,44.35h65.46a44.17,44.17,0,0,1-2.55-14.78Zm194-73.91H210.74a74,74,0,0,0-73.91,73.91V458.38a14.78,14.78,0,0,0,14.78,14.78H360.39a14.78,14.78,0,0,0,14.78-14.78V308.73A74,74,0,0,0,301.26,234.82ZM256,38.84a88.87,88.87,0,1,0,88.89,88.89A89,89,0,0,0,256,38.84ZM99.92,121.69a66.44,66.44,0,1,0,66.47,66.47A66.55,66.55,0,0,0,99.92,121.69Zm312.16,0a66.48,66.48,0,1,0,66.48,66.47A66.55,66.55,0,0,0,412.08,121.69Z"/></svg>
                    Forums & Categories
                    <svg class="toggle-arrow move-to-right size7" style="margin-top: 2px; @if($page == 'admin.forums-and-categories') transform: rotate(90deg) @endif" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                        <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                    </svg>
                </div>
            </div>
            <div class="relative toggle-container" style="margin-left: 26px; @if($page == 'admin.forums-and-categories') display: block; @endif">
                <div class="relative">
                    <a href="{{ route('admin.forum.and.categories.dashboard') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'forums-and-categories-dashboard') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'forums-and-categories-dashboard') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><g id="Icons"><g id="Outlined"><g id="Action"><g><polygon id="Path" points="29.13 32.13 22 -2 22 22 -2 22 29.13 32.13"/><path d="M17,3V5H13V3ZM7,3V9H3V3Zm10,8v6H13V11ZM7,15v2H3V15ZM19,1H11V7h8ZM9,1H1V11H9ZM19,9H11V19h8ZM9,13H1v6H9Z"/></g></g></g></g></svg>
                        Dashboard
                    </a>
                    @isset($subpage) @if($subpage=='forums-and-categories-dashboard')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <span class="mb4 fs10 bold block unselectable" style="color: rgb(223, 223, 223); margin-top: 14px;">FORUM::</span>
                <div class="relative">
                    <a href="{{ route('admin.forum.add') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'forums-and-categories-forum-add') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'forums-and-categories-forum-add') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M13.69,108.9q0-41,0-81.91c0-9.64,3.42-13.07,13-13.07q81.66,0,163.31,0c9.46,0,13.11,3.66,13.11,13.15q0,81.42,0,162.82c0,9.58-3.89,13.49-13.44,13.49q-81.41,0-162.82,0c-9.54,0-13.18-3.62-13.19-13.08Q13.66,149.6,13.69,108.9Zm168.24-.5c0-23-.09-46,.1-69.05,0-3.7-.87-4.57-4.55-4.55q-69.3.21-138.6,0c-3.43,0-4.31.78-4.3,4.27q.2,69.3,0,138.59c0,3.62.74,4.61,4.51,4.6q69.3-.24,138.59,0c3.43,0,4.37-.81,4.34-4.3C181.85,154.76,181.93,131.58,181.93,108.4Zm63.17,23.19q0-31.56,0-63.14c0-8.8-3.81-12.49-12.67-12.6-1.15,0-2.31-.07-3.46,0-5,.34-11.72-2.2-14.58,1.08-2.49,2.85-.45,9.41-.94,14.27-.48,4.7.93,6.83,5.81,5.86,4.21-.84,5,1,5,5q-.22,68.8,0,137.62c0,3.94-1.08,4.75-4.84,4.74q-68.31-.19-136.63.05c-5,0-6.82-1.21-5.92-6.09.65-3.54-.56-5.08-4.45-4.74a69.44,69.44,0,0,1-12.32,0c-3.93-.35-4.74,1.23-4.51,4.76.29,4.59,0,9.21.07,13.81.06,9.43,3.7,13.09,13.18,13.09q81.63,0,163.27,0c9.59,0,13-3.45,13-13.1q0-41,0-81.88ZM118.73,123.4c-.2-3.38.74-4.56,4.31-4.47,9.2.26,18.42-.05,27.62.16,3.3.08,4.72-.57,4.43-4.21a91.42,91.42,0,0,1,0-12.82c.19-3.14-.65-4.2-4-4.11-9.37.24-18.75-.09-28.12.17-3.58.1-4.35-1.05-4.27-4.41.24-9-.06-18.1.16-27.13.09-3.47-.5-5.15-4.48-4.79a84.27,84.27,0,0,1-12.81,0c-3.08-.19-3.91.8-3.84,3.84.19,9.53,0,19.07.14,28.61.06,2.93-.53,3.94-3.71,3.86-9.37-.24-18.75,0-28.12-.16-3.26-.07-4.77.52-4.47,4.2a89.92,89.92,0,0,1,0,12.82c-.22,3.29.89,4.19,4.14,4.11,9.37-.21,18.75.08,28.11-.15,3.32-.08,4.12.94,4,4.13-.21,9.53,0,19.08-.14,28.61,0,2.68.54,3.77,3.47,3.62,4.75-.25,9.54-.2,14.3,0,2.57.11,3.43-.66,3.33-3.29-.19-4.92-.06-9.86,0-14.79C118.8,132.6,119,128,118.73,123.4Z"/></svg>
                        Create a forum
                    </a>
                    @isset($subpage) @if($subpage=='forums-and-categories-forum-add')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.forum.manage') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'forums-and-categories-forum-manage') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'forums-and-categories-forum-manage') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"/></svg>
                        Manage forum
                    </a>
                    @isset($subpage) @if($subpage=='forums-and-categories-forum-manage')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.forum.archive') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'forums-and-categories-forum-archive') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'forums-and-categories-forum-archive') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.13,22.58c1.78.15,3.56.41,5.34.41,17.56,0,35.12.06,52.68,0,2.72,0,4.05.29,4.05,3.64Q65,130,65.19,233.42c0,3.25-1.16,3.7-4,3.7-19.36,0-38.72.1-58.08.18ZM48,74.3c0-9.5-.05-19,0-28.51,0-2.41-.49-3.52-3.24-3.45-7,.18-14.09.2-21.13,0-2.91-.08-3.54,1-3.52,3.68q.14,28.75,0,57.51c0,3,1.11,3.54,3.75,3.49,6.71-.15,13.44-.25,20.15,0,3.44.14,4.07-1.17,4-4.24C47.86,93.31,48,83.81,48,74.3ZM34.08,189.91a13.85,13.85,0,0,0-13.84,13.65,14.05,14.05,0,0,0,13.62,14,13.9,13.9,0,0,0,14-14A13.62,13.62,0,0,0,34.08,189.91ZM140.13,34.6l42.49-11.33c4.42-1.19,8.89-2.23,13.24-3.66,3.1-1,4.36-.48,5.25,2.93,6,23.28,12.36,46.49,18.59,69.73,11.43,42.67,22.79,85.37,34.39,128,1.13,4.13.34,5.37-3.75,6.4q-25.69,6.5-51.18,13.74c-3.38,1-4.14-.11-4.87-2.88q-23.65-88.69-47.4-177.37a212.52,212.52,0,0,0-6.76-21.85V43q0,94.28.11,188.56c0,4.5-1.13,5.67-5.61,5.59-17.39-.27-34.79-.2-52.18,0-3.42,0-4.4-.84-4.4-4.34q.17-102.9,0-205.79c0-3.38,1.07-4.08,4.17-4.06,17.89.12,35.77.15,53.66,0,3.45,0,4.7.91,4.3,4.36A65,65,0,0,0,140.13,34.6Zm-17,40.07c0-9.5-.13-19,.07-28.5.06-3.05-.82-3.93-3.86-3.84-6.87.22-13.75.18-20.63,0-2.56-.06-3.36.71-3.35,3.3q.13,29,0,58c0,2.53.72,3.44,3.33,3.38,6.88-.16,13.76-.2,20.64,0,3,.09,3.93-.8,3.87-3.86C123,93.68,123.14,84.17,123.14,74.67Zm81.55,27.88c-.05-.16-.11-.31-.15-.47q-7.72-28.92-15.42-57.85c-.49-1.84-1.46-2.3-3.23-1.81q-10.89,3-21.8,5.85c-1.65.44-2.47.89-1.89,3,5.2,19.09,10.26,38.23,15.35,57.36.41,1.52.73,2.61,3,2,7.37-2.16,14.83-4,22.26-6C203.79,104.32,205.26,104.36,204.69,102.55Zm-95.23,87.38a13.53,13.53,0,0,0-14,13.37,13.83,13.83,0,0,0,13.73,14.23,14.09,14.09,0,0,0,13.87-13.73A13.88,13.88,0,0,0,109.46,189.93ZM216.65,214.8a13.77,13.77,0,0,0,13.9-13.53,14.08,14.08,0,0,0-14-14.07,13.9,13.9,0,0,0-13.56,14A13.51,13.51,0,0,0,216.65,214.8Z"/></svg>
                        Archive a forum
                    </a>
                    @isset($subpage) @if($subpage=='forums-and-categories-forum-archive')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.forum.restore') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'forums-and-categories-forum-restore') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'forums-and-categories-forum-restore') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                        Restore a forum
                    </a>
                    @isset($subpage) @if($subpage=='forums-and-categories-forum-restore')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>

                <span class="mb4 fs10 bold block unselectable" style="color: rgb(223, 223, 223); margin-top: 14px;">CATEGORIES::</span>

                <div class="relative">
                    <a href="{{ route('admin.category.add') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'forums-and-categories-category-add') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'forums-and-categories-category-add') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M13.69,108.9q0-41,0-81.91c0-9.64,3.42-13.07,13-13.07q81.66,0,163.31,0c9.46,0,13.11,3.66,13.11,13.15q0,81.42,0,162.82c0,9.58-3.89,13.49-13.44,13.49q-81.41,0-162.82,0c-9.54,0-13.18-3.62-13.19-13.08Q13.66,149.6,13.69,108.9Zm168.24-.5c0-23-.09-46,.1-69.05,0-3.7-.87-4.57-4.55-4.55q-69.3.21-138.6,0c-3.43,0-4.31.78-4.3,4.27q.2,69.3,0,138.59c0,3.62.74,4.61,4.51,4.6q69.3-.24,138.59,0c3.43,0,4.37-.81,4.34-4.3C181.85,154.76,181.93,131.58,181.93,108.4Zm63.17,23.19q0-31.56,0-63.14c0-8.8-3.81-12.49-12.67-12.6-1.15,0-2.31-.07-3.46,0-5,.34-11.72-2.2-14.58,1.08-2.49,2.85-.45,9.41-.94,14.27-.48,4.7.93,6.83,5.81,5.86,4.21-.84,5,1,5,5q-.22,68.8,0,137.62c0,3.94-1.08,4.75-4.84,4.74q-68.31-.19-136.63.05c-5,0-6.82-1.21-5.92-6.09.65-3.54-.56-5.08-4.45-4.74a69.44,69.44,0,0,1-12.32,0c-3.93-.35-4.74,1.23-4.51,4.76.29,4.59,0,9.21.07,13.81.06,9.43,3.7,13.09,13.18,13.09q81.63,0,163.27,0c9.59,0,13-3.45,13-13.1q0-41,0-81.88ZM118.73,123.4c-.2-3.38.74-4.56,4.31-4.47,9.2.26,18.42-.05,27.62.16,3.3.08,4.72-.57,4.43-4.21a91.42,91.42,0,0,1,0-12.82c.19-3.14-.65-4.2-4-4.11-9.37.24-18.75-.09-28.12.17-3.58.1-4.35-1.05-4.27-4.41.24-9-.06-18.1.16-27.13.09-3.47-.5-5.15-4.48-4.79a84.27,84.27,0,0,1-12.81,0c-3.08-.19-3.91.8-3.84,3.84.19,9.53,0,19.07.14,28.61.06,2.93-.53,3.94-3.71,3.86-9.37-.24-18.75,0-28.12-.16-3.26-.07-4.77.52-4.47,4.2a89.92,89.92,0,0,1,0,12.82c-.22,3.29.89,4.19,4.14,4.11,9.37-.21,18.75.08,28.11-.15,3.32-.08,4.12.94,4,4.13-.21,9.53,0,19.08-.14,28.61,0,2.68.54,3.77,3.47,3.62,4.75-.25,9.54-.2,14.3,0,2.57.11,3.43-.66,3.33-3.29-.19-4.92-.06-9.86,0-14.79C118.8,132.6,119,128,118.73,123.4Z"/></svg>
                        Create a category
                    </a>
                    @isset($subpage) @if($subpage=='forums-and-categories-category-add')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.category.manage') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'forums-and-categories-category-manage') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'forums-and-categories-category-manage') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"/></svg>
                        Manage category
                    </a>
                    @isset($subpage) @if($subpage=='forums-and-categories-category-manage')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.category.archive') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'forums-and-categories-category-archive') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg fill="@isset($subpage) @if($subpage == 'forums-and-categories-category-archive') #2ca0ff @else #fff @endif @else #fff @endif" class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.13,22.58c1.78.15,3.56.41,5.34.41,17.56,0,35.12.06,52.68,0,2.72,0,4.05.29,4.05,3.64Q65,130,65.19,233.42c0,3.25-1.16,3.7-4,3.7-19.36,0-38.72.1-58.08.18ZM48,74.3c0-9.5-.05-19,0-28.51,0-2.41-.49-3.52-3.24-3.45-7,.18-14.09.2-21.13,0-2.91-.08-3.54,1-3.52,3.68q.14,28.75,0,57.51c0,3,1.11,3.54,3.75,3.49,6.71-.15,13.44-.25,20.15,0,3.44.14,4.07-1.17,4-4.24C47.86,93.31,48,83.81,48,74.3ZM34.08,189.91a13.85,13.85,0,0,0-13.84,13.65,14.05,14.05,0,0,0,13.62,14,13.9,13.9,0,0,0,14-14A13.62,13.62,0,0,0,34.08,189.91ZM140.13,34.6l42.49-11.33c4.42-1.19,8.89-2.23,13.24-3.66,3.1-1,4.36-.48,5.25,2.93,6,23.28,12.36,46.49,18.59,69.73,11.43,42.67,22.79,85.37,34.39,128,1.13,4.13.34,5.37-3.75,6.4q-25.69,6.5-51.18,13.74c-3.38,1-4.14-.11-4.87-2.88q-23.65-88.69-47.4-177.37a212.52,212.52,0,0,0-6.76-21.85V43q0,94.28.11,188.56c0,4.5-1.13,5.67-5.61,5.59-17.39-.27-34.79-.2-52.18,0-3.42,0-4.4-.84-4.4-4.34q.17-102.9,0-205.79c0-3.38,1.07-4.08,4.17-4.06,17.89.12,35.77.15,53.66,0,3.45,0,4.7.91,4.3,4.36A65,65,0,0,0,140.13,34.6Zm-17,40.07c0-9.5-.13-19,.07-28.5.06-3.05-.82-3.93-3.86-3.84-6.87.22-13.75.18-20.63,0-2.56-.06-3.36.71-3.35,3.3q.13,29,0,58c0,2.53.72,3.44,3.33,3.38,6.88-.16,13.76-.2,20.64,0,3,.09,3.93-.8,3.87-3.86C123,93.68,123.14,84.17,123.14,74.67Zm81.55,27.88c-.05-.16-.11-.31-.15-.47q-7.72-28.92-15.42-57.85c-.49-1.84-1.46-2.3-3.23-1.81q-10.89,3-21.8,5.85c-1.65.44-2.47.89-1.89,3,5.2,19.09,10.26,38.23,15.35,57.36.41,1.52.73,2.61,3,2,7.37-2.16,14.83-4,22.26-6C203.79,104.32,205.26,104.36,204.69,102.55Zm-95.23,87.38a13.53,13.53,0,0,0-14,13.37,13.83,13.83,0,0,0,13.73,14.23,14.09,14.09,0,0,0,13.87-13.73A13.88,13.88,0,0,0,109.46,189.93ZM216.65,214.8a13.77,13.77,0,0,0,13.9-13.53,14.08,14.08,0,0,0-14-14.07,13.9,13.9,0,0,0-13.56,14A13.51,13.51,0,0,0,216.65,214.8Z"/></svg>
                        Archive a category
                    </a>
                    @isset($subpage) @if($subpage=='forums-and-categories-category-archive')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.category.restore') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'forums-and-categories-category-restore') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'forums-and-categories-category-restore') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                        Restore a category
                    </a>
                    @isset($subpage) @if($subpage=='forums-and-categories-category-restore')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
            </div>
        </div>
        <div class="relative toggle-box @if($page=='admin.archives') admin-panel-button-focused @endif">
            <div class="flex align-center full-width relative pointer toggle-container-button">
                <div class="admin-panel-button @if($page == 'admin.archives') {{ 'bold white' }} @endif unselectable">
                    <svg class="size15 mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.13,22.58c1.78.15,3.56.41,5.34.41,17.56,0,35.12.06,52.68,0,2.72,0,4.05.29,4.05,3.64Q65,130,65.19,233.42c0,3.25-1.16,3.7-4,3.7-19.36,0-38.72.1-58.08.18ZM48,74.3c0-9.5-.05-19,0-28.51,0-2.41-.49-3.52-3.24-3.45-7,.18-14.09.2-21.13,0-2.91-.08-3.54,1-3.52,3.68q.14,28.75,0,57.51c0,3,1.11,3.54,3.75,3.49,6.71-.15,13.44-.25,20.15,0,3.44.14,4.07-1.17,4-4.24C47.86,93.31,48,83.81,48,74.3ZM34.08,189.91a13.85,13.85,0,0,0-13.84,13.65,14.05,14.05,0,0,0,13.62,14,13.9,13.9,0,0,0,14-14A13.62,13.62,0,0,0,34.08,189.91ZM140.13,34.6l42.49-11.33c4.42-1.19,8.89-2.23,13.24-3.66,3.1-1,4.36-.48,5.25,2.93,6,23.28,12.36,46.49,18.59,69.73,11.43,42.67,22.79,85.37,34.39,128,1.13,4.13.34,5.37-3.75,6.4q-25.69,6.5-51.18,13.74c-3.38,1-4.14-.11-4.87-2.88q-23.65-88.69-47.4-177.37a212.52,212.52,0,0,0-6.76-21.85V43q0,94.28.11,188.56c0,4.5-1.13,5.67-5.61,5.59-17.39-.27-34.79-.2-52.18,0-3.42,0-4.4-.84-4.4-4.34q.17-102.9,0-205.79c0-3.38,1.07-4.08,4.17-4.06,17.89.12,35.77.15,53.66,0,3.45,0,4.7.91,4.3,4.36A65,65,0,0,0,140.13,34.6Zm-17,40.07c0-9.5-.13-19,.07-28.5.06-3.05-.82-3.93-3.86-3.84-6.87.22-13.75.18-20.63,0-2.56-.06-3.36.71-3.35,3.3q.13,29,0,58c0,2.53.72,3.44,3.33,3.38,6.88-.16,13.76-.2,20.64,0,3,.09,3.93-.8,3.87-3.86C123,93.68,123.14,84.17,123.14,74.67Zm81.55,27.88c-.05-.16-.11-.31-.15-.47q-7.72-28.92-15.42-57.85c-.49-1.84-1.46-2.3-3.23-1.81q-10.89,3-21.8,5.85c-1.65.44-2.47.89-1.89,3,5.2,19.09,10.26,38.23,15.35,57.36.41,1.52.73,2.61,3,2,7.37-2.16,14.83-4,22.26-6C203.79,104.32,205.26,104.36,204.69,102.55Zm-95.23,87.38a13.53,13.53,0,0,0-14,13.37,13.83,13.83,0,0,0,13.73,14.23,14.09,14.09,0,0,0,13.87-13.73A13.88,13.88,0,0,0,109.46,189.93ZM216.65,214.8a13.77,13.77,0,0,0,13.9-13.53,14.08,14.08,0,0,0-14-14.07,13.9,13.9,0,0,0-13.56,14A13.51,13.51,0,0,0,216.65,214.8Z"/></svg>
                    Admin Archives
                    <svg class="toggle-arrow move-to-right size7" style="margin-top: 2px; @if($page == 'admin.archives') transform: rotate(90deg) @endif" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                        <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                    </svg>
                </div>
            </div>
            <div class="relative toggle-container" style="margin-left: 26px; @if($page == 'admin.archives') display: block; @endif">
                <div>
                    <div class="relative">
                        <a href="{{ route('admin.archives.forums') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'admin-archives-forums') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                            <svg class="mr4 size14" fill="@isset($subpage) @if($subpage == 'admin-archives-forums') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M438.09,273.32h-39.6a102.92,102.92,0,0,1,6.24,35.4V458.37a44.18,44.18,0,0,1-2.54,14.79h65.46A44.4,44.4,0,0,0,512,428.81V347.23A74,74,0,0,0,438.09,273.32ZM107.26,308.73a102.94,102.94,0,0,1,6.25-35.41H73.91A74,74,0,0,0,0,347.23v81.58a44.4,44.4,0,0,0,44.35,44.35h65.46a44.17,44.17,0,0,1-2.55-14.78Zm194-73.91H210.74a74,74,0,0,0-73.91,73.91V458.38a14.78,14.78,0,0,0,14.78,14.78H360.39a14.78,14.78,0,0,0,14.78-14.78V308.73A74,74,0,0,0,301.26,234.82ZM256,38.84a88.87,88.87,0,1,0,88.89,88.89A89,89,0,0,0,256,38.84ZM99.92,121.69a66.44,66.44,0,1,0,66.47,66.47A66.55,66.55,0,0,0,99.92,121.69Zm312.16,0a66.48,66.48,0,1,0,66.48,66.47A66.55,66.55,0,0,0,412.08,121.69Z"/></svg>
                            Forum archives
                        </a>
                        @isset($subpage) @if($subpage=='admin-archives-forums')
                            <div class="selected-colored-slice"></div>
                        @endif @endisset
                    </div>
                    <div class="relative">
                        <a href="{{ route('admin.archives.categories') }}" class="flex align-center white no-underline @isset($subpage) @if($subpage == 'admin-archives-categories') blue bold @else white @endif @else white @endisset fs12" style="padding: 8px 0">
                            <svg class="mr4 size13" fill="@isset($subpage) @if($subpage == 'admin-archives-categories') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M18.66,68.29c-.45-26.81,21.7-49.6,48.58-50a49.62,49.62,0,0,1,50.68,48.86c.58,27.16-21.52,50.15-48.55,50.49A49.71,49.71,0,0,1,18.66,68.29ZM68.23,97.81A29.81,29.81,0,1,0,38.55,68.19,29.83,29.83,0,0,0,68.23,97.81ZM18.66,191.6c-.51-26.59,21.39-49.43,48-50a49.63,49.63,0,0,1,51.25,48.77c.63,26.94-21.21,50-48,50.56A49.72,49.72,0,0,1,18.66,191.6ZM68.3,221a29.81,29.81,0,1,0-29.75-29.55A29.81,29.81,0,0,0,68.3,221ZM240.12,67.6c.54,26.57-21.44,49.49-48,50.07a49.7,49.7,0,0,1-51.29-48.76c-.73-26.83,21.25-50,48-50.57C217,17.73,239.54,39.35,240.12,67.6Zm-19.9.32A29.77,29.77,0,1,0,190.29,97.8,29.76,29.76,0,0,0,220.22,67.92Zm19.9,122.93c.52,26.58-21.46,49.48-48,50a49.69,49.69,0,0,1-51.26-48.79c-.71-26.83,21.28-50,48-50.53C217.05,141,239.57,162.61,240.12,190.85Zm-19.9.18a29.77,29.77,0,1,0-29.81,30A29.74,29.74,0,0,0,220.22,191Z"/></svg>
                            Categories archives
                        </a>
                        @isset($subpage) @if($subpage=='admin-archives-categories')
                            <div class="selected-colored-slice"></div>
                        @endif @endisset
                    </div>
                </div>
            </div>
        </div>
        <div class="relative toggle-box @if($page=='admin.rap') admin-panel-button-focused @endif">
            <div class="flex align-center full-width relative pointer toggle-container-button">
                <div class="admin-panel-button @if($page == 'admin.rap') {{ 'bold white' }} @endif unselectable">
                    <svg class="size15 mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.44,172.34c-10.15,14.26-25.88,18.13-41.5,21.48-43.65,9.35-87.82,10-132.06,5.81-20.18-1.9-40.31-4.88-59.29-12.74-5-2.07-9.8-4.58-13.76-8.36-7.07-6.75-7-14.28.28-20.79s16.06-9.27,25-12c7.48-2.28,7.64-2.16,8.08,5.36.51,8.47,5.39,13.72,12.37,17.54,12.18,6.68,25.66,8.72,39.12,10.42a273.28,273.28,0,0,0,89-2.87c8.2-1.66,16.17-4,23.41-8.45s11.29-10.5,10.57-19c-.41-4.91,1.19-5.3,5.38-4,7.64,2.44,15.22,4.9,22.25,8.84,5.28,3,9.22,7,11.18,12.84Zm-88.5-.17c12-1.77,23.93-3.57,34.76-9.58,5.6-3.11,9.07-7.2,8.51-14.09-.58-7.18-.45-14.41-1.09-21.58-1.28-14.37-3.68-28.52-9.74-41.81-9.14-20-25.42-28.5-46.66-23.8-9.94,2.19-19.17,6.43-28,11.51a23.2,23.2,0,0,1-15.59,2.63,207,207,0,0,0-21.46-2.33c-11.61-.5-21.11,3.7-27.4,14A52.88,52.88,0,0,0,56,98.65c-5.58,17.25-5.48,35.16-5.91,53-.11,4.68,3.07,7.85,6.88,10.09a50.94,50.94,0,0,0,10.65,4.9c20.56,6.33,41.72,7.84,68,7.93A204.19,204.19,0,0,0,167.94,172.17Z"/></svg>
                    Roles & Permissions
                    <svg class="toggle-arrow move-to-right size7" style="margin-top: 2px; @if($page == 'admin.rap') transform: rotate(90deg) @endif" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                        <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                    </svg>
                </div>
            </div>
            <div class="relative toggle-container" style="margin-left: 26px; @if($page == 'admin.rap') display: block; @endif">
                <div class="relative">
                    <a href="{{ route('admin.rap.hierarchy') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'admin.rap.hierarchy') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr8 size14" fill="@isset($subpage) @if($subpage == 'admin.rap.hierarchy') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M122.69,171.45c0-10.09-.09-20.17,0-30.25,0-2.77-.27-4.09-3.63-4-8.25.28-16.53.23-24.78,0-3-.08-3.75,1-3.41,3.65a27.53,27.53,0,0,1,0,4c-.22,9.51-6.79,16.17-16.33,16.24q-23.29.15-46.61,0c-9.75-.06-16.32-6.8-16.39-16.66q-.12-15.12,0-30.24c.08-9.85,6.66-16.49,16.49-16.54q23.06-.12,46.11,0c10.08,0,16.6,6.69,16.74,16.83.09,7,.09,7,6.94,7s13.89-.18,20.82.07c3.24.13,4.08-.81,4.05-4-.16-19.17-.09-38.34-.07-57.51,0-16.06,9.84-25.78,26-25.8,6.28,0,12.56-.09,18.84,0,2.16,0,3-.56,2.78-2.76a43.09,43.09,0,0,1,0-5.45c.32-8.71,6.78-15.48,15.44-15.58q24.28-.27,48.59,0a15.47,15.47,0,0,1,15.24,15.23q.33,16.35,0,32.72A15.55,15.55,0,0,1,234,73.78q-24,.24-48.09,0c-9-.1-15.45-7.1-15.61-16.44-.13-7.31-.13-7.31-7.58-7.31-4.95,0-9.91-.05-14.87,0-6.24.08-9.25,2.92-9.27,9-.06,19.67,0,39.33-.09,59,0,2.93.95,3.51,3.63,3.46,8.1-.17,16.2-.26,24.29,0,3.42.12,4.34-1.08,3.91-4.16a23.62,23.62,0,0,1,0-3.47c.21-9.53,6.75-16.18,16.29-16.24q23.31-.15,46.61,0c9.78.06,16.35,6.74,16.43,16.62q.13,15.12,0,30.25c-.08,9.85-6.67,16.51-16.47,16.57q-23.06.14-46.12,0c-10.09-.05-16.62-6.7-16.74-16.83-.09-7-.09-7-6.94-7-7.27,0-14.54.09-21.81,0-2.37-.05-3.06.63-3,3,.09,20,0,40,.09,60,0,5.07,3,8.24,7.85,8.38,7.1.2,14.21,0,21.32.1,1.87,0,2.72-.47,2.56-2.48a49.52,49.52,0,0,1,0-5.45c.26-9,6.73-15.77,15.65-15.86q24-.24,48.1,0a15.55,15.55,0,0,1,15.53,15.46c.2,10.74.18,21.49,0,32.23a15.62,15.62,0,0,1-15.81,15.7q-23.81.21-47.6,0c-9.34-.09-15.76-7-15.89-16.66-.1-7.1-.1-7.1-7.29-7.1-5.46,0-10.91.07-16.37,0-13.55-.21-23.77-10.37-23.93-23.89C122.59,191,122.69,181.2,122.69,171.45Z"/></svg>
                        R&P Hierarchy
                    </a>
                    @isset($subpage) @if($subpage=='admin.rap.hierarchy')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.rap.overview') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'admin.rap.overview') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr8 size14" fill="@isset($subpage) @if($subpage == 'admin.rap.overview') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M74.87,257.35c-6.23-6.1-12.61-12.06-18.62-18.36-2.34-2.45-3.6-2.13-5.63.14-3.09,3.43-6.41,6.66-9.77,9.83-4.06,3.81-8.2,3.8-12.2-.1-6.26-6.11-12.4-12.34-18.55-18.56-5.15-5.2-5.19-8.73,0-13.92Q34.21,192.2,58.42,168.1c14.25-14.23,28.44-28.52,42.81-42.61,2.42-2.36,2.72-4.11,1.31-7.16-19.18-41.47-2.48-87.75,38.54-107.18C188.48-11.31,246,19.72,253.29,71.68c6.35,45.17-23.62,85.28-68.64,91.35a75.39,75.39,0,0,1-44.71-7.26c-3-1.5-4.72-1.33-7.14,1.14Q110.6,179.52,88,201.74c-2.16,2.14-2.71,3.41-.14,5.75,5.12,4.66,9.9,9.7,14.76,14.64,4.66,4.74,4.75,8.6.23,13.19q-9.19,9.36-18.55,18.56a47.87,47.87,0,0,1-4.49,3.47Zm139-173.46a39.61,39.61,0,0,0-79.22-.14c-.09,21.48,18,39.61,39.62,39.75S213.85,105.64,213.89,83.89Z"/></svg>
                        R&P Overview
                    </a>
                    @isset($subpage) @if($subpage=='admin.rap.overview')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.rap.manage.role') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'admin.rap.manage.role') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr8 size14" fill="@isset($subpage) @if($subpage == 'admin.rap.manage.role') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.12,231.24c2.31-3.71,3.06-8.13,5.64-11.76a36.53,36.53,0,0,1,14.13-11.94c-6-5.69-9.23-12.14-8.34-20.21a21.81,21.81,0,0,1,8-14.77,22.21,22.21,0,0,1,30,1.73c8.91,9.18,8.22,21.91-1.78,32.9,2.87,2.14,5.94,4.06,8.58,6.46,7.19,6.54,10.59,14.89,10.81,24.54.14,6.25.1,12.5.14,18.75-21.12,0-42.23-.05-63.34.06-2.81,0-4.05-.27-3.9-3.64C3.35,246,3.12,238.61,3.12,231.24Zm252.72,25.7c0-6.42.14-12.85,0-19.26-.32-11.65-5.39-20.8-15-27.44-1.46-1-3-1.93-4.51-2.92,10.06-10.85,11-23,2.57-32.36A22.2,22.2,0,0,0,209,172a21.26,21.26,0,0,0-8.41,13.48c-1.51,8.68,1.38,16,7.89,21.91-13.05,7.83-19.22,17.23-19.62,29.81-.21,6.58-.12,13.17-.17,19.75Zm-92.8,0c0-6.42.09-12.85-.09-19.27a33,33,0,0,0-13-26c-2-1.61-4.3-2.92-6.49-4.38,10.35-11,10.92-24.16,1.56-33.38a22.16,22.16,0,0,0-30.72-.32c-9.69,9.21-9.27,22.38,1.27,33.8-1.28.78-2.53,1.49-3.74,2.29-9.73,6.38-15.15,15.39-15.76,27-.36,6.73-.12,13.5-.15,20.25ZM96,77.28a87.53,87.53,0,0,1-.07,11.34c-.45,4.15,1.32,4.76,4.94,4.72,16.77-.17,33.53-.06,50.3-.08,3.77,0,8.79,1.31,11-.59,2.61-2.26.6-7.43.87-11.33,1.1-16.44-4.23-29.59-19.56-37.45C153.86,32,154.27,19,144.7,9.93A22.16,22.16,0,0,0,114,10.2c-9.3,9.07-8.77,22.19,1.61,33.66C102.06,51.07,95.58,62.15,96,77.28ZM33.4,122.86c-3.47,0-4.5,1-4.39,4.42.26,7.41.15,14.83,0,22.24,0,2.26.6,3.1,3,3.26,11.75.78,11.88.86,11.82-10.59,0-3.45.94-4.44,4.4-4.41,20.88.15,41.77.07,62.66.07,10.84,0,10.94,0,11,10.87,0,2.82.48,4,3.73,4.09,11,.13,11.14.28,11.15-10.84,0-3.16.78-4.21,4.09-4.19q35,.21,70.07,0c3.36,0,4,1.15,4.05,4.25,0,11.09.12,10.95,11.17,10.78,3.27-.06,3.75-1.34,3.69-4.12-.16-7.08-.29-14.18,0-21.25.18-3.85-1.16-4.6-4.74-4.58-25.82.14-51.65.08-77.47.08-10.66,0-10.76,0-10.76-10.63,0-3-.48-4.34-4-4.34-10.85,0-11-.17-10.9,10.6,0,3.39-.79,4.5-4.33,4.45-14-.21-28-.08-41.94-.08C61.69,122.94,47.54,123.05,33.4,122.86Z"/></svg>
                        Manage role
                    </a>
                    @isset($subpage) @if($subpage=='admin.rap.manage.role')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.rap.manage.permission') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'admin.rap.manage.permission') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr8 size14" fill="@isset($subpage) @if($subpage == 'admin.rap.manage.permission') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.34,245.7q-40.65,0-81.31,0c-10.29,0-13.65-3.39-13.65-13.66q0-60.49,0-121c0-9.82,3.61-13.39,13.47-13.41,5,0,9.93-.19,14.87.07,3,.15,3.43-1,3.47-3.63C67.32,83.05,66.29,72,69,61c7.38-29.7,34.36-49.32,66.07-47.81,28.86,1.38,53.84,24.47,58.24,53.66,1.36,9.06.6,18.15.71,27.22,0,2.69.58,3.73,3.49,3.61,5.61-.24,11.24-.14,16.86,0,7.2.11,11.43,4.23,11.44,11.43q.09,62.47,0,125c0,7.7-4.13,11.62-12.18,11.63Q172,245.76,130.34,245.7Zm-.09-148c13,0,26.09-.07,39.13,0,2.67,0,3.83-.49,3.71-3.47-.24-5.94.09-11.9-.12-17.83-.79-22.48-16.7-39.91-38.29-42.1-20.86-2.12-40.25,11.75-45.25,32.56-2.11,8.77-.85,17.76-1.32,26.65-.19,3.69,1.22,4.26,4.49,4.21C105.15,97.54,117.7,97.65,130.25,97.65Zm.37,42.41a31.73,31.73,0,0,0-.29,63.46,32,32,0,0,0,32-31.67A31.61,31.61,0,0,0,130.62,140.06Z"/></svg>
                        Manage permission
                    </a>
                    @isset($subpage) @if($subpage=='admin.rap.manage.permission')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('admin.rap.manage.user') }}" class="flex align-center white no-underline fs12 @isset($subpage) @if($subpage == 'admin.rap.manage.user') blue bold @else white @endif @else white @endisset" style="padding: 8px 0">
                        <svg class="mr8 size14" fill="@isset($subpage) @if($subpage == 'admin.rap.manage.user') #2ca0ff @else #fff @endif @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                        Manage a user r&p
                    </a>
                    @isset($subpage) @if($subpage=='admin.rap.manage.user')
                        <div class="selected-colored-slice"></div>
                    @endif @endisset
                </div>
            </div>
        </div>
        <div class="flex relative">
            <div class="flex full-width relative">
                <a href="{{ route('admin.internationalization') }}" class="admin-panel-button @if($page == 'admin.internationalization') {{ 'bold blue admin-panel-button-focused' }} @endif unselectable" style="align-items: baseline;">
                    <svg class="size13 mr8 height-max-content" fill="@if($page=='admin.internationalization') #2ca0ff @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M30.26,67.8c6.19,0,11.74.14,17.27-.07,2.36-.09,3.56.78,4.64,2.73a142.64,142.64,0,0,0,14.7,21.37c1.49,1.82,2.24,1.9,3.77,0A149.26,149.26,0,0,0,95.19,49.67H90.45c-27,0-54-.1-81,.11-3.94,0-4.86-1.13-4.52-4.73a57.27,57.27,0,0,0,0-9.8c-.23-3,.76-3.83,3.76-3.8,15.49.15,31-.05,46.49.15,3.46,0,4.83-.69,4.51-4.36s0-7.39-.11-11.08c-.06-2.08.38-3.14,2.79-3.05q6.39.25,12.79,0c2.32-.09,2.93.8,2.86,3-.14,4,.15,8-.1,11.94-.18,2.87.8,3.57,3.57,3.55,15.64-.13,31.28,0,46.92-.14,3.25,0,4.59.66,4.27,4.16a76,76,0,0,0,0,11.09c.15,2.53-.82,3-3.15,3-5,0-11-2-14.52.74-3.28,2.51-3.8,8.54-5.7,12.94A157.66,157.66,0,0,1,84,104.12c-1.85,2.17-2.11,3.35.33,5.28a141.3,141.3,0,0,0,15.89,11.42c2,1.19,2.81,2.21,1.67,4.6a106.47,106.47,0,0,0-4.64,11.41c-.81,2.41-1.56,2.71-3.78,1.34a143,143,0,0,1-21.69-15.73c-2.28-2.08-3.63-2-5.93,0A151.49,151.49,0,0,1,16,151.19c-2.92,1-4.23.8-4.79-2.59A52.33,52.33,0,0,0,8.3,138.39c-1.18-3.1,0-4.09,2.82-5a131.75,131.75,0,0,0,42.27-24.08c2.26-1.88,2.07-2.92.34-4.92A155.48,155.48,0,0,1,30.26,67.8ZM194.42,184.13q-16.95-42.42-33.91-84.85C158.78,95,158,89.07,154.77,86.91s-9.05-.51-13.71-.81c-3-.19-4.46.71-5.6,3.64-9.36,23.88-18.93,47.68-28.44,71.5-3.28,8.23-6.58,16.46-10,25,6,0,11.37-.11,16.76.05,2.23.07,3.19-.71,4-2.78,2.75-7.29,5.84-14.45,8.59-21.74.84-2.22,1.93-3,4.33-2.92,7.53.18,15.07,0,22.6.08,3.82,0,8.55-1.15,11.21.66s3.16,6.67,4.67,10.17c2.33,5.43,2.78,13.27,7.22,15.76,4.66,2.61,11.89.63,18,.65a6.8,6.8,0,0,0,.83-.18C194.83,185.15,194.62,184.64,194.42,184.13Zm-36.94-43.34c-7.15,0-13.76,0-20.36,0-2.62,0-1.79-1.34-1.24-2.73,3.32-8.27,6.61-16.55,10.26-25.7Z"/></svg>
                    <span class="block">Internationalization</span>
                </a>
            </div>
            @if($page == 'admin.internationalization')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="flex relative">
            <div class="flex full-width relative">
                <a href="#" class="admin-panel-button @if($page == 'admins.chat.page') {{ 'bold blue admin-panel-button-focused' }} @endif unselectable" style="align-items: baseline;">
                    <svg class="size13 mr8 height-max-content" fill="@if($page=='admins.chat.page') #2ca0ff @else #fff @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"></path></svg>
                    <div>
                        <span class="block">Admins chat section</span>
                        <span class="fs10">(next release)</span>
                    </div>
                </a>
            </div>
            @if($page == 'admin.chat.page')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
    </div>
    <!-- designed with <3 by mouad -->
    <div class="move-to-bottom mr8" style="margin-left: 20px">
        <div class="flex align-center fs13">
            <p class="unselectable fs13 no-margin">Designed with</p>
            <div style="max-height: 19px; height: 19px; max-width: 19px; width: 19px" class="full-center mx4" title="LOVE">
                <svg class="heart-beating" fill="#FF0000" style="width: 16px; stroke: #331010; stroke-width: 5px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 94.5"><path d="M86.82,26.63v-7.3H78.64V12H62.27v7.29H54.09v7.3H45.91v-7.3H37.73V12H21.36v7.29H13.18v7.3H5V48.5h8.18v7.29h8.18v7.29h8.19v7.29h8.18v7.3h8.18V85h8.18V77.67h8.18v-7.3h8.18V63.08h8.19V55.79h8.18V48.5H95V26.63Z"/></svg>
            </div>
            <p class="unselectable fs13">by<a href="https://www.mouad-dev.com" target="_blank" class="no-underline mx4 bold" style="color: rgb(58, 186, 236)">mouad</a></p>
        </div>
    </div>
</div>