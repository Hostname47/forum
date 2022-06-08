// Category add
let category_add_lock = true;
$('#category-add-button').on('click', function() {
    if(!category_add_lock) return;
    category_add_lock = false;

    // Validating inputs
    let icon=$('#category-icon'), 
        name=$('#category-name'), 
        slug=$('#category-slug'), 
        description=$('#category-description');

    if(name.val() == '') {
        category_add_error_handle(name, $('#name-required-error-message').val());
        return;
    } else
        name.parent().find('.err').addClass('none');

    if(slug.val() == '') {
        category_add_error_handle(slug, $('#slug-required-error-message').val());
        return;
    } else
        slug.parent().find('.err').addClass('none');

    if(description.val() == '') {
        category_add_error_handle(description, $('#description-required-error-message').val());
        return;
    } else
        description.parent().find('.err').addClass('none');

    // If the parser reach here, it means all inputs pass validation phase
    $('.err').addClass('none');
    $('#category-add-error').text('');
    $('#category-add-error-container').addClass('none');

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let data = {
        _token: csrf,
        category: $('#category-name').val(),
        slug: $('#category-slug').val(),
        description: $('#category-description').val(),
    };
    data.forum_id = $('#forum-id').val();
    data.icon = (iv = icon.val()) ? iv : null;

    button.attr('style', 'background-color: #565e77; cursor: default;');
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');

    $.ajax({
        type: 'post',
        url: `/admin/categories/add`,
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
            category_add_lock = true;
        }
    })
});

function category_add_error_handle(input, message) {
    input.parent().find('.err').removeClass('none');
    $('#category-add-error').text(message);
    $('#category-add-error-container').removeClass('none');
    window.scrollTo(0, 0);

    category_add_lock = true;
    return;
}

// ============ Category approve ===========

$('.open-category-approve-confirmation-dialog').on('click', function() {
    $('#category-approve-viewer').removeClass('none');
    disable_page_scroll();
});

$('.select-category-status-after-approve').on('click', function() {
    if($(this).find('.radio-status').val() == 0)
        $('#category-status-after-approve').val('');
    else
        $('#category-status-after-approve').val($(this).find('.status').val());
});

$('#approve-category-confirm-input').on('input', function() {
    let input_value = $(this).val();
    let confirm_value = $('#approve-category-confirm-value').val();
    let button = $('#approve-category-button');
    
    able_to_approve = false;
    if(input_value == confirm_value) {
        // Along with enabling button we check the approval conditions
        if($('#parent-forum-is-archived').val().trim() == '1') {
            display_top_informer_message($('#parent-forum-is-archived-message').val(), 'warning');
            return;
        }
        if($('#parent-forum-is-under-review').val().trim() == '1') {
            display_top_informer_message($('#parent-forum-is-under-review-message').val(), 'warning');
            return;
        }
        if($('#category-status-after-approve').val() == '') {
            display_top_informer_message($('#category-status-after-approve-is-required-message').val(), 'warning');
            $(this).val($(this).val() + ' - ERROR : Specify the status')
            return;
        }

        able_to_approve = true;
        button.removeClass('disabled-green-button-style');
    } else
        button.addClass('disabled-green-button-style');
});

let approve_category_lock = true;
let able_to_approve = false;
$('#approve-category-button').on('click', function() {
    if(!able_to_approve) return;

    if(!approve_category_lock) return;
    approve_category_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');

    let categoryid = button.find('.category-id').val();
    let status_after_approve = $('#category-status-after-approve').val();

    button.attr('style', 'background-color: #84bb91; cursor: default;')
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');

    $.ajax({
        type: 'patch',
        url: `/admin/categories/approve`,
        data: {
            _token: csrf,
            cid: categoryid,
            status: status_after_approve
        },
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
            approve_category_lock = true;
        }
    });
});

// ============ Category ignore - delete (under review) ===========

$('.open-category-ignore-dialog').on('click', function() {
    $('#category-ignore-viewer').removeClass('none');
    disable_page_scroll();
});

$('#ignore-category-confirm-input').on('input', function() {
    let input_value = $(this).val();
    let confirm_value = $('#ignore-category-confirm-value').val();
    let button = $('#ignore-ur-category-button');
  
    if(input_value == confirm_value)
        button.removeClass('disabled-red-button-style');
    else
        button.addClass('disabled-red-button-style');
});

