// --- forum add ---

let forum_add_lock = true;
$('.forum-add-button').on('click', function() {
    if(!forum_add_lock) return;
    forum_add_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');

    // Validating inputs
    let icon=$('#forum-icon'), 
        name=$('#forum-name'), 
        slug=$('#forum-slug'), 
        description=$('#forum-description');

    if(name.val() == '') {
        forum_add_error_handle(name, $('#name-required-error-message').val());
        return;
    } else
        name.parent().find('.err').addClass('none');

    if(slug.val() == '') {
        forum_add_error_handle(slug, $('#slug-required-error-message').val());
        return;
    } else
        slug.parent().find('.err').addClass('none');

    if(description.val() == '') {
        forum_add_error_handle(description, $('#description-required-error-message').val());
        return;
    } else
        description.parent().find('.err').addClass('none');

    // If the parser reach here, it means all inputs pass validation phase
    $('.err').addClass('none');
    $('#forum-add-error').text('');
    $('#forum-add-error-container').addClass('none');

    let data = {
        _token: csrf,
        forum: name.val(),
        slug: slug.val(),
        description: description.val()
    };
    if(icon.val()) data.icon = icon.val();

    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');

    $.ajax({
        type: 'post',
        url: `/admin/forums/add`,
        data: data,
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.removeClass('disabled-typical-button-style');

            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            if(errorObject.errors) {
                let errors = errorObject.errors;
                er = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(er, 'error');
            forum_add_lock = true;
        }
    });
});

function forum_add_error_handle(input, message) {
    input.parent().find('.err').removeClass('none');
    $('#forum-add-error').text(message);
    $('#forum-add-error-container').removeClass('none');
    window.scrollTo(0, 0);

    forum_add_lock = true;
    return;
}

// --- forum approve ---

$('.open-forum-approve-confirmation-dialog').on('click', function() {
    $('#forum-approve-viewer').removeClass('none');
    disable_page_scroll();
});

$('.select-forum-status-after-approve').on('click', function() {
    if($(this).find('.radio-status').val() == 0)
        $('#forum-status-after-approve').val('');
    else
        $('#forum-status-after-approve').val($(this).find('.status').val());
});

$('#approve-forum-confirm-input').on('input', function() {
    let input_value = $(this).val();
    let confirm_value = $('#approve-forum-confirm-value').val();
    let button = $('#approve-forum-button');
    
    able_to_approve = false;
    if(input_value == confirm_value) {
        // Before open the button we check our condition for forum approve
        let icon_present = $('#forum-icon-present').val().trim() == '1';
        let announcements_present = $('#announcements-category-present').val().trim() == '1';
        let selected_categories = [];
        $('.select-category-to-approve-checkbox').each(function() {
            if($(this).find('.checkbox-status').val() == '1') {
                selected_categories.push($(this).find('.category-id').val());
            }
        });
        let at_least_one_category_selected = (selected_categories.length) ? true : false;
        let status_after_approve = $('#forum-status-after-approve').val();

        if(!handle_forum_approve_condition(icon_present, $('#icon-is-required-message').val())) return;
        if(!handle_forum_approve_condition(announcements_present, $('#announcements-is-required-message').val())) return;
        if(!handle_forum_approve_condition(at_least_one_category_selected, $('#at-least-one-category-approved-message').val())) return;
        if(!handle_forum_approve_condition(status_after_approve!='', $('#forum-status-after-approve-is-required-message').val())) return;

        able_to_approve = true;
        button.removeClass('disabled-green-button-style');
    } else
        button.addClass('disabled-green-button-style');
});

let forum_approve_lock = true;
let able_to_approve = false;
$('#approve-forum-button').on('click', function() {
    if(!forum_approve_lock || !able_to_approve) return;
    forum_approve_lock = false;

    let selected_categories = [];
    $('.select-category-to-approve-checkbox').each(function() {
        if($(this).find('.checkbox-status').val() == '1') {
            selected_categories.push($(this).find('.category-id').val());
        }
    });
    let status_after_approve = $('#forum-status-after-approve').val();

    /**
     * At this point the forum has an icon, has announcements category, status after approving specified, and
     * at least one category selected to be approved along with the forum.
     * So our forum is ready to be approved; We need to pass status and selected categories to controller
     */
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let fid = button.find('.fid').val();

    let data = {
        _token: csrf,
        fid: fid,
        categories: selected_categories, // categories to ba approved along with forum
        status: status_after_approve, // status of forum after approve
    };

    // If the parser reach here, it means all inputs pass validation phase
    $('.err').addClass('none');
    $('#forum-settings-error').text('');
    $('#forum-settings-error-container').addClass('none');

    button.attr('style', 'background-color: #84bb91; cursor: default;')
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');

    $.ajax({
        type: 'patch',
        url: `/admin/forums/approve`,
        data: data,
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.attr('style', '');

            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            if(errorObject.errors) {
                let errors = errorObject.errors;
                er = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(er, 'error');
        },
        complete: function() {
            forum_approve_lock = true;
        }
    });
});

