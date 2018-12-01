<?php
/***
The Related Posts module shows the X latest posts in the same category as the currently viewed post.
***/
return [
	[
		'name' => 'related_posts_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title above the list of posts.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'related_posts_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the posts here.', 'sleek'),
		'type' => 'wysiwyg'
	],
	[
		'name' => 'related_posts_limit',
		'label' => __('Number of Posts', 'sleek'),
		'instructions' => __('How many posts would you like to display?', 'sleek'),
		'type' => 'number',
		'default_value' => 3
	]
];
