$('.open-revoke-permission-from-users-dialog').on('click', function() {
	$('#detach-permission-from-users-viewer').removeClass('none');
    disable_page_scroll();
});

let able_to_revoke_permission_from_users = false;
$('#detach-permission-from-users-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#detach-permission-from-users-confirm-value').val();
	let detachbutton = $('#detach-permission-from-users-button');
    
    able_to_revoke_permission_from_users = false;
    if(confirmation_input.val() == confirmation_value) {
		// Check if at least one member selected
		let at_least_one_user_selected = false;
		$('.user-to-detach-permission-from-select').each(function() {
			if($(this).find('.checkbox-status').val() == 1) {
				at_least_one_user_selected = true;
				return false;
			}
		});
		if(!at_least_one_user_selected) {
			display_top_informer_message($('#at-least-one-selected-user-to-detach-permission-from-message').val(), 'warning');
			disable_revoke_permission_from_users_button();

			return;
		} else {
			detachbutton.removeClass('disabled-red-button-style');
			able_to_revoke_permission_from_users = true;
		}
    } else {
		disable_revoke_permission_from_users_button();
    }
});

function disable_revoke_permission_from_users_button() {
	let confirmation_input = $('#detach-permission-from-users-confirm-input');
	let confirmation_value = $('#detach-permission-from-users-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_input.val() + ' - x');

	let button = $('#detach-permission-from-users-button');
	button.addClass('disabled-red-button-style');
	able_to_revoke_permission_from_users = false;
}

$('.user-to-detach-permission-from-select').on('click', function() {
	if($(this).find('.checkbox-status').val() == 0) {
		let at_least_one_select = false;
		$('.user-to-detach-permission-from-select').each(function() {
			if($(this).find('.checkbox-status').val() == 1) {
				at_least_one_select = true;
				return false;
			}
		});

		if(!at_least_one_select) disable_revoke_permission_from_users_button();
	}
});

let revoke_permission_from_users_lock = true;
$('#detach-permission-from-users-button').on('click', function() {
	if(!revoke_permission_from_users_lock || !able_to_revoke_permission_from_users) return;
	revoke_permission_from_users_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');

	let selected_members = [];
	$('.user-to-detach-permission-from-select').each(function() {
		if($(this).find('.checkbox-status').val() == 1)
			selected_members.push($(this).find('.uid').val());
	});

	let data = {
		_token: csrf,
		pid: $('#permission-id').val(),
		users: selected_members,
	};

	button.addClass('disabled-red-button-style');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/permissions/revoke/from/users',
		data: data,
		success: function(response) {
			location.reload();
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

			revoke_permission_from_users_lock = true;
		},
	});
});
