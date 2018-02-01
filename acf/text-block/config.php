<?php
/***
Use Text Block to add additional text to the page.
***/
return [
	[
		'name' => 'text-block-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __('Enter a title for this text block.', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'text-block-image',
		'label' => __('Image', 'sleek_child'),
		'instructions' => __('Select an image.', 'sleek_child'),
		'type' => 'image',
		'return_format' => 'id'
	],
	[
		'name' => 'text-block-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Write a nice message here.', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	]
];
