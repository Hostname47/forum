$('.open-create-role-dialog').on('click', function() {
	let viewerbox = $('#create-role-viewer').find('.global-viewer-content-box');
	viewerbox.css('margin-top', '30px');
	viewerbox.animate({
		'margin-top': '0'
	}, 200);
	$('#create-role-viewer').removeClass('none');
    disable_page_scroll();
});

let unique_role_name = false;
let unique_role_slug = false;
$('#create-role-name-input').on('input', function() {
	let input = $(this);
	let existing_names = $('#existing-roles-names').val().split(',');
	unique_role_name = true;

	if($.inArray(input.val(), existing_names) > -1) { // If the role name already exists
		input.css({
			'border-color': 'rgb(228, 48, 48)',
			'outline-color': 'rgba(255, 133, 133, 0.29)'
		});
		$('.create-role-error').text($('#role-name-already-exists').val());
		$('.create-role-error-container').removeClass('none');
		$('#create-role-viewer .viewer-scrollable-box').animate({ scrollTop: 0 }, "fast");
		disable_create_role_button();

		unique_role_name = false;
	} else {
		input.css({
			'border-color': '',
			'outline-color': ''
		});
		$('.create-role-error-container').addClass('none');
	}

	if(input.val() == '') {
		disable_create_role_button();
	}
});

$('#create-role-slug-input').on('input', function() {
	let input = $(this);
	let existing_slugs = $('#existing-roles-slugs').val().split(',');
	unique_role_slug = true;

	if($.inArray(input.val(), existing_slugs) > -1) { // If the role name already exists
		input.css({
			'border-color': 'rgb(228, 48, 48)',
			'outline-color': 'rgba(255, 133, 133, 0.29)'
		});
		$('.create-role-error').text($('#role-slug-already-exists').val());
		$('.create-role-error-container').removeClass('none');
		$('#create-role-viewer .viewer-scrollable-box').animate({ scrollTop: 0 }, "fast");
		disable_create_role_button();

		unique_role_slug = false;
	} else {
		input.css({
			'border-color': '',
			'outline-color': ''
		});
		$('.create-role-error-container').addClass('none');
	}

	if(input.val() == '') {
		disable_create_role_button();
	}
});

$('#create-role-description-input').on('input', function() {
	if($(this).val() == '') {
		disable_create_role_button();
	}
})

let able_to_create_role = false;
$('#create-role-confirm-input').on('input', function() {
    let input_value = $(this).val();
    let confirm_value = $('#create-role-confirm-value').val();
    
    able_to_create_role = false;
    if(input_value == confirm_value) {
		// Here before open create role button we have to validate the inputs
		if(!create_role_condition(
			$('#create-role-name-input').val() != '', 
			$('#role-name-required').val())) return;
		if(!create_role_condition(
			$('#create-role-slug-input').val()!='', 
			$('#role-slug-required').val())) return;
		if(!create_role_condition(
			$('#create-role-description-input').val() != '', 
			$('#role-description-required').val())) return;
		if(!create_role_condition(
			unique_role_name, 
			$('#role-name-already-exists').val())) return;
		if(!create_role_condition(
			unique_role_slug, 
			$('#role-slug-already-exists').val())) return;

		enable_create_role_button();
    } else {
        disable_create_role_button();
    }
});

function create_role_condition(condition, message_when_error) {
	if(!condition) {
		able_to_create_role = false;
		$('#create-role-viewer .viewer-scrollable-box').animate({ scrollTop: 0 }, "fast");
		$('.create-role-error').text(message_when_error);
		$('.create-role-error-container').removeClass('none');
		$('#create-role-confirm-input').val($('#create-role-confirm-input').val() + ' - x');
		return false;
	}

	return true;
}

function disable_create_role_button() {
	// Only append error to confirmation when the values match
	let confirmation_input = $('#create-role-confirm-input');
	let confirmation_value = $('#create-role-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_input.val() + ' - x');

	$('#create-role-button').addClass('disabled-green-button-style');
	able_to_create_role = false;
}

function enable_create_role_button() {
	$('#create-role-button').removeClass('disabled-green-button-style');
	able_to_create_role = true;
}

let create_role_lock = true;
$('#create-role-button').on('click', function() {
	if(!able_to_create_role || !create_role_lock) return;
	create_role_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');

	let data = {
		_token: csrf,
		role: $('#create-role-name-input').val(),
		slug: $('#create-role-slug-input').val(),
		description: $('#create-role-description-input').val(),
	};

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
		url: '/admin/roles',
		data: data,
		success: function(response) {
			window.location.href = response;
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

			create_role_lock = true;
		},
		complete: function(response) {
			
		}
	});
});

