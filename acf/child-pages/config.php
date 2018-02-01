<?php
/***
Use the Child Pages module on a parent page to display its children. The Child Pages module automatically updates as you add or remove child pages.
***/
return [
	[
		'name' => 'child-pages-title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title above the list of child pages.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'child-pages-description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the child pages.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	]
];
