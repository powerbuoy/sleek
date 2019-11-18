var threshold = .25;

if (window.matchMedia('(min-width: 1000px)').matches) {
	threshold = .5;
}

var observer = new IntersectionObserver(entries => {
	entries.forEach(entry => {
		if (entry.isIntersecting) {
			entry.target.classList.add('in-view', 'was-in-view');
		}
		else {
			entry.target.classList.remove('in-view');
		}
	});
}, {threshold: threshold});

document.querySelectorAll('section, article, header, footer, aside, article, div').forEach(el => {
	observer.observe(el);
});
