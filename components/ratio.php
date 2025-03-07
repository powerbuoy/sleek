<?php return function ($args = []) {
	$config = array_merge([
		'name' => 'ratio',
		'label' => __('Ratio', 'sleek_admin'),
		'conditional_logic' => false,
		'default_value' => 'auto',
		'choices' => [
			'auto' => __('Auto', 'sleek_admin'),
			'16-9' => '16:9',
			'1-1' => '1:1',
			'4-3' => '4:3',
			'4-5' => '4:5'
		]
	], $args);

	$field = [
		'name' => $config['name'],
		'label' => $config['label'],
		'type' => 'select',
		'choices' => $config['choices'],
		'default_value' => $config['default_value']
	];

	if ($config['conditional_logic']) {
		$field['conditional_logic'] = $config['conditional_logic'];
	}

	return [$field];
};