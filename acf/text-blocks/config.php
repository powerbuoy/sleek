<?php
/***
Text Blocks, like Text Block, allows you to add additional text to the page. But Text Blocks, unlike Text Block, allows you to add any number of blocks.
***/
return [
	[
		'name' => 'text-blocks-title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title to display above the text blocks.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'text-blocks-description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the text blocks.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'text-blocks',
		'label' => __('Text Blocks', 'sleek'),
		'instructions' => __('Add any number of text blocks here.', 'sleek'),
		'button_label' => __('Add a text block', 'sleek'),
		'type' => 'repeater',
		'layout' => 'row',
		'sub_fields' => [
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
		]
	]
];
