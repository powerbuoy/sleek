<?php
function sleek_get_sass_colors () {
	$configCss = file_get_contents(get_stylesheet_directory() . '/src/sass/config.scss');
	$matches = false;
	$colors = [];

	preg_match('/\$colors: \((.*?)\)/s', $configCss, $matches);

	if ($matches and count($matches) > 1) {
		$matches = explode("\n", $matches[1]);

		foreach ($matches as $match) {
			if ($match) {
				$tmp = explode(':', $match);
				$color = trim(str_replace('"', '', $tmp[0]));
				$colors[] = [
					'name' => trim(str_replace('"', '', $tmp[0])),
					'color' => trim(str_replace('"', '', $tmp[1]))
				];
			}
		}
	}

	return $colors;
}

function sleek_get_sass_icons () {
	$icons = file_get_contents(get_stylesheet_directory() . '/icons.json');

	return json_decode($icons, true)['glyphs'];
}

# Add editor style
add_editor_style();

# Add the styleselect dropdown
add_filter('mce_buttons_2', function ($buttons) {
	array_unshift($buttons, 'styleselect');

	return $buttons;
});

# Add some stuff to the Format dropdown
add_filter('tiny_mce_before_init', function ($settings) {
	# Get a list of all icons
	$sassIcons = sleek_get_sass_icons();
	$icons = [];

	foreach ($sassIcons as $icon) {
		$icons[] = [
			'title' => ucfirst(str_replace(['-', '_'], ' ', $icon['css'])),
			'inline' => 'span',
			'classes' => 'icon-' . $icon['css']
		];
	}

	# And colors
	$sassColors = sleek_get_sass_colors();
	$colors = [
		[
			'title' => __('Default', 'sleek_child'),
			'selector' => 'a',
			'classes' => 'button'
		]
	];
	$ghostColors = [
		[
			'title' => __('Default', 'sleek_child'),
			'selector' => 'a',
			'classes' => 'button button--ghost'
		]
	];

	foreach ($sassColors as $color) {
		$colors[] = [
			'title' => ucfirst(str_replace('-', ' ', $color['name'])),
			'selector' => 'a',
			'classes' => 'button button--' . $color['name']
		];
		$ghostColors[] = [
			'title' => ucfirst(str_replace('-', ' ', $color['name'])),
			'selector' => 'a',
			'classes' => 'button button--ghost button--' . $color['name']
		];
	}

	# Allow empty spans (NOTE: Doesn't work??)
	$settings['extended_valid_elements'] = '#span[*]';

	# Keep the built-in WP styles and merge with ours
	$settings['style_formats_merge'] = true;
	$settings['style_formats'] = json_encode([
		[
			'title' => __('Button', 'sleek_child'),
			'items' => $colors
		],
		[
			'title' => __('Button ghost', 'sleek_child'),
			'items' => $ghostColors
		],
		[
			'title' => __('Icons', 'sleek_child'),
			'items' => $icons
		]
	]);

	return $settings;
});