<?php
# Sidebars
# add_action('init', 'sleek_register_sidebars');

function sleek_register_sidebars ($sidebars) {
	foreach ($sidebars as $id => $name) {
		$config = array(
			'id'			=> $id,
			'description'	=> '',
			'before_widget'	=> '<div id="widget-%1$s" class="%2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h2>',
			'after_title'	=> '</h2>'
		);

		if (is_array($name)) {
			$config = array_merge($config, $name);
		}
		else {
			$config['name'] = $name;
		}

		register_sidebar($config);
	}
}
