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
	$include_path	= file_exists($include_path) ? $include_path : get_template_directory() . $suffix;

	if (!file_exists($include_path)) {
		return '<p><strong>[ Include Error: Module "' . $atts['mod'] . '" does not exist ]</strong></p>';
	}

	extract($atts);

	return fetch($include_path, $atts);
}

# MarkdownFile
# add_shortcode('markdown-file', 'sleek_shortcode_markdown_file');

function sleek_shortcode_markdown_file ($atts) {
	if (!isset($atts['file'])) {
		return '<p><strong>[ Markdown-file error: Have to set file ]</strong></p>';
	}

	$include_path = WP_CONTENT_DIR . '/themes/' . $atts['file'];

	if (!file_exists($include_path)) {
		return '<p><strong>[ Markdown-file Error: File "' . $atts['file'] . '" does not exist ]</strong></p>';
	}

	$md = file_get_contents($include_path);

	if (!file_exists(WP_CONTENT_DIR . '/plugins/wp-markdown/markdown-extra.php')) {
		$md = "<p><strong>[ Markdown-file Error: Markdown() missing - please install wp-markdown plug-in (you don't even have to activate it) ]</strong></p>" . $md;
	}
	else {
		require_once WP_CONTENT_DIR . '/plugins/wp-markdown/markdown-extra.php';

		$md = Markdown($md);
	}

	return $md;
}
