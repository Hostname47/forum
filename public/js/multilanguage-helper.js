$('.find-keys').click(function() {
  let content = $('#multilang_textarea').val();
  let result = {};
  let cursor = 0;
  let current;
  while(current=content[cursor]) {
      if(current == '_')
          if(content[cursor+1] == '_' && content[cursor+2] == '(') {
              let closing_quote = (content[cursor+3] == "'") ? "'" : '"';
              let key = '';
              cursor = cursor+4;
              while((k=content[cursor]) != closing_quote) {
                  key += k;
                  cursor++;
              }
              result[key] = '';
              continue;
          }

      cursor++;
  }

  let lang_comparison_list = $('#lang-comparison-list').val();

  // Check if the user check a file to compare keys with and remove already existed translated keys
  if(lang_comparison_list != 'none') {
      let lang = lang_comparison_list;

      $.ajax({
          type: 'get',
          url: '/languages/' + lang + '/keys' ,
          success: function(language_file_keys) {
              language_file_keys = JSON.parse(language_file_keys);
              // Now we have two language keys in for of objects
              // All we want to do is to subtract the keys exist in language file from the results generated keys
              // because we don't need to add already translated strings in our result
              // That's mean whatever is generated after the following loop have to be added to the language file
              Object.keys(result).forEach((item) => {
                  if(item in language_file_keys) {
                      delete result[item];
                  }
              });

              $('#multilang_result_textarea').val(JSON.stringify(result, null, 4));
          }
      })
  } else {
      let generated_json = JSON.stringify(result, null, " ");
      $('#multilang_result_textarea').val(generated_json + '\n');
  }
});

$('.select-all').on('click', function() {
    $('#multilang_textarea').trigger('select');
});