// Init dialogs
document.querySelectorAll('.dialog').forEach(el => {
	// Insert methods
	el.sleekDialog = {
		open: () => {
			document.documentElement.classList.add('dialog-open');
			document.documentElement.classList.add('dialog-open--' + el.id);
			el.classList.add('open');
		},
		close: () => {
			document.documentElement.classList.remove('dialog-open');
			document.documentElement.classList.remove('dialog-open--' + el.id);
			el.classList.remove('open');
		},
		isOpen: () => {
			return el.classList.contains('open');
		},
		isClosed: () => {
			return !el.classList.contains('open');
		},
		getStatus: () => {
			return el.classList.contains('open') ? 'open' : 'close';
		}
	};

	// Insert backdrop
	var backdrop = document.createElement('div');

	backdrop.classList.add('backdrop');
	el.parentNode.insertBefore(backdrop, el.nextSibling);

	backdrop.addEventListener('click', e => {
		if (e.target === backdrop) {
			el.sleekDialog.close();
		}
	});

	// Insert close button
	var close = document.createElement('a');

	close.classList.add('close');
	close.innerHTML = '&times;';
	close.addEventListener('click', e => {
		e.preventDefault();
		el.sleekDialog.close();
	});
	el.appendChild(close);
});

// Init triggers
document.querySelectorAll('a[href$="-dialog"]').forEach(el => {
	el.addEventListener('click', e => {
		e.preventDefault();

		var target = document.getElementById(el.getAttribute('href').substr(1));

		if (target) {
			target.sleekDialog.open();
		}
	});
});
