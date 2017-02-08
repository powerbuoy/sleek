<?php
# TODO: These actions/filters will be added every time this field is included... :/
# Make sure the_permalink() points to the redirect URL
add_filter('the_permalink', function ($url) {
	global $post;

	$redirectUrl = get_field('redirect-url', $post->ID);

	return $redirectUrl ? $redirectUrl : $url;
});

# Redirect single pages to the redirect URL
add_action('the_post', function ($po) {
	if (is_single($po->ID) or is_page($po->ID)) {
		$redirectUrl = get_field('redirect-url', $po->ID);

		if ($redirectUrl) {
			wp_redirect($redirectUrl);
		}
	}
});

# ACF Definition
return [
	[
		'name' => 'redirect-url',
		'label' => __('Redirect URL', 'sleek'),
		'instructions' => __('Enter a URL to have this post redirect there.', 'sleek'),
		'type' => 'url'
	]
];
