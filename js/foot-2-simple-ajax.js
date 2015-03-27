var SimpleAjax = {
	xhr: function (conf, updateID) {
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
			xhr.open('GET', config.url + (config.data ? '?' + config.data : ''), true);
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.onreadystatechange = onReadyStateChange;
			xhr.send(null);
		}
	}
};
