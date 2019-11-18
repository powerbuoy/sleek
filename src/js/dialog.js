// import dialogPolyfill from 'dialog-polyfill';

// For every dialog
document.querySelectorAll('dialog').forEach(el => {
	// Polyfill it
//	dialogPolyfill.registerDialog(el);

	// And add a close button
	var close = document.createElement('a');

	close.classList.add('close');
	close.innerHTML = '&times;';
	close.addEventListener('click', e => {
		e.preventDefault();
		el.close();
	});
	el.appendChild(close);
});

// For every [data-popup] link
document.querySelectorAll('[data-dialog]').forEach(el => {
	var target = document.getElementById(el.dataset.popup.substr(1) || el.getAttribute('href'));

	// Open the target popup on click
	if (target) {
		el.addEventListener('click', e => {
			e.preventDefault();
			target.showModal();
		});
	}
});
