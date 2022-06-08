// ============= avatar & cover management =============

let avatar_management_dialog_lock = true;
let avatar_management_dialog_fetched = false;
$('#open-avatars-manage-dialog').on('click', function() {
    let viewer = $('#review-user-avatars-viewer');
    let uid = $(this).parent().find('.user-id').val();
    if(!avatar_management_dialog_fetched) {
        if(!avatar_management_dialog_lock) return;
        avatar_management_dialog_lock = false;

        let spinner = viewer.find('.loading-spinner');
        spinner.addClass('inf-rotate');
        $.ajax({
            url: '/admin/users/avatarsviewer',
            data: {
                userid: uid
            },
            success: function(response) {
                avatar_management_dialog_fetched = true;
                viewer.find('.global-viewer-content-box').html(response);
                uav_avatars_length = $('#uav-avatars-length');
                handle_avatar_management_nav_buttons();
                handle_component_images_center(viewer);
                handle_toggling(viewer);
                handle_image_open(viewer);
                handle_avatar_delete_button();
                viewer.find('.loading-box').addClass('none');
            },
            complete: function() {
                avatar_management_dialog_lock = true;
            }
        });
    }
    
    viewer.removeClass('none');
    disable_page_scroll();
})

let cover_management_dialog_lock = true;
let cover_management_dialog_fetched = false;
$('#open-covers-manage-dialog').on('click', function() {
    let viewer = $('#review-user-covers-viewer');
    let uid = $(this).parent().find('.user-id').val();
    if(!cover_management_dialog_fetched) {
        if(!cover_management_dialog_lock) return;
        cover_management_dialog_lock = false;

        let spinner = viewer.find('.loading-spinner');
        spinner.addClass('inf-rotate');

        $.ajax({
            url: '/admin/users/coversviewer',
            data: {
                userid: uid
            },
            success: function(response) {
                cover_management_dialog_fetched = true;
                viewer.find('.global-viewer-content-box').html(response);
                ucv_covers_length = $('#ucv-covers-length')
                handle_cover_management_nav_buttons();
                handle_component_images_center(viewer);
                handle_toggling(viewer);
                handle_image_open(viewer);
                handle_cover_delete_button();
                viewer.find('.loading-box').addClass('none');
            },
            complete: function() {
                cover_management_dialog_lock = true;
            }
        });
    }
    
    viewer.removeClass('none');
    disable_page_scroll();
})

let uav_selected_avatar_id = 1;
let uav_avatars_length;// Hidden input holds current length of avatars
function handle_avatar_management_nav_buttons() {
    $('.uav-right-nav-button').on('click', function() {
        if((uav_selected_avatar_id+1) > parseInt(uav_avatars_length.val())) {
            // Reaches the end
        } else {
            // First show the fade loading
            $('#uav-avatar-fade').removeClass('none');
            // Then update the avatar id to get the net avatar
            uav_selected_avatar_id++;
    
            let link = get_avatar_by_id(uav_selected_avatar_id);
    
            if(link.parent().find('.avatar-can-be-managed').val())
                $('#uav-manage-avatar-section').removeClass('none');
            else
                $('#uav-manage-avatar-section').addClass('none');
            
            // Get the avatar img element
            let avatarimage = $('#uav-avatar-image');
            // Push link to avatar image
            avatarimage.attr('src', link.val());
            
            // Remove the fade loading when the image is loaded
            avatarimage.parent().imagesLoaded(function() {
                $('#uav-avatar-fade').addClass('none');
                image_center(avatarimage);
            });
    
            // Update selection counter
            $('#uav-selection-counter').text(uav_selected_avatar_id);
        }
    });

    $('.uav-left-nav-button').on('click', function() {
        if(uav_selected_avatar_id == 1) {
            // Reaches the end
        } else {
            $('#uav-avatar-fade').removeClass('none');
            uav_selected_avatar_id--;
            
            let link = get_avatar_by_id(uav_selected_avatar_id);
    
            if(link.parent().find('.avatar-can-be-managed').val())
                $('#uav-manage-avatar-section').removeClass('none');
            else
                $('#uav-manage-avatar-section').addClass('none');
    
            let avatarimage = $('#uav-avatar-image');
            avatarimage.attr('src', link.val());
            handle_image_dimensions(avatarimage);
    
            avatarimage.parent().imagesLoaded(function() {
                $('#uav-avatar-fade').addClass('none');
            });
    
            $('#uav-selection-counter').text(uav_selected_avatar_id);
        }
    });
}

let ucv_selected_cover_id = 1;
let ucv_covers_length; // Hidden input holds current length of covers
function handle_cover_management_nav_buttons() {
    $('.ucv-right-nav-button').on('click', function() {
        if((ucv_selected_cover_id+1) > parseInt(ucv_covers_length.val())) {
            // Reaches the end
        } else {
            $('#ucv-cover-fade').removeClass('none');
            ucv_selected_cover_id++;
            let link = get_cover_by_id(ucv_selected_cover_id);
            let coverimage = $('#ucv-cover-image');
            coverimage.attr('src', link.val());
    
            coverimage.parent().imagesLoaded(function() {
                coverimage.css('width', '100%');
                $('#ucv-cover-fade').addClass('none');
            });
    
            $('#ucv-selection-counter').text(ucv_selected_cover_id);
            $('.delete-cover-th').text(ucv_selected_cover_id);
        }
    });
    
    $('.ucv-left-nav-button').on('click', function() {
        if(ucv_selected_cover_id == 1) {
            // Reaches the end
        } else {
            $('#ucv-cover-fade').removeClass('none');
            ucv_selected_cover_id--;
            
            let link = get_cover_by_id(ucv_selected_cover_id);
    
            let coverimage = $('#ucv-cover-image');
            coverimage.attr('src', link.val());
            
            coverimage.parent().imagesLoaded(function() {
                coverimage.css('width', '100%');
                $('#ucv-cover-fade').addClass('none');
            });
    
            $('#ucv-selection-counter').text(ucv_selected_cover_id);
            $('.delete-cover-th').text(ucv_selected_cover_id);
        }
    });
}

