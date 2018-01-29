<?php
require_once get_template_directory() . '/inc/utils.php';
require_once get_template_directory() . '/inc/acf.php';
require_once get_template_directory() . '/inc/add-editor-styles.php';
require_once get_template_directory() . '/inc/archive-filter.php';
require_once get_template_directory() . '/inc/archive-meta-data.php';
require_once get_template_directory() . '/inc/cleanup-nav.php';
require_once get_template_directory() . '/inc/cleanup.php';
require_once get_template_directory() . '/inc/comment-form-placeholders.php';
require_once get_template_directory() . '/inc/default-meta-boxes.php';
require_once get_template_directory() . '/inc/fix-active-menu-items.php';
require_once get_template_directory() . '/inc/fix-wp-gallery.php';
require_once get_template_directory() . '/inc/get-site-logo.php';
require_once get_template_directory() . '/inc/get-terms-post-type-arg.php';
require_once get_template_directory() . '/inc/login.php';
require_once get_template_directory() . '/inc/reduce-requests.php';
require_once get_template_directory() . '/inc/register-assets.php';
require_once get_template_directory() . '/inc/register-image-sizes.php';
require_once get_template_directory() . '/inc/register-post-types.php';
require_once get_template_directory() . '/inc/register-sidebars.php';
require_once get_template_directory() . '/inc/register-taxonomies.php';
require_once get_template_directory() . '/inc/register-theme-options.php';
require_once get_template_directory() . '/inc/youtube-args.php';

# Title tag support
add_theme_support('title-tag');

# Give pages excerpts
add_action('init', function () {
	add_post_type_support('page', 'excerpt');
});

# Show the editor on the blog page
# https://wordpress.stackexchange.com/questions/193755/show-default-editor-on-blog-page-administration-panel
add_action('edit_form_after_title', function ($post) {
	if (isset($post) and $post->ID == get_option('page_for_posts')) {
		remove_action('edit_form_after_title', '_wp_posts_page_notice');
		add_post_type_support('page', 'editor');
	}
}, 0);

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

# Set up for translation
add_action('after_setup_theme', function () {
	load_theme_textdomain('sleek', get_template_directory() . '/languages');
});

# 404 archive pages
add_filter('template_redirect', function () {
	global $wp_query;

	if (is_attachment()) {
		status_header(404); # Sets 404 header
		$wp_query->set_404(); # Shows 404 template
	}
});
