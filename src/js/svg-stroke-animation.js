'use strict';

document.querySelectorAll('[data-svg]').forEach(el => {
	const svg = el.dataset.svg;

	el.style.visibility = 'hidden';

	fetch('/wp-content/themes/sleek/dist/assets/' + svg + '.svg').then(res => res.text()).then(text => {
		el.style.visibility = 'visible';
		el.innerHTML = text;

		el.querySelector('svg').classList.add('svg-stroke-animation');
		el.querySelectorAll('path').forEach(path => {
			path.style.setProperty('--path-length', path.getTotalLength() + 'px');
		});
	}).catch(error => {
		console.log(error);
	});
});
