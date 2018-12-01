<?php
/***
Use the Next Post module to automatically link to the next post or page, or choose a specific post to link to.
***/
return [
	[
		'name' => 'next_post_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title above the post.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'next_post_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the post here.', 'sleek'),
		'type' => 'wysiwyg'
	],
	[
		'name' => 'next_post_post',
		'label' => __('Post', 'sleek'),
		'instructions' => __('(Optional) Choose a post or let WordPress automatically choose the next post.', 'sleek'),
		'type' => 'relationship',
		'max' => 1
	]
];
