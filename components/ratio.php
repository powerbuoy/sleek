<?php return function ($args = []) {
	return [
		[
			'name' => 'ratio',
			'label' => __('Ratio', 'sleek_admin'),
			'type' => 'select',
			'choices' => [
				'16-9' => '16:9'
			]
		]
	];
};