<?php
/***
Unsurprisingly the Google Map module allows you to add a Google Map to your page.
***/
return [
	[
		'name' => 'google-map-title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title to display above the map.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'google-map-description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the map.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'google-map-info-window',
		'label' => __('Information Window', 'sleek'),
		'instructions' => __("Enter a description that will be displayed in the map's info window.", 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'google-map',
		'label' => __('Location', 'sleek'),
		'instructions' => __('Choose a location to display on the map. Note that you will need a valid Google Maps API Key entered in Appearance -> Customize -> Theme options -> Google maps api key.', 'sleek'),
		'type' => 'google_map'
	]
];
