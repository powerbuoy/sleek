'use strict';

function loadScript (src) {
	return new Promise((resolve, reject) => {
		const existingScript = document.querySelector('script[src="' + src + '"]');

		if (!existingScript) {
			const script = document.createElement('script');

			script.src = src;

			document.body.appendChild(script);
			script.addEventListener('load', () => resolve(script));
		}
		else {
			resolve(existingScript);
		}
	});
}

const observer = new IntersectionObserver(entries => {
	entries.forEach(entry => {
		if (entry.isIntersecting) {
			observer.unobserve(entry.target);

			loadScript('//js.hsforms.net/forms/v2.js').then(() => {
				const config = {
					portalId: entry.target.dataset.hsFormPortalId,
					formId: entry.target.dataset.hsFormFormId,
					target: '#' + entry.target.id
				};

				if (entry.target.dataset.hsFormRedirectUrl && entry.target.dataset.hsFormRedirectUrl.length) {
					config.redirectUrl = entry.target.dataset.hsFormRedirectUrl;
				}

				hbspt.forms.create(config);
			});
		}
	});
}, {rootMargin: '0% 0% 25% 0%'});

let i = 0;

document.querySelectorAll('[data-hs-form]').forEach(el => {
	if (!el.id) {
		el.id = 'sleek-hs-form-' + i++;
	}

	observer.observe(el);
});
