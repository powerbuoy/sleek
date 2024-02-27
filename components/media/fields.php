<?php return function ($moduleName, $args = []) {
	$config = array_merge([
		'ratio' => true,
		'additional_fields' => []
	], $args);

	# Work out all the media mime types
	$mimes = wp_get_mime_types();
	$mediaExts = [];

	foreach ($mimes as $ext => $mime) {
		if (strpos($mime, 'video') !== false or strpos($mime, 'image') !== false) {
			$exts = explode('|', $ext);
			$mediaExts[] = array_merge($mediaExts, $exts);
		}
	}

	# Main media file
	$fields = [
		[
			'name' => 'media',
			'label' => __('Image or Video', 'sleek_admin'),
			'type' => 'file',
			'return_format' => 'id',
			# TODO: MIME_TYPES only image and video
		]
	];

	if ($config['ratio']) {
		$fields = array_merge($fields, (include get_stylesheet_directory() . '/components/ratio.php')([
			'conditional_logic' => [[[
				'field' => '{acf_key}_' . $moduleName . '_media_media',
				'operator' => '!=empty'
			]]]
		]));
	}

	# Portrait media
	$fields[] = [
		'name' => 'media_portrait',
		'label' => __('Portrait Media', 'sleek_admin'),
		'instructions' => __('Optionally select another image or video to be used in portrait mode.', 'sleek_admin'),
		'type' => 'file',
		'return_format' => 'id',
		'conditional_logic' => [[[
			'field' => '{acf_key}_' . $moduleName . '_media_media',
			'operator' => '!=empty'
		]]]
	];

	if ($config['ratio']) {
		$fields = array_merge($fields, (include get_stylesheet_directory() . '/components/ratio.php')([
			'name' => 'ratio_portrait',
			'conditional_logic' => [[[
				'field' => '{acf_key}_' . $moduleName . '_media_media_portrait',
				'operator' => '!=empty'
			]]]
		]));
	}

	# Potential additional fields
	$fields = array_merge($fields, $config['additional_fields']);

	# Return as group
	return [
		[
			'name' => 'media',
			'label' => __('Media', 'sleek_admin'),
			'type' => 'group',
			'sub_fields' => $fields
		]
	];
};