let delete_avatar_lock = true;
function handle_avatar_delete_button() {
    $('#delete-user-avatar').on('click', function() {
        if(!delete_avatar_lock) return;
        delete_avatar_lock = false;
    
        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let successmessage = button.find('.success-message').val();
        let uid = button.find('.user-id').val();
        let avatarlink = get_avatar_by_id(uav_selected_avatar_id);
        
        let box = button;
        while(!box.hasClass('delete-user-avatar-box')) box = box.parent();
        let wsaction = box.find('.user-avatar-delete-ws:checked').val();
        
        spinner.removeClass('opacity0');
        spinner.addClass('inf-rotate');
        buttonicon.addClass('none');
        button.addClass('disabled-red-button-style');
    
        $.ajax({
            type: 'delete',
            url: `/admin/users/avatars/delete`,
            data: {
                _token: csrf,
                user_id: uid,
                link: avatarlink.val(),
                wsaction: wsaction
            },
            success: function(response) {
                basic_notification_show(successmessage);
                location.reload();
            },
            error: function(response) {
                delete_avatar_lock = true;
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
                buttonicon.removeClass('none');
                button.removeClass('disabled-red-button-style');

                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(error, 'error');
            }
        });
    });
}

let delete_user_cover_lock = true;
function handle_cover_delete_button() {
    $('#delete-user-cover').on('click', function() {
        if(!delete_user_cover_lock) return;
        delete_user_cover_lock = false;
    
        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let successmessage = button.find('.success-message').val();
        let uid = button.find('.user-id').val();
        let coverlink = get_cover_by_id(ucv_selected_cover_id);
        
        let box = button;
        while(!box.hasClass('delete-user-cover-box')) box = box.parent();
        let wsaction = box.find('.user-cover-delete-ws:checked').val();
        
        spinner.removeClass('opacity0');
        spinner.addClass('inf-rotate');
        buttonicon.addClass('none');
        button.addClass('disabled-red-button-style');
    
        $.ajax({
            type: 'delete',
            url: `/admin/users/covers/delete`,
            data: {
                _token: csrf,
                user_id: uid,
                link: coverlink.val(),
                wsaction: wsaction
            },
            success: function(response) {
                basic_notification_show(successmessage);
                location.reload();
            },
            error: function(response) {
                delete_user_cover_lock = true;
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
                buttonicon.removeClass('none');
                button.removeClass('disabled-red-button-style');

                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(error, 'error');
            }
        });
    });
}

function image_center(image) {
    let width = image.prop('naturalWidth');
    let height = image.prop('naturalHeight');

    if(width > height) {
        image.height('100%');
        image.css('width', 'max-content');
    } else if(width < height) {
        image.width('100%');
        image.css('height', 'max-content');
    } else {
        image.width('100%');
        image.height('100%');
    }
}
function get_avatar_by_id(id) {
    let link;
    let c = 1;
    $('.uav-avatar-link').each(function() {
        if(c == id) {
            link = $(this);
            return false;
        }
        c++;
    });

    return link;
}
function get_cover_by_id(id) {
    let link;
    let c = 1;
    $('.ucv-cover-link').each(function() {
        if(c == id) {
            link = $(this);
            return false;
        }
        c++;
    });

    return link;
}
// ============================

$('.open-threads-review-viewer').on('click', function() {
    $('#user-threads-review-viewer').removeClass('none');
});

$('.open-posts-review-viewer').on('click', function() {
    $('#user-posts-review-viewer').removeClass('none');
});

$('.open-warnings-and-strikes-review-viewer').on('click', function() {
    $('#user-warnings-and-strikes-review-viewer').removeClass('none');
});

$('.open-auth-breaks-viewer').on('click', function() {
    $('#auth-breaks-review-viewer').removeClass('none');
});

let warn_user_lock = true;
$('.warn-user-button').on('click', function() {
    if(!warn_user_lock) return;
    warn_user_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();

    let data = {
        _token: csrf,
        user_id: button.find('.user-id').val(),
        resource_id: button.find('.resource-id').val(),
        resource_type: button.find('.resource-type').val(),
    };

    let wsbox = button;
    while(!wsbox.hasClass('ws-warning-box')) wsbox = wsbox.parent();
    data.reason_id = wsbox.find('.warningreason').val();

    button.addClass('disabled-red-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'post',
        url: '/admin/users/warn',
        data: data,
        success: function() {
            basic_notification_show(successmessage);
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
            
            button.removeClass('disabled-red-button-style');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            warn_post_owner_lock = true;
        }
    })
});

