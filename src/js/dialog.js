import dialogPolyfill from 'dialog-polyfill';

// For every dialog
document.querySelectorAll('dialog').forEach(el => {
	// Polyfill it
	dialogPolyfill.registerDialog(el);

	// And add a close button
	const close = document.createElement('a');

	close.classList.add('close');
	close.innerHTML = '&times;';
	close.addEventListener('click', e => {
		e.preventDefault();
		el.close();
	});
	el.appendChild(close);
});

// For every [data-dialog] link
document.querySelectorAll('[data-dialog], a[href$="-popup"]').forEach(el => {
	const targetId = el.dataset.popup || el.getAttribute('href');

	if (targetId) {
		const target = document.getElementById(targetId.substr(1));

		// Open the target popup on click
		if (target) {
			el.addEventListener('click', e => {
				e.preventDefault();
				target.showModal();
			});
		}
	}
});
