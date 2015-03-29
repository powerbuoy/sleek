<?php
# Admin CSS/JS
# add_action('admin_enqueue_scripts', 'sleek_register_css_js_admin');

function sleek_register_css_js_admin () {
	# Admin JS
	wp_register_script('sleek_admin', get_template_directory_uri() . '/js/admin.js', array('jquery'), filemtime(get_template_directory() . '/js/admin.js'));
	wp_enqueue_script('sleek_admin');

	# Admin CSS
	wp_register_style('sleek_admin', get_template_directory_uri() . '/css/admin.css', array(), filemtime(get_template_directory() . '/css/admin.css'));
	wp_enqueue_style('sleek_admin');
}

add_action('wp_head', 'sleek_add_js_class');

function sleek_add_js_class () {
	echo "<script>document.documentElement.className = document.documentElement.className.replace('no-js', 'js');</script>";
}

add_action('wp_head', 'sleek_add_config_vars');

function sleek_add_config_vars () {
	echo '<script>';

	echo 'AJAX_URL = "' . admin_url('admin-ajax.php') . '";';

	if (defined('RECAPTCHA_SITE_KEY')) {
		echo 'RECAPTCHA_SITE_KEY = "' . RECAPTCHA_SITE_KEY . '";';
	}

#	if (defined('RECAPTCHA_SECRET')) {
#		echo 'RECAPTCHA_SECRET = "' . RECAPTCHA_SECRET . '"';
#	}

	echo '</script>';
}

# Upgrade Browser Script
# add_action('wp_head', 'sleek_register_browser_update_js');

function sleek_register_browser_update_js () {
	echo str_replace(array("\n", "\t"), '', '<script>
		var $buoop = {};

		$buoop.ol = window.onload;

		window.onload = function () {
			try {
				if ($buoop.ol) $buoop.ol();
			}
			catch (e) {
			}

			var e = document.createElement("script");

			e.setAttribute("type", "text/javascript");
			e.setAttribute("src", "http://browser-update.org/update.js");
			document.body.appendChild(e);
		};
	</script>');
}
