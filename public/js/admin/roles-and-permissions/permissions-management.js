$('.open-create-permission-dialog').on('click', function() {
	let viewer = $('#create-permission-viewer');
	let viewerbox = viewer.find('.global-viewer-content-box');
	viewerbox.css('margin-top', '30px');
	viewerbox.animate({
		'margin-top': '0'
	}, 200);

	if($(this).find('.scope').length) { // if admin click on + new button on specific scope we set scope in viewer explicitely
		let scopeval = $(this).find('.scope').val();
		let scope = $('#create-permission-scope-input');
		scope.find('option[value="' + scopeval + '"]').attr('selected','selected');

		scope.css({
			outline: '4px solid rgba(33, 192, 255, 0.19)',
			border: '1px solid rgb(111, 205, 242)'
		});
	}
	viewer.removeClass('none');
    disable_page_scroll();
});

function disable_create_permission_button() {
	// We only append error to input (to disable button) if the confirmation input already match the confirmation value
	let confirmation_input = $('#create-permission-confirm-input');
	let confirmation_value = $('#create-permission-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_input.val() + ' - x');

	// $('#create-permission-viewer .viewer-scrollable-box').animate({ scrollTop: 0 }, "fast");
	$('#create-permission-button').addClass('disabled-green-button-style');
	
	able_to_create_permission = false;
}

function enable_create_permission_button() {
	$('.create-permission-error-container').addClass('none');
	$('#create-permission-button').removeClass('disabled-green-button-style');
	able_to_create_permission = true;
}

function create_permission_condition(condition, message_when_error) {
	if(!condition) {
		able_to_create_permission = false;
		$('#create-permission-viewer .viewer-scrollable-box').animate({ scrollTop: 0 }, "fast");
		$('.create-permission-error').text(message_when_error);
		$('.create-permission-error-container').removeClass('none');
		$('#create-permission-confirm-input').val($('#create-permission-confirm-input').val() + ' - x');
		return false;
	}

	return true;
}

let unique_permission_name = false;
let unique_permission_slug = false;
let able_to_create_permission = false;
$('#create-permission-name-input').on('input', function() {
	let input = $(this);
	let existing_names = $('#existing-permissions-names').val().split(',');
	unique_permission_name = true;

	if($.inArray(input.val(), existing_names) > -1) { // If the permission name already exists
		input.css({
			'border-color': 'rgb(228, 48, 48)',
			'outline-color': 'rgba(255, 133, 133, 0.29)'
		});
		$('.create-permission-error').text($('#permission-name-already-exists').val());
		$('.create-permission-error-container').removeClass('none');
		$('#create-permission-viewer .viewer-scrollable-box').animate({ scrollTop: 0 }, "fast");
		disable_create_permission_button();

		unique_permission_name = false;
	} else {
		input.css({
			'border-color': '',
			'outline-color': ''
		});
		$('.create-permission-error-container').addClass('none');
	}

	if(input.val() == '') {
		disable_create_permission_button();
	}
});

$('#create-permission-slug-input').on('input', function() {
	let input = $(this);
	let existing_slugs = $('#existing-permissions-slugs').val().split(',');
	unique_permission_slug = true;

	if($.inArray(input.val(), existing_slugs) > -1) { // If the permission slug already exists
		input.css({
			'border-color': 'rgb(228, 48, 48)',
			'outline-color': 'rgba(255, 133, 133, 0.29)'
		});
		$('.create-permission-error').text($('#permission-slug-already-exists').val());
		$('.create-permission-error-container').removeClass('none');
		$('#create-permission-viewer .viewer-scrollable-box').animate({ scrollTop: 0 }, "fast");
		disable_create_permission_button();

		unique_permission_slug = false;
	} else {
		input.css({
			'border-color': '',
			'outline-color': ''
		});
		$('.create-permission-error-container').addClass('none');
	}

	if(input.val() == '') {
		disable_create_permission_button();
	}
});

$('#create-permission-description-input').on('input', function() {
	if($(this).val() == '') {
		disable_create_permission_button();
	}
})

$('#create-permission-confirm-input').on('input', function() {
    let input_value = $(this).val();
    let confirm_value = $('#create-permission-confirm-value').val();
    
    able_to_create_permission = false;
    if(input_value == confirm_value) {
		// Here before open create permission button we have to validate the inputs
		if(!create_permission_condition(
			$('#create-permission-name-input').val() != '', 
			$('#permission-name-required').val())) return;
		if(!create_permission_condition(
			$('#create-permission-slug-input').val()!='', 
			$('#permission-slug-required').val())) return;
		if(!create_permission_condition(
			$('#create-permission-description-input').val() != '', 
			$('#permission-description-required').val())) return;
		if(!create_permission_condition(
			unique_permission_name, 
			$('#permission-name-already-exists').val())) return;
		if(!create_permission_condition(
			unique_permission_slug, 
			$('#permission-slug-already-exists').val())) return;

		// Handle scope
		if($('#create-permission-scope-type').val() == 'new') {
			if(!create_permission_condition(
				$('#create-permission-new-scope-input').val()!='', 
				$('#permission-scope-required').val())) return;
		}

		enable_create_permission_button();
    } else {
        disable_create_permission_button();
    }
});

$('.create-permission-scope-switch').on('change', function() {
	if($(this).val()) {
		// disable new scope input and enable existing scopes
		$('#create-permission-scope-type').val('select');
		$('#create-permission-scope-input').prop('disabled', false);
		$('#create-permission-new-scope-input').prop('disabled', true);
	};
});

$('.create-permission-new-scope-switch').on('change', function() {
	if($(this).val()) {
		// enable new scope input and disable existing scopes
		$('#create-permission-scope-type').val('new');
		$('#create-permission-scope-input').prop('disabled', true);
		$('#create-permission-new-scope-input').prop('disabled', false);

		if($('#create-permission-new-scope-input').val() == '') {
			let confirmation_input = $('#create-permission-confirm-input');
			let confirmation_value = $('#create-permission-confirm-value').val();
			if(confirmation_input.val() == confirmation_value) {
				disable_create_permission_button();
			}
		}
	};
});

$('#create-permission-new-scope-input').on('input', function() {
	let input = $(this);
	let existing_scopes = $('#existing-permissions-scopes').val().split(',');

	if($.inArray(input.val(), existing_scopes) > -1) { // If scope already exists, we show already exists message
		$('#scope-already-exists').removeClass('none');
	} else {
		$('#scope-already-exists').addClass('none');
	}

	if(input.val() == '') {
		disable_create_permission_button();
	}
})

let create_permission_lock = true;
$('#create-permission-button').on('click', function() {
	if(!able_to_create_permission || !create_permission_lock) return;
	create_permission_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');

	let data = {
		_token: csrf,
		permission: $('#create-permission-name-input').val(),
		slug: $('#create-permission-slug-input').val(),
		description: $('#create-permission-description-input').val(),
	};

	if($('#create-permission-scope-type').val() == 'select')
		data.scope = $('#create-permission-scope-input').val();
	else
		data.scope = $('#create-permission-new-scope-input').val();

	// If the parser reach here, it means all inputs pass validation phase
	$('.err').addClass('none');
	$('#forum-settings-error').text('');
	$('#forum-settings-error-container').addClass('none');

	button.attr('style', 'background-color: #84bb91; cursor: default;')
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/permissions',
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
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			display_top_informer_message(error, 'error');

			create_permission_lock = true;
		},
		complete: function(response) {
			
		}
	});
});

