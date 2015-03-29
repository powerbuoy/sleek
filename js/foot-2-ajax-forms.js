var AjaxForms = {
	init: function (selector) {
		var selector = selector || 'form.ajax';
		var forms = document.querySelectorAll(selector);

		for (var i = 0; i < forms.length; i++) {
			this.ajaxForm(forms[i]);
		}
	}, 

	ajaxForm: function (form) {
		var self = this;

		form.addEventListener('submit', function (e) {
			var form = this;

			e.preventDefault();

			if (form.classList.contains('loading')) {
				return;
			}

			// Remove error/success classes - set loading
			form.classList.remove('error');
			form.classList.remove('success');
			form.classList.add('loading');

			// Remove potential old message
			var oldMessage = form.parentNode.querySelector('p.message');

			if (oldMessage) {
				oldMessage.parentNode.removeChild(oldMessage);
			}

			// Remove potential old error messsages
			var errorMessages = form.querySelectorAll('strong.error');

			for (var i = 0; i < errorMessages.length; i++) {
				errorMessages[i].parentNode.removeChild(errorMessages[i]);
			}

			// Check potential captcha
			var captcha = document.querySelector('div.captcha');

			if (captcha && typeof(grecaptcha) != 'undefined') {
				if (!grecaptcha.getResponse(captcha.getAttribute('data-captcha-widget-id'))) {
					var errorMsg = document.createElement('strong');

					errorMsg.classList.add('error');
					errorMsg.innerHTML = 'Please verify that you are human';

					captcha.parentNode.appendChild(errorMsg);

					form.classList.remove('loading');
					form.classList.add('error');

					return;
				}
			}

			// AJAX the form away
			SimpleAjax.xhr({
				method:		form.method, 
				url:		form.action, 
				data:		self.serialize(form), 
				callback:	function (data) {
					var data = JSON.parse(data);

					form.classList.remove('loading');

					// Success! Do cool stuff
					if (data.success) {
						form.classList.add('success');
						form.reset();
					}
					// The backend did not return success
					else {
						form.classList.add('error');
					}

					// Reset potential captcha
					if (captcha && typeof(grecaptcha) != 'undefined') {
						grecaptcha.reset(captcha.getAttribute('data-captcha-widget-id'));
					}

					// The backend returned a message - display it
					if (data.msg && data.msg.length) {
						var newMessage = document.createElement('p');

						newMessage.classList.add('message');
						newMessage.classList.add((data.success ? 'success' : 'error'));

						newMessage.innerHTML = '<strong>' + data.msg + '</strong>';

						form.parentNode.insertBefore(newMessage, form);
					}

					// The backend returned errors - display them
					if (data.errors) {
						for (var fieldName in data.errors) {
							var strong = document.createElement('strong');
							var field = fieldName == 'captcha' ? form.querySelector('div.captcha') : form.querySelector('[name="' + fieldName + '"]');

							strong.classList.add('error');
							strong.innerHTML = data.errors[fieldName];

							if (field) {
								field.parentNode.insertBefore(strong, field.nextSibling);
							}
						}
					}
				}
			});
		});
	}, 

	// https://code.google.com/p/form-serialize/
	serialize: function (form) {
		if (!form || form.nodeName !== "FORM") {
			return;
		}

		var i, j, q = [];

		for (i = form.elements.length - 1; i >= 0; i = i - 1) {
			if (form.elements[i].name === "") {
				continue;
			}

			switch (form.elements[i].nodeName) {
				case 'INPUT':
					switch (form.elements[i].type) {
						case 'text':
						case 'hidden':
						case 'password': 
						case 'search': 
						case 'email': 
						case 'url': 
						case 'tel': 
						case 'number': 
						case 'date': 
						case 'month': 
						case 'week': 
						case 'time': 
						case 'datetime': 
						case 'datetime-local': 
						case 'color': 
						case 'button':
						case 'reset':
						case 'submit':
							q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
						break;

						case 'checkbox':
						case 'radio':
							if (form.elements[i].checked) {
								q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
							}
						break;

						case 'file':
						break;
					}
				break;			 

				case 'TEXTAREA':
					q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
				break;

				case 'SELECT':
					switch (form.elements[i].type) {
						case 'select-one':
							q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
						break;

						case 'select-multiple':
							for (j = form.elements[i].options.length - 1; j >= 0; j = j - 1) {
								if (form.elements[i].options[j].selected) {
									q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].options[j].value));
								}
							}
						break;
					}
				break;

				case 'BUTTON':
					switch (form.elements[i].type) {
						case 'reset':
						case 'submit':
						case 'button':
							q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
						break;
					}
				break;
			}
		}

		return q.join("&");
	}
};
