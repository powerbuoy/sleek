<?php
/**
 * Move jQuery to bottom of page + include from CDN
 */
# add_action('wp_enqueue_scripts', 'sleek_enqueue_jquery_cdn_in_footer');

function sleek_enqueue_jquery_cdn_in_footer () {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js', false, '2.2.2', true);
		wp_enqueue_script('jquery');
	}
}
