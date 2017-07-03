<?php
/**
 * Renders ACF flexible content modules in the $where container
 */
function sleek_render_acf_modules ($where, $postId = null) {
	global $post;

	if ($modules = get_field('modules-' . $where, $postId)) {
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

add_shortcode('render_module', function ($args) {
	$template = isset($args['template']) ? $args['template'] : 'default';

	if (isset($args['module']) and ($path = locate_template('acf/' . $args['module'] . '/' . $template . '.php'))) {
		return sleek_fetch($path, [
			'data' => $args
		]);
	}

	return '[Unable to locate module]';
});
