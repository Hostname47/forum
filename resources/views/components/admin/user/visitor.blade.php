<div class="visitor-record-container">
    <div class="flex">
        @if($guest)
        <img src="{{ \App\Models\User::defaultavatar(100) }}" class="rounded size32" alt="">
        @else
        <img src="{{ $visitor->sizedavatar(36, '-h') }}" class="rounded size32" alt="">
        @endif
        <div class="ml8">
            <div class="flex align-center">
                @if($guest)
                <p class="no-margin bold fs13 no-underline"><em class="fs12 gray">guest</em> - <span class="blue">{{ $visitor_ip }}</span></p>
                @else
                <a href="{{ $visitor->profilelink }}" class="bold blue fs13 no-underline">{{ $visitor->fullname }}</a>
                @endif
                <div class="gray height-max-content mx8 fs10">•</div>
                <div class="relative height-max-content">
                    <p class="no-margin fs11 flex align-center tooltip-section lblack">visited : {{ $visited_at_hummans }}</p>
                    <div class="tooltip tooltip-style-1" style="right: 0; left: auto;">
                        {{ $visited_at }}
                    </div>
                </div>
            </div>
            @if(!$guest)
            <p class="lblack fs11 bold no-margin">{{ $visitor->username }}</p>
            @endif
        </div>
    </div>
</div>