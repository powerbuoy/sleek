<?php
/***
With the Users module you can list any number of users on the page. Perfect for an Employee page or similar.
***/
return [
	[
		'name' => 'users_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title above the list of users.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'users_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the posts users.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'users_users',
		'label' => __('Users', 'sleek'),
		'instructions' => __('Add any number of users here.', 'sleek'),
		'type' => 'user',
		'multiple' => true,
		'allow_null' => false
	]
];
