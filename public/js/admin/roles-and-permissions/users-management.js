$('body').on('click', (event) => $('#rap-members-search-result-box').addClass('none'));
$('#rap-members-search-result-box').on('click', (event) => event.stopPropagation());

let rap_last_member_search_query = '';
let rap_member_search_lock = true;
$('#search-for-member-to-manage-rap').on('click', function(event) {
	event.stopPropagation();

	let resultbox = $('#rap-members-search-result-box');
	let results = resultbox.find('.results-container');
	let loading_block = resultbox.find('.search-loading');
	let no_results_box = resultbox.find('.no-results-found-box')
	let spinner = loading_block.find('.spinner');

	let query = $('#rap-member-search-input').val();

	if(query == '') return;
	if(query == rap_last_member_search_query) {
		if(rap_member_search_lock)
			loading_block.addClass('none');

		resultbox.removeClass('none');
		results.removeClass('none');
		return;
	}

	// Here if the flow reaches here and the lock is false meaning admin should wait until he get results from previous search
	if(!rap_member_search_lock) return;
	rap_member_search_lock = false;

	$('#rap-users-search-fetch-more-results').addClass('none no-fetch');

	results.html('');
	no_results_box.addClass('none'); // Hide no results box if it is displayed before
	spinner.addClass('inf-rotate');
	loading_block.removeClass('none');
	loading_block.removeClass('none'); // Display loading annimation

	resultbox.removeClass('none'); // Display parent

	$.ajax({
		type: 'post',
		url: '/admin/users/rap/search',
		data: {
			_token: csrf,
			k: query
		},
		success: function(response) {
			// Emptying old results
			results.html('');
			resultbox.removeClass('none');

			let users = response.users;
			let hasmore = response.hasmore;

			if(users.length) {
				for(let i = 0; i < users.length; i++) {
					let usercomponent = create_rap_member_search_component(users[i]);
					results.append(usercomponent);
				}

				// After handling all users components we have to check if search has more results
				if(hasmore) {
					let loadmore = $('#rap-users-search-fetch-more-results');
					loadmore.removeClass('none no-fetch')
				} else {
					// no-fetch prevent the scroll event from proceeding when no more results are there
					$('#rap-users-search-fetch-more-results').addClass('none no-fetch');
				}
			} else {
				// Results not founf
				results.addClass('none');
				no_results_box.removeClass('none');
			}
			loading_block.addClass('none');

			results.removeClass('none');
			resultbox.removeClass('none');
			rap_last_member_search_query = query;
			$('#k').val(query); // This is used in fetch more
		},
		error: function(response) {
			spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			display_top_informer_message(error, 'error');
		},
		complete: function() {
			rap_member_search_lock = true;
		}
	})
});

$('#rap-member-search-input').on('keyup', function(event) {
	if(event.key === 'Enter' || event.keyCode === 13) {
		$('#search-for-member-to-manage-rap').trigger('click');
	}
});

function create_rap_member_search_component(user) {
	let usercomponent = $('#rap-members-search-result-box .rap-search-member-factory').clone(true, true);
	usercomponent.removeClass('none rap-search-member-factory');

	let role = user.role;

	usercomponent.attr('href', user.managelink);
	usercomponent.find('.user-avatar').attr('src', user.avatar);
	usercomponent.find('.user-fullname').text(user.fullname);
	usercomponent.find('.user-username').text(user.username);
	usercomponent.find('.user-profilelink').attr('href', user.profilelink);
	
	if(role == null) {
		usercomponent.find('.user-role').text('normal user');
		usercomponent.find('.user-role').removeClass('blue bold');
		usercomponent.find('.user-role').addClass('gray italic');
	} else
		usercomponent.find('.user-role').text(role);

	return usercomponent;
}

