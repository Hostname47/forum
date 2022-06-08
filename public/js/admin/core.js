let urlprms = new URLSearchParams(window.location.search);

handle_expend($('body'));

$('.ws-toggler').on('change', function() {
    let type = $(this).val();
    let box = $(this);
    while(!box.hasClass('ws-toggler-box')) {
        box = box.parent();
    }

    if(type == 'warn') {
        box.find('.ws-warning-box').removeClass('none');
        box.find('.ws-striking-box').addClass('none');
    } else if(type == 'strike') {
        box.find('.ws-warning-box').addClass('none');
        box.find('.ws-striking-box').removeClass('none');
    }
});

$('.render-thread').each(function() {
    handle_thread_render($(this));
})

let last_rendered_report_thread = -1;
let render_thread_lock = true;
function handle_thread_render(renderbutton) {
    renderbutton.on('click', function() {
        let button = $(this);
        let buttonicon = button.find('.icon-above-spinner');
        let spinner = button.find('.spinner');
        let thread_id = button.parent().find('.thread-id').val();
        let render_viewer = $('#thread-render-viewer');
    
        if(last_rendered_report_thread != thread_id) {
            if(!render_thread_lock) return;
            render_thread_lock = false;

            spinner.addClass('inf-rotate');
            spinner.removeClass('none');
            buttonicon.addClass('none');

            $.ajax({
                type: 'get',
                url: `/admin/threads/${thread_id}/render`,
                success: function(response) {
                    last_rendered_report_thread = thread_id;
                    $('#thread-render-box').html('');
                    $('#thread-render-box').html(response.payload);
                    $('#thread-render-viewer .manage-link').attr('href', response.managelink);
                    render_viewer.removeClass('none');
                    disable_page_scroll();
                    
                    handle_hide_parent(render_viewer);
                    handle_tooltip(render_viewer);
                    handle_expend_button_appearence(render_viewer);
                    handle_expend(render_viewer);
                    // Keep in mind that images dimensions also handled withing lazy loading logic
                    force_lazy_load(render_viewer);
                    handle_thread_rtl(render_viewer);
                    handle_image_open(render_viewer);
                    handle_raw_fetch_remaining_poll_options(render_viewer);
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
                    spinner.removeClass('inf-rotate');
                    spinner.addClass('none');
                    buttonicon.removeClass('none');
                    render_thread_lock = true;
                }
            });
        } else {
            render_viewer.removeClass('none');
            disable_page_scroll();
        }
    });
}

$('.render-post').each(function() {
    handle_post_render($(this));
})

let last_rendered_post = -1;
let render_post_lock = true;
function handle_post_render(renderbutton) {
    renderbutton.on('click', function() {
        let button = $(this);
        let buttonicon = button.find('.icon-above-spinner');
        let post_id = button.find('.post-id').val();
        let render_viewer = $('#reply-render-viewer');
        let spinner = button.find('.spinner');
    
        if(last_rendered_post != post_id) {
            if(!render_post_lock) return;
            render_post_lock = false;

            spinner.addClass('inf-rotate');
            spinner.removeClass('none');
            buttonicon.addClass('none');
            
            $.ajax({
                type: 'get',
                url: `/admin/posts/${post_id}/render`,
                success: function(response) {
                    last_rendered_post = post_id;
                    $('#reply-render-box').html(response.payload);
                    $('#reply-render-viewer .manage-link').attr('href', response.managelink)
                    handle_expend($('#reply-render-box'));
                    handle_toggling($('#reply-render-box'));
                    handle_tooltip($('#reply-render-box'));
                    handle_html_entities_decoding($('#reply-render-box'));

                    render_viewer.removeClass('none');
                    disable_page_scroll();
                },
                complete: function() {
                    spinner.removeClass('inf-rotate');
                    spinner.addClass('none');
                    buttonicon.removeClass('none');
                    render_post_lock = true;
                }
            });
        } else {
            render_viewer.removeClass('none');
            disable_page_scroll();
        }
    });
}

let raw_fetch_remaining_poll_options_lock = true;
function handle_raw_fetch_remaining_poll_options(container) {
    container.find('.fetch-raw-remaining-poll-options').on('click', function() {
        if(!raw_fetch_remaining_poll_options_lock) return;
        raw_fetch_remaining_poll_options_lock = false;

        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let thread_id = button.find('.thread-id').val();
        
        let box = button;
        while(!box.hasClass('thread-poll-options-container')) box = box.parent();
        let skip = box.find('.poll-option-box').length;

        buttonicon.addClass('none');
        spinner.removeClass('opacity0');
        spinner.addClass('inf-rotate');

        $.ajax({
            type: 'post',
            url: '/thread/poll/raw-fetch-remaining-options',
            data: {
                _token: csrf,
                thread_id: thread_id,
                skip: skip
            },
            success: function(response) {
                let options = response;
                for(let i = 0; i < options.length; i++) {
                    let component = $('.poll-option-box-skeleton').clone();
                    component.find('.percentage').css('width', options[i].vote_percentage + '%');
                    component.find('.added-by').text(options[i].addedby_username);
                    component.find('.added-by').attr('href', options[i].addedby_link);
                    component.find('.content').text(options[i].content);
                    component.find('.percentage-text').text(options[i].vote_percentage);
                    component.find('.vote-count').text(options[i].votes_count);

                    component.removeClass('poll-option-box-skeleton none')
                    box.append(component);
                }

                button.remove();
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
                raw_fetch_remaining_poll_options_lock = true;
            }
        })
    });
}

