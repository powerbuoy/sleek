<?php
/**
 * Registers CSS and JS
 */
function sleek_register_assets ($extraAssets = []) {
	add_action('wp_enqueue_scripts', function () use ($extraAssets) {
		# Theme JS
		wp_register_script('sleek', get_stylesheet_directory_uri() . '/dist/all.js?v=' . filemtime(get_stylesheet_directory() . '/dist/all.js'), ['jquery'], null, true);
		wp_enqueue_script('sleek');

		# Some useful vars in config
		$jsConfig = [
			'TEMPLATE_DIRECTORY' => get_template_directory_uri(),
			'STYLESHEET_DIRECTORY' => get_stylesheet_directory_uri(),
			'AJAX_URL' => admin_url('admin-ajax.php')
		];

		if (get_theme_mod('recaptcha_site_key')) {
			$jsConfig['RECAPTCHA_SITE_KEY'] = get_theme_mod('recaptcha_site_key');
		}

		wp_localize_script('sleek', 'config', $jsConfig);

		# Theme CSS
		wp_register_style('sleek', get_stylesheet_directory_uri() . '/dist/all.css?v=' . filemtime(get_stylesheet_directory() . '/dist/all.css'), [], null);
		wp_enqueue_style('sleek');

		# Potential additional styles
		$id = 0;

		foreach ($extraAssets as $path => $dependencies) {
			$id++;

			if (!is_array($dependencies)) {
				$path = $dependencies;
				$dependencies = [];
			}

			$ext = pathinfo($path, PATHINFO_EXTENSION);

			if ($ext == 'js') {
				wp_register_script('sleek_extra_js_' . $id, $path, $dependencies, null, true);
				wp_enqueue_script('sleek_extra_js_' . $id);
			}
			else {
				wp_register_style('sleek_extra_css_' . $id, $path);
				wp_enqueue_style('sleek_extra_css_' . $id);
			}
		}

		# Remove duplicate post CSS
		if (!is_user_logged_in()) {
			wp_dequeue_style('duplicate-post');
		}

		# Add google maps?
		$googleMaps = get_theme_mod('google_maps_api_key');

		if ($googleMaps) {
			wp_register_script('google_maps', 'https://maps.googleapis.com/maps/api/js?key=' . $googleMaps . '&callback=gmAsyncInit', [], null, true);
			wp_enqueue_script('google_maps');
		}

		# Recaptcha?
		$recaptchaSiteKey = get_theme_mod('recaptcha_site_key');
		$recaptchaSecret = get_theme_mod('recaptcha_secret');

		if ($recaptchaSiteKey and $recaptchaSecret) {
			wp_register_script('recaptcha', 'https://www.google.com/recaptcha/api.js', [], null, true);
			wp_enqueue_script('recaptcha');
		}
	});
}

/**
 * Add Google Analytics etc based on theme options
 */
add_action('wp_footer', function () {
	# Google Maps
	if ($googleMaps = get_theme_mod('google_maps_api_key')) {
		echo "<script>
			// Make sure this exists when GM loads
			window.gmAsyncInit = function () {};

			// Helper function to add to GM Init
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
});

/**
 * Add a "no-js" or "js" class to <html>
 */
add_action('wp_head', function () {
	echo "<script>document.documentElement.className = document.documentElement.className.replace('no-js', 'js');</script>";
});

/**
 * Add Google Maps API Key to ACF
 */
add_action('init', function () {
	$googleMaps = get_theme_mod('google_maps_api_key');

	if ($googleMaps) {
		add_filter('acf/fields/google_map/api', function ($api) use ($googleMaps) {
			$api['key'] = $googleMaps;

			return $api;
		});
	}
});
