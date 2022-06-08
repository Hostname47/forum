if($('.textarea-chars-counter').length && $('#about').length)
  $('.textarea-chars-counter').text($('#about').val().length);

if($("#datepicker").length) {
  $(function() {
      $("#datepicker").datepicker({
          changeMonth: true,
          changeYear: true,
          maxDate: "+1m +1w",
          yearRange: '1950:2021',
          dateFormat: "yy-mm-dd"
      });
  });
}

if($("#country_selector").length) {
    $("#country_selector").countrySelect({
        preferredCountries: ['ma', 'dz', 'tn', 'eg'],
        defaultCountry: "ma"
    });
}

if($('#user-personal-country').length) {
    let country = $('#user-personal-country').val();
    if(country != '')
        $("#country_selector").countrySelect("setCountry", country);
}

let username_check_lock = true;
$('.check-username').on('click', function() {
    if(!username_check_lock) return;
    username_check_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let username = $('#username').val();

    button.addClass('disabled-wtypical-button-style');
    buttonicon.addClass('none');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    
    $.ajax({
        url: '/users/username/check',
        type: 'post',
        data: {
            'username': username,
            '_token': csrf
        },
        success: function(response) {
            button.parent().find('.red-box').addClass('none');
            button.parent().find('.green-box').removeClass('none');
            button.parent().find('.green-box').css('display', 'flex');

            if(response.valid) {
                button.parent().find('.green').text(response.message);
            } else {
                button.parent().find('.green-box').addClass('none');
                button.parent().find('.red-box').removeClass('none');
                button.parent().find('.red-box').css('display', 'flex');

                button.parent().find('.error').text(response.message);
            }
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            
            button.parent().find('.green-box').addClass('none');
            button.parent().find('.red-box').removeClass('none');

            button.parent().find('.error').text(error);
        },
        complete: function() {
            username_check_lock = true;
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.removeClass('disabled-wtypical-button-style');
        }
    })
});

// ============

$('.avatar-upload-button').on('change', function(event) {
    // validate uploaded cover
    let uploaded_avatar = [event.target.files[0]];
    if(validate_image_file_Type(uploaded_avatar).length == 1)
        $('.error-container').addClass('none');
    else {
        $('.error-container .error-text').text($('#avatar-image-type-error-message').val());
        $('.error-container').removeClass('none');
        return;
    }

    // validating image size and dimensions is done in server side
    $('.avatar-image').attr('src', URL.createObjectURL(event.target.files[0]));
    $('.avatar-image').removeClass('none');
    // Handle uploaded avatar dimensions
    $('.avatar-image').attr('style', '');
    setTimeout(function() {
        handle_image_dimensions($('.avatar-image'));
    }, 400);

    $('.discard-uploaded-avatar').removeClass('none');
    $('.open-remove-avatar-dialog').addClass('none');

    $('body').trigger('click'); // Hide button parent suboptions-container
    event.stopPropagation();
});

$('.discard-uploaded-avatar').on('click', function(event) {
    $('#avatar').val(''); // Discard upload

    // Discard uploaded cover from image tag
    if($('.original-avatar').val() != '') {
        $('.avatar-image').attr('src', $('.original-avatar').val());
        $('.avatar-image').removeClass('none');
        $('.open-remove-avatar-dialog').removeClass('none');
    } else {
        $('.avatar-image').attr('src', $('.default-avatar').val());
        $('.add-avatar-notice').removeClass('none');
    }

    $(this).parent().css('display', 'none');
    event.stopPropagation();

    $('.discard-uploaded-avatar').addClass('none');
    $('.restore-original-avatar').addClass('none');
});

$('.open-remove-avatar-dialog').on('click', function(event) {
    let container = $(this);
    while(!container.hasClass('suboptions-container')) container = container.parent();
    container.css('display', 'none');
    event.stopPropagation();

    $('#remove-user-avatar-viewer').removeClass('none');
    disable_page_scroll();
});

$('.remove-avatar-button').on('click', function() {
    // Remove avatar by clearing avatar value, mark avatar removed as 1 and emptying avatar image previewer
    $('#avatar').val('');
    $('#avatar-removed').val('1');
    $('.avatar-image').attr('src', $('.default-avatar').val());

    // Hide remove avatar dialog viewer
    $('#remove-user-avatar-viewer .close-global-viewer').trigger('click');
    // Hide remove avatar dialog opener button because the user remove the avatar
    $('.open-remove-avatar-dialog').addClass('none');
    // Show revert cover deletion - Only show restore cover if user has already a cover
    if($('.original-avatar').val() != '')
        $('.restore-original-avatar').removeClass('none');
});