let strike_user_lock = true;
$('.strike-user-button').on('click', function() {
    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();

    let data = {
        _token: csrf,
        user_id: button.find('.user-id').val(),
        resource_id: button.find('.resource-id').val(),
        resource_type: button.find('.resource-type').val(),
    };

    let wsbox = button;
    while(!wsbox.hasClass('ws-striking-box')) wsbox = wsbox.parent();
    data.reason_id = wsbox.find('.strikereason').val();

    button.addClass('disabled-red-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'post',
        url: '/admin/users/strike',
        data: data,
        success: function() {
            basic_notification_show(successmessage);
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
            
            button.removeClass('disabled-red-button-style');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            strike_post_owner_lock = true;
        }
    });
});

let delete_warning_from_user_lock = true;
$('#delete-warning-from-user-button').on('click', function() {
    if(!delete_warning_from_user_lock) return;
    delete_warning_from_user_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();

    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'delete',
        url: '/admin/warning',
        data: {
            _token: csrf,
            warning_id: button.find('.warning-id-to-remove').val()
        },
        success: function() {
            basic_notification_show(successmessage);
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
            
            button.removeClass('disabled-typical-button-style');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            delete_warning_from_user_lock = true;
        }
    })
});

let delete_strike_from_user_lock = true;
$('#delete-strike-from-user-button').on('click', function() {
    if(!delete_strike_from_user_lock) return;
    delete_strike_from_user_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();

    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'delete',
        url: '/admin/strike',
        data: {
            _token: csrf,
            strike_id: button.find('.strike-id-to-remove').val()
        },
        success: function() {
            basic_notification_show(successmessage);
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
            
            button.removeClass('disabled-typical-button-style');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            delete_strike_from_user_lock = true;
        }
    })
});

// ======= user management - resources review ========

// Fetch more user thread to review
let user_threads_review_fetch_more_lock = true;
function handle_threads_review_fetch_more() {
    let user_threads_review_fetch_more = $('#user-threads-review-fetch-more');
    let user_threads_review_box = $('#user-threads-review-box');

    if(user_threads_review_fetch_more.length) {
        user_threads_review_box.on('DOMContentLoaded scroll', function() {
            if(user_threads_review_box.scrollTop() + user_threads_review_box.innerHeight() + 50 >= user_threads_review_box[0].scrollHeight) {
                if(!user_threads_review_fetch_more_lock) return;
                user_threads_review_fetch_more_lock=false;
    
                let spinner = user_threads_review_fetch_more.find('.spinner');
                let user_id = user_threads_review_fetch_more.find('.user-id').val();
                let skip = $('#user-threads-review-box .thread-review-record').length;
                console.log(user_threads_review_fetch_more);
                console.log(user_id)
                spinner.addClass('inf-rotate');
                $.ajax({
                    type: 'post',
                    url: `/admin/user/threads/review/fetchmore`,
                    data: {
                        _token: csrf,
                        user_id: user_id,
                        skip: skip,
                        take: 10
                    },
                    success: function(response) {
                        if(response.payload != "")
                            user_threads_review_box.find('.threads-container').append($(`${response.payload}`));
                
                        if(response.hasmore == false) {
                            user_threads_review_fetch_more.remove();
                            user_threads_review_box.off();
                        }
    
                        /**
                         * Notice here when we fetch the notifications we return the number of fetched notifs
                         * because we need to handle the last count of appended components events
                         */
                        let unhandled_threads_review_components = 
                            user_threads_review_box.find(".thread-review-record").slice(response.count*(-1));
    
                        unhandled_threads_review_components.each(function() {
                            handle_thread_render($(this).find('.render-thread'));
                            handle_tooltip($(this));
                        });
                    },
                    complete: function() {
                        user_threads_review_fetch_more_lock = true;
                    },
                    error: function(response) {
                        /**
                         * Once an error occured we have to stop the event altogether and display the error
                         */
                         user_threads_review_box.off();
                        let errorObject = JSON.parse(response.responseText);
                        let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                        if(errorObject.errors) {
                            let errors = errorObject.errors;
                            error = errors[Object.keys(errors)[0]][0];
                        }
                        display_top_informer_message(error, 'error');
                    }
                });
            }
        });
    }
}

// Fetch more user posts to review
let user_posts_review_fetch_more_lock = true;
function handle_posts_review_fetch_more() {
    let user_posts_review_fetch_more = $('#user-posts-review-fetch-more');
    let user_posts_review_box = $('#user-posts-review-box');

    if(user_posts_review_fetch_more.length) {
        user_posts_review_box.on('DOMContentLoaded scroll', function() {
            if(user_posts_review_box.scrollTop() + user_posts_review_box.innerHeight() + 50 >= user_posts_review_box[0].scrollHeight) {
                if(!user_posts_review_fetch_more_lock) return;
                user_posts_review_fetch_more_lock=false;
    
                let spinner = user_posts_review_fetch_more.find('.spinner');
                let user_id = user_posts_review_fetch_more.find('.user-id').val();
                let skip = $('#user-posts-review-box .post-review-record').length;
    
                spinner.addClass('inf-rotate');
                $.ajax({
                    type: 'post',
                    url: `/admin/user/posts/review/fetchmore`,
                    data: {
                        _token: csrf,
                        user_id: user_id,
                        skip: skip,
                        take: 10
                    },
                    success: function(response) {
                        if(response.payload != "")
                            user_posts_review_box.find('.posts-container').append($(`${response.payload}`));
                
                        if(response.hasmore == false) {
                            user_posts_review_fetch_more.remove();
                            user_posts_review_box.off();
                        }
    
                        /**
                         * Notice here when we fetch the notifications we return the number of fetched notifs
                         * because we need to handle the last count of appended components events
                         */
                        let unhandled_posts_review_components = 
                            user_posts_review_box.find(".post-review-record").slice(response.count*(-1));
    
                        unhandled_posts_review_components.each(function() {
                            handle_thread_render($(this).find('.render-thread'));
                            handle_post_render($(this).find('.render-post'));
                            handle_tooltip($(this));
                        });
                    },
                    complete: function() {
                        user_posts_review_fetch_more_lock = true;
                    },
                    error: function(response) {
                        /**
                         * Once an error occured we have to stop the event altogether and display the error
                         */
                        user_posts_review_box.off();
                        let errorObject = JSON.parse(response.responseText);
                        let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                        if(errorObject.errors) {
                            let errors = errorObject.errors;
                            error = errors[Object.keys(errors)[0]][0];
                        }
                        display_top_informer_message(error, 'error');
                    }
                });
            }
        });
    }
}

