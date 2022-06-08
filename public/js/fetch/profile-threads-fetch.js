let profile_threads_fetch_more = $('.profile-fetch-more');
let profile_threads_fetch_more_lock = true;
if(profile_threads_fetch_more.length) {
    $(window).on('DOMContentLoaded scroll', function() {
      // We only have to start loading and fetching data when user reach the bottom
      if(profile_threads_fetch_more.isInViewport()) {
        if(!profile_threads_fetch_more_lock) return;
        profile_threads_fetch_more_lock=false;
    
        let skip = $('#threads-global-container .thread-container-box').length;
        let user_id = $('#profile-user-id').val();

        let url = `/users/{user}/threads/loadmore?skip=${skip}&user=${user_id}`;
        $.ajax({
            type: 'get',
            url: url,
            success: function(response) {
                $('#threads-global-container').append(response.content);
				if(!response.hasmore)
					profile_threads_fetch_more.remove();

                /**
                 * When appending threads we have to handle their events (Notice that response.count is the number of threads appended)
                 * Notice that we have faded thread container righgt after threads collection so we have to exclude it from unhandled threads collection
                 */
                let unhandled_appended_threads = 
                $('#threads-global-container .resource-container').slice(response.count*(-1));
                
                // When threads are appended we need to force lazy loading for the first appended thread for better ui experience
                force_lazy_load(unhandled_appended_threads.first());
    
                unhandled_appended_threads.each(function() {
                    handle_thread_events($(this));
                    $(this).find('.thread-component-follow-box').remove();
                });
                // This will prevent appended suboptions from disappearing when cursor click on suboption containers
                handle_document_suboptions_hiding();
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
                profile_threads_fetch_more_lock = true;
            }
        });
      }
    });
}