$('.restore-original-avatar').on('click', function(event) {
    $('.avatar-image').attr('src', $('.original-avatar').val());
    $('#avatar-removed').val('0');
    $('#avatar').val('');
    $(this).addClass('none');
    $('.open-remove-avatar-dialog').removeClass('none');
    $('.discard-uploaded-avatar').addClass('none');

    $(this).parent().css('display', 'none'); // Hide button parent suboptions-container
    event.stopPropagation();
});

// ============

$('.open-remove-cover-dialog').on('click', function(event) {
    let container = $(this);
    while(!container.hasClass('suboptions-container')) container = container.parent();
    container.css('display', 'none');
    event.stopPropagation();

    $('.remove-cover-dialog').css('display', 'flex');
    $('.remove-cover-dialog').animate({ opacity: 1 });
});

$('.remove-cover-button').on('click', function() {
    // Remove cover by clearing cover value, mark cover removed as 1 and emptying cover image previewer
    $('#cover').val('');
    $('#cover-removed').val('1');
    $('.cover-image').attr('src', '');
    $('.cover-image').addClass('none');

    // Hide remove cover dialog viewer
    $('.remove-cover-dialog .close-shadowed-view-button').trigger('click');
    // Hide remove dialog opener button because the user remove the cover
    $('.open-remove-cover-dialog').addClass('none');
    // Show revert cover deletion - Only show restore cover if user has already a cover
    if($('.original-cover').val() != '')
        $('.restore-original-cover').removeClass('none');
    // Show add cover hint
    $('.add-cover-notice').removeClass('none');
});

$('.restore-original-cover').on('click', function(event) {
    $('.cover-image').attr('src', $('.original-cover').val());
    $('.cover-image').removeClass('none');
    $('.add-cover-notice').addClass('none');

    $('#cover-removed').val('0');
    $('#cover').val('');
    $(this).addClass('none');
    $('.open-remove-cover-dialog').removeClass('none');
    $('.discard-uploaded-cover').addClass('none');
    $(this).parent().css('display', 'none'); // Hide button parent suboptions-container
    event.stopPropagation();
});

$('.cover-upload-button').on('change', function(event) {
    // validate uploaded cover
    let uploaded_cover = [event.target.files[0]];
    if(validate_image_file_Type(uploaded_cover).length == 1)
        $('.error-container').addClass('none');
    else {
        $('.error-container .error-text').text($('#cover-image-type-error-message').val());
        $('.error-container').removeClass('none');
        return;
    }

    // validating image size and dimensions is done in server side
    $('.cover-image').attr('src', URL.createObjectURL(event.target.files[0]));
    $('.cover-image').removeClass('none');

    $('.add-cover-notice').addClass('none');
    $('.discard-uploaded-cover').removeClass('none');
    $('.open-remove-cover-dialog').addClass('none');
    $('.remove-cover-dialog .close-shadowed-view-button').trigger('click');

    $('body').trigger('click'); // Hide button parent suboptions-container
    event.stopPropagation();
});

$('.discard-uploaded-cover').on('click', function(event) {
    $('#cover').val(''); // Discard upload

    // Discard uploaded cover from image tag
    if($('.original-cover').val() != '') {
        $('.cover-image').attr('src', $('.original-cover').val());
        $('.cover-image').removeClass('none');
        $('.open-remove-cover-dialog').removeClass('none');
    } else {
        $('.cover-image').attr('src', '');
        $('.cover-image').addClass('none');
        $('.add-cover-notice').removeClass('none');
    }

    $(this).parent().css('display', 'none');
    event.stopPropagation();

    $('.discard-uploaded-cover').addClass('none');
    $('.restore-original-cover').addClass('none');
});

$('.delete-account').on('click', function() {
    $('#deactivate-account-container').addClass('none');
    $('#delete-account-container').removeClass('none');
    return false;
});

