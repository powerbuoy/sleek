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
		if (get_theme_mod('google_maps_api_key')) {
			$jsConfig['GOOGLE_MAPS_API_KEY'] = get_theme_mod('google_maps_api_key');
		}

		wp_localize_script('sleek', 'config', $jsConfig);

		# Child theme is using a critical.scss - only include that to begin with
		$hasCriticalCss = file_exists(get_stylesheet_directory() . '/dist/critical.css');

		if ($hasCriticalCss) {
			# Inline the critical CSS in the head section
			add_action('wp_head', function () {
				$critical = file_get_contents(get_stylesheet_directory() . '/dist/critical.css');
				$critical = str_replace(['icons/', 'assets/'], [get_stylesheet_directory_uri() . '/dist/icons/', get_stylesheet_directory_uri() . '/dist/assets/'], $critical);

				echo '<style>' . $critical . '</style>';
			});

			# Load the rest of the CSS with JS
			add_action('wp_footer', function () use ($extraAssets) {
				?>
				<noscript id="deferred-styles">
					<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri() . '/dist/all.css?v=' . filemtime(get_stylesheet_directory() . '/dist/all.css') ?>">

					<?php foreach ($extraAssets as $path) : if (pathinfo($path, PATHINFO_EXTENSION) != 'js') : ?>
						<link rel="stylesheet" type="text/css" href="<?php echo $path ?>">
					<?php endif; endforeach ?>
				</noscript>
				<script>
					// https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery
					var loadDeferredStyles = function () {
						var addStylesNode = document.getElementById("deferred-styles");
						var replacement = document.createElement("div");
							replacement.innerHTML = addStylesNode.textContent;

						document.body.appendChild(replacement)
						addStylesNode.parentElement.removeChild(addStylesNode);
					};

					var raf = requestAnimationFrame || mozRequestAnimationFrame || webkitRequestAnimationFrame || msRequestAnimationFrame;

					if (raf) {
						raf(function () {
							window.setTimeout(loadDeferredStyles, 0);
						});
					}
					else {
						window.addEventListener('load', loadDeferredStyles);
					}
				</script>
				<?php
			});
		}
		# Only an all.css exists - just include it normally
		else {
			wp_register_style('sleek', get_stylesheet_directory_uri() . '/dist/all.css?v=' . filemtime(get_stylesheet_directory() . '/dist/all.css'), [], null);
			wp_enqueue_style('sleek');
		}

		# Potential additional styles
		$id = 0;

		foreach ($extraAssets as $path => $dependencies) {
			$id++;

			# Dependencies can be passed in like ['my-file.js' => ['jquery']]
			if (!is_array($dependencies)) {
				$path = $dependencies;
				$dependencies = [];
			}

			# Figure out the extension (css/js)
			$ext = pathinfo($path, PATHINFO_EXTENSION);

			# JS
			if ($ext == 'js') {
				wp_register_script('sleek_extra_js_' . $id, $path, $dependencies, null, true);
				wp_enqueue_script('sleek_extra_js_' . $id);
			}
			# Only add CSS if there's no critical CSS
			elseif (!$hasCriticalCss) {
				wp_register_style('sleek_extra_css_' . $id, $path);
				wp_enqueue_style('sleek_extra_css_' . $id);
			}
		}

		# Add google maps?
		if ($googleMaps = get_theme_mod('google_maps_api_key')) {
			wp_register_script('google_maps', 'https://maps.googleapis.com/maps/api/js?key=' . $googleMaps . '&callback=gmAsyncInit', [], null, true);
			wp_enqueue_script('google_maps');
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
	if ($googleMaps = get_theme_mod('google_maps_api_key')) {
		add_filter('acf/fields/google_map/api', function ($api) use ($googleMaps) {
			$api['key'] = $googleMaps;

			return $api;
		});
	}
});
