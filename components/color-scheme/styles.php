<?php return function ($moduleName, $args = []) {
	return [
		[
			'name' => 'color_scheme',
			'label' => __('Color scheme', 'sleek_admin'),
			'type' => 'group',
			'sub_fields' => [
				...(include get_stylesheet_directory() . '/components/media/fields.php')($moduleName . '_styles_color_scheme', [
					'ratio' => false,
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
				]),
				[
					'name' => 'bg_color',
					'label' => __('Background color'),
					'type' => 'select',
					'choices' => [
						'transparent' => __('Transparent', 'sleek_admin'),
						'dark' => __('Dark', 'sleek_admin')
					],
					'default_value' => 'transparent',
					'conditional_logic' => [[[
						'field' => '{acf_key}_' . $moduleName . '_styles_color_scheme_media_media',
						'operator' => '==empty'
					]]]
				]
			]
		]
	];
};