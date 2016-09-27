<?php
/**
 * Add an "active-parent" class to archive pages when browsing their taxonomies
 */
# add_filter('nav_menu_css_class', 'sleek_active_archive_link_on_taxonomies', 10, 2);

function sleek_active_archive_link_on_taxonomies ($cssClasses, $item) {
	global $wp_query;

	$cssClassName = 'active-parent';

	# Only do this on archive pages
	if (is_archive()) {
		# This is the link to the blog archive
		if ($item->object_id == get_option('page_for_posts')) {
			# If we're on a blog archive - give the blog link the active class
			if (is_category() or is_tag() or is_day() or is_month() or is_year()) {
				$cssClasses[] = $cssClassName;
			}
		}
		# This is a link to a custom post type archive
		elseif ($item->type == 'post_type_archive') {
			# If we're on a taxonomy and this post type has that taxonomy - make it look active
			if (is_tax()) {
				global $wp_taxonomies;

				$term = $wp_query->get_queried_object();

				if (isset($wp_taxonomies[$term->taxonomy])) {
					if (in_array($item->object, $wp_taxonomies[$term->taxonomy]->object_type)) {
						$cssClasses[] = $cssClassName;
					}
				}
			}
		}
	}

	return $cssClasses;
}
?>
