<?php
/***
With the "Share Page" module you can add Facebook, Twitter etc links that lets users share the page.
***/
return [
	[
		'name' => 'share_page_title',
		'label' => __('Title', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'share_page_description',
		'label' => __('Description', 'sleek'),
		'type' => 'wysiwyg'
	],
	[
		'name' => 'share_page_url',
		'label' => __('(Optional) enter a specific URL to share', 'sleek'),
		'instructions' => __('If left empty the URL of the page will be used.', 'sleek'),
		'type' => 'url'
	],
	[
		'name' => 'share_page_services',
		'label' => __('Select sharing methods', 'sleek'),
		'type' => 'checkbox',
		'choices' => [
			'Facebook' => 'Facebook',
			'Twitter' => 'Twitter',
			'LinkedIn' => 'LinkedIn',
		#	'Google Plus' => 'Google Plus',
			'Email' => 'Email'
		],
		'default_value' => [
			'Facebook',
			'Twitter',
			'LinkedIn',
		#	'Google Plus',
			'Email'
		]
	]
];
