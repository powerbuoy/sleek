// Modfied to work with items with 70px padding-bottom
jQuery.fn.equalHeight = function () {
	var height		= 0;
	var maxHeight	= 0;

	// Store the tallest element's height
	this.each(function () {
		height		= jQuery(this).outerHeight();
		maxHeight	= (height > maxHeight) ? height : maxHeight;
	});

	// Set element's min-height to tallest element's height
	return this.each(function () {
		jQuery(this).css('min-height', maxHeight + 'px');
	});
};
