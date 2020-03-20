'use strict';

class RadialProgress {
	constructor (el, conf) {
		this.el = el;
		this.config = Object.assign({
			value: 0,
			prefix: '',
			suffix: '',
			locale: 'en-US',
			options: {
				maximumFractionDigits: 0 // TODO: Should depend on whether input is int or float
			}
		}, conf);
		this.currentValue = this.config.value;
	}

	mount () {
		// Clear element contents
		this.el.innerHTML = '';

		// Create element to hold value
		this.valueEl = document.createElement('div');
		this.valueEl.classList.add('value');
		this.el.appendChild(this.valueEl);

		// Create SVG to hold progress bar
		this.progressBar = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
		this.progressBar.classList.add('radial-progress');
		this.progressBar.setAttribute('width', 100);
		this.progressBar.setAttribute('height', 100);
		this.progressBar.setAttribute('viewBox', '0 0 100 100');
		this.progressBar.innerHTML = '<circle cx="50" cy="50" r="50" fill="none" class="meter"></circle><circle cx="50" cy="50" r="50" fill="none" class="value"></circle>';
		this.el.appendChild(this.progressBar);

		// Set value
		this.value = this.currentValue;
	}

	set value (newValue) {
		console.log('Setting value to ' + newValue);

		this.currentValue = newValue;
		this.valueEl.innerHTML = `${this.config.prefix}${newValue}${this.config.suffix}`;
	}

	get value () {
		return this.currentValue;
	}
}

document.querySelectorAll('[data-radial-progress]').forEach(el => {
	const value = parseInt(el.dataset.value || 0);
	const prefix = el.dataset.prefix || '';
	const suffix = el.dataset.suffix || '';
	const radPro = new RadialProgress(el, {
		value: value,
		prefix: prefix,
		suffix: suffix
	});
	radPro.mount();
});
