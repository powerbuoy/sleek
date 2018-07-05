<?php
/***
The Latest Posts module shows the X latest posts from any post type you select. It automatically updates as you add or remove posts.
***/
return [
	[
		'name' => 'latest_posts_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title above the list of posts.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'latest_posts_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the posts here.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'latest_posts_post_type',
		'label' => __('Post Type', 'sleek'),
		'instructions' => __('Select the type of post you would like to display.', 'sleek'),
		'type' => 'select',
		'choices' => [
			'post' => __('Posts')
		],
		'allow_null' => true,
		'default_value' => 'any',
		'multiple' => true,
		'ui' => true
	],
	[
		'name' => 'latest_posts_limit',
		'label' => __('Number of Posts', 'sleek'),
		'instructions' => __('How many posts would you like to display?', 'sleek'),
		'type' => 'number',
		'default_value' => 3
	],
	# NOTE: Add more taxonomy fields as needed
	[
		'name' => 'latest_posts_category',
		'label' => __('Category', 'sleek_child'),
		'instructions' => __('Limit posts to this category.', 'sleek_child'),
		'type' => 'taxonomy',
		'taxonomy' => 'category',
		'return_format' => 'id',
		'allow_null' => true
	]
];
