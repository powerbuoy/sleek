<?php return function ($args = []) {
	$args = array_merge([
		'default_value' => 'left'
	], $args);

	return [
		[
			'name' => 'media_position',
			'label' => __('Media position', 'sleek_admin'),
			'type' => 'select',
			'choices' => [
				'left' => __('Left', 'sleek_admin'),
				'right' => __('Right', 'sleek_admin')
			],
			'default_value' => $args['default_value']
		]
	];
};