// Fetch more user votes to review
let user_votes_review_fetch_more_lock = true;
function handle_votes_review_fetch_more() {
    let user_votes_review_fetch_more = $('#user-votes-review-fetch-more');
    let user_votes_review_box = $('#user-votes-review-box');

    if(user_votes_review_fetch_more.length) {
        user_votes_review_box.on('DOMContentLoaded scroll', function() {
            if(user_votes_review_box.scrollTop() + user_votes_review_box.innerHeight() + 50 >= user_votes_review_box[0].scrollHeight) {
                if(!user_votes_review_fetch_more_lock) return;
                user_votes_review_fetch_more_lock=false;
    
                let spinner = user_votes_review_fetch_more.find('.spinner');
                let user_id = user_votes_review_fetch_more.find('.user-id').val();
                let skip = $('#user-votes-review-box .thread-review-record').length 
                    + $('#user-votes-review-box .post-review-record').length;
    
                spinner.addClass('inf-rotate');
                $.ajax({
                    type: 'post',
                    url: `/admin/user/votes/review/fetchmore`,
                    data: {
                        _token: csrf,
                        user_id: user_id,
                        skip: skip,
                        take: 10
                    },
                    success: function(response) {
                        if(response.payload != "")
                            user_votes_review_box.find('.user-votes-container').append($(`${response.payload}`));
                
                        if(response.hasmore == false) {
                            user_votes_review_fetch_more.remove();
                            user_votes_review_box.off();
                        }
    
                        // the appended user votes resources are encapsulated in a div with class user-votes-review-chunk
                        $('.user-votes-review-chunk').last().find('.thread-review-record, .post-review-record').each(function() {
                            handle_thread_render($(this).find('.render-thread'));
                            handle_post_render($(this).find('.render-post'));
                            handle_tooltip($(this));
                        });
                    },
                    complete: function() {
                        user_votes_review_fetch_more_lock = true;
                    },
                    error: function(response) {
                        /**
                         * Once an error occured we have to stop the event altogether and display the error
                         */
                        user_votes_review_box.off();
                        let errorObject = JSON.parse(response.responseText);
                        let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                        if(errorObject.errors) {
                            let errors = errorObject.errors;
                            error = errors[Object.keys(errors)[0]][0];
                        }
                        display_top_informer_message(error, 'error');
                    }
                });
            }
        });
    }
}

// Fetch more user visits to review
let user_visits_review_fetch_more_lock = true;
function handle_visits_review_fetch_more() {
    let user_visits_review_fetch_more = $('#user-visits-review-fetch-more');
    let user_visits_review_box = $('#user-visits-review-box .user-visits-container');

    if(user_visits_review_fetch_more.length) {
        user_visits_review_box.on('DOMContentLoaded scroll', function() {
            if(user_visits_review_box.scrollTop() + user_visits_review_box.innerHeight() + 50 >= user_visits_review_box[0].scrollHeight) {
                if(!user_visits_review_fetch_more_lock || user_visits_review_fetch_more.hasClass('no-fetch')) return;
                user_visits_review_fetch_more_lock=false;
    
                let spinner = user_visits_review_fetch_more.find('.spinner');
                let user_id = user_visits_review_fetch_more.find('.user-id').val();
                let skip = user_visits_review_box.find('.user-visit-review-record').length;
                let filter = user_visits_review_fetch_more.find('.current-filter').val();
    
                spinner.addClass('inf-rotate');
                $.ajax({
                    type: 'post',
                    url: `/admin/user/visits/review/fetchmore`,
                    data: {
                        _token: csrf,
                        user_id: user_id,
                        skip: skip,
                        filter: filter,
                        take: 10
                    },
                    success: function(response) {
                        let visits = response.visits;
                        for(let i = 0;i < visits.length; i++) {
                            let component = $('#user-visits-review-box .user-visit-review-record-skeleton').clone();
                            component.find('.link').attr('href', visits[i].url);
                            component.find('.link').text(visits[i].url);
                            component.find('.hits').text(visits[i].hits);
    
                            component.removeClass('user-visit-review-record-skeleton none');
                            $(component).insertBefore($('#user-visits-review-fetch-more'));
                        }
    
                        if(response.hasmore == false)
                            user_visits_review_fetch_more.addClass('no-fetch none');
                    },
                    complete: function() {
                        user_visits_review_fetch_more_lock = true;
                    },
                    error: function(response) {
                        /**
                         * Once an error occured we have to stop the event altogether and display the error
                         */
                        user_visits_review_box.off();
                        let errorObject = JSON.parse(response.responseText);
                        let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                        if(errorObject.errors) {
                            let errors = errorObject.errors;
                            error = errors[Object.keys(errors)[0]][0];
                        }
                        display_top_informer_message(error, 'error');
                    }
                });
            }
        });
    }
}

