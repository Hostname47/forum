
let cm_fetch_more = $('.contact-messages-fetch-more'); // cm for contact message
let cm_fetch_more_lock = true;
if(cm_fetch_more.length) {
    /**
     * We only bind scroll event to the document scroll, if there are more messages to fetch;
     * and if cm_fetch_more component exists
     */
    $(window).on('DOMContentLoaded scroll', function() {
        if(cm_fetch_more.isInViewport()) {
            if(!cm_fetch_more_lock) return;
            cm_fetch_more_lock=false;
            
            let present_messages = $('.contact-message-component').length;
    
            $.ajax({
                url: '/admin/contact/messages/fetch?skip=' + present_messages + '&take=12',
                type: 'get',
                success: function(response) {
                    $(`${response.payload}`).insertBefore(cm_fetch_more);
    
                    if(!response.hasmore) {
                        cm_fetch_more.remove();
                        $(window).off('scroll');
                    }
    
                    let unhandled_messages_components = 
                        $('.contact-message-component').slice(response.count*(-1));
    
                    unhandled_messages_components.each(function() {
                        handle_component_subcontainers($(this));
                        handle_cmessage_display_switch($(this));
                        handle_component_images_center($(this));
                        handle_cm_mark_as_read($(this));
                        handle_custom_checkbox($(this));
                        handle_tooltip($(this));
                        handle_expend($(this));
                    })
                },
                complete: function() {
                    cm_fetch_more_lock=true;
                }
            });
        }
    });
}

$('.contact-message-component').each(function() {
    handle_cmessage_display_switch($(this));
    handle_delete_cmessage($(this));
    handle_cm_mark_as_read($(this));
});

function handle_cmessage_display_switch(component) {
    component.find('.cmessage-display-switch').on('click', function() {
        let component = $(this);
        while(!component.hasClass('contact-message-component')) {
            component = component.parent();
        }

        if(component.find('.cmessage-hidden-box').hasClass('none')) {
            component.find('.contact-message-box').addClass('none');
            component.find('.cmessage-hidden-box').removeClass('none');
        } else {
            component.find('.contact-message-box').removeClass('none');
            component.find('.cmessage-hidden-box').addClass('none');
        }
    });
}

let cmessage_delete_lock = true;
function handle_delete_cmessage(component) {
    component.find('.delete-cmessage').on('click', function() {
        if(!cmessage_delete_lock) return;
        cmessage_delete_lock = false;

        let button = $(this);
        let component = button;
        while(!component.hasClass('contact-message-component')) {
            component = component.parent();
        }

        let spinner = button.find('.spinner');
        let buttonicon = button.find(".icon-above-spinner");
        let mid = component.find('.mid').val();
        let message = button.find('.message-after-delete').val();

        button.attr('style', 'cursor: not-allowed');
        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');
        buttonicon.addClass('none');

        $.ajax({
            url: `/admin/contact/messages/${mid}`,
            type: 'delete',
            data: {_token: csrf},
            success: function() {
                if(component.find('.cm-read').val() == '0') {
                    let unread_messages_counter = $('#unread-messages-counter');
                    unread_messages_counter.text(parseInt(unread_messages_counter.text()) - 1);
                }
                component.remove();
                basic_notification_show(message, 'basic-notification-round-tick');
            },
            error: function(response) {
                
            },
            complete: function() {
                cmessage_delete_lock = true;
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
                buttonicon.addClass('none');
            }
        })
    });
}

/**
 * Here, where an admin mark a message as read, we first take the id and push it to queue;
 * If admin by mistake press mark as read button twice, we only process once, because if the id is already
 * in the queue we stop the click
 * Once the request terminated, we take the id away from the queue
 */
let cm_mar_queue = []; // cm_mar => contact message mark as read
function handle_cm_mark_as_read(component) {
    component.find('.cm-mark-as-read').on('click', function() {
        let button = $(this);
        let cmcomponent = button;
        while(!cmcomponent.hasClass('contact-message-component')) {
            cmcomponent = cmcomponent.parent();
        }
        let mid = cmcomponent.find('.mid').val();

        if(cm_mar_queue.indexOf(mid) > -1) return; // If indexOf returns -1 that means it doesn't exist so we procees, otherwise we return
        cm_mar_queue.push(mid);

        let bluefill = '#2ca0ff';
        let grayfill = '#313131';
        let message = $('#message-read-message').val();

        button.attr('fill', bluefill);
        $.ajax({
            type: 'patch',
            url: `/admin/contact/messages/${mid}/markasread`,
            data: {_token: csrf},
            success: function() {
                button.parent().removeAttr('title');
                button.off('click');
                button.removeClass('pointer');
                let unread_messages_counter = $('#unread-messages-counter');
                unread_messages_counter.text(parseInt(unread_messages_counter.text()) - 1);
                cmcomponent.find('.cm-read').val('1');

                basic_notification_show(message, 'basic-notification-round-tick');
            },
            error: function(response) {
                button.attr('fill', grayfill);
                let errorObject = JSON.parse(response.responseText);
                let er = errorObject.message;
    
                display_top_informer_message(er, 'error');
            },
            complete: function() {
                let i = cm_mar_queue.indexOf(mid);
                if(i !== -1)
                    cm_mar_queue.splice(i, 1);
            }
        });
    });
}

