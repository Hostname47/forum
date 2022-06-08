handle_mark_as_read();

$('.header-button-counter-indicator').css('opacity', '0');
let element = $('.notification-button');
element.off();
element.css('cursor', 'default');
header_notifs_bootstrap_fetched
let notifications_fetch_more = $('.notifications-fetch-more');
let notifications_fetch_more_lock = true;
if(notifications_fetch_more.length) {
    $(window).on('DOMContentLoaded scroll', function() {
        // We only have to start loading and fetching data when user reach the explore more faded thread
        if(notifications_fetch_more.isInViewport()) {
            if(!notifications_fetch_more_lock) {
                return;
            }
            notifications_fetch_more_lock=false;

            let skip = $('.notifications-wrapper .notification-container').length;
            $.ajax({
                url: '/notifications/generate?range='+8+'&skip='+skip,
                type: 'get',
                success: function(notifications_components) {
            
                    if(notifications_components.content != "") {
                        $(`${notifications_components.content}`).insertBefore(notifications_fetch_more);
            
                    // The reason why we test for existence of notifications here because we need the fetch more
                    // container to insert notifs payload if exists before it
                    if(notifications_components.hasNext == false)
                        notifications_fetch_more.remove();

                        /**
                         * Notice here when we fetch the notifications we return the number of fetched notifs
                         * because we need to handle the last count of appended components events
                         * 
                         */
                        let unhandled_event_notification_components = 
                            $('.notifications-wrapper .notifs-box > .notification-container').slice(notifications_components.count*(-1));
                        
                        unhandled_event_notification_components.each(function() {
                            handle_notification_menu_appearence($(this));
                            handle_notification_menu_buttons($(this).find('.notification-menu-button'));
                            handle_nested_soc($(this).find('.notification-menu-button'));
                            handle_delete_notification($(this).find('.delete-notification'));
                            handle_disable_switch_notification($(this).find('.disable-switch-notification'));
                            handle_image_dimensions($(this).find('.action_takers_image'));
                            handle_lazy_loading();
                        });
                    }
                },
                complete: function() {
                    notifications_fetch_more_lock = true;
                }
            });
        }
    });
}

let get_disables_by_type_lock = true;
$('.get-disables-by-type').on('click', function() {
    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner= button.find('.spinner');
    let type = button.find('.action-type').val();
    let fetchstatus = button.find('.status');
    
    if(fetchstatus.val() == 'fetched') {
        let resultcontainer = button.parent().find('.disable-records-container');
        let arrowrotatedegree = 90;
        if(resultcontainer.hasClass('none'))
            resultcontainer.removeClass('none');
        else {
            resultcontainer.addClass('none');
            arrowrotatedegree = 0;
        }

        buttonicon.css({
            transform:`rotate(${arrowrotatedegree}deg)`,
            '-ms-transform':`rotate(${arrowrotatedegree}deg)`,
            '-moz-transform':`rotate(${arrowrotatedegree}deg)`,
            '-webkit-transform':`rotate(${arrowrotatedegree}deg)`,
            '-o-transform':`rotate(${arrowrotatedegree}deg)`,
        });

        return;
    }
    
    if(fetchstatus.val() == 'fetching') return;
    fetchstatus.val('fetching');

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'post',
        url: '/notifications/get-disables-by-type',
        data: {
            _token: csrf,
            type: type
        },
        success: function(response) {
            let container = button.parent().find('.disable-records-container');
            let payload = response.payload;
            let hasmore = response.hasmore;

            $(payload).insertBefore(button.parent().find('.disabled-actions-fetch-more'));
            container.removeClass('none');
            buttonicon.css({
                transform:`rotate(90deg)`,
                '-ms-transform':`rotate(90deg)`,
                '-moz-transform':`rotate(90deg)`,
                '-webkit-transform':`rotate(90deg)`,
                '-o-transform':`rotate(90deg)`,
            });

            handle_tooltip(container);
            handle_toggling(container);
            handle_expend(container);
            container.find('.enable-disabled-notification-button').each(function() { 
                handle_enable_notification_button($(this));
            });

            if(hasmore) {
                container.find('.disabled-actions-fetch-more').removeClass('none no-fetch');
                handle_fetch_more_disables(container);
            }

            fetchstatus.val('fetched');
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(error, 'error');

            fetchstatus.val('not-fetched');
        },
        complete: function() {
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
        }
    })
});


function handle_fetch_more_disables(container) {
    container.on('DOMContentLoaded scroll', function() {
        if(container.scrollTop() + container.innerHeight() + 50 >= container[0].scrollHeight) {
            let fetchmore = container.find('.disabled-actions-fetch-more');
            let status = fetchmore.find('.fetch-status');

            if(status.val() == 'fetching') return;
            status.val('fetching');
    
            let spinner = fetchmore.find('.spinner');
            let action_type = fetchmore.find('.action-type').val();
            let skip = fetchmore.parent().find('.disable-record-container').length;
            
            spinner.addClass('inf-rotate');
            $.ajax({
                type: 'post',
                url: `/notifications/get-disables-by-type`,
                data: {
                    _token: csrf,
                    type: action_type,
                    skip: skip,
                },
                success: function(response) {
                    $(response.payload).insertBefore(fetchmore);
            
                    let unhandled_disables = 
                        container.find(".disable-record-container").slice(response.count*(-1));

                    unhandled_disables.each(function() {
                        handle_tooltip($(this));
                        handle_toggling($(this));
                        handle_expend($(this));
                        handle_enable_notification_button($(this).find('.enable-disabled-notification-button'));
                    });

                    if(response.hasmore == false) {
                        fetchmore.remove();
                        container.off();
                    }
                },
                error: function(response) {
                    let errorObject = JSON.parse(response.responseText);
                    let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                    if(errorObject.errors) {
                        let errors = errorObject.errors;
                        error = errors[Object.keys(errors)[0]][0];
                    }
                    display_top_informer_message(error, 'error');
                },
                complete: function() {
                    status.val('stable');
                }
            });
        }
    });
}

function handle_enable_notification_button(button) {
    button.on('click', function() {
        let status = button.find('.status');
        if(status.val() == 'enabling') return;
        status.val('enabling');

        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let disable_id = button.find('.disable-id').val();

        spinner.removeClass('opacity0');
        spinner.addClass('inf-rotate');
        buttonicon.addClass('none');
        button.addClass('disabled-typical-button-style');

        $.ajax({
            type: 'post',
            url: '/notifications/disables/enable',
            data: {
                _token: csrf,
                disable: disable_id
            },
            success: function() {
                basic_notification_show($('#notification-enabled-success-message').val());
                location.reload();
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(error, 'error');

                status.val('stable');
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
                buttonicon.removeClass('none');
                button.removeClass('disabled-typical-button-style');
            },
        })
    });
}