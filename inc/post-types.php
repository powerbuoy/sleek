<?php
# Custom post types
# add_action('init', 'sleek_register_post_types');

# Registers custom post types (array('movies', 'directors')) and taxonomies (array('genre' => array('movies')))
function sleek_register_post_types ($postTypes, $taxonomies) {
	# Register Post Types
	foreach ($postTypes as $postType) {
		register_post_type($postType, array(
			'labels'			=> array(
				'name'			=> __(ucfirst($postType), 'sleek'),
				'singular_label'=> __(ucfirst($postType), 'sleek')
			), 
			'rewrite'			=> array(
				'with_front'	=> false, 
				'slug'			=> __('url_' . $postType, 'sleek')
			), 
			'has_archive'		=> true, 
			'public'			=> true,
			'supports'			=> array(
				'title', 'editor', 'author', 'thumbnail', 'excerpt', 
				'trackbacks', 'custom-fields', 'revisions', 'page-attributes'
			)
		));
	}

	# Register Taxonomies
	foreach ($taxonomies as $taxonomy => $forPostTypes) {
		register_taxonomy($taxonomy, $forPostTypes, array(
			'labels'			=> array(
				'name'			=> __(ucfirst(str_replace('_', ' ', $taxonomy)), 'sleek'), 
				'singular_label'=> __(ucfirst(str_replace('_', ' ', $taxonomy)), 'sleek')
			), 
			'rewrite'			=> array(
				'with_front'	=> false, 
				'slug'			=> __('url_' . $taxonomy, 'sleek')
			), 
			'sort'				=> true, 
			'hierarchical'		=> true
		));
	}
}
