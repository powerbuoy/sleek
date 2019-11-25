const threshold = 0.75;
const els = [
	'section', 'article', 'header', 'footer', 'aside', 'article', 'div'
];

function addViewClass (entry) {
	if (entry.isIntersecting) {
		entry.target.classList.add('in-view', 'was-in-view');
	}
	else {
		entry.target.classList.remove('in-view');
	}
}

document.querySelectorAll(els.join(',')).forEach(el => {
	const elHeight = el.getBoundingClientRect().height;
	var th = threshold;

	// The element is too tall to ever hit the threshold - change threshold
	if (elHeight > (window.innerHeight * threshold)) {
		th = ((window.innerHeight * threshold) / elHeight) * threshold;
	}

	new IntersectionObserver(iEls => iEls.forEach(iEl => addViewClass(iEl)), {threshold: th}).observe(el);
});
