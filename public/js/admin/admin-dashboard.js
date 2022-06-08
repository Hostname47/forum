
let change_dashboard_statistics_filter_lock = true;
$('.dashbaord-statistics-filter').on('click', function(event) {
	if($(this).hasClass('dsf-selected') || !change_dashboard_statistics_filter_lock) return;
	change_dashboard_statistics_filter_lock = false;

	event.stopPropagation();
	let button = $(this);
	let filter = button.find('.filter').val();
	let loadingsection = $('#dashboard-statistics-loading-strip');
	
	loadingsection.find('.spinner').addClass('inf-rotate');
	loadingsection.removeClass('none');
	
	button.parent().css('display', 'none');
	button.attr('style', 'cursor: default');

	$.ajax({
		type: 'post',
		url: '/admin/dashboard/statistics/fetch',
		data: {
			_token: csrf,
			filter: filter
		},
		success: function(response) {
			let statistics = response;
			console.log(statistics)
			$('.dashboard-visitors-count').text(statistics['visitors']);
			$('.dashboard-signups-count').text(statistics['signups']);
			$('.dashboard-threads-count').text(statistics['threads']);
			$('.dashboard-posts-count').text(statistics['posts']);
			$('.dashboard-votes-count').text(statistics['votes']);
			$('.dashboard-likes-count').text(statistics['likes']);
			$('.dashboard-feedbackmessages-count').text(statistics['feedbackmessages']);

			$('.dashboard-emoji-sad-count').text(statistics['emojifeedbacks'].sad);
			$('.dashboard-emoji-sceptic-count').text(statistics['emojifeedbacks'].sceptic);
			$('.dashboard-emoji-soso-count').text(statistics['emojifeedbacks'].soso);
			$('.dashboard-emoji-happy-count').text(statistics['emojifeedbacks'].happy);
			$('.dashboard-emoji-veryhappy-count').text(statistics['emojifeedbacks'].veryhappy);

			$('.dashboard-contactmessages-count').text(statistics['contactmessages']);
			$('.dashboard-reports-count').text(statistics['reports']);
			$('.dashboard-authbreaks-count').text(statistics['authbreaks']);

			$('#dashboard-statistics-filter-selection-name').text(button.find('.filter-name').val());
			$('.dashbaord-statistics-filter').removeClass('dsf-selected');
			button.addClass('dsf-selected');
		},
		error: function(response) {

		},
		complete: function() {
			change_dashboard_statistics_filter_lock = true;
			loadingsection.find('.spinner').removeClass('inf-rotate');
			loadingsection.addClass('none');
			button.attr('style', '');
		}
	})
});

let open_authbreaks_viewer_lock = true;
let authbreaks_viewer_opened = false;
$('#open-auth-breaks-viewer').on('click', function() {
	let viewer = $('#authbreaks-viewer');
	if(!authbreaks_viewer_opened) {
		if(!open_authbreaks_viewer_lock) return;
		open_authbreaks_viewer_lock = false;

		let spinner = viewer.find('.loading-spinner');
        spinner.addClass('inf-rotate');

        $.ajax({
            url: '/admin/authbreaks/all/viewer',
            success: function(response) {
                authbreaks_viewer_opened = true;
                viewer.find('.global-viewer-content-box').html(response);
				viewer.find('.user-authbreak-record').each(function() {
					handle_thread_render($(this).find('.render-thread'));
					handle_post_render($(this).find('.render-post'));
					handle_tooltip($(this));
					handle_fetch_more_authbreaks();
				});
                viewer.find('.loading-box').remove();
            },
            complete: function() {
				open_authbreaks_viewer_lock = true;
            }
        });
	}

	viewer.removeClass('none');
	disable_page_scroll();
});

// Fetch more user bans to review
let authbreaks_fetch_more_lock = true;
function handle_fetch_more_authbreaks() {
	let authbreaks_fetch_more = $('#authbreaks-fetch-more');
	let authbreaks_box = $('#authbreaks-review-box');
	authbreaks_box.on('DOMContentLoaded scroll', function() {
		if(authbreaks_box.scrollTop() + authbreaks_box.innerHeight() + 50 >= authbreaks_box[0].scrollHeight) {
			if(!authbreaks_fetch_more_lock) return;
			authbreaks_fetch_more_lock=false;
	
			let spinner = authbreaks_fetch_more.find('.spinner');
			let skip = authbreaks_box.find('.user-authbreak-record').length;
			
			spinner.addClass('inf-rotate');
			$.ajax({
				url: `/admin/authbreaks/fetchmore`,
				data: {
					skip: skip,
					take: 10
				},
				success: function(response) {
					$(response.payload).insertBefore(authbreaks_fetch_more);
			
					let unhandled_authbreaks = 
						authbreaks_box.find(".user-authbreak-record").slice(response.count*(-1));

					unhandled_authbreaks.each(function() {
						handle_thread_render($(this).find('.render-thread'));
						handle_post_render($(this).find('.render-post'));
						handle_tooltip($(this));
					});
			
					if(response.hasmore == false) {
						user_authbreaks_review_fetch_more.remove();
						user_authbreaks_review_box.off();
					}
				},
				complete: function() {
					authbreaks_fetch_more_lock = true;
				}
			});
		}
	});
}

