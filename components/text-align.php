<?php return function ($args = []) {
	return [
		[
			'name' => 'text_align',
			'label' => __('Text align', 'sleek_admin'),
			'type' => 'select',
			'choices' => [
				'inherit' => __('Inherit', 'sleek_admin'),
				'left' => __('Left', 'sleek_admin'),
				'center' => __('Center', 'sleek_admin'),
				'right' => __('Right', 'sleek_admin')
			],
			'default_value' => 'inherit'
		]
	];
};
