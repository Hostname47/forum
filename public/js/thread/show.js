
$('.share-post-box textarea').each(function() {
    var simplemde = new SimpleMDE({
        element: this,
        hideIcons: ["guide", "heading", "image"],
        spellChecker: false,
        mode: 'markdown',
        showMarkdownLineBreaks: true,
    });
});
// This will force lazy loading handling du to synchronous scrolling
force_lazy_load($('.thread-medias-container'));

let urlprms = new URLSearchParams(window.location.search);
if(urlprms.has('action')) {
    if(urlprms.get('action') == 'move-to-replies-section')
        scroll_to_element('thread-show-posts-container', -100);
}
