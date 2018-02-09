<?php
/***
Text Blocks, like Text Block, allows you to add additional text to the page. But Text Blocks, unlike Text Block, allows you to add any number of blocks.
***/
return [
	[
		'name' => 'text_blocks_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title to display above the text blocks.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'text_blocks_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the text blocks.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'text_blocks',
		'label' => __('Text Blocks', 'sleek'),
		'instructions' => __('Add any number of text blocks here.', 'sleek'),
		'button_label' => __('Add a text block', 'sleek'),
		'type' => 'repeater',
		'layout' => 'row',
		'sub_fields' => [
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
				'instructions' => __('Write a nice message here.', 'sleek'),
				'type' => 'wysiwyg',
				'media_upload' => false
			]
		]
	]
];
