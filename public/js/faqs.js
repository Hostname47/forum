//$('.qa-wrapper').on('click', function(event) {
$('.question-header').on('click', function(event) {
    let qa_wrapper = $(this);
    while(!qa_wrapper.hasClass('qa-wrapper')) {
      qa_wrapper = qa_wrapper.parent();
    }

    let toggled_arrow = qa_wrapper.find('.faq-toggled-arrow');
    let answer = qa_wrapper.find('.faq-answer');
    let display = answer.css('display');
    
    if(display == 'none') {
      $('.faq-toggled-arrow').rotate(0);
      toggled_arrow.rotate(180);
      $('.faq-answer').addClass('none');
      answer.removeClass('none');
    } else {
      toggled_arrow.rotate(0);
      answer.addClass('none');
    }
});

let send_faq_lock = true;
$('.faq-question-send').on('click', function() {
	let question = $("#question");
	let desc = $("#desc");
	let data = {
		_token: csrf
	};

	$('.faqs-error-container').addClass('none');

	if(question.val().trim() == '') {
		question.parent().find('.error').removeClass('none');
		question.parent().find('.error').text(question.parent().find('.question-required').val());
		question.css('border-color', '#ec4444');
		return;
	} else {
		question.parent().find('.error').addClass('none');
		data.question = question.val().trim();
	}

	if(question.val().trim().length < 10) {
		question.parent().find('.error').removeClass('none');
		question.parent().find('.error').text(question.parent().find('.question-length-error').val());
		question.css('border-color', '#ec4444');
		return;
	} else {
		question.parent().find('.error').addClass('none');
		data.question = question.val().trim();
	}

	if(desc.val().trim() != '')
		data.desc = desc.val();

	if(!send_faq_lock) return;
	send_faq_lock = false;

	// disable inputs
	question.attr('disabled', true);
	desc.attr('disabled', true);

	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

	button.addClass('disabled-typical-button-style');
	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');

	$.ajax({
		url: '/faqs',
		type: 'post',
		data: data,
		success: function(response) {
			location.reload();
		},
		error: function(response) {
			button.removeClass('disabled-typical-button-style');
			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');

			question.attr('disabled', false);
			desc.attr('disabled', false);

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}

			$('.faqs-error').text(error);
			$('.faqs-error-container').removeClass('none');

			send_faq_lock = true;
		}
	});
});

$('#question').on('click change', function() {
    $(this).attr('style', '');
})