let rap_member_search_fetch_more = $('#rap-users-search-fetch-more-results');
let rap_member_search_results_box = $('#rap-members-search-result-box');
let rap_member_search_fetch_more_lock = true;
if(rap_member_search_results_box.length) {
    rap_member_search_results_box.on('DOMContentLoaded scroll', function() {
        if(rap_member_search_results_box.scrollTop() + rap_member_search_results_box.innerHeight() + 50 >= rap_member_search_results_box[0].scrollHeight) {
            if(!rap_member_search_fetch_more_lock || rap_member_search_fetch_more.hasClass('no-fetch')) return;
            rap_member_search_fetch_more_lock=false;
            
			let results = $('#rap-members-search-result-box .results-container');
			let spinner = rap_member_search_fetch_more.find('.spinner');
			// Notice we don't count directly role members from scrollable because it will count factory components as well
            let present_search_members = results.find('.rap-search-member').length;

			spinner.addClass('inf-rotate');
            $.ajax({
				type: 'post',
				url: '/admin/users/rap/search/fetchmore',
				data: {
					_token: csrf,
					skip: present_search_members,
					k: $('#k').val()
				},
                success: function(response) {
					let users = response.users;
					let hasmore = response.hasmore;
		
					console.log(users);
					if(users.length) {
						console.log('here ;)')
						for(let i = 0; i < users.length; i++) {
							let usercomponent = create_rap_member_search_component(users[i]);
							results.append(usercomponent);
						}
		
						// After handling all users components we have to check if search has more results
						if(hasmore)
							rap_member_search_fetch_more.removeClass('none no-fetch');
						else
							// no-fetch prevent the scroll event from proceeding when no more results are there
							rap_member_search_fetch_more.addClass('none no-fetch');
					} else {
						// Results not founf
						results.addClass('none');
						results.find('.no-results-found-box').removeClass('none');
					}
                },
                complete: function() {
                    rap_member_search_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}

// Grant permissions to user
$('.open-attach-permissions-to-user-dialog').on('click', function() {
	$('#attach-permissions-to-user-viewer').removeClass('none');
    disable_page_scroll();
});

let able_to_attach_permissions_to_user = false;
$('#attach-permissions-to-user-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#attach-permissions-to-user-confirm-value').val();
	let button = $('#attach-permissions-to-user-button');
    
	able_to_attach_permissions_to_user = false;
    if(confirmation_input.val() == confirmation_value) {
		let at_least_one_permission_selected = false;
		$('.permission-to-attach-to-user').each(function() {
			if($(this).find('.checkbox-status').val() == 1) {
				at_least_one_permission_selected = true;
				return false;
			}
		});

		if(!at_least_one_permission_selected) {
			display_top_informer_message($('#at-least-one-selected-permission-to-user-attach-message').val(), 'warning');
			disable_attach_permissions_to_user_button();
			return;
		}

		able_to_attach_permissions_to_user = true;
		button.removeClass('disabled-green-button-style');
    } else
		disable_attach_permissions_to_user_button();
});

function disable_attach_permissions_to_user_button() {
	let button = $('#attach-permissions-to-user-button');
	let confirmation_input = $('#attach-permissions-to-user-confirm-input');
    let confirmation_value = $('#attach-permissions-to-user-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_value + ' - x');

	button.addClass('disabled-green-button-style');
	able_to_attach_permissions_to_user = false;
}

let attach_permissions_to_user_lock = true;
$('#attach-permissions-to-user-button').on('click', function() {
	if(!able_to_attach_permissions_to_user || !attach_permissions_to_user_lock) return;
	attach_permissions_to_user_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');
	
	let permissions = [];
	$('.permission-to-attach-to-user').each(function() {
		if($(this).find('.checkbox-status').val() == 1)
			permissions.push($(this).find('.pid').val());	
	});
	
	let data = {
		_token: csrf,
		user: $('#user-id').val(),
		permissions: permissions
	};

	button.addClass('disabled-green-button-style');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/user/permissions/attach',
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

			attach_permissions_to_user_lock = true;
		},
	});
});

// Revoke permissions from user
$('.open-detach-permissions-from-user-dialog').on('click', function() {
	$('#detach-permissions-from-user-viewer').removeClass('none');
    disable_page_scroll();
});

let able_to_detach_permissions_from_user = false;
$('#detach-permissions-from-user-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#detach-permissions-from-user-confirm-value').val();
	let button = $('#detach-permissions-from-user-button');
    
	able_to_detach_permissions_from_user = false;
    if(confirmation_input.val() == confirmation_value) {
		let at_least_one_permission_selected = false;
		$('.permission-to-detach-from-user').each(function() {
			if($(this).find('.checkbox-status').val() == 1) {
				at_least_one_permission_selected = true;
				return false;
			}
		});

		if(!at_least_one_permission_selected) {
			display_top_informer_message($('#at-least-one-selected-permission-to-user-detach-message').val(), 'warning');
			disable_detach_permissions_from_user_button();
			return;
		}

		able_to_detach_permissions_from_user = true;
		button.removeClass('disabled-red-button-style');
    } else
		disable_detach_permissions_from_user_button();
});

function disable_detach_permissions_from_user_button() {
	let button = $('#detach-permissions-from-user-button');
	let confirmation_input = $('#detach-permissions-from-user-confirm-input');
    let confirmation_value = $('#detach-permissions-from-user-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_value + ' - x');

	button.addClass('disabled-red-button-style');
	able_to_detach_permissions_from_user = false;
}

let detach_permissions_from_user_lock = true;
$('#detach-permissions-from-user-button').on('click', function() {
	if(!able_to_detach_permissions_from_user || !detach_permissions_from_user_lock) return;
	detach_permissions_from_user_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');
	
	let permissions = [];
	$('.permission-to-detach-from-user').each(function() {
		if($(this).find('.checkbox-status').val() == 1)
			permissions.push($(this).find('.pid').val());	
	});
	
	let data = {
		_token: csrf,
		user: $('#user-id').val(),
		permissions: permissions
	};

	button.addClass('disabled-red-button-style');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/user/permissions/detach',
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

			detach_permissions_from_user_lock = true;
		},
	});
});

