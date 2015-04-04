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
}

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
