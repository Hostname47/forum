$('.search-for-post-input').on('click', function(event) {
    if($(this).val() != '' && $(this).val() == last_post_searchquery) {
        $(this).parent().find('.search-result-container').removeClass('none');
    }
    event.stopPropagation();
});

let last_post_searchquery = "";
let postsearch_lock = true;
$('.search-for-post-input').on('keyup', function(event) {
    let value = $(this).val();
    if(value == '') {
        $(this).parent().find('.search-result-container').addClass('none');
        return;
    }

    if (event.key === 'Enter' || event.keyCode === 13) {
        if(value != last_post_searchquery) {
            if(!postsearch_lock) return;
            postsearch_lock = false;

            $(this).parent().find('.result-box').html('');
        
            let searchinput = $(this);
            let result_container = searchinput.parent().find('.search-result-container');
            let loadingfade = result_container.find('.search-result-faded');
            let noresult = result_container.find('.search-no-results');
        
            noresult.addClass('none');

            loadingfade.removeClass('none');
            result_container.removeClass('none');
            last_post_searchquery = value;

            $.ajax({
                url: '/admin/search/post?k=' + value,
                success: function(response) {
                    // we return an array : content & hasnext from serverside
                    if(response) {
                        let result_box = result_container.find('.result-box');
                        result_box.html('');
                        
                        let post_search_component = result_container.find('.search-post-record-skeleton').clone();
                        post_search_component.removeClass('search-post-record-skeleton');
                        post_search_component.removeClass('none');

                        post_search_component.find('.post-seearch-record-content').text(response.content);
                        post_search_component.attr('href', post_search_component.attr('href') + "?postid=" + response.id);
                        result_box.append(post_search_component);
                    } else
                        noresult.removeClass('none'); // If not result (empty result) returned we display no results by showing noresult
                },
                complete: function() {
                    loadingfade.addClass('none');
                    postsearch_lock = true;
                }
            });
        } else // If enter pressed and the search query is the same we only need to open the result container 
            $(this).parent().find('.search-result-container').removeClass('none');
    }
});

// Hide search result panel if user click somewhere not belong to search 
$('body').on('click', function() {
    $('.search-result-container').addClass('none');
});
  
$('.search-result-container').on('click', function(event) {
    event.stopPropagation();
});

let post_restore_lock = true;
$('.post-restore-button').on('click', function() {
    if(!post_restore_lock) return;
    post_restore_lock = false;

    let button = $(this);
    let spinner = button.parent().find('.spinner');
    let postid = button.find('.post-id').val();
    button.attr('style', 'cursor: not-allowed; background-color: #888');

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');

    let data = { _token: csrf };

    if($('#pm-clean-warnings')[0].checked) data.cleanwarnings = 1;
    if($('#pm-clean-strikes')[0].checked) data.cleanstrikes = 1;

    restorepost(postid, data)
        .done(function(response) {
            basic_notification_show(button.find('.post-restored-message').val(), 'basic-notification-round-tick');
            location.reload();
        })
        .catch(function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            button.attr('style', '');
            
            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            
            display_top_informer_message(er, 'error');
            post_restore_lock = true;
        });
});

function restorepost(postid, data) {
    return $.ajax({
        url: `/admin/posts/${postid}/restore`,
        type: 'patch',
        data: data
    });
}

let admin_delete_post_lock = true;
$('#delete-post-button').on('click', function() {
    if(!admin_delete_post_lock) return;
    admin_delete_post_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();

    button.addClass('disabled-red-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    let delete_post_box = button;
    while(!delete_post_box.hasClass('delete-post-box')) delete_post_box = delete_post_box.parent();

    let data = {
        _token: csrf,
        post_id: button.find('.post-id').val(),
        wsvalue: delete_post_box.find('.ws-owner-after-deleting-post:checked').val()
    };

    $.ajax({
        type: 'delete',
        url: '/admin/posts/delete',
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
            admin_delete_post_lock = true;
        }
    })
});

let admin_permanent_delete_post_lock = true;
$('#permanent-delete-post-button').on('click', function() {
    if(!admin_permanent_delete_post_lock) return;
    admin_permanent_delete_post_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();

    button.addClass('disabled-red-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'delete',
        url: '/admin/posts/delete/force',
        data: {
            _token: csrf,
            post_id: button.find('.post-id').val()
        },
        success: function(response) {
            basic_notification_show(successmessage);
            window.location.href = response.link;
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
            admin_permanent_delete_post_lock = true;
        }
    })
});

let admin_restore_post_lock = true;
$('#restore-deleted-post-button').on('click', function() {
    if(!admin_restore_post_lock) return;
    admin_restore_post_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();
    
    let restorebox = button;
    while(!restorebox.hasClass('post-restore-box')) restorebox = restorebox.parent();
    
    let data = {
        _token: csrf,
        post_id: button.find('.post-id').val()
    };
    if($('#post-restore-clean-warnings')[0].checked) data.cleanwarnings = 1;
    if($('#post-restore-clean-strikes')[0].checked) data.cleanstrikes = 1;
    console.log(data);
    
    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'patch',
        url: '/admin/posts/restore',
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
            
            button.removeClass('disabled-typical-button-style');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            admin_restore_post_lock = true;
        }
    })
});
