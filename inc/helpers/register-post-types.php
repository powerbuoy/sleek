<?php
/**
 * Register custom post types
 *
 * Takes $postTypes as 'slug' => 'Name of sidebar' or optional config array.
 * Pass in an optional text domain as the second argument (for translating URLs etc)
 */
function sleek_register_post_types ($postTypes, $textdomain = 'sleek') {
	# Register Post Types
	foreach ($postTypes as $postType => $description) {
		$config = array(
			'labels'				=> array(
				'name'					=> __(ucfirst(str_replace('_', ' ', $postType)), $textdomain),
				'singular_label'		=> __(ucfirst(str_replace('_', ' ', $postType)), $textdomain)
			),
			'rewrite'				=> array(
				'with_front'			=> false,
				'slug'					=> __('url_' . $postType, $textdomain)
			),
			'exclude_from_search'	=> false,
			'has_archive'			=> true,
			'public'				=> true,
			'supports'				=> array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'wpcom-markdown',
				'trackbacks',
				'custom-fields',
				'revisions',
				'page-attributes',
				'comments'
			)
		);

		if (is_array($description)) {
			$config = array_merge($config, $description);
		}
		else {
			$config['description'] = $description;
		}

		register_post_type($postType, $config);
	}
}
