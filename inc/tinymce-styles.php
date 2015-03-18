<?php
# Add the style button
# add_filter('mce_buttons_2', 'h5b_add_tinymce_styleselect');

function h5b_add_tinymce_styleselect ($buttons) {
	array_unshift($buttons, 'styleselect');

	return $buttons;
}

# Add our style CSS
# add_action('init', 'h5b_tinymce_css');

function h5b_tinymce_css () {
	add_editor_style('css/tinymce-styles.css');
}

# Add a small style
# add_filter('tiny_mce_before_init', 'h5b_tinymce_styles');

function h5b_tinymce_styles ($init) {
	$styles = array(
		# General
		array(
			'title' => 'Small',
			'inline' => 'small',
			'wrapper' => false
		), 
		array(
			'title' => 'Aside',
			'block' => 'aside',
			'wrapper' => true
		)
	);

	# Insert the array, JSON ENCODED, into 'style_formats'
	$init['style_formats'] = json_encode($styles);

	return $init;
}

# Add some buttons
# add_filter('mce_buttons', 'h5b_enable_more_buttons');

function h5b_enable_more_buttons ($buttons) {
	$buttons[] = 'hr';

	# Repeat with any other buttons you want to add, e.g.
	# $buttons[] = 'fontselect';
	# $buttons[] = 'sup';

	return $buttons;
}
