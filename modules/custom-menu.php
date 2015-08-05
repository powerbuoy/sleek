<?php
	$menu = wp_nav_menu(array(
		'menu' => isset($menu) ? $menu : ''
	));

	if ($menu) {
		echo $menu;
	}
?>
