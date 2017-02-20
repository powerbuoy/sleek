<?php
	# This template should be called with sleek_get_template_part('modules/acf-modules', ['where' => 'module-area'])
	global $post;

	if ($modules = get_field('modules-' . $where)) {
		$i = 0;
		$templateCount = [];

		foreach ($modules as $module) {
			# Keep track of how many times this template is included
			if (isset($templateCount[$module['template']])) {
				$templateCount[$module['template']]++;
			}
			else {
				$templateCount[$module['template']] = 1;
			}

			# Include the template
			sleek_get_template_part('acf/' . $module['template'], [
				'data' => $module,
				'count' => ++$i,
				'templateCount' => $templateCount[$module['template']]
			]);
		}
	}
?>