let mamas_lock = true; // mamas : mark all messages as read
$('#mark-all-messages-as-read').on('click', function() {
    if(!mamas_lock) return;
    mamas_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find(".icon-above-spinner");
    let message = button.find(".message-after-success").val();

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.attr('style', 'cursor: not-allowed');

    $.ajax({
        type: 'patch',
        url: '/admin/contact/messages/markasread',
        data: { _token: csrf },
        success: function() {
            /**
             * Before notifying the admin that all messages are read, we have to change tick to blue and remove all 
             * click event from mark as read buttons in messages components
             */
            $('.cm-mark-as-read').each(function() {
                let mar_button = $(this); // mar : mark as read
                mar_button.off('click');
                mar_button.removeClass('pointer');
                mar_button.parent().attr('title', 'read');
                mar_button.attr('fill', '#2ca0ff');
            });
            $('.contact-message-component').each(function() {
                $(this).find('.cm-read').val('1');
            });
            $('#unread-messages-counter').text('0');
            basic_notification_show(message, 'basic-notification-round-tick');
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;

            display_top_informer_message(er, 'error');
        },
        complete: function() {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.attr('style', '');
            mamas_lock = true;
        }
    })
});

let msmar_lock = true; // msmar : mark selected messages as read
$('#mark-selected-messages-as-read').on('click', function() {
    if(!msmar_lock) return;
    msmar_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find(".icon-above-spinner");
    let message = button.find(".message-after-success").val();

    let ids = [];
    $('.select-cm-checkbox').each(function() {
        let checkbox = $(this);
        // Only select unread messsages (id cm-read hidden input has value 1 it means it's already read)
        if(checkbox.find('.checkbox-status').val() == '1' && checkbox.find('.cm-read').val() == '0') {
            ids.push(checkbox.find('.mid').val());
        }
    });

    if(ids.length == 0) {
        spinner.addClass('opacity0');
        stop_spinner(spinner, 'mark-selected-messages-as-read-spinner');
        buttonicon.removeClass('none');
        button.attr('style', '');
        msmar_lock=true;
        display_top_informer_message("You need to select at least one message to mark as read. (the selected messages should be unread)", 'warning');

        return;
    }

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.attr('style', 'cursor: not-allowed');

    $.ajax({
        type: 'patch',
        url: '/admin/contact/messages/markgroupasread',
        data: {
            _token: csrf,
            ids: ids
        },
        success: function() {
            let unread_messages_counter = $('#unread-messages-counter');
            unread_messages_counter.text(parseInt(unread_messages_counter.text()) - ids.length);

            $('.contact-message-component').each(function() {
                // When all selected messages marked as read we loop through messages components
                let component = $(this);
                // Get the message id of each messager
                let mid = component.find('.mid').val();

                /**
                 * Check if the id exists in the list of marked messages ids; If so we have to remove mark as read click event
                 * and uncheck the select (custom) checkbox
                 */
                let i = ids.indexOf(mid);
                if(i !== -1) {
                    let mar_button = component.find('.cm-mark-as-read'); // mar : mark as read
                    mar_button.off('click');
                    mar_button.removeClass('pointer');
                    mar_button.parent().attr('title', 'read');
                    mar_button.attr('fill', '#2ca0ff');

                    component.find('.select-cm-checkbox').trigger('click');
                    component.find('.cm-read').val('1');
                }
            });

            ids = [];
            basic_notification_show(message, 'basic-notification-round-tick');
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            display_top_informer_message(er, 'error');
        },
        complete: function() {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.attr('style', '');
            msmar_lock=true;
        }
    });

});

let dsm_lock = true; // dsm : delete selected messages
$('#delete-selected-messages').on('click', function() {
    if(!dsm_lock) return;
    dsm_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find(".icon-above-spinner");
    let message = button.find(".message-after-success").val();

    let ids = [];
    $('.select-cm-checkbox').each(function() {
        let checkbox = $(this);
        // Only select unread messsages (id cm-read hidden input has value 1 it means it's already read)
        if(checkbox.find('.checkbox-status').first().val() == '1') {
            ids.push(checkbox.find('.mid').val());
        }
    });

    if(ids.length == 0) {
        dsm_lock=true;
        display_top_informer_message("You need to select at least one message to delete", 'warning');

        return;
    }

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.attr('style', 'cursor: not-allowed');

    $.ajax({
        type: 'delete',
        url: '/admin/contact/messages/group',
        data: { 
            _token: csrf,
            ids: ids
        },
        success: function() {
            let unreads = 0;
            $('.contact-message-component').each(function() {
                let mid = $(this).find('.mid').val();
                let i = ids.indexOf(mid);
                if(i !== -1) {
                    // Before delete the selected messages, we the number of unread messages to take the count from unread messages count
                    if($(this).find('.cm-read').val() == '0') unreads++;
                    $(this).remove();
                }
            });

            let unread_messages_counter = $('#unread-messages-counter');
            unread_messages_counter.text(parseInt(unread_messages_counter.text()) - unreads);
            basic_notification_show(message, 'basic-notification-round-tick');
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
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.attr('style', '');
            dsm_lock=true;
        }
    })
});
