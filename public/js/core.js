// SELF-XSS warning
const warningTitleCSS = 'color:red; font-size:50px; font-weight: bold; -webkit-text-stroke: 1px black;';
const warningDescCSS = 'font-size: 14px;';
console.log('%cWARNING', warningTitleCSS);
console.log("%cThis is a browser feature intended for developers. If someone told you to copy and paste something here to enable a feature or 'hack' someone's account, it is a scam and will give them access to your gladiator account.", warningDescCSS);
console.log('%cSee https://en.wikipedia.org/wiki/Self-XSS for more information.', warningDescCSS);

var userId = $('#current-auth-user-id').val();
let csrf = document.querySelector('meta[name="csrf-token"]').content;
let urlParams = new URLSearchParams(window.location.search);

Array.prototype.contains = function(element){
    return this.indexOf(element) > -1;
};

jQuery.fn.rotate = function(degrees) {
    $(this).css({   
        '-webkit-transform' : 'rotate('+ degrees +'deg)',
        '-moz-transform' : 'rotate('+ degrees +'deg)',
        '-ms-transform' : 'rotate('+ degrees +'deg)',
        'transform' : 'rotate('+ degrees +'deg)',
    });
    return $(this);
};

function array_elements_unique(array) {
    return (new Set(array)).size === array.length;
}

function disable_page_scroll() {
    $('body').attr('style', 'overflow-y: hidden;');
}
function enable_page_scroll() {
    $('body').attr('style', '');
}

$(window).on('unload', function() {
    $(window).scrollTop(0);
 });

/**
 * Update user activity in every page (because this js file is included in every page) and update the user
 * activity every 2 seconds if the user doesn't change the page
 */
if(userId) { // Disable this for debugging purposes (and also in developement phase) and it will only uncommented in production
    update_user_last_activity();
    setInterval(function() {
        update_user_last_activity();
    }, 120000);
}

function update_user_last_activity() {
    $.ajax({
        type: 'get',
        url: '/user/update_last_activity',
    });
}

$('.html-entities-decode').each(function() {
    handleElementHtmlEntitiesDecode($(this));
});

function handle_html_entities_decoding(container) {
    if(container.hasClass('html-entities-decode'))
        handleElementHtmlEntitiesDecode($(this));

    container.find('.html-entities-decode').each(function() {
        handleElementHtmlEntitiesDecode($(this));
    });
}

function handleElementHtmlEntitiesDecode(element) {
    let value="";
    if(element.is('input')) {
        value = element.val();
        element.val($('<textarea />').html(value).text());
    } else {
        value = element.text();
        element.text($('<textarea />').html(value).text());
    }
}

setTimeout(() => {
    let cookies_accepted = getCookie('cookies_accepted');

    if(cookies_accepted == null) {
        $('.cookie-notice-box').removeClass('none');
        $('.cookie-notice-box').animate({
            opacity: 1
        }, 400);
    }
}, 60000);

$('.close-cookie-notice-and-save').on('click', function() {
    let container = $(this);
    while(!container.hasClass('cookie-notice-box')) {
        container = container.parent();
    }

    setCookie('cookies_accepted', 1, 365);

    $('.cookie-notice-box').animate({
        opacity: 0
    }, 400, function() {
        $('.cookie-notice-box').addClass('none');
    });
});

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/;secure";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function checkRtl(character) {
    var RTL = ['ا','ب','پ','ت','س','ج','چ','ح','خ','د','ذ','ر','ز','ژ','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ک','گ','ل','م','ن','و','ه','ی'];
    return RTL.indexOf( character ) > -1;
};

function handle_thread_rtl(thread) {
    thread.find('.thread-title-text, .thread-content').each(function() {
        if(checkRtl($(this).text()[0]) ) {
            $(this).addClass('rtl');
        }
    });
}

$('.button-with-strip').on({
    mouseenter: function() {
        $(this).find('.menu-botton-bottm-strip').css('display', 'block');
    },
    mouseleave: function() {
        $(this).find('.menu-botton-bottm-strip').css('display', 'none');
    }
})

$('.stop-propagation').on('click', function(event) {
    event.stopPropagation();
});

function handle_stop_propagation(component) {
    component.find('.stop-propagation').each(function() {
        $(this).on('click', function(event) {
            event.stopPropagation();
        })
    });
}

$('.block-click').on('click', function() {
    return false;
});

$('.x-close-container').on('click', function(event) {
    $(this).parent().addClass('none');

    event.stopPropagation();
    event.preventDefault();
});

$('.handle-image-center-positioning').each(function() {
    let image = $(this);
    $(this).parent().imagesLoaded(function() {
        handle_image_dimensions(image);
    });
});
function handle_image_dimensions(image) {
    width = image.width();
    height = image.height();
    if(width > height) {
        image.height('100%');
        image.css('width', 'max-content');
    } else if(width < height) {
        image.width('100%');
        image.css('height', 'max-content');
    } else {
        image.width('100%');
        image.height('100%');
    }
}
function handle_portrait_image_dimensions(image, container) {
    let width = image.width();
    let height = image.height();
    let c_max_width = parseInt(container.css('max-width').replace('px',''));
    let c_max_height = parseInt(container.css('max-height').replace('px',''));

    if(width >= height) {
        image.width(c_max_width);
        if(image.height() > c_max_height) {
            let ih = image.height();
            while(ih > c_max_height) {
                ih--;
                image.height(ih);
            }
        }
    } else {
        image.height(c_max_height);
        if(image.width() > c_max_width) {
            let iw = image.width();
            while(iw > c_max_width) {
                iw--;
                image.height(iw);
            }
        }
    }
}
function handle_complexe_image_dimensions(image) {
    let image_container = image.parent();

    width = image.width();
    height = image.height();
    if(width >= height) {
        image.height(image_container.height());
    } else {
        image.width(image_container.width());
    }
}

function handle_component_images_center(component) {
    component.imagesLoaded(function() {
        component.find('.handle-image-center-positioning').each(function() {
            handle_image_dimensions($(this));
        });
    });
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

$(".button-with-suboptions").each(function() {
    handle_suboptions_container($(this));
});
$(".nested-soc-button").each(function() {
    handle_nested_soc($(this));
});
$('.notification-menu-button').each(function() {
    handle_notification_menu_buttons($(this));
})
$('.notification-container').each(function() {
    handle_notification_menu_appearence($(this));
});

function handle_suboptions_container(button) {
    button.on({
        'click': function(event) {
            let container = $(this).parent().find(".suboptions-container").first();
            container.on('click', function(e) { e.stopPropagation(); })
            if(container.css("display") == "none") {
                $(".suboptions-container").css("display", "none");
                $(".nested-soc").css("display", "none");
                container.css("display", "block");
            } else {
                container.css("display", "none");
            }
            return false;
        }
    });
}

function handle_component_nested_soc(component) {
    component.find('.nested-soc-button').each(function() {
        handle_nested_soc($(this));
    });
}

function handle_nested_soc(button) {
    // nested-soc: nested suboptions container
    button.on('click', function() {
        // Handle only the third level of suboptions, later we're gonna handle infinite number of suboptions level

        if(button.parent().find('.nested-soc').css('display') == 'block') {
            button.parent().find('.nested-soc').css('display', 'none');
            return;
        }
        $('.nested-soc').css('display', 'none');
        button.parent().find('.nested-soc').css('display', 'block');
        return false;
    });
}

function handle_notification_menu_buttons(button) {
    button.on('click', function(event) {
        $('.notification-menu-button-container').addClass('none');
        button.parent().removeClass('none');
    })
}

function handle_notification_menu_appearence(notification_container) {
    notification_container.on({
        mouseenter: function() {
            $(this).find('.notification-menu-button-container').removeClass('none');
        },
        mouseleave: function() {
            if($(this).find('.nested-soc').css('display') == 'none') {
                $(this).find('.notification-menu-button-container').addClass('none');
            }
        }
    });
}

function handle_element_suboption_containers(container) {
    if(!container.hasClass('button-with-suboptions')) {
        container.find('.button-with-suboptions').each(function() {
            handle_suboptions_container($(this));
        })
    } else {
        handle_suboptions_container(container);
    }
}

function handle_component_subcontainers(component) {
    component.find('.button-with-suboptions').each(function() {
        handle_suboptions_container($(this));
        let container = $(this).parent().find(".suboptions-container").first();
        container.on('click', function(event) {
            event.stopPropagation();
        });
    });

    if(component.hasClass('button-with-suboptions'))
        handle_suboptions_container(component);
}

document.addEventListener("click", function(event) {
    $(".suboptions-container").css("display", "none");
}, false);

handle_document_suboptions_hiding();
function handle_document_suboptions_hiding() {
    let subContainers = document.querySelectorAll('.suboptions-container');
    for(let i = 0;i<subContainers.length;i++) {
        subContainers[i].addEventListener("click", function(evt) {
            $(this).css("display", "block");
            $(".nested-soc").css("display", "none");
            evt.stopPropagation();
        }, false);
    }
}

function handle_section_suboptions_hinding(section) {
    section.find('.suboptions-container').each(function() {
        $(this).on('click', function(event) {
            event.stopPropagation();
        });
    });
}

$('.close-shadowed-view-button').on('click', function() {
    let shadowed_container = $(this);

    while(!shadowed_container.hasClass('full-shadowed')) {
        shadowed_container = shadowed_container.parent();
    }

    shadowed_container.css('opacity', '0');
    shadowed_container.css('display', 'none');

    $('.suboptions-container').css('display', 'none');

    return false;
});

function handle_expend(component) {
    component.find('.expand-button').each(function() {
        $(this).on('click', function() {
            let button = $(this);
            let status = button.parent().find('.expand-text-state');
            
            let textcontainer = button.parent().find('.expandable-text');
            let whole_text = button.parent().find('.expand-whole-text').val();
            let slice_text = button.parent().find('.expand-slice-text').val();
            
            let see_all = button.parent().find('.expand-text').val();
            let see_less = button.parent().find('.collapse-text').val();

            if(status.val() == "0") {
                textcontainer.text(whole_text);
                button.text(see_less);
                status.val('1');
            } else {
                textcontainer.text(slice_text);
                button.text(see_all);
                status.val('0');
            }
        });
    })
}

function handle_expend_button_appearence(thread) {
    if(!thread.find('.expend-thread-content-button').length) {
        return;
    }
    let thread_content_section = thread.find('.thread-content-section');
    let thread_content_box = thread_content_section.find('.thread-content-box');
    
    let content_full_height = thread_content_box[0].scrollHeight;
    let content_hidden_height = thread_content_box.height();
    
    if(content_full_height != content_hidden_height) {
        thread_content_section.find('.expend-thread-content-button').removeClass('none');

        let expand_state = thread_content_box.find('.expand-state');
        let expand_button = thread_content_section.find('.expend-thread-content-button');
        let expand_arrow = expand_button.find('.expand-arrow path');

        expand_button.on('click', function() {
            let see_less = thread_content_box.find('.expand-button-collapse-text').val();
            let see_more = thread_content_box.find('.expand-button-text').val();
            if(expand_state.val() == "0") {
                thread_content_box.removeClass('thread-content-box-max-height');
                expand_button.find('.btn-text').text(see_less);
                expand_state.val('1');
                expand_arrow.attr('d', expand_button.find('.up-arr').val());
            } else {
                thread_content_box.addClass('thread-content-box-max-height');
                expand_button.find('.btn-text').text(see_more);
                expand_state.val('0');
                expand_arrow.attr('d', expand_button.find('.down-arr').val());
            }
        });
    }

}

function heart_beating() {
    let heart = $('.heart-beating');
    if(heart.height() == 16) {
        heart.css('height', '19px');
        heart.css('width', '19px');
    } else {
        heart.css('height', '16px');
        heart.css('width', '16px');
    }
}
setInterval(heart_beating,500);

$('.login-signin-button').each(function() {
    handle_login_lock($(this).parent());
});
function handle_login_lock(container) {
    container.find('.login-signin-button').each(function() {
        $(this).on('click', function(event) {
            $('#login-viewer').removeClass('none');
            disable_page_scroll();
            
            event.preventDefault();
        });
    });
}

if($('#right-panel').height() > $(window).height()-52) {
    $(document).scroll(function() {
        // > 54 + .. => 54 because height(header) = 52 and the border top and bottom of sidebar is 2px
        if (document.documentElement.scrollTop + $(window).height() > 54 + $('#right-panel').height()) { 
            $('#right-panel').css({
                position: 'fixed',
                bottom: '0',
                top: 'unset'
            });
        } else {
            $('#right-panel').css({
                position: 'absolute',
                top: '0',
                bottom: 'unset'
            });
        }
    });
} else {
    $('#right-panel').css({
        position: 'fixed',
        height: '100%',
        top: '52px',
        bottom: 'unset'
    });
}

$('#left-panel').height($(window).height() - $('header').height() - 30);
$('#quick-access-box').height($(window).height() - $('header').height() - 21); // 1px of border-bottom and 20 to make some space between bottom of viewer and the menu
if($('#thread-media-viewer').length) {
    $('#thread-media-viewer').height($(window).height() - $('header').height());
    handle_viewer_infos_height($('.thread-media-viewer-infos-content'));
}

window.onresize = function(event) {
    $('#left-panel').height($(window).height() - $('header').height() - 30);
    $('#quick-access-box').height($(window).height() - $('header').height() - 21); // 1px of border-bottom and 20 to make some space between bottom of viewer and the menu
    if($('#thread-media-viewer').length) {
        $('#thread-media-viewer').height($(window).height() - $('header').height());
        handle_viewer_infos_height($('.thread-media-viewer-infos-content'));
        handle_viewer_media_logic($("#thread-viewer-media-image"));
    }
};

function handle_viewer_infos_height(infos) {
    infos.height($('#thread-media-viewer').height() - $('.thread-media-viewer-infos-header').height() - 16);
}

$('.reply-to-thread').on('click', function() {
    setTimeout(function(){$('textarea').focus();}, 200);
    
    location.hash = "#reply-site";
    return false;
});

let thread_replies_switch_lock = true;
$('#thread-replies-switcher').on('click', function() {
    if(!thread_replies_switch_lock) return;
    thread_replies_switch_lock = false;

    let button = $(this);
    let buttontext = button.find('.button-text');
    let waittext = button.find('.wait-text').val();
    let spinner = button.find('.spinner');
    let thread_id = button.find('.thread-id').val();
    let action = $('#thread-replies-switch-viewer').find('.action').val();

    buttontext.text(waittext);
    button.addClass('disabled-typical-button-style');
    spinner.addClass('inf-rotate');
    spinner.removeClass('none');

    $.ajax({
        type: 'post',
        url: '/thread/posts/switch',
        data: {
            _token: csrf,
            thread_id: thread_id,
            action: action
        },
        success: function(response) {
            let thread = $('#thread'+thread_id);
            let viewer = $('#thread-replies-switch-viewer');
            let turn_on_label = viewer.find('.turn-on-label').val();
            let turn_off_label = viewer.find('.turn-off-label').val();
            let message;

            if(response.current_replies_state == 'disabled') {
                buttontext.text(turn_on_label);
                thread.find('.open-thread-replies-switch .button-text').text(turn_on_label)
                thread.find('.icon').addClass('turnonreplies17-icon');
                thread.find('.icon').removeClass('turnoffreplies17-icon');
                thread.find('.open-thread-replies-switch .action').val('on');


                message = button.find('.replies-turned-off-message').val();
            } else {
                buttontext.text(turn_off_label);
                thread.find('.open-thread-replies-switch .button-text').text(turn_off_label)
                thread.find('.icon').addClass('turnoffreplies17-icon');
                thread.find('.icon').removeClass('turnonreplies17-icon');
                thread.find('.open-thread-replies-switch .action').val('off');

                message = button.find('.replies-turned-on-message').val();
            }

            basic_notification_show(message);
            $('.close-global-viewer').trigger('click');
            if($('.page').val() == 'thread-show') location.reload(); // Refresh page if user is in thread show page
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
            button.removeClass('disabled-typical-button-style');
            spinner.addClass('none');
            spinner.removeClass('inf-rotate');

            thread_replies_switch_lock = true;
        }
    })
});

$('#category-dropdown').on('change', function() {
    let forum_slug = $('#forum-slug').val();
    let category_slug = $('#category-dropdown').val();
    if(category_slug == 'all') {
        url = '/forums/'+forum_slug;
    } else {
        url = '/forums/'+forum_slug+'/'+category_slug+'/threads';
    }

    document.location.href = url;
});

$('.copy-thread-link').each(function() {
    handle_copy_thread_link($(this));
});
function handle_copy_thread_link(button) {
    button.on('click', function(event) {
        $(this).parent().find('input').trigger('select');
        document.execCommand("copy");
        $(this).parent().parent().css('display', 'none');
        basic_notification_show($(this).find('.copied').val(), 'basic-notification-round-tick');

        event.stopPropagation();
    });
}

$('.resource-container').each(function() {
    handle_thread_visibility_switch($(this));
});
function handle_thread_shadowed_viewers(thread) {
    thread.find('.open-thread-shadowed-viewer').each(function(event) {
        $(this).on('click', function(event) {
            let thread = $(this);
            while(!thread.hasClass('resource-container')) {
                thread = thread.parent();
            }
            
            let viewerclass = $(this).find('.viewer').val();
            thread.find(viewerclass).css('display', 'block');
            thread.find(viewerclass).css('opacity', '1');
            
            thread.find('.suboptions-container').css('display', 'none');
            event.stopPropagation();
        });
    })
}

$('.tooltip-section').each(function() {
    handle_tooltip($(this).parent());
})

function handle_tooltip(component) {
    component.find('.tooltip-section').on({
        'mouseenter': function() {
            $(this).parent().find('.tooltip').css('display', 'block');
        },
        'mouseleave': function() {
            $(this).parent().find('.tooltip').css('display', 'none');
        }
    });
}

// let mouse_over_button_timeout;
// let mouse_over_button_container_timeout;
// let mouse_over_displayer = false;
// let mouse_over_container = false;
let user_card_mouse_states = new Map();
let user_card_mouse_displayer_timeouts = new Map();
let user_card_mouse_container_timeouts = new Map();
/**
 * Here we have to have mouse_over_displayer and mouse_over_container values for each user-card-container
 * To accomplish that we create a map to store
 */
let index = 0;
$('.user-card-container-index').each(function() {
    $(this).val(index);
    user_card_mouse_states.set(index, {
        mouse_over_displayer: false,
        mouse_over_container: false,
    });
    user_card_mouse_displayer_timeouts.set(index, false);
    user_card_mouse_container_timeouts.set(index, false);

    index++;
});

$('.user-profile-card-box').each(function() {
    handle_user_profile_card_displayer($(this));
    handle_fetch_user_card($(this));
});

function handle_thread_user_card_fetch(thread) {
    // Here we have to set up the index because this handler will be attached on ly to the newly appended threads
    thread.find('.user-card-container-index').val(index);
    user_card_mouse_states.set(index, {
        mouse_over_displayer: false,
        mouse_over_container: false,
    });
    user_card_mouse_displayer_timeouts.set(index, false);
    user_card_mouse_container_timeouts.set(index, false);
    index++;
    
    thread.find('.user-profile-card-box').each(function() {
        handle_user_profile_card_displayer($(this));
        handle_fetch_user_card($(this));
    });
}

function handle_user_profile_card_displayer(user_profile_card_box) {
    user_profile_card_box.find('.user-profile-card-displayer').each(function() { 
        let container_index = $(this).parent().find('.user-card-container-index').val();

        $(this).on({
            mouseenter: function() {
                // Mouse is over displayer
                user_card_mouse_states.set(container_index, {
                    mouse_over_displayer: true,
                    mouse_over_container: false,
                });
                let inside_displayer_timeout = setTimeout(function() {
                    user_profile_card_box.find('.user-profile-card').removeClass('none');
                    user_profile_card_box.find('.user-profile-card').animate({
                        opacity: 1
                    }, 400);
                }, 500);
                user_card_mouse_displayer_timeouts.set(container_index, inside_displayer_timeout);
            },
            mouseleave: function() {
                // Mouse is outside displayer
                user_card_mouse_states.set(container_index, {
                    mouse_over_displayer: false,
                    mouse_over_container: false,
                });
                clearTimeout(user_card_mouse_displayer_timeouts.get(container_index));
                let inside_displayer_timeout = setTimeout(function() {
                    if(user_card_mouse_states.get(container_index).mouse_over_displayer || user_card_mouse_states.get(container_index).mouse_over_container) {
                        clearTimeout(inside_displayer_timeout);
                        return false;
                    }
                    user_profile_card_box.find('.user-profile-card').animate({
                        opacity: 0
                    }, 400);
                    user_profile_card_box.find('.user-profile-card').addClass('none');
                }, 500);
            }
        });

        $(this).parent().find('.user-profile-card').on({
            mouseenter: function() {
                // Mouse is over displayer
                user_card_mouse_states.set(container_index, {
                    mouse_over_displayer: false,
                    mouse_over_container: true,
                });
            },
            mouseleave: function() {
                // Mouse is outside displayer
                user_card_mouse_states.set(container_index, {
                    mouse_over_displayer: false,
                    mouse_over_container: false,
                });
                clearTimeout(user_card_mouse_displayer_timeouts.get(container_index));
                let inside_displayer_timeout = setTimeout(function() {
                    if(user_card_mouse_states.get(container_index).mouse_over_displayer) {
                        clearTimeout(inside_displayer_timeout);
                        return false;
                    }
                    user_profile_card_box.find('.user-profile-card').animate({
                        opacity: 0
                    }, 400);
                    user_profile_card_box.find('.user-profile-card').addClass('none');
                }, 500);
            }
        });
    });
}
let fetchings = [];
function handle_fetch_user_card(component) {
    component.find('.fetch-user-card').each(function() {
        let displayer = $(this);
        let uid = $(this).parent().find('.uid').val();
        let card = $(this).parent().find('.user-profile-card');
        let cardid = $(this).parent().find('.user-card-container-index').val();
        displayer.on('mouseenter', function() {
            if(!fetchings.contains(cardid)) {
                fetchings.push(cardid);

                $.ajax({
                    url: `/users/${uid}/card/generate`,
                    type: 'get',
                    success: function(response) {
                        card.html(response);
                        
                        // handle card events
                        let image = card.find('.card-user-avatar');
                        image.parent().imagesLoaded(function() {
                            handle_image_dimensions(image);
                        });
                        handle_suboptions_container(card.find('.button-with-suboptions'));
                    },
                    error: function() {

                    }
                });
            }
        });
    });
}

function handle_close_shadowed_view(component) {
    component.find('.close-shadowed-view-button').each(function() {
        $(this).on('click',function() {
            let shadowed_container = $(this);
            while(!shadowed_container.hasClass('full-shadowed')) {
                shadowed_container = shadowed_container.parent();
            }
            shadowed_container.css('display', 'none');
            $('.suboptions-container').css('display', 'none');
    
            return false;
        });
    })
}

$('.hide-parent').on('click', function() {
    $(this).parent().css('display', 'none');

    return false;
});

function handle_hide_parent(item) {
    item.find('.hide-parent').each(function() {
        $(this).on('click', function() {
            $(this).parent().css('display', 'none');
        });
    })
}

$('.toggle-container-button').on('click', function() {
    let box = $(this);
    while(!box.hasClass('toggle-box')) box = box.parent();
    let container = box.find('.toggle-container').first();

    if(container.css('display') == 'none') {
        container.removeClass('none');
        container.addClass('block');

        if(box.find('.toggle-arrow').length) {
            box.find('.toggle-arrow').first().css({
                transform:'rotate(90deg)',
                '-ms-transform':'rotate(90deg)',
                '-moz-transform':'rotate(90deg)',
                '-webkit-transform':'rotate(90deg)',
                '-o-transform':'rotate(90deg)'
            });
        }
    } else {
        container.removeClass('block');
        container.addClass('none');

        if(box.find('.toggle-arrow').length) {
            box.find('.toggle-arrow').first().css({
                transform:'rotate(0deg)',
                '-ms-transform':'rotate(0deg)',
                '-moz-transform':'rotate(0deg)',
                '-webkit-transform':'rotate(0deg)',
                '-o-transform':'rotate(0deg)'
            });
        }
    }
    
    return false;
});

function handle_toggling(container) {
    container.find('.toggle-container-button').each(function() {
        $(this).on('click', function() {
            let box = $(this);
            while(!box.hasClass('toggle-box')) {
                box = box.parent();
            }
            let container = box.find('.toggle-container');

            if(container.css('display') == 'none') {
                container.removeClass('none');
                container.addClass('block');

                if(box.find('.toggle-arrow').length) {
                    box.find('.toggle-arrow').css({
                        transform:'rotate(90deg)',
                        '-ms-transform':'rotate(90deg)',
                        '-moz-transform':'rotate(90deg)',
                        '-webkit-transform':'rotate(90deg)',
                        '-o-transform':'rotate(90deg)'
                    });
                }
            } else {
                container.removeClass('block');
                container.addClass('none');

                if(box.find('.toggle-arrow').length) {
                    box.find('.toggle-arrow').css({
                        transform:'rotate(0deg)',
                        '-ms-transform':'rotate(0deg)',
                        '-moz-transform':'rotate(0deg)',
                        '-webkit-transform':'rotate(0deg)',
                        '-o-transform':'rotate(0deg)'
                    });
                }
            }
            
            return false;
        });
    });
}

$('.row-num-changer').on('change', function() {
    let pagesize = $(this).val();

    window.location.href = updateQueryStringParameter(window.location.href, 'pagesize', pagesize);
});

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";

    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
}

