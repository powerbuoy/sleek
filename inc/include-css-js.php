<?php
add_action('wp_footer', 'sleek_add_extra_js');

function sleek_add_extra_js () {
	# ReCaptcha
	if (defined('RECAPTCHA_SITE_KEY') and RECAPTCHA_SITE_KEY and defined('RECAPTCHA_SECRET') and RECAPTCHA_SECRET) {
		echo '<script src="https://www.google.com/recaptcha/api.js?onload=RenderCaptchas&amp;render=explicit" async defer></script>';
	}

	# Google Analytics
	if (defined('GOOGLE_ANALYTICS') and GOOGLE_ANALYTICS) {
		echo "<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', '" . GOOGLE_ANALYTICS . "', 'auto');
			ga('send', 'pageview');
		</script>";
	}

	# Google Tag Manager
	if (defined('GOOGLE_TAG_MANAGER') and GOOGLE_TAG_MANAGER) {
		echo "<script>
			// TODO
		</script>";
	}
}

add_action('wp_head', 'sleek_add_js_class');

function sleek_add_js_class () {
	echo "<script>document.documentElement.className = document.documentElement.className.replace('no-js', 'js');</script>";
}

add_action('wp_head', 'sleek_add_config_vars');

function sleek_add_config_vars () {
	echo '<script>';

	echo 'TEMPLATE_DIRECTORY = "' . get_template_directory_uri() . '";';
	echo 'STYLESHEET_DIRECTORY = "' . get_stylesheet_directory_uri() . '";';
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

# Disable jQuery NoConflict
# add_action('wp_head', 'sleek_disable_jquery_noconflict');

function sleek_disable_jquery_noconflict () {
	echo '<script>$ = jQuery.noConflict()</script>';
}
# Move jQuery to bottom of page
# add_action('wp_default_scripts', 'sleek_enqueue_jquery_in_footer');

/* function sleek_enqueue_jquery_in_footer (&$scripts) {
	if (!is_admin()) {
		# TODO does not work
		$scripts->add_data('jquery', 'group', 1);
		$scripts->add_data('jquery-core', 'group', 1);
		$scripts->add_data('jquery-migrate', 'group', 1);
	}
} */

# add_action('wp_enqueue_scripts', 'sleek_enqueue_jquery_cdn_in_footer');

function sleek_enqueue_jquery_cdn_in_footer () {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js', false, '2.2.2', true);
		wp_enqueue_script('jquery');
	}
}