function handle_forum_approve_condition(condition, message_when_fail) {
    if(!condition) {
        display_top_informer_message(message_when_fail, 'warning');
        $('#approve-forum-confirm-input').val($('#approve-forum-confirm-input').val() + ' - ERROR')
        return false;
    }

    return true;
}

// --- forum edit ---
let forum_update_lock = true;
$('.forum-update-button').on('click', function() {
    if(!forum_update_lock) return;
    forum_update_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let fid = button.find('.fid').val();

    // Validating inputs
    let icon=$('#forum-icon'), 
        name=$('#forum-name'), 
        slug=$('#forum-slug'), 
        description=$('#forum-description');

    if(name.val() == '') {
        forum_settings_error_handle(name, $('#name-required-error-message').val());
        return;
    } else
        name.parent().find('.err').addClass('none');

    if(slug.val() == '') {
        forum_settings_error_handle(slug, $('#slug-required-error-message').val());
        return;
    } else
        slug.parent().find('.err').addClass('none');

    if(description.val() == '') {
        forum_settings_error_handle(description, $('#description-required-error-message').val());
        return;
    } else
        description.parent().find('.err').addClass('none');

    let data = {
        _token: csrf,
        forum: name.val(),
        slug: slug.val(),
        description: description.val()
    };
    data.icon = (iv = icon.val()) ? iv : null;

    // If the parser reach here, it means all inputs pass validation phase
    $('.err').addClass('none');
    $('#forum-settings-error').text('');
    $('#forum-settings-error-container').addClass('none');

    button.attr('style', 'background-color: #565e77; cursor: default;')
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');

    $.ajax({
        type: 'patch',
        url: `/admin/forums/${fid}/patch`,
        data: data,
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.attr('style', '');

            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            if(errorObject.errors) {
                let errors = errorObject.errors;
                er = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(er, 'error');
        },
        complete: function() {
            forum_update_lock = true;
        }
    });
});

function forum_settings_error_handle(input, message) {
    input.parent().find('.err').removeClass('none');
    $('#forum-settings-error').text(message);
    $('#forum-settings-error-container').removeClass('none');
    window.scrollTo(0, 0);

    forum_update_lock = true;
    return;
}

let update_forum_status_lock = true;
$('.update-forum-status').on('click', function() {
    if(!update_forum_status_lock) return;
    update_forum_status_lock = false;
    // If current status selected again we stop event
    if($(this).hasClass('selected-status')) {
        update_forum_status_lock = true;
        return;
    };

    let button = $(this);
    let spinner = button.find('.spinner');
    let button_icon = button.find('.icon-above-spinner');
    let fid = button.parent().find('.fid').val();
    let status = button.find('.forum-status').val();

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    button_icon.addClass('none');
    button.attr('style', 'cursor: not-allowed;');

    $.ajax({
        type: 'patch',
        url: `/admin/forums/${fid}/status`,
        data: {
            _token: csrf,
            status: status
        },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            button_icon.removeClass('none');
            button.attr('style', '');

            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            if(errorObject.errors) {
                let errors = errorObject.errors;
                er = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(er, 'error');
        },
        complete: function() {
            update_forum_status_lock = true;
        }
    })
});

// --- forum archive ---
$('.open-forum-archive-confirmation-dialog').on('click', function() {
  $('#forum-archive-viewer').removeClass('none');
  disable_page_scroll();
});

$('#archive-forum-confirm-input').on('input', function() {
  let input = $(this);
  let button = $('#archive-forum-button');
  let confirm_value = $('#confirm-value').val();

  if(input.val() == confirm_value)
      button.removeClass('disabled-red-button-style');
  else
      button.addClass('disabled-red-button-style');
});

let archive_forum_lock = true;
$('#archive-forum-button').on('click', function() {
  let confirm_input = $('#archive-forum-confirm-input');
  let confirm_value = $('#confirm-value').val();

  if(confirm_input.val() != confirm_value) return;

  if(!archive_forum_lock) return;
  archive_forum_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let fid = button.find('.fid').val();
    
    button.addClass('disabled-red-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'patch',
        url: '/admin/forums/archive',
        data: {
            _token: csrf,
            fid: fid
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            button.removeClass('disabled-red-button-style');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');

            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            if(errorObject.errors) {
                let errors = errorObject.errors;
                er = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(er, 'error');
        },
        complete: function() {
            archive_forum_lock = true;
        }
    })
});

