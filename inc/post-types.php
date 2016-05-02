<?php
# Custom post types
# add_action('init', 'sleek_register_post_types');

# Registers custom post types (array('movies', 'directors')) and taxonomies (array('genre' => array('movies')))
function sleek_register_post_types ($postTypes, $taxonomies, $textdomain = 'sleek', $excludeFromSearch = false) {
	# Register Post Types
	foreach ($postTypes as $postType => $description) {
		$pt = array(
			'labels'			=> array(
				'name'			=> __(ucfirst(str_replace('_', ' ', $postType)), $textdomain),
				'singular_label'=> __(ucfirst(str_replace('_', ' ', $postType)), $textdomain)
			),
			'description'		=> $description,
			'rewrite'			=> array(
				'with_front'	=> false,
				'slug'			=> __('url_' . $postType, $textdomain)
			),
			'has_archive'		=> true,
			'public'			=> true,
			'supports'			=> array(
				'title', 'editor', 'author', 'thumbnail', 'excerpt', 'wpcom-markdown',
				'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'comments'
			)
		);

		$pt['exclude_from_search'] = $excludeFromSearch;

		register_post_type($postType, $pt);
	}

	# Register Taxonomies
	foreach ($taxonomies as $taxonomy => $forPostTypes) {
		$hierarchical = strpos($taxonomy, 'tag') !== false ? false : true;

		register_taxonomy($taxonomy, $forPostTypes, array(
			'labels'			=> array(
				'name'			=> __(ucfirst(str_replace('_', ' ', $taxonomy)), $textdomain),
				'singular_label'=> __(ucfirst(str_replace('_', ' ', $taxonomy)), $textdomain)
			),
			'rewrite'			=> array(
				'with_front'	=> false,
				'slug'			=> __('url_' . $taxonomy, $textdomain)
			),
			'sort'				=> true,
			'hierarchical'		=> $hierarchical
		));
	}
}
