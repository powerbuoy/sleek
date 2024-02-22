<?php return function ($args = []) {
	return [
		[
			'name' => 'links',
			'label' => __('Links', 'sleek_admin'),
			'type' => 'group',
			'sub_fields' => [
				...(include get_stylesheet_directory() . '/components/text-align.php')()
			]
		]
	];
};