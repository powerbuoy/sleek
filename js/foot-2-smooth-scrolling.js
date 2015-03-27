/**
 * Hooks click event's too all in page links to smoothly scroll down
 * The scrolling code is from: http://www.cssscript.com/smooth-scroll-to-animation-with-anchor-scrolling-js-library/
 */
var SmoothScrolling = {
	init: function (offset) {
		var offset = offset || 0;

		var root = /firefox|trident/i.test(navigator.userAgent) ? document.documentElement : document.body;
		var easeInOutCubic = function(t, b, c, d) {
			if ((t/=d/2) < 1) {
				return c/2*t*t*t + b;
			}

			return c/2*((t-=2)*t*t + 2) + b;
		};

		document.body.addEventListener('click', function (e) {
			var clicked = e.target;
			var href = clicked.tagName.toUpperCase() == 'A' ? clicked.getAttribute('href') : false;

			if (!href) {
				return;
			}

			var targetID = href.match(/#(.*?)$/);

			if (!(targetID && targetID[1] && targetID[1].length)) {
				return;
			}

			targetID = targetID[1];

			var startTime;
			var startPos = root.scrollTop;
			var endPos = document.getElementById(targetID).getBoundingClientRect().top;
				endPos -= offset;
			var maxScroll = root.scrollHeight - window.innerHeight;
			var scrollEndValue = startPos + endPos < maxScroll ? endPos : maxScroll - startPos;
			var duration = 900;

			var scroll = function (timestamp) {
				startTime = startTime || timestamp;

				var elapsed = timestamp - startTime;
				var progress = easeInOutCubic(elapsed, startPos, scrollEndValue, duration);

				root.scrollTop = progress;
				elapsed < duration && requestAnimationFrame(scroll);
			};   

			requestAnimationFrame(scroll);
			e.preventDefault();
		});
	}
};