let last_role_reviewed = null;
let open_role_review_lock = true;
$('.open-role-review-dialog').on('click', function() {
	let viewer = $('#role-review-viewer');
	let button = $(this);
	let rid = button.find('.role-id').val();

	if(rid != last_role_reviewed) {
		if(!open_role_review_lock) return;
		open_role_review_lock = false;

		let spinner = viewer.find('.loading-viewer-spinner');
		spinner.removeClass('opacity0');
		spinner.addClass('inf-rotate');
		viewer.find('.global-viewer-content-box').html('');

		$.ajax({
			type: 'get',
			url: `/admin/roles/viewers/review?rid=${rid}`,
			success: function(response) {
				viewer.find('.global-viewer-content-box').html(response);
				last_role_reviewed = rid;
			},
			complete: function() {
				spinner.addClass('opacity0');
				spinner.removeClass('inf-rotate');
				open_role_review_lock = true;
			}
		});
	}

	disable_page_scroll();
	viewer.removeClass('none');
});

// ========= Manage role =========

// Edit role informations

$('#update-role-name-input').on('input', function() {
	if($(this).val() == '') disable_update_role_button();
});
$('#update-role-slug-input').on('input', function() {
	if($(this).val() == '') disable_update_role_button();
});
$('#update-role-description-input').on('input', function() {
	if($(this).val() == '') disable_update_role_button();
});

let able_to_update_role = false;
$('#update-role-confirm-input').on('input', function() {
    let input_value = $(this).val();
    let confirm_value = $('#update-role-confirm-value').val();
    
    able_to_update_role = false;
    if(input_value == confirm_value) {
		// Here we'll let uniqueness check to the server to avoid validation overhead (we'll check only for empty)
		if(!update_role_condition($('#update-role-name-input').val()!='', $('#role-name-required').val())) return;
		if(!update_role_condition($('#update-role-slug-input').val()!='', $('#role-slug-required').val())) return;
		if(!update_role_condition($('#update-role-description-input').val()!='', $('#role-description-required').val())) return;
		
		enable_update_role_button();
    } else
		disable_update_role_button();
});

function enable_update_role_button() {
	$('#update-role-button').removeClass('disabled-green-button-style');
	able_to_update_role = true;
}

function disable_update_role_button() {
	// Only append error to confirmation when the values match
	let button = $('#update-role-button');
	let confirmation_input = $('#update-role-confirm-input');
	let confirmation_value = $('#update-role-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_input.val() + ' - x');

	button.addClass('disabled-green-button-style');
	able_to_update_role = false;
}

function update_role_condition(condition, message_when_error) {
	if(!condition) {
		able_to_update_role = false;
		display_top_informer_message(message_when_error, 'warning');
		disable_update_role_button();
		return false;
	}

	return true;
}

let update_role_lock = true;
$('#update-role-button').on('click', function() {
	if(!able_to_update_role || !update_role_lock) return;
	update_role_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');

	let data = {
		_token: csrf,
		rid: $('#role-id').val(),
		role: $('#update-role-name-input').val(),
		slug: $('#update-role-slug-input').val(),
		description: $('#update-role-description-input').val(),
	};

	button.attr('style', 'background-color: #84bb91; cursor: default;')
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'patch',
		url: '/admin/roles',
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

			update_role_lock = true;
		},
		complete: function(response) {
			
		}
	});
});

// Grant role

$('body').on('click', (event) => $('#role-members-search-result-box').addClass('none'));
$('#role-members-search-result-box').on('click', (event) => event.stopPropagation());

$('.open-role-grant-dialog').on('click', function() {
	$('#grant-role-to-users-viewer').removeClass('none');
    disable_page_scroll();
});

