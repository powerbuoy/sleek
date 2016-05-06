<?php
/**
 * Excludes the currently viewed post in UPW
 */
# add_filter('upw_wp_query_args', 'sleek_exclude_current_post_in_upw');

function sleek_exclude_current_post_in_upw ($args) {
	if (is_single()) {
		global $post;

		$args['post__not_in'] = array($post->ID);
	}

	return $args;
}
