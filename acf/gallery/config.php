<?php
/***
Use the Gallery module to add any number of images to the page.
***/
return [
	[
		'name' => 'gallery-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __('Enter a title to display above the gallery.', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'gallery-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Enter a description for the gallery.', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'gallery-images',
		'label' => __('Images', 'sleek_child'),
		'instructions' => __('Select any number of images.', 'sleek_child'),
		'type' => 'gallery'
	]
];
