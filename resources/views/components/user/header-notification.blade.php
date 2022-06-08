<div class="notification-container @if(!$read) unread-notification-container @endif flex align-center relative" style="margin: 2px 0">
    <input type="hidden" class="notification-id" value="{{ $id }}">
    <a href="{{ $link }}" class="link-wraper notification-component-container" style="@if(!$read) background-color:#ccebf74a @endif">
        <div class="relative" style="height: max-content">
            <div class="size48 rounded hidden-overflow mr8 relative">
                <div class="fade-loading"></div>
                <img data-src="{{ $image }}" class="notification-doer-avatar lazy-image image-with-fade handle-image-center-positioning" alt="{{ $image_alt }}">
            </div>
            <div class="action_type_icon notification-type-icon sprite sprite-2-size {{ $resource_action_icon }}"></div>
        </div>
        <div>
            <div class="fs14">
                <strong class="text-content-bold">{{ $bold }}</strong> <span class="text-content-statement bblack">{!! $notification_statement !!}</span> <span class="text-content-resource-slice">{{ $resource_slice }}</span>
            </div>
            <div class="fs12 blue bold notification-date" title="{{ $action_date }}">{{ $action_date_hummans }}</div>
        </div>
    </a>
    @if($can_be_disabled OR $can_be_deleted)
    <div class="notification-menu-button-container relative none">
        <div class="nested-soc-button notification-menu-button size24 sprite sprite-2-size menu24-icon pointer"></div>
        <div class="suboptions-container nested-soc simple-button-suboptions-container">
            <input type="hidden" class="notif-id" value="{{ $id }}">
            @if($can_be_deleted)
            <div class="flex typical-suboption pointer fs13 delete-notification" style="width: 200px;">
                <svg class="size16 mr8" style="min-width: 16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                <div class="full-width">
                    <span class="block button-text">{{ __('Delete') }}</span>
                    <span class="block fs12 gray fw-normal">{{ __('Delete this notification') }}</span>
                </div>
                <input type="hidden" class="message-no-ing" value="{{ __('Delete') }}">
                <input type="hidden" class="message-ing" value="{{ __('Deleting notification') }}..">
                <input type="hidden" class="delete-success" value="{{ __('Notification deleted successfully') }}">
            </div>
            @endif
            @if($can_be_disabled)
            <div class="flex typical-suboption pointer fs13 disable-switch-notification @if($disableinfo['disabled']) enable-notification @else disable-notification @endif" style="width: 200px;">
                <div class="notif-switch-icon small-image-2 sprite sprite-2-size @if($disableinfo['disabled']) enablenotif17b-icon @else disablenotif17b-icon @endif mr8" style="min-width: 17px"></div>
                <div>
                    @if($disableinfo['disabled'])
                    <span class="button-text">{{ __('Turn on') }}</span>
                    <span class="block fs12 gray fw-normal button-label-text">{{ $disableinfo['enable_button_label'] }}</span>
                    @else
                    <span class="button-text">{{ __('Turn off') }}</span>
                    <span class="block fs12 gray fw-normal button-label-text">{{ $disableinfo['disable_button_label'] }}</span>
                    @endif
                </div>
                <input type="hidden" class="turning-off-text" value="{{ __('Turning off') }}.." autocomplete="off">
                <input type="hidden" class="turning-on-text" value="{{ __('Turning on') }}.." autocomplete="off">
                <input type="hidden" class="turn-off-text" value="{{ __('Turn off') }}" autocomplete="off">
                <input type="hidden" class="turn-on-text" value="{{ __('Turn on') }}" autocomplete="off">
            </div>
            @endif
        </div>
    </div>
    @endif
</div>