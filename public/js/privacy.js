let urlprms = new URLSearchParams(window.location.search);

if(urlprms.has('move-to')) {
	scroll_to_element(urlprms.get('move-to'), -60);
}
