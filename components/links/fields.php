<?php return function ($args = []) {
	return [
		[
			'name' => 'links',
			'label' => __('Links', 'sleek_admin'),
			'type' => 'repeater',
			'sub_fields' => [
				[
					'name' => 'link',
					'label' => __('Link', 'sleek_admin'),
					'type' => 'link'
				],
				[
					'name' => 'link_style',
					'label' => __('Link style', 'sleek_admin'),
					'type' => 'select',
					'choices' => [
						'button' => __('Button', 'sleek_admin'),
						'button button--ghost' => __('Button ghost', 'sleek_admin')
					]
				]
			]
		]
	];
};