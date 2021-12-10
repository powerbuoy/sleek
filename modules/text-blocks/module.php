<?php
# Description: Add several blocks of text.

namespace Sleek\Modules;

class TextBlocks extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek_admin'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek_admin'),
				'type' => 'wysiwyg',
				'toolbar' => 'simple',
				'media_upload' => false
			],
			[
				'name' => 'text_blocks',
				'label' => __('Text Blocks', 'sleek_admin'),
				'button_label' => __('Add a text block', 'sleek_admin'),
				'type' => 'repeater',
				'layout' => 'row',
				'sub_fields' => [
					[
						'name' => 'title',
						'label' => __('Title', 'sleek_admin'),
						'type' => 'text'
					],
					[
						'name' => 'image',
						'label' => __('Image', 'sleek_admin'),
						'type' => 'image',
						'return_format' => 'id'
					],
					[
						'name' => 'description',
						'label' => __('Description', 'sleek_admin'),
						'type' => 'wysiwyg',
						'toolbar' => 'simple',
						'media_upload' => false
					]
				]
			]
		];
	}
}
