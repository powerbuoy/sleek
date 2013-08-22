<?php
# add_action('init', 'h5b_register_sidebars');

function h5b_register_sidebars () {
	$sidebars = array(
		'header'	=> __('Header', 'h5b'), 
		'footer'	=> __('Footer', 'h5b'), 
		'secondary'	=> __('Secondary', 'h5b')
	);

	foreach ($sidebars as $id => $name) {
		register_sidebar(array(
			'name'			=> $name, 
			'id'			=> $id, 
			'description'	=> '', 
			'before_widget'	=> '<div id="wp-widget-%1$s" class="widget wp-%2$s">', 
			'after_widget'	=> '</div>', 
			'before_title'	=> '<h2>', 
			'after_title'	=> '</h2>'
		));
	}
}
