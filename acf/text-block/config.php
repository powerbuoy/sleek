<?php
/***
Use Text Block to add additional text to the page.
***/
return [
	[
		'name' => 'text_block_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title for this text block.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'text_block_image',
		'label' => __('Image', 'sleek'),
		'instructions' => __('Select an image.', 'sleek'),
		'type' => 'image',
		'return_format' => 'id'
	],
	[
		'name' => 'text_block_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Write something here.', 'sleek'),
		'type' => 'wysiwyg'
	]
];
