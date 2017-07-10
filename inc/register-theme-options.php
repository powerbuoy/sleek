<?php
/**
 * Register some options built into sleek (see register-assets for how these settings are used)
 */
 add_action('customize_register', function ($wpCustomize) {
 	$wpCustomize->add_section('sleek_settings', [
 		'title' => __('Theme Settings', 'sleek'),
 		'description' => __('Various settings for your theme.', 'sleek')
 	]);

	sleek_register_theme_options($wpCustomize, [
		'google_analytics_id' => 'text',
		'google_tag_manager_id' => 'text',
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
