
let verify_path_lock = true;
$('#add-path-to-i18n-paths-box').on('click', function() {
	let input = $('#path-to-add-for-i18n-search');
	let inputvalue = input.val().trim();

	$('#paths-box .error-container').addClass('none');

	if(inputvalue == '') {
		$('#paths-box .error-container .error').text('path field is required');
		$('#paths-box .error-container').removeClass('none');
		return;
	}

	let already_exists = false;
	$('#added-paths-section .path').each(function() {
		if($(this).text() == inputvalue) {
			already_exists = true;
			return false;
		}
	});

	if(already_exists) {
		$('#paths-box .error-container .error').text('path already selected');
		$('#paths-box .error-container').removeClass('none');
		return;
	}

	if(!verify_path_lock) return;
	verify_path_lock = false;

	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

	button.addClass('disabled-typical-button-style');
	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');
	input.attr('disabled', true);

	$.ajax({
		type: 'post',
		url: '/admin/checkpath',
		data: {
			_token: csrf,
			path: input.val()
		},
		success: function(response) {
			if(response.exists == 1) {
				$('#paths-selected-for-i18n-search').removeClass('none');
				$('#no-paths-selected-for-i18n-search').addClass('none');

				enable_keys_search_button();
				let path = $('.path-selected-for-i18n-search-skeleton').clone(true);
				path.find('.path').text(inputvalue);
				path.removeClass('path-selected-for-i18n-search-skeleton none');
				$('#paths-selected-for-i18n-search').append(path);
				if(response.type == 'dir') {
					path.find('.paths-to-exclude-box').removeClass('none');
					path.find('.path-text').text(inputvalue);
				}

				input.val('');
				basic_notification_show('Path validated and added successfuly');
			} else {
				$('#paths-box .error-container .error').text('Invalide path');
				$('#paths-box .error-container').removeClass('none');
			}
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
			button.removeClass('disabled-typical-button-style');
			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');
			input.attr('disabled', false);

			verify_path_lock = true;
		}
	});
});

$('.remove-selected-path-for-i18n-search').on('click', function() {
	let pathbox = $(this);
	while(!pathbox.hasClass('path-selected-for-i18n-search')) pathbox = pathbox.parent();

	pathbox.remove();
	if($('.path-selected-for-i18n-search:not(.path-selected-for-i18n-search-skeleton)').length == 0) {
		$('#paths-selected-for-i18n-search').addClass('none');
		$('#no-paths-selected-for-i18n-search').removeClass('none');
		disable_keys_search_button();
	}
});

let able_to_search_for_i18n_keys = true;
function enable_keys_search_button() {
	if(!search_for_i18n_keys_on_path_lock) return;
	able_to_search_for_i18n_keys = true;
	$('#search-for-i18n-keys-within-paths').removeClass('disabled-typical-button-style');
}

function disable_keys_search_button() {
	if(!search_for_i18n_keys_on_path_lock) return;
	able_to_search_for_i18n_keys = false;
	$('#search-for-i18n-keys-within-paths').addClass('disabled-typical-button-style');
}

let search_for_i18n_keys_on_path_lock = true;
$('#search-for-i18n-keys-within-paths').on('click', function() {
	if(!search_for_i18n_keys_on_path_lock || !able_to_search_for_i18n_keys) return;
	search_for_i18n_keys_on_path_lock = false;

	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

	let paths = [];
	$('#paths-selected-for-i18n-search .path-selected-for-i18n-search').each(function() {
		let path = $(this).find('.path').text();
		let ignoredpaths = [];
		$(this).find('.paths-to-exclude .path-to-ignore-text').each(function() {
			ignoredpaths.push($(this).text());
		});

		paths.push([path, ignoredpaths]);
	});

	button.addClass('disabled-typical-button-style');
	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');

	$.ajax({
		type: 'post',
		url: '/admin/internationalization/search',
		data: {
			_token: csrf,
			paths: paths
		},
		success: function(response) {
			if(response.count == 0) {
				display_top_informer_message('No translatable keys found in the specified paths.')
				$('#i18n-keys-results-area').val('');
				$('#i18n-keys-count').text('0');
				return;
			}

			let keys = JSON.stringify(response.keys, null, " ").replace(/[{}]/g, '');
			$('#i18n-keys-results-area').val(keys);
			$('#i18n-keys-count').text(response.count);

			scroll_to_element('i18n-keys-search-results-container', -4);
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
			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');
			if(!$('#paths-selected-for-i18n-search .path').length) {
				button.addClass('disabled-typical-button-style');
				able_to_search_for_i18n_keys = false;
			} else {
				button.removeClass('disabled-typical-button-style');
			}

			search_for_i18n_keys_on_path_lock = true;
		}
	})
});

