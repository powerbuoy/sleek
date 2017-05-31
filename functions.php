<?php
# Roots stuff
require_once get_template_directory() . '/inc/roots/utils.php';
require_once get_template_directory() . '/inc/roots/cleanup.php';
require_once get_template_directory() . '/inc/roots/nav.php';

# Sleek stuff
require_once get_template_directory() . '/inc/utils.php';
require_once get_template_directory() . '/inc/active-archive-link-on-taxonomies.php';
require_once get_template_directory() . '/inc/add-post-type-arg-to-get-terms.php';
require_once get_template_directory() . '/inc/attachments-archive.php';
require_once get_template_directory() . '/inc/comment-form-placeholders.php';
require_once get_template_directory() . '/inc/unset-active-blog-class.php';
require_once get_template_directory() . '/inc/default-meta-boxes.php';
require_once get_template_directory() . '/inc/fix-wp-gallery.php';
require_once get_template_directory() . '/inc/hide-sleek-from-admin.php';
require_once get_template_directory() . '/inc/html-in-widget-titles.php';
require_once get_template_directory() . '/inc/insert-figure-element.php';
require_once get_template_directory() . '/inc/jquery-cdn-in-foot.php';
require_once get_template_directory() . '/inc/more-markdown.php';
require_once get_template_directory() . '/inc/pagination-css-class.php';
require_once get_template_directory() . '/inc/get-archive-data.php';
require_once get_template_directory() . '/inc/get-site-logo.php';
require_once get_template_directory() . '/inc/get-page-type.php';
require_once get_template_directory() . '/inc/get-post-terms.php';
require_once get_template_directory() . '/inc/reduce-requests.php';
require_once get_template_directory() . '/inc/render-acf-modules.php';
require_once get_template_directory() . '/inc/register-acf.php';
require_once get_template_directory() . '/inc/register-assets.php';
require_once get_template_directory() . '/inc/register-post-types.php';
require_once get_template_directory() . '/inc/register-sidebars.php';
require_once get_template_directory() . '/inc/register-taxonomies.php';
require_once get_template_directory() . '/inc/register-theme-options.php';

# Currently unused
# require_once get_template_directory() . '/inc/ajax.php';
# require_once get_template_directory() . '/inc/relevanssi.php';
# require_once get_template_directory() . '/inc/tinymce-styles.php';

# Set up for translation
add_action('after_setup_theme', function () {
	load_theme_textdomain('sleek', get_template_directory() . '/languages');
});

# Eable post thumbnails
add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(320, 320, true);
});

# Remove a bunch of unwanted CSS/JS added by WP and plug-ins
add_action('init', function () {
	sleek_reduce_requests();
});

# Move jQuery to bottom of page + include from CDN
add_action('wp_enqueue_scripts', 'sleek_enqueue_jquery_cdn_in_footer');

# Add an "active-parent" class to archive pages when browsing their taxonomies
add_filter('nav_menu_css_class', 'sleek_active_archive_link_on_taxonomies', 10, 2);

# Add placeholders to comment form
add_filter('comment_form_defaults', 'sleek_comment_form_placeholders');

# Remove .current_page_parent from Blog-page when viewing another archive
add_filter('nav_menu_css_class', 'sleek_unset_active_blog_class', 10, 2);

# Give attachments an archive and make attachment taxonomy archives work (TODO: Doesn't work properly)
/* add_action('init', function () {
	sleek_attachment_archives(__('url_attachment', 'sleek'), []); # Pass in any potential attachment taxonomies (image_category for example) as the last array to enable taxonomy archives
}); */

# Remove "Protected:" from protected post titles
add_filter('private_title_format', function () {
	return '%s';
});

add_filter('protected_title_format', function () {
	return '%s';
});
