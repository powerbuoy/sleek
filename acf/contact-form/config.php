<?php
/***
With the Contact Form module you can add a Contact Form 7 form anywhere on the page. Make sure you have installed the Contact Form 7 plug-in first and created at least one form.
***/
return [
	[
		'name' => 'contact_form_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title to display above the form.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'contact_form_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the form.', 'sleek'),
		'type' => 'wysiwyg'
	],
	[
		'name' => 'contact_form_id',
		'label' => __('Form', 'sleek'),
		'instructions' => __('Select a Contact Form 7 form from the dropdown. Please note that this module requires the Contact Form 7 plug-in: https://wordpress.org/plugins/contact-form-7/', 'sleek'),
		'type' => 'post_object',
		'return_format' => 'id',
		'post_type' => ['wpcf7_contact_form']
	]
];
