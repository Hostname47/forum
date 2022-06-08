<div>
    <!-- thread owner -->
    <div class="flex">
        <img src="{{ $threadowner->sizedavatar(100, '-h') }}" class="rounded size30" alt="">
        <div class="ml8">
            <div class="flex align-center">
                <a href="{{ $threadowner->profilelink }}" class="bold blue fs13 no-underline">{{ $threadowner->fullname }}</a>
            </div>
            <p class="lblack fs12 no-margin">{{ $threadowner->username }}</p>
        </div>
    </div>
    <!-- thread forum - category -->
    <div class="flex align-center full-width my8">
        <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            {!! $thread->category->forum->icon !!}
        </svg>
        <div class="flex align-center fs11">
            <div class="flex align-center">
                <span>{{__('Forum')}} :</span>
                <a href="{{ route('forum.all.threads', ['forum'=>$thread->category->forum->slug]) }}" class="black-link path-blue-when-hover">{{ __($thread->category->forum->forum) }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div>
                <span>{{__('Category')}} :</span>
                <a href="{{ $thread->category->link }}" class="black-link path-blue-when-hover">{{ __($thread->category->category) }}</a>
            </div>
        </div>                        
    </div>
    <div class="mt8">
        <div class="flex mt4">
            <span class="bold fs13 gray mr4 no-wrap" style="margin-top: 3px">{{__('subject')}} :</span>
            <a href="{{ $thread->link }}" class="blue no-underline bold mt2">
                <span class="fs14">{!! $thread->mediumslice !!}</span>
            </a>
        </div>
        <div class="flex mt4">
            <span class="bold fs13 gray mr4 no-wrap">{{__('content')}} :</span>
            @if($thread->type == 'discussion')
            <div class="mb4 expand-box">
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
            <span class="fs13 gray mr4 gray italic">{{ __('This is a poll') }}</span>
            @endif
        </div>
    </div>
</div>