let save_user_profile_infos_lock = true;
$('#save-user-profile-informations').on('click', function() {
    if(!save_user_profile_infos_lock) return;
    save_user_profile_infos_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    // First validate inputs
    if(!handle_user_settings_input($('#firstname').val() != '', $('#firstname-required-error-message').val())) return;
    if(!handle_user_settings_input($('#lastname').val() != '', $('#lastname-required-error-message').val())) return;
    if(!handle_user_settings_input($('#username').val() != '', $('#username-required-error-message').val())) return;
    if(!handle_user_settings_input($('#about').val() != '', $('#about-required-error-message').val())) return;

    let data = new FormData();
    data.append('_token', csrf);
    data.append('firstname', $('#firstname').val());
    data.append('lastname', $('#lastname').val());
    data.append('username', $('#username').val());
    data.append('about', $('#about').val());
    if($('#avatar').val())
        data.append('avatar', $('#avatar')[0].files[0]);
    if($('#cover').val())
        data.append('cover', $('#cover')[0].files[0]);
    data.append('cover_removed', $('#cover-removed').val());
    data.append('avatar_removed', $('#avatar-removed').val());

    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'post',
        url: '/settings/profile',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: data,
        success: function(response) {
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
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            save_user_profile_infos_lock = true;
        }
    })
    
});

function handle_user_settings_input(condition, errormessage) {
    if(!condition) {
        $('.error-container .error-text').text(errormessage);
        $('.error-container').removeClass('none');
        $(window).scrollTop(0);
        save_user_profile_infos_lock = true;
        return false;
    }

    return true;
}

// ============

let save_user_personal_infos_lock = true;
$('#save-user-personal-informations').on('click', function() {
    if(!save_user_personal_infos_lock) return;
    save_user_personal_infos_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let data = { _token: csrf };
    $('.error-container').addClass('none');

    if($('.birth-input').val()) data.birth = $('.birth-input').val();
    data.country = $("#country_selector").countrySelect("getSelectedCountryData").name;
    if($('.city-input').val()) data.city = $('.city-input').val();
    if($('.phone-input').val()) data.phone = $('.phone-input').val();
    if($('#facebook').val()) data.facebook = $('#facebook').val();
    if($('#instagram').val()) data.instagram = $('#instagram').val();
    if($('#twitter').val()) data.twitter = $('#twitter').val();

    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'patch',
        url: '/settings/personal',
        data: data,
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            
            $('.error-container .error-text').text(error);
            $('.error-container').removeClass('none');

            button.removeClass('disabled-typical-button-style');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            save_user_personal_infos_lock = true;
        }
    })
});

// ====== DEACTIVATE ACCOUNT ======

$('#deactivate-account-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#deactivate-account-confirm-value').val();
	let button = $('#deactivate-account-button');
    
    if(confirmation_input.val() == confirmation_value) {
        if($('#deactivate-password').val() == '') {
            display_top_informer_message($('.password-required-error-message').val(), 'error');
            confirmation_input.val(confirmation_input.val() + ' - x')
            return;
        }
        button.removeClass('disabled-typical-button-style');
    } else {
        button.addClass('disabled-typical-button-style');
    }
});

$('#deactivate-password').on('input', function() {
    let confirmation_input = $('#deactivate-account-confirm-input');
    let confirmation_value = $('#deactivate-account-confirm-value').val();
    let button = $('#deactivate-account-button');

    if($(this).val() == '' && confirmation_input.val() == confirmation_value) {
        confirmation_input.val(confirmation_input.val() + ' - x');
        button.addClass('disabled-typical-button-style');
    }
});

let deactivate_account_lock = true;
$('#deactivate-account-button').on('click', function() {
    if($(this).hasClass('disabled-typical-button-style')) return;
    
    $('#account-deactivation-box .error-container').addClass('none');

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    if(!deactivate_account_lock) return;
    deactivate_account_lock = false;

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.addClass('disabled-typical-button-style');

    $.ajax({
        type: 'patch',
        url: '/settings/account/deactivate',
        data: {
            _token: csrf,
            password: $('#deactivate-password').val()
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            
            $('#account-deactivation-box .error-container .error-text').text(error);
            $('#account-deactivation-box .error-container').removeClass('none');
            $(window).scrollTop(0);

            button.removeClass('disabled-typical-button-style');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            deactivate_account_lock = true;
        }
    })
});

// ====== ACTIVATE ACCOUNT ======

let activate_account_lock = true;
$('#activate-account-button').on('click', function() {
    if(!activate_account_lock) return;
    activate_account_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.addClass('disabled-green-button-style');

    $.ajax({
        type: 'patch',
        url: '/settings/account/activate',
        data: {
            _token: csrf,
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            button.removeClass('disabled-green-button-style');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            activate_account_lock = true;
        }
    })
});

// ====== Warnings and strikes settings ======

