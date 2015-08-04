/**
 * ImageZoom 1.0
 *
 * Run on an element and all links pointing to images
 * inside that element will "zoom out" of the link.
 *
 * @param	HTMLElement		wrap: the wrapping element, if you want all img links affected just run it on document.body
 * @param	String			duration: transition duration, default .1s
 */
var ImageZoom = {
	init: function (wrap, duration) {
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
				img				= img.length ? img[0] : link; // Use the link as the source "img" if there is no img
			var targetIMG		= document.createElement('img');
				targetIMG.src	= link.getAttribute('href');
			var targetIMGSize	= {};
			var imgSize			= {};

			document.body.appendChild(targetIMG);

			// Initial styling
			targetIMG.style.position	= 'absolute';
			targetIMG.style.zIndex		= '99';
			targetIMG.style.maxHeight	= '90%';
			targetIMG.style.maxWidth	= '90%';
			targetIMG.style.transition	= 'all ' + duration + ' ease-out';

			// Position target on top
			var positionOnTop = function () {
				targetIMG.style.display		= 'block';
				targetIMG.style.left		= imgSize.left + 'px';
				targetIMG.style.top			= document.body.scrollTop + imgSize.top + 'px';
				targetIMG.style.width		= imgSize.width + 'px';
				targetIMG.style.height		= imgSize.height + 'px';
				targetIMG.style.boxShadow	= '0 0 0 rgba(0, 0, 0, .4)';
			};

			// Position target center
			var positionCenter = function () {
				var winSize = getWinSize();
				var newTargetIMGSize = {width: targetIMGSize.width, height: targetIMGSize.height};

				targetIMG.style.display		= 'block';
				targetIMG.style.left		= (winSize.width - newTargetIMGSize.width) / 2 + 'px';
				targetIMG.style.top			= document.body.scrollTop + (winSize.height - newTargetIMGSize.height) / 2 + 'px';
				targetIMG.style.width		= newTargetIMGSize.width + 'px';
				targetIMG.style.height		= newTargetIMGSize.height + 'px';
				targetIMG.style.boxShadow	= '0 0 60px rgba(0, 0, 0, .4)';
			};

			// When target has loaded
			var goOn = function () {
				imgSize = img.getBoundingClientRect();
				targetIMGSize = targetIMG.getBoundingClientRect();

				positionOnTop();

				img.style.visibility = 'hidden';

				setTimeout(function () {
					positionCenter();
				}, 50);
			};

			// Check if already cached (TODO: needed?)
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
				}, 50);
			});
		});
	}
};

if (typeof(jQuery) != 'undefined') {
	jQuery.fn.imageZoom = function (delay) {
		return this.each(function () {
			ImageZoom.init(this, delay);
		});
	};
}
