<?php
# Set up for translation
add_action('after_setup_theme', function () {
	load_theme_textdomain('sleek', get_template_directory() . '/languages');
});
