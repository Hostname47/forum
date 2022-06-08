<div>
    @php $canreview = false; @endphp
    @can('review_user_resources_and_activities', [\App\Models\User::class])
        @php $canreview = true; @endphp
    @endcan

    @if($canreview)
        <div class="flex align-center">
            <style>
                .url-col {
                    flex: 1;
                }
                .hits-col {
                    width: 85px;
                }

                table th {
                    background-color: #f3f5f9;
                }

                table th, table td {
                    border: 1px solid #cfd5dd;
                    padding: 10px;
                }

                .user-review-visit-filter-selected {
                    cursor: default;
                    background-color: #f4f4f4;
                }
            </style>
            <h2 class="fs14 forum-color no-margin">User visits</h2>
            <div class="relative" style="margin-left: 10px">
                <div class="flex align-center pointer button-with-suboptions">
                    <p class="no-margin lblack mr4 fs11">Date filter: <span class="bold fs12" id="user-visits-filter-selection-name">Today</span></p>
                    <svg class="size7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                </div>
                <div class="suboptions-container typical-suboptions-container">
                    <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                    <div class="pointer mb4 no-underline typical-suboption user-review-visits-links-filter user-review-visit-filter-selected" style="min-width: 180px;">
                        <div class="flex align-center">
                            <p class="no-margin bold forum-color">{{ __('Today') }}</p>
                            <svg class="spinner size12 opacity0 ml4" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <p class="no-margin fs12 gray">{{ __('All visits of today') }}</p>
                        <input type="hidden" class="filter" value="today">
                        <input type="hidden" class="filter-name" value="Today">
                    </div>
                    <div class="pointer mb4 no-underline typical-suboption user-review-visits-links-filter" style="min-width: 180px;">
                        <div class="flex align-center">
                            <p class="no-margin bold forum-color">{{ __('Last 7 days') }}</p>
                            <svg class="spinner size12 opacity0 ml4" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <p class="no-margin fs12 gray">{{ __('All visits in past 7 days') }}</p>
                        <input type="hidden" class="filter" value="lastweek">
                        <input type="hidden" class="filter-name" value="Last 7 days">
                    </div>
                    <div class="pointer no-underline typical-suboption user-review-visits-links-filter" style="min-width: 180px;">
                        <div class="flex align-center">
                            <p class="no-margin bold forum-color">{{ __('Last 30 days') }}</p>
                            <svg class="spinner size12 opacity0 ml4" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <p class="no-margin fs12 gray">{{ __('All visits in past 30 days') }}</p>
                        <input type="hidden" class="filter" value="lastmonth">
                        <input type="hidden" class="filter-name" value="Last 30 days">
                    </div>
                </div>
            </div>
        </div>
        <p class="fs13 no-margin my4">The following links include all visited links by this user.</p>
        <div class="user-visits-container mt8 y-auto-overflow pr8" style="max-height: 340px;">
            <table class="full-width">
                <tr>
                    <th class="fs13 url-col">
                        <div class="flex align-center">
                            <svg class="mr4 size12" fill="#1c1c1c" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M326.61,185.39A151.92,151.92,0,0,1,327,400l-.36.37-67.2,67.2c-59.27,59.27-155.7,59.26-215,0s-59.27-155.7,0-215l37.11-37.1c9.84-9.84,26.78-3.3,27.29,10.6a184.45,184.45,0,0,0,9.69,52.72,16.08,16.08,0,0,1-3.78,16.61l-13.09,13.09c-28,28-28.9,73.66-1.15,102a72.07,72.07,0,0,0,102.32.51L270,343.79A72,72,0,0,0,270,242a75.64,75.64,0,0,0-10.34-8.57,16,16,0,0,1-6.95-12.6A39.86,39.86,0,0,1,264.45,191l21.06-21a16.06,16.06,0,0,1,20.58-1.74,152.65,152.65,0,0,1,20.52,17.2ZM467.55,44.45c-59.26-59.26-155.69-59.27-215,0l-67.2,67.2L185,112A152,152,0,0,0,205.91,343.8a16.06,16.06,0,0,0,20.58-1.73L247.55,321a39.81,39.81,0,0,0,11.69-29.81,16,16,0,0,0-6.94-12.6A75,75,0,0,1,242,270a72,72,0,0,1,0-101.83L309.16,101a72.07,72.07,0,0,1,102.32.51c27.75,28.3,26.87,73.93-1.15,102l-13.09,13.09a16.08,16.08,0,0,0-3.78,16.61,184.45,184.45,0,0,1,9.69,52.72c.5,13.9,17.45,20.44,27.29,10.6l37.11-37.1c59.27-59.26,59.27-155.7,0-215Z"></path></svg>
                            <span class="bold lblack">url visited <span class="normal-weight gray fs12">(ordered by most visited)</span></span>
                        </div>
                    </th>
                    <th class="fs13 hits-col">
                        <div class="flex align-center">
                            <svg class="mr4 size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M199.61,155.63c13.95,13.82,27.52,27.22,41,40.67,8.08,8,8.06,12.71,0,20.8s-15.95,16-24,24c-7.5,7.43-12.4,7.47-19.79.13-12.69-12.61-25.43-25.2-37.91-38-2.91-3-4.19-2.85-6.6.47-7.21,9.88-14.83,19.46-22.18,29.24-3.16,4.2-6.78,7.39-12.42,6.19s-7.94-5.23-9-10.5Q94.64,161.3,80.46,94.05C78.6,85.11,85,78.6,94,80.46q67.28,14,134.51,28.23c5.24,1.1,9.35,3.42,10.58,9s-1.87,9.28-6.07,12.46C222.08,138.34,211.29,146.68,199.61,155.63Zm-74,47.29c6.31-8.23,12-15.64,17.65-23,7.29-9.44,13.1-9.9,21.41-1.63q16.27,16.2,32.47,32.46c9.8,9.8,9.64,9.63,19.56-.17,3.16-3.14,3-4.66-.1-7.65-12.82-12.47-25.37-25.23-38-37.9-8.7-8.72-8.29-14.34,1.5-21.85,7.38-5.66,14.74-11.32,22.8-17.52-31.83-6.75-62.39-13.25-92.95-19.72-2.38-.5-5.41-2.18-4.32,2.93C112.28,139.77,118.81,170.74,125.63,202.92Zm-88-174.59c-3,3-5.87,6.15-9.05,8.94-2.7,2.38-2.91,4-.07,6.63C34.52,49.49,40.19,55.5,46,61.33c12.52,12.51,12.47,12.45,24.46-.6,2-2.12,2.51-3.26.17-5.53-9.13-8.86-18-17.94-27-26.93-.83-.83-1.7-1.61-2.77-2.62C39.69,26.59,38.56,27.38,37.59,28.33ZM148.82,70q9-9,18-18c11.92-11.91,11.83-11.81-.61-23.63-2.72-2.58-4.16-2.57-6.67.11-6,6.35-12.3,12.37-18.43,18.56-3.48,3.51-9.88,7.44-9.54,10.58.45,4.07,6.29,7.57,9.85,11.27,1.29,1.36,2.7,2.6,4.19,4C146.76,71.92,147.83,71,148.82,70ZM44,174.78c5.82-5.79,11.65-11.57,17.41-17.4,3.79-3.83,10.7-8,10.38-11.55-.4-4.38-7-8-10.55-12.31-2.77-3.36-4.46-2.43-7,.26-6,6.3-12.22,12.32-18.35,18.45-10.7,10.69-10.72,10.71.13,21.41,1.47,1.44,2.6,3.37,5,4C42,176.71,43.06,175.77,44,174.78ZM108.27,54.62a4.09,4.09,0,0,1,.7,0c2.75.36,3.62-.86,3.59-3.57-.12-11-.06-22,0-33.07,0-1.79-.14-3.26-2.54-3.19-6.06.18-12.94-1.43-17.89,1-3.35,1.63-.69,9.05-1.1,13.87-.15,1.86,0,3.75,0,5.62C91,55.55,91,55.55,108.27,54.62ZM31.07,91c-17,0-16.93,0-16.34,17.05.11,3.12.53,4.63,4.18,4.55,10.6-.23,21.2-.07,31.8-.09,1.82,0,4,.49,3.88-2.55C54.4,103.87,56,97,53.54,92c-1.58-3.21-9.13-.63-14-1-1.64-.12-3.3,0-4.95,0Z" style="fill:#040404"/></svg>
                            <span class="bold lblack" style="margin-top: 1px;">hits</span>
                        </div>
                    </th>
                </tr>
                @foreach($visits as $visit)
                <tr class="user-visit-review-record">
                    <td class="fs13 url-col"><a href="{{ $visit->url }}" target="_blank" class="bold dark-blue">{{ $visit->url }}</a></td>
                    <td class="fs13 bold lblack hits-col">{{ $visit->hits }}</td>
                </tr>
                @endforeach
                <tr id="user-visits-review-fetch-more" class="@if(!$hasmore) none no-fetch @endif">
                    <td colspan="2">
                        <input type="hidden" class="current-filter" value="today" autocomplete="off">
                        <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                        <div class="full-center">
                            <svg class="spinner size16" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                    </td>
                </tr>
                <tr class="no-visits @if(count($visits)) none @endif">
                    <td class="fs13 lblack url-col" colspan="2">
                        <div class="full-center">
                            <svg class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="my4 lblack fs12">User does not have any visits on the selected date</p>
                        </div>
                    </td>
                </tr>
                <tr class="user-visit-review-record user-visit-review-record-skeleton none">
                    <td class="fs13 url-col"><a href="" target="_blank" class="bold dark-blue link"></a></td>
                    <td class="fs13 bold lblack hits-col hits"></td>
                </tr>
            </table>
        </div>
    @else
    <div class="section-style flex align-center my8 width-max-content move-to-middle">
        <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
        <p class="fs12 bold lblack no-margin">You cannot review user resources and activities because you don't have permission to do so</p>
    </div>
    @endif
</div>