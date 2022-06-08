$('.render-forum-icon').on('click', function(event) {
    let icon = $('#forum-icon').val();

    if(icon=='') {
        display_top_informer_message('icon field is empty', 'warning');
        $(this).parent().find('.forum-icon-viewer').css('display', 'none');
        return;
    }

    $('#forum-icon-svg').html(icon);
});

$('.render-category-icon').on('click', function(event) {
    let icon = $('#category-icon').val();

    if(icon=='') {
        display_top_informer_message('icon field is empty', 'warning');
        $(this).parent().find('.category-icon-viewer').css('display', 'none');
        return;
    }

    $('#category-icon-svg').html(icon);
});
