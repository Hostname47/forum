<div class="user-ban-record fs12 lblack mb8">
    <p class="no-margin bold">Ban type : <span class="red">{{ ucfirst($ban->type) }}</span></p>
    <p class="no-margin mt4"><strong>Banned by</strong> : <a href="{{ route('admin.user.manage', ['uid'=>$ban->bannedby->id]) }}" class="blue bold no-underline">{{ $ban->bannedby->username }}</a></p>
    <p class="no-margin mt4"><strong>Ban reason</strong> : {{ $ban->reason->reason }}</p>
    <p class="no-margin mt4"><strong>banned at :</strong> {{ $ban->bandate }}</p>
    @if($ban->type == 'temporary')
    <div class="temporary-infos-container">
        <p class="no-margin mt4"><strong>ban duration :</strong> {{ $ban->ban_duration_hummans }}</p>
        <p class="no-margin my4"><strong>expired at :</strong> {{ $ban->expired_at }}</p>
    </div>
    @endif
</div>