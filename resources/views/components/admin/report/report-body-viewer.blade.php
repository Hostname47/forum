<span class="bold block bold lblack fs13 mb4">Resource reported:</span>
<div class="section-style" style="padding: 10px;">
    @if($resourcetype=='thread')
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
    <div class="flex">
        <div class="size30 rounded hidden-overflow mr8">
            <img src="{{ $postowner->sizedavatar(36, '-l') }}" class="size30" alt="">
        </div>
        <div class="mb8">
            <a href="{{ $postowner->profilelink }}" class="blue bold no-underline mb2 fs13">{{ $postowner->fullname }}</a>
            <div class="relative">
                <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Posted') }}: {{ $post->athummans }}</p>
                <div class="tooltip tooltip-style-1">{{ $post->postedat }}</div>
            </div>
        </div>
    </div>
    <div class="flex mt8">
        <span class="mr4 bold forum-color fs12 no-wrap">reply content :</span>
        <p class="no-margin" style='margin-top: -2px'>{{ $content }}</p>
    </div>
    @endif
</div>
<p class="my8 lblack fs13"><span class="bold">Report type :</span> Moderator intervention</p>
<div class="section-style" style="padding: 10px;">
    <div class="flex">
        <img src="{{ $reporter->sizedavatar(100, '-l') }}" class="size36 rounded" style="border: 1px solid #c4c4c4;" alt="">
        <div class="ml8">
            <a href="{{ $reporter->profilelink }}" class="blue bold no-underline mb2 fs12">{{ $reporter->username }}</a>
            <span class="lblack fs12 bold">({{ $reporter->fullname }}) - reporter</span>
            <div class="relative">
                <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Reported') }}: {{ $athummans }}</p>
                <div class="tooltip tooltip-style-1">
                    {{ $at }}
                </div>
            </div>
        </div>
    </div>
    <span class="bold block bold lblack fs13 mt8 mb4">Report message :</span>
    <p class="no-margin lblack fs13">{{ $report->body }}</p>
</div>