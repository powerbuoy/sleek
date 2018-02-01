<?php
/***
Post List allows you to manually select any number of posts to display on the page. Useful if you want to highlight certain posts or pages.
***/
return [
	[
		'name' => 'featured-posts-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __('Enter a title above the list of posts.', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'featured-posts-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Enter a description for the posts here.', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'featured-posts-posts',
		'label' => __('Posts', 'sleek_child'),
		'instructions' => __('Add any number of posts here.', 'sleek_child'),
		'type' => 'relationship'
	]
];
