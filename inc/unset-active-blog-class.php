<?php
/**
 * Remove .current_page_parent from Blog-page when viewing another archive
 *
 * http://stackoverflow.com/questions/3269878/wordpress-custom-post-type-hierarchy-and-menu-highlighting-current-page-parent/3270171#3270171
 */
add_filter('nav_menu_css_class', function ($cssClass, $item) {
	if (get_post_type() != 'post') {
		if ($item->object_id == get_option('page_for_posts')) {
			foreach ($cssClass as $k => $v) {
				if ($v == 'active-parent' || $v == 'current_page_parent') {
					unset($cssClass[$k]);
				}
			}
		}
	}

	return $cssClass;
}, 10, 2);
