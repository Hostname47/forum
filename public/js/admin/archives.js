
let last_category_opened = null;
let open_delete_viewer_lock = true;
$('.open-delete-archived-category-dialog').on('click', function() {
	let categoryid = $(this).find('.category-id').val();
	let viewer = $('#delete-archived-category-viewer');

	if(last_category_opened != categoryid) {
		if(!open_delete_viewer_lock) return;
		open_delete_viewer_lock = false;

		let spinner = viewer.find('.loading-viewer-spinner');
		spinner.removeClass('opacity0');
		spinner.addClass('inf-rotate');
		viewer.find('.global-viewer-content-box').html('');

		// get delete archived category viewer
		$.ajax({
			type: 'get',
			url: `/admin/archives/categories/deleteviewer?cid=${categoryid}`,
			success: function(response) {
				viewer.find('.global-viewer-content-box').html(response);
				handle_confirmation_input(viewer);
				handle_category_delete_button(viewer);
				last_category_opened = categoryid;
			},
			complete: function() {
				spinner.addClass('opacity0');
				spinner.removeClass('inf-rotate');
				open_delete_viewer_lock = true;
			}
		});
	}

	viewer.removeClass('none');
  disable_page_scroll();
});

function handle_confirmation_input(viewer) {
	viewer.find('#delete-category-confirm-input').on('input', function() {
		let input_value = $(this).val();
		let confirm_value = $('#delete-category-confirm-value').val();
		let button = $('#delete-category-button');
	  
		if(input_value == confirm_value)
			button.removeClass('disabled-red-button-style');
		else
			button.addClass('disabled-red-button-style');
	});
}

let delete_category_lock = true;
function handle_category_delete_button(viewer) {
	viewer.find('#delete-category-button').on('click', function() {
		let input_value = $('#delete-category-confirm-input').val();
		let confirm_value = $('#delete-category-confirm-value').val();

		if(input_value != confirm_value || !delete_category_lock) return;
		delete_category_lock = false;

		let button = $(this);
		let buttonicon = button.find('.icon-above-spinner');
		let spinner = button.find('.spinner');
		let cid = button.find('.category-id').val();

		button.attr('style', 'cursor: default; cursor: not-allowed; background-color: #ee7d7d');
		spinner.addClass('inf-rotate');
		spinner.removeClass('opacity0');
		buttonicon.addClass('none');

		$.ajax({
			type: 'delete',
			url: '/admin/categories',
			data: {
				_token: csrf,
				cid: cid
			},
			success: function(response) {
				location.reload();
			},
			error: function(response) {
				spinner.addClass('opacity0');
				spinner.removeClass('inf-rotate');
				button.attr('style', '');
				buttonicon.removeClass('none');

				let errorObject = JSON.parse(response.responseText);
				let er = errorObject.message;
				if(errorObject.errors) {
					let errors = errorObject.errors;
					er = errors[Object.keys(errors)[0]][0];
				}
				display_top_informer_message(er, 'error');

				delete_category_lock = true;
			}
		});
	});
}

// Delete archived forum

let last_forum_delete_opened = null;
let open_delete_forum_viewer_lock = true;
$('.open-delete-archived-forum-dialog').on('click', function() {
	let forumid = $(this).find('.forum-id').val();
	let viewer = $('#delete-archived-forum-viewer');

	if(last_forum_delete_opened != forumid) {
		if(!open_delete_forum_viewer_lock) return;
		open_delete_forum_viewer_lock = false;

		let spinner = viewer.find('.loading-viewer-spinner');
		spinner.removeClass('opacity0');
		spinner.addClass('inf-rotate');
		viewer.find('.global-viewer-content-box').html('');

		// get delete archived forum viewer
		$.ajax({
			type: 'get',
			url: `/admin/archives/forums/deleteviewer?fid=${forumid}`,
			success: function(response) {
				viewer.find('.global-viewer-content-box').html(response);
				handle_forum_delete_confirmation_input(viewer);
				handle_forum_delete_button(viewer);
				last_forum_delete_opened = forumid;
			},
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let er = errorObject.message;
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    er = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(er, 'error');
            },
			complete: function() {
				spinner.addClass('opacity0');
				spinner.removeClass('inf-rotate');
				open_delete_forum_viewer_lock = true;
			}
		});
	}

	viewer.removeClass('none');
    disable_page_scroll();
});

function handle_forum_delete_confirmation_input(viewer) {
    viewer.find('#delete-forum-confirm-input').on('input', function() {
		let input_value = $(this).val();
		let confirm_value = $('#delete-forum-confirm-value').val();
		let button = $('#delete-forum-button');
	  
		if(input_value == confirm_value)
			button.removeClass('disabled-red-button-style');
		else
			button.addClass('disabled-red-button-style');
	});
}

let delete_forum_lock = true;
function handle_forum_delete_button(viewer) {
    viewer.find('#delete-forum-button').on('click', function() {
		let input_value = $('#delete-forum-confirm-input').val();
		let confirm_value = $('#delete-forum-confirm-value').val();

		if(input_value != confirm_value || !delete_forum_lock) return;
		delete_forum_lock = false;

		let button = $(this);
		let buttonicon = button.find('.icon-above-spinner');
		let spinner = button.find('.spinner');
		let fid = button.find('.forum-id').val();

		button.attr('style', 'cursor: default; cursor: not-allowed; background-color: #ee7d7d');
		spinner.addClass('inf-rotate');
		spinner.removeClass('opacity0');
		buttonicon.addClass('none');

		$.ajax({
			type: 'delete',
			url: '/admin/forums',
			data: {
				_token: csrf,
				fid: fid
			},
			success: function(response) {
				location.reload();
			},
			error: function(response) {
				spinner.addClass('opacity0');
				spinner.removeClass('inf-rotate');
				button.attr('style', '');
				buttonicon.removeClass('none');

				let errorObject = JSON.parse(response.responseText);
				let er = errorObject.message;
				if(errorObject.errors) {
					let errors = errorObject.errors;
					er = errors[Object.keys(errors)[0]][0];
				}
				display_top_informer_message(er, 'error');
			},
            complete: function() {
                delete_forum_lock = true;
            }
		});
	});
}

scrollLeftpanel('archives');
