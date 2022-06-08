@foreach($forums as $forum)
<div class="flex align-center">
    <div class="suboption-style-1 flex align-center full-width fs13 {{ $operation_class }}">
        <div class="flex" style="max-width: 200px; width: 200px;">
            <svg class="size13 mr4 mt2" style="min-width: 13px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                {!! $forum->icon !!}
            </svg>
            <span class="forum-name unselectable">{{ __($forum->forum) }}</span>
        </div>
        <div class="fs10 unselectable" style="margin: 0 12px">•</div>
        <div class="flex align-center">
            <span class="bold fs13 mr4 unselectable">Status :</span>
            @php
                $fscolor = 'green';
                $status = $forum->status;
                $fscolor = ($status->slug == 'live') ? 'green' : (($status->slug == 'closed') ? 'red' : (($status->slug == 'under-review') ? 'blue' : 'gray' ));
            @endphp
            <span class="{{ $fscolor }} bold unselectable">{{ $status->status }}</span>
        </div>
        <input type="hidden" class="forum-id" value="{{ $forum->id }}" autocomplete="off">
    </div>
</div>
@endforeach