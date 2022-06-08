let last_report_to_fetch_its_related_reports = -1;
let see_other_reports_lock = true;
$('.see-other-reports').on('click', function() {
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttontext = button.find('.button-text');
    let report_id = button.find('.report-id').val();
    let viewer = $('#view-resource-other-reports');

    if(last_report_to_fetch_its_related_reports != report_id) {
        if(!see_other_reports_lock) return;
        see_other_reports_lock = false;

        spinner.addClass('inf-rotate');
        buttontext.addClass('opacity0');
        spinner.removeClass('none');
        $('#other-reports-content').html('');

        $.ajax({
            type: 'get',
            url: `/admin/reports/${report_id}/generate`,
            success: function(response) {
                let payload = response.payload;
                let hasmore = response.hasmore;
                $('#other-reports-content').html(payload);
                if(hasmore) 
                    $('#fetch-more-resource-reports').removeClass('none no-fetch');
                else
                    $('#fetch-more-resource-reports').addClass('none no-fetch');
                
                handle_tooltip($('#other-reports-content'));
                viewer.find('#report-id').val(report_id); // This is used in fetch more
                
                viewer.removeClass('none');
                disable_page_scroll();

                last_report_to_fetch_its_related_reports = report_id;
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
                spinner.removeClass('inf-rotate');
                spinner.addClass('none');
                buttontext.removeClass('opacity0');
                
                see_other_reports_lock = true;
            }
        });
    } else {
        viewer.removeClass('none');
        disable_page_scroll();
    }
});

