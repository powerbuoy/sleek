H5B.plugins.Images = {
	init: function () {
		var that = this;

		$(window).load(function () {
			that.cycleImages();
		});
	}, 

	cycleImages: function () {
		var images	= $('div.images ul');
		var pager	= $('<div class="navigation"></div>').insertAfter(images);

		images.cycle({
			fx:			'scrollLeft', 
			speed:		400, 
			timeout:	8000, 
			easing:		'easeInOutQuad', 
			pager:		pager
		});
	}
};
