<?php
/***
Unsurprisingly the Google Map module allows you to add a Google Map to your page.
***/
return [
	[
		'name' => 'google-map-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __('Enter a title to display above the map.', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'google-map-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Enter a description for the map.', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'google-map-info-window',
		'label' => __('Information Window', 'sleek_child'),
		'instructions' => __("Enter a description that will be displayed in the map's info window.", 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'google-map',
		'label' => __('Location', 'sleek_child'),
		'instructions' => __('Choose a location to display on the map. Note that you will need a valid Google Maps API Key entered in Appearance -> Customize -> Theme options -> Google maps api key.', 'sleek_child'),
		'type' => 'google_map'
	]
];