let ignore_category_lock = true;
$('#ignore-ur-category-button').on('click', function() {
    let input_value = $('#ignore-category-confirm-input').val();
    let confirm_value = $('#ignore-category-confirm-value').val();
    if(input_value != confirm_value) return;

    if(!ignore_category_lock) return;
    ignore_category_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let cid = button.find('.category-id').val();

    button.attr('style', 'cursor: default; cursor: not-allowed; background-color: #ee7d7d');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'delete',
        url: '/admin/categories/under-review/ignore',
        data: {
            _token: csrf,
            cid: cid
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

            ignore_category_lock = true;
        }
    });
});

// ============ Category edit ===========
let select_forum_categories_lock = true;
$('.select-forum-categories-button').on('click', function() {
    if($(this).hasClass('forum-selected')) return;

    if(!select_forum_categories_lock) return;
    select_forum_categories_lock = false;

    let button = $(this);
    let spinner = $('#select-forum-spinner');
    let fid = button.find('.forum-id').val();

    let forum_selection_box = button;
    while(!forum_selection_box.hasClass('select-forum-section')) forum_selection_box = forum_selection_box.parent();

    let data = {
        _token: csrf,
        fid: fid
    };
    let status_excluded = null;
    if(forum_selection_box.find('.status-excluded').length)
        data.status_excluded = forum_selection_box.find('.status-excluded').val().split(',');

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');

    $.ajax({
        type: 'post',
        url: `/admin/forums/${fid}/categories`,
        data: data,
        success: function(response) {
            // First emptying the categories box from previous categories
            $('#categories-scrollable-box').html('');

            let categories = response.categories;
            for(let i=0;i<categories.length;i++) {
                let clonedcomponent = $('.forum-category-select-component').first().clone();
                clonedcomponent.removeClass('forum-category-select-component');
                clonedcomponent.removeClass('none');

                clonedcomponent.find('.category-text').text(categories[i].category);
                clonedcomponent.find('.category-status').text(categories[i].status);
                clonedcomponent.attr('href', clonedcomponent.attr('href') + "?categoryid=" + categories[i].id);

                let status = categories[i].status;
                if(status == 'Archived') {
                    clonedcomponent.find('.category-status').addClass('gray');
                } else if(status == 'Live')
                    clonedcomponent.find('.category-status').addClass('green');
                else if(status == 'Closed')
                    clonedcomponent.find('.category-status').addClass('red');
                else if(status == 'Under Review')
                    clonedcomponent.find('.category-status').addClass('blue');


                $('#categories-scrollable-box').append(clonedcomponent);
            }
            $('#forum-selected-p').removeClass('none');
            $('#forum-selected').text(response.forum);

            if(!categories.length)
                $('#no-categories-yet').removeClass('none');
            else
                $('#no-categories-yet').addClass('none');

            $('.select-forum-categories-button').removeClass('forum-selected-button-style');
            $('.select-forum-categories-button').removeClass('forum-selected');
            button.addClass('forum-selected-button-style');
            button.addClass('forum-selected');
            
            $('body').trigger('click');
        },
        error: function() {

        },
        complete: function() {
            select_forum_categories_lock = true;
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
        }
    })
});

let update_category_status_lock = true;
$('.update-category-status').on('click', function() {
    if(!update_category_status_lock) return;
    update_category_status_lock = false;

    // If current status selected again we stop event
    if($(this).hasClass('selected-status')) {
        update_category_status_lock = true;
        return;
    };

    let button = $(this);
    let spinner = button.find('.spinner');
    let button_icon = button.find('.icon-above-spinner');
    let categoryid = button.parent().find('.category-id').val();
    let status = button.find('.category-status').val();

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    button_icon.addClass('none');
    button.css('cursor', 'not-allowed');

    $.ajax({
        type: 'patch',
        url: `/admin/categories/status`,
        data: {
            _token: csrf,
            cid: categoryid,
            status: status
        },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            button_icon.removeClass('none');
            button.css('cursor', 'pointer');

            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            if(errorObject.errors) {
                let errors = errorObject.errors;
                er = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(er, 'error');
        },
        complete: function() {
            update_category_status_lock = true;
        }
    });
});

