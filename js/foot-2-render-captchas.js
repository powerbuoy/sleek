var RenderCaptchas = function () {
	var captchas = document.querySelectorAll('div.captcha');

	for (var i = 0; i < captchas.length; i++) {
		var widgetID = grecaptcha.render(captchas[i], {
			sitekey: RECAPTCHA_SITE_KEY
		});

		captchas[i].setAttribute('data-captcha-widget-id', widgetID);
	}
};
