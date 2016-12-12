<?php
# Make sure the_permalink() points to the external URL
add_filter('the_permalink', function ($url) {
	global $post;

	$externalUrl = get_field('external_url', $post->ID);

	return $externalUrl ? $externalUrl : $url;
});

# Redirect single pages to the external URL
add_action('the_post', function () {
	global $post;

	if (is_single()) {
		$externalUrl = get_field('external_url', $post->ID);

		if ($externalUrl) {
			wp_redirect($externalUrl);
		}
	}
});

# ACF Definition
return [
	'key' => 'external_url_group',
	'title' => __('External URL', 'sleek'),
	'position' => 'side',

	# Location
	'location' => [
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page'
			]
		]
	],

	# Fields
	'fields' => [
		[
			'key' => 'external_url',
			'name' => 'external_url',
			'instructions' => __('Enter a URL to have this post redirect there.', 'sleek'),
			'label' => __('External URL', 'sleek'),
			'type' => 'url'
		]
	]
];
