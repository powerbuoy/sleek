<?php
/*
	Description: Display your most recent Instagram pictures.
 */
namespace Sleek\Modules;

class Instagram extends Module {
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
				'name' => 'limit',
				'label' => __('Number of Images', 'sleek'),
				'type' => 'number',
				'default_value' => 4
			]
		];
	}
}
