<?php
function h5b_register_css_js () {
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'); # 2.0.0
#	wp_register_script('jquery_migrate', 'http://code.jquery.com/jquery-migrate-1.1.0.js', array('jquery'));
#	wp_enqueue_script('jquery_migrate');

	wp_register_script('google_maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');
	wp_enqueue_script('google_maps');

	wp_register_script('h5b_head', get_template_directory_uri() . '/js/head.php', array('jquery'), filemtime(TEMPLATEPATH . '/js/head.js'));
	wp_enqueue_script('h5b_head');

	wp_register_script('h5b_foot', get_template_directory_uri() . '/js/foot.php', array('jquery'), filemtime(TEMPLATEPATH . '/js/foot.js'), true);
	wp_enqueue_script('h5b_foot');

	wp_register_style('h5b', get_template_directory_uri() . '/css/all.css', array(), filemtime(TEMPLATEPATH . '/css/all.css'));
	wp_enqueue_style('h5b');
}

add_action('wp_enqueue_scripts', 'h5b_register_css_js');

function h5b_register_browser_update_js () {
	echo '<script>
		var $buoop = {};

		$buoop.ol = window.onload;

		window.onload = function () {
			try {
				if ($buoop.ol) $buoop.ol();
			}
			catch (e) {
			}

			var e = document.createElement("script");

			e.setAttribute("type", "text/javascript");
			e.setAttribute("src", "http://browser-update.org/update.js");
			document.body.appendChild(e);
		};
	</script>';
}

add_action('wp_head', 'h5b_register_browser_update_js');
