<?php
# Description: Display a gallery of images.

namespace Sleek\Modules;

class Gallery extends Module {
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
				'name' => 'images',
				'label' => __('Images', 'sleek_admin'),
				'type' => 'gallery'
			]
		];
	}
}
