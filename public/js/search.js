let forum_selection_lock = true;
$('.select-forum').on('click', function(event) {
    if(!forum_selection_lock) return;
    forum_selection_lock = false;

    let button = $(this);
    let spinner = $('#forum-filter-box .spinner');
    let forum_id = button.find('.forum-id').val(); // This is used to get categories
    let forum_slug = button.find('.forum-slug').val(); // This is used in search filter

    $('#forum').val(forum_slug);
    if(button.hasClass('typical-suboption-selected')) {
        forum_selection_lock = true;
        button.parent().css('display', 'none');
        event.stopPropagation();
        return;
    }

    if(forum_id == 0) {
        $('#category-filter option:not(:first)').remove();
        
        $('.select-forum').removeClass('typical-suboption-selected');
        button.addClass('typical-suboption-selected');

        $('#selected-forum-icon').html(button.find('.forum-icon').html());
        $('#selected-forum-name').text(button.find('.forum-name').text());
        button.parent().css('display', 'none');
        forum_selection_lock = true;
    } else {
        spinner.removeClass('opacity0');
        spinner.addClass('inf-rotate');

        $.ajax({
            type: 'get',
            url: `/forums/${forum_id}/categories`,
            success: function(response) {
                let categories = JSON.parse(response);
                $('#category-filter option:not(:first)').remove();
                $.each(categories, function(id, category){
                    $('#category-filter').append("<option value='" + category.id + "'>" + category.category + "</option>");
                });
                $('#selected-forum-icon').html(button.find('.forum-icon').html());
                $('#selected-forum-name').text(button.find('.forum-name').text());

                $('.select-forum').removeClass('typical-suboption-selected');
                button.addClass('typical-suboption-selected');

                button.parent().css('display', 'none');
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
                spinner.addClass("opacity0");
                spinner.removeClass('inf-rotate');
                forum_selection_lock = true;
            }
        });
    }

    event.stopPropagation();
});

$('.adv-search-remove-filter').on('click', function() {
    let filter = $(this).parent().find('.removed-filter').val();

    window.location.href = removeURLParameter(window.location.href, filter);
});

function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');   
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
    }
    return url;
}

let forum_exists = category_exists = false;
let forum;
$('.removed-filter').each(function() {
    if($(this).val() == 'forum') {
        forum = $(this).parent().find('.adv-search-remove-filter');
        forum_exists = true;
    }
    if($(this).val() == 'category') {
        category_exists = true;
    }
});

if(forum_exists && category_exists) {
    forum.parent().css('padding-right', '8px')
    forum.remove();
}