let change_user_visits_filter = true;
function handle_visits_review_filter() {
    $('.user-review-visits-links-filter').on('click', function(event) {
        let button = $(this);
        if(!change_user_visits_filter || button.hasClass('user-review-visit-filter-selected')) return;
        change_user_visits_filter = false;
    
        let spinner = button.find('.spinner');
        let filter = button.find('.filter').val();
        let user_id = button.parent().find('.user-id').val();
    
        spinner.removeClass('opacity0');
        spinner.addClass('inf-rotate');
        $.ajax({
            type: 'post',
            url: '/admin/user/visits/filter',
            data: {
                _token: csrf,
                user_id: user_id,
                filter: filter,
            },
            success: function(response) {
                $('.user-visit-review-record:not(.user-visit-review-record-skeleton)').remove();
                let visits = response.visits;
                if(visits.length) {
                    for(let i = 0; i < visits.length; i++) {
                        let component = $('#user-visits-review-box .user-visit-review-record-skeleton').clone();
                        component.find('.link').attr('href', visits[i].url);
                        component.find('.link').text(visits[i].url);
                        component.find('.hits').text(visits[i].hits);
        
                        component.removeClass('user-visit-review-record-skeleton none');
                        $(component).insertBefore($('#user-visits-review-fetch-more'));
                    }
                    $('#user-visits-review-box').find('.no-visits').addClass('none');
                } else
                    $('#user-visits-review-box').find('.no-visits').removeClass('none');
    
                if(response.hasmore)
                    $('#user-visits-review-fetch-more').removeClass('none no-fetch');
                else
                    $('#user-visits-review-fetch-more').addClass('none no-fetch');
                
                // set selected button filter
                $('.user-review-visits-links-filter').removeClass('user-review-visit-filter-selected');
                button.addClass('user-review-visit-filter-selected');
                // update selected filter name
                $('#user-visits-filter-selection-name').text(button.find('.filter-name').val());
                // Set filter in fetchmore loader to fetch depends on filter selected
                $('#user-visits-review-fetch-more').find('.current-filter').val(button.find('.filter').val());
    
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
                button.parent().css('display', 'none');
                event.stopPropagation();
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let er = errorObject.message;
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    er = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(er, 'error');
            },
            complete: function(response) {
                change_user_visits_filter = true;
            }
        })
    });
}

// Fetch more user authbreaks to review
let user_authbreaks_review_fetch_more_lock = true;
function handle_authbreaks_review_fetch_more() {
    let user_authbreaks_review_fetch_more = $('#user-authbreaks-review-fetch-more');
    let user_authbreaks_review_box = $('#user-authbreaks-review-box');
    if(user_authbreaks_review_fetch_more.length) {
        user_authbreaks_review_box.on('DOMContentLoaded scroll', function() {
            if(user_authbreaks_review_box.scrollTop() + user_authbreaks_review_box.innerHeight() + 50 >= user_authbreaks_review_box[0].scrollHeight) {
                if(!user_authbreaks_review_fetch_more_lock) return;
                user_authbreaks_review_fetch_more_lock=false;
    
                let spinner = user_authbreaks_review_fetch_more.find('.spinner');
                let user_id = user_authbreaks_review_fetch_more.find('.user-id').val();
                let skip = $('#user-authbreaks-review-box .user-authbreak-record:not(.user-authbreak-record-skeleton)').length;
    
                spinner.addClass('inf-rotate');
                $.ajax({
                    type: 'post',
                    url: `/admin/user/authbreaks/review/fetchmore`,
                    data: {
                        _token: csrf,
                        user_id: user_id,
                        skip: skip,
                        take: 12
                    },
                    success: function(response) {
                        $(response.payload).insertBefore(user_authbreaks_review_fetch_more);
                        let unhandled_authbreaks_review_components = 
                            user_authbreaks_review_box.find(".user-authbreak-record").slice(response.count*(-1));
    
                        unhandled_authbreaks_review_components.each(function() {
                            handle_thread_render($(this).find('.render-thread'));
                            handle_post_render($(this).find('.render-post'));
                            handle_tooltip($(this));
                        });
                
                        if(response.hasmore == false) {
                            user_authbreaks_review_fetch_more.remove();
                            user_authbreaks_review_box.off();
                        }
                    },
                    complete: function() {
                        user_authbreaks_review_fetch_more_lock = true;
                    },
                    error: function(response) {
                        /**
                         * Once an error occured we have to stop the event altogether and display the error
                         */
                        user_authbreaks_review_box.off();
                        let errorObject = JSON.parse(response.responseText);
                        let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                        if(errorObject.errors) {
                            let errors = errorObject.errors;
                            error = errors[Object.keys(errors)[0]][0];
                        }
                        display_top_informer_message(error, 'error');
                    }
                });
            }
        });
    }
}

