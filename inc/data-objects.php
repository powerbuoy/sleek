<?php
# add_action('init', 'h5b_register_post_types');

function h5b_register_post_types () {
	# Register Post Types
	$postTypes = array('testimonials');

	foreach ($postTypes as $postType) {
		register_post_type($postType, array(
			'labels'			=> array(
				'name'			=> __(ucfirst($postType), 'h5b'),
				'singular_label'=> __(ucfirst($postType), 'h5b')
			), 
			'rewrite'			=> array(
				'with_front' => false, 
				'slug' => __('url_' . $postType, 'h5b')
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
	$taxonomies = array(
		'misc' => array('post', 'page')
	);

	foreach ($taxonomies as $taxonomy => $forPostTypes) {
		register_taxonomy('misc', $forPostTypes, array(
			'labels'			=> array(
				'name'			=> __(ucfirst(str_replace('_', ' ', $taxonomy)), 'h5b'), 
				'singular_label'=> __(ucfirst(str_replace('_', ' ', $taxonomy)), 'h5b')
			), 
			'rewrite'			=> array(
				'with_front'	=> false, 
				'slug'			=> __('url_' . $taxonomy, 'h5b')
			), 
			'sort'				=> true, 
			'hierarchical'		=> true
		));
	}
}
