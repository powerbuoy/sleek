App.plugins.AjaxForm = {
	init: function () {
		var forms = document.querySelectorAll('form.ajax');

		for (var i = 0; i < forms.length; i++) {
			this.ajaxForm(forms[i]);
		}
	}, 

	ajaxForm: function (form) {
		var self = this;

		form.addEventListener('submit', function (e) {
			e.preventDefault();

			self.ajax({
				method: this.method, 
				url: this.action, 
				data: self.serialize(this), 
				callback: function (data) {
					console.log(data);
				}
			});
		});
	}, 

	// Or maybe : https://developer.mozilla.org/en-US/docs/DOM/XMLHttpRequest/Using_XMLHttpRequest
	ajax: function (conf, updateID) {
		// Create config
		var config = {
			method:		conf.method || 'get', 
			url:		conf.url, 
			data:		conf.data || '', 
			callback:	conf.callback || function (data) {
				if (updateID) {
					document.getElementById(updateID).innerHTML = data;
				}
			}
		};

		// Create ajax request object
		var xhr = new XMLHttpRequest();

		// This runs when request is complete
		var onReadyStateChange = function () {
			if (xhr.readyState == 4) {
				config.callback(xhr.responseText);
			}
		};

		// Send the request
		if (config.method.toUpperCase() == 'POST') {
			xhr.open('POST', config.url, true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.onreadystatechange = onReadyStateChange;
			xhr.send(config.data);
		}
		else {
			xhr.open('GET', config.url + '?' + config.data, true);
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.onreadystatechange = onReadyStateChange;
			xhr.send(null);
		}
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