// Fetch more user warnings to review
let user_warnings_review_fetch_more_lock = true;
function handle_warnings_review_fetch_more() {
    let user_warnings_review_fetch_more = $('#user-warnings-review-fetch-more');
    let user_warnings_review_box = $('#user-warnings-review-box');
    if(user_warnings_review_fetch_more.length) {
        user_warnings_review_box.on('DOMContentLoaded scroll', function() {
            if(user_warnings_review_box.scrollTop() + user_warnings_review_box.innerHeight() + 50 >= user_warnings_review_box[0].scrollHeight) {
                if(!user_warnings_review_fetch_more_lock) return;
                user_warnings_review_fetch_more_lock=false;
    
                let spinner = user_warnings_review_fetch_more.find('.spinner');
                let user_id = user_warnings_review_fetch_more.find('.user-id').val();
                let skip = user_warnings_review_box.find('.user-warning-record').length;
    
                spinner.addClass('inf-rotate');
                $.ajax({
                    type: 'post',
                    url: `/admin/user/warnings/review/fetchmore`,
                    data: {
                        _token: csrf,
                        user_id: user_id,
                        skip: skip,
                        take: 8
                    },
                    success: function(response) {
                        $(response.payload).insertBefore(user_warnings_review_fetch_more);
                        let unhandled_warnings_review_components = 
                            user_warnings_review_box.find(".user-warning-record").slice(response.count*(-1));
    
                        unhandled_warnings_review_components.each(function() {
                            handle_tooltip($(this));
                            handle_toggling($(this));
                            handle_image_open($(this));
                            handle_remove_warning_from_user_dialog_open($(this).find('.open-warning-remove-from-user-dialog'));
                            handle_ws_resource_simple_render($(this).find('.get-ws-simple-resource-render'));
                        });
                
                        if(response.hasmore == false) {
                            user_warnings_review_fetch_more.remove();
                            user_warnings_review_box.off();
                        }
                    },
                    complete: function() {
                        user_warnings_review_fetch_more_lock = true;
                    },
                    error: function(response) {
                        /**
                         * Once an error occured we have to stop the event altogether and display the error
                         */
                        user_warnings_review_box.off();
                        let errorObject = JSON.parse(response.responseText);
                        let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                        if(errorObject.errors) {
                            let errors = errorObject.errors;
                            error = errors[Object.keys(errors)[0]][0];
                        }
                        display_top_informer_message(error, 'error');
                    }
                });
            }
        });
    }
}

// Fetch more user strikes to review
let user_strikes_review_fetch_more_lock = true;
function handle_strikes_review_fetch_more() {
    let user_strikes_review_fetch_more = $('#user-strikes-review-fetch-more');
    let user_strikes_review_box = $('#user-strikes-review-box');

    if(user_strikes_review_fetch_more.length) {
        user_strikes_review_box.on('DOMContentLoaded scroll', function() {
            if(user_strikes_review_box.scrollTop() + user_strikes_review_box.innerHeight() + 50 >= user_strikes_review_box[0].scrollHeight) {
                if(!user_strikes_review_fetch_more_lock) return;
                user_strikes_review_fetch_more_lock=false;
    
                let spinner = user_strikes_review_fetch_more.find('.spinner');
                let user_id = user_strikes_review_fetch_more.find('.user-id').val();
                let skip = user_strikes_review_box.find('.user-strike-record').length;
    
                spinner.addClass('inf-rotate');
                $.ajax({
                    type: 'post',
                    url: `/admin/user/strikes/review/fetchmore`,
                    data: {
                        _token: csrf,
                        user_id: user_id,
                        skip: skip,
                        take: 8
                    },
                    success: function(response) {
                        $(response.payload).insertBefore(user_strikes_review_fetch_more);
                        let unhandled_strikes_review_components = 
                            user_strikes_review_box.find(".user-strike-record").slice(response.count*(-1));
    
                        unhandled_strikes_review_components.each(function() {
                            handle_tooltip($(this));
                            handle_toggling($(this));
                            handle_image_open($(this));
                            handle_remove_strike_from_user_dialog_open($(this).find('.open-strike-remove-from-user-dialog'));
                            handle_ws_resource_simple_render($(this).find('.get-ws-simple-resource-render'));
                        });
                
                        if(response.hasmore == false) {
                            user_strikes_review_fetch_more.remove();
                            user_strikes_review_box.off();
                        }
                    },
                    complete: function() {
                        user_strikes_review_fetch_more_lock = true;
                    },
                    error: function(response) {
                        /**
                         * Once an error occured we have to stop the event altogether and display the error
                         */
                        user_strikes_review_box.off();
                        let errorObject = JSON.parse(response.responseText);
                        let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                        if(errorObject.errors) {
                            let errors = errorObject.errors;
                            error = errors[Object.keys(errors)[0]][0];
                        }
                        display_top_informer_message(error, 'error');
                    }
                });
            }
        });
    }
}

let user_threads_viewer_fetched = false;
let get_user_threads_viewer_lock;
$('#open-user-threads-dialog').on('click', function() {
    let viewer = $('#review-user-threads-viewer');
    let user_id = $(this).find('.user-id').val();
    if(!user_threads_viewer_fetched) {
        viewer.find('.loading-spinner').addClass('inf-rotate');

        $.ajax({
            url: `/admin/users/threads/review?userid=${user_id}`,
            success: function(response) {
                viewer.find('.global-viewer-content-box').html(response);
                handle_threads_review_fetch_more();
                handle_tooltip(viewer);
                viewer.find('.render-thread').each(function() {
                    handle_thread_render($(this));
                });
                viewer.find('.loading-box').remove();
                user_threads_viewer_fetched = true;
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let er = errorObject.message;
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    er = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(er, 'error');
            },
            complete: function() {
                get_user_threads_viewer_lock = true;
            }
        });
    }

    viewer.removeClass('none');
    disable_page_scroll();
});

