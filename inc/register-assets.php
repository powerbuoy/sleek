<?php
/**
 * Registers all.css and all.js along with some config variables, potential extra assets etc
 * NOTE: Call this function from the wp_enqueue_scripts action (or login_enqueue_scripts or whatever)
 */
function sleek_register_assets ($extraAssets = []) {
	# Child theme is using a critical.scss - only include that to begin with
	$hasCriticalCss = file_exists(get_stylesheet_directory() . '/dist/critical.css');

	# Potential additional assets
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
		# Only add CSS if there's no critical CSS (if there is critical CSS it's already been added above)
		elseif (!$hasCriticalCss) {
			wp_register_style('sleek_extra_css_' . $id, $path);
			wp_enqueue_style('sleek_extra_css_' . $id);
		}
	}

	# Theme JS (all.js)
	if (file_exists(get_stylesheet_directory() . '/dist/all.js')) {
		wp_register_script('sleek', get_stylesheet_directory_uri() . '/dist/all.js?v=' . filemtime(get_stylesheet_directory() . '/dist/all.js'), ['jquery'], null, true);
		wp_enqueue_script('sleek');
	}

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

	wp_localize_script('sleek', 'SLEEK_CONFIG', $jsConfig);

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
	elseif (file_exists(get_stylesheet_directory() . '/dist/all.css')) {
		wp_register_style('sleek', get_stylesheet_directory_uri() . '/dist/all.css?v=' . filemtime(get_stylesheet_directory() . '/dist/all.css'), [], null);
		wp_enqueue_style('sleek');
	}
}
