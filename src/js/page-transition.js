'use strict';

window.addEventListener('pageshow', e => {
	document.documentElement.classList.remove('loading');
	document.documentElement.classList.remove('leaving');
});

window.addEventListener('beforeunload', e => {
	document.documentElement.classList.add('leaving');
});

// Prevent page transition when clicking mailto/tel links
const iframe = document.createElement('iframe');

iframe.style = 'position: absolute; left: 0; top: 0; pointer-events: none; visibility: hidden; width: 0; height: 0;';
iframe.name = 'sleek-page-transition-iframe';

document.body.appendChild(iframe);

document.querySelectorAll('a[href^="mailto:"],a[href^="tel:"]').forEach(el => {
	el.target = 'sleek-page-transition-iframe';
});