// Grant role to user

$('.open-grant-role-to-user-dialog').on('click', function() {
	$('#grant-role-to-user-viewer').removeClass('none');
    disable_page_scroll();
});

$('.select-role-to-grant-viewer').on('click', function() {
	let button = $(this);
	let viewer = button;
	while(!viewer.hasClass('global-viewer')) {
		viewer = viewer.parent();
	}
	let role = button.find('.role-id').val();
	let user = $('#user-id').val();

	let loadingbox = viewer.find('.loading-box');
	let selectionbox = viewer.find('.role-selection-box');
	let contentbox = viewer.find('.global-viewer-content-box');

	contentbox.html('');
	selectionbox.addClass('none');

	let spinner = loadingbox.find('.spinner');
	loadingbox.find('.role-name').text(button.find('.role-name').val());
	loadingbox.removeClass('none');
	
	spinner.addClass('inf-rotate');
	// Fetching the viewer
	$.ajax({
		type: 'post',
		url: '/admin/user/roles/grant/viewer',
		data: {
			_token: csrf,
			role: role,
			user: user
		},
		success: function(response) {
			contentbox.html(response);
			loadingbox.addClass('none');
			selectionbox.addClass('none');
			contentbox.removeClass('none');

			handle_back_to_role_grant_to_user_button(viewer);
			handle_grant_role_to_user_confirmation();
			handle_grant_role_to_user_button();
		},
		error: function(response) {
			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			display_top_informer_message(error, 'error');

			loadingbox.addClass('none');
			selectionbox.removeClass('none');
		},
		complete: function() {
			spinner.removeClass('inf-rotate');
		}
	})
});

function handle_back_to_role_grant_to_user_button(viewer) {
	$('.back-to-role-grant-to-user-selection').on('click', function() {
		viewer.find('.loading-box').addClass('none');
		viewer.find('.role-selection-box').removeClass('none');
		viewer.find('.global-viewer-content-box').addClass('none');
	});
}

function handle_grant_role_to_user_confirmation() {
	$('#grant-role-to-user-confirm-input').on('input', function() {
		let confirmation_input = $(this);
		let confirmation_value = $('#grant-role-to-user-confirm-value').val();
		let button = $('#grant-role-to-user-button');
		
		if(confirmation_input.val() == confirmation_value)
			button.removeClass('disabled-green-button-style');
		else
			button.addClass('disabled-green-button-style');
	});
}

let grant_role_to_user_lock = true;
function handle_grant_role_to_user_button() {
	$('#grant-role-to-user-button').on('click', function() {
		let input_value = $('#grant-role-to-user-confirm-input').val();
		let confirmation_value = $('#grant-role-to-user-confirm-value').val();

		if(input_value!=confirmation_value || !grant_role_to_user_lock) return;
		grant_role_to_user_lock = false;

		let button = $(this);
		let buttonicon = button.find('.icon-above-spinner');
		let spinner = button.find('.spinner');

		button.addClass('disabled-green-button-style');
		spinner.addClass('inf-rotate');
		buttonicon.addClass('none');
		spinner.removeClass('opacity0');

		$.ajax({
			type: 'post',
			url: '/admin/roles/grant/to/users',
			data: {
				_token: csrf,
				users: [button.find('.uid').val()],
				rid: button.find('.rid').val(),
			},
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

				grant_role_to_user_lock = true;
			},
		});
	});
}

// Revoke role from user (handling logic is defined in user management file)
let last_role_to_revoke_from_user;
let open_revoke_role_from_user_lock = true;
$('.open-revoke-role-from-user-dialog').on('click', function() {
	let viewer = $('#revoke-role-from-user-viewer');
	let contentbox = viewer.find('.global-viewer-content-box');
	let role = $(this).find('.role-id').val();
	let user = $('#user-id').val();
	if(last_role_to_revoke_from_user == role || !open_revoke_role_from_user_lock) {
		viewer.removeClass('none');
    	disable_page_scroll();
		return;
	}

	contentbox.html('');
	viewer.find('.loading-box .spinner').addClass('inf-rotate');
	viewer.find('.loading-box').removeClass('none');
	viewer.removeClass('none');

	$.ajax({
		type: 'get',
		url: `/admin/roles/viewers/revoke?rid=${role}&uid=${user}`,
		success: function(response) {
			contentbox.html(response);
			// The following handlers are called from roles-management file
			handle_role_revoke_confirmation_input();
			handle_role_revoke_button();
			handle_revoke_viewer_cancel_button();
			last_role_to_revoke_from_user = role;
		},
		error: function(response) {
			viewer.find('.close-global-viewer').trigger('click');
			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			display_top_informer_message(error, 'error');
		},
		complete: function() {
			viewer.find('.loading-box').addClass('none');
			viewer.find('.loading-box .spinner').removeClass('inf-rotate');
			open_revoke_role_from_user_lock = true;
		}
	});
});

scrollLeftpanel('roles-and-permissions');