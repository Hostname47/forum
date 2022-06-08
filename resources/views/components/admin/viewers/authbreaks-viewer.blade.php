<div>
    <style>
        .user-authbreak-record {
            padding: 8px;
            background-color: #f5f7f9;
            border: 1px solid #c5d1d7;
            border-radius: 4px;
        }
    </style>
    <h2 class="no-margin lblack fs16">Authorization breaks (total:{{ $totalcount }})</h2>
    <p class="no-margin mt4 fs13 lblack">The following records shows authorizations disrespected by users who perform some unauthorized actions and regulations violation. If a user has more than 3 auth breaks, it's better to ban him permanently to prevent risk.</p>
    <div class="mt8">
        @foreach($authbreaks as $authbreak)
            <x-admin.user.authorizationbreak-component :authbreak="$authbreak" :showowner="true"/>
        @endforeach

        @if($totalcount > 10)
        <div class="full-center py8" id="authbreaks-fetch-more">
            <svg class="spinner size24" fill="none" viewBox="0 0 16 16">
                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
            </svg>
        </div>
        @endif
    </div>
</div>