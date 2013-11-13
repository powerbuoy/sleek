<?php
# From: http://www.themelab.com/2010/07/11/remove-code-wordpress-header/
# Comment if needed
function h5b_cleanup () {
	## Really Simple Discovery
	remove_action('wp_head', 'rsd_link');

	## Windows Live Writer
	remove_action('wp_head', 'wlwmanifest_link');

	## Wordpress Generator
	remove_action('wp_head', 'wp_generator');

	## Useless link elements
	remove_action('wp_head', 'start_post_rel_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
}

add_action('init', 'h5b_cleanup');

# Allow HTML in Widget Titles (with [tags])
function h5b_html_in_widget_titles ($title)
{
	$title = str_replace('[', '<', $title);
	$title = str_replace(']', '>', $title);
	$title = strip_tags($title, '<a><blink><br><span>');

	return $title;
}

add_filter('widget_title', 'h5b_html_in_widget_titles');
