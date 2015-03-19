<?php
# Set up for translation
# add_action('after_setup_theme', 'sleek_setup_lang');

function sleek_setup_lang () {
	load_theme_textdomain('sleek', get_stylesheet_directory() . '/languages');
}
