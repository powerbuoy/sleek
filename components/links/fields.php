<?php return function ($args = []) {
	$args = array_merge([
		'min' => false,
		'max' => false
	], $args);

	return [
		[
			'name' => 'links',
			'label' => __('Links', 'sleek_admin'),
			'type' => 'repeater',
			'min' => $args['min'],
			'max' => $args['max'],
			'sub_fields' => [
				...(include get_stylesheet_directory() . '/components/link/fields.php')()
			]
		]
	];
};