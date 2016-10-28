<?php
/**
 * Proxy for AJAX requests
 */
# add_action('wp_ajax_sleek_proxy', 'sleek_proxy');
# add_action('wp_ajax_nopriv_sleek_proxy', 'sleek_proxy');

# TODO: Improve security here if ever used again
function sleek_proxy () {
	$validURLs = [
		'https://feeds.foursquare.com',
		'http://www.google.com'
	];
	$valid = false;

	foreach ($validURLs as $validURL) {
		if (strpos($_REQUEST['url'], $validURL) === 0) {
			$valid = true;
		}
	}

	if (!$valid) {
		die('Invalid URL');
	}

	header('Content-type: application/xml');

	$handle = fopen($_REQUEST['url'], 'r');

	if ($handle) {
		while (!feof($handle)) {
			echo fgets($handle, 4096);
		}

		fclose($handle);
	}

	die;
}

# Show all search results on AJAX search
# add_action('pre_get_posts', 'sleek_set_posts_per_page');

function sleek_set_posts_per_page ($query) {
	global $wp_the_query;

	if ((!is_admin() and $query === $wp_the_query) and (is_search() and defined('DOING_AJAX') and DOING_AJAX)) {
		$query->set('posts_per_page', -1);
	}

	return $query;
}
