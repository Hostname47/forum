let visits_fetch_more = $('#visits-fetch-more');
let visits_results_box = $('#visits-box');
let visits_fetch_more_lock = true;
if(visits_results_box.length && visits_fetch_more.length) {
    visits_results_box.on('DOMContentLoaded scroll', function() {
        if(visits_results_box.scrollTop() + visits_results_box.innerHeight() + 33 >= visits_results_box[0].scrollHeight) {
            if(!visits_fetch_more_lock || visits_fetch_more.hasClass('no-fetch')) return;
            visits_fetch_more_lock=false;
            
			let results = visits_results_box.find('.visits-results');
			let spinner = visits_fetch_more.find('.spinner');
            let present_rows = visits_results_box.find('.visit-row').length;

			spinner.addClass('inf-rotate');
            $.ajax({
				type: 'post',
				url: '/admin/visits/fetch',
				data: {
					_token: csrf,
					skip: present_rows,
					filter: visits_fetch_more.find('.current-filter').val()
				},
                success: function(response) {
					let visits = response.visits;
					let hasmore = response.hasmore;
		
					for(let i = 0; i < visits.length; i++) {
						let row = $('.visit-row-skeleton').first().clone(true);
						row.find('.visit-url').text(visits[i].url);
						row.find('.visit-hits').text(visits[i].hits);
						row.removeClass('visit-row-skeleton none');

						$(row).insertBefore('#visits-fetch-more');
					}
	
					if(hasmore)
						visits_fetch_more.removeClass('none no-fetch');
					else
						visits_fetch_more.addClass('none no-fetch');
                },
                complete: function() {
                    visits_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}


let change_dashboard_visits_filter_lock = true;
$('.visits-links-filter').on('click', function(event) {
	if($(this).hasClass('vlf-selected') || !change_dashboard_visits_filter_lock) return;
	change_dashboard_visits_filter_lock = false;

	event.stopPropagation();
	let button = $(this);
	let filter = button.find('.filter').val();
	let spinner = button.find('.spinner');
	
	$('#visits-fetch-more').addClass('none no-fetch');
	button.attr('style', 'cursor: default');
	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/visits/filter',
		data: {
			_token: csrf,
			filter: filter
		},
		success: function(response) {
			$('#visits-fetch-more .current-filter').val(filter); // This will be used in fetch more

			$('.visits-links-filter').removeClass('vlf-selected');
			button.addClass('vlf-selected');
			button.parent().css('display', 'none');
			$('#visits-filter-selection-name').text(button.find('.filter-name').val());

			let results = response.visits;
			$('.visit-row:not(.visit-row-skeleton)').remove();

			if(results.length) 
				$('#visits-empty').addClass('none');
			else
				$('#visits-empty').removeClass('none');

			for(let i = 0;i < results.length; i++) {
				let row = $('.visit-row-skeleton').first().clone(true);
				row.find('.visit-url').text(results[i].url);
				row.find('.visit-hits').text(results[i].hits);
				row.removeClass('visit-row-skeleton none');
	
				$(row).insertBefore('#visits-fetch-more');
			}

			if(response.hasmore)
				visits_fetch_more.removeClass('none no-fetch');
			else
				visits_fetch_more.addClass('none no-fetch');
		},
		error: function(response) {

		},
		complete: function() {
			change_dashboard_visits_filter_lock = true;
			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			button.attr('style', '');
		}
	})
});
