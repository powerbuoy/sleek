<?php return function ($args = []) {
	return [
		[
			'name' => 'module_header',
			'label' => __('Module Header', 'sleek_admin'),
			'type' => 'group',
			'sub_fields' => [
				[
					'name' => 'kicker',
					'label' => __('Kicker', 'sleek_admin'),
					'type' => 'text',
					'instructions' => __('The kicker will only be visible if the title is filled out.', 'sleek_admin')
				],
				[
					'name' => 'title',
					'label' => __('Title', 'sleek_admin'),
					'type' => 'text'
				],
				[
					'name' => 'description',
					'label' => __('Description', 'sleek_admin'),
					'type' => 'wysiwyg',
					'media_upload' => false,
					'toolbar' => 'basic'
				]
			]
		]
	];
};
