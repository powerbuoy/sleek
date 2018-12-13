<?php
/***
Use the Video module to add a video to the page.
***/
return [
	[
		'name' => 'video_title',
		'label' => __('Title', 'sleek'),
		'instructions' => __('Enter a title to display above the video.', 'sleek'),
		'type' => 'text'
	],
	[
		'name' => 'video_description',
		'label' => __('Description', 'sleek'),
		'instructions' => __('Enter a description for the video.', 'sleek'),
		'type' => 'wysiwyg'
	],
	[
		'name' => 'video_code',
		'label' => __('Video', 'sleek'),
		'instructions' => __('Copy the YouTube/Vimeo URL and paste it here.', 'sleek'),
		'type' => 'oembed'
	]
];
