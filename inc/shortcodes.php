<?php
# Allow shortcodes in Widgets
add_action('init', 'h5b_allow_shortcodes_in_widgets');

function h5b_allow_shortcodes_in_widgets () {
	add_filter('widget_text', 'do_shortcode');
}

# Include
add_shortcode('include', 'h5b_shortcode_include_module');

function h5b_shortcode_include_module ($atts) {
	if (!isset($atts['mod'])) {
		return 'Have to set mod';
	}

	extract($atts);

	$output = fetch(TEMPLATEPATH . '/modules/' . basename($atts['mod']) . '.php', $atts);

	return $output;
}
