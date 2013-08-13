<?php
add_action('after_setup_theme', 'h5b_setup_lang');

function h5b_setup_lang () {
	load_theme_textdomain('h5b', TEMPLATEPATH . '/languages');
}
