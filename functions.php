<?php
###################
# Composer Autoload
require __DIR__ . '/vendor/autoload.php';

######################################
# Modify WP's built in thumbnail sizes
add_action('after_setup_theme', function () {
	Sleek\ImageSizes\register(1920, 1080, ['center', 'center']/*, [
		'portrait' => ['width' => 1080, 'height' => 1920, 'crop' => ['center', 'top']],
		'square' => ['width' => 1920, 'height' => 1920],
	]*/);
});

########################
# Set up for translation
add_action('after_setup_theme', function () {
	load_theme_textdomain('sleek', get_template_directory() . '/languages');
});

################
# 404 some pages
add_filter('sleek_404s', function () {
	return is_attachment();
});

################
# My custom code
# TODO
