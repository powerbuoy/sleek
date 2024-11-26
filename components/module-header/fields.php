<?php return function ($args = []) {
	$config = array_merge([
		'kicker' => true,
		'description' => true,
		'links' => true
	], $args);

	if ($config['kicker']) {
		$fields[] = [
			'name' => 'kicker',
			'label' => __('Kicker', 'sleek_admin'),
			'type' => 'text'
		];
	}

	$fields = [
		[
			'name' => 'title',
			'label' => __('Title', 'sleek_admin'),
			'type' => 'text'
		]
	];

	if ($config['description']) {
		$fields[] = [
			'name' => 'description',
			'label' => __('Description', 'sleek_admin'),
			'type' => 'wysiwyg',
			'media_upload' => false,
			'toolbar' => 'simple'
		];
	}

	if ($config['links']) {
		$fields[] = (include get_stylesheet_directory() . '/components/links/fields.php')()[0];
	}

	return [
		[
			'name' => 'module_header',
			'label' => __('Module Header', 'sleek_admin'),
			'type' => 'group',
			'sub_fields' => $fields
		]
	];
};
