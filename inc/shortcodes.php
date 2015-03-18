<?php
# Allow shortcodes in Widgets
add_action('init', 'sleek_allow_shortcodes_in_widgets');

function sleek_allow_shortcodes_in_widgets () {
	add_filter('widget_text', 'do_shortcode');
}

# Include
add_shortcode('include', 'sleek_shortcode_include_module');

function sleek_shortcode_include_module ($atts) {
	if (!isset($atts['mod'])) {
		return '<p><strong>[include error: Have to set mod]</strong></p>';
	}

#	$include_path = TEMPLATEPATH . '/modules/' . basename($atts['mod']) . '.php';
	$include_path = TEMPLATEPATH . '/modules/' . $atts['mod'] . '.php'; # No basename() so we can do forms/foo for example

	if (!file_exists($include_path)) {
		return '<p><strong>[include error: Module "' . $atts['mod'] . '" does not exist]</strong></p>';
	}

	extract($atts);

	return fetch($include_path, $atts);
}
