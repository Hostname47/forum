
$('.faq-container').each(function() { handle_faq_discard_edits_button($(this)); });
function handle_faq_discard_edits_button(component) {
	component.find('.discard-faq-update').on('click', function() {
		let content_container = component.find('.faq-content-container');
		let edit_container = component.find('.faq-edit-container');
	
		content_container.removeClass('none');
		edit_container.addClass('none');
		edit_container.find('.error-container').addClass('none');
	
		edit_container.find('.faq-question').val(edit_container.find('.original-faq-question').val());
		edit_container.find('.faq-answer').val(edit_container.find('.original-faq-answer').val());
	});
}

$('.faq-container').each(function() { handle_faq_open_edit_container($(this)); });
function handle_faq_open_edit_container(component) {
	component.find('.open-faq-edit-container').on('click', function() {
		component.find('.faq-content-container').addClass('none');
		component.find('.faq-edit-container').removeClass('none');
	});
}

let update_faq_lock = true;
$('.faq-container').each(function() { handle_faq_update_button($(this)); });
function handle_faq_update_button(component) {
	component.find('.update-faq').on('click', function() {
		let button = $(this);
		let spinner = button.find('.spinner');
		let buttonicon = button.find('.icon-above-spinner');
		let faq_id = button.find('.faq-id').val();
	
		let faq_box = button;
		let faq_edit_box = button
		while(!faq_box.hasClass('faq-container')) {
			if(faq_box.hasClass('faq-edit-container'))
				faq_edit_box = faq_box;
			faq_box = faq_box.parent();
		}
		
		let errorbox = faq_edit_box.find('.error-container');
		errorbox.addClass('none');
	
		let new_question_value = faq_edit_box.find('.faq-question').val();
		let new_answer_value = faq_edit_box.find('.faq-answer').val();
	
		if(new_question_value == '') {
			errorbox.find('.error').text('Question field is required');
			errorbox.removeClass('none');
			return;
		}
	
		if(new_answer_value == '') {
			errorbox.find('.error').text('Answer field is required');
			errorbox.removeClass('none');
			return;
		}
	
		if(!update_faq_lock) return;
		update_faq_lock = false;
	
		spinner.addClass('inf-rotate');
		spinner.removeClass('opacity0');
		buttonicon.addClass('none');
		button.addClass('disabled-typical-button-style');
	
		$.ajax({
			type: 'patch',
			url: '/admin/faqs',
			data: {
				_token: csrf,
				faq_id: faq_id,
				question: faq_edit_box.find('.faq-question').val(),
				answer: faq_edit_box.find('.faq-answer').val(),
			},
			success: function(response) {
				faq_box.find('.faq-content-container').removeClass('none');
				faq_box.find('.faq-edit-container').addClass('none');
	
				faq_box.find('.original-faq-question').val(new_question_value);
				faq_box.find('.question-text').text(new_question_value);
				faq_box.find('.original-faq-answer').val(new_answer_value);
				faq_box.find('.answer-text').text(new_answer_value);
	
				basic_notification_show('faq content has been updated');
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
			complete: function(response) {
				update_faq_lock = true;
	
				spinner.removeClass('inf-rotate');
				spinner.addClass('opacity0');
				buttonicon.removeClass('none');
				button.removeClass('disabled-typical-button-style');
			}
		})
	});
}

$('.faq-container').each(function() { handle_faq_open_delete_container($(this)); });
function handle_faq_open_delete_container(component) {
	component.find('.open-faq-delete-container').on('click', function(event) {
		event.stopPropagation();
		let button = $(this);
		button.parent().css('display', 'none');
	
		let viewer = $('#faq-delete-viewer');
		viewer.find('.faq-id').val(component.find('.faq-id').val());
		viewer.find('.question-text').text(component.find('.question-text').text());
		viewer.find('.answer-text').text(component.find('.answer-text').text());
	
		viewer.removeClass('none');
		disable_page_scroll();
	});
}

let delete_faq_lock = true;
$('#delete-faq-button').on('click', function() {
	if(!delete_faq_lock) return;
	delete_faq_lock = false;

	let viewer = $('#faq-delete-viewer');
	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');
	let faq_id = button.find('.faq-id').val();

	let faqswrapper = $('#faq-'+faq_id+'-box');
	while(!faqswrapper.hasClass('faqs-wrapper')) faqswrapper = faqswrapper.parent();

	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');
	button.addClass('disabled-red-button-style');

	$.ajax({
		type: 'delete',
		url: '/admin/faqs',
		data: {
			_token: csrf,
			faq_id: faq_id,
		},
		success: function() {
			viewer.find('.close-global-viewer').trigger('click');
			let faq = $('#faq-' + faq_id + '-box');
			faq.animate({
				opacity: '0'
			}, 800, function() {
				faq.remove();
				
				faqswrapper.find('.faqs-count').text(parseInt(faqswrapper.find('.faqs-count').text()) - 1);
			});
			
			basic_notification_show('faq has been deleted successfully');
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
			delete_faq_lock = true;
			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');
			button.removeClass('disabled-red-button-style');
		}
	});
});

// change-faq-state
let update_faq_state_lock = true;
$('.faq-container').each(function() { handle_faq_change_state_button($(this)); });
function handle_faq_change_state_button(component) {
	component.find('.change-faq-state').on('click', function() {
		if(!update_faq_state_lock) return;
		update_faq_state_lock = false;

		let button = $(this);
		let spinner = button.find('.spinner');
		let buttonicon = button.find('.icon-above-spinner');
		let faq_id = component.find('.faq-id').val();

		spinner.addClass('inf-rotate');
		spinner.removeClass('opacity0');
		buttonicon.addClass('none');
	
		$.ajax({
			type: 'patch',
			url: '/admin/faqs',
			data: {
				_token: csrf,
				faq_id: faq_id,
				live: button.find('.state').val()
			},
			success: function(response) {
				basic_notification_show('faq status has been changed');
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

				update_faq_state_lock = true;
	
				spinner.removeClass('inf-rotate');
				spinner.addClass('opacity0');
				buttonicon.removeClass('none');
			},
		})
	});
}

// Handle ordering faqs components priority

$('#sort-faqs-components-by-priority').on('click', function() {
	// First check if admin enter an invalide priority value by mistake (character or empty string)
	let invalid_priority = false;
	$('#live-faqs-container .faq-container .faq-priority').each(function() {
		if(!parseInt($(this).val())) {
			invalid_priority = true;
			return false;
		}
	});

	if(invalid_priority) {
		display_top_informer_message('A priority value of one of live faqs is invalid. (priority should be a number)');
		return;
	}

	// Reorder options after votes based on number of votes (using bubble sort)
	let faqs = $('#live-faqs-container .faq-container');
	let count = faqs.length;
	let i, j;
	for (i = 0; i < count-1; i++) {
		faqs = $('#live-faqs-container .faq-container');
		// (count-i-1) because last i elements will be in the right place
		for (j = 0; j < count-i-1; j++) {
			let faqa = $(faqs[j]);
			let faqb = $(faqs[j+1]);
			let va = parseInt(faqa.find('.faq-priority').val());
			let vb = parseInt(faqb.find('.faq-priority').val());

			if(va > vb) {
				faqa.insertAfter(faqb);
				faqs = $('#live-faqs-container .faq-container');
			}
		}
	}
});

let update_faqs_priorities_lock = true;
$('#update-faqs-priorities').on('click', function() {
	let invalid_priority = false;
	$('#live-faqs-container .faq-container .faq-priority').each(function() {
		if(!parseInt($(this).val())) {
			invalid_priority = true;
			return false;
		}
	});

	if(invalid_priority) {
		display_top_informer_message('A priority value of one of live faqs is invalid. (priority should be a number)');
		return;
	}

	if(!update_faqs_priorities_lock) return;
	update_faqs_priorities_lock = false;

	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

	let faqs_ids=[];
	let faqs_priorities=[];
	$('#live-faqs-container .faq-container').each(function() {
		faqs_ids.push($(this).find('.faq-id').val());
		faqs_priorities.push($(this).find('.faq-priority').val());
	});

	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');
	button.addClass('disabled-typical-button-style');

	$.ajax({
		type: 'patch',
		url: '/admin/faqs/priorities',
		data: {
			_token: csrf,
			faqs_ids: faqs_ids,
			faqs_priorities, faqs_priorities
		},
		success: function() {
			location.reload();
		},
		error: function(response) {
			update_faqs_priorities_lock = true;

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			display_top_informer_message(error, 'error');

			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');
			button.removeClass('disabled-typical-button-style');
		}
	})
});

let unverified_faqs_fetch_more_lock = true;
let unverified_faqs_fetch_more = $('#unverified-faqs-fetch-more');
let unverified_faqs_box = $('#unverified-faqs-container');
if(unverified_faqs_fetch_more.length && unverified_faqs_box) {
	/**
	 * If unverified container exists and fetch more component exists as well then we handle scroll event
	 */
	unverified_faqs_box.on('DOMContentLoaded scroll', function() {
		if(unverified_faqs_box.scrollTop() + unverified_faqs_box.innerHeight() + 50 >= unverified_faqs_box[0].scrollHeight) {
			if(!unverified_faqs_fetch_more_lock) return;
			unverified_faqs_fetch_more_lock=false;

			let spinner = unverified_faqs_fetch_more.find('.spinner');
			let skip = $('#unverified-faqs-container .faq-container').length;

			spinner.addClass('inf-rotate');
			$.ajax({
				url: `/admin/faqs/fetch-more`,
				data: {
					skip: skip,
					take: 8,
					type: 'unverified'
				},
				success: function(response) {
					// Append faqs components
					$(response.payload).insertBefore(unverified_faqs_fetch_more);
					// If no more components left, we remove fetch more component and disable scroll event
					if(response.hasmore == false) {
						unverified_faqs_fetch_more.remove();
						unverified_faqs_box.off();
					}
					// Handle appended faqs events
					let unhandled_faqs = 
						unverified_faqs_box.find(".faq-container").slice(response.count*(-1));

					unhandled_faqs.each(function() {
						handle_toggling($(this));
						handle_component_subcontainers($(this));
						
						handle_faq_open_edit_container($(this));
						handle_faq_open_delete_container($(this));
						handle_faq_update_button($(this));
						handle_faq_discard_edits_button($(this));
						handle_faq_change_state_button($(this));
					});
				},
				complete: function() {
					unverified_faqs_fetch_more_lock = true;
				},
				error: function(response) {
					/**
					 * Once an error occured we have to stop the event altogether and display the error
					 */
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