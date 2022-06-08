
let last_selected_forum = $('.selected-forum-id').val();
let select_forum_lock = true;
$('.select-forum-button').on('click', function(event) {
	let fid = $(this).find('.forum-id').val();
	if(!select_forum_lock || fid == last_selected_forum) return;
	select_forum_lock = false;

    let button = $(this);
	let box = $(this);
	while(!box.hasClass('select-forum-box')) {
		box = box.parent();
	}

    // Start spinner
    let spinner = box.find('.spinner');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    // Hide forums suboptions
    box.find('.suboptions-container').css('display', 'none');

    // Get forum and categories sections
    $.ajax({
        url: `/admin/forum-and-categories/forums/${fid}/select`,
        success: function(response) {
            $('#forum-section-box').html(response.forumsection);
            $('#forum-categories-box').html(response.categoriessection);
            last_selected_forum = fid;

            handle_expend($('#forum-section-box'));
            handle_element_suboption_containers($('#forum-section-box'));
            
            $('.select-forum-button').removeClass('forum-selected-button-style');
            button.addClass('forum-selected-button-style');
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            display_top_informer_message(er, 'error');
        },
        complete: function() {
            select_forum_lock = true;
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
        }
    })

    event.stopPropagation();
});

if(urlParams.has('selectforum')) {
    let selected_forum = urlParams.get('selectforum');
    $('.select-forum-button').each(function() {
        if($(this).find('.forum-id').val() == selected_forum) {
            $(this).trigger('click');
        }
    })
}

scrollLeftpanel('f-a-c-dashboard');