let role_last_member_search_query = '';
let role_member_search_lock = true;
$('#role-search-for-member-to-grant').on('click', function(event) {
	event.stopPropagation();

	let resultbox = $('#role-members-search-result-box');
	let results = resultbox.find('.results-container');
	let loading_block = resultbox.find('.search-loading');
	let no_results_box = resultbox.find('.no-results-found-box')
	let spinner = loading_block.find('.spinner');

	let query = $('#role-member-search-input').val();
	let rid = $('#role-id').val();

	if(query == '') return;
	if(query == role_last_member_search_query) {
		if(role_member_search_lock)
			loading_block.addClass('none');

		resultbox.removeClass('none');
		results.removeClass('none');
		return;
	}

	// Here if the flow reaches here and the lock is false meaning admin should wait until he get results from previous search
	if(!role_member_search_lock) return;
	role_member_search_lock = false;

	$('#role-users-fetch-more-results').addClass('none no-fetch');

	results.html('');
	no_results_box.addClass('none'); // Hide no results box if it is displayed before
	spinner.addClass('inf-rotate');
	loading_block.removeClass('none');
	loading_block.removeClass('none'); // Display loading annimation

	resultbox.removeClass('none'); // Display parent

	$.ajax({
		type: 'post',
		url: '/admin/roles/users/search',
		data: {
			_token: csrf,
			rid: rid,
			k: $('#role-member-search-input').val()
		},
		success: function(response) {
			// Emptying old results
			results.html('');
			resultbox.removeClass('none');

			let users = response.users;
			let hasmore = response.hasmore;

			if(users.length) {
				for(let i = 0; i < users.length; i++) {
					let usercomponent = create_role_member_search_component(users[i]);
					results.append(usercomponent);
				}

				// After handling all users components we have to check if search has more results
				if(hasmore) {
					let loadmore = $('#role-users-fetch-more-results');
					loadmore.removeClass('none no-fetch')
				} else {
					// no-fetch prevent the scroll event from proceeding when no more results are there
					$('#role-users-fetch-more-results').addClass('none no-fetch');
				}
			} else {
				// Results not founf
				results.addClass('none');
				no_results_box.removeClass('none');
			}
			loading_block.addClass('none');

			results.removeClass('none');
			resultbox.removeClass('none');
			role_last_member_search_query = query;
			$('#rum-k').val(query); // This is used in fetch more
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
			role_member_search_lock = true;
		}
	})
});

$('.role-select-member').on('click', function() {
	let selected_user_component = $(this);
	while(!selected_user_component.hasClass('role-member-search-user')) {
		selected_user_component = selected_user_component.parent();
	}

	let selected_members_box = $('#role-members-selected-box');
	let empty_selected_members_box = $('#empty-role-members-selected-box');

	let user_component = $('.selected-role-member-to-get-role-factory').clone(true, true);
	let uid = selected_user_component.find('.rum-uid').val();
	user_component.find('.sum-uid').val(uid);
	user_component.find('.sum-avatar').attr('src', selected_user_component.find('.rum-avatar').attr('src'));
	user_component.find('.sum-fullname').text(selected_user_component.find('.rum-fullname').text());
	user_component.find('.sum-profilelink').attr('href', selected_user_component.find('.rum-profilelink').attr('href'));
	user_component.find('.sum-username').text(selected_user_component.find('.rum-username').text());
	user_component.find('.sum-role').text(selected_user_component.find('.rum-role').text());

	user_component.removeClass('none selected-role-member-to-get-role-factory');

	if(!role_user_already_selected(uid))
		selected_members_box.append(user_component);

	if(selected_members_box.hasClass('none')) {
		selected_members_box.removeClass('none');
		empty_selected_members_box.addClass('none');
	}
});

function role_user_already_selected(uid) {
	let already_selected = false;
	$('.selected-role-member-to-get-role').each(function() {
		if($(this).find('.sum-uid').val() == uid) {
			already_selected = true;
			return false;
		}
	});

	return already_selected;
}

$('.remove-sum-from-selection').on('click', function() {
	let selected_user_component = $(this);
	while(!selected_user_component.hasClass('selected-role-member-to-get-role')) {
		selected_user_component = selected_user_component.parent();
	}

	selected_user_component.remove();

	if(!$('#role-members-selected-box .selected-role-member-to-get-role').length) {
		$('#role-members-selected-box').addClass('none');
		$('#empty-role-members-selected-box').removeClass('none');
		disable_grant_role_button();
	}
});

