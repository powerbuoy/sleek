<?php
# Sidebars
# add_action('init', 'sleek_register_sidebars');

function sleek_register_sidebars ($sidebars) {
	foreach ($sidebars as $id => $name) {
		register_sidebar(array(
			'name'			=> $name, 
			'id'			=> $id, 
			'description'	=> '', 
			'before_widget'	=> '<div id="widget-%1$s" class="%2$s">', 
			'after_widget'	=> '</div>', 
			'before_title'	=> '<h2>', 
			'after_title'	=> '</h2>'
		));
	}
}
