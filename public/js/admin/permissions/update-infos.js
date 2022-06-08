$('#update-permission-name-input').on('input', function() {
	if($(this).val() == '') disable_update_permission_button();
});
$('#update-permission-slug-input').on('input', function() {
	if($(this).val() == '') disable_update_permission_button();
});
$('#update-permission-description-input').on('input', function() {
	if($(this).val() == '') disable_update_permission_button();
});

let able_to_update_permission = false;
$('#update-permission-confirm-input').on('input', function() {
    let input_value = $(this).val();
    let confirm_value = $('#update-permission-confirm-value').val();
    
    able_to_update_permission = false;
    if(input_value == confirm_value) {
		// Here we'll let uniqueness check to the server to avoid validation overhead (we'll check only for empty)
		if(!update_permission_condition($('#update-permission-name-input').val()!='', $('#permission-name-required').val())) return;
		if(!update_permission_condition($('#update-permission-slug-input').val()!='', $('#permission-slug-required').val())) return;
		if(!update_permission_condition($('#update-permission-description-input').val()!='', $('#permission-description-required').val())) return;
		
		enable_update_permission_button();
    } else
		disable_update_permission_button();
});

function enable_update_permission_button() {
	$('#update-permission-button').removeClass('disabled-green-button-style');
	able_to_update_permission = true;
}

function disable_update_permission_button() {
	// Only append error to confirmation when the values match
	let button = $('#update-permission-button');
	let confirmation_input = $('#update-permission-confirm-input');
	let confirmation_value = $('#update-permission-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_input.val() + ' - x');

	button.addClass('disabled-green-button-style');
	able_to_update_permission = false;
}

function update_permission_condition(condition, message_when_error) {
	if(!condition) {
		able_to_update_permission = false;
		display_top_informer_message(message_when_error, 'warning');
		disable_update_permission_button();
		return false;
	}

	return true;
}

let update_permission_lock = true;
$('#update-permission-button').on('click', function() {
	if(!able_to_update_permission || !update_permission_lock) return;
	update_permission_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');

	let data = {
		_token: csrf,
		pid: $('#permission-id').val(),
		permission: $('#update-permission-name-input').val(),
		slug: $('#update-permission-slug-input').val(),
		description: $('#update-permission-description-input').val(),
	};

	button.addClass('disabled-green-button-style');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'patch',
		url: '/admin/permissions',
		data: data,
		success: function(response) {
			location.reload();
		},
		error: function(response) {
			spinner.addClass('opacity0');
			spinner.removeClass('inf-rotate');
			buttonicon.removeClass('none');
			button.removeClass('disabled-green-button-style');

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			display_top_informer_message(error, 'error');

			update_permission_lock = true;
		}
	});
});