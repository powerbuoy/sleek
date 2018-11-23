<?php
# Better keep these here so we don't misstype anything
define('SLEEK_SETTINGS_PAGE_URL', 'sleek-settings');
define('SLEEK_SETTINGS_NAME', 'sleek_settings');
define('SLEEK_SETTINGS_SECTION_NAME', SLEEK_SETTINGS_NAME . '_section');
define('SLEEK_SETTINGS_TITLE', __('Sleek settings', 'sleek'));

# Wtf this is seriously the most complex and annoying piece of shit code I've ever written
add_action('admin_menu', function () {
	add_options_page(SLEEK_SETTINGS_TITLE, SLEEK_SETTINGS_TITLE, 'manage_options', SLEEK_SETTINGS_PAGE_URL, function () {
		?>
		<div class="wrap">
			<h1><?php echo SLEEK_SETTINGS_TITLE ?></h1>
			<form method="post" action="options.php">
				<?php settings_fields(SLEEK_SETTINGS_NAME) ?>
				<?php do_settings_sections(SLEEK_SETTINGS_SECTION_NAME) ?>
				<button><?php _e('Save settings', 'sleek') ?></button>
			</form>
		</div>
		<?php
	});
});

add_action('admin_init', function () {
	register_setting(SLEEK_SETTINGS_NAME, SLEEK_SETTINGS_NAME, function ($input) {
		# TODO: Validate
		return $input;
	});

	add_settings_section(SLEEK_SETTINGS_SECTION_NAME, SLEEK_SETTINGS_TITLE, function () {
		# Mandatory function but we don't need it...
	}, SLEEK_SETTINGS_SECTION_NAME); # WP Docs says this should be the add_options_page slug but that doesn't work. It needs to be the same as is later passed to do_settings_section

	# Google Maps API Key
	add_settings_field(SLEEK_SETTINGS_NAME . '_google_maps_api_key', __('Google Maps API Key', 'sleek'), function () {
		$options = get_option(SLEEK_SETTINGS_NAME);

		echo '<input type="text" name="' . SLEEK_SETTINGS_NAME . '[google_maps_api_key]" value="' . $options['google_maps_api_key'] . '">';
	}, SLEEK_SETTINGS_SECTION_NAME, SLEEK_SETTINGS_SECTION_NAME);

	# Google search API Key
	add_settings_field(SLEEK_SETTINGS_NAME . '_google_search_api_key', __('Google Search API Key', 'sleek'), function () {
		$options = get_option(SLEEK_SETTINGS_NAME);

		echo '<input type="text" name="' . SLEEK_SETTINGS_NAME . '[google_search_api_key]" value="' . $options['google_search_api_key'] . '">';
	}, SLEEK_SETTINGS_SECTION_NAME, SLEEK_SETTINGS_SECTION_NAME);

	# Google search engine id
	add_settings_field(SLEEK_SETTINGS_NAME . '_google_search_engine_id', __('Google Search Engine ID', 'sleek'), function () {
		$options = get_option(SLEEK_SETTINGS_NAME);

		echo '<input type="text" name="' . SLEEK_SETTINGS_NAME . '[google_search_engine_id]" value="' . $options['google_search_engine_id'] . '">';
	}, SLEEK_SETTINGS_SECTION_NAME, SLEEK_SETTINGS_SECTION_NAME);

	# <head> code
	add_settings_field(SLEEK_SETTINGS_NAME . '_head_code', esc_html__('Code inside <head>', 'sleek'), function () {
		$options = get_option(SLEEK_SETTINGS_NAME);

		echo '<textarea name="' . SLEEK_SETTINGS_NAME . '[head_code]" rows="6" cols="40">' . $options['head_code'] . '</textarea>';
	}, SLEEK_SETTINGS_SECTION_NAME, SLEEK_SETTINGS_SECTION_NAME);

	# <body> code
	add_settings_field(SLEEK_SETTINGS_NAME . '_body_code', esc_html__('Code just after <body>', 'sleek'), function () {
		$options = get_option(SLEEK_SETTINGS_NAME);

		echo '<textarea name="' . SLEEK_SETTINGS_NAME . '[body_code]" rows="6" cols="40">' . $options['body_code'] . '</textarea>';
	}, SLEEK_SETTINGS_SECTION_NAME, SLEEK_SETTINGS_SECTION_NAME);

	# <foot> code
	add_settings_field(SLEEK_SETTINGS_NAME . '_foot_code', esc_html__('Code just before </body>', 'sleek'), function () {
		$options = get_option(SLEEK_SETTINGS_NAME);

		echo '<textarea name="' . SLEEK_SETTINGS_NAME . '[foot_code]" rows="6" cols="40">' . $options['foot_code'] . '</textarea>';
	}, SLEEK_SETTINGS_SECTION_NAME, SLEEK_SETTINGS_SECTION_NAME);
});

/**
 * Add some stuff to <head></head>
 */
add_action('wp_head', function () {
	$options = get_option(SLEEK_SETTINGS_NAME);

	if (isset($options['head_code']) and !empty($options['head_code'])) {
		echo $options['head_code'];
	}
});

/**
 * Add some just after <body>
 */
add_action('sleek_after_body_tag_open', function () {
	$options = get_option(SLEEK_SETTINGS_NAME);

	if (isset($options['body_code']) and !empty($options['body_code'])) {
		echo $options['body_code'];
	}
});

/**
 * Add some stuff right before </body>
 */
add_action('wp_footer', function () {
	$options = get_option(SLEEK_SETTINGS_NAME);

	if (isset($options['foot_code']) and !empty($options['foot_code'])) {
		echo $options['foot_code'];
	}

	# Google Maps
	if (isset($options['google_maps_api_key']) and !empty($options['google_maps_api_key'])) {
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
	$options = get_option(SLEEK_SETTINGS_NAME);

	if (isset($options['google_maps_api_key']) and !empty($options['google_maps_api_key'])) {
		wp_register_script('google_maps', 'https://maps.googleapis.com/maps/api/js?key=' . $options['google_maps_api_key'] . '&callback=gmAsyncInit', [], null, true);
		wp_enqueue_script('google_maps');
	}
});

/**
 * Add Google Maps API Key to ACF
 */
add_action('init', function () {
	$options = get_option(SLEEK_SETTINGS_NAME);

	if (isset($options['google_maps_api_key']) and !empty($options['google_maps_api_key'])) {
		add_filter('acf/fields/google_map/api', function ($api) use ($options) {
			$api['key'] = $options['google_maps_api_key'];

			return $api;
		});
	}
});
