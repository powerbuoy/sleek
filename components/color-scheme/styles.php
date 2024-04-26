<?php return function ($moduleName, $args = []) {
	$config = array_merge([
		'bg_colors' => true,
		'bg_media' => true
	], $args);

	$bgMediaGroup = [];

	# Background Media
	if ($config['bg_media']) {
		$bgMediaConfig = [
			'required' => false,
			'ratio' => false
		];

		if (is_array($config['bg_media'])) {
			$bgMediaConfig = array_merge($bgMediaConfig, $config['bg_media']);
		}

		$bgMediaGroup = [
			...(include get_stylesheet_directory() . '/components/media/fields.php')($moduleName . '_styles_color_scheme', [
				'label' => __('Background Media', 'sleek_admin'),
				'required' => $bgMediaConfig['required'],
				'ratio' => $bgMediaConfig['ratio'],
				'additional_fields' => [
					[
						'name' => 'light_media',
						'label' => __('Light media', 'sleek_admin'),
						'instructions' => __('Check this if the media is light. Dark text will then be used.', 'sleek_admin'),
						'message' => __('Light media', 'sleek_admin'),
						'type' => 'true_false',
						'conditional_logic' => [[[
							'field' => '{acf_key}_' . $moduleName . '_styles_color_scheme_media_media',
							'operator' => '!=empty'
						]]]
					],
					[
						'name' => 'media_overlay',
						'label' => __('Media overlay', 'sleek_admin'),
						'instructions' => __('Check this to add an overlay to the media (if the media is light, the overlay will be light too).'),
						'message' => __('Enable media overlay', 'sleek_admin'),
						'type' => 'true_false',
						'default_value' => true,
						'conditional_logic' => [[[
							'field' => '{acf_key}_' . $moduleName . '_styles_color_scheme_media_media',
							'operator' => '!=empty'
						]]]
					]
				]
			])
		];
	}

	# Background Colors
	$bgColorsGroup = [];

	if ($config['bg_colors']) {
		$choices = is_array($config['bg_media']) ? $config['bg_media'] : [
			'transparent' => __('Transparent', 'sleek_admin'),
			'dark' => __('Dark', 'sleek_admin')
		];

		$bgColorsGroup = [
			[
				'name' => 'bg_color',
				'label' => __('Background Color', 'sleek_admin'),
				'type' => 'select',
				'choices' => $choices,
				'default_value' => 'transparent',
				'conditional_logic' => [[[
					'field' => '{acf_key}_' . $moduleName . '_styles_color_scheme_media_media',
					'operator' => '==empty'
				]]]
			]
		];

	}

	# Return group
	return [
		[
			'name' => 'color_scheme',
			'label' => __('Color scheme', 'sleek_admin'),
			'type' => 'group',
			'sub_fields' => [
				...$bgMediaGroup,
				...$bgColorsGroup
			]
		]
	];
};