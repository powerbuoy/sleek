<?php
/**
 * Add an "active-parent" class to archive pages when browsing their taxonomies
 * NOTE: Several post types mays hare a taxonomy in which case all post types will be selected
 */
add_filter('nav_menu_css_class', function ($cssClasses, $item) {
	global $wp_query;

	$cssClassName = 'active-parent';

	# Only do this on archive pages
	if (is_archive()) {
		# This is the link to the blog archive
		if (get_option('page_for_posts') and $item->object_id == get_option('page_for_posts')) {
			# If we're on a blog archive - give the blog link the active class
			if (is_category() or is_tag() or is_day() or is_month() or is_year()) {
				$cssClasses[] = $cssClassName;
			}
		}
		# This is a link to a custom post type archive
		elseif ($item->type == 'post_type_archive') {
			# If we're on a taxonomy and this post type has that taxonomy - make it look active
			if (is_tax()) {
				$term = $wp_query->get_queried_object();

				if (is_object_in_taxonomy($item->object, $term->taxonomy)) {
					$cssClasses[] = $cssClassName;
				}
			}
		}
	}

	return $cssClasses;
}, 10, 2);

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