function disable_grant_role_button() {
	let confirmation_input = $('#grant-role-confirm-input');
	let confirmation_value = $('#grant-role-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_input.val() + ' - x');

	$('#grant-role-button').addClass('disabled-green-button-style');
	able_to_grant_role = false;
}

let rum_search_fetch_more = $('#role-users-fetch-more-results');
let rum_search_results_box = $('#role-members-search-result-box');
let rum_search_fetch_more_lock = true;
if(rum_search_results_box.length) {
    rum_search_results_box.on('DOMContentLoaded scroll', function() {
        if(rum_search_results_box.scrollTop() + rum_search_results_box.innerHeight() + 50 >= rum_search_results_box[0].scrollHeight) {
			// no-fetch class is attached to fetch_more loader when no more results are there to prevent fetch
            if(!rum_search_fetch_more_lock || rum_search_fetch_more.hasClass('no-fetch')) return;
            rum_search_fetch_more_lock=false;
            
			let rid = $('#role-id').val();
			let results = $('#role-members-search-result-box .results-container');
			let spinner = rum_search_fetch_more.find('.spinner');
			// Notice we don't count directly role members from scrollable because it will count factory components as well
            let present_rums = rum_search_results_box.find('.results-container .role-member-search-user').length;

			spinner.addClass('inf-rotate');

            $.ajax({
				type: 'post',
				url: '/admin/roles/users/search/fetchmore',
				data: {
					_token: csrf,
					rid: rid,
					skip: present_rums,
					k: $('#rum-k').val()
				},
                success: function(response) {
					let users = response.users;
					let hasmore = response.hasmore;
		
					if(users.length) {
						for(let i = 0; i < users.length; i++) {
							let usercomponent = create_role_member_search_component(users[i]);
							
							results.append(usercomponent);
						}
		
						// After handling all users components we have to check if search has more results
						if(hasmore) {
							let loadmore = $('#role-users-fetch-more-results');
							loadmore.removeClass('none no-fetch');
						} else
							// no-fetch prevent the scroll event from proceeding when no more results are there
							$('#role-users-fetch-more-results').addClass('none no-fetch');
					} else {
						// Results not founf
						results.addClass('none');
						no_results_box.removeClass('none');
					}
                },
                complete: function() {
                    rum_search_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}

function create_role_member_search_component(user) {
	let usercomponent = $('#role-members-search-result-box .role-member-search-user-factory').clone(true, true);
	usercomponent.removeClass('none role-member-search-user-factory');

	let role = user.role;
	let already_has_role = user.already_has_this_role;

	usercomponent.find('.rum-uid').val(user.id);
	usercomponent.find('.rum-avatar').attr('src', user.avatar);
	usercomponent.find('.rum-fullname').text(user.fullname);
	usercomponent.find('.rum-username').text(user.username);
	usercomponent.find('.rum-profilelink').attr('href', user.profilelink);
	
	if(role == null) {
		usercomponent.find('.rum-role').text('normal user');
		usercomponent.find('.rum-role').removeClass('blue bold');
		usercomponent.find('.rum-role').addClass('gray italic');
	} else
		usercomponent.find('.rum-role').text(role);

	if(already_has_role) {
		usercomponent.find('.role-select-member').remove();
		usercomponent.find('.already-has-role').removeClass('none');
	} else {
		usercomponent.find('.already-has-role').remove();
		usercomponent.find('.role-select-member').removeClass('none');
	}

	return usercomponent;
}

let able_to_grant_role = false;
$('#grant-role-confirm-input').on('input', function() {
    let input_value = $(this).val();
    let confirm_value = $('#grant-role-confirm-value').val();
	let grantbutton = $('#grant-role-button');
    
    able_to_grant_role = false;
    if(input_value == confirm_value) {
		// Check if at least one member selected
		if(!$('#role-members-selected-box .selected-role-member-to-get-role').length) {
			// Only append error to confirmation when the values match
			let confirmation_input = $('#grant-role-confirm-input');
			let confirmation_value = $('#grant-role-confirm-value').val();
			if(confirmation_input.val() == confirmation_value)
				confirmation_input.val(confirmation_input.val() + ' - x');

			display_top_informer_message($('#rum-at-least-one-selected-message').val(), 'warning');
			grantbutton.addClass('disabled-green-button-style');
			able_to_grant_role = false;

			return;
		} else {
			grantbutton.removeClass('disabled-green-button-style');
			able_to_grant_role = true;
		}
    } else {
        // Only append error to confirmation when the values match
		let confirmation_input = $('#grant-role-confirm-input');
		let confirmation_value = $('#grant-role-confirm-value').val();
		if(confirmation_input.val() == confirmation_value)
			confirmation_input.val(confirmation_input.val() + ' - x');

		$('#grant-role-button').addClass('disabled-green-button-style');
		able_to_grant_role = false;
    }
});

let grant_role_lock = true;
$('#grant-role-button').on('click', function() {
	if(!grant_role_lock || !able_to_grant_role) return;
	grant_role_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');

	let selected_members = [];
	$('#role-members-selected-box .selected-role-member-to-get-role').each(function() {
		selected_members.push($(this).find('.sum-uid').val());
	});

	let data = {
		_token: csrf,
		rid: $('#role-id').val(),
		users: selected_members,
	};

	button.addClass('disabled-green-button-style');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/roles/grant/to/users',
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

			grant_role_lock = true;
		}
	});
});

// Revoke role

let last_user_to_revoke_role = null;
let open_role_revoke_lock = true;
$('.open-revoke-role-dialog').on('click', function() {
	let viewer = $('#revoke-role-from-users-viewer');
	let button = $(this);
	let uid = button.find('.uid').val();
	let rid = $('#role-id').val();

	if(uid != last_user_to_revoke_role) {
		if(!open_role_revoke_lock) return;
		open_role_revoke_lock = false;

		let spinner = viewer.find('.loading-viewer-spinner');
		spinner.removeClass('opacity0');
		spinner.addClass('inf-rotate');
		viewer.find('.global-viewer-content-box').html('');

		$.ajax({
			type: 'get',
			url: `/admin/roles/viewers/revoke?rid=${rid}&uid=${uid}`,
			success: function(response) {
				viewer.find('.global-viewer-content-box').html(response);
				handle_role_revoke_confirmation_input();
				handle_role_revoke_button();
				handle_revoke_viewer_cancel_button();
				last_user_to_revoke_role = uid;
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
				spinner.addClass('opacity0');
				spinner.removeClass('inf-rotate');
				open_role_revoke_lock = true;
			}
		});
	}

	disable_page_scroll();
	viewer.removeClass('none');
});

let able_to_revoke_role = false;
function handle_role_revoke_confirmation_input() {
	$('#revoke-role-confirm-input').on('input', function() {
		let input_value = $(this).val();
		let confirm_value = $('#revoke-role-confirm-value').val();
		let revokebutton = $('#revoke-role-button');
		
		able_to_revoke_role = false;
		if(input_value == confirm_value) {
			revokebutton.removeClass('disabled-red-button-style');
			able_to_revoke_role = true;
		} else
			revokebutton.addClass('disabled-red-button-style');
	});
}

let role_revoke_lock = true;
function handle_role_revoke_button() {
	$('#revoke-role-button').on('click', function() {
		if(!role_revoke_lock || !able_to_revoke_role) return;
		role_revoke_lock = false;
	
		let button = $(this);
		let buttonicon = button.find('.icon-above-spinner');
		let spinner = button.find('.spinner');

		let data = {
			_token: csrf,
			role: button.find('.rid').val(),
			user: button.find('.uid').val(),
		};

		button.addClass('disabled-red-button-style');
		spinner.addClass('inf-rotate');
		buttonicon.addClass('none');
		spinner.removeClass('opacity0');

		$.ajax({
			type: 'post',
			url: '/admin/roles/revoke/from/user',
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

				role_revoke_lock = true;
			},
		});
	});
}

function handle_revoke_viewer_cancel_button() {
	$('#revoke-role-from-users-viewer .close-global-viewer').last().on('click', function() {
		$('#revoke-role-from-users-viewer .close-global-viewer').first().trigger('click');
	})
}

// Attach permissions to role

$('.open-attach-permissions-to-role-dialog').on('click', function() {
	$('#attach-permissions-to-role-viewer').removeClass('none');
    disable_page_scroll();
});

$('.select-permission-to-attach-to-role').on('click', function() {
	let button = $(this);
	let pid = button.find('.pid').val();

	let already_selected = false;
	$('#role-permissions-selected-box .selected-permission-to-attach-to-role').each(function() {
		if($(this).find('.pid').val() == pid) {
			already_selected = true;
			return false;
		}
	})
	if(already_selected) return;

	button.find('.x-ico').addClass('none');
	button.find('.v-ico').removeClass('none');

	let permission_component = $('.selected-permission-to-attach-to-role-factory').clone(true, true);
	permission_component.find('.permission-name').text(button.find('.permission-name').text());
	permission_component.find('.pid').val(pid);
	permission_component.removeClass('none selected-permission-to-attach-to-role-factory');

	$('#empty-role-permissions-selected-box').addClass('none');
	$('#role-permissions-selected-box').removeClass('none');
	$('#role-permissions-selected-box').append(permission_component);
});

$('.remove-selected-permission-to-attach-to-role').on('click', function() {
	let component = $(this);
	while(!component.hasClass('selected-permission-to-attach-to-role')) {
		component = component.parent();
	}
	let pid = component.find('.pid').val();
	$('.select-permission-to-attach-to-role').each(function() {
		if($(this).find('.pid').val() == pid) {
			$(this).find('.x-ico').removeClass('none');
			$(this).find('.v-ico').addClass('none');
			return false;
		}
	})
	component.remove();

	if(!$('#role-permissions-selected-box .selected-permission-to-attach-to-role').length) {
		$('#empty-role-permissions-selected-box').removeClass('none');
		$('#role-permissions-selected-box').addClass('none');
		disable_attach_permission_to_role_button();
	}
});

let able_to_attach_permissions_to_role = false;
$('#attach-permissions-to-role-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#attach-permissions-to-role-confirm-value').val();
	let button = $('#attach-permissions-to-role-button');
    
    able_to_attach_permissions_to_role = false;
    if(confirmation_input.val() == confirmation_value) {
		// Check if at least one member selected
		if(!$('#role-permissions-selected-box .selected-permission-to-attach-to-role').length) {
			disable_attach_permission_to_role_button();
			display_top_informer_message($('#at-least-one-selected-permission-message').val(), 'warning');
			return;
		}

		button.removeClass('disabled-green-button-style');
		able_to_attach_permissions_to_role = true;
    } else {
		disable_attach_permission_to_role_button();
    }
});

function disable_attach_permission_to_role_button() {
	let button = $('#attach-permissions-to-role-button');
	let input = $('#attach-permissions-to-role-confirm-input');
	let conf = $('#attach-permissions-to-role-confirm-value').val();
	if(input.val() == conf) {
		input.val(conf + ' - x');
	}
	button.addClass('disabled-green-button-style');
	able_to_attach_permissions_to_role = false;
}

let attach_permissions_to_role_lock = true;
$('#attach-permissions-to-role-button').on('click', function() {
	if(!attach_permissions_to_role_lock || !able_to_attach_permissions_to_role) return;
	attach_permissions_to_role_lock = false;
	
	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');
	
	let permissions = [];
	$('#role-permissions-selected-box .selected-permission-to-attach-to-role').each(function() {
		permissions.push($(this).find('.pid').val());
	});
	
	let data = {
		_token: csrf,
		role: $('#role-id').val(),
		permissions: permissions
	};

	button.addClass('disabled-green-button-style');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/roles/attach/permissions',
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

			attach_permissions_to_role_lock = true;
		},
	});
});

