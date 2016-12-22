<?php
/**
 * All post types are by default included in search so that custom taxonomy archives still work (WP Bug https://core.trac.wordpress.org/ticket/20234)
 * We need to adjust which should _actually_ show up ín search using pre_get_posts.
 */
function sleek_set_cpt_in_search ($pts = [], $override = false) {
	$postTypes = array_merge(['post', 'page'], $pts);

	if ($override) {
		$postTypes = $pts;
	}

	add_filter('pre_get_posts', function ($query) use ($postTypes) {
		if ($query->is_search() and !$query->is_admin() and $query->is_main_query() and !isset($_GET['post_type'])) {
			$query->set('post_type', $postTypes);
		}

		return $query;
	});
}
