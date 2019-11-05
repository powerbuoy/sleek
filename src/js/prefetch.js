'use strict';

var cache = {
	prefetch: {},
	prerender: {}
};

function preload (href, type = 'prefetch') {
	if (href.substr(0, 1) !== '#' && !cache[type][href]) {
		cache[type][href] = true;

		const link = document.createElement('link');

		link.setAttribute('rel', type);
		link.setAttribute('href', href);

		document.head.appendChild(link);
	}
}

document.querySelectorAll('a').forEach(el => {
	var timeout = null;

	el.addEventListener('mouseover', e => {
		timeout = setTimeout(() => {
			preload(el.getAttribute('href'), 'prefetch');
		}, 100);
	});

	el.addEventListener('mouseout', e => {
		clearTimeout(timeout);
	});

	el.addEventListener('mousedown', e => {
		preload(el.getAttribute('href'), 'prerender');
	});
});
