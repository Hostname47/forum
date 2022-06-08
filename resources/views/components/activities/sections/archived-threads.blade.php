<div class="activities-section activities-archived-threads-section">
    <div class="activities-section-content-header flex">
        <h3 class="move-to-middle forum-color flex align-center unselectable">
            <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 331.53 331.53"><path d="M197.07,216.42a11,11,0,0,1-11,11H145.46a11,11,0,0,1,0-22h40.61A11,11,0,0,1,197.07,216.42ZM331.53,51.9v68.32a11,11,0,0,1-11,11H313.4V279.63a11,11,0,0,1-11,11H29.13a11,11,0,0,1-11-11V131.22H11a11,11,0,0,1-11-11V51.9a11,11,0,0,1,11-11H320.53A11,11,0,0,1,331.53,51.9ZM291.4,131.22H221.24a56.55,56.55,0,0,1-110.94,0H40.13V268.63H291.4ZM165.77,154.77a34.61,34.61,0,0,0,32.75-23.55H133A34.6,34.6,0,0,0,165.77,154.77ZM309.53,62.9H22v46.32H309.53Z"/></svg>
            {{ __('Archived posts') }} [<span class="current-section-thread-count mx4">{{ 10 * ($archivedthreads->count() / 10) }}</span> / <span class="current-section-global-threads-count mx4">{{ $totalarchivedthreads }}</span> ]
        </h3>
    </div>
    <div class="activities-section-content">
        @foreach($archivedthreads as $thread)
            <x-activities.activity-thread :thread="$thread" :user="$user" :actiontype="$actiontype"/>
        @endforeach
        @if($totalarchivedthreads > 10)
        <div class="flex activity-section-load-more">
            <input type="hidden" class="section" value="archived-threads" autocomplete="off">
            <input type="hidden" class="lock" value="stable" autocomplete="off">
            <div class="flex align-center move-to-middle">
                <p class="bold no-margin mr8 fs14 blue">{{ __('Load more') }}</p>
                <svg class="spinner size15 blue opacity0" fill='none' viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
        </div>
        @endif
        @if(!$archivedthreads->count())
            <div class="full-center" style="margin-top: 46px">
                <div class="flex flex-column align-center">
                    <svg class="size48 my4" viewBox="0 0 442 442"><path d="M442,268.47V109.08a11.43,11.43,0,0,0-.1-1.42,2.51,2.51,0,0,0,0-.27,10.11,10.11,0,0,0-.29-1.3v0c-.1-.31-.21-.62-.34-.92l-.12-.26-.15-.32c-.17-.34-.36-.67-.56-1a.57.57,0,0,1-.08-.13,10.33,10.33,0,0,0-.81-1l-.17-.18a8,8,0,0,0-.84-.81l-.14-.12a9.65,9.65,0,0,0-1.05-.76l-.26-.15a8.61,8.61,0,0,0-1.05-.53.67.67,0,0,0-.12-.06l-236-99-.06,0-.28-.1a10,10,0,0,0-4.4-.61h-.08a10.59,10.59,0,0,0-1.94.39l-.12,0c-.27.09-.55.18-.82.29l0,0-69.22,29a10,10,0,0,0,0,18.44L186,74.73v88.16L6.13,238.37l-.36.17-.36.17c-.28.15-.55.31-.82.48l-.13.07s0,0,0,0a9.86,9.86,0,0,0-1,.72l-.09.08c-.25.23-.49.46-.72.71l-.2.22a8.19,8.19,0,0,0-.53.67c-.07.08-.13.17-.19.25-.18.27-.34.54-.5.81l-.09.15c-.17.33-.32.67-.46,1,0,.09-.07.19-.1.28-.09.26-.18.53-.25.79l-.09.35c-.06.28-.12.55-.16.83,0,.1,0,.19,0,.28A11.87,11.87,0,0,0,0,247.62V333a10,10,0,0,0,6.13,9.22l235.92,99a9.8,9.8,0,0,0,1.95.6l.19,0c.26.05.52.09.79.12s.66.05,1,.05.67,0,1-.05.53-.07.79-.12l.19,0a9.8,9.8,0,0,0,2-.6l186-78A10,10,0,0,0,442,354V268.47ZM330.23,300.4l-63.15-26.49a10,10,0,0,0-7.74,18.44l45,18.9L246,335.75,137.62,290.29l58.4-24.5,35.53,14.9a10,10,0,1,0,7.74-18.44l-33.27-14V184.58l200.13,84ZM186,248.29l-74.25,31.16L35.85,247.59l150.17-63v63.71ZM196,20.84,406.15,109l-43.37,18.2L200,58.89l-.09,0L152.65,39Zm162.82,126.4a10,10,0,0,0,7.81,0L422,124.05V253.51L206,162.89V83.13ZM20,262.63l216,90.62V417L20,326.34ZM422,347.3,256,417V353.25l166-69.66Z"/></svg>
                    <p class="fs20 text-center bold my8">{{ __("You don't have any archived posts") }}.</p>
                </div>
            </div>
        @endif
    </div>
</div>