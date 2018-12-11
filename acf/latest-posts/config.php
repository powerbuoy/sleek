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
		'type' => 'wysiwyg'
	],
	[
		'name' => 'latest_posts_limit',
		'label' => __('Number of Posts', 'sleek'),
		'instructions' => __('How many posts would you like to show?', 'sleek'),
		'type' => 'number',
		'default_value' => 3
	]
];
