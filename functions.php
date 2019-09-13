<?php
###################
# Composer Autoload
require __DIR__ . '/vendor/autoload.php';

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
