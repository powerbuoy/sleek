<?php
# https://wordpress.stackexchange.com/questions/28095/how-can-i-tell-if-im-on-a-login-page
function sleek_is_login_page () {
	return $GLOBALS['pagenow'] == 'wp-login.php';
}

add_action('init', function () {
	# Prevent subscribers from viewing admin (https://wordpress.stackexchange.com/questions/23007/how-do-i-remove-dashboard-access-from-specific-user-roles)
	if (is_admin() and current_user_can('subscriber') and !defined('DOING_AJAX')) {
		wp_redirect(home_url());
	}

	# Hide admin bar from subscribers
	if (current_user_can('subscriber')) {
		add_filter('show_admin_bar', '__return_false');
	}
});

# Redirect subscribers to home page after login (https://codex.wordpress.org/Plugin_API/Filter_Reference/login_redirect)
add_filter('login_redirect', function ($to, $request, $user) {
	if (isset($user->roles) and is_array($user->roles) and in_array('subscriber', $user->roles)) {
		return home_url();
	}

	return $to;
}, 10, 3);

# Include theme CSS/JS on login page
# NOTE: Don't do this on the recover password page because it has very special CSS/JS
if (!(isset($_GET['action']) and $_GET['action'] === 'rp')) {
	# Link logo to home page
	add_filter('login_headerurl', function () {
		return home_url();
	});

	# Change "Powered by WordPress" to site name
	add_filter('login_headertext', function () {
		return get_bloginfo('name');
	});

	# Remove default login style (https://wordpress.stackexchange.com/questions/113501/avoid-to-load-default-wp-styles-in-login-screen)
	add_action('login_init', function() {
		wp_deregister_style('login');
	});

	# Add our styles
	add_action('login_enqueue_scripts', function () {
		sleek_register_assets();
	});
}