let open_visitors_viewer_lock = true;
let visitors_viewer_opened = false;
$('#open-visitors-viewer').on('click', function() {
	let viewer = $('#visitors-viewer');
	if(!visitors_viewer_opened) {
		if(!open_visitors_viewer_lock) return;
		open_visitors_viewer_lock = false;

		let spinner = viewer.find('.loading-spinner');
        spinner.addClass('inf-rotate');

        $.ajax({
            url: '/admin/visitors/all/viewer',
            success: function(response) {
                visitors_viewer_opened = true;
                viewer.find('.global-viewer-content-box').html(response);
				viewer.find('.visitor-record-container').each(function() {
					handle_tooltip($(this));
					handle_fetch_more_visitors();
				});
                viewer.find('.loading-box').remove();
            },
            complete: function() {
				open_visitors_viewer_lock = true;
            }
        });
	}

	viewer.removeClass('none');
	disable_page_scroll();
});

let visitors_fetch_more_lock = true;
function handle_fetch_more_visitors() {
	let visitors_fetch_more = $('#visitors-fetch-more');
	let visitors_results_box = $('#visitors-box');
	if(visitors_results_box.length && visitors_fetch_more.length) {
		visitors_results_box.on('DOMContentLoaded scroll', function() {
			if(visitors_results_box.scrollTop() + visitors_results_box.innerHeight() + 33 >= visitors_results_box[0].scrollHeight) {
				if(!visitors_fetch_more_lock) return;
				visitors_fetch_more_lock=false;
				
				let spinner = visitors_fetch_more.find('.spinner');
				let skip = visitors_results_box.find('.visitor-record-container').length;
	
				spinner.addClass('inf-rotate');
				$.ajax({
					type: 'get',
					url: `/admin/visitors/fetchmore?skip=${skip}&take=10`,
					success: function(response) {
						let visitors = response.payload;
						let hasmore = response.hasmore;
			
						$(visitors).insertBefore(visitors_fetch_more);
						let unhandled_visitors = 
							visitors_results_box.find(".visitor-record-container").slice(response.count*(-1));
	
						unhandled_visitors.each(function() {
							handle_tooltip($(this));
						});
	
		
						if(!hasmore) {
							visitors_fetch_more.remove();
							visitors_results_box.off();
						}
					},
					complete: function() {
						visitors_fetch_more_lock = true;
						spinner.removeClass('inf-rotate');
					}
				});
			}
		});
	}
}

let open_signups_viewer_lock = true;
let signups_viewer_opened = false;
$('#open-newsignups-viewer').on('click', function() {
	let viewer = $('#new-signups-viewer');
	if(!signups_viewer_opened) {
		if(!open_signups_viewer_lock) return;
		open_signups_viewer_lock = false;

		let spinner = viewer.find('.loading-spinner');
        spinner.addClass('inf-rotate');

        $.ajax({
            url: '/admin/signups/all/viewer',
            success: function(response) {
                signups_viewer_opened = true;
                viewer.find('.global-viewer-content-box').html(response);
				viewer.find('.signup-record-container').each(function() {
					handle_tooltip($(this));
					handle_fetch_more_signups();
				});
                viewer.find('.loading-box').remove();
            },
            complete: function() {
				open_signups_viewer_lock = true;
            }
        });
	}

	viewer.removeClass('none');
	disable_page_scroll();
});

let signups_fetch_more_lock = true;
function handle_fetch_more_signups() {
	let signups_fetch_more = $('#new-signups-fetch-more');
	let signups_results_box = $('#new-signups-box');
	if(signups_results_box.length && signups_fetch_more.length) {
		signups_results_box.on('DOMContentLoaded scroll', function() {
			if(signups_results_box.scrollTop() + signups_results_box.innerHeight() + 33 >= signups_results_box[0].scrollHeight) {
				if(!signups_fetch_more_lock) return;
				signups_fetch_more_lock=false;
				
				let spinner = signups_fetch_more.find('.spinner');
				let skip = signups_results_box.find('.signup-record-container').length;
	
				spinner.addClass('inf-rotate');
				$.ajax({
					type: 'get',
					url: `/admin/newsignups/fetchmore?skip=${skip}&take=10`,
					success: function(response) {
						let signups = response.payload;
						let hasmore = response.hasmore;
			
						$(signups).insertBefore(signups_fetch_more);
						let unhandled_signups = 
							signups_results_box.find(".signup-record-container").slice(response.count*(-1));
	
						unhandled_signups.each(function() { handle_tooltip($(this)); });
		
						if(!hasmore) {
							signups_fetch_more.remove();
							signups_results_box.off();
						}
					},
					complete: function() {
						signups_fetch_more_lock = true;
						spinner.removeClass('inf-rotate');
					}
				});
			}
		});
	}
}