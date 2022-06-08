

let uprms = new URLSearchParams(window.location.search);

if(uprms.has('type')) {
    if(uprms.get('type') == 'poll') {
        let thread_add_container = $('#thread-add-wrapper');
        thread_add_container.find('.thread-type-value').val('poll');
        thread_add_container.find('#thread-add-discussion').addClass('none');
        thread_add_container.find('#thread-add-poll').removeClass('none');

        thread_add_container.find('.tap-discussion').attr('style', '');
        thread_add_container.find('.tap-poll').attr('style', 'background-color: #dfdfdf; cursor: default;');

        let selected_icon_path = thread_add_container.find('.tap-poll .selected-icon-path').val();
        let status_ico = thread_add_container.find('.thread-add-type-icon');
        status_ico.find('path').attr('d', selected_icon_path);
    }
}

/**
 * When user clicks on display thread add button to add a thread (post) we have to perform the following steps
 *      *: If the viewer is already fetched, we simply display it (by removing none class) and stop the flow
 *      1. Display the global viewer
 *      2. We send a request to fetch thread add component - meanwhile we start loading section
 *      3. once thread add component get fetched, we have to handle all the events
 */
let thread_add_viewer_bootstrapped = false;
$('.display-thread-add-viewer').on('click', function() {
    let viewer = $('#thread-add-viewer');
    viewer.removeClass('none');
    disable_page_scroll();
    // *
    if(thread_add_viewer_bootstrapped) return;
    
    // 1
    let thread_add_content = viewer.find('.global-viewer-content');
    viewer.find('.loading-spinner').addClass('inf-rotate');
    viewer.animate({
        opacity: 1
    }, 200, function() { // 2
        $.ajax({
            url: '/thread/add/component/fetch',
            type: 'get',
            success: function(response) {
                thread_add_content.html(response);
                // 3
                handle_element_suboption_containers(thread_add_content);
                handle_section_suboptions_hinding(thread_add_content);
                handle_component_nested_soc(thread_add_content);
                handle_thread_add_forum_switch(thread_add_content);
                handle_thread_add_category_switch(thread_add_content);
                handle_thread_add_type_change(thread_add_content.find('.thread-add-type-change'));
                handle_thread_add_visibility_change(thread_add_content.find('.thread-add-visibility'));
                handle_thread_medias_upload(thread_add_content);
                handle_thread_add_media_closing(thread_add_content);
                handle_custom_radio(thread_add_content);
                handle_custom_checkbox(thread_add_content);
                // Poll events
                handle_container_dynamic_inputs(thread_add_content);
                handle_container_options_key_up(thread_add_content);
                handle_poll_option_delete(thread_add_content);
                handle_poll_option_add(thread_add_content.find('.poll-add-option'));
                handle_thread_add_share(thread_add_content.find('.thread-add-share'));
                handle_toggling(thread_add_content);
                
                thread_add_content.find('textarea').each(function() {
                    let simplemde = new SimpleMDE({
                        element: this,
                        hideIcons: ["guide", "heading", "image"],
                        spellChecker: false,
                        mode: 'markdown',
                        showMarkdownLineBreaks: true,
                    });
                });
            },
        })
        thread_add_viewer_bootstrapped = true;
    });
});

