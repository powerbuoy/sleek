<?php
/**
 * Register some options built into sleek
 */
 add_action('customize_register', function ($wpCustomize) {
 	$wpCustomize->add_section('sleek_settings', [
 		'title' => __('Theme Settings', 'sleek'),
 		'description' => __('Various settings for your theme.', 'sleek')
 	]);

	sleek_register_theme_options($wpCustomize, [
		'head_code' => 'textarea',
		'body_code' => 'textarea',
		'foot_code' => 'textarea',

		'google_maps_api_key' => 'text',
		'google_search_api_key' => 'text',
		'google_search_engine_id' => 'text'
	], 'sleek');
});

/**
 * Helper function for registering theme options
 */
function sleek_register_theme_options ($wpCustomize, $options, $textdomain = 'sleek') {
	foreach ($options as $name => $type) {
		$args = [
			'title' => __(ucfirst(str_replace('_', ' ', $name)), $textdomain),
			'description' => null,
			'default' => null,
			'type' => 'text'
		];

		if (is_array($type)) {
			$args = array_merge($args, $type);
		}
		else {
			$args['type'] = $type;
		}

		$wpCustomize->add_setting($name, [
			'title' => $args['title'],
			'description' => $args['description'],
			'default' => $args['default']
		]);

		$wpCustomize->add_control($name, [
			'label' => $args['title'],
			'section' => 'sleek_settings',
			'type' => $args['type']
		]);
	}
}

/**
 * Add some stuff to <head></head>
 */
add_action('wp_head', function () {
	if ($code = get_theme_mod('head_code')) {
		echo $code;
	}
});

/**
 * Add some just after <body>
 */
add_action('sleek_after_body_tag_open', function () {
	if ($code = get_theme_mod('body_code')) {
		echo $code;
	}
});

/**
 * Add some stuff right before </body>
 */
add_action('wp_footer', function () {
	if ($code = get_theme_mod('foot_code')) {
		echo $code;
	}

	# Google Maps
	if (get_theme_mod('google_maps_api_key')) {
		echo "<script>
			window.gmAsyncInit = function () {};

			function gmInit (cb) {
				if (window.google && window.google.maps) {
					cb(window.google);
				}
				else {
					var oldGMInit = window.gmAsyncInit;

					window.gmAsyncInit = function () {
						oldGMInit();
						cb(window.google);
					};
				}
			}
		</script>";
	}
});

/**
 * Add Google Maps if specified in theme options
 */
add_action('wp_enqueue_scripts', function () {
	if ($googleMaps = get_theme_mod('google_maps_api_key')) {
		wp_register_script('google_maps', 'https://maps.googleapis.com/maps/api/js?key=' . $googleMaps . '&callback=gmAsyncInit', [], null, true);
		wp_enqueue_script('google_maps');
	}
});

/**
 * Add Google Maps API Key to ACF
 */
add_action('init', function () {
	if ($googleMaps = get_theme_mod('google_maps_api_key')) {
		add_filter('acf/fields/google_map/api', function ($api) use ($googleMaps) {
			$api['key'] = $googleMaps;

			return $api;
		});
	}
});
