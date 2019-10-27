'use strict';

var observer = new IntersectionObserver(entries => {
	entries.forEach(entry => {
		if (entry.isIntersecting) {
			entry.target.classList.add('in-view', 'was-in-view');
		}
		else {
			entry.target.classList.remove('in-view');
		}
	});
}, {threshold: .25});

document.querySelectorAll('section, article, header, footer, nav, aside, div, h1, h2, h3, h4, h5, h6, figure').forEach(el => {
	observer.observe(el);
});
