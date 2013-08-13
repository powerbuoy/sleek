H5B.plugins.Images = {
	init: function () {
		var that = this;

		$(window).load(function () {
			that.cycleImages();
		});
	}, 

	cycleImages: function () {
		var images		= $('div.images ul');

		if (images.find('> li').length > 1) {
			var pager		= $('<div class="navigation"></div>').insertAfter(images);
			var prevNext	= $('<div class="prev-next"><a href="#" class="prev">&lt;</a><a href="#" class="next">&gt;</a></div>').insertAfter(images);

			images.cycle({
				fx:			'scrollLeft', 
				speed:		400, 
				timeout:	8000, 
				easing:		'easeInOutQuad', 
				pager:		pager, 
				prev:		prevNext.find('a.prev'), 
				next:		prevNext.find('a.next')
			});
		}
	}
};
