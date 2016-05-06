<?php
/**
 * Remove sleek parent theme from admin
 */
add_filter('wp_prepare_themes_for_js', 'sleek_hide_sleek_from_admin');

function sleek_hide_sleek_from_admin ($themes) {
	unset($themes['sleek']);

	return $themes;
}
