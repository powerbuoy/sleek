<?php
/**
 * Works just like get_template_part() but acceps arguments
 * [include path=modules/latest-posts category=news limit=3]
 */
# add_shortcode('include', 'sleek_shortcode_include_module');

function sleek_shortcode_include_module ($atts) {
	if (!isset($atts['path'])) {
		return '<p><strong>[ include error: Have to set path ]</strong></p>';
	}

	$template = locate_template($atts['path'] . '.php');

	if (!$template) {
		return '<p><strong>[ Include Error: File "' . $atts['path'] . '" does not exist ]</strong></p>';
	}

	extract($atts);

	return sleek_fetch($template, $atts);
}
