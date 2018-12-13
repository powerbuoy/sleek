<?php
/***
Sibling Pages is very similar to Child Pages but instead of displaying a posts children it displays its siblings. It's common to use Child Pages on the parent and Sibling Pages on every child of the parent.
***/
return [
	[
		'name' => 'sibling_pages_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title above the list of sibling pages.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'sibling_pages_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the sibling pages.', 'sleek'),
		'type' => 'wysiwyg'
	]
];
