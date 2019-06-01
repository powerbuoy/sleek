<?php
# Better keep these here so we don't misstype anything
define('SLEEK_SETTINGS_PAGE_URL', 'sleek-settings');
define('SLEEK_SETTINGS_NAME', 'sleek_settings');
define('SLEEK_SETTINGS_SECTION_NAME', SLEEK_SETTINGS_NAME . '_section');
define('SLEEK_SETTINGS_TITLE', __('Sleek settings', 'sleek'));

function sleek_add_settings_field ($name, $label = false, $type = 'text') {
	$label = $label ?? __(ucfirst(str_replace('_', ' ', $name)), 'sleek');

	add_settings_field(SLEEK_SETTINGS_NAME . '_' . $name, $label, function () use ($name, $type) {
		$options = get_option(SLEEK_SETTINGS_NAME);

		if ($type == 'textarea') {
			echo '<textarea name="' . SLEEK_SETTINGS_NAME . '[' . $name . ']" rows="6" cols="40">' . ($options[$name] ?? '') . '</textarea>';
		}
		else {
			echo '<input type="text" name="' . SLEEK_SETTINGS_NAME . '[' . $name . ']" value="' . ($options[$name] ?? '') . '">';
		}
	}, SLEEK_SETTINGS_SECTION_NAME, SLEEK_SETTINGS_SECTION_NAME);
}

# Wtf this is seriously the most complex and annoying piece of shit code I've ever written
add_action('admin_menu', function () {
	add_options_page(SLEEK_SETTINGS_TITLE, 'Sleek', 'manage_options', SLEEK_SETTINGS_PAGE_URL, function () {
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

	add_settings_section(SLEEK_SETTINGS_SECTION_NAME, false, function () {
		# NOTE: Mandatory function but we don't need it...
	}, SLEEK_SETTINGS_SECTION_NAME); # NOTE: WP Docs says this should be the add_options_page slug but that doesn't work. It needs to be the same as is later passed to do_settings_section

	# Built-in fields
	sleek_add_settings_field('google_maps_api_key', __('Google Maps API Key', 'sleek'), 'text');
	sleek_add_settings_field('google_search_api_key', __('Google Search API Key', 'sleek'), 'text');
	sleek_add_settings_field('google_search_engine_id', __('Google Search Engine ID', 'sleek'), 'text');
	sleek_add_settings_field('head_code', esc_html__('Code inside <head>', 'sleek'), 'textarea');
	sleek_add_settings_field('body_code', esc_html__('Code just after <body>', 'sleek'), 'textarea');
	sleek_add_settings_field('foot_code', esc_html__('Code just before </body>', 'sleek'), 'textarea');
	sleek_add_settings_field('cookie_consent', esc_html__('Cookie consent text', 'sleek'), 'textarea');
	sleek_add_settings_field('site_notice', esc_html__('Site notice', 'sleek'), 'textarea');
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

/**
 * Add Cookie Consent text
 */
add_action('wp_enqueue_scripts', function () {
	$options = get_option(SLEEK_SETTINGS_NAME);

	if (isset($options['cookie_consent']) and !empty($options['cookie_consent'])) {
		$cookieConsent = $options['cookie_consent'];
	}
	else {
		$cookieUrl = get_option('wp_page_for_privacy_policy') ? get_permalink(get_option('wp_page_for_privacy_policy')) : 'https://cookiesandyou.com/';
		$cookieConsent = sprintf(__('We use cookies to bring you the best possible experience when browsing our site. <a href="%s" target="_blank">Read more</a> | <a href="#" class="close">Accept</a>', 'sleek'), $cookieUrl);
	}

	wp_localize_script('sleek', 'SLEEK_COOKIE_CONSENT', $cookieConsent);
});
