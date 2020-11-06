<?php
# Description: Embed a Video.

namespace Sleek\Modules;

class Video extends Module {
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
				'name' => 'code',
				'label' => __('Video', 'sleek'),
				'instructions' => __('Copy the YouTube/Vimeo URL and paste it here.', 'sleek'),
				'type' => 'oembed'
			]
		];
	}
}
