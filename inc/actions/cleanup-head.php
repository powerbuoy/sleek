<?php
/**
 * Cleanup HEAD
 *
 * http://www.themelab.com/2010/07/11/remove-code-wordpress-header/
 */
# add_action('init', 'sleek_cleanup_head');

function sleek_cleanup_head () {
	# Comment if needed
	## Really Simple Discovery
	remove_action('wp_head', 'rsd_link');

	## Windows Live Writer
	remove_action('wp_head', 'wlwmanifest_link');

	## Wordpress Generator
	remove_action('wp_head', 'wp_generator');

	## WPML Generator (TODO: What's this?? :P)
#	remove_action('wp_head', [$sitepress, 'meta_generator_tag']);

	## Useless link elements
	remove_action('wp_head', 'start_post_rel_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
}
