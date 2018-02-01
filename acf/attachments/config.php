<?php
/***
The Attachments module allows you to add any number of files for download.
***/
return [
	[
		'name' => 'attachments-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __('Enter a title to display above the attachments.', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'attachments-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Enter a description for the attachments.', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'attachments-files',
		'label' => __('Files', 'sleek_child'),
		'instructions' => __('Select any number of files.', 'sleek_child'),
		'type' => 'repeater',
		'sub_fields' => [
			[
				'name' => 'attachments-files-file',
				'label' => __('Select a file', 'sleek_child'),
				'type' => 'file'
			]
		]
	]
];