$('.send-feedback').on('click', function() {
    let button = $(this);
    let btn_text_ing = button.find('.btn-text-ing').val();
    let btn_text_no_ing = button.find('.btn-text-no-ing').val();
    let message_sent = button.find('.message-sent').val();

    let data = {
        _token: csrf,
    };

    let feedback_container = $(this);
    while(!feedback_container.hasClass('feedback-container')) {
        feedback_container = feedback_container.parent();
    }

    // If this is true, it means the user is a guest
    let error_container = feedback_container.find('.error-box');
    if(feedback_container.find('#email').length) {
        let email = feedback_container.find('#email').val().trim();
        if(email == "") {
            feedback_container.find('#email').parent().find('.err').removeClass('none');
            error_container.find('.error').text(feedback_container.find('.email-required').val());
            error_container.removeClass('none');
            return;
        } else if(!validateEmail(email)) {
            feedback_container.find('#email').parent().find('.err').removeClass('none');
            feedback_container.find('.error').text(feedback_container.find('.email-invalide').val());
            error_container.removeClass('none');
            return;
        } else {
            feedback_container.find('#email').parent().find('.err').addClass('none');
            error_container.addClass('none');
            data.email = email;
        }
    }

    let feedback = feedback_container.find('#feedback').val().trim();
    if(feedback == "") {
        feedback_container.find('#feedback').parent().parent().find('.err').removeClass('none');
        error_container.removeClass('none');
        error_container.find('.error').text(feedback_container.find('.content-required').val());
        return;
    } else if(feedback.length < 10) {
        feedback_container.find('#feedback').parent().parent().find('.err').removeClass('none');
        error_container.removeClass('none');
        error_container.find('.error').text(feedback_container.find('.content-min').val());
        return;
    } else {
        feedback_container.find('#feedback').parent().parent().find('.err').addClass('none');
        error_container.addClass('none');
        data.feedback = feedback;
    }

    // Disabling inputs while sending feedback
    feedback_container.find('#email').attr('disabled', 'disabled');
    feedback_container.find('textarea').attr('disabled', 'disabled');

    button.attr('disabled', 'disabled');
    button.find('.btn-text').text(btn_text_ing);
    button.attr('style', 'padding: 5px 8px; background-color: #acacac; cursor: not-allowed');

    $.ajax({
        url: '/feedback',
        type: 'POST',
        data: data,
        success: function(response) {
            $('#send-feedback-box-sidebar').parent().find('.feedback-sent-success-container').removeClass('none');
            $('#send-feedback-box-sidebar').remove();
            basic_notification_show(message_sent, 'basic-notification-round-tick');
            
        },
        error: function(response) {
            feedback_container.find('#email').removeAttr('disabled');
            feedback_container.find('textarea').removeAttr('disabled');
            button.removeAttr('disabled');
            button.find('.btn-text').text(btn_text_no_ing);
            button.attr('style', 'padding: 5px 8px;');
            let er = '';
            try {
                let errorObject = JSON.parse(response.responseText).errors;
                er = errorObject[Object.keys(errorObject)][0];
            } catch(e) {
                er = JSON.parse(response.responseText).message;
            }

            error_container.removeClass('none');
            error_container.find('.error').text(er);
        }
    })
});

$('.emoji-button').on('click', function(event) {
    event.preventDefault();
    let emoji_button = $(this);

    $(this).find('.emoji-unfilled').addClass('none');
    $('.emoji-unfilled').animate({
        opacity: '0.5'
    }, 300);
    $(this).find('.emoji-filled').removeClass('none');

    $(this).parent().find('.emoji-button').off('click');

    $.ajax({
        url: '/emojifeedback',
        type: 'post',
        data: {
            _token: csrf,
            emoji_feedback: emoji_button.find('.feedback-emoji-state').val()
        }
    });
});

let vote_lock = true;
$('.votable-up-vote').each(function() { handle_up_vote($(this)); });
$('.votable-down-vote').each(function() { handle_down_vote($(this)); });
function handle_up_vote(button) {
    button.on('click', function() {  
        let vote_box = button;
        while(!vote_box.hasClass('vote-box')) vote_box = vote_box.parent();

        let lock = vote_box.find('.lock');
        if(lock.val() == 'voting') return;
        lock.val('voting');

        // All vote buttons of votable component
        let buttons = {
            up: vote_box.find('.up-vote'),
            upvoted: vote_box.find('.up-vote-filled'),
            down: vote_box.find('.down-vote'),
            downvoted: vote_box.find('.down-vote-filled'),
        };

        let votable_id = vote_box.find('.votable-id').val();
        let votable_type = vote_box.find('.votable-type').val();
        let vote_counter = vote_box.find('.vote-counter');
        let old_vote_counter = parseInt(vote_box.find('.vote-counter').text());
        let old_vote_state;
        let new_vote_state;
    
        // Handle vote buttons
        if(buttons.upvoted.hasClass('none')) {
            old_vote_state = 'not-voted';
            new_vote_state = 'up-voted';

            buttons.up.addClass('none');
            buttons.upvoted.removeClass('none');
            vote_counter.text(parseInt(vote_counter.text()) + 1);

            if(!buttons.downvoted.hasClass('none')) {
                old_vote_state = 'down-voted';
                new_vote_state = 'flipped-to-up';

                buttons.down.removeClass('none');
                buttons.downvoted.addClass('none');
                // we've already added one before if() so result is +2 because the current user already down voted it
                vote_counter.text(parseInt(vote_counter.text()) + 1);
            }
        } else {
            old_vote_state = 'up-voted';
            new_vote_state = 'un-voted';

            buttons.up.removeClass('none');
            buttons.upvoted.addClass('none');
            vote_counter.text(parseInt(vote_counter.text()) - 1);
        }

        $.ajax({
            type: 'POST',
            url: `/${votable_type}/vote`,
            data: {
                _token: csrf,
                'resourceid': votable_id,
                'vote': 1
            },
            success: function(response) {
                let new_vote_counter = vote_counter.text();
                handle_vote_sync(vote_box, new_vote_state, new_vote_counter);
            },
            error: function(response) {
                /** revert icon change */
                switch(old_vote_state) {
                    case 'not-voted':
                        buttons.up.removeClass('none');
                        buttons.upvoted.addClass('none');
                        break;
                    case 'up-voted':
                        buttons.up.addClass('none');
                        buttons.upvoted.removeClass('none');
                        break;
                    case 'down-voted':
                        buttons.up.removeClass('none');
                        buttons.upvoted.addClass('none');
                        buttons.down.addClass('none');
                        buttons.downvoted.removeClass('none');
                        break;
                }
    
                // If there's an error we simply set the old value
                vote_box.find('.vote-counter').text(old_vote_counter);

                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(error, 'warning');
            },
            complete: function() {
                lock.val('stable');
            }
        });
    });
}
function handle_down_vote(button) {
    button.on('click', function() {  
        let vote_box = button;
        while(!vote_box.hasClass('vote-box')) vote_box = vote_box.parent();

        let lock = vote_box.find('.lock');
        if(lock.val() == 'voting') return;
        lock.val('voting');

        // All vote buttons of votable component
        let buttons = {
            up: vote_box.find('.up-vote'),
            upvoted: vote_box.find('.up-vote-filled'),
            down: vote_box.find('.down-vote'),
            downvoted: vote_box.find('.down-vote-filled'),
        };

        let votable_id = vote_box.find('.votable-id').val();
        let votable_type = vote_box.find('.votable-type').val();
        let vote_counter = vote_box.find('.vote-counter');
        let old_vote_counter = parseInt(vote_box.find('.vote-counter').text());
        let old_vote_state;
        let new_vote_state;
    
        // Handle vote buttons
        if(buttons.downvoted.hasClass('none')) {
            old_vote_state = 'not-voted';
            new_vote_state = 'down-voted';

            buttons.down.addClass('none');
            buttons.downvoted.removeClass('none');
            vote_counter.text(parseInt(vote_counter.text()) - 1);

            if(!buttons.upvoted.hasClass('none')) {
                old_vote_state = 'up-voted';
                new_vote_state = 'flipped-to-down';

                buttons.up.removeClass('none');
                buttons.upvoted.addClass('none');
                // we've already subtracted one before if() so result is -2 because the current user already up voted it
                vote_counter.text(parseInt(vote_counter.text()) - 1);
            }
        } else {
            old_vote_state = 'down-voted';
            new_vote_state = 'un-voted';

            buttons.down.removeClass('none');
            buttons.downvoted.addClass('none');
            vote_counter.text(parseInt(vote_counter.text()) + 1);
        }

        $.ajax({
            type: 'POST',
            url: `/${votable_type}/vote`,
            data: {
                _token: csrf,
                'resourceid': votable_id,
                'vote': -1
            },
            success: function(response) {
                let new_vote_counter = vote_counter.text();
                handle_vote_sync(vote_box, new_vote_state, new_vote_counter);
            },
            error: function(response) {
                /** revert icon change */
                switch(old_vote_state) {
                    case 'not-voted':
                        buttons.down.removeClass('none');
                        buttons.downvoted.addClass('none');
                        break;
                    case 'down-voted':
                        buttons.down.addClass('none');
                        buttons.downvoted.removeClass('none');
                        break;
                    case 'up-voted':
                        buttons.down.removeClass('none');
                        buttons.downvoted.addClass('none');
                        buttons.up.addClass('none');
                        buttons.upvoted.removeClass('none');
                        break;
                }
    
                // If there's an error we simply set the old value
                vote_box.find('.vote-counter').text(old_vote_counter);

                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(error, 'warning');
            },
            complete: function() {
                lock.val('stable');
            }
        });
    });
}
function handle_vote_sync(votebox, new_vote_state, new_vote_count) {
    // If the thread viewer is not opened we stop the execution flow
    if(!last_opened_thread) return;

    let from = votebox.find('.from').val();
    let votable_id = votebox.find('.votable-id').val();
    let votable_type = votebox.find('.votable-type').val();
    let target_votebox;

    // Get target vote box where we need to sync
    switch(from) {
        case 'outside-media-viewer':
            if(votable_type == 'thread') {
                /**
                 * Here we have to check if the viewer is already opened and the thread opened is the same as the 
                 * voted thread before update the viewer voting items
                 */
                let loaded_to_viewer = (last_opened_thread == votable_id) ? 1 : 0;
                if(loaded_to_viewer)
                    // Thread vote section inside viewer
                    target_votebox = $('#thread-media-viewer').find('.vote-box');
                else
                    // Here the votable thread is not the thread loaded into the viewer; so we have to stop the execution
                    return;
            } else if(votable_type == 'post')
                target_votebox = $('.viewer-replies-container .post'+votable_id).find('.vote-box');

            break;
        case 'inside-media-viewer':
            if(votable_type == 'thread')
                target_votebox = $('#thread'+votable_id).find('.vote-box');
            else if(votable_type == 'post') {
                if($('#thread-show-posts-container').length)
                    target_votebox = $('#thread-show-posts-container .post'+votable_id).find('.vote-box');
                else
                    return;
            }

            break;
    }

    // After getting the votable box of the inside or outside section, we begin by editing the counter
    target_votebox.find('.vote-counter').text(new_vote_count);

    // Handle vote buttons
    let buttons = {
        up: target_votebox.find('.up-vote'),
        upvoted: target_votebox.find('.up-vote-filled'),
        down: target_votebox.find('.down-vote'),
        downvoted: target_votebox.find('.down-vote-filled'),
    };

    switch(new_vote_state) {
        case 'up-voted':
            buttons.down.removeClass('none');
            buttons.downvoted.addClass('none');
            buttons.up.addClass('none');
            buttons.upvoted.removeClass('none');
            break;
        case 'down-voted':
            buttons.up.removeClass('none');
            buttons.upvoted.addClass('none');
            buttons.down.addClass('none');
            buttons.downvoted.removeClass('none');
            break;
        case 'un-voted':
            buttons.up.removeClass('none');
            buttons.upvoted.addClass('none');
            buttons.down.removeClass('none');
            buttons.downvoted.addClass('none');
            break;
        case 'flipped-to-up':
            buttons.up.addClass('none');
            buttons.upvoted.removeClass('none');
            buttons.down.removeClass('none');
            buttons.downvoted.addClass('none');
            break;
        case 'flipped-to-down':
            buttons.down.addClass('none');
            buttons.downvoted.removeClass('none');
            buttons.up.removeClass('none');
            buttons.upvoted.addClass('none');
            break;
    }
}

