'use strict';

setTimeout(() => {
	document.documentElement.classList.remove('loading');
});

window.addEventListener('beforeunload', e => {
	document.documentElement.classList.add('leaving');
});
