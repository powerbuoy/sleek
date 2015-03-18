<?php
add_action('init', 'sleek_post_thumbnails');

function sleek_post_thumbnails () {
	add_theme_support('post-thumbnails');

	set_post_thumbnail_size(200, 200, true);

#	add_image_size('sleek-25', 220, 130, true);
#	add_image_size('sleek-33', 300, 190, true);
#	add_image_size('sleek-50', 460, 280, true);
#	add_image_size('sleek-66', 620, 280, true);
#	add_image_size('sleek-75', 700, 320, true);
#	add_image_size('sleek-100', 940, 410, true);
#	add_image_size('sleek-100-hd', 1920, 1080, true);
#	add_image_size('sleek-100-uhd', 3840, 2160, true);
}