$('.like-resource').each(function() { handle_resource_like($(this)); });
function handle_resource_like(button) {
    button.on('click', function() {
        let likable_id = button.find('.likable-id').val();
        let likable_type = button.find('.likable-type').val();
        let likes_counter = button.find('.likes-counter');
        let old_likes_counter = likes_counter.text();
        let like_state_after_click;

        if(!button.find('.red-like').hasClass('none')) {
            like_state_after_click = 'not-liked';
            likes_counter.text(parseInt(likes_counter.text())-1);
            button.find('.red-like').addClass('none');
            button.find('.gray-like').removeClass('none');
        } else {
            like_state_after_click = 'liked';
            likes_counter.text(parseInt(likes_counter.text())+1);
            button.find('.red-like').removeClass('none');
            button.find('.gray-like').addClass('none');
        }

        $.ajax({
            type: 'POST',
            url: `/${likable_type}/like`,
            data: {
                _token: csrf,
                resourceid: likable_id
            },
            success: function(response) {
                handle_like_sync(button, like_state_after_click, likes_counter.text());
            },
            error: function(response) {
                // If there's an error we simply set the old value
                likes_counter.text(old_likes_counter);
                
                if(like_state_after_click == 'liked') {
                    button.find('.red-like').addClass('none');
                    button.find('.gray-like').removeClass('none');
                } else {
                    button.find('.red-like').removeClass('none');
                    button.find('.gray-like').addClass('none');
                }

                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(error, 'warning');
            },
            complete: function() {
            }
        });
    });
}
function handle_like_sync(button, like_status_after_click, new_likes_counter) {
    // If the thread viewer is not opened we have to stop the execution flow
    if(!last_opened_thread) return;

    let from = button.find('.from').val(); // inside/outside viewer
    let likable_id = button.find('.likable-id').val();
    let likable_type = button.find('.likable-type').val();
    let target_button;

    switch(from) {
        case 'outside-media-viewer':
            if(likable_type == 'thread')
                if(last_opened_thread == likable_id)
                    target_button = $('#thread-media-viewer').find('.viewer-thread-like');
                else
                    return;
            else if(likable_type == 'post')
                target_button = $('.viewer-replies-container .post'+likable_id).find('.like-resource');
            break;
        case 'inside-media-viewer':
            if(likable_type == 'thread')
                target_button = $('#thread'+likable_id).find('.like-resource');
            else if(likable_type == 'post')
                if($('.page').val() == 'thread-show')
                    target_button = $('#thread-show-posts-container .post'+likable_id).find('.like-resource');
                else
                    return;
            break;
    }


    target_button.find('.likes-counter').text(new_likes_counter);

    if(like_status_after_click == 'liked') {
        target_button.find('.red-like').removeClass('none');
        target_button.find('.gray-like').addClass('none');
    } else {
        target_button.find('.red-like').addClass('none');
        target_button.find('.gray-like').removeClass('none');
    }
}

$('.set-lang').on('click', function(event) {
    let language = $(this).find('.lang-value').val();
    start_loading_strip();
    $.ajax({
        type: 'post',
        url: '/setlang',
        data: {
            _token: csrf,
            lang: language
        },
        success: function() {
            location.reload();
        }
    });

    event.preventDefault();
});

let header_notifs_bootstrap_fetched = false;
let header_notifications_bootstrap_fetch_lock = true;
let header_notifications_unread_after_bootstrap_fetch_lock = true;
$('.notification-button').on('click', function() {
    if(header_notifs_bootstrap_fetched) {
        /**
         * If the user already fetched the first chunk of notifications by clicking on notifications button
         * we have here to check whether other notifications are added or not and mark them as read
         */
        let unread_notifications_ids = [];
        $('#header-notifications-box .unread-notification-container').each(function() {
            unread_notifications_ids.push($(this).find('.notification-id').val());
        });

        // We process request of marking group of notifs as read only if it exists at least one unread notification
        if(unread_notifications_ids.length) {
            if(header_notifications_unread_after_bootstrap_fetch_lock) {
                $.ajax({
                    url: `/notifications/group/markasread`,
                    type: 'patch',
                    data: {
                        _token: csrf,
                        ids: unread_notifications_ids
                    },
                    success: function() {
                        $('#header-notifications-box .unread-notification-container').each(function() {
                            $(this).removeClass('unread-notification-container');
                        });
                    },
                    complete: function() {
                        header_notifications_unread_after_bootstrap_fetch_lock = true;
                    }
                });
            }
        }

        $('#header-button-counter-indicator').addClass('none');
        $('#header-button-counter-indicator').text('0');
        return;
    }

    if(!header_notifications_bootstrap_fetch_lock) return;
    header_notifications_bootstrap_fetch_lock = false;
    
    $.ajax({
        type: 'get',
        url: '/notifications/bootstrap',
        success: function(response) {
            header_notifs_bootstrap_fetched = true;
            // If no more notifications left (hasmore=false), we have to remove scroll event that fetch more notifications and the fetch-more-fade component as well
            if(!response.hasmore) {
                header_notifs_scrollable_box.off('scroll');
                $('.header-notifications-fetch-more').remove();
            }
            // If no notifications exists at all in first fetch, se simply remove fades, display empty box, and stop
            if(!response.count) {
                $('.notifs-box').html('');
                $('#header-notifications-box .notification-empty-box').removeClass('none');
                return;
            }

            $('.notifs-box').html(response.content);
            // Because this is the first notifications fetch we fetch and handle all notifications components events
            let unhandled_notification_components = $('.notifs-box .notification-container');
            
            unhandled_notification_components.each(function() {
                $(this).removeClass('unread-notification-container');
                handle_notification_menu_appearence($(this));
                handle_notification_menu_buttons($(this).find('.notification-menu-button'));
                handle_nested_soc($(this).find('.notification-menu-button'));
                handle_delete_notification($(this).find('.delete-notification'));
                handle_disable_switch_notification($(this).find('.disable-switch-notification'));
                handle_image_dimensions($(this).find('.action_takers_image'));
            });
        },
        complete: function() {
            force_lazy_load($('.notifs-box'));
            handle_mark_as_read();
            header_notifications_bootstrap_fetch_lock = true;
        }
    });
});


let header_notifications_fetch_more = $('.header-notifications-fetch-more');
let header_notifs_scrollable_box = $('#header-notifs-scrollable-box');
let header_notifications_fetch_more_lock = true;
if(header_notifs_scrollable_box.length) {
    header_notifs_scrollable_box.on('DOMContentLoaded scroll', function() {
        // We only have to start loading and fetching data when user reach the explore more faded thread
        // + 50 because we don't want the user to scroll to the last bottom point in order to load notification, instead
        // we want to load notifications just when the user see the faded notification
        if(header_notifs_scrollable_box.scrollTop() + header_notifs_scrollable_box.innerHeight() + 50 >= header_notifs_scrollable_box[0].scrollHeight) {
            if(!header_notifications_fetch_more_lock || !header_notifs_bootstrap_fetched) {
                return;
            }
            header_notifications_fetch_more_lock=false;
            
            let present_notifs_count = $('header .notification-container').length;
            
            $.ajax({
                url: `/notifications/generate?range=6&skip=${present_notifs_count}`,
                type: 'get',
                success: function(response) {
                    if(response.content != "")
                        $('#header-notifications-box .notifs-box').append($(`${response.content}`));
            
                    if(response.hasmore == false) {
                        header_notifications_fetch_more.remove();
                        header_notifs_scrollable_box.off();
                    }

                    /**
                     * Notice here when we fetch the notifications we return the number of fetched notifs
                     * because we need to handle the last count of appended components events
                     */
                    let unhandled_event_notification_components = 
                        $('.notifs-box > .notification-container').slice(response.count*(-1));

                    unhandled_event_notification_components.each(function() {
                        handle_notification_menu_appearence($(this));
                        handle_notification_menu_buttons($(this).find('.notification-menu-button'));
                        handle_nested_soc($(this).find('.notification-menu-button'));
                        handle_delete_notification($(this).find('.delete-notification'));
                        handle_disable_switch_notification($(this).find('.disable-switch-notification'));
                        handle_image_dimensions($(this).find('.action_takers_image'));
                    });
                    force_lazy_load($('header .notification-container'));
                },
                complete: function() {
                    header_notifications_fetch_more_lock = true;
                }
            });
        }

    });
}

function handle_mark_as_read() {
    $.ajax({
        type: 'post',
        url: '/notifications/markasread',
        data: {
            _token: csrf
        },
        success: function() {
            $('#header-button-counter-indicator').addClass('none');
            $('#header-button-counter-indicator').text('0');
        }
    })
}

function mark_single_notification_as_read(notification_id) {
    $.ajax({
        type: 'post',
        url: `/notifications/${notification_id}/markasread`,
        data: {
            _token: csrf
        },
        success: function() {
            
        }
    });
}



function mark_notifications_group_as_read(group) {
    
}

let header_notifications_counter = $('#header-button-counter-indicator');
let bl_notification_timeout;
if(userId) {
    Echo.private('user.' + userId + '.notifications')
        .notification((notification) => {
            // Stop bottom-left notification appearence animation if there's already animation
            $('.bl-notification-container').stop();
            clearTimeout(bl_notification_timeout);

            let header_notifications_box = $('#header-notifications-box');
            /**
             * user will not receive notification statement because it will be fetched separately
             * due to i18n convenience;
             * Notice that sometimes we pass along with other values like in OAuthcontroller; in this case we don't
             * append it directly without sending request to get the localized version
             */
            let id = notification.notification_id;
            $('.bl-notification-container .notification-id').val(id);
            $('.bl-notification-container .bl-notification-image').attr('src', notification.image);
            $('.bl-notification-container .bl-notification-bold').text(notification.bold);
            $('.bl-notification-container').attr('href', notification.link);
            // set the action icon
            let lastClass = $('.bl-notification-action-icon').attr('class').split(' ').pop();
            $('.bl-notification-action-icon').removeClass(lastClass);
            $('.bl-notification-action-icon').addClass(notification.action_icon);
            
            let notificationcontent = $('.bl-notification-container .bl-notification-content');
            $.ajax({
                type: 'get',
                url: `/notifications/statement/${notification.action_statement}/get`,
                success: function(statement) {
                    notificationcontent.text(statement);
                    if(notification.resource_slice)
                        notificationcontent.append(notification.resource_slice);
                    display_bl_notification();
                }
            });

            /**
             * Notice here that we only append the notification to the notifications box if the user has already 
             * open the notifications container in the header or the user is located in notifications page.
             * Also, notifications counter is only incremented if we the current page is not notifications page;
             * and the notifications box is not opened;
             */
            let is_notifications_page = $('#page').length && $('#page').val() == 'notifications-page';
            if(header_notifs_bootstrap_fetched || is_notifications_page) {
                $.ajax({
                    type: 'post',
                    url: '/notification/generate',
                    data: {
                        _token: csrf,
                        notification_id: notification.id,
                    },
                    success: function(response) {
                        $('.notifs-box').prepend(response);
                        let appended_component = $('.notifs-box').last().find('.notification-container').first();
                        handle_image_dimensions(appended_component.find('.action_takers_image'));
                        handle_notification_menu_appearence(appended_component);
                        handle_notification_menu_buttons(appended_component.find('.notification-menu-button'));
                        handle_nested_soc(appended_component.find('.notification-menu-button'));
                        handle_delete_notification(appended_component.find('.delete-notification'));
                        handle_disable_switch_notification(appended_component.find('.disable-switch-notification'));
                        force_lazy_load(appended_component);

                        // Remove notification empty block in case notifications are empty before the notification comes
                        $('.notification-empty-box').addClass('none');

                        /**
                         * We want to mark notification as read only after 
                         * appending it to notification box
                         * To increment the counter of notification in header when a new notif comes, notifications box must be closed
                         */
                        if(header_notifications_box.css('display') != 'none' || is_notifications_page) {
                            /**
                             * When notifications box is already opened, we asumed that the user is opening it to read notifications,
                             * and so when a new notification comes, it will be appended to the box, and we mark it as read because
                             * the user will see it for sure
                             * Also if the user is located in notifications page we mark it as read directly after appending
                             */
                            mark_single_notification_as_read(notification.notification_id);
                        } else {
                            header_notifications_counter.removeClass('none');
                            increment_header_notifications_counter(1);
                        }
                    }
                })
            } else {
                header_notifications_counter.removeClass('none');
                increment_header_notifications_counter(1);
            }
        });
}

let last_notification_read = -1;
$('.bl-notification-container').on({
    mouseenter: function(event) {
        clearTimeout(bl_notification_timeout);
        $('.bl-notification-container').stop(); // Stop current animation if it exists
        $('.bl-notification-container').removeClass('none');
        $('.bl-notification-container').css('opacity', '1');
        
        let notification_id = $('.bl-notification-container').find('.notification-id').val();

        // We want to do the following actions only once; only the first time user hover over the notification
        if(notification_id != last_notification_read) {
            // we hide indicator if notifs counter is <= 1, and if it is > 1 we simply decrement it
            let notifications_indicator = $('#header-button-counter-indicator');
            let ni_value = parseInt(notifications_indicator.text());
            if(ni_value <= 1)
                $('#header-button-counter-indicator').addClass("none")
            else
                notifications_indicator.text(ni_value-1);

            // Mark notificatuion as read
            mark_single_notification_as_read($('.bl-notification-container').find('.notification-id').val());
            last_notification_read = notification_id;
        }
    }, 
    mouseleave: function(event) {
        bl_notification_timeout = setTimeout(function() {
            $('.bl-notification-container').animate({
                'opacity': 0
            }, 600, function() {
                $('.bl-notification-container').addClass('none');
            });
        }, 5000);
    }
});

function increment_header_notifications_counter(increment=1) {
    // We check first if the notification counter has something like : +99; If so we don't have to increment
    if(!(header_notifications_counter.text().indexOf('+') > -1)) {
        header_notifications_counter.text(parseInt(header_notifications_counter.text()) + 1);
    }
}

function display_bl_notification() {
    // We display the bl-notification one statement fetched from server
    $('.bl-notification-container').removeClass('none');
    $('.bl-notification-container').animate({
        'opacity': 1
    }, 600);
    bl_notification_timeout = setTimeout(function() {
        $('.bl-notification-container').animate({
            'opacity': 0
        }, 600, function() {
            $('.bl-notification-container').addClass('none');
        });
    }, 5000);
}

$('.delete-notification').each(function() {
    handle_delete_notification($(this));
})

$('.disable-switch-notification').each(function() {
    handle_disable_switch_notification($(this));
})

let notification_delete_lock = true;
function handle_delete_notification(button) {
    button.on('click', function() {
        if(!notification_delete_lock) {
            return false;;
        }
        notification_delete_lock = false;

        let notif_id = button.parent().find('.notif-id').val();
        let notif_container = button;
        while(!notif_container.hasClass('notification-container')) {
            notif_container = notif_container.parent();
        }

        button.find('.button-text').text(button.find('.message-ing').val());
        button.addClass('block-click');
        button.css('background-color', '#dddddd5e');
        button.css('cursor', 'default');

        $.ajax({
            url: `/notification/${notif_id}/delete`,
            type: 'delete',
            data: {
                _token: csrf,
            },
            success: function() {
                notif_container.remove();
                basic_notification_show(button.find('.delete-success').val(), 'basic-notification-round-tick');
                if(!$('.notifs-box .notification-container').length)
                    $('.notification-empty-box').removeClass('none');
            },
            complete: function() {
                notification_delete_lock = true;
            },
            error: function(response) {
                button.css('background-color', '');
                button.css('cursor', 'pointer');
                button.find('.button-text').text(button.find('.message-no-ing').val());
            }
        })

        return false;
    });
}