let catgeory_changes_save_lock = true;
$('.category-update-changes-button').on('click', function() {
    if(!catgeory_changes_save_lock) return;
    catgeory_changes_save_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let categoryid = button.find('.category-id').val();

    // Validating inputs
    let name=$('#category-name'), 
        slug=$('#category-slug'), 
        description=$('#category-description'),
        icon=$('#category-icon');

    if(name.val() == '') {
        category_edit_error_handle(name, $('#name-required-error-message').val());
        return;
    } else
        name.parent().find('.err').addClass('none');

    if(slug.val() == '') {
        category_edit_error_handle(slug, $('#slug-required-error-message').val());
        return;
    } else
        slug.parent().find('.err').addClass('none');

    if(description.val() == '') {
        category_edit_error_handle(description, $('#description-required-error-message').val());
        return;
    } else
        description.parent().find('.err').addClass('none');

    // If the parser reach here, it means all inputs pass validation phase
    $('.err').addClass('none');
    $('#forum-settings-error').text('');
    $('#forum-settings-error-container').addClass('none');

    button.attr('style', 'background-color: #565e77; cursor: default;')
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');

    let data = {
        _token: csrf,
        cid: categoryid,
        category: $('#category-name').val(),
        slug: $('#category-slug').val(),
        description: $('#category-description').val(),
    };
    data.icon = (iv = icon.val()) ? iv : null;
    
    $.ajax({
        type: 'patch',
        url: `/admin/categories/update`,
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
            display_top_informer_message(er, 'error');
        },
        complete: function() {
            catgeory_changes_save_lock = true;
        }
    });
});

function category_edit_error_handle(input, message) {
    input.parent().find('.err').removeClass('none');
    $('#category-manage-error').text(message);
    $('#category-manage-error-container').removeClass('none');
    window.scrollTo(0, 0);

    catgeory_hanges_save_lock = true;
    return;
}

// ============ Category archive ============

$('#archive-category-confirm-input').on('input', function() {
    let input = $(this);
    let button = $('#archive-category-button');
    let confirm_value = $('#archive-category-confirm-value').val();

    if(input.val() == confirm_value)
        button.removeClass('disabled-red-button-style');
    else
        button.addClass('disabled-red-button-style');
});

$('.open-category-archive-confirmation-dialog').on('click', function() {
    $('#category-archive-viewer').removeClass('none');
    disable_page_scroll();
});

let archive_category_lock = true;
$('#archive-category-button').on('click', function() {
    if(!archive_category_lock) return;
    archive_category_lock = false;

    let confirm_input_value = $('#archive-category-confirm-input').val();
    let confirm_value = $('#archive-category-confirm-value').val();

    if(confirm_input_value != confirm_value) {
        archive_category_lock = true;
        return;
    }

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let cid = button.find('.category-id').val();
    
    button.attr('style', 'cursor: default; cursor: not-allowed; background-color: #ee7d7d');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'patch',
        url: '/admin/categories/archive',
        data: {
            _token: csrf,
            cid: cid
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
            archive_category_lock = true;
        }
    })
});

// ============ Restore archive ============

$('#restore-category-confirm-input').on('input', function() {
    let input = $(this);
    let button = $('#restore-category-button');
    let confirm_value = $('#restore-category-confirm-value').val();

    able_to_restore = false;
    if(input.val() == confirm_value) {
        if($('#category-status-after-restore').val() == '') {
            display_top_informer_message($('#category-status-after-restore-is-required-message').val(), 'warning');
            input.val(input.val() + ' - ERROR : specify the status')
            return;
        }

        able_to_restore=true;
        button.removeClass('disabled-green-button-style');
    } else
        button.addClass('disabled-green-button-style');
});

$('.open-category-restore-confirmation-dialog').on('click', function() {
    $('#category-restore-viewer').removeClass('none');
    disable_page_scroll();
});

$('.select-category-status-after-restore').on('click', function() {
    if($(this).find('.radio-status').val() == 0)
        $('#category-status-after-restore').val('');
    else
        $('#category-status-after-restore').val($(this).find('.status').val());
});

let category_restore_lock = true;
let able_to_restore = false;
$('#restore-category-button').on('click', function() {
    if(!category_restore_lock || !able_to_restore) return;
    category_restore_lock = false;

    let confirm_value = $('#restore-category-confirm-value').val();
    let input_value = $('#restore-category-confirm-input').val();

    if(confirm_value != input_value) {
        category_restore_lock = true;
        return;
    }

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let cid = button.find('.category-id').val();
    let status_after_restore = $('#category-status-after-restore').val();
    
    button.attr('style', 'background-color: #84bb91; cursor: default;');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'patch',
        url: '/admin/categories/restore',
        data: {
            _token: csrf,
            cid: cid,
            status_after_restore: status_after_restore
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
            category_restore_lock = true;
        }
    });
});

scrollLeftpanel('f-a-c-category-management');
