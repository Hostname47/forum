<div>
    <p class="no-margin mb4 fs13 lblack">The following visitors are sorted by date and visitors are uniquely indentified by ip addresses.</p>
    <h3 class="no-margin lblack fs14">Visitors</h3>
    <div class="flex align-center gray mb8">
        <p class="fs11 bold no-margin">Today : <span class="black fs12">{{ $todaycount }}</span></p>
        <div class="gray height-max-content mx8 fs10">•</div>
        <p class="fs11 bold no-margin">This week : <span class="black fs12">{{ $thisweekcount }}</span></p>
        <div class="gray height-max-content mx8 fs10">•</div>
        <p class="fs11 bold no-margin">This month : <span class="black fs12">{{ $thismonthcount }}</span></p>
    </div>

    <style>
        .visitor-record-container {
            padding: 4px;
            background-color: #f5faff;
            border: 1px solid #c9d2db;
            border-radius: 3px;
            margin-bottom: 4px;
        }
    </style>
    <div>
        @foreach($visitors as $visitor)
        <x-admin.user.visitor :visitor="$visitor" />
        @endforeach

        @if($hasmore)
        <div class="full-center py8" id="visitors-fetch-more">
            <svg class="spinner size20" fill="none" viewBox="0 0 16 16">
                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
            </svg>
        </div>
        @endif
    </div>
</div>