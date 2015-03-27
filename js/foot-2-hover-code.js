var HoverCode = {
	init: function () {
		var codes = document.querySelectorAll('pre code');

		for (var i = 0; i < codes.length; i++) {
			codes[i].parentNode.style.width = (codes[i].offsetWidth + 25) + 'px';
			codes[i].parentNode.classList.add('hover-code');
			codes[i].parentNode.classList.add('prettyprint');
		}
	}
};