// --- Restore forum ---
$('.open-forum-restore-confirmation-dialog').on('click', function() {
    $('#forum-restore-viewer').removeClass('none');
    disable_page_scroll();
});

$('.select-forum-status-after-restore').on('click', function() {
    if($(this).find('.radio-status').val() == 0)
        $('#forum-status-after-restore').val('');
    else
        $('#forum-status-after-restore').val($(this).find('.status').val());
});

$('#restore-forum-confirm-input').on('input', function() {
    let input_value = $(this).val();
    let button = $('#restore-forum-button');
    let confirm_value = $('#restore-forum-confirm-value').val();
    able_to_restore = false;
    if(input_value == confirm_value) {
        // When the inputs match we then check other conditions like categories to restore and status
        let categories_to_restore = [];
        $('.select-category-to-restore-checkbox').each(function() {
            if($(this).find('.checkbox-status').val() == '1')
                categories_to_restore.push($(this).find('.category-id').val());
        });
        let at_least_one_category_selected = (categories_to_restore.length) ? true : false;
        let status_after_restore = $('#forum-status-after-restore').val();

        if(!handle_forum_restore_condition(status_after_restore!='', $('#forum-status-after-restore-is-required-message').val())) return;
        if(!handle_forum_restore_condition(at_least_one_category_selected, $('#at-least-one-category-restored-message').val())) return;
        able_to_restore = true;
        
        button.removeClass('disabled-green-button-style');
    } else
        button.addClass('disabled-green-button-style');
});

function handle_forum_restore_condition(condition, message_when_fail) {
    if(!condition) {
        display_top_informer_message(message_when_fail, 'warning');
        restore_forum_lock = true;
        $('#restore-forum-confirm-input').val($('#restore-forum-confirm-input').val() + ' - ERROR');
        return false;
    }

    return true;
}

let restore_forum_lock = true;
let able_to_restore = false;
$('#restore-forum-button').on('click', function() {
    let confirm_input = $('#restore-forum-confirm-input').val();
    let confirm_value = $('#restore-forum-confirm-value').val();
    if(confirm_input != confirm_value) return;

    if(!restore_forum_lock || !able_to_restore) return;
    restore_forum_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    let fid = button.find('.forum-id').val();
    let categories_to_restore = [];
    $('.select-category-to-restore-checkbox').each(function() {
        if($(this).find('.checkbox-status').val() != '0') {
            categories_to_restore.push($(this).find('.category-id').val());
        }
    });
    let status_after_restore = $('#forum-status-after-restore').val();
    
    button.attr('style', 'cursor: default; cursor: not-allowed; background-color: #84bb91');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'patch',
        url: '/admin/forums/restore',
        data: {
            _token: csrf,
            fid: fid,
            categories_to_restore: categories_to_restore,
            status_after_restore: status_after_restore
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.attr('style', '');

            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            if(errorObject.errors) {
                let errors = errorObject.errors;
                er = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(er, 'error');
        },
        complete: function() {
            restore_forum_lock = true;
        }
    })
});

// --- delete forum under review ---
$('.open-forum-delete-dialog').on('click', function() {
    $('#forum-delete-viewer').removeClass('none');
    disable_page_scroll();
});

$('#delete-forum-confirm-input').on('input', function() {
    let input = $(this);
    let button = $('#delete-forum-button');
    let confirm_value = $('#delete-forum-confirm-value').val();
  
    if(input.val() == confirm_value)
        button.removeClass('disabled-red-button-style');
    else
        button.addClass('disabled-red-button-style');
});

let delete_forum_lock = true;
$('#delete-forum-button').on('click', function() {
    let confirm_input = $('#delete-forum-confirm-input').val();
    let confirm_value = $('#delete-forum-confirm-value').val();
    if(confirm_input != confirm_value) return;

    if(!delete_forum_lock) return;
    delete_forum_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let fid = button.find('.fid').val();

    button.attr('style', 'cursor: default; cursor: not-allowed; background-color: #ee7d7d');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'delete',
        url: '/admin/forums/under-review/ignore',
        data: {
            _token: csrf,
            fid: fid
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            button.attr('style', '');
            buttonicon.removeClass('none');

            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            if(errorObject.errors) {
                let errors = errorObject.errors;
                er = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(er, 'error');

            delete_forum_lock = true;
        },
    })
});

scrollLeftpanel('f-a-c-forum-management');
