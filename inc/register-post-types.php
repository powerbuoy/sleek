<?php
/**
 * Register custom post types
 *
 * Pass in an array of custom post type slugs. You can optionally override the default
 * configuration by passing in a multi-dimensional array; array('my_post_type' => ['my-config' => 'my-value'])
 */
function sleek_register_post_types ($postTypes, $textdomain = false) {
	foreach ($postTypes as $postType => $data) {
		# If no data was supplied - a one-dimensional array is assumed
		if (!is_array($data)) {
			$postType = $data;
		}

		# Store plural version of name
		$plural = sleek_pluralize($postType);

		# Create the post type slug - if a textdomain is specified make it translatable, otherwise make it dash-separated
		$slug = $textdomain ? _x(str_replace('_', '-', $plural), 'url', $textdomain) : str_replace('_', '-', $plural);

		# Create the post type nice-name based on the the post type slug
		$name = ucfirst(str_replace('_', ' ', $postType));

		# Create the config
		$config = [
			'labels' => [
				'name' => __(sleek_pluralize($name), $textdomain),
				'singular_name' => __($name, $textdomain)
			],
			'rewrite' => [
				'with_front' => false,
				'slug' => $slug
			],
			'exclude_from_search' => false, # Never exclude from search because it prevents taxonomy archives for this post type (https://core.trac.wordpress.org/ticket/20234)
			'has_archive' => true,
			'public' => true,
			'show_in_rest' => true,
			'supports' => [
				'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks',
				'custom-fields', 'revisions', 'page-attributes', 'comments'
			]
		];

		# If a config array was specified
		if (is_array($data)) {
			$config = array_merge($config, $data);
		}

		register_post_type($postType, $config);
	}
}

# Instead of exclude_from_search we can use this to specifically tell WP which CPTs to include in search
function sleek_set_cpt_in_search ($postTypes) {
	add_filter('pre_get_posts', function ($query) use ($postTypes) {
		if ($query->is_search() and !$query->is_admin() and $query->is_main_query() and !isset($_GET['post_type'])) {
			$query->set('post_type', $postTypes);
		}

		return $query;
	});
}
