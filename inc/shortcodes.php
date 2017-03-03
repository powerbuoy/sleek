<?php
/* add_shortcode('include', function ($atts) {
	if (!isset($atts['path'])) {
		return '<p><strong>[ include error: Have to set path ]</strong></p>';
	}

	$template = locate_template($atts['path'] . '.php');

	if (!$template) {
		return '<p><strong>[ Include Error: File "' . $atts['path'] . '" does not exist ]</strong></p>';
	}

	extract($atts);

	# Include without echo:ing
	ob_start();

	include $template;

	$contents = ob_get_contents();

	ob_end_clean();

	return $contents;
}); */
