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
		'google_gtag_id' => 'text',
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
 * Add some stuff to <head></head>
 */
add_action('wp_head', function () {
	# Gtag
	if ($gtag = get_theme_mod('google_gtag_id')) {
		echo "<script async src=\"https://www.googletagmanager.com/gtag/js?id=$gtag\"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '$gtag');
		</script>";
	}

	# Google Analytics
	if ($googleAnalytics = get_theme_mod('google_analytics_id')) {
		echo "<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			ga('create', '$googleAnalytics', 'auto');
			ga('send', 'pageview');
		</script>";
	}

	# Google Tag Manager
	if ($gtmId = get_theme_mod('google_tag_manager_id')) {
		echo "<script>
			(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','$gtmId');
		</script>";
	}
});

/**
 * Add some stuff before <body>
 */
add_action('sleek_after_body_tag_open', function () {
	# Google Tag Manager again
	if ($gtmId = get_theme_mod('google_tag_manager_id')) {
		echo '<noscript>
			<iframe src="https://www.googletagmanager.com/ns.html?id='. $gtmId .'" height="0" width="0" style="display:none;visibility:hidden"></iframe>
		</noscript>';
	}
});

/**
 * Add some stuff before </body>
 */
add_action('wp_footer', function () {
	# Google Maps
	if ($googleMaps = get_theme_mod('google_maps_api_key')) {
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
