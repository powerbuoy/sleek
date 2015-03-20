<?php
# Allow HTML in Widget Titles (with [tags])
# add_filter('widget_title', 'sleek_html_in_widget_titles');

function sleek_html_in_widget_titles ($title)
{
	$title = str_replace('[', '<', $title);
	$title = str_replace(']', '>', $title);
	$title = strip_tags($title, '<a><blink><br><span>');

	return $title;
}

# Allow shortcodes in Widgets
# add_action('init', 'sleek_allow_shortcodes_in_widgets');

function sleek_allow_shortcodes_in_widgets () {
	add_filter('widget_text', 'do_shortcode');
}

# Include
# add_shortcode('include', 'sleek_shortcode_include_module');

function sleek_shortcode_include_module ($atts) {
	if (!isset($atts['mod'])) {
		return '<p><strong>[ include error: Have to set mod ]</strong></p>';
	}

	$suffix			= '/modules/' . basename($atts['mod']) . '.php';
	$suffix			= '/modules/' . $atts['mod'] . '.php';  # No basename() so we can do forms/foo for example
	$include_path	= get_stylesheet_directory() . $suffix;
	$include_path	= file_exists($include_path) ? $include_path : TEMPLATEPATH . $suffix;

	if (!file_exists($include_path)) {
		return '<p><strong>[ include error: Module "' . $atts['mod'] . '" does not exist ]</strong></p>';
	}

	extract($atts);

	return fetch($include_path, $atts);
}
