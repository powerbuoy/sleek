/**
 * LiveSearch 1.0
 *
 * TODO
 */
var LiveSearch = {
	init: function (input, url, appendTo) {
		var appendTo = appendTo || 'after';

		input.setAttribute('autocomplete', 'off');

		// Create search container
		var container = document.createElement('div');

		container.id = 'live-search-' + input.name;

		container.classList.add('live-search');

		// Append search container
		if (appendTo == 'after') {
			input.parentNode.classList.add('live-search-wrap');
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
					if (q) {
						SimpleAjax.xhr({
							method: 'get', 
							url: url + q, 
							callback: function (data) {
								container.innerHTML = data;
							}
						});
					}
					else {
						container.innerHTML = '';
					}
				}, 300);

				this.liveSearchLastValue = this.value;
			}
		});
	}
};

if (typeof(jQuery) != 'undefined') {
	jQuery.fn.liveSearch = function (url, appendTo) {
		return this.each(function () {
			LiveSearch.init(this, url, appendTo);
		});
	};
}
