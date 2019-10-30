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
}, {threshold: .75});

document.querySelectorAll('section, article, header, aside, article').forEach(el => {
	observer.observe(el);
});