let last_permission_reviewed = null;
let open_permission_review_lock = true;
$('.open-permission-review-dialog').on('click', function() {
	let viewer = $('#permission-review-viewer');
	let button = $(this);
	let pid = button.find('.permission-id').val();

	if(pid != last_permission_reviewed) {
		if(!open_permission_review_lock) return;
		open_permission_review_lock = false;

		let spinner = viewer.find('.loading-viewer-spinner');
		spinner.removeClass('opacity0');
		spinner.addClass('inf-rotate');
		viewer.find('.global-viewer-content-box').html('');

		$.ajax({
			type: 'get',
			url: `/admin/permissions/viewers/review?pid=${pid}`,
			success: function(response) {
				viewer.find('.global-viewer-content-box').html(response);
				last_permission_reviewed = pid;
			},
			complete: function() {
				spinner.addClass('opacity0');
				spinner.removeClass('inf-rotate');
				open_permission_review_lock = true;
			}
		});
	}

	disable_page_scroll();
	viewer.removeClass('none');
});

$('.select-permissions-scope').on('click', function(event) {
	event.stopPropagation();
	let scope = $(this).find('.scope-slug').val();
	let scopename = $(this).find('.scope-name').text();

	$('#selected-scope-name').text(scopename);

	if(scope == 'all') {
		$('.permissions-scope-box').removeClass('none');
	} else {
		$('.permissions-scope-box').addClass('none');
		$('.permissions-scope-box').each(function() {
			if($(this).find('.scope').val() == scope) {
				$(this).removeClass('none');
				return false;
			}
		});
	}

	$('body').trigger('click');
});

if(urlprms.has('open-viewer')) {
	if(urlprms.get('open-viewer') == 'create-permission')
		$('.open-create-permission-dialog').first().trigger('click');
}

scrollLeftpanel('roles-and-permissions');

$('.load-remaining-permissions').on('click', function() {
	let button = $(this);
	let remaining_permission_box = button.parent().find('.remaining-permissions-container');
	if(remaining_permission_box.hasClass('none')) {
		remaining_permission_box.removeClass('none');
		button.find('.arrow').css({
			transform:'rotate(-180deg)',
			'-ms-transform':'rotate(-180deg)',
			'-moz-transform':'rotate(-180deg)',
			'-webkit-transform':'rotate(-180deg)',
			'-o-transform':'rotate(-180deg)'
		});
	} else {
		remaining_permission_box.addClass('none');
		button.find('.arrow').css({
			transform:'rotate(0deg)',
			'-ms-transform':'rotate(0deg)',
			'-moz-transform':'rotate(0deg)',
			'-webkit-transform':'rotate(0deg)',
			'-o-transform':'rotate(0deg)'
		});
	}
});