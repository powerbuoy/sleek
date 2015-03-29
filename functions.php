<?php
# Is AJAX call?
define('XHR', (
	isset($_SERVER['HTTP_X_REQUESTED_WITH']) and 
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
));

# Roots stuff
include get_template_directory() . '/inc/roots/utils.php';
include get_template_directory() . '/inc/roots/cleanup.php';
include get_template_directory() . '/inc/roots/nav.php';

# My stuff
include get_template_directory() . '/inc/functions.php';
include get_template_directory() . '/inc/cleanup.php';
include get_template_directory() . '/inc/lang.php';
include get_template_directory() . '/inc/post-thumbnails.php';
include get_template_directory() . '/inc/sidebars.php';
include get_template_directory() . '/inc/ajax.php';
include get_template_directory() . '/inc/post-types.php';
include get_template_directory() . '/inc/shortcodes.php';
include get_template_directory() . '/inc/include-css-js.php';
include get_template_directory() . '/inc/pagination-css-class.php';
include get_template_directory() . '/inc/advanced-search.php';
include get_template_directory() . '/inc/tinymce-styles.php';
include get_template_directory() . '/inc/get-posts-intro.php';
include get_template_directory() . '/inc/more-markdown.php';
# include get_template_directory() . '/inc/submit-form.php';
# include get_template_directory() . '/inc/relevanssi.php';
# include get_template_directory() . '/inc/get-posts/get-posts.php';
