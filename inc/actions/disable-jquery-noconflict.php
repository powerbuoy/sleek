<?php
/**
 * Disable jQuery noconflict
 */
# add_action('wp_head', 'sleek_disable_jquery_noconflict');

function sleek_disable_jquery_noconflict () {
	echo '<script>$ = jQuery.noConflict()</script>';
}
