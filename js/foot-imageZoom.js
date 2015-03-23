var imageZoom = function (wrap, duration) {
	var wrap		= wrap || document.body;
	var duration	= duration || '.1s';

	// http://stackoverflow.com/questions/3437786/get-the-size-of-the-screen-current-web-page-and-browser-window
	var getWinSize = function () {
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
	};

	var isIMGLink = function (el) {
		return el && el.tagName && el.tagName.toUpperCase() == 'A' && el.href && el.href.match(/\.(png|gif|jpg|jpeg)$/);
	};

	wrap.addEventListener('click', function (e) {
		// Make sure a link pointing to an image was clicked
		var clicked = e.target;

		if (!isIMGLink(clicked)) {
			var child = clicked;

			while (child.parentNode) {
				if (isIMGLink(child.parentNode)) {
					clicked = child.parentNode;
					break;
				}

				child = child.parentNode;
			}
		}

		if (!isIMGLink(clicked)) {
			return;
		}

		// An img link was clicked - go on
		e.preventDefault();

		var link			= clicked;
		var img				= link.getElementsByTagName('img');
			img				= img ? img[0] : false;
		var targetIMG		= document.createElement('img');
			targetIMG.src	= link.getAttribute('href');
		var targetIMGSize	= {};

		document.body.appendChild(targetIMG);

		// Initial styling
		targetIMG.style.position = 'fixed';
		targetIMG.style.transition = 'left ' + duration + ' ease-out, top ' + duration + ' ease-out, width ' + duration + ' ease-out, height ' + duration + ' ease-out, box-shadow ' + duration + ' ease-out';

		// Position target on top
		var positionOnTop = function () {
			var imgSize = img.getBoundingClientRect();

			targetIMG.style.display		= 'block';
			targetIMG.style.left		= imgSize.left + 'px';
			targetIMG.style.top			= imgSize.top + 'px';
			targetIMG.style.width		= imgSize.width + 'px';
			targetIMG.style.height		= imgSize.height + 'px';
			targetIMG.style.boxShadow	= '0 0 0 rgba(0, 0, 0, .4)';
		};

		// Position target center
		var positionCenter = function () {
			var winSize = getWinSize();

			targetIMG.style.display		= 'block';
			targetIMG.style.left		= (winSize.width - targetIMGSize.width) / 2 + 'px';
			targetIMG.style.top			= (winSize.height - targetIMGSize.height) / 2 + 'px';
			targetIMG.style.width		= targetIMGSize.width + 'px';
			targetIMG.style.height		= targetIMGSize.height + 'px';
			targetIMG.style.boxShadow	= '0 0 60px rgba(0, 0, 0, .4)';
		};

		// When target has loaded
		var goOn = function () {
			targetIMGSize = targetIMG.getBoundingClientRect();

			positionOnTop();

			img.style.visibility = 'hidden';

			setTimeout(function () {
				positionCenter();
			}, 100);
		};

		// Check if already cached (load does not trigger in IE)
		if (targetIMG.complete) {
			goOn();
		}
		else {
			targetIMG.addEventListener('load', function () {
				goOn();
			});
		}

		// Close the img
		targetIMG.addEventListener('click', function () {
			positionOnTop();

			setTimeout(function () {
				img.style.visibility = 'visible';
				targetIMG.style.display = 'none';
			}, 100);
		});
	});
};

if (typeof(jQuery) != 'undefined') {
	jQuery.fn.imageZoom = function (delay) {
		return this.each(function () {
			imageZoom(this, delay);
		});
	};
}