let user_warnings_fetch_more_lock = true;
let user_warnings_fetch_more = $('#user-warnings-fetch-more');
let user_warnings_box = $('#user-warnings-box');
user_warnings_box.on('DOMContentLoaded scroll', function() {
    if(user_warnings_box.scrollTop() + user_warnings_box.innerHeight() + 50 >= user_warnings_box[0].scrollHeight) {
        if(!user_warnings_fetch_more_lock) return;
        user_warnings_fetch_more_lock=false;

        let spinner = user_warnings_fetch_more.find('.spinner');
        let skip = user_warnings_box.find('.user-warning-record').length;

        spinner.addClass('inf-rotate');
        $.ajax({
            type: 'post',
            url: `/user/warnings/fetchmore`,
            data: {
                _token: csrf,
                skip: skip
            },
            success: function(response) {
                $(response.payload).insertBefore(user_warnings_fetch_more);
                let unhandled_warnings_components = 
                    user_warnings_box.find(".user-warning-record").slice(response.count*(-1));

                unhandled_warnings_components.each(function() {
                    handle_tooltip($(this));
                    handle_toggling($(this));
                    handle_image_open($(this));
                    handle_ws_resource_simple_render($(this).find('.get-ws-simple-resource-render'));
                });
        
                if(response.hasmore == false) {
                    user_warnings_fetch_more.remove();
                    user_warnings_box.off();
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
                user_warnings_fetch_more_lock = true;
            }
        });
    }
});

let user_strikes_fetch_more_lock = true;
let user_strikes_fetch_more = $('#user-strikes-fetch-more');
let user_strikes_box = $('#user-strikes-box');
user_strikes_box.on('DOMContentLoaded scroll', function() {
    if(user_strikes_box.scrollTop() + user_strikes_box.innerHeight() + 50 >= user_strikes_box[0].scrollHeight) {
        if(!user_strikes_fetch_more_lock) return;
        user_strikes_fetch_more_lock=false;

        let spinner = user_strikes_fetch_more.find('.spinner');
        let skip = user_strikes_box.find('.user-strike-record').length;

        spinner.addClass('inf-rotate');
        $.ajax({
            type: 'post',
            url: `/user/strikes/fetchmore`,
            data: {
                _token: csrf,
                skip: skip
            },
            success: function(response) {
                $(response.payload).insertBefore(user_strikes_fetch_more);
                let unhandled_strikes_components = 
                    user_strikes_box.find(".user-strike-record").slice(response.count*(-1));

                unhandled_strikes_components.each(function() {
                    handle_tooltip($(this));
                    handle_toggling($(this));
                    handle_image_open($(this));
                    handle_ws_resource_simple_render($(this).find('.get-ws-simple-resource-render'));
                });
        
                if(response.hasmore == false) {
                    user_strikes_fetch_more.remove();
                    user_strikes_box.off();
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
                user_strikes_fetch_more_lock = true;
            }
        });
    }
});

// ====== delete account :( ======
$('#delete-account-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#delete-account-confirm-value').val();
	let button = $('#delete-account-button');
    
    if(confirmation_input.val() == confirmation_value) {
        if($('#delete-account-password').val() == '') {
            display_top_informer_message($('.password-required-error-message').val(), 'error');
            confirmation_input.val(confirmation_input.val() + ' - x')
            return;
        }
        button.removeClass('disabled-red-button-style');
    } else
        button.addClass('disabled-red-button-style');
});

$('#delete-account-password').on('input', function() {
    let confirmation_input = $('#delete-account-confirm-input');
    let confirmation_value = $('#delete-account-confirm-value').val();
    let button = $('#delete-account-button');

    if($(this).val() == '' && confirmation_input.val() == confirmation_value) {
        confirmation_input.val(confirmation_value + ' - x');
        button.addClass('disabled-red-button-style');
    }
});

let delete_account_lock = true;
$('#delete-account-button').on('click', function() {
    if($(this).hasClass('disabled-red-button-style')) return;
    
    $('#account-deletion-box .error-container').addClass('none');

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let successmessage = button.find('.success-message').val();

    if(!delete_account_lock) return;
    delete_account_lock = false;

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.addClass('disabled-red-button-style');

    $.ajax({
        type: 'delete',
        url: '/user/delete',
        data: {
            _token: csrf,
            password: $('#delete-account-password').val()
        },
        success: function(response) {
            basic_notification_show(successmessage);
            window.location.href = response;
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            
            $('#account-deletion-box .error-container .error-text').text(error);
            $('#account-deletion-box .error-container').removeClass('none');
            scroll_to_element('delete-account-container', -20);

            button.removeClass('disabled-red-button-style');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            delete_account_lock = true;
        }
    })
});