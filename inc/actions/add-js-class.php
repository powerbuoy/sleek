<?php
/**
 * Adds a "no-js" or "js" class to <html> depending on user's support
 */
add_action('wp_head', 'sleek_add_js_class');

function sleek_add_js_class () {
	echo "<script>document.documentElement.className = document.documentElement.className.replace('no-js', 'js');</script>";
}