let user_posts_viewer_fetched = false;
let get_user_posts_viewer_lock;
$('#open-user-posts-dialog').on('click', function() {
    let viewer = $('#review-user-posts-viewer');
    let user_id = $(this).find('.user-id').val();
    if(!user_posts_viewer_fetched) {
        viewer.find('.loading-spinner').addClass('inf-rotate');

        $.ajax({
            url: `/admin/users/posts/review?userid=${user_id}`,
            success: function(response) {
                viewer.find('.global-viewer-content-box').html(response);
                handle_posts_review_fetch_more();
                handle_tooltip(viewer);
                viewer.find('.render-post').each(function() { handle_post_render($(this)); });
                viewer.find('.render-thread').each(function() { handle_thread_render($(this)); });
                viewer.find('.loading-box').remove();
                user_posts_viewer_fetched = true;
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let er = errorObject.message;
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    er = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(er, 'error');
            },
            complete: function() {
                get_user_posts_viewer_lock = true;
            }
        });
    }

    viewer.removeClass('none');
    disable_page_scroll();
});

let user_votes_viewer_fetched = false;
let get_user_votes_viewer_lock = true;
$('#open-user-votes-dialog').on('click', function() {
    let viewer = $('#review-user-votes-viewer');
    let user_id = $(this).find('.user-id').val();
    if(!user_votes_viewer_fetched) {
        if(!get_user_votes_viewer_lock) return;
        get_user_votes_viewer_lock = false;
        viewer.find('.loading-spinner').addClass('inf-rotate');

        $.ajax({
            url: `/admin/users/votes/review?userid=${user_id}`,
            success: function(response) {
                viewer.find('.global-viewer-content-box').html(response);
                handle_votes_review_fetch_more();
                handle_tooltip(viewer);
                viewer.find('.render-post').each(function() { handle_post_render($(this)); });
                viewer.find('.render-thread').each(function() { handle_thread_render($(this)); });
                viewer.find('.loading-box').remove();
                user_votes_viewer_fetched = true;
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let er = errorObject.message;
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    er = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(er, 'error');
            },
            complete: function() {
                get_user_votes_viewer_lock = true;
            }
        });
    }

    viewer.removeClass('none');
    disable_page_scroll();
});

let user_visits_viewer_fetched = false;
let get_user_visits_viewer_lock = true;
$('#open-user-visits-dialog').on('click', function() {
    let viewer = $('#review-user-visits-viewer');
    let user_id = $(this).find('.user-id').val();
    if(!user_visits_viewer_fetched) {
        if(!get_user_visits_viewer_lock) return;
        get_user_visits_viewer_lock = false;
        viewer.find('.loading-spinner').addClass('inf-rotate');

        $.ajax({
            url: `/admin/users/visits/review?userid=${user_id}`,
            success: function(response) {
                viewer.find('.global-viewer-content-box').html(response);
                handle_visits_review_fetch_more();
                handle_element_suboption_containers(viewer);
                handle_visits_review_filter();
                viewer.find('.loading-box').remove();
                user_visits_viewer_fetched = true;
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let er = errorObject.message;
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    er = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(er, 'error');
            },
            complete: function() {
                get_user_visits_viewer_lock = true;
            }
        });
    }

    viewer.removeClass('none');
    disable_page_scroll();
});

let user_authbreaks_viewer_fetched = false;
let get_user_authbreaks_viewer_lock = true;
$('#open-user-authbreaks-dialog').on('click', function() {
    let viewer = $('#review-user-authbreaks-viewer');
    let user_id = $(this).find('.user-id').val();
    if(!user_authbreaks_viewer_fetched) {
        if(!get_user_authbreaks_viewer_lock) return;
        get_user_authbreaks_viewer_lock = false;
        viewer.find('.loading-spinner').addClass('inf-rotate');

        $.ajax({
            url: `/admin/users/authbreaks/review?userid=${user_id}`,
            success: function(response) {
                viewer.find('.global-viewer-content-box').html(response);

                let unhandled_authbreaks_components = 
                    viewer.find(".user-authbreak-record");

                unhandled_authbreaks_components.each(function() {
                    handle_tooltip($(this));
                    viewer.find('.render-thread').each(function() { handle_thread_render($(this)); });
                    viewer.find('.render-post').each(function() { handle_post_render($(this)); });
                });

                handle_authbreaks_review_fetch_more();
                viewer.find('.loading-box').remove();
                user_authbreaks_viewer_fetched = true;
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
                get_user_authbreaks_viewer_lock = true;
            }
        });
    }

    viewer.removeClass('none');
    disable_page_scroll();
});

let user_warnings_viewer_fetched = false;
let get_user_warnings_viewer_lock = true;
$('#open-user-warnings-dialog').on('click', function() {
    let viewer = $('#review-user-warnings-viewer');
    let user_id = $(this).find('.user-id').val();
    if(!user_warnings_viewer_fetched) {
        if(!get_user_warnings_viewer_lock) return;
        get_user_warnings_viewer_lock = false;
        viewer.find('.loading-spinner').addClass('inf-rotate');

        $.ajax({
            url: `/admin/users/warnings/review?userid=${user_id}`,
            success: function(response) {
                viewer.find('.global-viewer-content-box').html(response);

                handle_warnings_review_fetch_more();
                handle_tooltip(viewer);
                handle_image_open(viewer);
                handle_toggling(viewer);
                viewer.find('.get-ws-simple-resource-render').each(function() { handle_ws_resource_simple_render($(this)); });
                viewer.find('.open-warning-remove-from-user-dialog').each(function() { handle_remove_warning_from_user_dialog_open($(this)); });

                viewer.find('.loading-box').remove();
                user_warnings_viewer_fetched = true;
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
                get_user_warnings_viewer_lock = true;
            }
        });
    }

    viewer.removeClass('none');
    disable_page_scroll();
});

