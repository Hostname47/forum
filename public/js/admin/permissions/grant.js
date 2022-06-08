$('.open-permission-grant-dialog').on('click', function() {
	$('#grant-permission-to-users-viewer').removeClass('none');
    disable_page_scroll();
});

$('body').on('click', (event) => $('#permission-members-search-result-box').addClass('none'));
$('#permission-members-search-result-box').on('click', (event) => event.stopPropagation());


function create_permission_member_search_component(user) {
	let usercomponent = $('#permission-members-search-result-box .permission-member-search-user-factory').clone(true, true);
	usercomponent.removeClass('none permission-member-search-user-factory');

	let userrole = user.role;
	let already_has_permission = user.already_has_this_permission;

	usercomponent.find('.pum-uid').val(user.id);
	usercomponent.find('.pum-avatar').attr('src', user.avatar);
	usercomponent.find('.pum-fullname').text(user.fullname);
	usercomponent.find('.pum-username').text(user.username);
	usercomponent.find('.pum-profilelink').attr('href', user.profilelink);
	
	if(userrole == null) {
		usercomponent.find('.pum-role').text('normal user');
		usercomponent.find('.pum-role').removeClass('blue bold');
		usercomponent.find('.pum-role').addClass('gray italic');
	} else
		usercomponent.find('.pum-role').text(userrole);

	if(already_has_permission) {
		usercomponent.find('.permission-select-member').remove();
		usercomponent.find('.already-has-permission').removeClass('none');
	} else {
		usercomponent.find('.already-has-permission').remove();
		usercomponent.find('.permission-select-member').removeClass('none');
	}

	return usercomponent;
}

let permission_last_member_search_query = '';
let permission_member_search_lock = true;
$('#permission-search-for-member-to-grant').on('click', function(event) {
	event.stopPropagation();

	let resultbox = $('#permission-members-search-result-box');
	let results = resultbox.find('.results-container');
	let loading_block = resultbox.find('.search-loading');
	let no_results_box = resultbox.find('.no-results-found-box')
	let spinner = loading_block.find('.spinner');

	let query = $('#permission-member-search-input').val();
	let pid = $('#permission-id').val();

	if(query == '') return;
	if(query == permission_last_member_search_query) {
		if(permission_member_search_lock)
			loading_block.addClass('none');

		resultbox.removeClass('none');
		results.removeClass('none');
		return;
	}

	if(!permission_member_search_lock) return;
	permission_member_search_lock = false;

	$('#permission-users-fetch-more-results').addClass('none no-fetch');

	results.html('');
	no_results_box.addClass('none');
	spinner.addClass('inf-rotate');
	loading_block.removeClass('none');
	loading_block.removeClass('none');

	resultbox.removeClass('none');

	$.ajax({
		type: 'post',
		url: '/admin/permissions/users/search',
		data: {
			_token: csrf,
			pid: pid,
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
					let usercomponent = create_permission_member_search_component(users[i]);
					results.append(usercomponent);
				}

				// After handling all users components we have to check if search has more results
				if(hasmore) {
					let loadmore = $('#permission-users-fetch-more-results');
					loadmore.removeClass('none no-fetch')
				} else {
					// no-fetch prevent the scroll event from proceeding when no more results are there
					$('#permission-users-fetch-more-results').addClass('none no-fetch');
				}
			} else {
				// Results not found
				results.addClass('none');
				no_results_box.removeClass('none');
			}
			loading_block.addClass('none');

			results.removeClass('none');
			resultbox.removeClass('none');
			permission_last_member_search_query = query;
			$('#pum-k').val(query); // This is used in fetch more
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
			permission_member_search_lock = true;
		}
	})
});

