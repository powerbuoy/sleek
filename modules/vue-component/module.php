<?php
# Description: Render a Vue component.

namespace Sleek\Modules;

class VueComponent extends Module {
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
				'name' => 'component',
				'label' => __('Component', 'sleek'),
				'type' => 'text'
			]
		];
	}
}
