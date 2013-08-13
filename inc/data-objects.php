<?php
# add_action('init', 'h5b_register_post_types');

function h5b_register_post_types () {
	register_post_type('items', array(
		'labels'			=> array(
			'name'			=> __('Items', 'h5b'),
			'singular_label'=> __('Item', 'h5b')
		), 
		'rewrite'			=> array(
			'with_front' => false, 
			'slug' => __('url_items', 'h5b')
		), 
		'has_archive'		=> true, 
		'public'			=> true,
		'supports'			=> array(
			'title', 'editor', 'author', 'thumbnail', 'excerpt', 
			'trackbacks', 'custom-fields', 'revisions', 'page-attributes'
		)
	));

	register_post_type('locations', array(
		'labels'			=> array(
			'name'			=> __('Locations', 'h5b'),
			'singular_label'=> __('Location', 'h5b')
		), 
		'rewrite'			=> array(
			'with_front' => false, 
			'slug' => __('url_locations', 'h5b')
		), 
		'has_archive'		=> true, 
		'public'			=> true,
		'supports'			=> array(
			'title', 'editor', 'author', 'thumbnail', 'excerpt', 
			'trackbacks', 'custom-fields', 'revisions', 'page-attributes'
		)
	));
}
