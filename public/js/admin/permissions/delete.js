$('.open-delete-permission-dialog').on('click', function() {
	$('#delete-permission-viewer').removeClass('none');
    disable_page_scroll();
});

let able_to_delete_permission = false;
$('#delete-permission-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#delete-permission-confirm-value').val();
	let button = $('#delete-permission-button');
    
	able_to_delete_permission = false;
    if(confirmation_input.val() == confirmation_value) {
		able_to_delete_permission = true;
		button.removeClass('disabled-red-button-style');
    } else
		button.addClass('disabled-red-button-style');
});

let delete_permission_lock = true;
$('#delete-permission-button').on('click', function() {
	if(!able_to_delete_permission || !delete_permission_lock) return;
	delete_permission_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');

	button.addClass('disabled-red-button-style');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'delete',
		url: '/admin/permission',
		data: {
			_token: csrf,
			permission: $('#permission-id').val()
		},
		success: function(response) {
			window.location.href = response;
		},
		error: function(response) {
			spinner.addClass('opacity0');
			spinner.removeClass('inf-rotate');
			buttonicon.removeClass('none');
			button.removeClass('disabled-red-button-style');

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			display_top_informer_message(error, 'error');

			delete_permission_lock = true;
		},
	});
});