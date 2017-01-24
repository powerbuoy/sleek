<?php
	global $post;

	if ($modules = get_field('modules-' . $where)) {
		foreach ($modules as $module) {
			sleek_get_template_part('acf/' . $module['template'], ['data' => $module]);
		}
	}
?>
