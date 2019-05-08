<?php
/***
Unsurprisingly the Google Map module allows you to add a Google Map to your page.
***/
return [
	[
		'name' => 'google_map_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title to display above the map.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'google_map_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the map.', 'sleek'),
		'type' => 'wysiwyg'
	],
	[
		'name' => 'google_map_info_window',
		'label' => __('Information Window', 'sleek'),
		'instructions' => __("Enter a description that will be displayed in the map's info window.", 'sleek'),
		'type' => 'wysiwyg'
	],
	[
		'name' => 'google_map',
		'label' => __('Location', 'sleek'),
		'instructions' => __('Choose a location to display on the map. Note that you will need a valid Google Maps API Key entered in Settings -> Sleek -> Google maps api key.', 'sleek'),
		'type' => 'google_map'
	]
];
