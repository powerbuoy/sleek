<?php
/***
Use the Video module to add a video to the page.
***/
return [
	[
		'name' => 'video-title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title to display above the video.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'video-description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the video.', 'sleek'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'video-code',
		'label' => __('Video', 'sleek'),
		'instructions' => __('Copy the YouTube/Vimeo URL and paste it here.', 'sleek'),
		'type' => 'oembed'
	]
];
