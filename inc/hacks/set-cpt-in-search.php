<?php
/**
 * Adds support for ?post_type during search
 * and limits what CPTs show up in search
 * All post types are by default included in search
 * so that custom taxonomy archives still work (WP Bug https://core.trac.wordpress.org/ticket/20234)
 * We need to adjust which should _actually_ show up ín search using pre_get_posts
 */
function sleek_set_cpt_in_search ($pts = []) {
	$postTypes = array_merge(['post', 'page'], $pts);

	add_filter('pre_get_posts', function ($query) {
		if ($query->is_search and !$query->is_admin and $query->is_main_query) {
			if (isset($_GET['post_type'])) {
				$query->set('post_type', [$_GET['post_type']]);
			}
			else {
				$query->set('post_type', $postTypes);
			}
		}

		return $query;
	});
}
