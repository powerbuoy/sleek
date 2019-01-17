<?php
/***
Use the Child Pages module on a parent page to display its children. The Child Pages module automatically updates as you add or remove child pages.
***/
return [
	[
		'name' => 'child_pages_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title above the list of child pages.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'child_pages_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the child pages.', 'sleek'),
		'type' => 'wysiwyg'
	],
	[
		'name' => 'child_pages_page_id',
		'label' => __('Page', 'sleek'),
		'instructions' => __('Select the page whose child pages you want to display. If left empty the current page\'s child pages will be displayed.', 'sleek'),
		'type' => 'post_object',
		'post_type' => ['page'],
		'required' => false,
		'allow_null' => true,
		'return_format' => 'id'
	]
];
