<?php
/**
 * Hide some "ACF Section" related custom fields
 */
add_action('acf/load_field', 'sleek_hide_acf_section_fields', 10, 1);

function sleek_hide_acf_section_fields ($field) {
	$hide = array('section_name', 'section_modifiers', 'modifiers');

	global $current_user;

	if ((isset($field['_name']) and in_array($field['_name'], $hide)) and (is_admin() && is_user_logged_in() && !in_array('administrator', $current_user->roles))) {
		$field['disabled'] = true;
	}

	return $field;
}

add_action('admin_head', 'sleek_hide_acf_section_fields_css');

function sleek_hide_acf_section_fields_css () {
	$hide = array('section_name', 'section_modifiers', 'modifiers');

	global $current_user;

	if (is_admin() && is_user_logged_in() && !in_array('administrator', $current_user->roles)) {
		echo '<style>';

		foreach ($hide as $h) {
			echo 'div.acf-fc-popup a[data-layout="' . $h . '"]{display: none}';
		}

		echo '</style>';
	}
}
