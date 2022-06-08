
let urlprms = new URLSearchParams(window.location.search);

let activities_section_opened = 'threads';
let activities_sections_apperance_switch = new Map([
    ['threads', true],
    ['saved-threads', false],
    ['liked-threads', false],
    ['voted-threads', false],
    ['activity-log', false],
    ['replied-threads', false],
]);
let section_switcher_lock = true;
$('.activity-section-switcher').on('click', function(event) {
    let spinner = $('#activities-sections-loading-container').find('.spinner');
    let section = $(this).find('.activity-section-name').val();
    console.log(section);
    // If the section is already opened we don't to do anything
    if(section == activities_section_opened) return;

    // If the section is already fetched we only need to hide the other opened sections and show it
    // If the section doesn't exists we need to send GET request to fetch the section
    if(activities_sections_apperance_switch.get(section)) {
        $('#activities-sections-content').find('.activities-section').addClass('none');
        $('.activities-' + section + '-section').removeClass('none');
        activities_section_opened = section;
    } else {
        if(!section_switcher_lock) return;
        section_switcher_lock = false;

        // Display loading
        $('#activities-sections-loading-container').removeClass('none');
        spinner.addClass('inf-rotate');
        
        let user =  $('.activities-user').val()
        $.ajax({
            url: `/users/${user}/activities/sections/${section}/generate`,
            type: 'get',
            success: function(payload) {
                $('#activities-sections-content').append(payload);
                $('#activities-sections-content').find('.activities-section').addClass('none');
                $('#activities-sections-content').find('.activities-' + section + '-section').removeClass('none');

                let appended_section = $('.activities-section').last();
                handle_activity_load_more_button(appended_section.find('.activity-section-load-more'));
                appended_section.find('.thread-container-box').each(function() {
                    let thread_container = $(this);
                    handle_element_suboption_containers($(this));
                    handle_section_suboptions_hinding($(this));
                    handle_thread_display($(this));
                    handle_tooltip($(this));
                    $(this).imagesLoaded(function() {
                        thread_container.find('.activity-thread-user-image').each(function(){
                            handle_image_dimensions($(this));
                        });
                    });
                    handle_restore_thread_button($(this));
                    handle_permanent_delete($(this));
                    handle_permanent_destroy_button($(this));
                    handle_hide_parent($(this));
                });
            },
            complete: function() {
                activities_sections_apperance_switch.set(section, true);
                activities_section_opened = section;
                $('#activities-sections-loading-container').addClass('none');
                spinner.removeClass('inf-rotate');
                section_switcher_lock = true;
            }
              
        })
    }
});

if(urlprms.has('section')) {
    $('.activity-section-name').each(function() {
        if($(this).val() == urlprms.get('section')) {
            $(this).parent().trigger('click');
        }
    })
}
