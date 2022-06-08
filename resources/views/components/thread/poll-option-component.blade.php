<div id="polloption{{ $option->id }}" class="poll-option-box flex align-center mb8">
    <input type="hidden" class="voted" autocomplete="off" value="{{ $int_voted }}">
    <input type="hidden" class="option-id" autocomplete="off" value="{{ $option->id }}">
    <div class="flex align-center pointer 
        @auth vote-option
            @if($multiplevoting) custom-checkbox-button @else custom-radio-button @endif 
        @endauth 
        @guest login-signin-button @endguest">
        <input type="hidden" class="optionid" autocomplete="off" value="{{ $option->id }}">
        @if($multiplevoting)
        <div class="custom-checkbox-background mr4">
            <div class="custom-checkbox @if($voted) custom-checkbox-checked @endif" style="width: 20px; height: 20px">
                <svg class="size14 custom-checkbox-tick @if(!$voted) none @endif" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                <input type="hidden" class="checkbox-status" autocomplete="off" value="{{ $int_voted }}">
            </div>
        </div>
        @else
        <div class="custom-radio-background mr4">
            <div class="custom-radio @if($voted) custom-radio-checked @endif size18">
                <span class="radio-check-tick @if(!$voted) none @endif" style="width: 14px; height: 14px"></span>
                <input type="hidden" class="radio-status" autocomplete="off" value="{{ $int_voted }}">
            </div>
        </div>
        @endif
        <div class="relative poll-option-container full-width">
            <div class="vote-option-percentage-strip" style="width: {{ $vote_percentage }}%;"> <!-- vote percentage --></div>
            <div class="relative" style="z-index: 1">
                <span class="gray fs11 block unselectable">{{ __('Added by') }} {!! $addedby !!}</span>
                <p class="poll-option-value no-margin mt4 fs16 unselectable">{{ $option->content }}</p>
            </div>
        </div>
    </div>
    <div class="ml8">
        @php
            $vtext = ($votevalue > 1) ? __('votes') : __('vote');
        @endphp
        <span class="block fs11 gray">(<span class="option-vote-percentage">{{ $vote_percentage }}</span>%)</span>
        <div class="block forum-color"><span class="option-vote-count">{{ $votevalue }}</span><span style="margin-left: 2px">{{ $vtext }}</span></div>
    </div>
    @if($poll_owner)
    <div class="open-option-delete-check-view move-to-right">
        <svg class="mx8 size12 simple-icon-button-style" style="padding:6px; margin-bottom: 2px" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 95.94 95.94"><path d="M62.82,48,95.35,15.44a2,2,0,0,0,0-2.83l-12-12A2,2,0,0,0,81.92,0,2,2,0,0,0,80.5.59L48,33.12,15.44.59a2.06,2.06,0,0,0-2.83,0l-12,12a2,2,0,0,0,0,2.83L33.12,48,.59,80.5a2,2,0,0,0,0,2.83l12,12a2,2,0,0,0,2.82,0L48,62.82,80.51,95.35a2,2,0,0,0,2.82,0l12-12a2,2,0,0,0,0-2.83Z"></path></svg>
        <input type="hidden" class="optionid" autocomplete="off" value="{{ $option->id }}">
    </div>
    @endif
</div>