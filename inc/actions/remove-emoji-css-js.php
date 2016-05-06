<?php
/**
 * Remove Emoji CSS/JS from head added since WP 4.2.2
 *
 * TODO: Doesn't work??
 */
# add_action('init', 'sleek_remove_emoji_css_js');

function sleek_remove_emoji_css_js () {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
}
