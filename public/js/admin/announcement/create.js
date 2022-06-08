
$('.announcement-forum-select').each(function() {
    $(this).on('click', function(event) {
        let button = $(this);
        let forum_id = button.find('.forum-id').val();
        let forum_title = button.find('.thread-add-forum-title').text();

        $('.announcement-forum-selected-icon').html(button.find('.forum-ico').html()); // Change the icon
        $('.announcement-forum-selected-forum').text(forum_title); // Change the title
        $('#forum-id').val(forum_id);

        button.parent().css('display', 'none');
        event.stopPropagation();
    })
});

let announcement_add_lock = true;
$('.announcement-add-share').on('click', function(event) {
    let form_data = new FormData();
    form_data.append('_token' ,csrf);

    let has_upload = false;
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let successmessage = button.find('.success-message').val();
    let container = $('#thread-add-wrapper');
    let threadtype = container.find('.thread-type-value').val(); // discussion or poll

    if($('#subject').val().trim() == '') {
        $('#subject').parent().find('.error').removeClass('none');
        container.find('.thread-add-error').text($('#subject').parent().find('.required-text').val());
        container.find('.thread-add-error-container').removeClass('none');
        scroll_to_element('thread-add-wrapper', -60);
        return;
    } else {
        $('#subject').parent().find('.error').addClass('none');
        container.find('.thread-add-error-container').addClass('none');
    }

    const $threadcontent = $('#content').nextAll('.CodeMirror')[0].CodeMirror;
    switch(threadtype) {
        case 'discussion':
            if($threadcontent.getValue().trim() == '') {
                $('#content').parent().find('.error').removeClass('none');
                container.find('.thread-add-error').text($('#content').parent().find('.required-text').val());
                container.find('.thread-add-error-container').removeClass('none');
                scroll_to_element('thread-add-wrapper', -60);
                return;
            } else {
                // Append thread content to the thread in case the user keep it as discussion
                form_data.append('content' ,$threadcontent.getValue());
                $('#content').parent().find('.error').addClass('none');
                container.find('.thread-add-error-container').addClass('none');
            }

            /**
             * ---------------- WE CHECK FOR MEDIAS ONLY IN DISCUSSION TYPE ----------------
             * Update: instead of directly append files to form data, we take first the old filename and extract the extension
             * then we use the counter and append the extension to the counter value, in that way we get ascending order of file names to maintain order
             * when saving those files
             */
            if(uploaded_thread_images_assets.length) {
                has_upload = true;
                // Append image files
                for(let i = 0;i<uploaded_thread_images_assets.length;i++) {
                    // First filename
                    let filename = uploaded_thread_images_assets[i][1].name.toLowerCase();
                    // Get file extension with the preceding dot (ex: file.jpg => .jpg)
                    let ext = filename.substr(filename.lastIndexOf('.'));
                    // Then we store the file with the combination of counter and extension to preserve the order when saving files
                    filename = uploaded_thread_images_assets[i][0] + ext;
                    form_data.append('images[]', uploaded_thread_images_assets[i][1], filename);
                }
            }
            // Checking videos existence in the thread
            if(uploaded_thread_videos_assets.length) {
                has_upload = true;
                // Append videos files
                for(let i = 0;i<uploaded_thread_videos_assets.length;i++) {
                    // First filename
                    let filename = uploaded_thread_videos_assets[i][1].name.toLowerCase();
                    // Get file extension with the preceding dot (ex: file.jpg => .jpg)
                    let ext = filename.substr(filename.lastIndexOf('.'));
                    // Then we store the file with the combination of counter and extension to preserve the order when saving files
                    filename = uploaded_thread_videos_assets[i][0] + ext;
                    form_data.append('videos[]', uploaded_thread_videos_assets[i][1], filename);
                }
            }
    
            break;
        case 'poll':
            form_data.append('type' , 'poll');
            form_data.append('content' , '..'); // This will be set to '..' on server if thread is a poll
            form_data.append('allow_multiple_voting', $('.poll-allow-multiple-voting').val());
            form_data.append('allow_options_add', $('.allow-others-to-add-options').val());
            if(form_data.get('allow_options_add') == 1)
                form_data.append('options_add_limit', $('#poll-options-per-user-limit').val());

            // Validating options rules
            let options = $('#thread-add-poll-options-box .thread-poll-option-container');
            let optionsvalues = [];
            options.each(function() {
                if($(this).find('.poll-option-value').val().trim() != "")
                    optionsvalues.push($(this).find('.poll-option-value').val());
            });

            if(!array_elements_unique(optionsvalues)) {
                container.find('.thread-add-error').text($('#options-should-be-unique-error').val());
                container.find('.thread-add-error-container').removeClass('none');
                optionsvalues = [];
                scroll_to_element('thread-add-wrapper', -60);
                return;
            }

            if(optionsvalues.length < 2) {
                container.find('.thread-add-error').text($('#options-length-fillables-required').val());
                container.find('.thread-add-error-container').removeClass('none');
                scroll_to_element('thread-add-wrapper', -60);
                return;
            } else {
                form_data.append('options' , JSON.stringify(optionsvalues));
                container.find('.thread-add-error-container').addClass('none');
            }
            break;
    }
    
    // When user click share and everything is validated we need to disable both subject and content inputs
    $('#subject').attr('disabled', 'disabled');
    if(threadtype == 'discussion') {
        $threadcontent.setOption('readOnly', 'nocursor');
    } else if(threadtype == 'poll') {
        $('#thread-add-poll-options-box .thread-poll-option-container').each(function() {
            $(this).find('.poll-option-value').attr('disabled', 'disabled');
        })
    }

    form_data.append('subject' ,$('#subject').val().trim());
    form_data.append('replies_off', $('#replies-disable').val());
    form_data.append('forum_id', $('#forum-id').val());
    form_data.append('type', threadtype);

    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    if(!announcement_add_lock) return;
    announcement_add_lock = false;

    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            
            if(has_upload) {
                let progress_bar_box = container.find('.progress-bar-box');
                let progress_bar = progress_bar_box.find('.progress-bar');
                progress_bar_box.removeClass('none');
    
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        progress_bar.css('width', percentComplete+"%");
                        progress_bar_box.find('.progress-bar-percentage-counter').text(percentComplete);
                        if(percentComplete >= 50) {
                            progress_bar_box.find('.progress-bar-percentage').css('color', 'white');
                        }
                
                        if (percentComplete === 100) {
                            if(progress_bar_box.find('.text-above-progress-bar').length) {
                                progress_bar_box.find('.text-above-progress-bar').text(progress_bar_box.find('.upload-finish-text').val());
                            }
                        }
                    }
                }, false);
            }
        
            return xhr;
        },
        url: '/announcement',
        type: 'post',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: form_data,
        success: function(response) {
            basic_notification_show(successmessage);
            window.location.href = response.link;
        },
        error: function(response) {
            if(has_upload) {
                let progress_bar_box = container.find('.progress-bar-box');
                let progress_bar = progress_bar_box.find('.progress-bar');
    
                progress_bar_box.addClass('none');
                progress_bar_box.find('.text-above-progress-bar').text(progress_bar_box.find('.uploading-text').val());
                progress_bar_box.find('.progress-bar-percentage').css('color', 'black');
                progress_bar.css('width', '0%');
            }
            
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            container.find('.thread-add-error').html(error);
            container.find('.thread-add-error-container').removeClass('none');
    
            button.removeClass('disabled-typical-button-style');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');

            $('#subject').attr('disabled', false);
            $threadcontent.setOption('readOnly', false);
            
            scroll_to_element('thread-add-wrapper', -200);
            announcement_add_lock = true;
        }
    });
})
