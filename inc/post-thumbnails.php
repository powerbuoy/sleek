<?php
function h5b_post_thumbnails () {
	add_theme_support('post-thumbnails');

	set_post_thumbnail_size(150, 150, true);

#	add_image_size('h5b-25', 220, 130, true);
#	add_image_size('h5b-33', 300, 190, true);
#	add_image_size('h5b-50', 460, 280, true);
#	add_image_size('h5b-66', 620, 280, true);
#	add_image_size('h5b-75', 700, 320, true);
	add_image_size('h5b-100', 940, 410, true);
#	add_image_size('h5b-100-hd', 1920, 1080, true);
#	add_image_size('h5b-100-uhd', 3840, 2160, true);
}

add_action('init', 'h5b_post_thumbnails');
