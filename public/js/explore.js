$('.sort-by-option').on('click', function() {
    let sort_by_key = $(this).find('.sort-by-key').val();
    window.location.href = updateQueryStringParameter(window.location.href, 'sortby', sort_by_key);
});

let explore_more = $('.explore-more');
let explore_lock = true;

$(window).on('DOMContentLoaded scroll', function() {
  // We only have to start loading and fetching data when user reach the explore more faded thread
  if(explore_more.isInViewport()) {
    if(!explore_lock) {
      return;
    }
    explore_lock=false;

    let sortby = $('#sort').val();
    let from = $('#hours_interval_from').val();
    let to = $('#hours_interval_to').val();
    let skip = $('#skip').val();

    let url = `/explore/loadmore?from=${from}&to=${to}&sortby=${sortby}&skip=${skip}`;
    $.ajax({
        type: 'get',
        url: url,
        success: function(response) {
          if(response.terminated) {
            explore_more.remove();
          }
          $('#hours_interval_from').val(response.from);
          $('#hours_interval_to').val(response.to);
          $('#remains').val(response.remains);
          $('#skip').val(response.skip);
          $('#threads-global-container').append(response.content);
          
          console.log($('.thread-container-box').length);

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
          explore_lock = true;
        },
        error: function(response) {

        },
        complete: function(response) {
          
        }
    });
  }
});