let check_resource_lock = true;
$('.check-resource').on('click', function() {
    if(!check_resource_lock)
        return;
    check_resource_lock = false;

    let button = $(this);
    let box = button;
    while(!box.hasClass('check-resource-box')) {
        box = box.parent();
    }

    let exists = box.find('.mu-resource-exists');
    let notexists = box.find('.mu-resource-not-exists');
    exists.addClass('none');
    notexists.addClass('none');

    let resourceid = box.find('.resource-id').val();
    let resourcetype = box.find('.resource-type').val();
    let uid = button.find('.uid').val();

    if(resourcetype == 'none') {
        display_top_informer_message('select resource type', 'warning');
        check_resource_lock = true;
        return;
    }
    if(resourceid == '') {
        display_top_informer_message('select resource id', 'warning');
        check_resource_lock = true;
        return;
    }

    button.attr('style', 'background-color: #888; cursor: not-allowed;');

    checkresource(uid, resourceid, resourcetype)
        .done(function(response) {
            if(response=="1") {
                exists.removeClass('none');
                notexists.addClass('none');
            } else {
                exists.addClass('none');
                notexists.removeClass('none');
            }

            button.attr('style', '');
        })
        .fail(function(response) {
            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            
            display_top_informer_message(er, 'warning');
        });
});

function checkresource(uid, resourceid, resourcetype) {
    return $.ajax({
        url: `/admin/resource/check?uid=${uid}&resourceid=${resourceid}&resourcetype=${resourcetype}`,
        complete: function() {
            check_resource_lock = true;
        },
    });
}

$('.open-warning-remove-from-user-dialog').each(function() { handle_remove_warning_from_user_dialog_open($(this)); });
function handle_remove_warning_from_user_dialog_open(button) {
    button.on('click', function() {
        let viewer = $('#remove-warning-from-user-viewer');
        viewer.find('.warning-name').text(button.parent().find('.warning-name').text());
        viewer.find('.warning-id-to-remove').val(button.parent().find('.warning-id').val());
        $('#remove-warning-from-user-viewer').removeClass('none');
        disable_page_scroll();
    });
}

$('.open-strike-remove-from-user-dialog').each(function() { handle_remove_strike_from_user_dialog_open($(this)); });
function handle_remove_strike_from_user_dialog_open(button) {
    button.on('click', function() {
        let viewer = $('#remove-strike-from-user-viewer');
        viewer.find('.strike-name').text(button.parent().find('.strike-name').text());
        viewer.find('.strike-id-to-remove').val(button.parent().find('.strike-id').val());
        $('#remove-strike-from-user-viewer').removeClass('none');
        disable_page_scroll();
    });
}

function scrollLeftpanel(section) {
    let leftpanel = $('#admin-left-panel');
    switch(section) {
        case 'f-a-c-dashboard':
            leftpanel.scrollTop(146);
            break;
        case 'f-a-c-forum-management':
            leftpanel.scrollTop(200);
            break;
        case 'f-a-c-category-management':
            leftpanel.scrollTop(250);
            break;
        case 'archives':
            leftpanel.scrollTop(40);
            break;
        case 'roles-and-permissions':
            leftpanel.scrollTop(100);
            break;
    }
}

let set_admin_status_lock = true;
$('.set-admin-status').on('click', function(event) {
    if(!set_admin_status_lock) return;
    set_admin_status_lock = false;

    let button = $(this);
    let status = button.find('.admin-status').val();
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.status-icon');
    let successmessage = button.find('.success-message').val();

    let adminstatusbox = button;
    while(!adminstatusbox.hasClass('admin-status-set-box')) adminstatusbox = adminstatusbox.parent();

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'post',
        url: '/admin/user/status/set',
        data: {
            _token: csrf,
            status: status
        },
        success: function(response) {
            let new_status_icon = buttonicon.clone();
            new_status_icon.removeClass('size10 none');
            new_status_icon.addClass('size8');
            adminstatusbox.find('.selected-admin-status-name').text(button.find('.status-name').text());
            adminstatusbox.find('.selected-admin-status-icon').html(new_status_icon);

            basic_notification_show(successmessage);
            button.parent().css('display', 'none');
            event.stopPropagation();
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

            set_admin_status_lock = true;
        }
    });
});
