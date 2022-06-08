<div id="thread-report-container" class="report-resource-container none">
    @php $already_reported = $thread->already_reported; @endphp
    <input type="hidden" class="reportable-id" value="">
    <input type="hidden" class="reportable-type" value="thread">
    <div class="close-report-container x-close-container-style" style="top: 12px; right: 12px">
        <span class="x-close">✖</span>
    </div>
    <div class="@if(!$already_reported) none @endif already-reported-container">
        <div class="flex align-center justify-center move-to-middle">
            <svg class="size17 mr8" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"/></svg>
            <h2 class="text-center gray my8">{{ __('You already report this post') }}.</h2>
        </div>
        <p class="text-center my8">{{ __('We have received your report submit and we are going to verify if this post respects our guidelines and standards as soon as possible') }}.</p>
    </div>
    @if(!$already_reported)
    <div class="report-section">
        <div style="width: calc(100% - 20px);">
            <div class="flex">
                <svg class="size17 mr4" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"/></svg>
                <h3 class="no-margin mb8">{{ __('I am flagging to report this post as') }}... </h3>
            </div>
        </div>
        <div>
            <label class="resource-report-option">
                <input type="radio" name="report" value="spam" class="height-max-content report-choice-input" autocomplete="off">
                <div class="ml8">
                    <p class="bold no-margin">{{__('spam')}}</p>
                    <p class="no-margin gray">{{__("Exists only to promote a product or service, does not disclose the author's affiliation, repetitive or out of topic")}}.</p>
                </div>
            </label>
            <label class="resource-report-option">
                <input type="radio" name="report" value="rude-or-abusive" class="height-max-content report-choice-input" autocomplete="off">
                <div class="ml8">
                    <p class="bold no-margin">{{__('rude or abusive')}}</p>
                    <p class="no-margin gray">{{__('A reasonable person would find this content inappropriate for respectful discourse')}}.</p>
                </div>
            </label>
            <label class="resource-report-option">
                <input type="radio" name="report" value="low-quality" class="height-max-content report-choice-input" autocomplete="off">
                <div class="ml8">
                    <p class="bold no-margin">{{__('very low quality')}}</p>
                    <p class="no-margin gray">{{__('This post has severe formatting or content problems. This post is unlikely to be salvageable through editing, and might need to be removed')}}.</p>
                </div>
            </label>
            <label class="resource-report-option has-child-to-be-opened">
                <input type="radio" name="report" value="moderator-intervention" class="height-max-content report-choice-input" autocomplete="off">
                <div class="ml8">
                    <p class="bold no-margin">{{__('in need of moderator intervention')}}</p>
                    <p class="no-margin gray">{{__('A problem not listed above that requires action by a moderator')}}. <i>{{__('Be specific and detailed')}}!</i></p>
                    <div class="child-to-be-opened">
                        <textarea name="content" class="report-section-textarea" placeholder="{{ __('Be specific and detailed') }}"></textarea>
                        <p class="no-margin ml4 fs12 gray report-content-counter"><span class="report-content-count"></span> <span class="report-content-count-phrase">{{ __('Enter at least 10 characters') }}</span></p>
                        <input type="hidden" class="first-phrase-text" value="{{ __('Enter at least 10 characters') }}">
                        <input type="hidden" class="more-to-go-text" value="{{ __('more to go') }}..">
                        <input type="hidden" class="chars-left-text" value="{{ __('characters left') }}">
                        <input type="hidden" class="too-long-text" value="{{ __('Too long by ') }}">
                        <input type="hidden" class="characters-text" value="{{ __('characters') }}">
                    </div>
                </div>
            </label>
        </div>
        <p class="fs12 my8 lh15">{{__('Please check carefully your report before submit it, because inappropriate or random reports could lead')}} <strong>{{__('your account to be banned')}}</strong> !</p>
        <div class="flex align-center" style="margin-top: 12px">
            <div id="submit-thread-report-button" class="blue-button-style disabled-blue-button-style submit-report-button flex align-center">
                <svg class="spinner size14 none mr8" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
                <span class="fs13 unselectable">{{__('Submit')}}</span>
            </div>
            <div class="pointer close-report-container link-path ml8">{{ __('Cancel') }}</div>
            <input type="hidden" class="reported-text" value="{{ __('Your report has been sent successfully') }}" autocomplete="off">
        </div>
    </div>
    @endif
</div>