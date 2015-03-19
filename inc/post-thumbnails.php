<?php
# Eable post thumbnails
add_action('init', 'sleek_post_thumbnails');

function sleek_post_thumbnails () {
	add_theme_support('post-thumbnails');

	set_post_thumbnail_size(320, 320, true);
}
