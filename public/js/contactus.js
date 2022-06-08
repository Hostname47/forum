
let send_message_lock = true;
$('.contact-send-message').on('click', function() {
    let errorbox = $('#contact-us-error-container');
    let errors_messages = $('#validation-messages');

    let firstname = $('#firstname');
    let lastname = $('#lastname');
    let email = $('#contact-email');
    let company = $('#company');
    let phone = $('#phone');
    let message = $('#message');

    let data = { _token: csrf };

    if(firstname.val().trim() == '') {
        firstname.parent().find('.err').removeClass('none');
        errorbox.removeClass('none');
        errorbox.find('.error').text(errors_messages.find('.firstname-required').val());
        scroll_to_element('contact-us-error-container', -60);
        return;
    } else {
        firstname.parent().find('.err').addClass('none');
        data.firstname = firstname.val().trim();
    }

    if(lastname.val().trim() == '') {
        lastname.parent().find('.err').removeClass('none');
        errorbox.removeClass('none');
        errorbox.find('.error').text(errors_messages.find('.lastname-required').val());
        scroll_to_element('contact-us-error-container', -60);
        return;
    } else {
        lastname.parent().find('.err').addClass('none');
        data.lastname = lastname.val().trim();
    }

    if(email.val().trim() == '') {
        email.parent().find('.err').removeClass('none');
        errorbox.removeClass('none');
        errorbox.find('.error').text(errors_messages.find('.email-required').val());
        scroll_to_element('contact-us-error-container', -60);
        return;
    } else if(!validateEmail(email.val().trim())) {
        email.parent().find('.err').removeClass('none');
        errorbox.removeClass('none');
        errorbox.find('.error').text(errors_messages.find('.email-invalide').val());
        scroll_to_element('contact-us-error-container', -60);
        return;
    } else {
        email.parent().find('.err').addClass('none');
        data.email = email.val().trim();
    }

    if(company.val().trim() != "") {
        data.company = company.val().trim();
    }

    if(phone.val().trim() != "") {
        data.phone = phone.val().trim();
    }
    
    if(message.val().trim() == '') {
        message.parent().parent().find('.err').removeClass('none');
        errorbox.removeClass('none');
        errorbox.find('.error').text(errors_messages.find('.message-required').val());
        scroll_to_element('contact-us-error-container', -60);
        return;
    }else if(message.val().trim().length < 10) {
        message.parent().parent().find('.err').removeClass('none');
        errorbox.removeClass('none');
        errorbox.find('.error').text(errors_messages.find('.message-length-error').val());
        scroll_to_element('contact-us-error-container', -60);
        return;
    } else {
        message.parent().parent().find('.err').addClass('none');
        data.message = message.val();
    }

    errorbox.addClass('none');

	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

	button.addClass('disabled-typical-button-style');
	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');

    if(!send_message_lock) return;
    send_message_lock = false;

    $.ajax({
        url: '/contact',
        type: 'post',
        data: data,
        success: function() {
            location.reload();
        },
        error: function(response) {
            button.removeClass('disabled-typical-button-style');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');

            let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}

			$('#contact-us-error-container .error').text(error);
			$('#contact-us-error-container').removeClass('none');

            send_message_lock = true;
        }
    })
});