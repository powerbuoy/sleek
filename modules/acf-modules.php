<?php
	# This template should be called with sleek_get_template_part('modules/acf-modules', ['where' => 'module-area'])
	global $post;

	if ($modules = get_field('modules-' . $where)) {
		foreach ($modules as $module) {
			sleek_get_template_part('acf/' . $module['template'], ['data' => $module]);
		}
	}
?>
