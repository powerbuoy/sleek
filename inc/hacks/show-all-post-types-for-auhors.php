<?php
/**
 * Show all post types when browsing author
 */
# add_filter('pre_get_posts', 'sleek_show_all_post_types_for_authors');

function sleek_show_all_post_types_for_authors ($qry) {
	if ($qry->is_main_query() and $qry->is_author) {
		$qry->set('post_type', 'any');
	}
}
