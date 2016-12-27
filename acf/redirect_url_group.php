<?php
# Make sure the_permalink() points to the redirect URL
add_filter('the_permalink', function ($url) {
	global $post;

	$redirectUrl = get_field('redirect_url', $post->ID);

	return $redirectUrl ? $redirectUrl : $url;
});

# Redirect single pages to the redirect URL
add_action('the_post', function ($po) {
	if (is_single() or is_page()) {
		$redirectUrl = get_field('redirect_url', $po->ID);

		if ($redirectUrl) {
			wp_redirect($redirectUrl);
		}
	}
});

# ACF Definition
return [
	'key' => 'redirect_url_group',
	'name' => 'redirect_url_group',
	'title' => __('Redirect URL', 'sleek'),
	'position' => 'side',

	# Fields
	'fields' => [
		[
			'key' => 'redirect_url',
			'name' => 'redirect_url',
			'instructions' => __('Enter a URL to have this post redirect there.', 'sleek'),
			'label' => __('Redirect URL', 'sleek'),
			'type' => 'url'
		]
	]
];
