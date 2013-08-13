H5B.plugins.Cut = {
	init: function () {
		$(window).load(function () {
			$('div.cut').each(function () {
				var cut				= $(this);
				var parent			= cut.parent();
				var parentDisplay	= parent.css('display');

				parent.css('display', 'block'); // While calculating the offsets etc

				var parentOffset	= parent.offset();
				var cutOffset		= cut.offset();
				var cutPosTop		= cutOffset.top - parentOffset.top + cut.outerHeight() + 15; // I honestly don't know why this + 15 is needed, but cut's offset.top is off by exactly 15 (it's worth mentioning that p:s have a margin-bottom of 15 and h*:s have a margin-top of the same

				// Set parent's height to cut's position
				parent.css({
					height:		cutPosTop + 'px', 
					overflow:	'hidden', 
					display:	parentDisplay
				});

				// Maximize / minimize links
			//	var cutBack	= $('<div class="cut-back"><a href="#" class="less">Read less</a></div>').appendTo(parent);
			//	var less	= cutBack.find('a.less');
				var more	= cut.find('a.more');

				more.click(function () {
					parent.css('height', 'auto');

					more.hide();

					return false;
				});

			/*	less.click(function () {
					parent.css('height', cutPosTop + 'px');

					more.show();

					return false;
				}); */
			});
		});
	}
};
