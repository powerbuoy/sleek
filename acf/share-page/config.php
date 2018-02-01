<?php
return [
	[
		'name' => 'share-page-title',
		'label' => __('Title', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'share-page-description',
		'label' => __('Description', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'share-page-url',
		'label' => __('(Optional) enter a specific URL to share', 'sleek_child'),
		'instructions' => __('If left empty the URL of the page will be used.', 'sleek_child'),
		'type' => 'url'
	],
	[
		'name' => 'share-page-services',
		'label' => __('Select sharing methods', 'sleek_child'),
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
