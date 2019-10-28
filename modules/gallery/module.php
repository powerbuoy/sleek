<?php
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
				'type' => 'wysiwyg'
			],
			[
				'name' => 'images',
				'label' => __('Images', 'sleek'),
				'type' => 'gallery'
			]
		];
	}
}
