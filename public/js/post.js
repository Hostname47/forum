function handle_post_display_buttons(post) {
    post.find('.hide-post').click(function() {
        if($(this).hasClass('hide-post-from-viewer')) {
            post.find('.viewer-post-main-component').css('display', 'none');
            post.find('.show-post-container').css('display', 'block');
            $(this).parent().css('display', 'none');
        } else if($(this).hasClass('hide-post-from-outside-viewer')) {
            post.find('.post-main-component').css('display', 'none');
            post.find('.show-post-container').css('display', 'block');
            $(this).parent().css('display', 'none');
        }
    });

    post.find('.show-post').click(function() {
        if($(this).hasClass('show-post-from-viewer')) {
            post.find('.viewer-post-main-component').css('display', 'block');
            $(this).parent().css('display', 'none');
        } else if($(this).hasClass('show-post-from-outside-viewer')) {
            $(this).parent().parent().find('.post-main-component').css('display', 'flex');
            $(this).parent().css('display', 'none');
        }
    });
}

function handle_open_edit_post_container(post) {
    post.find('.open-edit-post-container').click(function(event) {
        $('.post-content-wrapper').removeClass('none');
        $('.post-content-edit-container').addClass('none');
        post.find('.post-content-wrapper').addClass('none');
        post.find('.post-content-edit-container').removeClass('none');

        // Hide button parent suboptions container
        $(this).parent().css('display', 'none');
        event.stopPropagation();

        // set the value
        const $codemirror = post.find('.post-edit-new-content-input').nextAll('.CodeMirror')[0].CodeMirror;
        $codemirror.getDoc().setValue(post.find('.current-post-content').val());
    });
}

