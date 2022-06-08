
let domain = window.location.host;
$('.search-for-users-input').on('click', function(event) {
  if($(this).val() != '' && $(this).val() == last_user_searchquery) {
    $(this).parent().find('.search-result-container').removeClass('none');
  }
  event.stopPropagation();
});

let last_user_searchquery = "";
let usearch_lock = true;
$('.search-for-users-input').on('keyup', function(event) {
  let value = $(this).val();
  if(value == '') {
    $(this).parent().find('.search-result-container').addClass('none');
    return;
  }

  if (event.key === 'Enter' || event.keyCode === 13) {
    if(value != last_user_searchquery) {
      $(this).parent().find('.result-box').html('');
        
      let searchinput = $(this);
      let result_container = searchinput.parent().find('.search-result-container');
      let loadingfade = result_container.find('.search-result-faded');
      let noresult = result_container.find('.search-no-results');
  
      noresult.addClass('none');

      loadingfade.removeClass('none');
      result_container.removeClass('none');
      last_user_searchquery = value;
    
      $.ajax({
        url: '/admin/search/users?k=' + value,
        success: function(response) {
          let result = response.content;
  
          if(result.length) {
            let result_box = result_container.find('.result-box');
            result_box.html('');
            let user_search_component = result_container.find('.search-user-record-skeleton');

            insert_users_search_records_to_result_box(result, user_search_component, result_box);

            if(response.hasnext) $('#admin-user-search-fetch-more').removeClass('none');
            else $('#admin-user-search-fetch-more').addClass('none');
          } else {
            noresult.removeClass('none');
          }
        },
        complete: function() {
          loadingfade.addClass('none');
          usearch_lock = true;
        }
      });
    } else {
      $(this).parent().find('.search-result-container').removeClass('none');
    }
  }
});

// Handle thread search fetch more
let user_search_fetch_more = $('#admin-user-search-fetch-more');
let user_search_result_box = user_search_fetch_more.parent().find('.result-box');
let user_search_fetch_more_lock = true;
$('#admin-user-search-fetch-more').on('click', function() {
  if(!user_search_fetch_more_lock) return;
  user_search_fetch_more_lock=false;

  let button = $(this);
  let spinner = button.find('.spinner');

  button.css('cursor', 'not-allowed');
  spinner.addClass('inf-rotate');
  spinner.removeClass('opacity0');

  let present_records_count = user_search_result_box.find('.search-user-record').length;

  $.ajax({
      url: `/admin/search/users/fetchmore?k=${last_user_searchquery}&skip=${present_records_count}`,
      type: 'get',
      success: function(response) {
        let result = response.content;
        let result_box = user_search_fetch_more.parent().find('.result-box');
        let user_search_component = user_search_fetch_more.parent().find('.search-user-record-skeleton');

        insert_users_search_records_to_result_box(result, user_search_component, result_box);

        if(response.hasnext) $('#admin-user-search-fetch-more').removeClass('none');
        else $('#admin-user-search-fetch-more').addClass('none');
      },
      complete: function() {
        user_search_fetch_more_lock = true;
        spinner.removeClass('inf-rotate');
        spinner.addClass('opacity0');
        button.css('cursor', 'pointer');
      }
  });
});

// This function take result from ajax users search request and append it in form of 
// result components to result container
// user_search_component: is user result component as a blueprint for result entities
function insert_users_search_records_to_result_box(records, user_search_component, resultbox) {
  for(let i = 0; i < records.length; i++) {
    let clonedcomponent = user_search_component.clone();
    clonedcomponent.removeClass('search-user-record-skeleton');
    clonedcomponent.removeClass('none');
    clonedcomponent.find('.us-fullname').text(records[i].firstname + ' ' + records[i].lastname);
    clonedcomponent.find('.us-username').text(records[i].username);
    if(records[i].avatar) {
      if(records[i].avatar != records[i].provider_avatar) {
        clonedcomponent.find('.us-avatar')[0].src = '/' + records[i].avatar;
      } else
      clonedcomponent.find('.us-avatar').attr('src', records[i].avatar);
    } else {
      clonedcomponent.find('.us-avatar')[0].src = '/users/defaults/medias/avatars/100-h.png';
    }
    clonedcomponent.attr('href', clonedcomponent.attr('href') + "?uid=" + records[i].id);
    console.log(clonedcomponent)
    resultbox.append(clonedcomponent);
  }
}


// Hide search result panel if user click somewhere not belong to search 
$('body').on('click', function() {
  $('.search-result-container').addClass('none');
});

$('.search-result-container').on('click', function(event) {
  event.stopPropagation();
});
