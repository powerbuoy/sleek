<?php
function h5b_init_sessions () {
	if (!session_id()) {
		session_start();
	}
}

# add_action('init', 'h5b_init_sessions');

define('XHR', (
	isset($_SERVER['HTTP_X_REQUESTED_WITH']) and 
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
));

include TEMPLATEPATH . '/inc/cleanup.php';
include TEMPLATEPATH . '/inc/lang.php';
include TEMPLATEPATH . '/inc/post-thumbnails.php';
include TEMPLATEPATH . '/inc/sidebars.php';
include TEMPLATEPATH . '/inc/functions.php';
include TEMPLATEPATH . '/inc/ajax.php';
include TEMPLATEPATH . '/inc/data-objects.php';
include TEMPLATEPATH . '/inc/include-css-js.php';
