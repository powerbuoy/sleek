<?php
# Description: Display specific posts.

namespace Sleek\Modules;

class FeaturedPosts extends Module {
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
				'name' => 'rows',
				'label' => __('Posts', 'sleek_admin'),
				'type' => 'relationship'
			]
		];
	}
}
