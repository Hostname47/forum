let category_threads_fetch_more = $('.category-threads-fetch-more');
let category_threads_fetch_more_lock = true;
if(category_threads_fetch_more.length) {
    $(window).on('DOMContentLoaded scroll', function() {
      // We only have to start loading and fetching data when user reach the bottom
      if(category_threads_fetch_more.isInViewport()) {
        if(!category_threads_fetch_more_lock) {
            return;
        }
        category_threads_fetch_more_lock=false;
    
        let forum = $('#forum-id').val();
        let category = $('#category-id').val();
        let skip = $('.current-threads-count').val();
        let tab = $('.date-tab').val();

        let url = `/forums/${forum}/categories/${category}/threads/loadmore?skip=${skip}&tab=${tab}`;
        $.ajax({
            type: 'get',
            url: url,
            success: function(response) {
                $('#threads-global-container').append(response.content);
              if(!response.hasmore) {
                category_threads_fetch_more.remove();
              }

                let new_skip = parseInt(skip) + parseInt(response.count);
                $('.current-threads-count').val(new_skip);
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
                });
                // This will prevent appended suboptions from disappearing when cursor click on suboption containers
                handle_document_suboptions_hiding();

                category_threads_fetch_more_lock = true;
            },
            error: function(response) {
              
            },
            complete: function(response) {
                
            }
        });
      }
    });
}