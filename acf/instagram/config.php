<?php
/***
Display your latest Instagram photos using the Instagram module. First make sure you have installed the WP Instagram Widget plug-in.
***/
return [
	[
		'name' => 'instagram-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __('Enter a title to display above the Instagram feed.', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'instagram-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Enter a description for the Instagram feed.', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'instagram-username',
		'label' => __('Instagram username', 'sleek_child'),
		'instructions' => __('Enter the Instagram username here. Please note that this module requires the WP Instagram Widget plug-in: https://wordpress.org/plugins/wp-instagram-widget/', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'instagram-limit',
		'label' => __('Number of images', 'sleek_child'),
		'instructions' => __('How many images would you like to display?', 'sleek_child'),
		'type' => 'number',
		'default_value' => 4
	]
];
