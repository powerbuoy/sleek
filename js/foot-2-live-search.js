var LiveSearch = function (input, url, appendTo) {
	var appendTo = appendTo || document.body;

	input.autocomplete = false;

	// Create search container
	var container = document.createElement('div');

	container.id = 'live-search-' + input.name;

	container.classList.add('live-search');

	// Append search container
	if (appendTo == 'after') {
		input.parentNode.insertBefore(container, input.nextSibling);
	}
	else {
		appendTo.appendChild(container);
	}

	// Hook up keyup on input
	input.addEventListener('keyup', function (e) {
		if (this.value != this.liveSearchLastValue) {
			this.classList.add('loading');

			var q = this.value;

			// Clear previous ajax request
			if (this.liveSearchTimer) {
				clearTimeout(this.liveSearchTimer);
			}

			this.liveSearchTimer = setTimeout(function () {
				SimpleAjax({
					method: 'get', 
					url: url + q, 
					callback: function (data) {
						console.dir(data);
					}
				});
			}, 200);

			this.liveSearchLastValue = this.value;
		}
	});
};
