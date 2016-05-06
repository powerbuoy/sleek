<?php
# Set up for translation
add_action('after_setup_theme', 'sleek_setup_lang');

function sleek_setup_lang () {
	global $l10n;

	if (!load_theme_textdomain('sleek', get_template_directory() . '/lang')) {
	#	var_dump($l10n);
	#	die(get_template_directory() . '/lang');
	}
}
