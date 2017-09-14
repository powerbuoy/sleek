<?php
require_once get_template_directory() . '/inc/utils.php';
require_once get_template_directory() . '/inc/active-archive-link-on-taxonomies.php';
require_once get_template_directory() . '/inc/add-post-type-arg-to-get-terms.php';
require_once get_template_directory() . '/inc/cleanup.php';
require_once get_template_directory() . '/inc/cleanup-nav.php';
require_once get_template_directory() . '/inc/comment-form-placeholders.php';
require_once get_template_directory() . '/inc/default-meta-boxes.php';
require_once get_template_directory() . '/inc/fix-wp-gallery.php';
require_once get_template_directory() . '/inc/get-archive-data.php';
require_once get_template_directory() . '/inc/get-archive-taxonomies.php';
require_once get_template_directory() . '/inc/get-archive-image.php';
require_once get_template_directory() . '/inc/get-site-logo.php';
require_once get_template_directory() . '/inc/jquery-cdn-in-foot.php';
require_once get_template_directory() . '/inc/modify-archive-title.php';
require_once get_template_directory() . '/inc/more-api-data.php';
require_once get_template_directory() . '/inc/reduce-requests.php';
require_once get_template_directory() . '/inc/register-acf.php';
require_once get_template_directory() . '/inc/register-assets.php';
require_once get_template_directory() . '/inc/register-post-types.php';
require_once get_template_directory() . '/inc/register-sidebars.php';
require_once get_template_directory() . '/inc/register-taxonomies.php';
require_once get_template_directory() . '/inc/register-theme-options.php';
require_once get_template_directory() . '/inc/unset-active-blog-class.php';

# Give pages excerpts
add_action('init', function () {
	add_post_type_support('page', 'excerpt');
});

# Set up for translation
add_action('after_setup_theme', function () {
	load_theme_textdomain('sleek', get_template_directory() . '/languages');
});

# Eable post thumbnails
add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(300, 200, true);
});

# Remove a bunch of unwanted CSS/JS added by WP and plug-ins
add_action('init', function () {
	sleek_reduce_requests();
});

# Remove "Protected:" from protected post titles
add_filter('private_title_format', function () {
	return '%s';
});

add_filter('protected_title_format', function () {
	return '%s';
});

# Hide Sleek theme from admin
add_filter('wp_prepare_themes_for_js', function ($themes) {
	unset($themes['sleek']);

	return $themes;
});

# Title tag support
add_theme_support('title-tag');
