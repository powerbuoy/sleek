<?php
function sleek_get_sass_config ($key) {
	if (!file_exists(get_stylesheet_directory() . '/src/sass/config.scss')) {
		return false;
	}

	$configCss = file_get_contents(get_stylesheet_directory() . '/src/sass/config.scss');
	$matches = false;

	preg_match('/\$' . $key . ':(.*?);/s', $configCss, $matches);

	if (isset($matches[1])) {
		return $matches[1];
	}

	return false;
}

function sleek_get_sass_colors () {
	if (!file_exists(get_stylesheet_directory() . '/src/sass/config.scss')) {
		return false;
	}

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
	if (!file_exists(get_stylesheet_directory() . '/icons.json')) {
		return false;
	}

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

	if ($sassIcons) {
		foreach ($sassIcons as $icon) {
			$icons[] = [
				'title' => ucfirst(str_replace(['-', '_'], ' ', $icon['css'])),
				'inline' => 'span',
				'classes' => 'icon-' . $icon['css']
			];
		}
	}

	# And colors
	$sassColors = sleek_get_sass_colors();
	$colors = [
		[
			'title' => __('Default', 'sleek'),
			'selector' => 'a',
			'classes' => 'button'
		]
	];
	$ghostColors = [
		[
			'title' => __('Default', 'sleek'),
			'selector' => 'a',
			'classes' => 'button button--ghost'
		]
	];

	if ($sassColors) {
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
	}

	# Allow empty spans (NOTE: Doesn't work??)
	$settings['extended_valid_elements'] = '#span[*]';

	# Keep the built-in WP styles and merge with ours
	$settings['style_formats_merge'] = true;

	# Also keep any potentially added style_formats
	$oldFormats = [];

	if (isset($settings['style_formats'])) {
		$oldFormats = json_decode($settings['style_formats']);
	}

	$newFormats = array_merge($oldFormats, [
		[
			'title' => __('Button', 'sleek'),
			'items' => $colors
		],
		[
			'title' => __('Button ghost', 'sleek'),
			'items' => $ghostColors
		],
		[
			'title' => __('Icons', 'sleek'),
			'items' => $icons
		]
	]);

	$settings['style_formats'] = json_encode($newFormats);

	return $settings;
});
