$('.register-type-switch').on('click', function() {
	if($(this).hasClass('register-type-switch-selected')) return;

	let button = $(this);
	let type_to_open = button.find('.register-type').val();

	$('.register-type-switch').removeClass('register-type-switch-selected');
	button.addClass('register-type-switch-selected');
	if(type_to_open == 'social') {
		$('#social-register-box').removeClass('none');
		$('#typical-register-box').addClass('none');
	} else {
		$('#social-register-box').addClass('none');
		$('#typical-register-box').removeClass('none');
	}
});

$('.open-typical-register-notice-viewer').on('click', function() {
	$('#typical-register-notice-viewer').removeClass('none');
	disable_page_scroll();
});