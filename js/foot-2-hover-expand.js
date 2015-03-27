var HoverExpand = {
	init: function () {
		var codes = document.querySelectorAll('pre code');

		for (var i = 0; i < codes.length; i++) {
			codes[i].parentNode.style.width = (codes[i].offsetWidth + 25) + 'px';
			codes[i].parentNode.classList.add('hover-expand');
			codes[i].parentNode.classList.add('prettyprint');
		}
	}
};
