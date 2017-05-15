<?php
/**
 * Renders ACF flexible content modules in the $where container
 */
function sleek_render_acf_modules ($where) {
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
			if (locate_template('acf/' . $module['template'] . '.php')) {
				sleek_get_template_part('acf/' . $module['template'], [
					'data' => $module,
					'count' => ++$i,
					'template_count' => $templateCount[$module['template']]
				]);
			}
			# Or dump data if template doesn't exist
			else {
				echo '<section>';
				echo '<h2>No template defined</h2>';
				echo '<p><small>' . $module['acf_fc_layout'] . '</small></p>';
				echo '<pre>';
				var_dump($module);
				echo '</pre>';
				echo '</section>';
			}
		}
	}
}
