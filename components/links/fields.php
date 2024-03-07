<?php return function ($args = []) {
	# Extract all available icons from fontello config
	$icons = [];
	$icoPath = get_stylesheet_directory() . '/dist/assets/fontello/config.json';

	if (file_exists($icoPath)) {
		$data = json_decode(file_get_contents($icoPath));

		if (!empty($data->glyphs) and is_array($data->glyphs)) {
			foreach ($data->glyphs as $ico) {
				$icons[$ico->css] = \Sleek\Utils\convert_case($ico->css, 'title');
			}

			ksort($icons);
		}
	}

	return [
		[
			'name' => 'links',
			'label' => __('Links', 'sleek_admin'),
			'type' => 'repeater',
			'sub_fields' => [
				[
					'name' => 'link',
					'label' => __('Link', 'sleek_admin'),
					'type' => 'link'
				],
				[
					'name' => 'link_style',
					'label' => __('Link style', 'sleek_admin'),
					'type' => 'select',
					'choices' => [
						'button' => __('Button', 'sleek_admin'),
						'button button--ghost' => __('Button ghost', 'sleek_admin'),
						'link--button' => __('Link', 'sleek_admin')
					]
				],
				[
					'name' => 'icon',
					'label' => __('Icon', 'sleek_admin'),
					'type' => 'select',
					'choices' => $icons,
					'allow_null' => true
				]
			]
		]
	];
};