<?php
/**
 * Allows including any .md file TODO
 */
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
