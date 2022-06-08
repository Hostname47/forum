
let update_annnouncement_lock = true;
$('#update-announcement-button').on('click', function() {
    if(!update_annnouncement_lock) return;
    update_annnouncement_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    let thread_id = $('#thread-id').val();
    const $content_edit = $('#content').nextAll('.CodeMirror')[0].CodeMirror;
    
    let form_data = new FormData();
    form_data.append('_token' ,csrf);
    form_data.append('subject' ,$('#subject').val().trim());
    form_data.append('category_id' ,$('#category').val());
    form_data.append('content' , $content_edit.getValue().trim());
    form_data.append('_method', 'patch');

    if(edit_deleted_medias.length) {
        form_data.append('removed_medias', JSON.stringify(edit_deleted_medias));
    }

    if(uploaded_thread_images_assets.length) {
        // Append image files
        for(let i = 0;i<uploaded_thread_images_assets.length;i++) {
            // First filename
            let filename = uploaded_thread_images_assets[i][1].name.toLowerCase();
            // Get file extension with the preceding dot (ex: file.jpg => .jpg)
            let ext = filename.substr(filename.lastIndexOf('.'));
            /**
             * Here to preserve the order is little more different than storing media the first time
             * First we need to take the last already uploaded media's name (If exists) from it's source
             * and add 1 to that counter
             */
            filename = last_media_count + ext;
            last_media_count++;
            form_data.append('images[]', uploaded_thread_images_assets[i][1], filename);
        }
    }
    // Checking videos existence in the thread
    if(uploaded_thread_videos_assets.length) {
        // Append videos files
        for(let i = 0;i<uploaded_thread_videos_assets.length;i++) {
            // First filename
            let filename = uploaded_thread_videos_assets[i][1].name.toLowerCase();
            // Get file extension with the preceding dot (ex: file.jpg => .jpg)
            let ext = filename.substr(filename.lastIndexOf('.'));
            // Then we store the file with the combination of counter and extension to preserve the order when saving files
            filename = last_media_count + ext;
            last_media_count++;
            form_data.append('videos[]', uploaded_thread_videos_assets[i][1], filename);
        }
    }

    if($('#thread-resplies-disable').prop("checked") == true) {
        form_data.append('replies_off', 1);
    } else {
        form_data.append('replies_off', 0);
    }

    let error_container = $('.thread-edit-error-container');
    if(form_data.get('subject') == '') {
        error_container.removeClass('none');
        error_container.find('.thread-edit-error').text($('.subject-required-error').val());
        $('#subject').parent().find('.error').removeClass('none');
        $(window).scrollTop(0);
        return;
    } else {
        error_container.addClass('none');
        $('#subject').parent().find('.error').addClass('none');
    }

    if(form_data.get('content') == '') {
        error_container.removeClass('none');
        error_container.find('.thread-edit-error').text($('.content-required-error').val());
        $('#content').parent().find('.error').removeClass('none');
        $(window).scrollTop(0);
        return;
    }

    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
    button.addClass('disabled-typical-button-style');

    error_container.addClass('none');

    $.ajax({
        type: 'post',
        data: form_data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        url: `/announcement/${thread_id}`,
        success: function(response) {
            document.location.href = response;
        },
        error: function(response) {
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            button.removeClass('disabled-typical-button-style');

            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            error_container.removeClass('none');
            error_container.find('.thread-edit-error').html(error);
            $(window).scrollTop(0);

            update_annnouncement_lock = true;
        },
        complete: function() {
            
        }
    })
    
    return false;
});