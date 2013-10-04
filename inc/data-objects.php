<?php
# add_action('init', 'h5b_register_post_types');

function h5b_register_post_types () {
	$postTypes = array('testimonials', 'whitepapers', 'videos');

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
}
