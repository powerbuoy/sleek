<?php
# https://www.advancedcustomfields.com/resources/oembed/
function sleek_add_youtube_args ($iframe, $args = [], $atts = '') {
	# Use preg_match to find iframe src
	preg_match('/src="(.+?)"/', $iframe, $matches);

	$src = $matches[1];
	$newSrc = add_query_arg($args, $src);
	$iframe = str_replace($src, $newSrc, $iframe);

	# Add extra attributes to iframe html
	$iframe = str_replace('></iframe>', ' ' . $atts . '></iframe>', $iframe);

	return $iframe;
}

# https://stackoverflow.com/questions/1773822/get-youtube-video-id-from-html-code-with-php#answer-7308332
function sleek_get_youtube_id ($iframe) {
	preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $iframe, $matches);

	return isset($matches[2]) ? $matches[2] : false;
}
