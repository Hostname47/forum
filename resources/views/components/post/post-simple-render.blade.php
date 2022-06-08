<div>
    <div>
        <div class="flex">
            <div class="size30 rounded hidden-overflow mr4">
                <img src="{{ $postowner->sizedavatar(36, '-l') }}" class="size30" alt="">
            </div>
            <div class="mb8">
                <a href="{{ $postowner->profilelink }}" class="blue bold no-underline mb2">{{ $postowner->fullname }}</a>
                <div class="relative width-max-content">
                    <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Replied') }}: {{ $post->athummans }}</p>
                    <div class="tooltip tooltip-style-1">
                        {{ $post->creationDate }}
                    </div>
                </div>
            </div>
        </div>
        <div class="flex">
            <span class="bold gray mr4 no-wrap fs12">{{__('Reply')}} :</span>
            <div class="expand-box" style="margin-top: -1px">
                <span class="html-entities-decode expandable-text">{{ $post->mediumcontentslice }}</span>
                @if($post->content != $post->mediumcontentslice)
                <input type="hidden" class="expand-slice-text" value="{{ $post->mediumcontentslice }}" autocomplete="off">
                <input type="hidden" class="expand-whole-text" value="{{ $post->content }}" autocomplete="off">
                <input type="hidden" class="expand-text-state" value="0" autocomplete="off">
                <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                <input type="hidden" class="expand-text" value="{{ __('see all') }}" autocomplete="off">
                <input type="hidden" class="collapse-text" value="{{ __('see less') }}" autocomplete="off">
                @endif
            </div>
        </div>
    </div>
    <div class="flex mt8" style="margin-left: 24px">
        <svg class="size15 mr8" style="min-width: 16px" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
        <div style="margin-top: 2px">
            <div class="flex">
                <span class="bold gray fs12 mt4">{{ __('Post') }}</span>
            </div>
            <div class="toggle-box relative">
                <div class="fs12 toggle-container-button flex align-center">
                    <span class="blue bold pointer fs11">{{ __('show parent post') }}</span>
                    <svg class="toggle-arrow size6 ml4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                        <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                    </svg>
                </div>
                <div class="mt8 toggle-container">
                    <div class="flex">
                        <div class="size30 rounded hidden-overflow mr4" style="min-width: 30px">
                            <img src="{{ $threadowner->sizedavatar(36, '-l') }}" class="size30" alt="">
                        </div>
                        <div class="mb8">
                            <a href="{{ $threadowner->profilelink }}" class="blue bold no-underline mb2">{{ $threadowner->fullname }}</a>
                            <div class="relative width-max-content">
                                <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Posted') }}: {{ $thread->athummans }}</p>
                                <div class="tooltip tooltip-style-1">
                                    {{ $thread->postedat }}
                                </div>
                            </div>
                            <div class="mt8">
                                <div class="flex">
                                    <span class="bold fs12 lblack no-wrap mr4" style="margin-top: 3px">{{__('subject')}} :</span>
                                    <a href="{{ $thread->link }}" class="blue no-underline bold">
                                        <span class="fs15">{!! $thread->mediumslice !!}</span>
                                    </a>
                                </div>
                                <div class="flex mt4">
                                    <span class="bold fs12 lblack no-wrap mr4">{{__('content')}} :</span>
                                    @if($thread->type == 'discussion')
                                    <div class="expand-box" style="margin-top: -1px;">
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
                                    @else
                                    <span class="fs12 lblack mr4 italic">{{ __('This is a poll') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>