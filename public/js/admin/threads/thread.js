
$('.search-for-threads-input').on('click', function(event) {
    if($(this).val() != '' && $(this).val() == lastthreadsearchquery) {
        $(this).parent().find('.search-result-container').removeClass('none');
    }
    event.stopPropagation();
});

let lastthreadsearchquery;
let threadsearch_lock = true;
$('.search-for-threads-input').on('keyup', function(event) {
    let value = $(this).val();
    if(value == '') {
        $(this).parent().find('.search-result-container').addClass('none');
        return;
    }

    if (event.key === 'Enter' || event.keyCode === 13) {
        $('#admin-thread-search-fetch-more').addClass('none');
        if(value != lastthreadsearchquery) {
            $(this).parent().find('.result-box').html('');
        
            let searchinput = $(this);
            let result_container = searchinput.parent().find('.search-result-container');
            let loadingfade = result_container.find('.search-result-faded');
            let noresult = result_container.find('.search-no-results');
        
            noresult.addClass('none');
            
            if(value != '') {
                if(!threadsearch_lock) return;
                threadsearch_lock = false;

                loadingfade.removeClass('none');
                result_container.removeClass('none');
                lastthreadsearchquery = value;

                $.ajax({
                    url: '/admin/search/threads?k=' + value,
                    success: function(response) {
                        // we return an array : content & hasnext from serverside
                        let result = response.content;
                        if(result.length) {
                            let result_box = result_container.find('.result-box');
                            let thread_search_component = result_container.find('.search-thread-record-skeleton');
                            result_box.html('');
                            append_thread_result_records_to_result_box(result, thread_search_component, result_box);

                            if(response.hasnext) $('#admin-thread-search-fetch-more').removeClass('none');
                            else $('#admin-thread-search-fetch-more').addClass('none');
                        } else
                            noresult.removeClass('none'); // If not result (empty result) returned we display no results by showing noresult
                    },
                    complete: function() {
                        loadingfade.addClass('none');
                        threadsearch_lock = true;
                    }
                });

            } else {
                result_container.addClass('none');
                threadsearch_lock = true;
            }
        
            event.stopPropagation();
        } else // If enter pressed and the search query is the same we only need to open the result container
            $(this).parent().find('.search-result-container').removeClass('none');
    }
    event.stopPropagation();
});

// Hide search result panel if user click somewhere not belong to search 
$('body').on('click', function() {
    $('.search-result-container').addClass('none');
});
  
$('.search-result-container').on('click', function(event) {
    event.stopPropagation();
});

// Handle thread search fetch more
let thread_search_fetch_more = $('#admin-thread-search-fetch-more');
let thread_search_result_box = thread_search_fetch_more.parent().find('.result-box');
let thread_search_fetch_more_lock = true;
$('#admin-thread-search-fetch-more').on('click', function() {
    if(!thread_search_fetch_more_lock) return;
    thread_search_fetch_more_lock=false;

    let button = $(this);
    let spinner = button.find('.spinner');

    button.css('cursor', 'not-allowed');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');

    let present_records_count = thread_search_result_box.find('.search-thread-record').length;

    $.ajax({
        url: `/admin/search/threads/fetchmore?k=${lastthreadsearchquery}&skip=${present_records_count}`,
        type: 'get',
        success: function(response) {
            let result = response.content;
            let thread_search_component = thread_search_fetch_more.parent().find('.search-thread-record-skeleton');

            append_thread_result_records_to_result_box(result, thread_search_component, thread_search_result_box);
            if(response.hasnext)
                $('#admin-thread-search-fetch-more').removeClass('none');
            else
                $('#admin-thread-search-fetch-more').addClass('none');
        },
        complete: function() {
            thread_search_fetch_more_lock = true;
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            button.css('cursor', 'pointer');
        }
    });
});

