<?php
# Description: Embed a Google Map.

namespace Sleek\Modules;

class GoogleMap extends Module {
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
				'name' => 'info_window',
				'label' => __('Information Window', 'sleek'),
				'instructions' => __("Enter a text that will be displayed in the map's info window.", 'sleek'),
				'type' => 'wysiwyg',
				'toolbar' => 'simple',
				'media_upload' => false
			],
			[
				'name' => 'google_map',
				'label' => __('Location', 'sleek'),
				'instructions' => __('Choose a location to display on the map. Note that you will need a valid Google Maps API Key entered in Settings -> Sleek -> Google maps api key.', 'sleek'),
				'type' => 'google_map'
			]
		];
	}
}
