<?php
add_action('after_setup_theme', 'sleek_setup_lang');

function sleek_setup_lang () {
	load_theme_textdomain('sleek', TEMPLATEPATH . '/languages');
}
