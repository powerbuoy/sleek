<?php
/***
The Redirect URL field allows you to redirect this post to another URL. If you want to add a normal 301 redirect you should use a redirection plug-in or .htaccess instead. This module is useful if you want to display a post on your page but have it link elsewhere.
***/
# Make sure the_permalink() points to the redirect URL
if (!function_exists('sleek_redirect_url_permalink_filter')) {
	function sleek_redirect_url_permalink_filter ($url) {
		global $post;

		$redirectUrl = get_field('redirect-url', $post->ID);

		return $redirectUrl ? $redirectUrl : $url;
	}
}

if (!has_filter('the_permalink', 'sleek_redirect_url_permalink_filter')) {
	add_filter('the_permalink', 'sleek_redirect_url_permalink_filter');
}

# Redirect single pages to the redirect URL
if (!function_exists('sleek_redirect_url_the_post_action')) {
	function sleek_redirect_url_the_post_action ($po) {
		if (is_single($po->ID) or is_page($po->ID)) {
			$redirectUrl = get_field('redirect-url', $po->ID);

			if ($redirectUrl) {
				wp_redirect($redirectUrl);
			}
		}
	}
}

if (!has_filter('the_post', 'sleek_redirect_url_the_post_action')) {
	add_action('the_post', 'sleek_redirect_url_the_post_action');
}

# ACF Definition
return [
	[
		'name' => 'redirect-url',
		'label' => __('Redirect URL', 'sleek_child'),
		'instructions' => __('Enter a URL to have this post redirect there.', 'sleek_child'),
		'type' => 'url'
	]
];