let notification_disable_switch_lock = true;
function handle_disable_switch_notification(button) {
    button.on('click', function(event) {
        event.stopPropagation();
        if(!notification_disable_switch_lock) {
            return false;;
        }
        notification_disable_switch_lock = false;

        let notif_id = button.parent().find('.notif-id').val();

        button.attr('style', 'background-color: #dddddd5e; cursor: default');

        let url;
        if(button.hasClass('disable-notification')) {
            button.find('.button-text').text(button.find('.turning-off-text').val());
            url = `/notification/${notif_id}/disable`;
        } else {
            button.find('.button-text').text(button.find('.turning-on-text').val());
            url = `/notification/${notif_id}/enable`;
        }

        $.ajax({
            url: url,
            type: 'post',
            data: {
                _token: csrf,
            },
            success: function(response) {
                if(response.status == 'enabled') {
                    button.find('.notif-switch-icon').removeClass('enablenotif17b-icon');
                    button.find('.notif-switch-icon').addClass('disablenotif17b-icon');
                    button.removeClass('enable-notification');
                    button.addClass('disable-notification');
                    button.find('.button-text').text(button.find('.turn-off-text').val());
                } else {
                    button.find('.notif-switch-icon').removeClass('disablenotif17b-icon');
                    button.find('.notif-switch-icon').addClass('enablenotif17b-icon');
                    button.removeClass('disable-notification');
                    button.addClass('enable-notification');
                    button.find('.button-text').text(button.find('.turn-on-text').val());
                }
                button.parent().css('display', 'none');
                button.find('.button-label-text').text(response.button_label);
                basic_notification_show(response.message, 'basic-notification-round-tick');
            },
            complete: function() {
                button.attr('style', '');
                notification_disable_switch_lock = true;
            },
            error: function(response) {
                // If an error occurs, we have to revert the button text
                if(button.hasClass('disable-notification'))
                    button.find('.button-text').text(button.find('.turn-off-text').val());
                else
                    button.find('.button-text').text(button.find('.turn-on-text').val());

                let errorObject = JSON.parse(response.responseText);
                let er = errorObject.message;
                display_top_informer_message(er, 'warning');
            }
        })
    });
}


let loading_anim_interval;
function start_loading_anim(loading_anim) {
    loading_anim_interval = window.setInterval(function(){
        if(loading_anim.text() == "•") {
            loading_anim.text("••");
        } else if(loading_anim.text() == "••") {
            loading_anim.text("•••");
        } else {
            loading_anim.text("•");
        }
    }, 300);
}
function stop_loading_anim() {
    clearInterval(loading_anim_interval);
}

$('.thread-container-box').each(function() {
    handle_thread_medias_containers($(this));
    handle_open_media_viewer($(this));
    handle_thread_shadowed_viewers($(this));
    handle_expend_button_appearence($(this));
    handle_thread_display($(this));
    handle_expend($(this));
    handle_open_thread_delete_viewer($(this));
    handle_open_thread_replies_switch($(this));
    handle_thread_rtl($(this));
    handle_fetch_remaining_poll_options($(this));
    handle_thread_poll_option_propose($(this));
});

function handle_open_thread_delete_viewer(thread) {
    thread.find('.open-thread-delete-viewer').on('click', function(event) {
        let threadid = $(this).find('.thread-id').val();
        $('#thread-delete-viewer').find('.thread-id').val(threadid);
        $('#thread-delete-viewer').removeClass('none');
        disable_page_scroll();

        $(this).parent().css('display', 'none'); // hide suboptions container
        event.stopPropagation();
    });
}
function handle_open_thread_replies_switch(thread) {
    thread.find('.open-thread-replies-switch').on('click', function(event) {
        let button = $(this);
        let threadid = button.find('.thread-id').val();
        let action = button.find('.action').val();
        $('#thread-replies-switch-viewer').find('.thread-id').val(threadid);
        $('#thread-replies-switch-viewer').find('.action').val(action);

        let turn_on_label = $('#thread-replies-switcher').find('.turn-on-label').val();
        let turn_off_label = $('#thread-replies-switcher').find('.turn-off-label').val();
        if(action == 'off') {
            $('#thread-replies-switch-viewer').find('.thread-replies-switched-on').removeClass('none');
            $('#thread-replies-switch-viewer').find('.thread-replies-switched-off').addClass('none');
            $('#thread-replies-switcher .button-text').text(turn_off_label);
        } else {
            $('#thread-replies-switch-viewer').find('.thread-replies-switched-on').addClass('none');
            $('#thread-replies-switch-viewer').find('.thread-replies-switched-off').removeClass('none');
            $('#thread-replies-switcher .button-text').text(turn_on_label);
        }
        $('#thread-replies-switch-viewer').removeClass('none');
        disable_page_scroll();

        button.parent().css('display', 'none');
        event.stopPropagation();
    });
}
function handle_thread_display(thread) {
    thread.find('.thread-display-button').on('click', function() {
        let thread_component_display = thread.find('.thread-component').css('display');

        if(thread_component_display == 'none') {
            thread.find('.thread-component').css('display', 'flex');
            thread.find('.hidden-thread-section').addClass('none');
        } else {
            thread.find('.thread-component').css('display', 'none');
            thread.find('.hidden-thread-section').removeClass('none');
        }
    });
}

/**
 * NOTICE: Later, add a feature where the user click on locked button and the lock is false add this click in kind 
 * of queue and when the loc is released check the queue and trigger the event again and so on ;)
 */
let thread_visibility_lock = true;
function handle_thread_visibility_switch(component) {
    component.find('.thread-visibility-button').each(function() {
        $(this).on('click', function() {
            if(!thread_visibility_lock) return;
            thread_visibility_lock = false;

            let button = $(this);
            let spinner = button.find('.spinner');
            let buttonicon = button.find('.icon-above-spinner');
            let visibility_box = button;
            while(!visibility_box.hasClass('visibility-box')) {
                visibility_box = visibility_box.parent();
            }
        
            visibility_box.find('.thread-visibility-button').attr('style','background-color: rgb(250, 250, 250); color: gray');
            button.attr('style', 'background-color: rgb(240, 240, 240); color: black');
            spinner.addClass('inf-rotate');
            spinner.removeClass('opacity0');
            buttonicon.addClass('none');

            let thread_id = button.parent().find('.thread-id').val();
            let visibility_slug = button.find('.thread-visibility-slug').val();

            $.ajax({
                url: `/thread/visibility/patch`,
                type: 'patch',
                data: {
                    _token: csrf,
                    thread_id: thread_id,
                    visibility_slug: visibility_slug
                },
                success: function() {
                    let button_ico = visibility_box.find('.thread-resource-visibility-icon');
                    let new_path = button.find('.icon-path-when-selected').val();
                    basic_notification_show(visibility_box.find('.message-after-change').val(), 'basic-notification-round-tick');
                    button_ico.find('path').attr('d', new_path);
                },
                complete: function() {
                    thread_visibility_lock = true;
                    visibility_box.find('.thread-visibility-button').attr('style','');
                    buttonicon.removeClass('none');
                    spinner.addClass('opacity0');
                    spinner.removeClass('inf-rotate');

                    button.parent().css('display', 'none');
                }
            });
        });    
    });
}

$('.follow-user').each(function() { handle_user_follow($(this)); });
function handle_user_follow(button) {
    button.on('click', function() {
        let lock = button.find('.lock');
        if(lock.val() == 'processing') return;
        lock.val('processing');

        let user_id = button.find('.user-id').val();
        let status = button.find('.status').val()
        
        let followbox;
        let spinner;
        let buttonicon;
        let buttontext = [];

        if(button.hasClass('follow-button-with-icon')) {
            buttontext['follow-text'] = button.find('.follow-text').val();
            buttontext['followed-text'] = button.find('.followed-text').val();

            spinner = button.find('.spinner');
            buttonicon = button.find('.icon-above-spinner');

            spinner.removeClass('opacity0');
            spinner.addClass('inf-rotate');
            buttonicon.addClass('none');
        } else {
            followbox = button;
            while(!followbox.hasClass('follow-box')) followbox = followbox.parent();

            buttontext['follow-text'] = followbox.find('.follow-text').val();
            buttontext['unfollow-text'] = followbox.find('.unfollow-text').val();
            buttontext['following-text'] = followbox.find('.following-text').val();
            buttontext['unfollowing-text'] = followbox.find('.unfollowing-text').val();

            button.find((status == 'followed') ? '.unfollow-button-text' : '.follow-button-text')
                .text((status == 'followed') ? buttontext['unfollowing-text'] : buttontext['following-text']);
        }
        console.log(button);
        $.ajax({
            type: 'post',
            url: `/users/follow`,
            data: {
                _token: csrf,
                user_id: user_id
            },
            success: function(response) {
                if(button.hasClass('follow-button-with-icon')) {
                    if(response == -1) {
                        button.find('.status').val('not-followed');
                        button.find('.button-text').text(buttontext['follow-text']);
                        button.find('.follow-icon').removeClass('none');
                        button.find('.followed-icon').addClass('none');
                        basic_notification_show(button.find('.unfollow-success').val());
                    } else {
                        button.find('.status').val('followed');
                        button.find('.button-text').text(buttontext['followed-text']);
                        button.find('.follow-icon').addClass('none');
                        button.find('.followed-icon').removeClass('none');
                        basic_notification_show(button.find('.follow-success').val());
                    }

                    /**
                     * If user click on follow/unfollow associated to profile owner we have to either
                     * delete follower or add follower component to profile owner followers list (only if followers
                     * viewer is fetched)
                     */
                    if(button.hasClass('follow-profile-owner'))
                        if(followers_dialog_fetched) {
                            if(response == 1) {
                                // Generate follower component of current user and add it to followers container in case there's no fetch more loader
                                if(!$('#user-followers-container .fetch-more').length)
                                    $.ajax({
                                        type: 'get', 
                                        url: `/users/follower/component/generate`,
                                        data: { user_id: userId },
                                        success: function(response) {
                                            // Only append it if there is no fetch more loader
                                            $('#user-followers-container').append(response);
                                        }
                                    });

                                $('#user-followers-container .no-followers-box').addClass('none');
                                $('#user-followers-container .no-followers-box').removeClass('flex');
                            } else {
                                // Delete follower component of current
                                $('#user-followers-container .follow-box-item').each(function() {
                                    if($(this).find('.followable-id').val() == userId) {
                                        $(this).remove();
                                        return false;
                                    }
                                })
                                if(!$('#user-followers-container .follow-box-item').length) {
                                    $('#user-followers-container .no-followers-box').removeClass('none');
                                    $('#user-followers-container .no-followers-box').addClass('flex');
                                }
                            }
                        }    
                } else if(button.hasClass('follow-button-with-toggle-bell')) { // In thread component (when follow button pressed we turn follow button to bell button with suboptions)
                    if(response == 1)
                    basic_notification_show(followbox.find('.follow-success-text').val());
                    else
                    basic_notification_show(followbox.find('.unfollow-success-text').val());
                    
                    // After follow/unfollow user, we have to loop over every thread component that belong to this user and update his following box
                    $('.follow-box').each(function() {
                        let fbox = $(this);
                        let uid = fbox.find('.user-id').val();
                        
                        if(user_id == uid) {
                            if(response == 1) {
                                fbox.find('.follow-options-container').removeClass('none');
                                fbox.find('.follow-button-textual').addClass('none');
                            } else {
                                fbox.find('.follow-options-container').addClass('none');
                                fbox.find('.follow-button-textual').removeClass('none');
                            }
                            
                            fbox.find('.follow-button-text').text(buttontext['follow-text']);
                            fbox.find('.unfollow-button-text').text(buttontext['unfollow-text']);
                        }
                    });
                }

                if(button.hasClass('adjust-counter')) {
                    followbox = button;
                    while(!followbox.hasClass('follow-box')) followbox = followbox.parent();
                    // If followed response return 1 (means we add 1); otherwise it will return -1 (means we subtract 1)
                    followbox.find('.followers-counter').text(parseInt(followbox.find('.followers-counter').text()) + parseInt(response));
                }
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
                lock.val('stable');

                if(button.hasClass('follow-button-with-icon')) {
                    spinner.removeClass('inf-rotate');
                    spinner.addClass('opacity0');
                    buttonicon.removeClass('none');
                }
            }
        });
    })
}

function scroll_to_element_and_place_it_to_bottom_viewer(element) {
    let id = element.attr('id');
    location.hash = "#" + id;

    let element_height = element.height();
    let viewport_height = $(window).height();
    let current_y_position = $(window).scrollTop();
    
    let scroll_target = (element_height > viewport_height) 
        ? current_y_position + (element_height - viewport_height)
        : current_y_position - 57;

    console.log('scroll target : ' + scroll_target);

    $(window).scrollTop(scroll_target);
}

function scroll_to_element(id, top=-60, scrollable=null) {
    $('#'+id)[0].scrollIntoView(true);
    if(scrollable == null)
        $(window).scrollTop($(window).scrollTop() + top);
    else
        scrollable.scrollTop(scrollable.scrollTop() + top);
}

function move_element_by_id(id, target_top=56) {
    location.hash = "#" + id;
    var y = $(window).scrollTop(); //your current y position on the page
    $(window).scrollTop(y-target_top);
}

let load_image = function(file, image) {
    let reader = new FileReader();
    reader.onload = function(){
        image.attr('src', reader.result);
        image.on('load', function() {
            handle_image_dimensions(image);
        })
        
    };
    reader.readAsDataURL(file);
};

// The following three functions used to fetch image thumbnail from the uploaded video if user upload a video
const get_thumbnail = async function(file, seekTo, thumbnail_container) {
    let response = await getVideoCover(file, seekTo, thumbnail_container);

    return response;
}
function createPoster(video) {
    var canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
    return canvas.toDataURL("image/jpeg");;
}
function getVideoCover(file, seekTo = 0.0, thumbnail_container) {
    return new Promise((resolve, reject) => {
        // load the file to a video player
        const videoPlayer = document.createElement('video');
        videoPlayer.setAttribute('src', URL.createObjectURL(file));
        videoPlayer.load();
        videoPlayer.addEventListener('error', (ex) => {
            reject("error when loading video file", ex);
        });
        // load metadata of the video to get video duration and dimensions
        videoPlayer.addEventListener('loadedmetadata', () => {
            // seek to user defined timestamp (in seconds) if possible
            if (videoPlayer.duration < seekTo) {
                reject("video is too short.");
                return;
            }
            // delay seeking or else 'seeked' event won't fire on Safari
            setTimeout(() => {
              videoPlayer.currentTime = seekTo;
            }, 200);
            // extract video thumbnail once seeking is complete
            videoPlayer.addEventListener('seeked', () => {
                // define a canvas to have the same dimension as the video
                const canvas = document.createElement("canvas");
                canvas.width = videoPlayer.videoWidth;
                canvas.height = videoPlayer.videoHeight;
                // draw the video frame to canvas
                const ctx = canvas.getContext("2d");
                ctx.drawImage(videoPlayer, 0, 0, canvas.width, canvas.height);
                // return the canvas image as a blob
                ctx.canvas.toBlob(
                    blob => {
                        resolve(createPoster(videoPlayer));
                    },
                    "image/jpeg",
                    0.75 /* quality */
                );
            });
        });
    });
}

// Validate images upload
function validate_image_file_Type(files){
    let extensions = ["jpg", "jpeg", "png", "gif", "bmp"];
    let result = [];
    for(let i = 0; i<files.length;i++) {
        fileName = files[i].name;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if(extensions.contains(extFile)) {
            result.push(files[i]);
        }
    }

    return result;
}
function is_image(url) {
    let extensions = ["jpg", "jpeg", "png", "gif", "bmp"];

    var idxDot = url.lastIndexOf(".") + 1;
    var extFile = url.substr(idxDot, url.length).toLowerCase();
    if(extensions.contains(extFile)) {
        return true;
    }

    return false;
}
// Validate videos upload
function validate_video_file_Type(files) {
    let result = [];
    for(let i = 0; i<files.length;i++) {
        fileName = files[i].name;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="mp3" || extFile=="webm" || extFile=="mpg" 
        || extFile=="mp2"|| extFile=="mpeg"|| extFile=="mpe" 
        || extFile=="mpv"|| extFile=="ogg"|| extFile=="mp4" 
        || extFile=="m4p"|| extFile=="m4v"|| extFile=="avi"){
            result.push(files[i]);
        }
    }

    return result;
}
function is_video(url) {
    let extensions = ["mp3", "webm", "mpg", "mp2", "mpeg", "mpe", "mpv", "ogg", "mp4", "m4p", "m4v", "avi"];
    var idxDot = url.lastIndexOf(".") + 1;
    var extFile = url.substr(idxDot, url.length).toLowerCase();
    if(extensions.contains(extFile)) {
        return true;
    }

    return false;
}

