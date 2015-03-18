<?php
add_action('init', 'h5b_register_sidebars');

function h5b_register_sidebars () {
	$sidebars = array(
		'aside'		=> __('Aside', 'h5b'), 
		'header'	=> __('Header', 'h5b'), 
		'footer'	=> __('Footer', 'h5b')
	);

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
