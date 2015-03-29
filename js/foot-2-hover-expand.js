var HoverExpand = {
	init: function () {
		var codes = document.querySelectorAll('pre code');

		for (var i = 0; i < codes.length; i++) {
			var code = codes[i];

			code.parentNode.style.width = (code.offsetWidth + 50) + 'px'; // + 50 = give it some room for potential padding etc, doesn't really matter

			// Make sure it doesn't grow wider than the screen
			var rect = code.getBoundingClientRect();
			var winSize = this.getWinSize();

			code.parentNode.style.maxWidth = (winSize.width - rect.left - 70) + 'px';

			// For styling (and prettyprint!)
			codes[i].parentNode.classList.add('hover-expand');
			codes[i].parentNode.classList.add('prettyprint');
		}
	}, 

	// http://stackoverflow.com/questions/3437786/get-the-size-of-the-screen-current-web-page-and-browser-window
	getWinSize: function () {
		var w = window,
			d = document,
			e = d.documentElement,
			g = d.getElementsByTagName('body')[0],
			x = w.innerWidth || e.clientWidth || g.clientWidth,
			y = w.innerHeight|| e.clientHeight|| g.clientHeight;

		return {
			width: x, 
			height: y
		};
	}
};