function handle_thread_medias_containers(thread) {
    let thread_medias_container = thread.find('.thread-medias-container');
    let media_count = thread_medias_container.find('.thread-media-container').length;
    let medias = thread_medias_container.find('.thread-media-container');
    let full_media_width = thread_medias_container.width();
    let half_media_width = (full_media_width / 2);

    if(media_count == 1) {
        /**
         * In case thead has only one media(for now we're going to handle image - video will be handled later)
         * we set an initial height to the container = full width - 40 to display faded animation while we handling the image dimensions
         * Here we don't have to use typical lazy loading and image dimensions calculating directly because If media container is not determined
         * initially, so the containr may be expanded or collapsed based on the final image dimensions.
         * For that reason we have to use separate function to handle this situation solely
         */
        $(medias[0]).height(full_media_width);
        handle_single_lazy_image_container_unbased(thread);
    } else if(media_count == 2) {
        medias.each(function() {
            $(this).width(half_media_width-2);
            $(this).height(half_media_width-2);
        })
    } else if(media_count == 3) {
        $(medias[0]).width(half_media_width-2);
        $(medias[0]).height(half_media_width-2);
        
        $(medias[1]).width(half_media_width-2);
        $(medias[1]).height(half_media_width-2);
        
        $(medias[2]).width(full_media_width);
        $(medias[2]).height(half_media_width);

        $(medias[0]).css('margin-bottom', '4px');
        $(medias[1]).css('margin-bottom', '4px');
    } else if(media_count == 4) {
        medias.each(function() {
            $(this).width(half_media_width-2);
            $(this).height(half_media_width-2);
        });
        $(medias[0]).css('margin-bottom', '4px');
        $(medias[1]).css('margin-bottom', '4px');
    } else {
        for(let i = 0;i<4;i++) {
            $(medias[i]).width(half_media_width-2);
            $(medias[i]).height(half_media_width-2);
        }

        $(medias[0]).css('margin-bottom', '4px');
        $(medias[1]).css('margin-bottom', '4px');

        for(i=4;i<medias.length;i++) {
            $(medias[i]).addClass('none');
        }

        let more = medias.length - 4;
        $(medias[3]).find('.full-shadow-stretched').removeClass('none');
        $(medias[3]).find('.thread-media-more-counter').text(more);
    }
}

let images_loaded = false;
let infos_fetched = false;
let viewer_media_count = 0;
let viewer_medias = [];
let last_opened_thread = 0;
let opened_thread_component;
let viewer_loading_finished = false;
function handle_open_media_viewer(thread) {
    thread.find('.open-media-viewer').each(function() {
        $(this).on('click', function(event) {
            event.preventDefault();

            infos_fetched = images_loaded = false;

            let media_viewer = $('#thread-media-viewer');
            // all thread medias container
            let medias_container = $(this);
            while(!medias_container.hasClass('thread-medias-container')) {
                medias_container = medias_container.parent();
            }
            // selected media container
            let media_container = $(this);
            while(!media_container.hasClass('thread-media-container')) {
                media_container = media_container.parent();
            }
            let selected_media = media_container.find('.media-count').val();
            
            medias_container.find('.thread-media-container').each(function() {
                // Here before pushing the sources, we need to check media type
                let media_type = $(this).find('.media-type').val();
                let media_source;
                if(media_type == "image") {
                    var attr = $(this).find('.thread-media').attr('data-src');
                    // we check for data-src due to lazy loaded more images (because +4 images are hidden and therefor they are not handled by lazy loading function)
                    if (typeof attr !== 'undefined' && attr !== false)
                        media_source = $(this).find('.thread-media').attr('data-src');
                    else
                        media_source = $(this).find('.thread-media').attr('src');
                } else if(media_type == "video") {
                    media_source = $(this).find('video source').attr('src');
                }
                viewer_medias.push(media_source);
            });
            viewer_media_count = selected_media;
            let selected_media_url = viewer_medias[selected_media];

            // Viewer navigation buttons
            if(viewer_medias.length == 1) {
                $('.thread-viewer-right').addClass('none');
                $('.thread-viewer-left').addClass('none');
            } else {
                if(selected_media != 0) {
                    $('.thread-viewer-left').removeClass('none');
                }

                if(selected_media == viewer_medias.length-1) {
                    $('.thread-viewer-right').addClass('none');
                } else {
                    $('.thread-viewer-right').removeClass('none');
                }
            }
            // media index indicator
            if(viewer_medias.length > 1) {
                media_viewer.find('.thread-viewer-medias-indicator').removeClass('none');
                media_viewer.find('.thread-counter-total-medias').text(viewer_medias.length);
                media_viewer.find('.thread-counter-current-index').text(parseInt(viewer_media_count)+1);
            }
            
            /**
             * Before opening thread media viewer we need to make sure all medias are loaded
             */
            medias_container.imagesLoaded( function() {
                images_loaded = true;
                $('body').css('overflow', 'hidden');
                media_viewer.removeClass('none');
                // Check type of media
                if(is_image(selected_media_url)) {
                    // It's an image
                    let viewer_image = $('#thread-viewer-media-image');
                    let viewer_video = $('#thread-viewer-media-video');
                    viewer_image.removeClass('none');
                    viewer_video.addClass('none');
                    viewer_image.attr('src', viewer_medias[selected_media]);
                    handle_thread_viewer_image(viewer_image);
                } else if(is_video(selected_media_url)) {
                    // It's a video
                    let viewer_image = $('#thread-viewer-media-image');
                    let viewer_video = $('#thread-viewer-media-video');
                    viewer_image.addClass('none');
                    viewer_video.removeClass('none');
                    viewer_video.attr('src', selected_media_url);
                    viewer_video[0].load();
                }
                if(infos_fetched) {
                    stop_loading_strip();
                    viewer_loading_finished = true;
                }
            });

            opened_thread_component = $(this);
            while(!opened_thread_component.hasClass('resource-container')) {
                opened_thread_component = opened_thread_component.parent();
            }
            let thread_id = opened_thread_component.find('.thread-id').first().val();
            if(last_opened_thread != thread_id) {
                viewer_loading_finished = false;
                start_loading_strip();
                $('.tmvis').html('');
                $('.thread-media-viewer-infos-header-pattern').removeClass('none');
                // First we send ajax request to get thread infos component
                $.ajax({
                    url: `/threads/${thread_id}/viewer_infos_component`,
                    type: 'get',
                    success: function(thread_infos_section) {
                        infos_fetched = true;
                        last_opened_thread = thread_id;
                        $('.thread-media-viewer-infos-header-pattern').addClass('none');
                        $('.tmvisc').html(thread_infos_section);
                        // Bind mde to thread reply editor
                        $('.tmvisc .share-post-box textarea').each(function() {
                            let viewer_reply_simplemde = new SimpleMDE({
                                element: this,
                                hideIcons: ["guide", "heading", "image"],
                                spellChecker: false,
                                mode: 'markdown',
                                showMarkdownLineBreaks: true,
                            });
                        });
                        // ----- HANDLING EVENTS -----
                        $('.tmvisc').find('.follow-user').each(function() {
                            handle_user_follow($(this));
                        })
                        $('.tmvisc').find('.button-with-suboptions').not('#viewer-posts-container .button-with-suboptions').each(function() {
                            handle_suboptions_container($(this));
                        });
                        $('.tmvisc').find('.expand-button').not('#viewer-posts-container .expand-button').each(function() {
                            handle_expend($(this));
                        });
                        $('.tmvisc').find('.move-to-thread-viewer-reply').on('click', function() {
                            scroll_to_element('media-viewer-posts-count', -10, $('#viewer-infos-section-box .thread-media-viewer-infos-content').first());
                        });
                        $('.tmvisc').find('.like-resource').not('#viewer-posts-container .like-resource').each(function() {
                            handle_resource_like($(this));
                        });
                        $('.tmvisc').find('.login-signin-button').not('#viewer-posts-container .login-signin-button').each(function() {
                            handle_login_lock($(this).parent());
                        });
                        handle_save_threads($('.tmvisc').find('.save-thread'));
                        handle_document_suboptions_hiding();
                        $('.tmvisc').find('.votable-up-vote').not('#viewer-posts-container .votable-up-vote').each(function() {
                            handle_up_vote($(this));
                        })
                        $('.tmvisc').find('.votable-down-vote').not('#viewer-posts-container .votable-down-vote').each(function() {
                            handle_down_vote($(this));
                        })
                        if($('#viewer-posts-fetch-more').length)
                            handle_viewer_posts_fetchmore();
                        
                        $('.tmvisc').find('.viewer-post-container').each(function() {
                            handle_viewer_reply_events($(this));
                        });
                        // ---- HANDLE REPLY BUTTON ---- //
                        handle_post_share($('.tmvisc').find('.share-post'));
                        // ---------------------- //
                        handle_viewer_infos_height($('.tmvisc').find('.thread-media-viewer-infos-content'));
                        handle_media_viewer_thread_content_expand();
                        
                        if(images_loaded) {
                            stop_loading_strip();
                            viewer_loading_finished = true;
                        }
                    }
                });
            } else {
                viewer_loading_finished = true;
            }
        })
    })
}

function handle_media_viewer_thread_content_expand() {
    let tread_content_box = $('.thread-media-viewer-infos-content .thread-content-box');
    let original_content_height = tread_content_box[0].scrollHeight;
    let max_height = parseInt(tread_content_box.css('max-height'), 10);

    if(original_content_height > max_height) {
        let expandbutton = $('.thread-media-viewer-infos-content .expend-media-viewer-thread-content');
        expandbutton.removeClass('none');

        expandbutton.on('click', function() {
            let status = expandbutton.find('.status');
            if(status.val() == 'contracted') {
                tread_content_box.removeClass('thread-content-box-max-height');
                status.val('expanded');
            } else {
                tread_content_box.addClass('thread-content-box-max-height');
                status.val('contracted');
            }
        });
    }
}

function handle_viewer_reply_events(post) {
    handle_resource_like(post.find('.like-resource'));
    handle_tooltip(post);
    handle_post_display_buttons(post);
    // Handle reply edit editor
    post.find('textarea').each(function() {
        var simplemde = new SimpleMDE({
            element: this,
            hideIcons: ["guide", "heading", "image"],
            spellChecker: false,
            mode: 'markdown',
            showMarkdownLineBreaks: true,
        });
    });
    // ------------------------
    handle_open_edit_post_container(post);
    handle_save_edit_post(post);
    handle_exit_post_edit_changes(post);
    handle_open_delete_post_viewer(post);
    handle_close_shadowed_view(post);
    handle_login_lock(post);

    post.find('.button-with-suboptions').each(function() {
        handle_suboptions_container($(this));
    });
    handle_user_follow(post.find('.follow-user'));
    handle_up_vote(post.find('.votable-up-vote'));
    handle_down_vote(post.find('.votable-down-vote'));
    handle_expend_post_content(post);
}

$('.close-thread-media-viewer').on('click', function() {
    handle_viewer_closing();
});

$('.thread-viewer-left').on('click', function(event) {
    event.stopPropagation();
    
    if(viewer_media_count == 1) {
        $('.thread-viewer-left').addClass('none');
        $('.thread-viewer-right').removeClass('none');
    } else {
        $('.thread-viewer-right').removeClass('none');
    }

    let previous_media_url = viewer_medias[parseInt(viewer_media_count)-1];
    if(is_image(previous_media_url)) {
        let viewer_image = $('#thread-viewer-media-image');
        handle_thread_viewer_image(viewer_image);

        $('#thread-viewer-media-video').addClass('none');
        viewer_image.removeClass('none');

        viewer_image.attr('src', "");
        viewer_image.attr('src', viewer_medias[--viewer_media_count]);
    } else if(is_video(previous_media_url)) {
        let viewer_video = $('#thread-viewer-media-video');

        $('#thread-viewer-media-image').addClass('none');
        viewer_video.removeClass('none');

        viewer_video.attr('src', "");
        viewer_video.attr('src', viewer_medias[--viewer_media_count]);
        viewer_video[0].load();
    }

    $('#thread-media-viewer').find('.thread-counter-current-index').text(parseInt(viewer_media_count)+1);
});
$('.thread-viewer-right').on('click', function(event) {
    event.stopPropagation();

    $('.thread-viewer-left').removeClass('none');
    let next_media_url = viewer_medias[parseInt(viewer_media_count)+1];
    if(is_image(next_media_url)) {
        let viewer_image = $('#thread-viewer-media-image');
        handle_thread_viewer_image(viewer_image);
        $('#thread-viewer-media-video').addClass('none');
        viewer_image.removeClass('none');

        viewer_image.attr('src', "");
        viewer_image.attr('src', viewer_medias[++viewer_media_count]);
    } else if(is_video(next_media_url)) {
        let viewer_video = $('#thread-viewer-media-video');

        $('#thread-viewer-media-image').addClass('none');
        viewer_video.removeClass('none');

        viewer_video.attr('src', "");
        viewer_video.attr('src', viewer_medias[++viewer_media_count]);
        viewer_video[0].load();
    }
    $('#thread-media-viewer').find('.thread-counter-current-index').text(parseInt(viewer_media_count)+1);

    if(viewer_media_count == viewer_medias.length-1) {
        $('.thread-viewer-right').addClass('none');
    }
});

$('#thread-viewer-media-image,#thread-viewer-media-video').on('click', function(event) {
    event.stopPropagation();
});

$('.thread-media-viewer-content-section').on('click', function() {
    handle_viewer_closing();
})
function handle_viewer_closing() {
    viewer_media_count = 0;
    viewer_medias = [];
    
    let viewer = $('#thread-media-viewer');
    let viewer_video = $('#thread-viewer-media-video');
    viewer_video[0].pause();
    $('.thread-viewer-nav').addClass('none');
    viewer.find('.thread-viewer-medias-indicator').addClass('none');
    viewer.addClass('none');
    $('body').css('overflow-y', '');
    stop_loading_strip();
}
function handle_thread_viewer_image(image) {
    image.parent().imagesLoaded(function() {
        handle_viewer_media_logic(image);
    });
}

/**
 * Keep in mind that the result dimensions for the passed image must be in percentage (%)
 * because we call this handler in resize event of browser
 */
function handle_viewer_media_logic(image) {
    image.attr('style', '');
    let container_height = image.parent().height();
    let original_width = image.width();
    let original_height = image.height();

    if(original_width > original_height) {
        image.css('width', '100%');
        let new_width = image.width(); // get the new width after setting it to 100%
        let new_height = image.height(); // get newer height dimension because width is changed and affect the height

        if(new_height > container_height) {
            image.css('height', '100%');
            let ratio = container_height * original_width / original_height;
            image.css('width', ratio + 'px');
        } else {
            
        }
    } else {
        image.css('height', '100%');
    }
}

/**
 * This function take an image as its only parameter and stratch it to it container
 * The container must be its first direct parent
 * The function handle all image dimensions possibilities and container possibilities
 * Container possibilities (3 possibilites):
 *      container_width == container_height
 *      container_width > container_height
 *      container_width < container_height
 * Image possibilities (10 possibilities) ----------- THE CASES IN DOCS ARE MESSY THEY NEED TO BE UPDATED BECAUSE I UPDATED THE LOGIC -------------
 *      case#1 = container_width < container_height && image_width > image_height
 *      case#2 = container_width < container_height && image_width < image_height && image_height > container_height
 *      case#3 = container_width < container_height && image_width < image_height && image_height > container_height
 *      case#4 = container_width < container_height && image_width < image_height && image_height < container_height
 * 
 *      case#5 = container_width > container_height && image_width < image_height
 *      case#6 = container_width > container_height && image_width > image_height && image_height < container_height
 *      case#7 = container_width > container_height && image_width > image_height && image_height > container_height
 *      case#8 = container_width > container_height && image_width > image_height && image_height < container_height
 * 
 *      case#9 = container_width == container_width && image_width >= image_height
 *      case#10 = container_width == container_width && image_width < image_height
 */
function handle_media_image_dimensions(image) {
    let image_container = image.parent();
    let container_width = image_container.width();
    let container_height = image_container.height();

    let width = image.width();
    let height = image.height();

    if(container_width > container_height) {
        if(height > width) {
            if(height > container_height) {
                if(width < container_width) {
                    /** CASE #2 */
                    image.width(container_width);
                    image.css('height', 'max-content');
                } else {
                    /** CASE #3 */
                    image.height(container_height);
                    if(image.width() < container_width) {
                        // Calculate the ratio
                        let ratio = container_width / image.width();
                        let new_height = image.height() * ratio;
                        image.width(container_width);
                        image.height(new_height);
                    }
                }
            } else {
                /** CASE #4 */
                image.height(container_height);
                if(image.width() < container_width) {
                    // Calculate the ratio
                    let ratio = container_width / image.width();
                    let new_height = image.height() * ratio;
                    image.width(container_width);
                    image.height(new_height);
                }
            }
        } else if(height < width) {
            /** CASE #1 */
            if(height > container_height) {
                if(width < container_width) {
                    /** CASE #2 */
                    image.css('width', '100%');
                    image.css('height', 'max-content');
                } else {
                    /** CASE #3 */
                    image.css('height', '100%');
                    image.css('width', 'max-content');
                }
            } else {
                image.height('100%');
                image.css('width', '100%');
            }
        } else {
            image.css('width', '100%');
            image.css('height', 'max-content');
        }
    } else if(container_height < container_width) {
        if(width > height) {
            if(width > container_width) {
                if(height < container_height) {
                    /** CASE #2 */
                    image.height(container_height);
                } else {
                    /** CASE #3 */
                    image.width(container_width);
                    if(image.height() < container_height) {
                        // Calculate the ratio
                        let ratio = container_height / image.height();
                        let new_width = image.width() * ratio;
                        image.height(container_height);
                        image.height(new_width);
                    }
                }
            } else {
                /** CASE #4 */
                image.width(container_width);
                if(image.height() < container_height) {
                    // Calculate the ratio
                    let ratio = container_height / image.height();
                    let new_width = image.width() * ratio;
                    image.height(container_height);
                    image.height(new_width);
                }
            }
        } else {
            image.width(container_width);
            image.css('height', 'max-content');
        }
    } else {
        if(width >= height) {
            /** CASE #9 */
            image.height(container_height);
        } else {
            /** CASE #10 */
            image.width(container_width);
        }
    }
}

function handle_thread_video_dimensions(video) {
    let medias_container = video;
    while(!medias_container.hasClass('thread-medias-container')) {
        medias_container = medias_container.parent();
    }
    
    let videoWidth = video[0].videoWidth;
    let videoHeight = video[0].videoHeight;
}

