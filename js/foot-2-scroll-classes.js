/**
 * Adds classes to the body element reflecting the user's current scroll behaviour
 * e.g. "has-scrolled", "scrolling-up" or "scrolling-down".
 * These are used for styling purposes in some themes.
 */
var ScrollClasses = {
	init: function () {
		var lastST = 0;
		var lastSTns = 0; // Last scroll top (no sensitivity)
		var sensitivity = 100;

		window.addEventListener('scroll', function (e) {
			var st = document.body.scrollTop || document.body.parentNode.scrollTop || document.body.scrollTop;

			// Check if at top
			if (st) {
				document.body.classList.add('has-scrolled');
			}
			else {
				document.body.classList.remove('has-scrolled');
			}

			// Check direction
			if (Math.abs(lastST - st) > sensitivity) {
				if (st > lastST) {
					document.body.classList.remove('scrolling-up-far');
					document.body.classList.add('scrolling-down-far');
				}
				else {
					document.body.classList.remove('scrolling-down-far');
					document.body.classList.add('scrolling-up-far');
				}

				lastST = st;
			}

			if (Math.abs(lastSTns - st) > 0) {
				if (st > lastSTns) {
					document.body.classList.remove('scrolling-up');
					document.body.classList.remove('scrolling-up-far');
					document.body.classList.add('scrolling-down');
				}
				else {
					document.body.classList.remove('scrolling-down');
					document.body.classList.remove('scrolling-down-far');
					document.body.classList.add('scrolling-up');
				}

				lastSTns = st;
			}
		});
	}
};
