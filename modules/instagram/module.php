<?php
# Description: Display your most recent Instagram pictures.

namespace Sleek\Modules;

class Instagram extends Module {
	public function init () {
		add_action('wp_enqueue_scripts', function () {
			wp_dequeue_style('meks_instagram-widget-styles');
		}, 99);
	}

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
				'name' => 'limit',
				'label' => __('Number of Images', 'sleek_admin'),
				'type' => 'number',
				'default_value' => 4
			]
		];
	}
}
