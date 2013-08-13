<?php
add_shortcode('cut', 'h5b_shortcode_cut');

function h5b_shortcode_cut () {
	return '<div class="cut"><a href="#" class="more">' . __('Read more', 'h5b') . '</a></div>';
}

add_shortcode('include', 'h5b_shortcode_include_moule');

function h5b_shortcode_include_moule ($atts) {
	if (!isset($atts['mod'])) {
		return 'Have to set mod';
	}

	$module = $atts['mod'];
	$output = '';

	switch ($module) {
		# Featured items
		case 'featured-items' : 
			if (isset($atts['items'])) {
				$items = simple_fields_values($atts['items']);
			}
			else {
				$items = false;
			}

			$output = fetch(TEMPLATEPATH . '/modules/' . basename($module) . '.php', array(
				'items' => $items
			));

			break;

		# Accommodations
		case 'accommodations' : 
			if (isset($atts['items'])) {
				$items = simple_fields_values('accommodations_' . $atts['items']);
			}
			else {
				$items = simple_fields_values('accommodations');
			}

			$output = fetch(TEMPLATEPATH . '/modules/' . basename($module) . '.php', array(
				'items' => $items
			));

			break;

		# Default
		default : 
			$output = fetch(TEMPLATEPATH . '/modules/' . basename($module) . '.php');

			break;
	}

	return $output;
}