// --- Operations on result keys ---

$('#copy-i18n-result-keys').on('click', function() {
	if($('#i18n-keys-count').text() == 0) {
		display_top_informer_message("You don't have any keys to copy in the result box.");
		return;
	}

	/* Get the text field */
	let result_input = $("#i18n-keys-results-area");

	/* Select the text field */
	result_input[0].select();
	result_input[0].setSelectionRange(0, 99999); /* For mobile devices */

	/* Copy the text inside the text field */
	navigator.clipboard.writeText(result_input.val());

	 basic_notification_show($('#i18n-keys-count').text() + ' keys have been copied to your clipboard')
});

$('#clean-i18n-results').on('click', function() {
	$('#i18n-keys-results-area').val('');
	$('#i18n-keys-count').text('0');
});

let compare_i12n_keys_with_lang_file_lock = true;
$('.compare-i18n-keys-with-lang-file').on('click', function() {
	if($('#i18n-keys-count').text() == '0') {
		display_top_informer_message("You don't have any keys in the result box to compare.");
		return;
	}

	if(!compare_i12n_keys_with_lang_file_lock) return;
	compare_i12n_keys_with_lang_file_lock = false;

	let button = $(this);
	let spinner = button.find('.spinner');
	let lang = button.find('.lang').val();
	
	spinner.removeClass('opacity0');
	spinner.addClass('inf-rotate');

	$.ajax({
		type: 'get',
		url: '/admin/internationalization/lang-file/keys?lang='+lang,
		success: function(lang_file_keys) {
			let lang_keys = JSON.parse(lang_file_keys);
			let search_keys = JSON.parse('{' + $('#i18n-keys-results-area').val().trim().replace(/": "/g, '":"') + '}');
			let untranslatables = 0;

			// Exclude keys that are already translated in our lang file
			Object.keys(search_keys).forEach((item) => {
				if(item in lang_keys)
					delete search_keys[item];
				else
					untranslatables++;
			});

			$('#i18n-keys-results-area').val(JSON.stringify(search_keys, null, " ").replace(/[{}]/g, ''));
			if($('#i18n-keys-results-area').val() == '')
				display_top_informer_message('All keys already exists in the lang file and no need to translate anything.');
			else
				basic_notification_show('Result keys filtered successfully');

			// Update keys counter
			$('#i18n-keys-count').text(untranslatables);

			button.parent().css('display', 'none');
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
			compare_i12n_keys_with_lang_file_lock=true;
			spinner.addClass('opacity0');
			spinner.removeClass('inf-rotate');
		},
	})
});

$('.ignore-path-input').on('click', function() {
	$(this).css('border-color', '');
});

$('.add-ignored-path').on('click', function() {
	let box = $(this);
	while(!box.hasClass('paths-to-exclude-container')) box = box.parent();

	let input = box.find('.ignore-path-input');

	if(input.val() == '') {
		input.css('border-color', 'red');
		return;
	}
	
	let already_exists = false;
	box.find('.path-to-ignore-text').each(function() {
		if($(this).text() == input.val()) {
			already_exists = true;
			return false;
		}
	});
	if(already_exists) {
		input.css('border-color', 'red');
		display_top_informer_message('path already defined in ignored paths');
		return;
	}

	let ignoredpath = $('.path-to-ignore-skeleton').first().clone(true);

	ignoredpath.find('.path-to-ignore-text').text(input.val());
	ignoredpath.removeClass('path-to-ignore-skeleton none');

	box.find('.paths-to-exclude').append(ignoredpath);
	input.val('');
});

let i18n_search_in_db = true;
$('#search-for-db-i18n-keys').on('click', function() {
	if(!i18n_search_in_db) return;
	i18n_search_in_db = false;

	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');

	$.ajax({
		url: '/admin/internationalization/db-entries/search',
		success: function(response) {
			let keys = response.keys;
			let count = response.count;

			if(count == 0) {
				display_top_informer_message('No translatable keys found in the database tables.')
				$('#i18n-keys-results-area').val('');
				$('#i18n-keys-count').text('0');
				return;
			}

			let jsonkeys = JSON.stringify(keys, null, " ").replace(/[{}]/g, '');
			$('#i18n-keys-results-area').val(jsonkeys);
			$('#i18n-keys-count').text(count);

			scroll_to_element('i18n-keys-search-results-container', -4);
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
			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');
			i18n_search_in_db = true;
		}
	})
});
