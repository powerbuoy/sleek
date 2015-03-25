<?php
# Custom post types
# add_action('init', 'sleek_register_post_types');

# Registers custom post types (array('movies', 'directors')) and taxonomies (array('genre' => array('movies')))
function sleek_register_post_types ($postTypes, $taxonomies, $textdomain = 'sleek') {
	# Register Post Types
	foreach ($postTypes as $postType => $description) {
		register_post_type($postType, array(
			'labels'			=> array(
				'name'			=> __(ucfirst($postType), $textdomain),
				'singular_label'=> __(ucfirst($postType), $textdomain)
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
		));
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
