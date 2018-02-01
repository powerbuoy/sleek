<?php
/***
With the Users module you can list any number of users on the page. Perfect for an Employee page or similar.
***/
return [
	[
		'name' => 'users-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __('Enter a title above the list of users.', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'users-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Enter a description for the posts users.', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'users-users',
		'label' => __('Users', 'sleek_child'),
		'instructions' => __('Add any number of users here.', 'sleek_child'),
		'type' => 'user',
		'multiple' => true,
		'allow_null' => false
	]
];
