<?php
/***
The Hubspot Form module allows you to embed a Hubspot form in the page.
***/
return [
	[
		'name' => 'hubspot-form-title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title to display above the form.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'hubspot-form-description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the form.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'hubspot-form-id',
		'label' => __('Form ID', 'sleek'),
		'instructions' => __('Enter the Hubspot Form ID here.', 'sleek'),
		'type' => 'text'
	]
];
