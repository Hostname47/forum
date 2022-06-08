// Fetch more user bans to review
let forums_fetch_more_lock = true;
let forums_fetch_more = $('#fetch-more-forums');
$(window).on('DOMContentLoaded scroll', function() {
  	if(forums_fetch_more.isInViewport()) {
        if(!forums_fetch_more_lock) return;
        forums_fetch_more_lock=false;

        let spinner = forums_fetch_more.find('.spinner');
        let skip = $('#forums-box .forum-component-container').length;

        spinner.addClass('inf-rotate');
        $.ajax({
            type: 'post',
            url: `/forums/fetchmore`,
            data: {
                _token: csrf,
                skip: skip,
            },
            success: function(response) {
                $(response.payload).insertBefore(forums_fetch_more);

                if(response.hasmore == false) {
                    forums_fetch_more.remove();
                    $(window).off();
                }

				let unhandled_forums = $('#forums-box .forum-component-container').slice(response.count*(-1));
                unhandled_forums.each(function() { handle_tooltip($(this)); });
            },
            complete: function() {
                forums_fetch_more_lock = true;
            }
        });
    }
});