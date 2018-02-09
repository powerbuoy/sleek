<?php
/***
The Attachments module allows you to add any number of files for download.
***/
return [
	[
		'name' => 'attachments_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title to display above the attachments.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'attachments_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the attachments.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'attachments_files',
		'label' => __('Files', 'sleek'),
		'instructions' => __('Select any number of files.', 'sleek'),
		'type' => 'repeater',
		'sub_fields' => [
			[
				'name' => 'attachments_files_file',
				'label' => __('Select a file', 'sleek'),
				'type' => 'file'
			]
		]
	]
];