// go to index resource give video media a specific class and then come back here to handle each video

$('.fade-loading').each(function(event) {
    let fade_item = $(this);
    window.setInterval(function(){
        let target_color;
        if(fade_item.css('background-color') == "rgb(230, 230, 230)") {
            target_color = "rgb(200, 200, 200)";
        } else {
            target_color = "rgb(230, 230, 230)";
        }
        fade_item.css({
            backgroundColor: target_color,
            transition: "background-color 0.8s"
        });
    }, 800);
});
function handle_fade_loading_removing(fade_container) {
    fade_container.imagesLoaded(function() {
        fade_container.find('.fade-loading').remove();
    });
}
function handle_fade_loading(fade_container) {
    fade_container.find('.fade-loading').each(function() {
        let fade_item = $(this);
        window.setInterval(function(){
            let target_color;
            if(fade_item.css('background-color') == "rgb(240, 240, 240)") {
                target_color = "rgb(200, 200, 200)";
            } else {
                target_color = "rgb(240, 240, 240)";
            }
            fade_item.css({
                backgroundColor: target_color,
                transition: "background-color 1.2s"
            });
        }, 1200);
    });
}

let strip_loading_interval;
function start_loading_strip() {
    let loading_strip = $('#loading-strip');
    let loading_strip_line = loading_strip.find('.loading-strip-line');
    loading_strip.removeClass('none');
    strip_loading_interval = window.setInterval(function(){
        loading_strip_line.animate({
            left: '100%'
        }, 800, function() {
            loading_strip_line.css('left', '-100%');
        });
    }, 800);
}
function stop_loading_strip() {
    $('#loading-strip').addClass('none');
    clearInterval(strip_loading_interval);
}

let viewer_posts_fetch_lock = true;
function handle_viewer_posts_fetchmore() {
    // thread-media-viewer-infos-content
    let fetchmore = $('#viewer-posts-fetch-more');
    let postsbox = $('#viewer-infos-section-box .thread-media-viewer-infos-content');

    postsbox.on('DOMContentLoaded scroll', function() {
        if(postsbox.scrollTop() + postsbox.innerHeight() + 52 >= postsbox[0].scrollHeight) {
            if(!viewer_posts_fetch_lock) return;
            viewer_posts_fetch_lock=false;

            let spinner = fetchmore.find('.spinner');
            let skip = $('#viewer-posts-container').find('.viewer-post-container:not(.viewer-ticked-post)').length;
            let thread_id = $('#viewer-infos-section-box').find('.thread-id').val();

            spinner.addClass('inf-rotate');
            $.ajax({
                type: 'get',
                url: `/thread/viewer/posts/fetchmore`,
                data: {
                    thread_id: thread_id,
                    skip: skip
                },
                success: function(response) {
                    // Append the returned posts
                    $(response.payload).insertBefore(fetchmore);
                    // Check if there are more posts; If not remove fetchmore spinner and detach scroll events from posts box
                    if(response.hasmore == false) {
                        postsbox.off()
                        fetchmore.remove();
                    }

                    // get appended unhandled posts
                    let unhandled_posts = 
                        $('#viewer-posts-container .viewer-post-container').slice(response.count*(-1));
                    // Handle their events
                    unhandled_posts.each(function() { handle_viewer_reply_events($(this)); });
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
                    viewer_posts_fetch_lock = true;
                }
            })
        }
    });
}

$('.move-to-thread-replies').each(function() {
    handle_move_to_thread_replies($(this));
});

function handle_move_to_thread_replies(button) {
    button.on('click', function() {
        if(button.hasClass('thread-show-replies')) {
            scroll_to_element('thread-show-posts-container', -100);
        } else if(button.hasClass('media-viewer-replies')) {
            
        }
    });
}

$('.remove-tick-from-thread').each(function() { handle_untick_thread($(this)); });
let untick_thread_lock = true;
function handle_untick_thread(button) {
    button.on('click', function() {
        if(!untick_thread_lock) return;
        untick_thread_lock = false;

        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let thread_id = button.find('.thread-id').val();

        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');
        buttonicon.addClass('none');

        $.ajax({
            type: 'patch',
            url: '/thread/posts/untick',
            data: {
                _token: csrf,
                thread_id: thread_id
            },
            success: function(response) {
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

                untick_thread_lock = true;
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
                buttonicon.removeClass('none');
            },
        })
    });
}

$('.save-thread').each(function() {
    handle_save_threads($(this));
});

let save_thread_lock = true;
function handle_save_threads(button) {
    button.on('click', function() {
        if(!save_thread_lock) return;
        save_thread_lock = false;

        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let thread_id = button.find('.thread-id').first().val();
        let status = button.find('.status').val().trim();

        button.attr('style', 'color: #313131; cursor: default;');
        buttonicon.addClass('none');
        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');

        $.ajax({
            type: 'post',
            url: `/thread/${thread_id}/save`,
            data: {
                _token: csrf,
                save_switch: (status == 'saved') ? 'unsave' : 'save'
            },
            success: function(response) {
                if(response == 1) {
                    button.find('.status').val('saved');
                    button.find('.unsave-icon').addClass('none');
                    button.find('.save-icon').removeClass('none');
                    button.find('.button-text').text(button.find('.unsave-text').val());
                    basic_notification_show(button.find('.saved-message').val());
                } else {
                    button.find('.status').val('not-saved');
                    button.find('.unsave-icon').removeClass('none');
                    button.find('.save-icon').addClass('none');
                    button.find('.button-text').text(button.find('.save-text').val());
                    basic_notification_show(button.find('.unsaved-message').val());
                }
                handle_save_post_sync(button);

                button.parent().css('display', 'none');
            },
            complete: function() {
                button.attr('style', '');
                buttonicon.removeClass('none');
                spinner.removeClass('inf-rotate');
                spinner.addClass('opacity0');

                save_thread_lock = true;
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(error, 'error');
            }
        });
    });
}

function handle_save_post_sync(button) {
    let thread_id = button.find('.thread-id').val();
    let status = button.find('.status').val();
    let from = button.find('.from').val();
    let target_button;

    if(from == 'media-viewer')
        target_button = $('#thread'+thread_id).find('.save-thread').first();
    else
        if(last_opened_thread)
            target_button = $('#viewer-infos-section-box').find('.save-thread').first();
        else
            return;

    if(status == 'saved') {
        target_button.find('.status').val('saved');
        target_button.find('.unsave-icon').addClass('none');
        target_button.find('.save-icon').removeClass('none');
        target_button.find('.button-text').text(target_button.find('.unsave-text').val());
    } else {
        target_button.find('.status').val('not-saved');
        target_button.find('.unsave-icon').removeClass('none');
        target_button.find('.save-icon').addClass('none');
        target_button.find('.button-text').text(target_button.find('.save-text').val());
    }
}

let basic_notification;
let basic_notif_timeout;
function basic_notification_show(message, icon='basic-notification-round-tick') {
    clearInterval(basic_notif_timeout);

    $('.basic-notification-container').find('.'+icon).removeClass('none');
    $('.basic-notification-container').find('.basic-notification-content').html(message);
    $('.basic-notification-container').removeClass('none');

    basic_notif_timeout = setTimeout(function() {
        $('.basic-notification-container').addClass('none');
        $('.basic-notification-container').find('.basic-notification-content').html('');
   }, 5000);
}

$('.basic-notification-container').on({
    mouseenter: function() {
        // Stop animation to keep the notification displayed
        clearTimeout(basic_notif_timeout);
    },
    mouseleave: function() {
        // Start animation to hide the notification after 5 seconds
        basic_notif_timeout = setTimeout(function() {
            $('.basic-notification-container').addClass('none');
            $('.basic-notification-container').find('.basic-notification-content').html('');
       }, 3000);
    }
});

// -------------------------------------    reporting section    -------------------------------------
let able_to_report = false;
$('.open-thread-report-container').on('click', function() {
    $('#post-report-container').addClass('none'); // close reply report container if it's already opened
    let container = $('#thread-report-container');

    container.css('opacity', '0');
    container.removeClass('none');
    container.animate({
        opacity: 1
    }, 200);

    container.find('.reportable-id').val($(this).find('.thread-id').val());
});
$('.open-post-report').on('click', function(event) {
    $('#thread-report-container').addClass('none');
    $(this).parent().css('display', 'none');
    /**
     * Stop propagation to close the button container because if propagation not stop container won't disappear 
     * because clicking on container or its content doesn't close the container
     */
    event.stopPropagation(); 
    let container = $('#post-report-container');
    let button = $(this);
    // Already reported not equal to zero means it is already reported
    if(button.find('.already-reported').val() != '0') {
        container.find('.already-reported-container').removeClass('none');
        container.find('.report-section').addClass('none');
    } else {
        container.find('.already-reported-container').addClass('none');
        container.find('.report-section').removeClass('none');

        container.find('.reportable-id').val($(this).find('.post-id').val());
    }
    // Display report container
    container.css('opacity', '0');
    container.removeClass('none');

    container.animate({
        opacity: 1
    }, 200);
});
$('.close-report-container').on('click', function() {
    let report_container = $(this);
    while(!report_container.hasClass('report-resource-container')) {
        report_container = report_container.parent();
    }

    close_report_container(report_container);
});
function close_report_container(container) {
    container.animate({
        opacity: 0
    }, 200, function() {
        container.addClass('none');
    })
}
$('.report-choice-input').on('change', function() {
    if($(this).is(':checked')) {
        able_to_report = true;
        $('.resource-report-option').css('background-color', '');
        $(this).css('background-color', 'rgb(242, 242, 242)');
        let value = $(this).val();

        let report_container = $(this);
        while(!report_container.hasClass('report-resource-container')) {
            report_container = report_container.parent();
        }

        let button = report_container.find('.submit-report-button');
        if(value == 'moderator-intervention') {
            $(this).parent().find('.child-to-be-opened').animate({
                height: '100%'
            }, 300);

            handle_report_textarea(report_container.find('.report-section-textarea'));
        } else {
            $('.child-to-be-opened').animate({
                height: '0'
            }, 300);
            button.removeClass('disabled-blue-button-style');
            button.addClass('blue-button-style');
        }
    }
});
$('.report-section-textarea').on('input', function() {
    handle_report_textarea($(this));
});
function handle_report_textarea(textarea) {
    able_to_report = false;
    let report_container = textarea;
    while(!report_container.hasClass('report-resource-container')) {
        report_container = report_container.parent();
    }

    let counter_container = textarea.parent().find('.report-content-counter');
    let maxlength = 500;
    let currentLength = textarea.val().length;

    let report_button = report_container.find('.submit-report-button');
    report_button.addClass('disabled-blue-button-style');

    counter_container.addClass('gray');
    if(currentLength == 0) {
        counter_container.attr('style', '');
        counter_container.find('.report-content-count').text('');
        counter_container.find('.report-content-count-phrase').text(counter_container.parent().find('.first-phrase-text').val());        
    } else if(currentLength > maxlength){
        let more_than_max = currentLength - maxlength;
        let chars_text = more_than_max > 1 ? counter_container.parent().find('.characters-text').val() : counter_container.parent().find('.characters-text').val().slice(0, -1);
        let counter_phrase = counter_container.parent().find('.too-long-text').val() + ' ' + more_than_max + ' ' + chars_text;
        counter_container.find('.report-content-count').text('');
        counter_container.find('.report-content-count-phrase').text(counter_phrase);

        counter_container.removeClass('gray');
        counter_container.css('color', '#e83131');
    } else {
        counter_container.attr('style', '');
        if(currentLength < 10) {
            let left_to_10 = 10 - currentLength;
            let counter_phrase = counter_container.parent().find('.more-to-go-text').val();
            counter_container.find('.report-content-count').text(left_to_10);
            counter_container.find('.report-content-count-phrase').text(counter_phrase);
        } else {
            let chars_left = maxlength - currentLength;
            let counter_phrase = counter_container.parent().find('.chars-left-text').val();
            counter_container.find('.report-content-count').text(chars_left);
            counter_container.find('.report-content-count-phrase').text(counter_phrase);
            
            report_button.removeClass('disabled-blue-button-style');
            able_to_report = true;
        }
    }
}

let submit_report_lock = true;
$('.submit-report-button').on('click', function() {
    if(!submit_report_lock || !able_to_report) return;
    submit_report_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let report_container = $(this);
    while(!report_container.hasClass('report-resource-container')) {
        report_container = report_container.parent();
    }

    let reportable_type = report_container.find('.reportable-type').val();
    let reportable_id = report_container.find('.reportable-id').val();
    let report_type = report_container.find('input[name="report"]:checked').val();

    let report_content = report_container.find('.report-section-textarea').val();
    report_content = report_content.trim();
    if(report_content.length < 10) {
        while(report_content.length != 10) {
            report_content += '%';
        }
    }

    let data = {
        _token: csrf,
        type: report_type
    };
    if(report_type == "moderator-intervention") data.body = report_content;

    spinner.removeClass('none');
    spinner.addClass('inf-rotate');
    button.addClass('disabled-blue-button-style');
    $.ajax({
        type: 'post',
        url: `/${reportable_type}/${reportable_id}/report`,
        data: data,
        success: function(response) {
            if(reportable_type == 'post') {
                // We have to set already reported to 1 inside report 
                let pid = reportable_id;
                $('.already-reported').each(function() {
                    if($(this).parent().find('.post-id').val() == pid) {
                        $(this).val('1'); // Set already reported to 1
                        return false;
                    }
                });
            }

            close_report_container(report_container);
            // Wait for closing annimation
            setTimeout(function() {
                report_container.find('.report-section').addClass('none');
                report_container.find('.already-reported-container').removeClass('none');
                basic_notification_show(button.parent().find('.reported-text').val(), 'basic-notification-round-tick');

                // Reset all inputs after submitting the report
                able_to_report = false;

                report_container.find('.report-choice-input').prop('checked', false);
                report_container.find('.child-to-be-opened').css('height', '0');
                $('.resource-report-option').css('background-color', '');
                $('.report-section-textarea').val('');
            }, 200);
        },
        error: function(response) {
            report_container.addClass('none');
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(error, 'error');
            able_to_report = true;
        },
        complete: function() {
            spinner.addClass('none');
            spinner.removeClass('inf-rotate');
            button.addClass('disabled-blue-button-style');
            submit_report_lock = true;
        }
    });
});
// -----------------------------------------------------------------------

$('.thread-media-options .open-media-viewer').on('click', function() {
    let medias_container = $(this);
    while(!medias_container.hasClass('thread-medias-container')) {
        medias_container = medias_container.parent();
    }

    medias_container.find('video').each(function() {
        $(this)[0].pause();
    });
});

$('.inline-button-style').on('click', function() {
    $(this).parent().find('.inline-button-style').removeClass('selected-inline-button-style');
    $(this).addClass('selected-inline-button-style');
});

let spinners_intervals = new Map();
let spinner_rotation = 0;
function start_spinner(spinner, spinner_interval_name) {
    spinner_rotation = 360;
    spinner.rotate(spinner_rotation);
    spinners_intervals.set(spinner_interval_name, 
        setInterval(function() {
            spinner_rotation+= 360;
            spinner.rotate(spinner_rotation);
        }, 1500, true)
    );
}

function stop_spinner(spinner, spinner_interval_name) {
    clearInterval(spinners_intervals.get(spinner_interval_name));
    spinner.rotate(0);
    spinner_rotation = 0;
}

handle_activity_load_more_button(
    $('#activities-sections-content').find('.activity-section-load-more'));
function handle_activity_load_more_button(button) {
    button.on('click', function() {
        let spinner = button.find('.spinner');
        let section_container = button;
        while(!section_container.hasClass('activities-section')) {
            section_container = section_container.parent();
        }
    
        spinner.removeClass('opacity0');
        spinner.addClass('inf-rotate');
    
        let activity_user = $('.activities-user').val();
        let present_threads_in_section = section_container.find('.thread-container-box').length;
        let section = button.find('.section').val();
    
        $.ajax({
            url: `/users/${activity_user}/activities/sections/generate?section=${section}&range=10&skip=${present_threads_in_section}`,
            type: 'get',
            success: function(response) {
                if(response.hasNext == false) {
                    button.addClass('none');
                }
    
                $(`${response.content}`).insertBefore(button);
    
                let unhandled_activities_threads = section_container.find('.thread-container-box').slice(response.count*(-1));
                
                unhandled_activities_threads.each(function() {
                    handle_html_entities_decoding($(this));
                    handle_element_suboption_containers($(this));
                    handle_section_suboptions_hinding($(this));
                    handle_thread_display($(this));
                    handle_tooltip($(this));
                    $(this).find('.handle-image-center-positioning').each(function() {
                        let image = $(this);
                        $(this).parent().imagesLoaded(function() {
                            handle_image_dimensions(image);
                        });
                    });
                    handle_restore_thread_button($(this));
                    handle_permanent_delete($(this));
                    handle_permanent_destroy_button($(this));
                    handle_hide_parent($(this));
                });
    
                let c = parseInt(section_container.find('.current-section-thread-count').text()) + parseInt(response.count);
                section_container.find('.current-section-thread-count').text(c);
            },
            complete: function() {
                spinner.removeClass('inf-rotate');
                spinner.addClass('opacity0');
            }
        });
    })
}

$('.countable-textarea').on('input', function() {
    let textarea = $(this);
    let container = $(this);
    while(!container.hasClass('countable-textarea-container')) {
        container = container.parent();
    }

    let counter_container = container.find('.textarea-counter-box');
    let counter = container.find('.textarea-chars-counter');
    let maxlength = container.find('.max-textarea-characters').val();
    let currentLength = textarea.val().length;

    counter_container.addClass('gray');
    counter.text(currentLength);
    if(currentLength <= maxlength) {
        counter_container.attr('style', '');
    } else {
        counter_container.removeClass('gray');
        counter_container.css('color', '#e83131');
    }
});