// ---------------- THREAD ADD EMBBED MEDIA SHARING ----------------
let thread_add_lock = true;
handle_thread_add_share($('.thread-add-share'));
function handle_thread_add_share(button) {
    button.on('click', function(event) {
        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let successmessage = button.find('.success-message').val();
        
        let container = $('#thread-add-wrapper');
        let threadtype = $('#thread-add-wrapper .thread-type-value').val(); // discussion or poll

        let form_data = new FormData();
        form_data.append('_token', csrf);
        form_data.append('subject', $('#subject').val());
        form_data.append('replies_off', $('#disable-replies').val());
        form_data.append('category_id', $('.category').val());
        form_data.append('visibility_slug', $('.thread-add-visibility-slug').val());
        form_data.append('type', threadtype);
        
        if(form_data.get('subject') == '') {
            $('#subject').parent().find('.error').removeClass('none');
            container.find('.thread-add-error').text($('#subject').parent().find('.required-text').val());
            container.find('.thread-add-error-container').removeClass('none');
            move_element_by_id('thread-add-wrapper');
            scroll_to_element('thread-add-wrapper', -60);
            return;
        } else {
            $('#subject').parent().find('.error').addClass('none');
            container.find('.thread-add-error').text("");
            container.find('.thread-add-error-container').addClass('none');
        }
        let has_upload = false;
      
        const $threadcontent = $('.thread-add-container #content').nextAll('.CodeMirror')[0].CodeMirror;
        switch(threadtype) {
            case 'discussion':
                // Append thread content to the thread in case the user keep it as discussion
                form_data.append('content' ,$threadcontent.getValue());
      
                if(form_data.get('content') == '') {
                    $('#content').parent().find('.error').removeClass('none');
                    container.find('.thread-add-error').text($('#content').parent().find('.required-text').val());
                    container.find('.thread-add-error-container').removeClass('none');
                    scroll_to_element('thread-add-wrapper', -60);
                    return;
                } else {
                    $('#content').parent().find('.error').addClass('none');
                    container.find('.thread-add-error-container').addClass('none');
                }
                // ---------------- WE CHECK FOR MEDIAS ONLY IN DISCUSSION TYPE ----------------
                // Checking images existence in the thread
                /**
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
                // Here the user choose a poll se we have to append the thread type
                // The validation in the serverside of the content is : only required if the user choose discussion type
                // But in db level the content is required for that reason we're going to add two dashes as content just to fulfil the validation
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
                    scroll_to_element('thread-add-wrapper', -60);
                    optionsvalues = [];
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
      
        button.addClass('disabled-typical-button-style');
        spinner.removeClass('opacity0');
        spinner.addClass('inf-rotate');
        buttonicon.addClass('none');

        if(!thread_add_lock) return;
        thread_add_lock = false;

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
            url: '/thread',
            type: 'post',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: form_data,
            success: function(response) {
                if($('#threads-global-container').length) {
                    let thread_id = response.id;
                    $.ajax({
                        url: `/threads/${response.id}/component/generate`,
                        type: 'get',
                        success: function(thread) {
                            if(threadtype == 'discussion') {
                                $('.thread-add-uploaded-media').slice(1).remove();
                                // Clear thread add component inputs
                                $('.uploaded-images-counter').val('0');
                                $('.uploaded-videos-counter').val('0');
      
                                $threadcontent.setOption('readOnly', false);
                                $threadcontent.getDoc().setValue("");
                                $('#thread-photos').val('');
                                $('#thread-videos').val('');
                                uploaded_thread_images_assets = [];
                                uploaded_thread_videos_assets = [];
                                uploaded_thread_media_counter = 0;
      
                                if(has_upload) {
                                    let progress_bar_box = container.find('.progress-bar-box');
                                    let progress_bar = progress_bar_box.find('.progress-bar');
                    
                                    progress_bar_box.addClass('none');
                                    progress_bar_box.find('.text-above-progress-bar').text(progress_bar_box.find('.uploading-text').val());
                                    progress_bar_box.find('.progress-bar-percentage').css('color', 'black');
                                    progress_bar.css('width', '0%');
                                }
                            } else if(threadtype == 'poll') {
                                $('#thread-add-poll-options-box .thread-poll-option-container').each(function() {
                                    let option_input = $(this).find('.poll-option-value');
                                    option_input.attr('disabled', false);
                                    option_input.val('');
                                    option_input.trigger('focus');
                                });
                                $('body').trigger('click');
                            }
      
                            $('#subject').attr('disabled', false);
                            $('#subject').val('');
                            
                            $('.close-global-viewer').trigger('click');
                            $('#threads-global-container').prepend(thread);
      
                            let unhandled_thread = $('#threads-global-container').find('.thread-container-box').first();
                            $('.thread-container-box').attr('style', '');
                            unhandled_thread.attr('style', 'box-shadow: 0px 0px 12px 0px #8e9ea6; margin-bottom: 8px;');
                            force_lazy_load(unhandled_thread);
                            handle_thread_events(unhandled_thread);
                            handle_document_suboptions_hiding();
                            // Scroll to the appended thread - first scroll to thread - then scroll -60px(-60 because of absolute header)
                            $('#thread'+thread_id)[0].scrollIntoView(true);
                            $(window).scrollTop($(window).scrollTop() - 60);

                            basic_notification_show(successmessage);
                        },
                        complete: function() {
                            button.removeClass('disabled-typical-button-style');
                            spinner.addClass('opacity0');
                            spinner.removeClass('inf-rotate');
                            buttonicon.removeClass('none');
                        }
                    })
                } else
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
                container.find('.thread-add-error-container').removeClass('none');
                container.find('.thread-add-error').html(error);
      
                $('#subject').attr('disabled', false);
                if(threadtype == 'discussion') {
                    $threadcontent.setOption('readOnly', false);
                } else if(threadtype == 'poll') {
                    $('#thread-add-poll-options-box .thread-poll-option-container').each(function() {
                        $(this).find('.poll-option-value').attr('disabled', false);
                    })
                }
      
                button.removeClass('disabled-typical-button-style');
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
                buttonicon.removeClass('none');
      
                $('#thread-add-wrapper')[0].scrollIntoView(true);
            },
            complete: function() {
                thread_add_lock = true;
            }
        });
    });
}

// The following three variables will be used in edit thread (look at /thread/edit.js)
let already_uploaded_thread_images_assets = [];
let already_uploaded_thread_videos_assets = [];
let edit_deleted_medias = [];

let uploaded_thread_images_assets = [];
let uploaded_thread_videos_assets = [];
let uploaded_thread_media_counter = 0;
// This will track image uploads --- [Now it is possible to share more than one image] ---
handle_thread_medias_upload($('#app'));

function handle_thread_medias_upload(thread_add_component) {
    thread_add_component.find('#thread-photos').on('change', function(event) {
        // First we close the error if it is opened
        $('.thread-add-media-error p').addClass('none');
        /**
         * IMPORTANT: Because this is input file, if it gets clicked two times a row, then it will remove all the first files and
         * replace them with the new files so we will handle the situation where we upload more than one file; then we put them in an array;
         * then later if the user want to add more image or video; we'll take that addition and append it to the array(uploaded_thread_assets)
         * First we get the container and store it in a variable, then we loop through files and assign each one to the container and append
         * it to the post container to show it to the user
         */

        /**
         * First get the new uploaded files and passed them to validation function.
         * Images type validation function get the files, verify their types and then return an array of validated images
         * If the length of the returned array matches the length of original array of files; that means all files are validated :)
         * If not display the 
         */
        let media_container = $(this);
        while(!media_container.hasClass('thread-add-media-section')) {
            media_container = media_container.parent();    
        }

        let images = event.originalEvent.target.files;
        let validated_images = validate_image_file_Type(images);

        // First we check if all images passes image type by comparing uploaded images with validated images lengths
        if(images.length != validated_images.length) {
            /**
             * Print error: Only jpeg, png .. are supported
             * (tame: thread add media error)
             */
            media_container.find('.tame-image-type').removeClass('none');
        } else {
            media_container.find('.tame-image-type').addClass('none');
            media_container.find('.tame-video-type').addClass('none');
        }

        /** 
         * then we check the limit of uploaded images 
         * Notice: already uploaded videos and images is useful in edit page where the user has already upload images
         * we place those uploaded medias in separate arrays and then we check if the global number of medias is passable
         * ex: If user already uploaded 5 images, and then later he want to edit the thread by adding
         * 18 images, here we have to check if 18 + 5 < 20; If so then OK
         * Otherwise: we have to take only 15 from 18
         */
        if(validated_images.length + uploaded_thread_images_assets.length > 20
            || validated_images.length + uploaded_thread_images_assets.length + already_uploaded_thread_images_assets.length > 20) {
            media_container.find('.tame-image-limit').removeClass('none');
            validated_images = validated_images.slice(0, 20-(uploaded_thread_images_assets.length+already_uploaded_thread_images_assets.length));
        }
        
        images = validated_images;
        for(let i=0;i<images.length;i++) {
            /**
             * Here instead of pushing only the file to the array we have to pass also the counter (used to preserve the order) 
             * of uploaded file and then increment it
             */
            uploaded_thread_images_assets.push([uploaded_thread_media_counter, images[i]]);
            uploaded_thread_media_counter++;
        }
        /**
         * Now we loop through the new files and append them to thread-add-uploaded-medias-container by cloning 
         * thread-add-uploaded-media-projection-model container
         * About the other validations like file size we're gonna implement them in the backend
         */
        for (let i = 0; i < images.length; i++) {
            let clone = $('.thread-add-uploaded-media-projection-model').clone(true);
            $('.thread-add-uploaded-medias-container').append(clone);

            // Increment uploaded images index
            let upload_images_index = $('.thread-add-uploaded-medias-container').find('.uploaded-images-counter');
            let images_counter = parseInt(upload_images_index.val()) + 1;
            upload_images_index.val(images_counter);

            let global_medias_count = images_counter
            + already_uploaded_thread_images_assets.length
            + already_uploaded_thread_videos_assets.length
            + parseInt($('.thread-add-uploaded-medias-container').find('.uploaded-videos-counter').val());

            // We get the last uploaded image container
            let last_uploaded_image = $(".thread-add-uploaded-medias-container .thread-add-uploaded-media").last();
            last_uploaded_image.find('.uploaded-media-index').val(images_counter-1); // we want 0 based indexes here
            last_uploaded_image.find('.uploaded-media-genre').val('image'); // this is useful when close button is pressed in order for us to know from where we should delete the uploaded file(either from videos array container/image array container)

            last_uploaded_image.removeClass('none thread-add-uploaded-media-projection-model');

            // Scroll to the end position of x axe
            let c = $('.thread-add-uploaded-medias-container');
            c[0].scrollLeft = c[0].scrollWidth;

            let img = last_uploaded_image.find(".thread-add-uploaded-image");
            img.removeClass('none');

            // Preview the image
            load_image(images[i], img);
        }

        // Clear the input because we don't need its value; we use arrays to store files
        $(this).val('');
    });
    thread_add_component.find('#thread-videos').on('change', function(event) {
        // First we close the error if it is opened
        $('.thread-add-media-error p').addClass('none');
        /**
         * IMPORTANT: see notices inside thread-image change event handler above
         */
        let media_container = $(this);
        while(!media_container.hasClass('thread-add-media-section')) {
            media_container = media_container.parent();    
        }

        let videos = event.originalEvent.target.files;
        let validated_videos = validate_video_file_Type(videos);

        if(videos.length != validated_videos.length) {
            media_container.find('.tame-video-type').removeClass('none');
        } else {
            media_container.find('.tame-video-type').addClass('none');
            media_container.find('.tame-image-type').addClass('none');
        }

        videos = validated_videos;

        /** First let's limit the number of uploaded files */
        if(videos.length + uploaded_thread_videos_assets.length > 4 
            || videos.length + uploaded_thread_videos_assets.length + already_uploaded_thread_videos_assets.length > 4) {
            videos = videos.slice(0, 4-(uploaded_thread_videos_assets.length+already_uploaded_thread_videos_assets.length));
            media_container.find('.tame-video-limit').removeClass('none');
        } else {
            media_container.find('.tame-video-limit').addClass('none');
        }

        for(let i=0;i<videos.length;i++) {
            uploaded_thread_videos_assets.push([uploaded_thread_media_counter, videos[i]]);
            uploaded_thread_media_counter++;
        }

        for (let i = 0; i < videos.length; i++) {
            let clone = $('.thread-add-uploaded-media-projection-model').clone(true);
            $('.thread-add-uploaded-medias-container').append(clone);
            // Increment the index
            let upload_videos_index = $('.thread-add-uploaded-medias-container').find('.uploaded-videos-counter');
            let videos_counter = parseInt(upload_videos_index.val()) + 1;
            upload_videos_index.val(videos_counter);
            
            let global_medias_count = videos_counter
                + already_uploaded_thread_images_assets.length
                + already_uploaded_thread_videos_assets.length
                + parseInt($('.thread-add-uploaded-medias-container').find('.uploaded-images-counter').val());
            
            // We get the last uploaded video container
            let last_uploaded_video = $(".thread-add-uploaded-medias-container .thread-add-uploaded-media").last();
            last_uploaded_video.find('.uploaded-media-index').val(videos_counter-1); // we want 0 based indexes here
            last_uploaded_video.find('.uploaded-media-genre').val('video'); // this is useful when close button is pressed in order for us to know from where we should delete the uploaded file(either from videos array container/image array container)
            
            last_uploaded_video.find('.thread-add-video-indicator').removeClass('none');

            last_uploaded_video.removeClass('none thread-add-uploaded-media-projection-model');

            // Scroll to the end position of x axe
            let c = $('.thread-add-uploaded-medias-container');
            c[0].scrollLeft = c[0].scrollWidth;

            
            // Preview the image (here image should be a snapshot from the video uploaded)
            let img = last_uploaded_video.find(".thread-add-uploaded-image");
            img.removeClass('none');
            try {
                // get the frame at 1.5 seconds of the video file
                get_thumbnail(videos[i], 1.5, img.parent()).then(value => {
                    img.attr("src", value);
                    handle_image_dimensions(img);
                });
            } catch(e) {
                
            }
        }

        // Clear the input because we don't need its value; we use arrays to store files
        $(this).val('');
    });
}

handle_thread_add_media_closing($('#app'));
function handle_thread_add_media_closing(container) {
    container.find('.thread-add-uploaded-media').each(function() {
        handle_close_uploaded_media($(this));
    });
}
function handle_close_uploaded_media(container) {
  container.find('.close-thread-media-upload').on('click', function() {
      // First we close the error if it is opened
      $('.thread-add-media-error p').addClass('none');
      /**
       * Before deleting the component we need the whole components container to decrement the 
       * global upload media counter and the genre of the component whether it's an image or video
       */
      let container = $(this);
      while(!container.hasClass('thread-add-uploaded-medias-container')) {
          container = container.parent();
      }
      let component_genre = $(this).parent().find('.uploaded-media-genre').val();
      let index_to_remove = $(this).parent().find('.uploaded-media-index').val();

      // Then we have to know the genre of component(image/video) in rorder to delete it from the array container type
      if(component_genre == 'image') {
          // decrement the uploaded images counter
          let global_images_counter = container.find('.uploaded-images-counter');
          global_images_counter.val(parseInt(global_images_counter.val()) - 1);

          uploaded_thread_images_assets.splice(index_to_remove, 1);
      } else if(component_genre == 'video') {
          // decrement the uploaded videos counter
          let global_videos_counter = container.find('.uploaded-videos-counter');
          global_videos_counter.val(parseInt(global_videos_counter.val()) - 1);
          
          uploaded_thread_videos_assets.splice(index_to_remove, 1);
      }

      // Then we need to remove the component
      $(this).parent().remove();

      // After removeing the component we need to adjust indexes
      adjust_uploaded_medias_indexes();
  })
}
function adjust_uploaded_medias_indexes() {
  let images_count = 0;
  let videos_count = 0;
  $('.thread-add-uploaded-media').each(function() {
      if($(this).find('.uploaded-media-genre').val() == 'image') {
          $(this).find('.uploaded-media-index').val(images_count);
          images_count++;
      } else if($(this).find('.uploaded-media-genre').val() == 'video') {
          $(this).find('.uploaded-media-index').val(videos_count);
          videos_count++;
      }
  });
}

$('.close-thread-media-upload-edit').on('click', function() {
  // First we close the error if it is opened
  $('.thread-add-media-error p').addClass('none');

  edit_deleted_medias.push($(this).parent().find('.uploaded-media-url').val());

  $(this).parent().remove();
});

$('.thread-add-container textarea').each(function() {
    let simplemde = new SimpleMDE({
        hideIcons: ["guide", "heading", "image"],
        spellChecker: false,
        mode: 'markdown',
        showMarkdownLineBreaks: true,
    });
});

$('.thread-poll-option-container').each(function() {
    handle_input_with_dynamic_label($(this));
    handle_poll_option_delete($(this));
});
function handle_poll_option_delete(option) {
    option.find('.remove-poll-option').on('click', function() {
        // verify if there are only 2 poll options inputs there; If so we prevent the deletion
        if($('#thread-add-poll-options-box .thread-poll-option-container').length == 2) return;

        let option_container = $(this);
        while(!option_container.hasClass('thread-poll-option-container')) {
            option_container = option_container.parent();
        }
        let deleted_index = parseInt(option_container.find('.ta-option-index').text())-1;

        // Adjusting indexes of options' labels (Option n) that come after the deleted option
        $('#thread-add-poll-options-box .thread-poll-option-container').each(function(index) {
            if(index >= deleted_index) {
                $(this).find('.ta-option-index').text(parseInt($(this).find('.ta-option-index').text())-1);
            }
        });

        option_container.remove();
    });
}

handle_poll_option_add($('#thread-add-wrapper').find('.poll-add-option'));
function handle_poll_option_add(button) {
    button.on('click', function() {
        let existing_options_length = $('#thread-add-poll-options-box .thread-poll-option-container').length;
        if(existing_options_length < 30) { // Allow only 30 option
            let newoption = $('.thread-add-poll-option-factory').clone();
            newoption.removeClass('thread-add-poll-option-factory none');
            newoption.find('.ta-option-index').text(existing_options_length+1);
            // Append option
            $('#thread-add-poll-options-box').append(newoption);
            // Handle events
            handle_input_with_dynamic_label(newoption.find('.dynamic-input-wrapper'));
            handle_poll_option_delete(newoption);
            handle_poll_option_keyup(newoption.find('.poll-option-validation'));

            $('#thread-add-poll-options-box').scrollTop(function() { return this.scrollHeight; });
        } else {
            let limit_error = $('#options-length-limit-error').val();
            display_top_informer_message(limit_error, 'warning');
        }
    });
}

handle_thread_add_forum_switch($('#thread-add-wrapper'));
let thread_add_forum_lock = true;
function handle_thread_add_forum_switch(component) {
    component.find('.thread-add-select-forum').each(function() {
        $(this).on('click', function() {
            if(!thread_add_forum_lock) return;
            thread_add_forum_lock = false;
        
            let button = $(this);
            let spinner = button.find('.spinner');
            let buttonicon = button.find('.icon-above-spinner');
        
            spinner.addClass('inf-rotate');
            spinner.removeClass('opacity0');
            buttonicon.addClass('none');
            button.css('cursor', 'default');

            let thread_add_container = button;
            while(!thread_add_container.hasClass('thread-add-container')) {
                thread_add_container = thread_add_container.parent();
            }
        
            let forum_id = button.find('.forum-id').val();
        
            $.ajax({
                url: `/forums/${forum_id}/categories`,
                type: 'get',
                success: function(response) {
                    // First change the icon
                    $('.thread-add-forum-icon').html(button.find('.forum-ico').html());
        
                    let categories = JSON.parse(response);
                    $('.thread-add-categories-container').html('');
                    let selected_category_set = false;
                    $.each(categories, function(id, category){
                        let component = $('.thread-add-category-skeleton').clone();

                        if(!selected_category_set && category.status.slug == 'live') {
                            component.addClass('selected-category');
                            $('.thread-add-selected-category').text(category.category);
                            thread_add_container.find('.category').val(category.id);
                            selected_category_set = true;
                        }

                        component.find('.category-name').text(category.category);
                        component.find('.category-id').val(category.id);
                        component.find('.category-status').text(category.status.status);
                        
                        if(category.status.slug == 'closed') {
                            component.find('.category-status').addClass('red');
                            component.find('.status-section').removeClass('none');
                            
                            component.removeClass('thread-add-select-category');
                            component.addClass('stop-propagation');
                            component.css('cursor', 'not-allowed');
                        }

                        component.removeClass('thread-add-category-skeleton none');
                        $('.thread-add-categories-container').append(component);
                    });
                    handle_thread_add_category_switch($('#thread-add-wrapper'));
                },
                error: function() {
                    
                },
                complete: function() {
                    button.css('cursor', 'pointer');
                    spinner.addClass('opacity0');
                    spinner.removeClass('inf-rotate');
                    buttonicon.removeClass('none');

                    // Set forum id to global forum id that will be used as forum_id when storing
                    thread_add_container.find('.forum').val(forum_id);
        
                    // setting forum to posted to:
                    $('.thread-add-selected-forum').text(button.find('.thread-add-forum-val').text());
                    // Hide the suboptions container
                    $('.thread-add-select-forum').removeClass('thread-add-suboption-selected');
                    
                    button.addClass('thread-add-suboption-selected');
                    button.parent().css('display', 'none');
                    thread_add_forum_lock = true;
                }
            })
        })
    })
}
handle_thread_add_category_switch($('#thread-add-wrapper'));
function handle_thread_add_category_switch(component) {
    component.find('.thread-add-select-category').each(function() {
        $(this).on('click', function(event) {
            let category_button = $(this);
            event.stopPropagation();
            $(".thread-add-selected-category").text(category_button.find('.category-name').text());
    
            $('.thread-add-select-category').removeClass('selected-category');
            category_button.addClass('selected-category');
            
            let container = category_button;
            while(!container.hasClass('thread-add-container')) {
                container = container.parent();
            }
            container.find('.category').val(category_button.find('.category-id').val());
    
            $(this).parent().parent().css('display', 'none');
        })        
    });
}
handle_thread_add_type_change($('.thread-add-type-change'));
function handle_thread_add_type_change(button) {
    button.on('click', function(event) {
        event.stopPropagation();

        let container = $(this);
        while(!container.hasClass('thread-add-container')) {
            container = container.parent();
        }
    
        let selected_thread_type_name = $(this).find('.thread-type-name').val();
        let selected_thread_type = $(this).find('.thread-type').val();
        container.find('.thread-type-value').val(selected_thread_type)
        $('#thread-add-type-selected-name').text(selected_thread_type_name);
    
        let selected_icon_path = $(this).find('.selected-icon-path').val();
        let status_ico = container.find('.thread-add-type-icon');
        status_ico.find('path').attr('d', selected_icon_path);
    
        switch(selected_thread_type) {
            case 'discussion':
                container.find('#thread-add-discussion').removeClass('none');
                container.find('#thread-add-poll').addClass('none');
                break;
            case 'poll':
                container.find('#thread-add-discussion').addClass('none');
                container.find('#thread-add-poll').removeClass('none');
                break;
        }
        $('.thread-add-type-change').attr('style', '');
        $(this).attr('style', 'background-color: #dfdfdf; cursor: default;');
    
        // Hide errors
        $('.thread-add-error-container').addClass('none');
        $('#thread-add-wrapper .asterisk-error').addClass('none');
    
        $(this).parent().css('display', 'none');
    });
}
handle_thread_add_visibility_change($('.thread-add-visibility'));
function handle_thread_add_visibility_change(button) {
    button.on('click', function(event) {
        event.stopPropagation();

        let container = $(this);
        while(!container.hasClass('thread-add-container')) {
            container = container.parent();
        }

        container.find('.thread-add-visibility-slug').val($(this).find('.thread-visibility').val());
        $('#thread-add-visibility-selected-name').text($(this).find('.thread-visibility-name').val());
        let selected_icon_path = $(this).find('.selected-icon-path').val();
        let status_ico = container.find('.thread-add-visibility-icon');

        status_ico.find('path').attr('d', selected_icon_path);

        $(this).parent().css('display', 'none');
    });
}
function handle_container_options_key_up(container) {
    container.find('.poll-option-validation').each(function() {
        handle_poll_option_keyup($(this));
    });
}