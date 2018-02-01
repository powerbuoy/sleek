<?php
return [
	[
		'name' => 'share-page-title',
		'label' => __('Title', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'share-page-description',
		'label' => __('Description', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'share-page-url',
		'label' => __('(Optional) enter a specific URL to share', 'sleek'),
		'instructions' => __('If left empty the URL of the page will be used.', 'sleek'),
		'type' => 'url'
	],
	[
		'name' => 'share-page-services',
		'label' => __('Select sharing methods', 'sleek'),
		'type' => 'checkbox',
		'choices' => [
			'Facebook' => 'Facebook',
			'Twitter' => 'Twitter',
			'LinkedIn' => 'LinkedIn',
			'Google Plus' => 'Google Plus',
			'Email' => 'Email'
		],
		'default_value' => [
			'Facebook',
			'Twitter',
			'LinkedIn',
			'Google Plus',
			'Email'
		]
	]
];
