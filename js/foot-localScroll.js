H5B.plugins.LocalScroll = {
	init: function () {
		if (!$('html').is('.lt-ie9')) {
			$('a[href^="#"]').click(function () {
				$('body').animate({scrollTop: $($(this).attr('href')).offset().top}, 1000);

				return false;
			});
		}
	}
};
