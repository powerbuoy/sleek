<?php return function ($args = []) {
	return [
		[
			'name' => 'module_header',
			'label' => __('Module Header', 'sleek_admin'),
			'type' => 'group',
			'sub_fields' => [
				...(include get_stylesheet_directory() . '/components/text-align.php')()
			]
		]
	];
};