function append_thread_result_records_to_result_box(records, thread_search_component, resultbox) {
    for(let i = 0; i < records.length; i++) {
        let thread_record = thread_search_component.clone();
        thread_record.removeClass('search-thread-record-skeleton');
        thread_record.removeClass('none');

        thread_record.find('.thread-search-record-id').text(records[i].id);
        thread_record.find('.thread-seearch-record-subject').text(records[i].subject);
        thread_record.find('.thread-seearch-record-content').text(records[i].content);
        thread_record.attr('href', thread_record.attr('href') + "?threadid=" + records[i].id);
        resultbox.append(thread_record);
    }
}

let admin_thread_close_lock = true;
$('#close-thread-button').on('click', function() {
    if(!admin_thread_close_lock) return;
    admin_thread_close_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();
    let threadid = button.find('.thread-id').val();

    let closebox = button;
    while(!closebox.hasClass('thread-close-box')) closebox = closebox.parent();

    let data = {
        _token: csrf,
        threadid: threadid,
        closereason: closebox.find('.closereason').val(),
    };

    button.addClass('disabled-typical-button-style');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'patch',
        url: `/admin/threads/close`,
        data: data,
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
            admin_thread_close_lock = true;
        },
    });
});

let admin_thread_open_lock = true;
$('#open-thread-button').on('click', function() {
    if(!admin_thread_open_lock) return;
    admin_thread_open_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();

    button.addClass('disabled-typical-button-style');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'patch',
        url: `/admin/threads/open`,
        data: {
            _token: csrf,
            thread_id: button.find('.thread-id').val()
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
            admin_thread_open_lock = true;
        },
    });
});

// delete thread event attached to class based element because it is used twice (for delete and force admin delete)
let admin_thread_delete_lock = true;
$('.delete-thread-button').on('click', function() {
    if(!admin_thread_delete_lock) return;
    admin_thread_delete_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();

    let deletebox = button;
    while(!deletebox.hasClass('delete-thread-box')) deletebox = deletebox.parent();

    button.addClass('disabled-red-button-style');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'delete',
        url: '/admin/threads/delete',
        data: {
            _token: csrf,
            thread_id: button.find('.thread-id').val(),
            wsaction: deletebox.find('.ws-owner-after-deleting-thread:checked').val()
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
            button.removeClass('disabled-red-button-style');
            admin_thread_delete_lock = true;
        },
    });
});

let thread_restore_lock = true;
$('#restore-deleted-thread-button').on('click', function() {
    if(!thread_restore_lock) return;
    thread_restore_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let successmessage = button.find('.success-message').val();

    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'patch',
        url: '/admin/threads/restore',
        data: {
            _token: csrf,
            thread_id: button.find('.thread-id').val()
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
            
            button.removeClass('disabled-typical-button-style');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            thread_restore_lock = true;
        }
    })
});

let delete_thread_permanently_lock = true;
$('#permanent-delete-thread-button').on('click', function() {
    if(!delete_thread_permanently_lock) return;
    delete_thread_permanently_lock = false;

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
        url: '/admin/threads/delete/force',
        data: {
            _token: csrf,
            thread_id: button.find('.thread-id').val()
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
            delete_thread_permanently_lock = true;
        }
    })
});

let admin_thread_restore_lock = true;
$('.thread-restore-button').on('click', function() {
    if(!admin_thread_restore_lock) return;
    admin_thread_restore_lock = false;

    let button = $(this);
    let spinner = button.parent().find('.spinner');
    let threadid = $('#thread-id').val();
    button.attr('style', 'cursor: not-allowed; background-color: #888');

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');

    let data = { _token: csrf };

    if($('#tm-unclose-thread')[0].checked) data.unclose = 1;

    if($('#tm-clean-warnings')[0].checked) data.cleanwarnings = 1;

    if($('#tm-clean-strikes')[0].checked) data.cleanstrikes = 1;

    restorethread(threadid, data)
        .done(function(response) {
            basic_notification_show(button.find('.thread-restored-message').val(), 'basic-notification-round-tick');
            location.reload();
        })
        .catch(function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            button.attr('style', '');
            admin_thread_restore_lock = true;
        });
});

function restorethread(threadid, data) {
    return  $.ajax({
        type: 'patch',
        url: `/admin/threads/${threadid}/restore`,
        data: data,
    });
}
