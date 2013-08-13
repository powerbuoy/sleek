H5B.modules.Featured = {
	init: function () {
		$(window).load(function () {
			H5B.modules.Featured.cycleFeatureds();
		//	H5B.modules.Featured.thumbsInNav();
		//	H5B.modules.Featured.centerNav();
		});
	}, 

	cycleFeatureds: function () {
		$('#featured ul').after('<div id="featured-navigation">').cycle({
			fx:			'scrollLeft', 
			speed:		400, 
			timeout:	8000, 
			easing:		'easeInOutQuad', 
			pager:		'#featured-navigation'
		});
	}, 

	thumbsInNav: function () {
		var featureds = $('#featured li');

		$('#featured-navigation a').each(function (i) {
			var link = $(this);

			link.html('<img src="' + featureds.eq(i).find('img').attr('src') + '" alt="' + link.text() + '"/>');
		});
	}, 

	centerNav: function () {
		var nav = $('#featured-navigation');
		var hw = Math.round(nav.outerWidth() / 2);

		nav.css('margin-left', '-' + hw + 'px');
	}
};
