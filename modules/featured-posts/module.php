<?php
/*
	Description: Display specific posts.
 */
namespace Sleek\Modules;

class FeaturedPosts extends Module {
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
				'name' => 'rows',
				'label' => __('Posts', 'sleek'),
				'type' => 'relationship'
			]
		];
	}
}
