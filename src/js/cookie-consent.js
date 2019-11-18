const accept = window.localStorage.getItem('sleek_cookie_consent');

if (typeof SLEEK_COOKIE_CONSENT !== 'undefined' && !accept) {
	const el = document.createElement('aside');

	el.id = 'cookie-consent';
	el.innerHTML = SLEEK_COOKIE_CONSENT;

	document.body.appendChild(el);

	const close = el.querySelector('a.close');

	if (close) {
		close.addEventListener('click', e => {
			e.preventDefault();
			window.localStorage.setItem('sleek_cookie_consent', true);
			el.parentNode.removeChild(el);
		});
	}
}
