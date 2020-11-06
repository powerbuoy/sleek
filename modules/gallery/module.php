<?php
# Description: Display a gallery of images.

namespace Sleek\Modules;

class Gallery extends Module {
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
				'type' => 'wysiwyg',
				'toolbar' => 'simple',
				'media_upload' => false
			],
			[
				'name' => 'images',
				'label' => __('Images', 'sleek'),
				'type' => 'gallery'
			]
		];
	}
}
