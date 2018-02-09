<?php
/***
The Hubspot Form module allows you to embed a Hubspot form in the page.
***/
return [
	[
		'name' => 'hubspot_form_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title to display above the form.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'hubspot_form_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the form.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'hubspot_form_id',
		'label' => __('Form ID', 'sleek'),
		'instructions' => __('Enter the Hubspot Form ID here.', 'sleek'),
		'type' => 'text'
	]
];