// Detach permissions from role

$('.open-detach-permissions-from-role-dialog').on('click', function() {
	$('#detach-permissions-from-role-viewer').removeClass('none');
    disable_page_scroll();
});

$('.select-permission-to-detach-from-role').on('click', function() {
	let button = $(this);
	let pid = button.find('.pid').val();

	let already_selected = false;
	$('#role-permissions-to-detach-selected-box .selected-permission-to-detach-from-role').each(function() {
		if($(this).find('.pid').val() == pid) {
			already_selected = true;
			return false; // Just break the loop
		}
	})
	if(already_selected) return;

	button.find('.x-ico').addClass('none');
	button.find('.v-ico').removeClass('none');

	let permission_component = $('.selected-permission-to-detach-from-role-factory').clone(true, true);
	permission_component.find('.permission-name').text(button.find('.permission-name').text());
	permission_component.find('.pid').val(pid);
	permission_component.removeClass('none selected-permission-to-detach-from-role-factory');

	$('#empty-role-permissions-to-detach-selected-box').addClass('none');
	$('#role-permissions-to-detach-selected-box').removeClass('none');
	$('#role-permissions-to-detach-selected-box').append(permission_component);
});

$('.remove-selected-permission-to-detach-from-role').on('click', function() {
	let component = $(this);
	while(!component.hasClass('selected-permission-to-detach-from-role')) {
		component = component.parent();
	}
	let pid = component.find('.pid').val();
	$('.select-permission-to-detach-from-role').each(function() {
		if($(this).find('.pid').val() == pid) {
			$(this).find('.x-ico').removeClass('none');
			$(this).find('.v-ico').addClass('none');
			return false;
		}
	})
	component.remove();

	if(!$('#role-permissions-to-detach-selected-box .selected-permission-to-detach-from-role').length) {
		$('#empty-role-permissions-to-detach-selected-box').removeClass('none');
		$('#role-permissions-to-detach-selected-box').addClass('none');
		disable_detach_permissions_from_role_button();
	}
});

