

<tr 
    @if($resourcetype=='thread')
    id="threadreport{{$thread->id}}"
    @elseif($resourcetype=='post')
    id="postreport{{$post->id}}"
    @endif

    style="background-color: 
    @if($resourcetype=='thread') #f3fcff78
    @elseif($resourcetype=='post') #effff47a
    @endif">
    <td>
        @if($resourcetype=='thread')
            <div class="flex space-between">
                <div class="flex">
                    <div class="size30 rounded hidden-overflow mr8" style="min-width: 30px">
                        <img src="{{ $threadowner->sizedavatar(36, '-l') }}" class="size30" alt="">
                    </div>
                    <div class="mb8">
                        <a href="{{ $threadowner->profilelink }}" class="blue bold no-underline mb2">{{ $threadowner->fullname }}</a>
                        <div class="relative">
                            <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Posted') }}: {{ $thread->athummans }}</p>
                            <div class="tooltip tooltip-style-1">
                                {{ $thread->postedat }}
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    @if($reports_count > 1)
                    <div class="flex height-max-content fs11 mb4">
                        <svg class="size10 mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"></path></svg>
                        <div>
                            <div class="flex align-center">
                                <div class="lblack ml4"><strong class="mr4">total reports:</strong> {{ $reports_count }}</div>
                                <div class="flex full-center see-other-reports pointer ml8 relative">
                                    <span class="pointer blue bold button-text">see all</span>
                                    <svg class="spinner size12 absolute none" style="color: #2ca0ff;" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                    <input type="hidden" class="report-id" aotocomplete="off" value="{{ $report->id }}">
                                </div>
                            </div>
                            @if($unreviewed_reports_count)
                            <div class="lblack ml4 bold">({{ $unreviewed_reports_count }} unreviewed)</div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($resourcereviewed)
                    <div class="flex align-center height-max-content">
                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                        <p class="bold no-margin fs11" style="color: #44a644">{{ __("resource reviewed") }}</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="flex align-center height-max-content mt8">
                <span class="fs11 mr4 lblack bold">Forum : </span>
                <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="fs11 black-link flex align-center">
                    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        {!! $forum->icon !!}
                    </svg>
                    <span class="flex align-center path-blue-when-hover">
                        {{ __($forum->forum) }}</a>
                    </span>
                </a>
            </div>
            <div class="flex mt8">
                <div class="flex">
                    <span class="fs11 bold forum-color no-wrap mr4">Thread title :</span>
                    <a href="{{ route('thread.show', ['forum'=>$forum->slug, 'category'=>$category->slug, 'thread'=>$thread->id]) }}" class="bold blue no-underline" style="margin-top: -1px">{!! $thread->mediumslice !!}</a>
                </div>
            </div>
        @elseif($resourcetype=='post')
        <div class="flex space-between">
            <div class="flex">
                <div class="size30 rounded hidden-overflow mr8">
                    <img src="{{ $postowner->sizedavatar(36, '-l') }}" class="size30" alt="">
                </div>
                <div class="mb8">
                    <a href="{{ $postowner->profilelink }}" class="blue bold no-underline mb2 fs13">{{ $postowner->fullname }}</a>
                    <div class="relative">
                        <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Posted') }}: {{ $post->athummans }}</p>
                        <div class="tooltip tooltip-style-1">
                            {{ $post->postedat }}
                        </div>
                    </div>
                </div>
            </div>
            <div>
            @if($reports_count > 1)
            <div class="flex height-max-content fs11 mb4">
                <svg class="size10 mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"></path></svg>
                <div>
                    <div class="flex align-center">
                        <div class="lblack ml4"><strong class="mr4">total reports:</strong> {{ $reports_count }}</div>
                        <div class="flex full-center see-other-reports pointer ml8 relative">
                            <span class="pointer blue bold button-text">see all</span>
                            <svg class="spinner size12 absolute none" style="color: #2ca0ff;" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                            <input type="hidden" class="report-id" aotocomplete="off" value="{{ $report->id }}">
                        </div>
                    </div>
                    @if($unreviewed_reports_count)
                    <div class="lblack ml4 bold">({{ $unreviewed_reports_count }} unreviewed)</div>
                    @endif
                </div>
            </div>
            @endif
            @if($resourcereviewed)
            <div class="flex align-center height-max-content">
                <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                <p class="bold no-margin fs12" style="color: #44a644">{{ __("resource reviewed") }}</p>
            </div>
            @endif
            </div>
        </div>
        <div class="flex mt8">
            <span class="mr4 bold forum-color fs12 no-wrap">reply content :</span>
            <p class="no-margin" style='margin-top: -2px'>{{ $content }}</p>
        </div>
        @endif
    </td>
    <td>
        @if($resourcetype == 'thread')
        <div class="flex align-center justify-center">
            <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,17.11h97.27c11.82,0,15.64,3.73,15.64,15.34q0,75.07,0,150.16c0,11.39-3.78,15.13-15.22,15.13-2.64,0-5.3.12-7.93-.06a11.11,11.11,0,0,1-10.53-9.38c-.81-5.69,2-11,7.45-12.38,3.28-.84,3.52-2.36,3.51-5.06-.07-27.15-.11-54.29,0-81.43,0-3.68-1-4.69-4.68-4.68q-85.63.16-171.29,0c-3.32,0-4.52.68-4.5,4.33q.26,41,0,81.95c0,3.72,1.3,4.53,4.56,4.25a45.59,45.59,0,0,1,7.39.06,11.06,11.06,0,0,1,10.58,11c0,5.62-4.18,10.89-9.91,11.17-8.43.4-16.92.36-25.36,0-5.16-.23-8.82-4.31-9.68-9.66a33,33,0,0,1-.24-5.27q0-75.08,0-150.16c0-11.61,3.81-15.34,15.63-15.34Zm22.49,45.22c16.56,0,33.13,0,49.7,0,5.79,0,13.59,2,16.83-.89,3.67-3.31.59-11.25,1.19-17.13.4-3.92-1.21-4.54-4.73-4.51-19.21.17-38.42.08-57.63.08-22.73,0-45.47.11-68.21-.1-4,0-5.27,1-4.92,5a75.62,75.62,0,0,1,0,12.68c-.32,3.89.78,5,4.85,5C110.54,62.21,131.51,62.33,152.49,62.33ZM62.3,51.13c0-11.26,0-11.26-11.45-11.26h-.53c-10.47,0-10.47,0-10.47,10.71,0,11.75,0,11.75,11.49,11.75C62.3,62.33,62.3,62.33,62.3,51.13ZM102,118.66c25.79.3,18.21-2.79,36.49,15.23,18.05,17.8,35.89,35.83,53.8,53.79,7.34,7.35,7.3,12.82-.13,20.26q-14.94,15-29.91,29.87c-6.86,6.81-12.62,6.78-19.5-.09-21.3-21.28-42.53-42.64-63.92-63.84a16.11,16.11,0,0,1-5.24-12.62c.23-9.86,0-19.73.09-29.59.07-8.71,4.24-12.85,13-13C91.81,118.59,96.92,118.66,102,118.66ZM96.16,151c.74,2.85-1.53,6.66,1.41,9.6,17.66,17.71,35.39,35.36,53,53.11,1.69,1.69,2.59,1.48,4.12-.12,4.12-4.34,8.24-8.72,12.73-12.67,2.95-2.59,2.36-4-.16-6.49-15.68-15.46-31.4-30.89-46.63-46.79-4.56-4.76-9.1-6.73-15.59-6.35C96.18,141.8,96.16,141.41,96.16,151Z"></path></svg>
            <p class="my4 fs15 bold forum-color">thread</p>
        </div>
        @elseif($resourcetype == 'post')
        <div class="flex align-center justify-center">
            <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
            <p class="my4 fs15 bold forum-color">reply</p>
        </div>
        @endif
    </td>
    <td>
        <p class="no-margin bold">{{ $report->type }}</p>
        @if($report->type == 'moderator-intervention')
        <div>
            <div class="button-with-left-icon view-report-body pointer fs11 mt8 bold">
                <svg class="mr4 size13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px; margin-top: 2px"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                view message
                <input type="hidden" class="report-id" value="{{ $report->id }}" autocomplete="off">
            </div>
        </div>
        @endif
    </td>
    <td>
        <div class="full-center flex-column">
            <div class="size36 rounded hidden-overflow mr4">
                <img src="{{ $reporter->sizedavatar(100, '-l') }}" class="size36" alt="">
            </div>
            <a href="{{ $reporter->profilelink }}" class="blue bold no-underline mb2 fs12">{{ $reporter->username }}</a>
            <span class="lblack fs12 bold">({{ $reporter->fullname }})</span>
            <div class="relative">
                <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Reported') }}: {{ $athummans }}</p>
                <div class="tooltip tooltip-style-1">
                    {{ $at }}
                </div>
            </div>
        </div>
    </td>
    <td>
        @if($resourcetype == 'thread')
        <div class="button-with-left-icon fs11 width-max-content render-thread" style="padding: 3px 8px">
            <div class="relative size14 full-center mr4">
                <svg class="size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px; margin-top: 2px"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                <svg class="spinner size12 absolute none" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
            <span class="bold lblack">render thread</span>
            <input type="hidden" class="thread-id" value="{{ $thread->id }}">
        </div>
        <a href="{{ route('admin.thread.manage') . '?threadid=' . $thread->id }}" target="_blank" class="button-with-left-icon width-max-content no-underline bold lblack fs11 my8" style="padding: 3px 8px">
            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
            <span>manage thread</span>
            <svg class="size12 ml4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352,289V416H64V128h96V64H32A32,32,0,0,0,0,96V448a32,32,0,0,0,32,32H384a32,32,0,0,0,32-32V289Z"></path><path d="M505.6,131.2l-128-96A16,16,0,0,0,352,48V96H304C206.94,96,128,175,128,272a16,16,0,0,0,12.32,15.59A16.47,16.47,0,0,0,144,288a16,16,0,0,0,14.3-8.83l3.78-7.52A143.2,143.2,0,0,1,290.88,192H352v48a16,16,0,0,0,25.6,12.8l128-96a16,16,0,0,0,0-25.6Z"></path></svg>
        </a>
        @elseif($resourcetype == 'post')
        <div class="button-with-left-icon fs11 width-max-content render-post" style="padding: 3px 8px">
            <div class="relative size14 full-center mr4">
                <svg class="size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px; margin-top: 1px"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                <svg class="spinner size12 absolute none" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
            <span class="bold lblack">render reply</span>
            <input type="hidden" class="post-id" value="{{ $post->id }}">
        </div>
        <a href="{{ route('admin.post.manage') . '?postid=' . $post->id }}" target="_blank" class="button-with-left-icon width-max-content no-underline bold lblack fs11 my8" style="padding: 3px 8px">
            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
            <span>manage reply</span>
            <svg class="size12 ml4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352,289V416H64V128h96V64H32A32,32,0,0,0,0,96V448a32,32,0,0,0,32,32H384a32,32,0,0,0,32-32V289Z"></path><path d="M505.6,131.2l-128-96A16,16,0,0,0,352,48V96H304C206.94,96,128,175,128,272a16,16,0,0,0,12.32,15.59A16.47,16.47,0,0,0,144,288a16,16,0,0,0,14.3-8.83l3.78-7.52A143.2,143.2,0,0,1,290.88,192H352v48a16,16,0,0,0,25.6,12.8l128-96a16,16,0,0,0,0-25.6Z"></path></svg>
        </a>
        @endif
    </td>
</tr>