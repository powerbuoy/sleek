ApppluginsCaptchasrender = function () {
	var captchas = document.querySelectorAll('div.captcha');

	for (var i = 0; i < captchas.length; i++) {
		var widgetID = grecaptcha.render(captchas[i], {
			sitekey: '6Ld0FQQTAAAAADAb-WQKUveGUHFP6IAYjuIWthBv'
		});

		captchas[i].setAttribute('data-captcha-widget-id', widgetID);
	}
};
