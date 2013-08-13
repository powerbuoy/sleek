<?php
# add_action('init', 'h5b_register_post_types');

function h5b_register_post_types () {
	register_post_type('items', array(
		'labels'			=> array(
			'name'			=> __('Items', 'h5b'),
			'singular_label'=> __('item', 'h5b')
		), 
		'rewrite'			=> array(
			'with_front' => false, 
			'slug' => __('items', 'h5b')
		), 
		'has_archive'		=> true, 
		'public'			=> true,
		'supports'			=> array(
			'title', 'editor', 'author', 'thumbnail', 'excerpt', 
			'trackbacks', 'custom-fields', 'revisions', 'page-attributes'
		)
	));

	register_taxonomy('countries', 'items', array(
		'labels'				=> array(
			'name'				=> __('Countries', 'h5b'), 
			'singular_label'	=> __('Country', 'h5b')
		), 
		'rewrite'			=> array(
			'with_front' => false, 
			'slug' => __('countries', 'h5b')
		), 
		'sort'					=> true, 
		'hierarchical'			=> true
	));
}
