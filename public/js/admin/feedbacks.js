
let feedback_fetch_more = $('#feedback-fetch-more');
let feedback_fetch_more_lock = true;

if(feedback_fetch_more.length) {
    $(window).on('DOMContentLoaded scroll', function() {
        if(feedback_fetch_more.isInViewport()) {
            if(!feedback_fetch_more_lock) return;
            feedback_fetch_more_lock=false;
            
            let present_feedback = $('.feedback-component').length;

            $.ajax({
                url: '/admin/contact/feedbacks/fetch?skip=' + present_feedback + '&take=12',
                type: 'get',
                success: function(response) {
                    $(`${response.payload}`).insertBefore(feedback_fetch_more);
    
                    if(!response.hasmore) {
                        feedback_fetch_more.remove();
                        $(window).off('scroll');
                    }
    
                    let unhandled_feedbacks_components = 
                        $('.feedback-component').slice(response.count*(-1));

                    unhandled_feedbacks_components.each(function() {
                        handle_component_subcontainers($(this));
                        handle_feedback_display_switch($(this));
                        handle_delete_feeback($(this));
                        handle_component_images_center($(this));
                        handle_custom_checkbox($(this));
                        handle_tooltip($(this));
                        handle_expend($(this));
                    })
                },
                complete: function() {
                  feedback_fetch_more_lock=true;
                }
            });
        }
    });
}

$('.feedback-component').each(function() {
    handle_feedback_display_switch($(this));
    handle_delete_feeback($(this));
});

function handle_feedback_display_switch(component) {
    component.find('.feedback-display-switch').on('click', function() {
        let component = $(this);
        while(!component.hasClass('feedback-component')) {
            component = component.parent();
        }

        if(component.find('.feedback-hidden-box').hasClass('none')) {
            component.find('.feedback-box').addClass('none');
            component.find('.feedback-hidden-box').removeClass('none');
        } else {
            component.find('.feedback-box').removeClass('none');
            component.find('.feedback-hidden-box').addClass('none');
        }
    });
}

let feedback_delete_queue = [];
function handle_delete_feeback(component) {
    component.find('.delete-feedback').on('click', function() {
        let button = $(this);
        let feedbackcomponent = button;
        while(!feedbackcomponent.hasClass('feedback-component')) {
            feedbackcomponent = feedbackcomponent.parent();
        }
        let fid = feedbackcomponent.find('.feedback-id').val();

        if(feedback_delete_queue.indexOf(fid) > -1) return; // If indexOf returns -1 that means it doesn't exist so we procees, otherwise we return
        feedback_delete_queue.push(fid);

        let message = $('#message-after-feedback-delete').val();
        let spinner = button.find('.spinner');
        let buttonicon = button.find(".icon-above-spinner");

        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');
        buttonicon.addClass('none');
        button.attr('style', 'cursor: not-allowed');

        $.ajax({
            type: 'delete',
            url: `/admin/contact/feedbacks/${fid}`,
            data: { 
                _token: csrf,
            },
            success: function(response) {
                feedbackcomponent.remove();
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
                
                let i = feedback_delete_queue.indexOf(fid);
                if(i !== -1)
                    feedback_delete_queue.splice(i, 1);
            }
        })

    });
}

let delete_selected_feedbacks_lock = true;
$('#delete-selected-feedbacks-read').on('click', function() {
    if(!delete_selected_feedbacks_lock) return;
    delete_selected_feedbacks_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find(".icon-above-spinner");
    let message = button.find(".message-after-success").val();

    let ids = [];
    $('.select-feedback-checkbox').each(function() {
        let checkbox = $(this);
        if(checkbox.find('.checkbox-status').val() == '1') {
            ids.push(checkbox.find('.fid').val());
        }
    });

    if(ids.length == 0) {
        delete_selected_feedbacks_lock=true;
        display_top_informer_message("You need to select at least one feedback to delete", 'warning');

        return;
    }

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.attr('style', 'cursor: not-allowed');

    $.ajax({
        type: 'delete',
        url: '/admin/contact/feedbacks/group',
        data: { 
            _token: csrf,
            ids: ids
        },
        success: function() {
            $('.feedback-component').each(function() {
                let fid = $(this).find('.fid').val();
                let i = ids.indexOf(fid);
                if(i !== -1)
                    $(this).remove();
            });

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
            delete_selected_feedbacks_lock = true;
        }
    })
});
