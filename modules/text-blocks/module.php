<?php
namespace Sleek\Modules;

class TextBlocks extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek'),
				'type' => 'wysiwyg'
			],
			[
				'name' => 'text_blocks',
				'label' => __('Text Blocks', 'sleek'),
				'button_label' => __('Add a text block', 'sleek'),
				'type' => 'repeater',
				'layout' => 'row',
				'sub_fields' => [
					[
						'name' => 'title',
						'label' => __('Title', 'sleek'),
						'type' => 'text'
					],
					[
						'name' => 'image',
						'label' => __('Image', 'sleek'),
						'type' => 'image',
						'return_format' => 'id'
					],
					[
						'name' => 'description',
						'label' => __('Description', 'sleek'),
						'type' => 'wysiwyg'
					]
				]
			]
		];
	}
}
