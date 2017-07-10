<?php
/**
 * Allow HTML in Widget Titles (with [tags])
 */
# add_filter('widget_title', 'sleek_html_in_widget_titles');

function sleek_html_in_widget_titles ($title) {
	$title = str_replace('[', '<', $title);
	$title = str_replace(']', '>', $title);
	$title = strip_tags($title, '<a><blink><br><span>');

	return $title;
}