function handle_permanent_delete(thread) {
    thread.find('.thread-permanent-delete').on('click', function() {
        let container = $(this);
        while(!container.hasClass('suboptions-container')) container = container.parent();
        container.css('display', 'none');

        let thread_container = $(this);
        while(!thread_container.hasClass('thread-container-box')) thread_container = thread_container.parent();

        thread_container.find('.thread-permanent-deletion-dialog').css({
            display: 'block',
            opacity: 1
        });
    });
}

let destroy_thread_lock = true;
function handle_permanent_destroy_button(thread) {
    thread.find('.destroy-thread-button').on('click', function(event) {
        if(!destroy_thread_lock) return;
        destroy_thread_lock = false;

        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let threadid = button.parent().find('.thread-id').val();

        button.addClass('disabled-red-button-style');
        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');
        buttonicon.addClass('none');

        $.ajax({
            type: 'delete',
            url: `/thread/delete/force`,
            data: {
                _token: csrf,
                thread_id: threadid
            },
            success: function() {
                let threadcontainer = button;
                while(!threadcontainer.hasClass('thread-container-box')) threadcontainer = threadcontainer.parent();
                let activitysection = threadcontainer;
                while(!activitysection.hasClass('activities-section')) activitysection = activitysection.parent();
                threadcontainer.remove();
                
                let present_section_threads_count = activitysection.find('.current-section-thread-count');
                let global_section_threads_count = activitysection.find('.current-section-global-threads-count');

                present_section_threads_count.text(parseInt(present_section_threads_count.text()) - 1);
                global_section_threads_count.text(parseInt(global_section_threads_count.text()) - 1);
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
                spinner.addClass('opacity0');
                buttonicon.removeClass('none');
                button.removeClass('disabled-red-button-style');
                destroy_thread_lock = true;
            }
        });
    });
}

let restore_thread_lock = true;
function handle_restore_thread_button(thread) {
    thread.find('.restore-thread-button').on('click', function() {
        if(!restore_thread_lock) return;
        restore_thread_lock = false;

        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');

        button.attr('style', 'cursor: default; color: #171717');
        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');
        buttonicon.addClass('none');

        $.ajax({
            type: 'post',
            url: '/thread/restore',
            data: {
                _token: csrf,
                thread_id: button.find('.thread-id').val()
            },
            success: function(response) {
                window.location.href = response;
            },
            error: function(response) {
                spinner.removeClass('inf-rotate');
                spinner.addClass('opacity0');
                buttonicon.removeClass('none');
                button.attr('style', '');

                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                display_top_informer_message(error, 'error');
            },
            complete: function() {
                restore_thread_lock = true;
            }
        });

        return false;
    });
}

let move_thread_to_trash_lock = true;
$('#move-thread-to-trash').on('click', function() {
    if(!move_thread_to_trash_lock) return;
    move_thread_to_trash_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let successmessage = button.find('.success-message').val();
    let errormessage = button.find('.error-message').val();
    let go_to_archive = button.find('.go-to-archive').val();
    let threadid = button.find('.thread-id').val();

    button.addClass('disabled-typical-button-style');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');

    $.ajax({
        type: 'delete',
        url: `/thread/${threadid}`,
        data: {
            _token: csrf,
        },
        success: function(response) {
            if($('.page').length && $('.page').val() == "thread-show") {
                window.location.href = response;
            } else {
                $('#thread'+threadid).remove();
            }
            basic_notification_show(successmessage + "<a class='blue no-underline bold' href='" + response + "'>" + go_to_archive + "</a>");
            $('.close-global-viewer').trigger('click');
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let er = errorObject.message;
            if(errorObject.errors) {
                let errors = errorObject.errors;
                er = errors[Object.keys(errors)[0]][0];
            }
            display_top_informer_message(er, 'error');
        },
        complete: function() {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.removeClass('disabled-typical-button-style');

            move_thread_to_trash_lock = true;
        }
    });
});

function handle_thread_events(thread) {
    thread.find('.button-with-suboptions').each(function() {
        // Handle all suboptions of thread component
        handle_suboptions_container($(this));
    });
    handle_html_entities_decoding(thread);
    // Handle votes event
    handle_up_vote(thread.find('.votable-up-vote'));
    handle_down_vote(thread.find('.votable-down-vote'));
    // Handle like
    handle_resource_like(thread.find('.like-resource'));
    // Handle thread delete viewer && turn off posts viewer appearence
    handle_thread_shadowed_viewers(thread);
    // Handle close shadowed viewer
    handle_close_shadowed_view(thread);
    // Handle hide parent
    handle_hide_parent(thread);
    // Handle thread events
    handle_save_threads(thread.find('.save-thread'));
    handle_open_thread_delete_viewer(thread);
    handle_open_thread_replies_switch(thread);
    handle_thread_display(thread);
    handle_untick_thread(thread.find('.remove-tick-from-thread'));
    handle_tooltip(thread);
    handle_thread_visibility_switch(thread);
    handle_user_follow(thread.find('.follow-user'));
    handle_expend_button_appearence(thread);
    handle_expend(thread);
    // Keep in mind that images dimensions also handled withing lazy loading logic
    handle_thread_medias_containers(thread);
    handle_login_lock(thread);
    /**
     * Handle image fade loading when image is not fetched from server yet 
     * Remember fade removing is handled in lazy loading scroll feature when scroll reach the image it will
     * check at the end if the image comes with a fade loader and it will delete it immedietely when the image fully loaded
     */
    handle_fade_loading(thread);
    handle_open_media_viewer(thread);
    // Handle link copy
    handle_copy_thread_link(thread.find('.copy-thread-link'));
    handle_thread_user_card_fetch(thread);
    handle_thread_rtl(thread);

    // If thread is a poll we have to handlme all poll events
    if(thread.find('.thread-type').val() == 'poll') {
        handle_input_with_dynamic_label(thread);
        handle_option_deletion_view(thread);
        handle_option_vote(thread);
        handle_custom_radio(thread);
        handle_stop_propagation(thread);
        handle_custom_checkbox(thread);
        handle_fetch_remaining_poll_options(thread);
        handle_thread_poll_option_propose(thread);
    }
}

let index_fetch_more = $('.index-fetch-more');
let index_fetch_more_lock = true;
if(index_fetch_more.length) {
    $(window).on('DOMContentLoaded scroll', function() {
      // We only have to start loading and fetching data when user reach the explore more faded thread
      if(index_fetch_more.isInViewport()) {
            if(!index_fetch_more_lock) {
                return;
            }
            index_fetch_more_lock=false;
        
            let skip = $('.thread-container-box:not(.faded-thread-container)').length;
            let tab = $('.date-tab').val();
        
            let url = `/index/threads/loadmore?skip=${skip}&tab=${tab}`;
            $.ajax({
                type: 'get',
                url: url,
                success: function(response) {
                    $('#threads-global-container').append(response.content);
                    /**
                     * When appending threads we have to handle their events (Notice that response.count is the number of threads appended)
                     * Notice that we have faded thread container righgt after threads collection so we have to exclude it from unhandled threads collection
                     */
                    if(response.count) {
                        let unhandled_appended_threads = 
                        $('#threads-global-container .resource-container').slice(response.count*(-1));
                        
                        // When threads are appended we need to force lazy loading for the first appended thread for better ui experience
                        force_lazy_load(unhandled_appended_threads.first());
            
                        unhandled_appended_threads.each(function() {
                            handle_thread_events($(this));
                        });
                        // This will prevent appended suboptions from disappearing when cursor click on suboption containers
                        handle_document_suboptions_hiding();
                    }

                    if(!response.hasmore) {
                        index_fetch_more.remove();
                    }
                    index_fetch_more_lock = true;
                },
                error: function(response) {
        
                },
                complete: function(response) {
                    
                }
            });
      }
    });
}

let top_informer_timeout;
function display_top_informer_message(message, type="normal") {
    clearTimeout(top_informer_timeout);
    let informer_box = $('.top-informer-box');
    let informer_container = informer_box.find('.top-informer-container');
    informer_box.removeClass('none');
    informer_box.find('.top-informer-text').text(message);


    switch(type) {
        case 'normal':
            break;
        case 'warning':
            informer_container.find('.tiei-icon').addClass('none');
            informer_container.find('.top-informer-icon-box').removeClass('none');
            informer_container.find('.top-informer-error-icon').removeClass('none');
            informer_container.find('.top-informer-error-icon').css('fill', 'black');
            break;
        case 'error':
            informer_container.find('.tiei-icon').removeClass('none');
            informer_container.find('.tiei-icon').css('fill', 'rgb(104, 28, 28)');
            informer_container.find('.top-informer-icon-box').removeClass('none');
            informer_container.css('border-color', '#ff9696');
            informer_container.css('box-shadow', '0px 0px 6px 0px #ffd4d4');
            informer_container.css('background-color', 'rgb(255, 237, 237)');
            informer_container.find('.top-informer-text').css('color', 'rgb(104, 28, 28)');
            informer_container.find('.top-informer-error-icon').removeClass('none');
            break;
    }
    
    // This timeout will wait for 6 sec before close the message
    top_informer_timeout = setTimeout(function() {
        informer_box.addClass('none');
        informer_box.find('.top-informer-text').text('');
   }, 6000);
}

$('.remove-top-informer-container').on('click', function() {
    clearTimeout(top_informer_timeout);
    $('.top-informer-box').addClass('none');
    $('.top-informer-box').find('.top-informer-text').text('');
});

let fcc_lock = true;
function handle_fcc(button) {
    button.on('click', function() {
        if(!fcc_lock) return false;
        fcc_lock = false;
        
        let button = $(this);
        let forum_id = button.find('.forum-id').val();
        let changer_box = button;
        while(!changer_box.hasClass('forum-category-changer-box')) changer_box = changer_box.parent();
        let spinner = changer_box.find('.fcc_spinner');
    
        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');
    
        $.ajax({
            url: `/forums/${forum_id}/categories`,
            type: 'get',
            success: function(response) {
                // First change the icon
                changer_box.find('.fcc-selected-forum-ico').html(button.find('.forum-ico').html());
                changer_box.find('.fcc-selected-forum').text(button.find('.forum-name').text());
    
                let categories = JSON.parse(response);
                changer_box.find('.fcc-category:not(:first)').remove();
    
                let first_iteration = true;
                $.each(categories, function(id, category){
                    if(first_iteration) {
                        first_iteration = false;
                        changer_box.find('.fcc-category:first').attr('href', category.forum_link);
                    } else {
                        $('.fcc-categories-container').append(`
                            <a href="${category.link}" class="no-underline black thread-add-suboption fcc-category flex align-center">
                                <span class="thread-add-category-val">${category.category}</span>
                            </a>
                        `);
                    }
                });
            },
            complete: function() {
                button.attr('style', '');
                fcc_lock = true;
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
                stop_spinner(spinner, 'fcc_spinner');
    
                let forums_container = button;
                while(!forums_container.hasClass('suboptions-container')) {
                    forums_container = forums_container.parent();
                }
    
                forums_container.css('display', 'none');
            }
        })
    
        return false;
    });
}
function handle_search_path_switcher(container) {
    container.find('.search-path-switcher').each(function() {
        $(this).on('click', function() {
            container.find('.search-path-switcher').removeClass('search-path-switcher-selected');
            $(this).addClass('search-path-switcher-selected');
            let path = $(this).find('.search-path').val();
            container.find('.quick-access-search-form').attr('action', path);
        });
    })
}

let quick_access_fetched = false;
$('.quick-access-generate').on('click', function() {
    if(quick_access_fetched) {
        return;
    }

    $.ajax({
        type: 'get',
        url: '/generatequickaccess',
        success: function(response) {
            $('#quick-access-content-box').html('');
            $('#quick-access-content-box').html(response);

            handle_toggling($('#quick-access-box'));
            handle_search_path_switcher($('#quick-access-box'));
            handle_fcc($('#quick-access-box').find('.forum-category-changer'));
            $('#quick-access-box .nested-soc-button').each(function() {
                handle_nested_soc($(this));
            });
            quick_access_fetched = true;
        }
    })
});

let fetched_categories_forums = [];
$('.forumslist-categories-load').on('click', function() {
    let forum = $(this).find('.forum').val();
    let button = $(this);
    if(fetched_categories_forums.includes(parseInt(forum))) {
        return;
    }
    fetched_categories_forums.push(parseInt(forum));

    $.ajax({
        url: `/forums/${forum}/categories`,
        type: 'get',
        success: function(response) {
            let categories = JSON.parse(response);
            let categories_html = "";
            $.each(categories, function(id, category){
                categories_html +=
                `
                    <div class="my8" style="margin-left: 30px">
                        <a href="${category.link}" class="bold blue fs13 no-underline">${category.category}</a>
                    </div>
                `;
            });
            button.parent().find('.forumslist-categories').html(categories_html);
        }
    })
})

$('.dynamic-input-wrapper').each(function() {
    handle_input_with_dynamic_label($(this));
});
function handle_input_with_dynamic_label(input_wrapper) {
    input_wrapper.find('.input-with-dynamic-label').on({
        focus: function() {
            let input = $(this);
            if(input_wrapper.find('.input-with-dynamic-label').val().length == 0) {
                input_wrapper.find('.dynamic-label').animate({
                    fontSize: '10px',
                    top: '10px'
                }, 100, function() {
                    input_wrapper.find('.dynamic-label').css('color', '#2ca0ff');
                    input.css('paddingTop', '18px');
                    input.css('paddingBottom', '12px');
                });
            } else
            input_wrapper.find('.dynamic-label').css('color', '#2ca0ff');
        },
        focusout: function() {
            let input = $(this);
            if(input_wrapper.find('.input-with-dynamic-label').val().length == 0) {
                input_wrapper.find('.dynamic-label').animate({
                    fontSize: '14px',
                    top: '50%'
                }, 100, function() {
                    input_wrapper.find('.dynamic-label').css('color', '#555');
                    input.css('padding', '15px 12px');
                });
            } else
            input_wrapper.find('.dynamic-label').css('color', '#555');
        }
    });
}
function handle_container_dynamic_inputs(container) {
    container.find('.dynamic-input-wrapper').each(function() {
        handle_input_with_dynamic_label($(this));
    });
}

$('.custom-checkbox-button').on('click', function() {
    trigger_checkbox_button($(this));
});
function handle_custom_checkbox(component) {
    component.find('.custom-checkbox-button').each(function() {
        $(this).on('click', function() {
            trigger_checkbox_button($(this));
        })
    });
}
function trigger_checkbox_button(button) {
    let status = button.find('.checkbox-status');
    if(status.val() == '0') {
        button.find('.custom-checkbox').addClass('custom-checkbox-checked');
        button.find('.custom-checkbox-tick').removeClass('none');
        status.val('1');
    } else {
        button.find('.custom-checkbox').removeClass('custom-checkbox-checked');
        button.find('.custom-checkbox-tick').addClass('none');
        status.val('0');
    }
}

$('.custom-radio-button').on('click', function() {
    trigger_radio_button($(this));
});
function handle_custom_radio(component) {
    component.find('.custom-radio-button').each(function() {
        $(this).on('click', function() {
            trigger_radio_button($(this));
        })
    });
}
function trigger_radio_button(button) {
    let status = button.find('.radio-status');
    if(status.val() == 1) {
        status.val('0');
        button.find('.radio-check-tick').addClass('none');
        button.find('.custom-radio').removeClass('custom-radio-checked');
        return;
    }
    let group = button;
    while(!group.hasClass('radio-group')) {
        group = group.parent();
    }
    // Remove all others' radio buttons style and reset their status
    group.find('.radio-status').val('0');
    group.find('.radio-check-tick').addClass('none');
    group.find('.custom-radio').removeClass('custom-radio-checked');
    // handle the new pressed radio button
    button.find('.radio-status').val('1');
    button.find('.radio-check-tick').removeClass('none');
    button.find('.custom-radio').addClass('custom-radio-checked');
}

$('.vote-option').each(function() {
    handle_option_vote($(this).parent());
});

/**
 * The reason we use this queue is because we want to handle only one vote at the time
 * If two votes came at the same time we take the first one and handle it, and the second one we push it to the queue,
 * then when the ajax call terminate, we check the queue if there's a vote there, if it is we call take that first element
 * in the queue and trigger the click event to handle it again
 */
