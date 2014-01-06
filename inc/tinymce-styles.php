<?php
# Add the style button
add_filter('mce_buttons_2', 'h5b_add_tinymce_styleselect');

function h5b_add_tinymce_styleselect ($buttons) {
	array_unshift($buttons, 'styleselect');

	return $buttons;
}

# Add our style CSS
add_action('init', 'h5b_tinymce_css');

function h5b_tinymce_css () {
	add_editor_style('css/tinymce-styles.css');
}

# Add a small style
add_filter('tiny_mce_before_init', 'h5b_tinymce_styles');

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
			'block' => 'div',
			'classes' => 'aside',
			'wrapper' => true
		), 
		array(
			'title' => 'Note',
			'block' => 'div',
			'classes' => 'note',
			'wrapper' => true
		), 
		array(
			'title' => 'Highlight',
			'block' => 'div',
			'classes' => 'highlight',
			'wrapper' => true
		), 

		# Bars
		array(
			'title' => 'Gray Bar',
			'block' => 'div',
			'classes' => 'bar light-gray',
			'wrapper' => true
		), 
		array(
			'title' => 'Blue Bar',
			'block' => 'div',
			'classes' => 'bar blue',
			'wrapper' => true
		), 
		array(
			'title' => 'Silver Bar',
			'block' => 'div',
			'classes' => 'bar silver',
			'wrapper' => true
		), 

		# Sections
	/*	array(
			'title' => 'Dark Section',
			'block' => 'div',
			'classes' => 'section dark lines',
			'wrapper' => true
		), 
		array(
			'title' => 'Dark Pattern Section',
			'block' => 'div',
			'classes' => 'section dark pattern',
			'wrapper' => true
		), 
		array(
			'title' => 'Red Section',
			'block' => 'div',
			'classes' => 'section red pattern',
			'wrapper' => true
		), 
		array(
			'title' => 'Dark Red Section',
			'block' => 'div',
			'classes' => 'section dark-red pattern',
			'wrapper' => true
		), 
		array(
			'title' => 'Silver Section',
			'block' => 'div',
			'classes' => 'section silver',
			'wrapper' => true
		), 
		array(
			'title' => 'Gray Section',
			'block' => 'div',
			'classes' => 'section gray',
			'wrapper' => true
		), 
		array(
			'title' => 'Light Gray Section',
			'block' => 'div',
			'classes' => 'section light-gray',
			'wrapper' => true
		), 
		array(
			'title' => 'Blue Section',
			'block' => 'div',
			'classes' => 'section blue',
			'wrapper' => true
		), 
		array(
			'title' => 'White Section',
			'block' => 'div',
			'classes' => 'section white',
			'wrapper' => true
		), 

		# Columns
		array(
			'title' => 'Left',
			'block' => 'div',
			'classes' => 'left',
			'wrapper' => true
		), 
		array(
			'title' => 'Left (small)',
			'block' => 'div',
			'classes' => 'left-25',
			'wrapper' => true
		), 
		array(
			'title' => 'Left (big)',
			'block' => 'div',
			'classes' => 'left-75',
			'wrapper' => true
		), 
		array(
			'title' => 'Right',
			'block' => 'div',
			'classes' => 'right',
			'wrapper' => true
		), 
		array(
			'title' => 'Right (small)',
			'block' => 'div',
			'classes' => 'right-25',
			'wrapper' => true
		), 
		array(
			'title' => 'Right (big)',
			'block' => 'div',
			'classes' => 'right-75',
			'wrapper' => true
		) */
	);

	# Insert the array, JSON ENCODED, into 'style_formats'
	$init['style_formats'] = json_encode($styles);

	return $init;
}

# Add some buttons
add_filter('mce_buttons', 'h5b_enable_more_buttons');

function h5b_enable_more_buttons ($buttons) {
	$buttons[] = 'hr';

	# Repeat with any other buttons you want to add, e.g.
	# $buttons[] = 'fontselect';
	# $buttons[] = 'sup';

	return $buttons;
}
