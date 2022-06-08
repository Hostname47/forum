<header>
    <div id="header" class="relative">
        <div id="header-logo-container" style="min-width: 144px; max-width: 144px">
            <a href="/">
                <img src='{{ asset("assets/images/logos/header-logo.png") }}' alt="logo" id="header-logo">
            </a>
        </div>
        <div class="flex align-center full-height" style="margin-left: 10px;">
            <a href="/" class="menu-button-style">
                <svg class="size14 mr8" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <span style="margin-top: 1px; @if(isset($globalpage) && $globalpage == 'home') color: white; @endif">{{ __('Home') }}</span>
                @if(isset($globalpage) && $globalpage == 'home')
                <div class="menu-button-style-selected-stripe"></div>
                @endif
            </a>
            <a href="{{ route('explore') }}" class="menu-button-style">
                <svg class="size14 mr8" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510 510"><path d="M255,227A28.05,28.05,0,1,0,283.05,255,28.3,28.3,0,0,0,255,227ZM255,0C114.75,0,0,114.75,0,255S114.75,510,255,510,510,395.25,510,255,395.25,0,255,0Zm56.1,311.1L102,408l96.9-209.1L408,102Z"/></svg>
                <span style="margin-top: 1px; @if(isset($globalpage) && $globalpage == 'explore') color: white; @endif">{{ __('Explore') }}</span>
                @if(isset($globalpage) && $globalpage == 'explore')
                <div class="menu-button-style-selected-stripe"></div>
                @endif
            </a>
            <a href="{{ route('announcements') }}" class="menu-button-style">
                <svg class="size14 mr8" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 390.34 390.34"><path d="M294.17,21.07c-3.29,0-6.52,2.08-9.6,6.18-.33.44-34.42,44.62-119.62,70.89-6.23,1.92-13.57,4.39-21.86,5.4-4.59.56-5.67-.41-6-1.07a15,15,0,0,0-13.13-7.79H39.78a15,15,0,0,0-15,15v5.58c0,3.38-2.38,3.53-3.21,3.59l-2,.15A21.48,21.48,0,0,0,0,140.08v56.24a21.47,21.47,0,0,0,19.6,21.07l2.8.22c.68,0,2.38.65,2.38,3.65v5.45a15,15,0,0,0,15,15h6.51a3.6,3.6,0,0,1,3.44,2.91L73,350.69c2.29,10.42,12.44,18.58,23.1,18.58H123a16.56,16.56,0,0,0,16.66-20.72L116.91,244.92s-.87-3.21,2.38-3.21h4.63c5.63,0,10.11-3.37,13.09-7.71,1.28-1.86,3.94-1.59,5.38-1.29,8.46,1.71,16.15,3.56,22.56,5.54,85.2,26.32,119.28,70.45,119.61,70.89,3.08,4.11,6.32,6.19,9.61,6.19h0a7.68,7.68,0,0,0,7-4.62,17.38,17.38,0,0,0,1.43-7.57V33.25C302.56,21.66,295.57,21.07,294.17,21.07Zm72.31,71.81A10,10,0,1,0,350,104.23c13.3,19.29,20.33,42.54,20.33,67.27s-7.35,48.71-20.7,67.81A10,10,0,1,0,366,250.76c15.89-22.75,24.3-50.16,24.3-79.26C390.34,142.7,382.09,115.52,366.48,92.88Zm-32.86,28.26a10,10,0,0,0-16.47,11.35A68.47,68.47,0,0,1,329,171.61a69.33,69.33,0,0,1-12,39.44,10,10,0,0,0,16.4,11.46,90.74,90.74,0,0,0,.29-101.37Z"/></svg>
                <span style="@if(isset($globalpage) && $globalpage == 'announcements') color: white; @endif">{{ __('Announcements') }}</span>
                @if(isset($globalpage) && $globalpage == 'announcements')
                <div class="menu-button-style-selected-stripe"></div>
                @endif
            </a>
            <a href="{{ route('contactus') }}" class="menu-button-style">
                <svg class="size14 mr8" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448,64H400V16A16,16,0,0,0,384,0H96A48.06,48.06,0,0,0,48,48V448a64.06,64.06,0,0,0,64,64H448a16,16,0,0,0,16-16V80A16,16,0,0,0,448,64ZM368,400a16,16,0,0,1-16,16H160a16,16,0,0,1-16-16V368a80.09,80.09,0,0,1,80-80h64a80.07,80.07,0,0,1,80,80ZM192,192a64,64,0,1,1,64,64A64.06,64.06,0,0,1,192,192ZM368,64H96a16,16,0,0,1,0-32H368Z"/></svg>
                <span style="@if(isset($globalpage) && $globalpage == 'contactus') color: white; @endif">{{ __('Contact Us') }}</span>
                @if(isset($globalpage) && $globalpage == 'contactus')
                <div class="menu-button-style-selected-stripe"></div>
                @endif
            </a>
        </div>

        <div id="search-and-login" class="flex align-center move-to-right">
            <div id="header-search-container">
                <form action="{{ route('search') }}" method="GET" class="search-forum relative">
                    <svg class="header-search-field-icon" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                    <input type="text" name="k" value="{{ request()->get('k') }}" class="search-field" placeholder="{{ __('Search everything') }}.." title="{{ __('search field') }}" required>
                    <input type="submit" value="{{ __('search') }}" class="search-button">
                </form>
            </div>
            @auth
                @php
                    $authuser = auth()->user();
                    if($unreadnotificationscounter = $authuser->unreadnotificationscount) {
                        $unreadnotificationscounter = ($unreadnotificationscounter > 99) 
                            ? '+' . $unreadnotificationscounter
                            : $unreadnotificationscounter;
                    }
                @endphp
                <div class="flex align-center">
                    <div class="relative"> <!-- header notifications -->
                        <div class="header-button button-with-suboptions pointer notification-button" title="Notifications">
                            <div id="header-button-counter-indicator" class="@if(!$unreadnotificationscounter) none @endif unselectable">{{ $unreadnotificationscounter }}</div>
                            <svg class="small-image-2" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,512a64,64,0,0,0,64-64H192A64,64,0,0,0,256,512ZM471.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C150.56,68.1,96.08,130.3,96.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,32,384c.11,16.4,13,32,32.1,32H447.9c19.12,0,32-15.6,32.1-32A31.23,31.23,0,0,0,471.39,362.29Z"/></svg>
                        </div>    
                        <div id="header-notifications-box" class="suboptions-container suboptions-header-button-style">
                            <div class="triangle"></div>
                            <div class="suboptions-container-header flex align-center space-between">
                                <div class="flex align-center">
                                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,512a64,64,0,0,0,64-64H192A64,64,0,0,0,256,512ZM471.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C150.56,68.1,96.08,130.3,96.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,32,384c.11,16.4,13,32,32.1,32H447.9c19.12,0,32-15.6,32.1-32A31.23,31.23,0,0,0,471.39,362.29Z"/></svg>
                                    <h2 class="no-margin">{{__('Notifications')}}</h2>
                                </div>
                                <div class="flex align-center">
                                    <a href="{{ route('user.notifications') }}" class="link-path">{{ __('See all') }}</a>
                                    <div class="gray height-max-content mx4 fs10">•</div>
                                    <a href="{{ route('user.notifications.settings') }}" class="link-path size14">
                                        <svg class="size14" fill="#1d84d9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                                    </a>
                                </div>
                            </div>
                            <div id="header-notifs-scrollable-box" class="suboptions-container-dims">
                                <div class="notifs-box">
                                    <div class="flex" style="padding: 6px">
                                        <div class="size48 rounded hidden-overflow mr8 relative" style="min-width: 48px">
                                            <div class="fade-loading"></div>
                                        </div>
                                        <div class="full-width">
                                            <div class="flex align-center">
                                                <div class="relative br3 hidden-overflow" style="width: 80px; height: 10px">
                                                    <div class="fade-loading"></div>
                                                </div>
                                                <div class="relative br3 hidden-overflow mx4" style="width: 16px; height: 10px">
                                                    <div class="fade-loading"></div>
                                                </div>
                                                <div class="relative br3 hidden-overflow" style="width: 100%; height: 10px">
                                                    <div class="fade-loading"></div>
                                                </div>
                                            </div>
                                            <div class="relative br3 hidden-overflow my4" style="width: 100%; height: 18px">
                                                <div class="fade-loading"></div>
                                            </div>
                                            <div class="relative br3 hidden-overflow" style="width: 80px; height: 8px">
                                                <div class="fade-loading"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex" style="padding: 6px">
                                        <div class="size48 rounded hidden-overflow mr8 relative" style="min-width: 48px">
                                            <div class="fade-loading"></div>
                                        </div>
                                        <div class="full-width">
                                            <div class="flex align-center">
                                                <div class="relative br3 hidden-overflow" style="width: 80px; height: 10px">
                                                    <div class="fade-loading"></div>
                                                </div>
                                                <div class="relative br3 hidden-overflow mx4" style="width: 16px; height: 10px">
                                                    <div class="fade-loading"></div>
                                                </div>
                                                <div class="relative br3 hidden-overflow" style="width: 100%; height: 10px">
                                                    <div class="fade-loading"></div>
                                                </div>
                                            </div>
                                            <div class="relative br3 hidden-overflow my4" style="width: 100%; height: 18px">
                                                <div class="fade-loading"></div>
                                            </div>
                                            <div class="relative br3 hidden-overflow" style="width: 80px; height: 8px">
                                                <div class="fade-loading"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex" style="padding: 6px">
                                        <div class="size48 rounded hidden-overflow mr8 relative" style="min-width: 48px">
                                            <div class="fade-loading"></div>
                                        </div>
                                        <div class="full-width">
                                            <div class="flex align-center">
                                                <div class="relative br3 hidden-overflow mr4" style="width: 80px; height: 10px">
                                                    <div class="fade-loading"></div>
                                                </div>
                                                <div class="relative br3 hidden-overflow" style="width: 100%; height: 10px">
                                                    <div class="fade-loading"></div>
                                                </div>
                                            </div>
                                            <div class="relative br3 hidden-overflow my4" style="width: 100%; height: 24px">
                                                <div class="fade-loading"></div>
                                            </div>
                                            <div class="relative br3 hidden-overflow" style="width: 80px; height: 8px">
                                                <div class="fade-loading"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-empty-box none" style="padding: 12px">
                                    <svg class="flex size28 move-to-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 438.53 438.53"><path d="M431.4,211l-68-157.6A25.47,25.47,0,0,0,353,41.4q-7.56-4.86-15-4.86H100.5q-7.43,0-15,4.86a25.52,25.52,0,0,0-10.42,12L7.14,211A91.85,91.85,0,0,0,0,246.1V383.72a17.59,17.59,0,0,0,5.42,12.85A17.61,17.61,0,0,0,18.27,402h402a18.51,18.51,0,0,0,18.26-18.27V246.1A91.84,91.84,0,0,0,431.4,211ZM292.07,237.54,265,292.36H173.59l-27.12-54.82H56.25a12.85,12.85,0,0,0,.71-2.28,13.71,13.71,0,0,1,.72-2.29L118.2,91.37H320.34L380.86,233c.2.58.43,1.34.71,2.29s.53,1.7.72,2.28Z"/></svg>
                                    <h3 class="my4 fs17 text-center">{{ __('Notifications box is empty') }}</h3>
                                    <p class="my4 fs13 gray text-center">{{ __("Try to create more posts and react to other users' posts to get notifications") }}.</p>
                                </div>
                                <div class="header-notifications-fetch-more">
                                    <div class="flex" style="padding: 6px">
                                        <div class="size48 rounded hidden-overflow mr8 relative" style="min-width: 48px">
                                            <div class="fade-loading"></div>
                                        </div>
                                        <div class="full-width">
                                            <div class="flex align-center">
                                                <div class="relative br3 hidden-overflow mr4" style="width: 80px; height: 10px">
                                                    <div class="fade-loading"></div>
                                                </div>
                                                <div class="relative br3 hidden-overflow" style="width: 100%; height: 10px">
                                                    <div class="fade-loading"></div>
                                                </div>
                                            </div>
                                            <div class="relative br3 hidden-overflow my4" style="width: 100%; height: 24px">
                                                <div class="fade-loading"></div>
                                            </div>
                                            <div class="relative br3 hidden-overflow" style="width: 80px; height: 8px">
                                                <div class="fade-loading"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="notifications-offset" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="relative"> <!-- messages (soon) -->
                        <div class="header-button button-with-suboptions pointer" title="Messages">
                            <svg class="small-image-2" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"/></svg>
                        </div>
                        <div class="suboptions-container suboptions-header-button-style">
                            <div class="triangle"></div>
                            <div class="suboptions-container-header">
                                <div class="flex align-center">
                                    <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"/></svg>
                                    <h2 class="no-margin">{{__('Messages')}}</h2>
                                </div>
                            </div>
                            <div class="suboptions-container-dims messages-box" style="overflow-y: unset">
                                <div style="width: 80%; margin: 0 auto">
                                    <svg class="flex size34 move-to-middle my8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"/></svg>
                                    <h3 class="my4 fs17 text-center">{{__('Chatting and rooms features are not available in the current time')}}</h3>
                                    <p class="my4 fs13 gray text-center">{{ __('We are working on these features and you are going to receive a notification as soon as we complete them') }}.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative"> <!-- quick access -->
                        <div class="header-button button-with-suboptions quick-access-generate pointer" title="{{ __('Quick access') }}">
                            <svg class="small-image-2" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M106.67,0H21.33A21.34,21.34,0,0,0,0,21.33v85.34A21.34,21.34,0,0,0,21.33,128h85.34A21.34,21.34,0,0,0,128,106.67V21.33A21.34,21.34,0,0,0,106.67,0Zm0,192H21.33A21.34,21.34,0,0,0,0,213.33v85.34A21.34,21.34,0,0,0,21.33,320h85.34A21.34,21.34,0,0,0,128,298.67V213.33A21.34,21.34,0,0,0,106.67,192Zm0,192H21.33A21.34,21.34,0,0,0,0,405.33v85.34A21.34,21.34,0,0,0,21.33,512h85.34A21.34,21.34,0,0,0,128,490.67V405.33A21.34,21.34,0,0,0,106.67,384Zm192-384H213.33A21.34,21.34,0,0,0,192,21.33v85.34A21.34,21.34,0,0,0,213.33,128h85.34A21.34,21.34,0,0,0,320,106.67V21.33A21.34,21.34,0,0,0,298.67,0Zm0,192H213.33A21.34,21.34,0,0,0,192,213.33v85.34A21.34,21.34,0,0,0,213.33,320h85.34A21.34,21.34,0,0,0,320,298.67V213.33A21.34,21.34,0,0,0,298.67,192Zm0,192H213.33A21.34,21.34,0,0,0,192,405.33v85.34A21.34,21.34,0,0,0,213.33,512h85.34A21.34,21.34,0,0,0,320,490.67V405.33A21.34,21.34,0,0,0,298.67,384Zm192-384H405.33A21.34,21.34,0,0,0,384,21.33v85.34A21.34,21.34,0,0,0,405.33,128h85.34A21.34,21.34,0,0,0,512,106.67V21.33A21.34,21.34,0,0,0,490.67,0Zm0,192H405.33A21.34,21.34,0,0,0,384,213.33v85.34A21.34,21.34,0,0,0,405.33,320h85.34A21.34,21.34,0,0,0,512,298.67V213.33A21.34,21.34,0,0,0,490.67,192Zm0,192H405.33A21.34,21.34,0,0,0,384,405.33v85.34A21.34,21.34,0,0,0,405.33,512h85.34A21.34,21.34,0,0,0,512,490.67V405.33A21.34,21.34,0,0,0,490.67,384Z"/></svg>
                        </div>
                        <div id="quick-access-box" class="suboptions-container">
                            <div class="triangle"></div>
                            <div id="quick-access-header">
                                <div class="flex align-center">
                                    <svg class="size16 mr8" fill="#000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M106.67,0H21.33A21.34,21.34,0,0,0,0,21.33v85.34A21.34,21.34,0,0,0,21.33,128h85.34A21.34,21.34,0,0,0,128,106.67V21.33A21.34,21.34,0,0,0,106.67,0Zm0,192H21.33A21.34,21.34,0,0,0,0,213.33v85.34A21.34,21.34,0,0,0,21.33,320h85.34A21.34,21.34,0,0,0,128,298.67V213.33A21.34,21.34,0,0,0,106.67,192Zm0,192H21.33A21.34,21.34,0,0,0,0,405.33v85.34A21.34,21.34,0,0,0,21.33,512h85.34A21.34,21.34,0,0,0,128,490.67V405.33A21.34,21.34,0,0,0,106.67,384Zm192-384H213.33A21.34,21.34,0,0,0,192,21.33v85.34A21.34,21.34,0,0,0,213.33,128h85.34A21.34,21.34,0,0,0,320,106.67V21.33A21.34,21.34,0,0,0,298.67,0Zm0,192H213.33A21.34,21.34,0,0,0,192,213.33v85.34A21.34,21.34,0,0,0,213.33,320h85.34A21.34,21.34,0,0,0,320,298.67V213.33A21.34,21.34,0,0,0,298.67,192Zm0,192H213.33A21.34,21.34,0,0,0,192,405.33v85.34A21.34,21.34,0,0,0,213.33,512h85.34A21.34,21.34,0,0,0,320,490.67V405.33A21.34,21.34,0,0,0,298.67,384Zm192-384H405.33A21.34,21.34,0,0,0,384,21.33v85.34A21.34,21.34,0,0,0,405.33,128h85.34A21.34,21.34,0,0,0,512,106.67V21.33A21.34,21.34,0,0,0,490.67,0Zm0,192H405.33A21.34,21.34,0,0,0,384,213.33v85.34A21.34,21.34,0,0,0,405.33,320h85.34A21.34,21.34,0,0,0,512,298.67V213.33A21.34,21.34,0,0,0,490.67,192Zm0,192H405.33A21.34,21.34,0,0,0,384,405.33v85.34A21.34,21.34,0,0,0,405.33,512h85.34A21.34,21.34,0,0,0,512,490.67V405.33A21.34,21.34,0,0,0,490.67,384Z"/></svg>
                                    <span class="no-margin fs20 bold">{{ __('Quick access') }}</span>
                                </div>
                            </div>
                            <div id="quick-access-content-box">
                                <div id="quick-access-panel" class="flex flex-column full-height">
                                    <div class="relative br3 hidden-overflow" style="width: 100%; height: 34px">
                                        <div class="fade-loading"></div>
                                    </div>
                                    <div class="relative br3 hidden-overflow my8" style="width: 100%; height: 34px">
                                        <div class="fade-loading"></div>
                                    </div>
                                    <div class="relative br3 hidden-overflow" style="width: 100%; height: 34px">
                                        <div class="fade-loading"></div>
                                    </div>
                                    <div class="relative br3 hidden-overflow my8" style="width: 60%; height: 16px">
                                        <div class="fade-loading"></div>
                                    </div>
                                    <div style="padding-left: 14px">
                                        <div class="relative br3 hidden-overflow" style="width: 100%; height: 34px">
                                            <div class="fade-loading"></div>
                                        </div>
                                    </div>
                                    <div class="relative br3 hidden-overflow mt8" style="width: 100%; height: 100%;">
                                        <div class="fade-loading"></div>
                                    </div>
                                </div>
                                <div id="quick-access-content" class="flex flex-column">
                                    <div class="relative br3 hidden-overflow" style="width: 40%; height: 16px">
                                        <div class="fade-loading"></div>
                                    </div>
                                    <div class="flex align-center my4">
                                        <div class="relative br3 hidden-overflow" style="width: 80px; height: 16px">
                                            <div class="fade-loading"></div>
                                        </div>
                                        <div class="relative br3 hidden-overflow mx4" style="width: 20px; height: 16px">
                                            <div class="fade-loading"></div>
                                        </div>
                                        <div class="relative br3 hidden-overflow" style="width: 60px; height: 16px">
                                            <div class="fade-loading"></div>
                                        </div>
                                        <div class="relative br3 hidden-overflow move-to-right" style="width: 60px; height: 16px">
                                            <div class="fade-loading"></div>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <svg class="size17 mr8" style="margin-left: 17px" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                                        <div class="flex align-center mt8">
                                            <div class="relative br3 hidden-overflow" style="width: 60px; height: 16px">
                                                <div class="fade-loading"></div>
                                            </div>
                                            <div class="relative br3 hidden-overflow mx4" style="width: 10px; height: 16px">
                                                <div class="fade-loading"></div>
                                            </div>
                                            <div class="relative br3 hidden-overflow" style="width: 90px; height: 16px">
                                                <div class="fade-loading"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex align-center space-between mt8">
                                        <div class="relative br3 hidden-overflow" style="width: 80px; height: 26px">
                                            <div class="fade-loading"></div>
                                        </div>
                                        <div class="relative br3 hidden-overflow" style="width: 60px; height: 18px">
                                            <div class="fade-loading"></div>
                                        </div>
                                    </div>
                                    <div class="relative br3 hidden-overflow mt8 my4" style="width: 70%; height: 34px">
                                        <div class="fade-loading"></div>
                                    </div>
                                    <div class="relative br3 hidden-overflow my4" style="width: 100%; height: 24px">
                                        <div class="fade-loading"></div>
                                    </div>
                                    <div class="relative br3 hidden-overflow my4" style="width: 90%; height: 100%">
                                        <div class="fade-loading"></div>
                                    </div>
                                    <div class="relative br3 hidden-overflow" style="width: 100px; height: 16px">
                                        <div class="fade-loading"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex align-center pointer button-with-suboptions">
                            <div class='header-profile-button relative' style="align-items: flex-start">
                                <img src="{{ auth()->user()->sizedavatar(36, '-l') }}" alt="{{__('your profile picture')}}" class="header-profile-picture size36 fs10" style='background-color: #10151e'>
                            </div>
                            <p class="no-margin fs13 mx4 light-gray flex align-center unselectable">
                                {{ $authuser->lightusername }}
                                <svg class="size7 ml8" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                            </p>
                        </div>
                        <div class="suboptions-container suboptions-account-style" style="width: 196px">
                            <div class="flex first-profile-container-part">
                                <a href="{{ route('user.profile', ['user'=>$authuser->username]) }}" class="relative size36 mr8" style="min-width: 36px">
                                    <img src="{{ auth()->user()->sizedavatar(36, '-l') }}" alt="{{__('your profile picture')}}" class="rounded size36 fs10" style='background-color: white'>
                                </a>
                                <div>
                                    <p class="no-margin fs15 bold unselectable">{{ $authuser->firstname . ' ' . $authuser->lastname }}</p>
                                    <a href="{{ route('user.profile', ['user'=>$authuser->username]) }}" class="no-underline">
                                        <p class="no-margin fs11 blue bold">{{ $authuser->username }}</p>
                                    </a>

                                </div>
                            </div>
                            @if(auth()->user() && auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="suboption-style-1">
                                <svg class="size17 mr8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M145.92,2.42c2.68,10.29,5.38,20.58,8,30.88a4.66,4.66,0,0,0,3.47,3.62c4.18,1.38,8.6,2.55,12.28,4.84,5,3.09,8.91,2.73,13.69-.5,6.36-4.3,13.37-7.62,19.9-11.69,2.51-1.56,3.82-1.14,5.72.84q8.85,9.25,18.1,18.11c2.1,2,2.52,3.46.9,6.11-4.71,7.67-9,15.62-13.6,23.34-1.33,2.22-1.63,4-.26,6.26a64.07,64.07,0,0,1,6.45,15.35,5.43,5.43,0,0,0,4.52,4.35c8.91,2.18,17.74,4.66,26.63,6.87,2.57.64,3.71,1.61,3.62,4.58q-.39,13.05,0,26.1c.11,3.21-1.17,4.13-4,4.8-8.58,2.1-17.06,4.65-25.67,6.66-3.18.74-4.56,2.22-5.41,5.29a81,81,0,0,1-6.47,15.35c-1,1.95-1.67,2.9-3.74.88-3.5-3.45-7.23-6.68-11-9.82-1.54-1.29-1.71-2.39-.85-4.13a67.26,67.26,0,0,0,6-19.13c.43-2.64,1.78-3.67,4.41-4.3,8.12-1.92,16.14-4.28,24.2-6.44,1.24-.33,2.68-.25,2.66-2.17s-1.52-1.81-2.73-2.14c-8.05-2.19-16.06-4.58-24.19-6.46-3-.69-4-2.18-4.38-4.86a69.65,69.65,0,0,0-12.6-30.58c-1.81-2.5-1.54-4.18-.1-6.54,4.17-6.85,8.16-13.82,12.15-20.78.57-1,1.89-2,.56-3.45-1.52-1.72-2.68-.31-3.84.34-7,3.9-14.05,7.76-21,11.85-2.38,1.42-4,1.62-6.48-.17a70.52,70.52,0,0,0-31.5-12.91c-2.41-.37-3.22-1.35-3.77-3.57-1.95-8-4.12-15.84-6.3-23.73-.34-1.26.15-3.21-2.09-3.33-2.63-.14-2.1,2.12-2.48,3.49-2.13,7.73-4.22,15.48-6.14,23.26-.57,2.32-1.33,3.5-4,3.92A70.12,70.12,0,0,0,84.85,66.08c-2.25,1.69-3.86,1.6-6.12.22C71.89,62.12,64.93,58.12,58,54.11c-1.13-.65-2.25-2.2-3.82-.51s.09,2.71.74,3.84c3.93,6.8,7.88,13.6,12,20.31,1.42,2.32,1.78,4-.06,6.52a68.44,68.44,0,0,0-12.76,31c-.44,3-1.79,4.36-4.72,5-8,1.87-15.86,4-23.79,6.07-1.23.32-2.72.11-2.76,2.06s1.41,1.85,2.65,2.18c8.22,2.22,16.4,4.57,24.65,6.65,2.38.6,3.67,1.54,4,4.07a62.3,62.3,0,0,0,6.1,19.09c1.05,2.07,1,3.33-.94,4.94C55,168.92,51,172.78,46.53,176.76a70.39,70.39,0,0,1-8.69-19.06C37,155,35.77,153.71,33,153c-10-2.44-20-5.17-29.94-7.78v-33.5c9.18-2.38,18.31-5,27.56-7,4.52-1,6.84-3.13,8-7.66A57.58,57.58,0,0,1,44.1,84.5c1.4-2.55,1.14-4.34-.26-6.68C39.13,70,34.71,61.93,30,54.07c-1.22-2-1.1-3.26.65-4.94Q40.42,39.74,49.81,30c1.69-1.76,2.91-1.88,4.95-.67,8,4.77,16.14,9.33,24.16,14.08,2,1.18,3.62,1.59,5.81.26A64.17,64.17,0,0,1,100.5,37a5.13,5.13,0,0,0,4-4.23c2.55-10.15,5.25-20.25,7.89-30.37Z" style="fill:#030303"/><path d="M97.41,166.15c-25.52-24.74-19-57.61-1.13-73.8a49.25,49.25,0,0,1,68.07,1.22c17.86,17.72,21.57,49.54-2.41,72.38,3.77,1.76,7.48,3.25,11,5.17,31.1,17.21,47.95,43.6,50.84,79,.31,3.7-.67,4.85-4.42,4.55-4.73-.37-10.6,1.58-14-.6s-1.62-8.64-2.5-13.17C196,205.13,164.19,179.34,128,180.3a74.13,74.13,0,0,0-72,64.36c-.07.48-.19,1-.25,1.45-.32,2.72.29,7-1.15,7.82-2.31,1.39-6,.65-9,.66-10.78,0-10.84,0-9.33-10.63,5.2-36.66,25-62.19,58.92-76.82Zm61.75-37.65a29.5,29.5,0,1,0-29.74,29.55A29.57,29.57,0,0,0,159.16,128.5Z" style="fill:#030303"/><path d="M159.16,128.5A29.5,29.5,0,1,1,129.91,99,29.58,29.58,0,0,1,159.16,128.5Z" style="fill:#fdfdfd"/></svg>
                                <p class="no-margin">{{__('Admin gate')}}</p>
                            </a>
                            @endif
                            <a href="{{ route('user.profile', ['user'=>$authuser->username]) }}" class="suboption-style-1">
                                <svg class="size17 mr8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                                <p class="no-margin">{{__('Profile')}}</p>
                            </a>
                            <a href="{{ route('user.activities', ['user'=>$authuser->username]) }}" class="suboption-style-1">
                                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448,0H64A64.08,64.08,0,0,0,0,64V448a64.08,64.08,0,0,0,64,64H448a64.07,64.07,0,0,0,64-64V64A64.08,64.08,0,0,0,448,0Zm21.33,448A21.35,21.35,0,0,1,448,469.33H64A21.34,21.34,0,0,1,42.67,448V64A21.36,21.36,0,0,1,64,42.67H448A21.36,21.36,0,0,1,469.33,64ZM147.63,119.89a22.19,22.19,0,0,0-4.48-7c-1.07-.85-2.14-1.7-3.2-2.56a16.41,16.41,0,0,0-3.84-1.92,13.77,13.77,0,0,0-3.84-1.28,20.49,20.49,0,0,0-12.38,1.28,24.8,24.8,0,0,0-7,4.48,22.19,22.19,0,0,0-4.48,7,20.19,20.19,0,0,0,0,16.22,22.19,22.19,0,0,0,4.48,7A22.44,22.44,0,0,0,128,149.33a32.71,32.71,0,0,0,4.27-.42,13.77,13.77,0,0,0,3.84-1.28,16.41,16.41,0,0,0,3.84-1.92c1.06-.86,2.13-1.71,3.2-2.56A22.44,22.44,0,0,0,149.33,128,21.38,21.38,0,0,0,147.63,119.89ZM384,106.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM148.91,251.73a13.77,13.77,0,0,0-1.28-3.84,16.41,16.41,0,0,0-1.92-3.84c-.86-1.06-1.71-2.13-2.56-3.2a24.8,24.8,0,0,0-7-4.48,21.38,21.38,0,0,0-16.22,0,24.8,24.8,0,0,0-7,4.48c-.85,1.07-1.7,2.14-2.56,3.2a16.41,16.41,0,0,0-1.92,3.84,13.77,13.77,0,0,0-1.28,3.84,32.71,32.71,0,0,0-.42,4.27A21.1,21.1,0,0,0,128,277.33,21.12,21.12,0,0,0,149.34,256,34.67,34.67,0,0,0,148.91,251.73ZM384,234.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM147.63,375.89a20.66,20.66,0,0,0-27.74-11.52,24.8,24.8,0,0,0-7,4.48,24.8,24.8,0,0,0-4.48,7,21.38,21.38,0,0,0-1.7,8.11,21.33,21.33,0,1,0,42.66,0A17.9,17.9,0,0,0,147.63,375.89ZM384,362.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66Z"/></svg>
                                <p class="no-margin">{{__('My activities')}}</p>
                            </a>
                            <a href="/guidelines" class="suboption-style-1">
                                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="no-margin">{{__('Guidelines')}}</p>
                            </a>
                            <a href="{{ route('user.settings') }}" class="suboption-style-1">
                                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                                <p class="no-margin">{{__('Settings')}}</p>
                            </a>
                            <div class="suboption-style-1 full-center pointer relative">
                                <div class="flex align-center full-dimensions bold pointer">
                                    <svg class="size17 mr8" style="padding-left: 3px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M496,240H293.32a16,16,0,1,1,0-32H496a16,16,0,0,1,0,32Zm-80,80a16,16,0,0,1-11.31-27.33L473.37,224,404.68,155.3a16,16,0,0,1,22.63-22.64l80,80a16,16,0,0,1,0,22.63l-80,80A15.87,15.87,0,0,1,416,320ZM170.66,512a44,44,0,0,1-13.22-2L29.05,467.24A43.06,43.06,0,0,1,0,426.67v-384A42.71,42.71,0,0,1,42.67,0,44.07,44.07,0,0,1,55.89,2L184.27,44.77a43.06,43.06,0,0,1,29.06,40.58v384A42.72,42.72,0,0,1,170.66,512ZM42.67,32A10.71,10.71,0,0,0,32,42.68v384A11.08,11.08,0,0,0,39.4,437l127.78,42.58a11.53,11.53,0,0,0,3.48.47,10.7,10.7,0,0,0,10.67-10.67v-384a11.09,11.09,0,0,0-7.41-10.29L46.14,32.48A11.73,11.73,0,0,0,42.67,32ZM325.32,170.68a16,16,0,0,1-16-16v-96A26.7,26.7,0,0,0,282.66,32h-240a16,16,0,1,1,0-32h240a58.71,58.71,0,0,1,58.66,58.66v96A16,16,0,0,1,325.32,170.68ZM282.66,448H197.33a16,16,0,0,1,0-32h85.33a26.7,26.7,0,0,0,26.66-26.66v-96a16,16,0,0,1,32,0v96A58.71,58.71,0,0,1,282.66,448Z"/></svg>
                                    <p class="no-margin fs14" style="color: #131313; font-family: Arial, Helvetica, sans-serif">{{__('Logout')}}</p>
                                </div>
                                <form action="{{ route('logout') }}" method="POST" class="opacity0 absolute full-dimensions">
                                    @csrf
                                    <button type="submit" class="flex align-center full-dimensions bold pointer" style="background: unset; border: unset; padding: 0 0 0 3px"></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            @guest
            <div id="login" class="flex align-center ml8">
                <a href="" class="flex align-center login-signin-button fs13 light-gray no-underline">
                    <svg class="size20 mr4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="#FFF" d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                    {{__('Sign-in')}}
                </a>
            </div>
            @endguest
            <div class="relative mx4">
                @php
                    $local = \Illuminate\Support\Facades\App::currentLocale();
                @endphp
                <div class="flex align-center no-underline button-with-suboptions pointer" title="{{ __('Languages') }}">
                    <div class='header-profile-button'>
                        <svg class="size24" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M138.71,137h-6.42l-12,60h30.42ZM381.37,257A157,157,0,0,0,406,300.47c9.53-12,19.15-26.07,25.63-43.47ZM467,91H280.72l38.84,311.68c.69,12.75-2.8,24.75-11.12,34.14L242.66,512H467a45.05,45.05,0,0,0,45-45V137C512,112.19,491.81,91,467,91Zm0,166h-4a190.35,190.35,0,0,1-36.13,65.7c11,10.08,22.8,18.34,34.51,27.6a15,15,0,1,1-18.75,23.4c-12.72-10-24.67-18.45-36.62-29.42-11.95,11-22.9,19.38-35.63,29.42a15,15,0,0,1-18.75-23.4c11.72-9.26,22.5-17.52,33.52-27.6-14.06-16.89-26.6-38.32-35.13-65.7h-4a15,15,0,0,1,0-30h45V212a15,15,0,0,1,30,0v15h46a15,15,0,0,1,0,30ZM244.16,39.42A45.05,45.05,0,0,0,199.52,0H45A45.05,45.05,0,0,0,0,45V377a45.05,45.05,0,0,0,45,45H281.55c4.38-5,8.05-8.13,8.2-14.66C289.79,405.7,244.37,41,244.16,39.42ZM183.94,286.71a15,15,0,0,1-17.65-11.77L156.71,227H114.29l-9.58,47.94a15,15,0,1,1-29.42-5.88l30-150A15,15,0,0,1,120,107h31a15,15,0,0,1,14.71,12.06l30,150A15,15,0,0,1,183.94,286.71ZM175.26,452l2.58,20.58c1.71,13.78,10.87,27.84,25.93,34.86L254.13,452Z"/></svg>
                    </div>
                </div>
                <div class="suboptions-container suboptions-account-style">
                    <div class="triangle"></div>
                    <span class="suboption-style-1 block-click">
                        <div class="small-image-2 sprite sprite-2-size ma-arabic17-flag mr8" style="min-width: 17px"></div>
                        <p class="no-margin unselectable">{{ __('Arabic') }} (قريبا)</p>
                        <div class="loading-dots-anim ml4 none">•</div>
                        <input type="hidden" class="lang-value" value="ar">
                    </span>
                    <span class="suboption-style-1 pointer @if($local == 'en') block-click @else set-lang @endif" style="@if($local == 'en') background-color: #e6e6e6; cursor: pointer @endif">
                        <div class="small-image-2 sprite sprite-2-size english17-flag mr8"></div>
                        <p class="no-margin unselectable">{{__('English')}}</p>
                        <div class="loading-dots-anim ml4 none">•</div>
                        <input type="hidden" class="lang-value" value="en">
                    </span>
                    <span class="suboption-style-1 pointer @if($local == 'fr') block-click @else set-lang @endif" style="@if($local == 'fr') background-color: #e6e6e6; cursor: pointer @endif">
                        <div class="small-image-2 sprite sprite-2-size french17-flag mr8"></div>
                        <p class="no-margin unselectable">{{__('French')}}</p>
                        <div class="loading-dots-anim ml4 none">•</div>
                        <input type="hidden" class="lang-value" value="fr">
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div id="loading-strip" class="none">
        <div class="loading-strip-line"></div>
    </div>
</header>