//let votes_queue = [];
function handle_option_vote(component) {
    component.find('.vote-option').each(function() {
        let votebutton = $(this);
        votebutton.on('click', function() {
            let votecount = votebutton.parent().find('.option-vote-count');
            let optionid = votebutton.find('.optionid').val();
            // fetch option component
            let optioncomponent = votebutton;
            while(!optioncomponent.hasClass('poll-option-box'))
                optioncomponent = optioncomponent.parent();
            // Vote the option
            $.ajax({
                url: `/options/vote`,
                type: 'post',
                data: {
                    _token: csrf,
                    option_id: optionid
                },
                success: function(response) {
                    // response will return how much votes table increment or decrement 
                    // (-1: vote deleted; 1: vote added; 0: when poll owner disable multiple choice and user already vote an option and then choose another one)
                    let result = parseInt(votecount.text()) + parseInt(response.diff);
                    votecount.text(result);
    
                    // Get poll options container
                    let poll_options_box = votebutton;
                    while(!poll_options_box.hasClass('thread-poll-options-container')) {
                        poll_options_box = poll_options_box.parent();
                    }
    
                    // If multiple options are disabled (radio) and the vote is flipped we handle the situation
                    if(poll_options_box.hasClass('radio-group')) {
                        if(response.type == "flipped") {
                            let option_vote_removed = poll_options_box.find('.voted[value=1]').parent();
                            let new_deleted_option_votevalue = parseInt(option_vote_removed.find('.option-vote-count').text())-1;
                            option_vote_removed.find('.option-vote-count').text(new_deleted_option_votevalue);
                            option_vote_removed.find('.voted').val('0');
                        }
                    }
    
                    // If user delete vote we have to set voted value to 0 otherwise we set it to 1
                    if(response.type == 'deleted')
                        optioncomponent.find('.voted').val(0);
                    else
                        optioncomponent.find('.voted').val(1);
    
                    // Reorder options after votes based on number of votes (using bubble sort)
                    let count = poll_options_box.find('.poll-option-box').length;
                    let i, j;
                    for (i = 0; i < count-1; i++) {
                        // Last i elements are already in place
                        for (j = 0; j < count-i-1; j++) {
                            let optiona = $(poll_options_box.find('.poll-option-box')[j]);
                            let optionb = $(poll_options_box.find('.poll-option-box')[j+1]);
                            let va = parseInt(optiona.find('.option-vote-count').text());
                            let vb = parseInt(optionb.find('.option-vote-count').text());
    
                            if(va < vb) {
                                optiona.insertAfter(optionb);
                            }
                        }
                    }

                    if(count > 5)
                        move_element_by_id(optioncomponent.attr('id'), 100);
    
                    // Adjusting percentage
                    let total_poll_votes = poll_options_box.find('.total-poll-votes');
                    switch(response.type) {
                        // Here before handling the percentages we have to adjust the total poll votes first based on response.diff
                        case 'added':
                            total_poll_votes.val(parseInt(total_poll_votes.val()) + 1);
                            adjust_poll_options_percentage(poll_options_box);
                            break;
                        case 'deleted':
                            total_poll_votes.val(parseInt(total_poll_votes.val()) - 1);
                            adjust_poll_options_percentage(poll_options_box);
                            break;
                        case 'flipped':
                            // Here the votes are flipped so we don't have to edit the poll options votes because it stays the same
                            adjust_poll_options_percentage(poll_options_box);
                            break;
                    }
                },
                error: function(response) {
                    let errorObject = JSON.parse(response.responseText);
                    let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                    if(errorObject.errors) {
                        let errors = errorObject.errors;
                        error = errors[Object.keys(errors)[0]][0];
                    }
                    display_top_informer_message(error, 'error');

                    if(votebutton.hasClass('custom-radio-button')) {
                        let radio = votebutton.find('.custom-radio');
                        if(radio.hasClass('custom-radio-checked')) {
                            radio.removeClass('custom-radio-checked');
                            radio.find('.radio-check-tick').addClass('none');
                            radio.find('.radio-status').val('0');
                        } else {
                            radio.addClass('custom-radio-checked');
                            radio.find('.radio-check-tick').removeClass('none');
                            radio.find('.radio-status').val('1');
                        }
                    } else if(votebutton.hasClass('custom-checkbox-button')) {
    
                    }
                },
                complete: function() {
                    
                }
            });
        });
    })
}

function adjust_poll_options_percentage(options_wrapper) {
    let total_poll_votes = options_wrapper.find('.total-poll-votes');
    options_wrapper.find('.poll-option-box').each(function() {
        let option_votes_count = $(this).find('.option-vote-count').text();
        let new_votes_percentage;
        if(parseInt(total_poll_votes.val()) == 0)
            new_votes_percentage = 0;
        else
            new_votes_percentage = Math.floor(parseInt(option_votes_count) * 100 / parseInt(total_poll_votes.val()));

        // Here we set the new percentage to the counter as well as to div strip
        $(this).find('.option-vote-percentage').text(new_votes_percentage);
        $(this).find('.vote-option-percentage-strip').css('width',new_votes_percentage+'%');
    });
}

let delete_poll_option_lock = true;
$('#delete-poll-option').on('click', function() {
    if(!delete_poll_option_lock) return;
    delete_poll_option_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let successmessage = button.find('.success-message').val();
    let optionid = button.find('.option-id').val();

    button.addClass('disabled-typical-button-style');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');

    $.ajax({
        url: `/options/delete`,
        type: 'delete',
        data: {
            _token: csrf,
            option_id: optionid
        },
        success: function(response) {
            // First we delete the option component from the poll
            let optionscontainer;
            $('.poll-option-box').each(function() {
                if($(this).find('.optionid').first().val() == optionid) {
                    // Before removing the option component we have to get its parent to use it to adjust percentage
                    // and also we need to adjust total vote value
                    optionscontainer = $(this).parent();
                    let total_poll_votes = optionscontainer.find('.total-poll-votes');
                    let diff = parseInt($(this).find('.option-vote-count').text());
                    total_poll_votes.val(parseInt(total_poll_votes.val())-diff);
                    $(this).remove();
                    return false;
                }
            });

            $('.close-global-viewer').trigger('click');
            basic_notification_show(successmessage);
            adjust_poll_options_percentage(optionscontainer);
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
            button.removeClass('disabled-typical-button-style');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            delete_poll_option_lock = true;
        }
    })
});

$('.open-option-delete-check-view').each(function() {
    handle_option_deletion_view($(this).parent());
});
function handle_option_deletion_view(component) {
    let buttons = component;
    if(!component.hasClass('open-option-delete-check-view'))
        buttons = component.find('.open-option-delete-check-view');
    
    buttons.each(function() {
        $(this).on('click', function() {
            let option = $(this);
            while(!option.hasClass('poll-option-box')) option = option.parent();

            $('#poll-option-deletion-viewer').find('.option-id').val(option.find('.option-id').val());
            $('#poll-option-deletion-viewer').find('.option-content').text(option.find('.poll-option-value').text());
            $('#poll-option-deletion-viewer').removeClass('none');
    
            disable_page_scroll();
        });
    });
}

$('.remove-parent').on('click', function() {
    $(this).parent().remove();
});
$('.close-parent').on('click', function() {
    $(this).parent().addClass('none');
});
$('.close-global-viewer').on('click', function() {
    let globalviewer = $(this);
    while(!globalviewer.hasClass('global-viewer')) {
        globalviewer = globalviewer.parent();
    }

    if($('.global-viewer').not('.none').length == 1)
        enable_page_scroll();
    globalviewer.addClass('none');
});

$('.poll-option-validation').each(function(event) {
    handle_poll_option_keyup($(this));
});

function handle_poll_option_keyup(optioninput) {
    optioninput.on('keyup', function(event) {
        let value = $(this).val().trim();

        let options_box = $(this);
        let option_container = $(this);
        while(!options_box.hasClass('poll-options-wrapper')) options_box = options_box.parent();
        while(!option_container.hasClass('poll-option-box')) option_container = option_container.parent();
        
        // The following function call will set uniqueness hidden input to wether the uniqueness pass or not
        poll_options_uniqueness_check(options_box, option_container, value);
    })
}
function poll_options_uniqueness_check(options_wrapper, current_optionbox, value) {
    let optionsvalues = [];
    if(value == '')
        current_optionbox.find('.poll-option-input-error').addClass('none');
    else {
        options_wrapper.find('.poll-option-value').each(function() {
            let value = $(this).is('input') ? $(this).val().trim() : $(this).text().trim();
            if(value != '')
                optionsvalues.push(value);
        });
        
        if(optionsvalues.filter(item => item == value).length > 1) { // If current option value exists twice in options collection
            current_optionbox.find('.poll-option-input-error').find('.error').text(options_wrapper.find('.uniqueness-error').val());
            current_optionbox.find('.poll-option-input-error').removeClass('none');
        } else
            current_optionbox.find('.poll-option-input-error').addClass('none');
    }

    /**
     * After validating the current option uniqueness, we need to handle a special situation
     * let's say we have 2 options like following : 
     *      option 1 : foo
     *      option 2 : bar
     * Now let's say we add a third option with value foo
     *      option 3 : foo
     * here we'll get uniqueness error in third option
     * But what if the user go to the first option and edit foo to 'kkk'; In this case we need to remove
     * the uniqueness error from option 3 becuase it is not duplicated any more
     */
    let uniqueness_failures = 0;
    options_wrapper.find('.poll-option-value').each(function() {
        let optionvalue = $(this).is('input') ? $(this).val().trim() : $(this).text().trim();
        if(optionvalue == '') return;
        if(optionsvalues.filter(item => item == optionvalue).length == 1) {
            let optionbox = $(this);
            while(!optionbox.hasClass('thread-poll-option-container')) optionbox = optionbox.parent();
            optionbox.find('.poll-option-input-error').addClass('none');
        } else
            uniqueness_failures++;
    });

    if(uniqueness_failures)
        options_wrapper.find('.uniqueness-pass').val('0');
    else
        options_wrapper.find('.uniqueness-pass').val('1');
}

function handle_thread_poll_option_propose(thread) {
    thread.find('.poll-option-propose .poll-option-value').on('keyup', function(event) {
        let value = $(this).val().trim();
        let option = thread.find('.poll-option-propose');
        option.find('.poll-option-input-error').addClass('none');
        /**
         * Uniqueness will not be handled here because user will get error when option
         * inserted already exists or options number reaches maximum allowed limit
         */
        if(event.key == 'Enter') {
            let error_container = option.find('.poll-option-input-error');
            if(value.trim() == '') {
                error_container.find('.error').text(option.find('.length-error').val());
                error_container.removeClass('none');
                return;
            } else
                error_container.addClass('none');

            let input = option.find('.poll-option-value');
            let poll_id = option.find('.poll-id').val();
            input.attr('disabled', true);

            $.ajax({
                type: 'post',
                data: {
                    _token: csrf,
                    poll_id: poll_id,
                    content: input.val(),
                },
                url: '/options',
                success: function(response) {
                    let optionid = response;
                    $.ajax({
                        url: `/options/${optionid}/component/generate`,
                        success: function(response) {
                            let optioncomponent = response;
                            let loadmore = thread.find('.fetch-remaining-poll-options');
                            if(loadmore.length) {
                                loadmore.find('.scroll-by-put-thread-into-bottom-of-viewport').val(1);
                                loadmore.trigger('click');
                            }
                            else {
                                thread.find('.thread-poll-options-container').append(optioncomponent);
                                let unhandled_option = thread.find('.thread-poll-options-container .poll-option-box').last();
                                handle_option_events(unhandled_option);
                            }

                            input.val('');
                            basic_notification_show(option.find('.success-message').val());
                            $('body').trigger('click');
                        },
                        complete: function() {
                            input.attr('disabled', false);
                        }
                    });
                    
                },
                error: function(response) {
                    input.attr('disabled', false);

                    let errorObject = JSON.parse(response.responseText);
                    let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                    if(errorObject.errors) {
                        let errors = errorObject.errors;
                        error = errors[Object.keys(errors)[0]][0];
                    }
                    display_top_informer_message(error, 'error');
                }
            })
            
            return;
        }
    })
}

// old name = handle_options_display_switch
let fetch_remaining_poll_options_lock = true;
function handle_fetch_remaining_poll_options(thread) {
    thread.find('.fetch-remaining-poll-options').on('click', function() {
        if(!fetch_remaining_poll_options_lock) return;
        fetch_remaining_poll_options_lock = false;

        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let thread_id = button.find('.thread-id').val();
        
        let box = button;
        let thread = button;
        while(!box.hasClass('thread-poll-options-container')) box = box.parent();
        while(!thread.hasClass('thread-container-box')) thread = thread.parent();

        let skip = box.find('.poll-option-box').length;

        buttonicon.addClass('none');
        spinner.removeClass('opacity0');
        spinner.addClass('inf-rotate');

        $.ajax({
            type: 'post',
            url: '/thread/poll/fetch-remaining-options',
            data: {
                _token: csrf,
                thread_id: thread_id,
                skip: skip
            },
            success: function(response) {
                box.append(response.payload);
                button.remove();

                let unhandled_options = box.find('.poll-option-box').slice(response.count*(-1));
                unhandled_options.each(function() { handle_option_events($(this)); });
                if(button.find('.scroll-by-put-thread-into-bottom-of-viewport').val() == 1)
                    scroll_to_element_and_place_it_to_bottom_viewer(thread);
                
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
                fetch_remaining_poll_options_lock = true;
            }
        })
    });
}

function handle_option_events(option) {
    handle_option_vote(option);
    handle_option_deletion_view(option.find('.open-option-delete-check-view'));
    handle_stop_propagation(option);
    handle_custom_radio(option.find('.custom-radio-button').parent());
    handle_custom_checkbox(option.find('.custom-checkbox-button').parent());
}

$('.copy-text').each(function() {
    handle_text_copy($(this));
});

function handle_text_copy(button) {
    button.on('click', function(event) {
        $(this).parent().find('.text-to-copy').trigger('select');
        document.execCommand("copy");
        basic_notification_show($(this).find('.copied').val(), 'basic-notification-round-tick');

        event.stopPropagation();
    });
}

$('.custom-drop-down-option').on('click', function(event) {
    event.stopPropagation();
    let option = $(this);
    let box = option;
    while(!box.hasClass('custom-dropdown-box')) box = box.parent();

    let dropdown_selector = box.find('.custom-dropdown-selector');
    let selected_value = option.find('.custom-dropdown-option-value').val();
    let selected_option_text = option.find('.custom-dropdown-option-text').text();
    // set value
    box.find('.custom-dropdown-value').val(selected_value);
    // set option text to selector text
    dropdown_selector.find('.custom-dropdown-selected-option-text').text(selected_option_text);
    // close options container after selecting option
    box.find('.custom-dropdown-options-container').css('display', 'none');
    // Assign selected class to the selected option
    box.find('.custom-drop-down-option').removeClass('custom-dropdown-option-selected');
    option.addClass('custom-dropdown-option-selected');
});

$('.open-image-on-image-viewer').each(function() {
    handle_image_open($(this).parent());
});
function handle_image_open(component) {
    component.find('.open-image-on-image-viewer').each(function() {
        $(this).on('click', function() {
            let viewer = $('#image-viewer');
            let vimage = viewer.find('.image');

            vimage.attr('src', $(this).attr('src'));
            viewer.removeClass('none');
            handle_viewer_media_logic(vimage);
        });
    });
}

$('#image-viewer').on('click', function() {
    $(this).addClass('none');
});

$('#image-viewer .image').on('click', function(event) {
    event.stopPropagation();
});

$('.get-ws-simple-resource-render').each(function() { handle_ws_resource_simple_render($(this)); });
let ws_resource_simple_render_fetched = []; // Those are resources already fetched
let ws_resource_simple_render_pending = []; // Those are resource that are waiting to be fetched
function handle_ws_resource_simple_render(button) {
    button.on('click', function(event) {
        let button = $(this);
        let buttonicon = button.find('.icon-above-spinner');
        let resource_id = button.find('.resource-id').val();
        let resource_type = button.find('.resource-type').val();
        let resource_index = button.find('.index').val();
        let resource_section = button.parent().find('.simple-resource-render-container');
    
        /**
         * Here we want to check if the resource is already fetched; If so we only deal with the button as toggler
         * If not, we have to check if the resource is wait for resource to come from request; if so we prevent click;
         * If not we commit a request to fetch the resource
         */
        if(is_simple_resource_render_fetched(resource_index)) {
            if(resource_section.hasClass('none')) {
                buttonicon.css({
                    transform:'rotate(90deg)',
                    '-ms-transform':'rotate(90deg)',
                    '-moz-transform':'rotate(90deg)',
                    '-webkit-transform':'rotate(90deg)',
                    '-o-transform':'rotate(90deg)'
                });
                resource_section.removeClass('none');
            } else {
                buttonicon.css({
                    transform:'rotate(0deg)',
                    '-ms-transform':'rotate(0deg)',
                    '-moz-transform':'rotate(0deg)',
                    '-webkit-transform':'rotate(0deg)',
                    '-o-transform':'rotate(0deg)'
                });
                resource_section.addClass('none');
            }
        } else {
            if(is_simple_resource_render_pending(resource_index)) return;
            ws_resource_simple_render_pending.push([resource_index]);
        
            let spinner = button.find('.spinner');
            buttonicon.addClass('none');
            spinner.removeClass('opacity0');
            spinner.addClass('inf-rotate');
        
            $.ajax({
                type: 'post',
                url: '/resource/simple-render',
                data: {
                    _token: csrf,
                    resource_id: resource_id,
                    resource_type: resource_type
                },
                success: function(response) {
                    ws_resource_simple_render_fetched.push([resource_index]);
        
                    spinner.addClass('opacity0');
                    spinner.removeClass('inf-rotate');
                    buttonicon.removeClass('none');
                    buttonicon.css({
                        transform:'rotate(90deg)',
                        '-ms-transform':'rotate(90deg)',
                        '-moz-transform':'rotate(90deg)',
                        '-webkit-transform':'rotate(90deg)',
                        '-o-transform':'rotate(90deg)'
                    });
        
                    resource_section.html(response);
                    handle_toggling(resource_section);
                    handle_tooltip(resource_section);
                    handle_expend(resource_section);
                    resource_section.removeClass('none');
                },
                error: function(response) {
                    spinner.addClass('opacity0');
                    spinner.removeClass('inf-rotate');
                    buttonicon.removeClass('none');
                },
                complete: function() {
                    remove_simple_resource_render_from_pending(resource_index);
                    get_ws_simple_resource_render_lock = true;
                }
            })
        }
    
    });
}

function is_simple_resource_render_fetched(resource_index) {
    let fetched = false;
    $(ws_resource_simple_render_fetched).each(function(index, item) {
        if(item == resource_index) {
            fetched = true;
            return false;
        }
    });

    return fetched;
}
function is_simple_resource_render_pending(resource_index) {
    let fetched = false;
    $(ws_resource_simple_render_pending).each(function(index, item) {
        if(item == resource_index) {
            fetched = true;
            return false;
        }
    });

    return fetched;
}
function remove_simple_resource_render_from_pending(resource_index) { // means we have to delete it from pending
    $(ws_resource_simple_render_pending).each(function(index, item) {
        if(item == resource_index) {
            ws_resource_simple_render_pending.splice(index, 1);
            return false;
        }
    });
}
