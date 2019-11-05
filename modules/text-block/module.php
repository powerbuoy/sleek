<?php
namespace Sleek\Modules;

class TextBlock extends Module {
	public function fields () {
		return [
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
		];
	}
}
