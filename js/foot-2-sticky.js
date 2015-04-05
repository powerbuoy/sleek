var Sticky = {
	init: function (element, offset, stopBefore) {
		var origPos = element.getBoundingClientRect();
		var compStyle = window.getComputedStyle(element);
		var offset = offset || 0;
		var stopBefore = stopBefore || false;
		var stopBeforePos = stopBefore ? stopBefore.getBoundingClientRect() : false;

		var origCSS = {
			position:	compStyle.position || 'static', 
			left:		compStyle.left || 'auto', 
			top:		compStyle.top || 'top', 
			width:		compStyle.width || 'auto', 
			boxSizing:	compStyle.boxSizing || 'content-box'
		};
		var fixedCSS = {
			position:	'fixed', 
			left:		origPos.left + 'px', 
			top:		offset + 'px', 
			width:		origPos.width + 'px', 
			boxSizing:	'border-box'
		};
		var absoluteCSS = {
			position:	'absolute', 
			left:		origPos.left + 'px', 
			top:		false, 
			width:		origPos.width + 'px', 
			boxSizing:	'border-box'
		};

		// Applies an object of CSS rules
		var applyCSS = function (el, css) {
			for (var property in css) {
				el.style[property] = css[property];
			}
		};

		// Do everything as soon as user scrolls
		window.addEventListener('scroll', function (e) {
			var st = document.body.scrollTop;

			// Stop before certain element
			if (stopBeforePos && (st + offset + origPos.height + offset) > stopBeforePos.top) {
				absoluteCSS.top = (stopBeforePos.top - origPos.height - offset) + 'px';

				applyCSS(element, absoluteCSS);
			}
			// We've reached the element - make it sticky
			else if ((st + offset) > origPos.top) {
				applyCSS(element, fixedCSS);
			}
			// We're above the element
			else {
				applyCSS(element, origCSS);
			}
		});
	}
};
