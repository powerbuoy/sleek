<?php
/**
 * Move jQuery to bottom of page + include from CDN
 */
# add_action('wp_enqueue_scripts', 'sleek_enqueue_jquery_cdn_in_footer');

function sleek_enqueue_jquery_cdn_in_footer () {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', '//code.jquery.com/jquery-3.1.1.min.js', false, '3.1.1', true);
		wp_enqueue_script('jquery');
	}
}