let pum_search_fetch_more = $('#permission-users-fetch-more-results');
let pum_search_results_box = $('#permission-members-search-result-box');
let pum_search_fetch_more_lock = true;
if(pum_search_results_box.length) {
    pum_search_results_box.on('DOMContentLoaded scroll', function() {
        if(pum_search_results_box.scrollTop() + pum_search_results_box.innerHeight() + 50 >= pum_search_results_box[0].scrollHeight) {
            if(!pum_search_fetch_more_lock || pum_search_fetch_more.hasClass('no-fetch')) return;
            pum_search_fetch_more_lock=false;
            
			let pid = $('#permission-id').val();
			let results = $('#permission-members-search-result-box .results-container');
			let spinner = pum_search_fetch_more.find('.spinner');
            let present_pums = pum_search_results_box.find('.results-container .permission-member-search-user').length;

			spinner.addClass('inf-rotate');

            $.ajax({
				type: 'post',
				url: '/admin/permissions/users/search/fetchmore',
				data: {
					_token: csrf,
					pid: pid,
					skip: present_pums,
					k: $('#pum-k').val()
				},
                success: function(response) {
					let users = response.users;
					let hasmore = response.hasmore;
		
					if(users.length) {
						for(let i = 0; i < users.length; i++) {
							let usercomponent = create_permission_member_search_component(users[i]);
							results.append(usercomponent);
						}
		
						if(hasmore)
							pum_search_fetch_more.removeClass('none no-fetch');
						else
							pum_search_fetch_more.addClass('none no-fetch');
					} else {
						// Results not found
						results.addClass('none');
						no_results_box.removeClass('none');
					}
                },
                complete: function() {
                    pum_search_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}

$('.permission-select-member').on('click', function() {
	let selected_user_component = $(this);
	while(!selected_user_component.hasClass('permission-member-search-user')) {
		selected_user_component = selected_user_component.parent();
	}

	let selected_members_box = $('#permission-members-selected-box');
	let empty_selected_members_box = $('#empty-permission-members-selected-box');

	let user_component = $('.selected-permission-member-to-get-permission-factory').clone(true, true);
	let uid = selected_user_component.find('.pum-uid').val();

	// If the selected user is already selected we stop the flow
	if(permission_user_already_selected(uid)) return;

	user_component.find('.psu-id').val(uid);
	user_component.find('.psu-avatar').attr('src', selected_user_component.find('.pum-avatar').attr('src'));
	user_component.find('.psu-fullname').text(selected_user_component.find('.pum-fullname').text());
	user_component.find('.psu-profilelink').attr('href', selected_user_component.find('.pum-profilelink').attr('href'));
	user_component.find('.psu-username').text(selected_user_component.find('.pum-username').text());
	user_component.find('.psu-role').text(selected_user_component.find('.pum-role').text());

	user_component.removeClass('none selected-permission-member-to-get-permission-factory');
	selected_members_box.append(user_component);

	if(selected_members_box.hasClass('none')) {
		selected_members_box.removeClass('none');
		empty_selected_members_box.addClass('none');
	}
});

function permission_user_already_selected(uid) {
	let already_selected = false;
	$('.selected-permission-member-to-get-permission').each(function() {
		if($(this).find('.psu-id').val() == uid) {
			already_selected = true;
			return false;
		}
	});

	return already_selected;
}

$('.remove-psu-from-selection').on('click', function() {
	let selected_user_component = $(this);
	while(!selected_user_component.hasClass('selected-permission-member-to-get-permission')) {
		selected_user_component = selected_user_component.parent();
	}

	selected_user_component.remove();

	if(!$('#permission-members-selected-box .selected-permission-member-to-get-permission').length) {
		$('#permission-members-selected-box').addClass('none');
		$('#empty-permission-members-selected-box').removeClass('none');
		disable_grant_permission_button();
	}
});

function disable_grant_permission_button() {
	let confirmation_input = $('#grant-permission-to-users-confirm-input');
	let confirmation_value = $('#grant-permission-to-users-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_input.val() + ' - x');

	let button = $('#grant-permission-to-users-button');
	button.addClass('disabled-green-button-style');
	able_to_grant_permission_to_users = false;
}

let able_to_grant_permission_to_users = false;
$('#grant-permission-to-users-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#grant-permission-to-users-confirm-value').val();
	let grantbutton = $('#grant-permission-to-users-button');
    
    able_to_grant_permission_to_users = false;
    if(confirmation_input.val() == confirmation_value) {
		// Check if at least one member selected
		if(!$('#permission-members-selected-box .selected-permission-member-to-get-permission').length) {
			display_top_informer_message($('#at-least-one-user-to-attach-permission-message').val(), 'warning');
			disable_grant_permission_button();

			return;
		} else {
			grantbutton.removeClass('disabled-green-button-style');
			able_to_grant_permission_to_users = true;
		}
    } else {
		disable_grant_permission_button();
    }
});

let grant_permission_to_users_lock = true;
$('#grant-permission-to-users-button').on('click', function() {
	if(!grant_permission_to_users_lock || !able_to_grant_permission_to_users) return;
	grant_permission_to_users_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');

	let selected_members = [];
	$('#permission-members-selected-box .selected-permission-member-to-get-permission').each(function() {
		selected_members.push($(this).find('.psu-id').val());
	});

	let data = {
		_token: csrf,
		pid: $('#permission-id').val(),
		users: selected_members,
	};

	button.addClass('disabled-green-button-style');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/permissions/grant/to/users',
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

			grant_permission_to_users_lock = true;
		},
	});
});
