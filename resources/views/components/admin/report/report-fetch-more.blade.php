<tr>
    <td>
        <div class="flex align-center">
            <div class="size30 rounded hidden-overflow" style="min-width: 30px;">
                <img src="{{ $reporter->sizedavatar(36, '-l') }}" class="size30" alt="">
            </div>
            <div class="ml8" style="margin-top: -2px">
                <a href="{{ $reporter->profilelink }}" class="blue bold no-underline mb2 fs12">{{ $reporter->username }}</a>
                <span class="block lblack fs12 bold">({{ $reporter->fullname }})</span>
            </div>
        </div>
        <div class="relative width-max-content">
            <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Reported') }}: {{ $athummans }}</p>
            <div class="tooltip tooltip-style-1">
                {{ $at }}
            </div>
        </div>
    </td>
    <td>
        <p class="no-margin unselectable bold">{{ $report->type }}</p>
    </td>
    <td>
        @if($report->type == 'moderator-intervention')
            <p class="no-margin lblack fs12">
                <span class="bold mr4 block mb2">report message :</span>
                <span>{{ $report->body }}</span>
            </p>
        @else
            <em class="gray">null</em>
        @endif
    </td>
    <td>
        @if($report->reviewed)
        <span class="bold fs12 green-message">YES</span>
        @else
        <span class="bold fs12 red">NO</span>
        @endif
    </td>
</tr>