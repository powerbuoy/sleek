<?php
	$module = isset($_GET['sleek_module']) ? 
				$_GET['sleek_module'] : 
				(isset($_POST['sleek_module']) ? 
					$_POST['sleek_module'] : 
					false
				);

	if (XHR and $module) {
		sleek_get_module(basename($module));
		die;
	}
	else {
		sleek_get_module('head');
		sleek_get_module('header');
	}
?>
