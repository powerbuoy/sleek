// Create template dialog
const templateDialog = document.createElement('div');

templateDialog.classList.add('dialog');
document.body.appendChild(templateDialog);

// Init dialogs
document.querySelectorAll('.dialog').forEach(dialog => {
	// Insert methods
	dialog.sleekDialog = {
		open: () => {
			document.documentElement.classList.add('dialog-open');
			document.documentElement.classList.add('dialog-open--' + dialog.id);
			dialog.classList.add('open');
		},
		close: () => {
			document.documentElement.classList.remove('dialog-open');
			document.documentElement.classList.remove('dialog-open--' + dialog.id);
			dialog.classList.remove('open');
		},
		isOpen: () => {
			return dialog.classList.contains('open');
		},
		isClosed: () => {
			return !dialog.classList.contains('open');
		},
		getStatus: () => {
			return dialog.classList.contains('open') ? 'open' : 'close';
		}
	};

	// Insert backdrop
	var backdrop = document.createElement('div');

	backdrop.classList.add('backdrop');
	dialog.parentNode.insertBefore(backdrop, dialog.nextSibling);

	backdrop.addEventListener('click', e => {
		if (e.target === backdrop) {
			dialog.sleekDialog.close();
		}
	});

	// Insert close button
	var close = document.createElement('a');

	close.classList.add('dialog__close');
	close.innerHTML = '&times;';
	dialog.appendChild(close);

	dialog.addEventListener('click', e => {
		if (e.target.classList.contains('dialog__close')) {
			e.preventDefault();
			dialog.sleekDialog.close();
		}
	});
});

// Init triggers
document.querySelectorAll('a[href$="-dialog"]').forEach(el => {
	el.addEventListener('click', e => {
		e.preventDefault();

		var target = document.getElementById(el.getAttribute('href').substr(1));

		if (target) {
			// The target is a template
			if (target.nodeName.toLowerCase() === 'script') {
				templateDialog.className = 'dialog dialog--no-transition ' + target.className;
				templateDialog.innerHTML = target.innerHTML + '<a class="dialog__close">&times;</a>';

				// HACK: Wait for dialog--no-transition to kick in (for some reason I need around 50ms...)
				setTimeout(() => {
					templateDialog.classList.remove('dialog--no-transition');
					templateDialog.sleekDialog.open();
				}, 50);
			}
			// The target is a dialog element
			else {
				target.sleekDialog.open();
			}
		}
	});
});