let user_strikes_viewer_fetched = false;
let get_user_strikes_viewer_lock = true;
$('#open-user-strikes-dialog').on('click', function() {
    let viewer = $('#review-user-strikes-viewer');
    let user_id = $(this).find('.user-id').val();
    if(!user_strikes_viewer_fetched) {
        if(!get_user_strikes_viewer_lock) return;
        get_user_strikes_viewer_lock = false;
        viewer.find('.loading-spinner').addClass('inf-rotate');

        $.ajax({
            url: `/admin/users/strikes/review?userid=${user_id}`,
            success: function(response) {
                viewer.find('.global-viewer-content-box').html(response);

                handle_strikes_review_fetch_more();
                handle_tooltip(viewer);
                handle_image_open(viewer);
                handle_toggling(viewer);
                viewer.find('.get-ws-simple-resource-render').each(function() { handle_ws_resource_simple_render($(this)); });
                viewer.find('.open-strike-remove-from-user-dialog').each(function() { handle_remove_strike_from_user_dialog_open($(this)); });

                viewer.find('.loading-box').remove();
                user_strikes_viewer_fetched = true;
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
                get_user_strikes_viewer_lock = true;
            }
        });
    }

    viewer.removeClass('none');
    disable_page_scroll();
});

// ======== BAN SECTION ========

let clean_expired_ban_lock = true;
$('#clean-expired-ban-button').on('click', function() {
    if(!clean_expired_ban_lock) return;
    clean_expired_ban_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();

    button.addClass('disabled-typical-button-style');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'post',
        url: `/admin/users/bans/clean-expired`,
        data: {
            _token: csrf,
            user_id: button.find('.user-id').val()
        },
        success: function(response) {
            basic_notification_show(successmessage);
            location.reload();
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            if(errorObject.errors) {
                let errors = errorObject.errors;
                er = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(er, 'error');

            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            button.removeClass('disabled-typical-button-style');
            clean_expired_ban_lock = true;
        },
    });
});

// Fetch more user bans to review
let user_bans_review_fetch_more_lock = true;
let user_bans_review_fetch_more = $('#user-bans-fetch-more');
let user_bans_review_box = $('#user-bans-box');
user_bans_review_box.on('DOMContentLoaded scroll', function() {
    if(user_bans_review_box.scrollTop() + user_bans_review_box.innerHeight() + 50 >= user_bans_review_box[0].scrollHeight) {
        if(!user_bans_review_fetch_more_lock) return;
        user_bans_review_fetch_more_lock=false;

        let spinner = user_bans_review_fetch_more.find('.spinner');
        let user_id = user_bans_review_fetch_more.find('.user-id').val();
        let skip = user_bans_review_box.find('.user-ban-record').length;
        
        spinner.addClass('inf-rotate');
        $.ajax({
            type: 'post',
            url: `/admin/user/bans/review/fetchmore`,
            data: {
                _token: csrf,
                user_id: user_id,
                skip: skip,
                take: 3
            },
            success: function(response) {
                $(response.payload).insertBefore(user_bans_review_fetch_more);
        
                if(response.hasmore == false) {
                    user_bans_review_fetch_more.remove();
                    user_bans_review_box.off();
                }
            },
            complete: function() {
                user_bans_review_fetch_more_lock = true;
            }
        });
    }
});

$('.um-ban-type-switch').on('change', function() {
    let box = $(this);
    while(!box.hasClass('um-ban-type-box')) box = box.parent();

    if($(this).val() == 'temporary') {
        box.find('.temporary-ban-box').removeClass('none');
        box.find('.permanent-ban-box').addClass('none');
    } else {
        box.find('.temporary-ban-box').addClass('none');
        box.find('.permanent-ban-box').removeClass('none');
    }
});

let ban_user_lock = true;
$('#ban-user-button').on('click', function() {
    if(!ban_user_lock) return;
    ban_user_lock = false;
    
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let successmessage = button.find('.success-message').val();

    let banbox = button;
    while(!banbox.hasClass('um-ban-type-box')) banbox = banbox.parent();

    let data = {
        _token: csrf,
        user_id: button.find('.user-id').val(),
        ban_reason: banbox.find('.ban-reason').val(),
        type: banbox.find('.um-ban-type-switch:checked').val()
    };
    if(data.type == 'temporary')
        data.ban_duration = banbox.find('.ban-duration').val();

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.addClass('disabled-red-button-style');
    
    $.ajax({
        type: 'post',
        url: `/admin/users/ban`,
        data: data,
        success: function(response) {
            basic_notification_show(successmessage, 'basic-notification-round-tick');
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

            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.removeClass('disabled-red-button-style');

            ban_user_lock = true;
        }
    });
});

let unban_user_lock = true;
$('#unban-user-button').on('click', function() {
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let successmessage = button.find('.success-message').val();

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.addClass('disabled-typical-button-style');
    
    $.ajax({
        type: 'post',
        url: `/admin/users/unban`,
        data: {
            _token: csrf,
            user_id: button.find('.user-id').val(),
        },
        success: function(response) {
            basic_notification_show(successmessage);
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

            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.removeClass('disabled-typical-button-style');

            ban_user_lock = true;
        }
    });
});