let update_post_content_lock = true;
function handle_save_edit_post(post) {
    post.find('.update-post-content').click(function() {
        const $codemirror = $(post).find('.post-edit-new-content-input').nextAll('.CodeMirror')[0].CodeMirror;
        let content = $codemirror.getValue();
        let oldcontent = post.find('.current-post-content').val();

        if(content.trim().length == 0) {
            display_top_informer_message(post.find('.content-is-required-error-message').val(), 'error');
            return;
        }

        if(content == oldcontent){
            post.find('.post-content-edit-container').addClass('none');
            post.find('.post-content-wrapper').removeClass('none');
            return;
        }

        if(!update_post_content_lock) return;
        update_post_content_lock = false;

        let button = $(this);
        let from = button.find('.from').val();
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let post_id = post.find('.post-id').first().val();
        let exit_button = post.find('.exit-post-edit-changes');
        
        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');
        buttonicon.addClass('none');
        button.addClass('disabled-wtypical-button-style');
        exit_button.css('cursor', 'not-allowed');
        
        $codemirror.options.readOnly = 'nocursor';
        $.ajax({
            url: '/post',
            type:"patch",
            data: {
                '_token': csrf,
                'post_id': post_id,
                'content': content
            },
            success: function(response) {
                basic_notification_show(button.find('.success-message').val());
                post.find('.current-post-content').val(content);
                post.find('.post-content-wrapper').html(response.parsedcontent);
                post.find('.post-content-wrapper').removeClass('none');
                post.find('.post-content-edit-container').addClass('none');
                post.find('.post-updated-text').removeClass('none');

                if(from == 'thread-show') {
                    if(last_opened_thread) {
                        let viewerpost = $('#viewer-posts-container .post' + post_id);
                        viewerpost.find('.current-post-content').val(content);
                        viewerpost.find('.post-content-wrapper').html(response.parsedcontent);
                    }
                } else {
                    if($('#thread-show-posts-container').length) {
                        let threadshowpost = $('#thread-show-posts-container .post' + post_id);
                        threadshowpost.find('.current-post-content').val(content);
                        threadshowpost.find('.post-content-wrapper').html(response.parsedcontent);
                    }
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
                $codemirror.options.readOnly = true;
            },
            complete: function() {
                spinner.removeClass('inf-rotate');
                spinner.addClass('opacity0');
                buttonicon.removeClass('none');
                button.removeClass('disabled-wtypical-button-style');
                exit_button.css('cursor', 'pointer');
                
                $codemirror.options.readOnly = false;
                update_post_content_lock = true;
            }
        });
    });
}

function handle_exit_post_edit_changes(post) {
    post.find('.exit-post-edit-changes').click(function() {
        if(!update_post_content_lock) return; // If post is currently updated, we don't allow user to cancel

        post.find('.post-content-edit-container').addClass('none');
        post.find('.post-content-wrapper').removeClass('none');
    });
}

let open_post_delete_lock = true;
let last_opened_post_to_delete = null;
function handle_open_delete_post_viewer(post) {
    post.find('.open-delete-post-viewer').click(function(event) {
        let post_id = post.find('.post-id').first().val();

        if(post_id == last_opened_post_to_delete) {
            $('#post-delete-viewer').removeClass('none');
            disable_page_scroll();
            return;
        }

        if(!open_post_delete_lock) return;
        open_post_delete_lock = false;

        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');

        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');
        buttonicon.addClass('none');

        $.ajax({
            url: '/post/content/parsed/fetch',
            data: {
                post_id: post_id,
                min: 1
            },
            success: function(response) {
                let viewer = $('#post-delete-viewer');
                viewer.find('.post-deleted-content').html(response);
                viewer.find('.post-id').val(post_id);
                last_opened_post_to_delete = post_id;

                button.parent().css('display', 'none');
                $('#post-delete-viewer').removeClass('none');
                disable_page_scroll();
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
                spinner.addClass('opacity0');
                buttonicon.removeClass('none');

                open_post_delete_lock = true;
            }
        })

        event.stopPropagation();
    });
}

let delete_post_lock = true;
$('#delete-post-button').on('click', function() {
    if(!delete_post_lock) return;
    delete_post_lock = false;
    
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let post_id = $('#post-delete-viewer .post-id').val();

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.addClass('disabled-red-button-style');

    $.ajax({
        url: '/post',
        type: 'delete',
        data: {
            '_token':csrf,
            'post_id': post_id
        },
        success: function(response) {
            let thread_id = response.thread_id;
            let posts_count_after_delete = response.posts_count_after_delete;
            basic_notification_show(button.find('.success-message').val());

            $('#thread-show-posts-count').text(posts_count_after_delete); // counter in thread show
            $('#viewer-infos-section-box .posts-count').text(posts_count_after_delete); // counter in media viewer
            $('#thread'+thread_id).find('.posts-count').text(posts_count_after_delete); // counter in thread component
            // This exists only in places where user reply on the selected thread and we use it to get the current posts count
            $('.selected-thread-posts-count').val(posts_count_after_delete);

            $('.post'+post_id).remove(); // Remove all posts with post_id id (thread show and viewer if already opened)

            $('#post-delete-viewer .close-global-viewer').trigger('click');
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
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            button.removeClass('disabled-red-button-style');
            delete_post_lock = true;
        }
    });
});

function handle_tooltips(post) {
    post.find('.tooltip-section').on({
        'mouseenter': function() {
            $(this).parent().find('.tooltip').css('display', 'block');
        },
        'mouseleave': function() {
            $(this).parent().find('.tooltip').css('display', 'none');
        }
    });
}

function handle_post_events(post) {
    // Hide/show post
    handle_post_display_buttons(post);
    // Editing post
    post.find('textarea').each(function() {
        var simplemde = new SimpleMDE({
            element: this,
            hideIcons: ["guide", "heading", "image"],
            spellChecker: false,
            mode: 'markdown',
            showMarkdownLineBreaks: true,
        });
    })
    // Handle post edit editor
    handle_open_edit_post_container(post);
    handle_expend_post_content(post);
    handle_save_edit_post(post);
    handle_exit_post_edit_changes(post);
    // Deleting post
    handle_open_delete_post_viewer(post);
    // Tooltips
    handle_tooltips(post);
    // Handle close shadowed view for deleting
    handle_close_shadowed_view(post);
    // Handle post best reply
    handle_post_reply_tick_button(post);
    // posts like buttons are already handled from app-depth script
}

function handle_post_other_events(post) {
    // Suboption containers
    handle_element_suboption_containers(post);
    // buttons with container inside
    handle_user_profile_card_displayer(post);
    // Handle vote buttons
    handle_up_vote(post.find('.votable-up-vote'));
    handle_down_vote(post.find('.votable-down-vote'));
}

$('.post-container').each(function() { handle_post_events($(this)); });

handle_post_share($('.share-post'));
let share_post_lock = true;
function handle_post_share(button) {
    button.on('click', function() {
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let from = button.find('.from').val();
        let successmessage = button.find('.success-message').val();
    
        let share_post_box = button;
        while(!share_post_box.hasClass('share-post-box')) share_post_box = share_post_box.parent();
        
        const $codemirror = share_post_box.find('.post-input').nextAll('.CodeMirror')[0].CodeMirror;
        let postcontent = $codemirror.getDoc().getValue();
        let thread_id = share_post_box.find('.thread-id').val();
    
        if(postcontent.trim() == "") {
            share_post_box.find('.error-container').removeClass('none');
            share_post_box.find('.error-container .error').text(share_post_box.find('.content-required').val());
            return;
        }
        share_post_box.find('.error-container').addClass('none');
        
        if(!share_post_lock) return;
        share_post_lock = false;
        
        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');
        buttonicon.addClass('none');
        button.addClass('disabled-typical-button-style');
    
        $.ajax({
            type: 'post',
            data: {
                _token: csrf,
                thread_id: thread_id,
                content: postcontent,
                from: from
            },
            url: '/post',
            success: function(response) {
                $codemirror.getDoc().setValue('');
                basic_notification_show(successmessage);
                // Display replies text label if it is hidden
                $('.thread-show-posts-counter-text').removeClass('none');
                
                let newpost;
                if(from == 'thread-show') {
                    if($("#ticked-post").length){
                        $("#thread-show-posts-container .resource-container:first-child").after(response);
                        newpost = $('#thread-show-posts-container .resource-container:eq(1)');
                    } else {
                        $('#thread-show-posts-container').prepend(response);
                        newpost = $('#thread-show-posts-container .resource-container').first();
                    }
                } else {
                    if($("#viewer-posts-container .viewer-ticked-post").length){
                        $("#viewer-posts-container .viewer-post-container:first-child").after(response);
                        newpost = $('#viewer-posts-container .viewer-post-container:eq(1)');
                    } else {
                        $('#viewer-posts-container').prepend(response);
                        newpost = $('#viewer-posts-container .viewer-post-container').first();
                    }
                }

                // Handling all events of the newly appended reply
                handle_post_events(newpost);
                handle_post_other_events(newpost);
                handle_resource_like(newpost.find('.like-resource'));
    
                // Get posts count and increment it
                let post_id = newpost.find('.post-id').first().val();
                let posts_count = parseInt(share_post_box.find('.selected-thread-posts-count').first().val(), 10)+1;

                $('#thread-show-posts-count').text(posts_count); // counter in thread show
                $('#viewer-infos-section-box .posts-count').text(posts_count); // counter in media viewer
                $('#thread'+thread_id).find('.posts-count').text(posts_count); // counter in thread component
                // This exists only in places where user reply on the selected thread and we use it to get the current posts count
                $('.selected-thread-posts-count').val(posts_count);

                if(from == 'thread-show') {
                    if(last_opened_thread) {
                        $.ajax({
                            url: `/post/${post_id}/viewer/generate`,
                            type: 'get',
                            success: function(post) {
                                $('#media-viewer-posts-count').removeClass('none');
                                let viewerpost;
                                if ($(".viewer-ticked-post").length){
                                    $("#viewer-posts-container .viewer-post-container:first-child").after(post);
                                    viewerpost = $('#viewer-posts-container .viewer-post-container:eq(1)');
                                } else {
                                    $('#viewer-posts-container').prepend(post);
                                    viewerpost = $('#viewer-posts-container .viewer-post-container').first();
                                }
                                // Handling all events of the newly appended component
                                handle_post_events(viewerpost);
                                handle_post_other_events(viewerpost);
                                handle_resource_like(viewerpost.find('.like-resource'));
                                $('.viewer-thread-replies-number').text(posts_count);
                            }
                        });
                    }
                } else {
                    if($('#thread-show-posts-container').length) {
                        $.ajax({
                            url: `/post/${post_id}/show/generate`,
                            type: 'get',
                            success: function(post) {
                                $('#thread-show-posts-count').removeClass('none');
                                $('#global-error').css('display', 'none');
                                let pst;
                                if ($("#ticked-post")[0]){
                                    $("#thread-show-posts-container .resource-container:first-child").after(post);
                                    pst = $('#thread-show-posts-container .resource-container:eq(1)');
                                } else {
                                    $('#thread-show-posts-container').prepend(post);
                                    pst = $('#thread-show-posts-container .resource-container').first();
                                }
                                $('.thread-replies-number').text(posts_count);
    
                                // Handling all events of the newly appended component
                                handle_post_events(pst);
                                handle_post_other_events(pst);
                                handle_resource_like(pst.find('.like-resource'));
                            }
                        })
                    }
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
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
                buttonicon.removeClass('none');
                button.removeClass('disabled-typical-button-style');
    
                share_post_lock = true;
            }
        })
    });
}

function handle_post_reply_tick_button(post) {
    let post_tick_container = post.find('.tick-post-container');
    let remove_best_reply = post_tick_container.find('.remove-best-reply').val();
    let mark_best_reply = post_tick_container.find('.mark-best-reply').val();
    let button = post_tick_container.find('.post-tick-button');

    button.on('click', function(event) {
        let button = $(this);
        $('.post-tick-button').addClass('none');
        button.removeClass('none');

        let grey_tick = button.find('.grey-tick');
        let green_tick = button.find('.green-tick');

        if(grey_tick.hasClass('none')) {
            $('.post-tick-button').removeClass('none');
            $('.post-tick-button .grey-tick').removeClass('none');
            
            grey_tick.removeClass('none');
            green_tick.addClass('none');
            $('.remove-tick-from-thread').addClass('none'); // Hide remove tick from thrread in parent thread component

            $(this).attr('title', mark_best_reply);
            post.find('.post-main-component').attr('style', '');
            post.find('.post-main-section').attr('style', '');
            post.find('.best-reply-ticket').addClass('none');
            post.attr('id', '');

            $('.thread-component-tick').addClass('none');
        } else {
            grey_tick.addClass('none');
            green_tick.removeClass('none');
            $('.remove-tick-from-thread').removeClass('none'); // Show remove tick from thrread in parent thread component

            $(this).attr('title', remove_best_reply);
            post.find('.post-main-component').attr('style', 'border-color: #28882678;');
            post.find('.post-main-section').attr('style', 'background-color: #e1ffe438;');
            post.find('.best-reply-ticket').removeClass('none');
            post.attr('id', 'ticked-post');

            $('.thread-component-tick').removeClass('none');
        }

        let post_id = $(this).parent().find('.post-id').val();
        $.ajax({
            url: '/post/' + post_id + '/tick',
            type: 'post',
            data: {
                _token: csrf
            },
            success: function(response) {
                if(response == 1)
                    basic_notification_show(button.find('.ticked-message').val());
                else
                    basic_notification_show(button.find('.unticked-message').val());
            },
            error: function(response) {
                if(grey_tick.hasClass('none')) {
                    grey_tick.removeClass('none');
                    green_tick.addClass('none');
                    $('.remove-tick-from-thread').addClass('none');

                    $('.post-tick-button').removeClass('none');
                    
                    post.find('.post-main-component').attr('style', '');
                    post.find('.post-main-section').attr('style', '');
                    post.find('.best-reply-ticket').addClass('none');
                } else {
                    post.find('.grey-tick').addClass('none');
                    post.find('.green-tick').removeClass('none');
                    $('.remove-tick-from-thread').removeClass('none');
                }

                let error = JSON.parse(response.responseText).message;
                display_top_informer_message(error, 'warning');
            },
            complete: function() {
                vote_tick_lock = true;
            }
        })
        event.preventDefault();
    });
}

function handle_expend_post_content(post) {
    let original_content_height = post.find('.post-content-wrapper')[0].scrollHeight;
    let max_height = parseInt(post.find('.post-content-wrapper').css('max-height'), 10);

    if(original_content_height > max_height) {
        let expandbutton = post.find('.expend-post-content-button');
        expandbutton.removeClass('none');

        expandbutton.on('click', function() {
            let status = expandbutton.find('.status');
            if(status.val() == 'contracted') {
                post.find('.post-content-wrapper').removeClass('post-content-wrapper-max-height');
                status.val('expanded');
            } else {
                post.find('.post-content-wrapper').addClass('post-content-wrapper-max-height');
                status.val('contracted');
            }
        });
    }
}
