<?php
# Make sure the_permalink() points to the redirect URL
remove_filter('the_permalink', 'sleek_redirect_url_permalink_filter');
add_filter('the_permalink', 'sleek_redirect_url_permalink_filter');

function sleek_redirect_url_permalink_filter ($url) {
	global $post;

	$redirectUrl = get_field('redirect-url', $post->ID);

	return $redirectUrl ? $redirectUrl : $url;
}

# Redirect single pages to the redirect URL
remove_action('the_post', 'sleek_redirect_url_the_post_action');
add_action('the_post', 'sleek_redirect_url_the_post_action');

function sleek_redirect_url_the_post_action ($po) {
	if (is_single($po->ID) or is_page($po->ID)) {
		$redirectUrl = get_field('redirect-url', $po->ID);

		if ($redirectUrl) {
			wp_redirect($redirectUrl);
		}
	}
}

# ACF Definition
return [
	[
		'name' => 'redirect-url',
		'label' => __('Redirect URL', 'sleek'),
		'instructions' => __('Enter a URL to have this post redirect there.', 'sleek'),
		'type' => 'url'
	]
];
