<?php
/***
Use the Page Menu module to create an automatically generated menu tree based on the page the user is currently on.
***/
return [
	[
		'name' => 'page-menu-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __("Enter a custom title above the menu or leave blank to display the parent page's title.", 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'page-menu-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Enter a description for the menu.', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	]
];