let able_to_detach_permissions_from_role = false;
$('#detach-permissions-from-role-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#detach-permissions-from-role-confirm-value').val();
	let button = $('#detach-permissions-from-role-button');
    
    able_to_detach_permissions_from_role = false;
    if(confirmation_input.val() == confirmation_value) {
		// Check if at least one member selected
		if(!$('#role-permissions-to-detach-selected-box .selected-permission-to-detach-from-role').length) {
			disable_detach_permissions_from_role_button();
			display_top_informer_message($('#at-least-one-selected-permission-to-detach-from-role-message').val(), 'warning');
			return;
		}

		button.removeClass('disabled-red-button-style');
		able_to_detach_permissions_from_role = true;
    } else {
		disable_detach_permissions_from_role_button();
    }
});

function disable_detach_permissions_from_role_button() {
	let button = $('#detach-permissions-from-role-button');
	let input = $('#detach-permissions-from-role-confirm-input');
	let conf = $('#detach-permissions-from-role-confirm-value').val();
	if(input.val() == conf) {
		input.val(conf + ' - x');
	}
	button.addClass('disabled-red-button-style');
	able_to_detach_permissions_from_role = false;
}

let detach_permissions_from_role_lock = true;
$('#detach-permissions-from-role-button').on('click', function() {
	if(!detach_permissions_from_role_lock || !able_to_detach_permissions_from_role) return;
	detach_permissions_from_role_lock = false;
	
	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');
	
	let permissions = [];
	$('#role-permissions-to-detach-selected-box .selected-permission-to-detach-from-role').each(function() {
		permissions.push($(this).find('.pid').val());
	});
	
	let data = {
		_token: csrf,
		role: $('#role-id').val(),
		permissions: permissions
	};

	button.addClass('disabled-red-button-style');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/roles/detach/permissions',
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

			detach_permissions_from_role_lock = true;
		},
	});
});

