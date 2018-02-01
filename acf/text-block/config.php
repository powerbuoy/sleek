<?php
/***
Use Text Block to add additional text to the page.
***/
return [
	[
		'name' => 'text-block-title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title for this text block.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'text-block-image',
		'label' => __('Image', 'sleek'),
		'instructions' => __('Select an image.', 'sleek'),
		'type' => 'image',
		'return_format' => 'id'
	],
	[
		'name' => 'text-block-description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Write a nice message here.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	]
];
