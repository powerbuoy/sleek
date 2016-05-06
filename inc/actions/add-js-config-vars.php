<?php
/**
 * Adds configuration variables so they can be used from JS
 */
add_action('wp_head', 'sleek_add_js_config_vars');

function sleek_add_js_config_vars () {
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
