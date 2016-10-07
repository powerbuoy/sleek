<?php
/**
 * Reduces the number of HTTP requests by removing
 * unwanted CSS and JS files from WP and plug-ins
 */
function sleek_reduce_requests ($except = []) {
	if (!is_admin()) {
		# WP Embed (URL missing)
		if (!in_array('wp_oembed', $except)) {
			# Remove the REST API endpoint.
			remove_action('rest_api_init', 'wp_oembed_register_route');

			# Turn off oEmbed auto discovery. Don't filter oEmbed results.
			remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

			# Remove oEmbed discovery links.
			remove_action('wp_head', 'wp_oembed_add_discovery_links');

			# Remove oEmbed-specific JavaScript from the front-end and back-end.
			remove_action('wp_head', 'wp_oembed_add_host_js');
		}

		# Emoji
		if (!in_array('wp_emoji', $except)) {
			remove_action('wp_head', 'print_emoji_detection_script', 7);
			remove_action('wp_print_styles', 'print_emoji_styles');
		}

		# CF7
		if (!in_array('wpcf7_css', $except)) {
			add_filter('wpcf7_load_css', '__return_false');
		}
		if (!in_array('wpcf7_js', $except)) {
			add_filter('wpcf7_load_js', '__return_false');
		}

		# UPW
		if (!in_array('upw', $except)) {
			add_filter('upw_enqueue_styles', '__return_false');
		}

		# WPMU Signup Stylesheet
		if (!in_array('wpmu_signup_stylesheet', $except)) {
			add_action('get_header', function () {
				remove_action('wp_head', 'wpmu_signup_stylesheet');
			});
		}

		# Duplicate post CSS
		if (!in_array('duplicate-post', $except)) {
			wp_dequeue_style('duplicate-post');
		}
	}
}
