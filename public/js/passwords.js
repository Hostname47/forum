let set_first_password_lock = true;
$('#set-first-password-button').on('click', function() {
	let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

	let password = $('#password').val();
	let password_confirmation = $('#password_confirmation').val();

	$('.error-container').addClass('none');

	if(!check_condition(password !== '' && password_confirmation !== '', $('#password-required-validation-error').val())) return;
	if(!check_condition(/[A-Z]/.test(password), $('#password-uppercase-validation-error').val())) return;
	if(!check_condition(/[a-z]/.test(password), $('#password-lowercase-validation-error').val())) return;
	if(!check_condition(/\d/.test(password), $('#password-numeric-validation-error').val())) return;
	if(!check_condition(password.trim().length >= 8, $('#password-length-validation-error').val())) return;
	if(!check_condition(password === password_confirmation, $('#password-confirmation-validation-error').val())) return;

	if(!set_first_password_lock) return;
	set_first_password_lock = false;

    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'post',
        url: '/settings/password/set',
        data: {
			_token: csrf,
			user_id: userId,
			password: password,
			password_confirmation: password_confirmation
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

let change_password_lock = true;
$('#change-password-button').on('click', function() {
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

	let currentpassword = $('#current-password').val();
	let password = $('#new-password').val();
	let password_confirmation = $('#new-password-confirmation').val();

	$('.error-container').addClass('none');

	if(!check_condition(password !== '' && password_confirmation !== '' && currentpassword !== '', $('#password-required-validation-error').val())) return;
	if(!check_condition(/[A-Z]/.test(password), $('#password-uppercase-validation-error').val())) return;
	if(!check_condition(/[a-z]/.test(password), $('#password-lowercase-validation-error').val())) return;
	if(!check_condition(/\d/.test(password), $('#password-numeric-validation-error').val())) return;
	if(!check_condition(password.trim().length >= 8, $('#password-length-validation-error').val())) return;
	if(!check_condition(password === password_confirmation, $('#password-confirmation-validation-error').val())) return;

	if(!change_password_lock) return;
	change_password_lock = false;

    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'patch',
        url: '/settings/password/update',
        data: {
			_token: csrf,
            currentpassword: currentpassword,
			password: password,
			password_confirmation: password_confirmation
		},
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
            change_password_lock = true;
        }
    })
})

function check_condition(condition, errormessage) {
	if(!condition) {
		$(window).scrollTop(0);
		$('.error-container .error-text').text(errormessage);
		$('.error-container').removeClass('none');
		return false;
	}

	return true;
}
