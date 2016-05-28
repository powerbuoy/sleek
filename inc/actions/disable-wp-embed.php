<?php
/**
 * Disable WP Embed
 * http://wordpress.stackexchange.com/questions/211701/what-does-wp-embed-min-js-do-in-wordpress-4-4
 */
# add_action('init', 'sleek_disable_wp_embed', 999);

function sleek_disable_wp_embed () {
	# Remove the REST API endpoint.
	remove_action('rest_api_init', 'wp_oembed_register_route');

	# Turn off oEmbed auto discovery.
	# Don't filter oEmbed results.
	remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

	# Remove oEmbed discovery links.
	remove_action('wp_head', 'wp_oembed_add_discovery_links');

	# Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action('wp_head', 'wp_oembed_add_host_js');
}
