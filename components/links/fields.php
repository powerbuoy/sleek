<?php return function ($args = []) {
	$args = array_merge([
		'min' => false,
		'max' => false,
		'name' => 'links',
		'label' => __('Links', 'sleek_admin'),
		'wrapper' => null
	], $args);

	return [
		[
			'name' => $args['name'],
			'label' => $args['label'],
			'type' => 'repeater',
			'min' => $args['min'],
			'max' => $args['max'],
			'wrapper' => $args['wrapper'],
			'sub_fields' => [
				...(include get_stylesheet_directory() . '/components/link/fields.php')()
			]
		]
	];
};