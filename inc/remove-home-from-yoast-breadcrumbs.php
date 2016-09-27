<?php
/**
 * Remove HOME from Yoast Breadcrumbs
 *
 * http://wordpress.org/support/topic/how-can-i-remove-home-from-breadcrumbs
 */
# add_filter('wpseo_breadcrumb_links', 'sleek_remove_home_from_breadcrumb');

function sleek_remove_home_from_breadcrumb ($links) {
	if ($links[0]['url'] == get_home_url()) {
		array_shift($links);
	}

	return $links;
}
