<?php
/***
Use the Child Pages module on a parent page to display its children. The Child Pages module automatically updates as you add or remove child pages.
***/
return [
	[
		'name' => 'child-pages-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __('Enter a title above the list of child pages.', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'child-pages-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Enter a description for the child pages.', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	]
];
