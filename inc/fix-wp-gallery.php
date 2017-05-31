<?php
# Remove gallery inline styles (WP shines again!) (https://css-tricks.com/snippets/wordpress/remove-gallery-inline-styling/)
add_filter('use_default_gallery_style', '__return_false');

# https://wordpress.stackexchange.com/questions/10524/add-filter-to-post-gallery-and-remove-all-brs
add_filter('the_content', function ($output) {
	return preg_replace('/<br style=(.*)>/mi', '', $output);
}, 11, 2);
