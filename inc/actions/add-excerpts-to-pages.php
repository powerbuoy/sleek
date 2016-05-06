<?php
/**
 * Give pages excerpts
 */
# add_action('init', 'sleek_add_excerpts_to_pages');

function sleek_add_excerpts_to_pages () {
	add_post_type_support('page', 'excerpt');
}
