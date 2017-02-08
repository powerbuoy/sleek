<?php
# Roots stuff
include get_template_directory() . '/inc/roots/utils.php';
include get_template_directory() . '/inc/roots/cleanup.php';
include get_template_directory() . '/inc/roots/nav.php';

# Sleek stuff
include get_template_directory() . '/inc/utils.php';
include get_template_directory() . '/inc/active-archive-link-on-taxonomies.php';
include get_template_directory() . '/inc/add-post-type-arg-to-get-terms.php';
include get_template_directory() . '/inc/attachments-archive.php';
include get_template_directory() . '/inc/comment-form-placeholders.php';
include get_template_directory() . '/inc/unset-active-blog-class.php';
include get_template_directory() . '/inc/default-meta-boxes.php';
include get_template_directory() . '/inc/hide-sleek-from-admin.php';
include get_template_directory() . '/inc/html-in-widget-titles.php';
include get_template_directory() . '/inc/jquery-cdn-in-foot.php';
include get_template_directory() . '/inc/more-markdown.php';
include get_template_directory() . '/inc/pagination-css-class.php';
include get_template_directory() . '/inc/get-archive-data.php';
include get_template_directory() . '/inc/get-site-logo.php';
include get_template_directory() . '/inc/reduce-requests.php';
include get_template_directory() . '/inc/register-acf.php';
include get_template_directory() . '/inc/register-assets.php';
include get_template_directory() . '/inc/register-post-types.php';
include get_template_directory() . '/inc/register-sidebars.php';
include get_template_directory() . '/inc/register-taxonomies.php';
include get_template_directory() . '/inc/register-theme-options.php';

# Currently unused
# include get_template_directory() . '/inc/ajax.php';
# include get_template_directory() . '/inc/relevanssi.php';
# include get_template_directory() . '/inc/tinymce-styles.php';

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

# Allow shortcodes in Widgets
/* add_action('init', function () {
	add_filter('widget_text', 'do_shortcode');
}); */

# Move jQuery to bottom of page + include from CDN
add_action('wp_enqueue_scripts', 'sleek_enqueue_jquery_cdn_in_footer');

# Add an "active-parent" class to archive pages when browsing their taxonomies
add_filter('nav_menu_css_class', 'sleek_active_archive_link_on_taxonomies', 10, 2);

# Allow a 'post_type' => [] argument in get_terms()
add_filter('terms_clauses', 'sleek_terms_clauses', 10, 3);

# Add placeholders to comment form
add_filter('comment_form_defaults', 'sleek_comment_form_placeholders');

# Remove .current_page_parent from Blog-page when viewing another archive
add_filter('nav_menu_css_class', 'sleek_unset_active_blog_class', 10, 2);

# Allow HTML in Widget Titles (with [tags])
# add_filter('widget_title', 'sleek_html_in_widget_titles');

# Allow Markdown in excerpts and ACF
# add_action('init', 'sleek_more_markdown');

# Give editors access to theme options
/* $editorRole = get_role('editor');

if (!$editorRole->has_cap('edit_theme_options')) {
	$editorRole->add_cap('edit_theme_options');
}

if (!$editorRole->has_cap('manage_options')) {
	$editorRole->add_cap('manage_options');
} */

# Give attachments an archive and make attachment taxonomy archives work (TODO: Doesn't work properly)
/* add_action('init', function () {
	sleek_attachment_archives(__('url_attachment', 'sleek'), []); # Pass in any potential attachment taxonomies (image_category for example) as the last array to enable taxonomy archives
}); */
