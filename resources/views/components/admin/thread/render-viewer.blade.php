<div>
    <style>
        .media-container {
            display: flex;
            justify-content: center;
            width: 100px;
            min-width: 100px;
            height: 100px;
            margin-right: 8px;
            border-radius: 2px;
            overflow: hidden;
            background-color: #dfdfdf;
        }

        .medias-container {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #d5d5d5;
        }
    </style>
    <div>
        <!-- thread owner -->
        <div class="flex">
            <img src="{{ $threadowner->sizedavatar(36, '-h') }}" class="rounded size36" alt="">
            <div class="ml8">
                <div class="flex align-center">
                    <a href="{{ $threadowner->profilelink }}" class="bold blue fs13 no-underline">{{ $threadowner->fullname }}</a>
                    <p class="lblack fs11 no-margin ml4">- {{ $threadowner->username }}</p>
                </div>
                <div class="relative width-max-content">
                    <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top: 1px">Posted: {{ $thread->athummans }}</p>
                    <div class="tooltip tooltip-style-1">
                        {{ $thread->postedat }}
                    </div>
                </div>
                <div class="flex align-center gray mt2 fs11" title="{{ $thread->visibility->visibility }}">
                    <span class="mr4">Visibility :</span>
                    <svg class="size11 thread-resource-visibility-icon" style="fill: #202020;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        {!! $thread->visibility->icon !!}
                    </svg>
                    <span class="ml4 bold">{{ $thread->visibility->visibility }}</span>
                </div>
            </div>
        </div>
        <!-- thread forum - category -->
        <div class="flex align-center full-width my8">
            <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                {!! $thread->category->forum->icon !!}
            </svg>
            <div class="flex align-center fs11">
                <div class="flex align-center">
                    <span>Forum :</span>
                    <a href="{{ route('forum.all.threads', ['forum'=>$thread->category->forum->slug]) }}" class="black-link path-blue-when-hover">{{ __($thread->category->forum->forum) }}</a>
                </div>
                <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                <div>
                    <span>Category :</span>
                    <a href="{{ $thread->category->link }}" class="black-link path-blue-when-hover">{{ __($thread->category->category) }}</a>
                </div>
            </div>                        
        </div>
        <div class="flex align-center lblack mb4">
            <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M143.07,255.58H115.63c-1.47-1.93-3.77-1.5-5.71-1.8A115.72,115.72,0,0,1,68.3,239c-34.6-20.48-56-50.43-61.72-90.34-6.69-47,8.7-86.63,45.66-116.2C89.37,2.76,131.66-3.41,176.08,13.73c38.41,14.82,63.1,43.15,75,82.64,2,6.63,2,13.66,4.7,20.07v28.42c-1.92.89-1.35,2.86-1.55,4.26A110.34,110.34,0,0,1,247,175.93q-23.64,57.1-82.86,74.95C157.2,253,149.88,253.09,143.07,255.58ZM130.61,32.19c-53.67-.25-97.8,43.5-98.28,97.44-.48,53.76,43.66,98.25,97.72,98.5,53.67.26,97.8-43.49,98.28-97.44C228.81,76.94,184.67,32.45,130.61,32.19Z"/><path d="M157.75,130.06a27.42,27.42,0,1,1-27.52-27.31A27.63,27.63,0,0,1,157.75,130.06Z"/></svg>
            <p class="no-margin fs12 bold">thread status :</p>
            @php
                $threadstatus = $thread->status;
                $scolor = 'green';
                if($threadstatus->slug != 'live')
                    $scolor = 'red';
            @endphp
            <span class="bold fs13 {{ $scolor }} ml4">{{ $threadstatus->status }}</span>
        </div>
        <div class="flex align-center lblack">
            <div class="flex align-center">
                <svg class="size12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M10.11,66.39c-4.06,0-7.63-2.06-9.09-5.25a6.9,6.9,0,0,1,1.21-7.62L42.11,7.29A10.25,10.25,0,0,1,50,3.92a10.28,10.28,0,0,1,7.87,3.37L97.8,53.5A6.92,6.92,0,0,1,99,61.13c-1.47,3.18-5,5.24-9.08,5.24H75.74V55.77h4.42a1.83,1.83,0,0,0,1.67-1A1.61,1.61,0,0,0,81.57,53L51.39,18A1.9,1.9,0,0,0,48.61,18L18.42,53a1.61,1.61,0,0,0-.26,1.75,1.83,1.83,0,0,0,1.67,1h4.26V66.39Zm58.1,29.69a7.56,7.56,0,0,0,7.53-7.58V55.78H63.89v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58Z" style="fill:#010202"></path></svg>
                <span class="fs12 bold mx4">vote value :</span>
                <span class="fs12 bold">{{ $thread->votevalue }}</span>
            </div>
            <div class="gray height-max-content mx8 fs10">•</div>
            <div class="flex align-center">
                <svg class="size12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84"><path d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/></svg>
                <span class="fs12 bold mx4">{{ $thread->likes()->count() }}</span>
                <span class="fs12 bold">likes</span>
            </div>
            <div class="gray height-max-content mx8 fs10">•</div>
            <div class="flex align-center">
                <svg class="size12" xmlns="http://www.w3.org/2000/svg" fill="#1c1c1c" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                <span class="fs12 bold mx4">{{ $thread->posts()->count() }}</span>
                <span class="fs12 bold">replies</span>
            </div>
            <div class="simple-border-container flex align-center move-to-right" title="{{ __('views') }}">
                <svg class="mr4 size13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                <p class="no-margin fs11 bold unselectable" style="margin-top: 1px">{{ $thread->view_count }}</p>
            </div>
        </div>
        <div class="mt8 section-style white-background" style="padding: 8px">
            <div class="flex">
                <span class="bold fs13 gray mr4 no-wrap" style="margin-top: 3px">subject :</span>
                <a href="{{ $thread->link }}" class="blue no-underline bold mt2">
                    <span class="fs14">{!! $thread->mediumslice !!}</span>
                </a>
            </div>
            @if($thread->type == 'discussion')
            <div class="flex mt8">
                <span class="bold fs13 gray mr4">content :</span>
                <div class="expand-box">
                    <span class="thread-title-text html-entities-decode expandable-text block full-width">{{ $thread->mediumcontentslice }}</span>
                    @if($thread->content != $thread->mediumcontentslice)
                    <input type="hidden" class="expand-slice-text" value="{{ $thread->mediumcontentslice }}">
                    <input type="hidden" class="expand-whole-text" value="{{ $thread->content }}">
                    <input type="hidden" class="expand-text-state" value="0">
                    <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                    <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                    <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                    @endif
                </div>
            </div>
            @elseif($thread->type == 'poll')
                <div class="mt8">
                    <span class="mt4 fs12 gray">This is a poll, and the following are it options</span>
                    <span class="block my4 bold fs13 gray">poll options :</span>
                    <div class="thread-poll-options-container">
                        @foreach($options as $option)
                            @php
                                $votescount = $option->votes()->count();
                                $vpercentage = ($totalpollvotes == 0) ? 0 : floor($votescount * 100 / $totalpollvotes);
                                $optionuser = $option->user;
                            @endphp
                            <div class="poll-option-box flex align-center mb8">
                                <div class="flex align-center pointer" style="flex: 1;">
                                    <div class="relative poll-option-container full-width" style="flex: 1;">
                                        <div class="vote-option-percentage-strip" style="width: {{ $vpercentage }}%;"> <!-- vote percentage --></div>
                                        <div class="relative" style="z-index: 1">
                                            <span class="gray fs11 block unselectable">{{ __('Added by') }} <a href="{{ route('admin.user.manage') . '?uid=' . $optionuser->id }}" target="_blank" class="blue no-underline stop-propagation underline-when-hover">{{ $optionuser->username }}</a></span>
                                            <p class="poll-option-value no-margin mt4 fs16 unselectable">{{ $option->content }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml8">
                                    <span class="block fs11 gray">(<span class="option-vote-percentage">{{ $vpercentage }}</span>%)</span>
                                    <div class="block forum-color"><span class="option-vote-count">{{ $votescount }}</span><span style="margin-left: 2px">{{ ($votescount > 1) ? 'votes' : 'vote' }}</span></div>
                                </div>
                            </div>
                        @endforeach
                        <!-- display more options if exists -->
                        @if($hasmoreoptions)
                        <div class="flat-button-style unselectable fetch-raw-remaining-poll-options border-box mb8" style="padding: 10px; width: calc(100% - 45px)">
                            Load more options
                            <div class="relative size7 ml4 full-center">
                                <svg class="flex size7 icon-above-spinner mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                                <svg class="spinner size10 opacity0 absolute mt2" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <input type="hidden" class="thread-id" value="{{ $thread->id }}" autocomplete="off">
                        </div>
                        @endif
                    </div>
                    <div class="poll-option-box poll-option-box-skeleton flex align-center mb8 none">
                        <div class="flex align-center pointer" style="flex: 1;">
                            <div class="relative poll-option-container full-width" style="flex: 1;">
                                <div class="vote-option-percentage-strip percentage" style=""><!-- vote percentage --></div>
                                <div class="relative" style="z-index: 1">
                                    <span class="gray fs11 block unselectable">{{ __('Added by') }} <a href="" target="_blank" class="blue no-underline stop-propagation underline-when-hover added-by"></a></span>
                                    <p class="no-margin mt4 fs16 unselectable content"></p>
                                </div>
                            </div>
                        </div>
                        <div class="ml8">
                            <span class="block fs11 gray">(<span class="percentage-text"></span>%)</span>
                            <div class="block forum-color"><span class="vote-count"></span><span style="margin-left: 2px">votes</span></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if($thread->hasmedias)
        <div class="mt8">
            <span class="block bold fs13 gray mb4">Medias :</span>
            <div class="flex x-auto-overflow medias-container">
                @foreach($medias as $media)
                <div class="media-container pointer">
                    @if($media['type'] == 'image')
                    <img src="{{ asset($media['source']) }}" alt="" class="lazy-image dims-fit-content open-image-on-image-viewer">
                    @else
                    <video class="full-dimensions" controls preload="none">
                        <source src="{{ asset($media['source']) }}" type="{{ $media['mime'] }}">
                        {{ __('Your browser does not support the video tag') }}
                    </video>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($thread->hasmediatrash)
        <div class="mt8">
            <span class="block bold fs13 gray">Trashed Medias :</span>
            <span class="block lblack fs12 mb4">The following medias are deleted by thread owner</span>
            <div class="flex x-auto-overflow medias-container">
                @foreach($trashedmedias as $media)
                <div class="media-container pointer relative">
                    @if($media['type'] == 'image')
                    <img src="{{ asset($media['source']) }}" alt="" class="lazy-image dims-fit-content open-image-on-image-viewer">
                    @else
                    <video class="full-dimensions" controls preload="none">
                        <source src="{{ asset($media['source']) }}" type="{{ $media['mime'] }}">
                        {{ __('Your browser does not support the video tag') }}
                    </video>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>