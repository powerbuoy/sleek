<?php
# Description: Embed a Video.

namespace Sleek\Modules;

class Video extends Module {
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
				'name' => 'code',
				'label' => __('Video', 'sleek_admin'),
				'instructions' => __('Copy the YouTube/Vimeo URL and paste it here.', 'sleek_admin'),
				'type' => 'oembed'
			]
		];
	}
}
