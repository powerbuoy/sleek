document.querySelectorAll('a[href^="http"]').forEach(el => {
	el.addEventListener('click', e => {
		e.preventDefault();
		window.open(el.href);
	});
});
