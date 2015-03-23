<?php
# Is AJAX call?
define('XHR', (
	isset($_SERVER['HTTP_X_REQUESTED_WITH']) and 
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
));

# Roots stuff
include TEMPLATEPATH . '/inc/roots/utils.php';
include TEMPLATEPATH . '/inc/roots/cleanup.php';
include TEMPLATEPATH . '/inc/roots/nav.php';

# My stuff
include TEMPLATEPATH . '/inc/functions.php';
include TEMPLATEPATH . '/inc/cleanup.php';
include TEMPLATEPATH . '/inc/lang.php';
include TEMPLATEPATH . '/inc/post-thumbnails.php';
include TEMPLATEPATH . '/inc/sidebars.php';
include TEMPLATEPATH . '/inc/ajax.php';
include TEMPLATEPATH . '/inc/post-types.php';
include TEMPLATEPATH . '/inc/shortcodes.php';
include TEMPLATEPATH . '/inc/include-css-js.php';
include TEMPLATEPATH . '/inc/pagination-css-class.php';
include TEMPLATEPATH . '/inc/advanced-search.php';
include TEMPLATEPATH . '/inc/tinymce-styles.php';
include TEMPLATEPATH . '/inc/get-posts.php';
include TEMPLATEPATH . '/inc/get-posts-intro.php';
include TEMPLATEPATH . '/inc/more-markdown.php';
# include TEMPLATEPATH . '/inc/submit-form.php';
# include TEMPLATEPATH . '/inc/relevanssi.php';
