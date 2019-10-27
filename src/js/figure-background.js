'use strict';

document.querySelectorAll('figure').forEach(el => {
//	el.setAttribute('data-img', el.querySelector('img').getAttribute('src'));
	el.style.backgroundImage = 'url(' +  el.querySelector('img').getAttribute('src') + ')';
});