let reports_fetch_more = $('#fetch-more-resource-reports');
let reports_fetch_bore_box = $('#fetch-more-resource-reports-box');
let reports_fetch_more_lock = true;
if(reports_fetch_bore_box.length && reports_fetch_more.length) {
    reports_fetch_bore_box.on('DOMContentLoaded scroll', function() {
        if(reports_fetch_bore_box.scrollTop() + reports_fetch_bore_box.innerHeight() + 42 >= reports_fetch_bore_box[0].scrollHeight) {
            if(!reports_fetch_more_lock || reports_fetch_more.hasClass('no-fetch')) return;
            reports_fetch_more_lock=false;
            
			let results = $('#other-reports-content');
			let spinner = reports_fetch_more.find('.spinner');
            let present_rows = results.find('tr').length;
            let report = $('#report-id').val();

			spinner.addClass('inf-rotate');
            $.ajax({
				type: 'post',
				url: '/admin/resource/reports/fetchmore',
				data: {
					_token: csrf,
                    report: report,
					skip: present_rows,
				},
                success: function(response) {
                    let payload = response.payload;
                    let hasmore = response.hasmore;
                    $('#other-reports-content').append(payload);
                    if(hasmore) 
                        $('#fetch-more-resource-reports').removeClass('none no-fetch');
                    else
                        $('#fetch-more-resource-reports').addClass('none no-fetch');
                    
                    handle_tooltip($('#other-reports-content'));
                },
                complete: function() {
                    reports_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}

let last_report_to_render_body = false;
let view_report_body_lock = true;
$('.view-report-body').on('click', function() {
    let viewer = $('#reporting-body-viewer');
    let loading = viewer.find('.loading-box');
    let contentsection = viewer.find('.global-viewer-content-box');
    let button = $(this);
    let reportid = button.find('.report-id').val();
    
    if(reportid != last_report_to_render_body) {
        if(!view_report_body_lock) return;
        view_report_body_lock = false;

        let spinner = viewer.find('.loading-spinner');
        contentsection.html('');
        spinner.addClass('inf-rotate');
        loading.removeClass('none');

        $.ajax({
            type: 'post',
            url: '/admin/reports/bodyviewer/get',
            data: {
                _token: csrf,
                report: reportid
            },
            success: function(response) {
                last_report_to_render_body = reportid;
                contentsection.html(response);
                handle_tooltip(contentsection);
            },
            error: function(response) {

            },
            complete: function(response) {
                spinner.removeClass('inf-rotate');
                loading.addClass('none');
                view_report_body_lock = true;
            }
        });
    }

    viewer.removeClass('none');
    disable_page_scroll();
});

let resource_reports_fetch_more = $('#fetch-more-resource-reports-data');
let resource_reports_fetch_more_box = $('#resource-reports-box');
let resource_reports_fetch_more_lock = true;
if(resource_reports_fetch_more_box.length && resource_reports_fetch_more.length) {
    resource_reports_fetch_more_box.on('DOMContentLoaded scroll', function() {
        if(resource_reports_fetch_more_box.scrollTop() + resource_reports_fetch_more_box.innerHeight() + 42 >= resource_reports_fetch_more_box[0].scrollHeight) {
            if(!resource_reports_fetch_more_lock || resource_reports_fetch_more.hasClass('no-fetch')) return;
            resource_reports_fetch_more_lock=false;
            
            let resultbox = $('#resource-reports-records-box');
			let spinner = resource_reports_fetch_more.find('.spinner');
            let present_rows = resultbox.find('.resource-report-record').length;
            let report = resource_reports_fetch_more.find('.report-id').val();

			spinner.addClass('inf-rotate');
            $.ajax({
				type: 'post',
				url: '/admin/resource/reports/raw/fetchmore',
				data: {
					_token: csrf,
                    report: report,
					skip: present_rows,
				},
                success: function(response) {
                    let reports = response.reports;
                    let hasmore = response.hasmore;

                    for(let i = 0;i < reports.length; i++) {
                        let reportcomponent = $('.resource-report-record-skeleton').clone(true, true);
                        reportcomponent.find('.reporter-id').val(reports[i].reporter_id);
                        reportcomponent.find('.report-id').val(reports[i].id);
                        reportcomponent.find('.reporter-avatar').attr('src', reports[i].reporter_avatar);
                        reportcomponent.find('.reporter-profile-link').attr('href', reports[i].user_manage_link);
                        reportcomponent.find('.reporter-username').text(reports[i].reporter_username);
                        reportcomponent.find('.reported-at-hummans').text(reports[i].reported_at);
                        reportcomponent.find('.report-type').text(reports[i].report_type);
                        reportcomponent.find('.report-body').text(reports[i].report_body);

                        if(reports[i].reporter_already_warned_for_this_report)
                            reportcomponent.find('.reporter-already-warned').removeClass("none");
                        if(reports[i].reporter_already_striked_for_this_report)
                            reportcomponent.find('.reporter-already-striked').removeClass("none");

                        // Here we check if the admin check select all; if so we have to check the select radio button
                        if(resultbox.find('.select-all-reporters .checkbox-status').val() == 1)
                            reportcomponent.find('.select-reporter-to-ws').trigger('click');
                        handle_reporter_selection(reportcomponent);
                        reportcomponent.removeClass('none resource-report-record-skeleton');
                        resultbox.append(reportcomponent);
                    }

                    if(hasmore)
                        resource_reports_fetch_more.removeClass('none no-fetch');
                    else
                        resource_reports_fetch_more.addClass('none no-fetch');
                    
                },
                complete: function() {
                    resource_reports_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}

let ws_selected_reporters_lock = true; // Declared here before it is used also in other handlers (other than warning/striking buttons event handlers)

$('.select-all-reporters').on('click', function(event) {
    if(!ws_selected_reporters_lock) return;

    let selectall = $(this);
    let reportersbox = selectall.parent();
    // select all
    if(selectall.find('.checkbox-status').val() == 1)
        reportersbox.find('.select-reporter-to-ws').each(function() {
            if($(this).find('.checkbox-status').val() == 0)
                $(this).trigger('click');
        });
    else // unselect all
        reportersbox.find('.select-reporter-to-ws').each(function() {
            if($(this).find('.checkbox-status').val() == 1) {
                $(this).trigger('click');
            }
        });
});

let able_to_ws_selected_reporters = false;
handle_reporter_selection($('#resource-reports-records-box'));
function handle_reporter_selection(component) {
    component.find('.select-reporter-to-ws').on('click', function(event) {
        if(!ws_selected_reporters_lock) return;
        /**
         * In order to warn or strike reporters, at least one reporter should be selected in order to enable
         * warn and strike buttons
         */
        let at_least_one_selected = false;
        let box = $('#resource-reports-records-box');
        box.find('.select-reporter-to-ws').each(function() {
            if($(this).find('.checkbox-status').val() == 1) {
                at_least_one_selected = true;
                return false;
            }
        });

        if($(this).find('.checkbox-status').val() == 0) {
            // When an item is unselected, we check if select all is checked and unchecked
            let wrapper = box;
            while(!wrapper.hasClass('ws-reporters-wrapper')) wrapper = wrapper.parent();
            let selectallbutton = wrapper.find('.select-all-reporters');
            if(selectallbutton.find('.checkbox-status').val() == 1)
                trigger_checkbox_button(selectallbutton);
        }
    
        if(at_least_one_selected)
            switch_ws_selected_reporters_buttons('enable');
        else
            switch_ws_selected_reporters_buttons('disable');
    })
}

function switch_ws_selected_reporters_buttons(swtch) {
    let warnbutton = $('#warn-selected-reporters');
    let strikebutton = $('#strike-selected-reporters');

    if(swtch=='enable') {
        warnbutton.removeClass('disabled-red-button-style');
        strikebutton.removeClass('disabled-red-button-style');
    } else {
        warnbutton.addClass('disabled-red-button-style');
        strikebutton.addClass('disabled-red-button-style');
    }
}

$('#warn-selected-reporters').on('click', function() {
    if(!ws_selected_reporters_lock) return;
    ws_selected_reporters_lock = false;

    let ws_reporters_box = $(this);
    while(!ws_reporters_box.hasClass('ws-reporters-wrapper')) ws_reporters_box = ws_reporters_box.parent();

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let all_reporters_selected = ws_reporters_box.find('.select-all-reporters .checkbox-status').val() == 1;

    let data = {
        _token: csrf,
        reason_id: ws_reporters_box.find('.warningreason').val(),
        resource_type: 'App\\Models\\Report'
    };

    /**
     * We get selected users along with their reports to make those reports as resource id for warning
     * users to be warned and their reports ids are specified in 2 arrays in the same order to match every user with
     * its report id
     */
    if(all_reporters_selected) {
        data.users_to_warn = ws_reporters_box.find('.all-reporters-ids').val().split(',');
        data.resources_ids = ws_reporters_box.find('.all-reports-ids').val().split(',');
    }
    else {
        let reporters = [];
        let resources_ids = [];
        ws_reporters_box.find('.select-reporter-to-ws').each(function() {
            if($(this).find('.checkbox-status').val() == 1) {
                reporters.push($(this).find('.reporter-id').val());
                resources_ids.push($(this).find('.report-id').val());
            }
        });
        if(!reporters.length || !resources_ids.length) {
            ws_selected_reporters_lock = true;
            return;
        }
        data.users_to_warn = reporters;
        data.resources_ids = resources_ids;
    }

    button.addClass('disabled-red-button-style');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');

    $.ajax({
        url: `/admin/usersgroup/warn`,
        type: 'post',
        data: data,
        success: function(response) {
            basic_notification_show(button.find('.success-message').val());
            location.reload();
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(error, 'error');
            
            button.removeClass('disabled-red-button-style');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            ws_selected_reporters_lock = true;
        }
    })
});

$('#strike-selected-reporters').on('click', function() {
    if(!ws_selected_reporters_lock) return;
    ws_selected_reporters_lock = false;

    let ws_reporters_box = $(this);
    while(!ws_reporters_box.hasClass('ws-reporters-wrapper')) ws_reporters_box = ws_reporters_box.parent();

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let all_reporters_selected = ws_reporters_box.find('.select-all-reporters .checkbox-status').val() == 1;

    let data = {
        _token: csrf,
        reason_id: ws_reporters_box.find('.strikereason').val(),
        resource_type: 'App\\Models\\Report'
    };

    /**
     * We get selected users along with their reports to make those reports as resource id for warning
     * users to be warned and their reports ids are specified in 2 arrays in the same order to match every user with
     * its report id
     */
    if(all_reporters_selected) {
        data.users_to_strike = ws_reporters_box.find('.all-reporters-ids').val().split(',');
        data.resources_ids = ws_reporters_box.find('.all-reports-ids').val().split(',');
    }
    else {
        let reporters = [];
        let resources_ids = [];
        ws_reporters_box.find('.select-reporter-to-ws').each(function() {
            if($(this).find('.checkbox-status').val() == 1) {
                reporters.push($(this).find('.reporter-id').val());
                resources_ids.push($(this).find('.report-id').val());
            }
        });
        if(!reporters.length || !resources_ids.length) {
            ws_selected_reporters_lock = true;
            return;
        }

        data.users_to_strike = reporters;
        data.resources_ids = resources_ids;
    }

    button.addClass('disabled-red-button-style');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');

    $.ajax({
        url: `/admin/usersgroup/strike`,
        type: 'post',
        data: data,
        success: function(response) {
            basic_notification_show(button.find('.success-message').val());
            location.reload();
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(error, 'error');
            
            button.removeClass('disabled-red-button-style');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            ws_selected_reporters_lock = true;
        }
    })
});

let change_resource_reports_review_status_lock = true;
$('.change-resource-reports-review-status').on('click', function() {
    if(!change_resource_reports_review_status_lock) return;
    change_resource_reports_review_status_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let successmessage = button.find('.success-message').val();

    let box = button;
    while(!box.hasClass('review-reports-box')) box = box.parent();

    button.attr('style', 'cursor: default;');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'patch',
        url: '/admin/reports/review/patch',
        data: {
            _token: csrf,
            action: button.find('.action-type').val(),
            report: box.find('.report-id').val()
        },
        success: function(response) {
            if(response == 'reviewed') {
                box.find('.unreview-reports-section').removeClass('none');
                box.find('.review-reports-section').addClass('none');
            } else {
                box.find('.unreview-reports-section').addClass('none');
                box.find('.review-reports-section').removeClass('none');
            }
            basic_notification_show(successmessage);
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
            change_resource_reports_review_status_lock = true;
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.attr('style', '');
        }
    })
});
