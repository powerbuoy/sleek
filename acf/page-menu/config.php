<?php
/***
Use the Page Menu module to create an automatically generated menu tree based on the page the user is currently on.
***/
return [
	[
		'name' => 'page_menu_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __("Enter a custom title above the menu or leave blank to display the parent page's title.", 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'page_menu_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the menu.', 'sleek'),
		'type' => 'wysiwyg'
	]
];
