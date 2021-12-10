<?php
# Description: Add a block of text with an optional image.

namespace Sleek\Modules;

class TextBlock extends Module {
	public function fields () {
		return [
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
		];
	}
}
