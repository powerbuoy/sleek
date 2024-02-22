<?php return function ($args = []) {
	$config = array_merge([
		'name' => 'ratio',
		'label' => __('Ratio', 'sleek_admin'),
		'conditional_logic' => false,
		'ratios' => [
			'auto' => __('Auto', 'sleek_admin'),
			'16-9' => '16:9'
		]
	], $args);

	$field = [
		'name' => $config['name'],
		'label' => $config['label'],
		'type' => 'select',
		'choices' => $config['ratios'],
		'default_value' => 'auto'
	];

	if ($config['conditional_logic']) {
		$field['conditional_logic'] = $config['conditional_logic'];
	}

	return [$field];
};