<div>
    <p class="no-margin mb4 fs13 lblack">The following users are new registered users ordered by newest to older ones.</p>
    <div class="flex align-center">
        <h3 class="no-margin lblack fs14">New signups</h3>
        <div class="gray height-max-content mx4 fs10">•</div>
        <h3 class="no-margin black fs10">(total : {{ $totalcount }})</h3>
    </div>
    <div class="flex align-center gray mt2 mb8">
        <p class="fs11 bold no-margin">Today : <span class="black fs12">{{ $todaycount }}</span></p>
        <div class="gray height-max-content mx8 fs10">•</div>
        <p class="fs11 bold no-margin">This week : <span class="black fs12">{{ $thisweekcount }}</span></p>
        <div class="gray height-max-content mx8 fs10">•</div>
        <p class="fs11 bold no-margin">This month : <span class="black fs12">{{ $thismonthcount }}</span></p>
    </div>

    <style>
        .signup-record-container {
            padding: 6px;
            background-color: #fbfdff;
            border: 1px solid #c9d2db;
            border-radius: 3px;
            margin-bottom: 4px;
        }
    </style>
    <div>
        @foreach($users as $user)
        <x-admin.user.signup-user :user="$user"/>
        @endforeach

        @if($hasmore)
        <div class="full-center py8" id="new-signups-fetch-more">
            <svg class="spinner size20" fill="none" viewBox="0 0 16 16">
                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
            </svg>
        </div>
        @endif
    </div>
</div>