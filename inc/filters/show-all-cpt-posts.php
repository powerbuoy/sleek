<?php
/**
 * Show all posts (ignore posts_per_page setting) when browsing custom post types
 */
# add_filter('pre_get_posts', 'sleek_show_all_cpt_posts');

function sleek_show_all_cpt_posts () {
	if (!is_admin()) {
		$limit = get_option('posts_per_page');

		if (is_post_type_archive()) {
			$limit = -1;
		}

		set_query_var('posts_per_page', $limit);
	}
}
?>
