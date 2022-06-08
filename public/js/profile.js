/**
 * The following line will remove follow from thread components because we are in profile
 * page and we can follow user directly from follow button under cover image
 */
$('.thread-component-follow-box').remove();

let followers_dialog_lock = true;
let followers_dialog_fetched = false;
$('#open-followers-dialog').on('click', function() {
    let viewer = $('#user-followers-viewer');
    let user_id = $(this).parent().find('.user-id').val();
    if(!followers_dialog_fetched) {
        if(!followers_dialog_lock) return;
        followers_dialog_lock = false;

        let spinner = viewer.find('.loading-spinner');
        spinner.addClass('inf-rotate');

        $.ajax({
            url: '/user/followers/viewer',
            data: {
                user_id: user_id
            },
            success: function(response) {
                viewer.find('.loading-box').remove();
                viewer.find('.global-viewer-content-box').html(response.payload);
                viewer.find('.follow-user').each(function() { handle_user_follow($(this)); })
                viewer.find('.login-signin-button').each(function() {
                    handle_login_lock($(this).parent());
                });
                if(response.hasmore)
                    handle_followers_load_more();
                followers_dialog_fetched = true;
            },
            complete: function() {
                followers_dialog_lock = true;
            }
        });
    }
    
    viewer.removeClass('none');
    disable_page_scroll();
})

function handle_followers_load_more() {
    let user_followers_fetch_more = $('#user-followers-container .fetch-more');
    let user_followers_box = $('#user-followers-container');
    user_followers_box.on('DOMContentLoaded scroll', function() {
        if(user_followers_box.scrollTop() + user_followers_box.innerHeight() + 58 >= user_followers_box[0].scrollHeight) {
            let status = user_followers_fetch_more.find('.status');
            if(status.val() == 'fetching') return;
            status.val('fetching');
    
            let spinner = user_followers_fetch_more.find('.spinner');
            let user_id = user_followers_fetch_more.find('.user-id').val();
            let skip = user_followers_box.find('.follow-box-item').length;
    
            spinner.addClass('inf-rotate');
            $.ajax({
                url: `/users/followers/fetchmore`,
                data: {
                    user_id: user_id,
                    skip: skip
                },
                success: function(response) {
                    $(response.payload).insertBefore(user_followers_fetch_more);
                    if(response.hasmore == false) {
                        user_followers_fetch_more.remove();
                        user_followers_box.off();
                    }

                    /**
                     * Notice here when we fetch the notifications we return the number of fetched notifs
                     * because we need to handle the last count of appended components events
                     * 
                     */
                    let unhandled_follower_components = 
                        user_followers_box.find('.follow-box-item').slice(response.count*(-1));
                        
                    unhandled_follower_components.each(function() {
                        handle_user_follow($(this).find('.follow-user'));
                        $(this).find('.login-signin-button').each(function() {
                            handle_login_lock($(this).parent());
                        });
                    });
                },
                complete: function() {
                    status.val('stable');
                }
            })
        }
    });
}

let follows_dialog_lock = true;
let follows_dialog_fetched = false;
$('#open-follows-dialog').on('click', function() {
    let viewer = $('#user-follows-viewer');
    let user_id = $(this).parent().find('.user-id').val();
    if(!follows_dialog_fetched) {
        if(!follows_dialog_lock) return;
        follows_dialog_lock = false;

        let spinner = viewer.find('.loading-spinner');
        spinner.addClass('inf-rotate');

        $.ajax({
            url: '/user/follows/viewer',
            data: {
                user_id: user_id
            },
            success: function(response) {
                viewer.find('.loading-box').remove();
                viewer.find('.global-viewer-content-box').html(response.payload);
                viewer.find('.follow-user').each(function() { handle_user_follow($(this)); })
                viewer.find('.login-signin-button').each(function() {
                    handle_login_lock($(this).parent());
                });
                if(response.hasmore)
                    handle_follows_load_more();
                follows_dialog_fetched = true;
            },
            complete: function() {
                follows_dialog_lock = true;
            }
        });
    }
    
    viewer.removeClass('none');
    disable_page_scroll();
})

function handle_follows_load_more() {
    let user_follows_fetch_more = $('#user-follows-container .fetch-more');
    let user_follows_box = $('#user-follows-container');
    user_follows_box.on('DOMContentLoaded scroll', function() {
        if(user_follows_box.scrollTop() + user_follows_box.innerHeight() + 58 >= user_follows_box[0].scrollHeight) {
            let status = user_follows_fetch_more.find('.status');
            if(status.val() == 'fetching') return;
            status.val('fetching');
    
            let spinner = user_follows_fetch_more.find('.spinner');
            let user_id = user_follows_fetch_more.find('.user-id').val();
            let skip = user_follows_box.find('.follow-box-item').length;
    
            spinner.addClass('inf-rotate');

            $.ajax({
                url: `/users/follows/fetchmore`,
                data: {
                    user_id: user_id,
                    skip: skip
                },
                success: function(response) {
                    $(response.payload).insertBefore(user_follows_fetch_more);
                    if(response.hasmore == false) {
                        user_follows_fetch_more.remove();
                        user_follows_box.off();
                    }
        
                    /**
                     * Notice here when we fetch the notifications we return the number of fetched notifs
                     * because we need to handle the last count of appended components events
                     * 
                     */
                    let unhandled_follow_components = 
                        user_follows_box.find('.follow-box-item').slice(response.count*(-1));
                        
                    unhandled_follow_components.each(function() {
                        handle_user_follow($(this).find('.follow-user'));
                        $(this).find('.login-signin-button').each(function() {
                            handle_login_lock($(this).parent());
                        });
                    });
                },
                complete: function() {
                    status.val('stable');
                }
            })
        }
    });
}
