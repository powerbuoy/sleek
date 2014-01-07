<?php
# Give pages excerpts
# add_action('init', 'h5b_add_excerpts_to_pages');

function h5b_add_excerpts_to_pages () {
	add_post_type_support('page', 'excerpt');
}

# Add some fields to users
# add_filter('user_contactmethods', 'h5b_add_user_fields');

function h5b_add_user_fields ($fields) {
	$fields['profession'] = __('Profession', 'h5b');

	return $fields;
}

# Allow HTML in Widget Titles (with [tags])
add_filter('widget_title', 'h5b_html_in_widget_titles');

function h5b_html_in_widget_titles ($title)
{
	$title = str_replace('[', '<', $title);
	$title = str_replace(']', '>', $title);
	$title = strip_tags($title, '<a><blink><br><span>');

	return $title;
}

# Cleanup HEAD
# From: http://www.themelab.com/2010/07/11/remove-code-wordpress-header/
add_action('init', 'h5b_cleanup');

function h5b_cleanup () {
	# Comment if needed
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
