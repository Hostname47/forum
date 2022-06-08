$('.share-post-form textarea').each(function() {
  var simplemde = new SimpleMDE({
      element: this,
      hideIcons: ["guide", "heading", "link", "image"],
      spellChecker: false,
      showMarkdownLineBreaks: true,
  });
  simplemde.render();
});