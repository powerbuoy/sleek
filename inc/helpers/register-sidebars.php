<?php
/**
 * Register sidebars
 *
 * Takes $sidebars as 'slug' => 'Name of sidebar' or optional config array.
 */
function sleek_register_sidebars ($sidebars) {
	foreach ($sidebars as $id => $name) {
		$config = [
			'id' => $id,
			'description' => '',
			'before_widget' => '<div id="widget-%1$s" class="%2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>'
		];

		# If $name isn't string, consider it config
		if (is_array($name)) {
			$config = array_merge($config, $name);
		}
		else {
			$config['name'] = $name;
		}

		register_sidebar($config);
	}
}
