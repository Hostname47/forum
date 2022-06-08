
let last_announcement_to_delete = null;
let open_announcement_delete_viewer_lock = true;
$('.open-announcement-delete-dialog').on('click', function() {
	let viewer = $('#announcement-delete-viewer');
    let announcementid = $(this).find('.announcement-id').val();
	let contentbox = viewer.find('.global-viewer-content-box');
	let spinner = viewer.find('.loading-viewer-spinner');

	disable_page_scroll();
	viewer.removeClass('none');
	if(!open_announcement_delete_viewer_lock || announcementid == last_announcement_to_delete) {
		return;
	}

	contentbox.html('');
	spinner.addClass('inf-rotate');
	spinner.removeClass('none');

	$.ajax({
		type: 'post',
		url: '/admin/announcements/delete/viewer',
		data: {
			_token: csrf,
			announcement: announcementid,
		},
		success: function(response) {
			last_announcement_to_delete = announcementid;
			contentbox.html(response);
			handle_announcement_delete();
			handle_delete_announcement_viewer_cancel_button();
		},
		error: function(response) {
			last_announcement_to_delete = false;
			$('.close-global-viewer').first().trigger('click');

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}

			display_top_informer_message(error, 'error');
		},
		complete: function(response) {
			open_announcement_delete_viewer_lock = true;
			spinner.removeClass('inf-rotate');
			spinner.addClass('none');
		}
	});
});

let delete_announcement_lock = true;
function handle_announcement_delete() {
	$('#delete-announcement-button').on('click', function() {
		if(!delete_announcement_lock) return;
		delete_announcement_lock = false;
	
		let button = $(this);
		let spinner = button.find('.spinner');
		let buttonicon = button.find('.icon-above-spinner');
		let announcementid = button.find('.announcement-id').val();
	
		button.addClass('disabled-red-button-style');
		buttonicon.addClass('none');
		spinner.addClass('inf-rotate');
		spinner.removeClass('opacity0');
	
	
		$.ajax({
			type: 'delete',
			url: `/announcement/${announcementid}`,
			data: {
				_token: csrf,
				announcement: announcementid
			},
			success: function(response) {
				$('#thread'+announcementid).remove();
				$('.close-global-viewer').trigger('click');
				basic_notification_show(button.find('.deleted-successfully').val(), 'basic-notification-round-tick');
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
				spinner.addClass('opacity0');
				spinner.removeClass('inf-rotate');
				buttonicon.removeClass('none');
				button.removeClass('disabled-red-button-style');
	
				delete_announcement_lock = true;
			}
		});
	});
}

function handle_delete_announcement_viewer_cancel_button() {
	$('#announcement-delete-viewer .close-global-viewer').last().on('click', function() {
		$('#announcement-delete-viewer .close-global-viewer').first().trigger('click');
	})
}