// Delete role

$('.open-delete-role-dialog').on('click', function() {
	$('#delete-role-viewer').removeClass('none');
    disable_page_scroll();
});

let able_to_delete_role = false;
$('#delete-role-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#delete-role-confirm-value').val();
	let button = $('#delete-role-button');
    
	able_to_delete_role = false;
    if(confirmation_input.val() == confirmation_value) {
		able_to_delete_role = true;
		button.removeClass('disabled-red-button-style');
    } else
		button.addClass('disabled-red-button-style');
});

let delete_role_lock = true;
$('#delete-role-button').on('click', function() {
	if(!able_to_delete_role || !delete_role_lock) return;
	delete_role_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');
	
	let data = {
		_token: csrf,
		role: $('#role-id').val(),
	};

	button.attr('style', 'background-color: #ee7d7d; cursor: default;');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'delete',
		url: '/admin/roles',
		data: {
			_token: csrf,
			role: $('#role-id').val()
		},
		success: function(response) {
			window.location.href = response;
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

			delete_role_lock = true;
		},
	});
});

if(urlprms.has('open-viewer')) {
	let viewer = urlprms.get('open-viewer');
	console.log(viewer);
    switch(viewer) {
		case 'create-role':
			$('.open-create-role-dialog').first().trigger('click');
			break;
	}
}

scrollLeftpanel('roles-and-permissions');