<?php
# add_action('wp_head', 'sleek_add_favicon');

function sleek_add_favicon () {
	if (file_exists(get_stylesheet_directory() . '/favicon.ico')) {
		echo '<link rel="shortcut icon" href="' . get_stylesheet_directory_uri() . '/favicon.ico">';
	}
}
?>
