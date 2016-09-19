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

# Helper functions
include get_template_directory() . '/inc/helpers/disable-single-post-types.php';
include get_template_directory() . '/inc/helpers/get-archive-data.php';
include get_template_directory() . '/inc/helpers/get-site-logo.php';
include get_template_directory() . '/inc/helpers/misc.php';
include get_template_directory() . '/inc/helpers/register-post-types.php';
include get_template_directory() . '/inc/helpers/register-sidebars.php';
include get_template_directory() . '/inc/helpers/register-taxonomies.php';

# Shortcodes (TODO: Move to separate plugins)
include get_template_directory() . '/inc/shortcodes/hubspot-form.php';
include get_template_directory() . '/inc/shortcodes/include.php';
include get_template_directory() . '/inc/shortcodes/markdown-file.php';

# HTML5Form (TODO: Move to plugin)
# include get_template_directory() . '/inc/html5form/html5form.php';

# Actions
include get_template_directory() . '/inc/actions/add-excerpts-to-pages.php';
include get_template_directory() . '/inc/actions/add-favicon.php';
include get_template_directory() . '/inc/actions/add-upgrade-browser-script.php';
# include get_template_directory() . '/inc/actions/ajax.php';
include get_template_directory() . '/inc/actions/allow-shortcodes-in-widgets.php';
include get_template_directory() . '/inc/actions/cleanup-head.php';
include get_template_directory() . '/inc/actions/disable-wp-embed.php';
include get_template_directory() . '/inc/actions/hide-acf-section-fields.php';
include get_template_directory() . '/inc/actions/jquery-cdn-in-foot.php';
include get_template_directory() . '/inc/actions/more-markdown.php';
include get_template_directory() . '/inc/actions/open-graph-tags.php';
include get_template_directory() . '/inc/actions/post-thumbnails.php';
include get_template_directory() . '/inc/actions/register-assets.php';
include get_template_directory() . '/inc/actions/register-theme-options.php';
include get_template_directory() . '/inc/actions/remove-emoji-css-js.php';
include get_template_directory() . '/inc/actions/setup-lang.php';
# include get_template_directory() . '/inc/actions/submit-form.php';
# include get_template_directory() . '/inc/actions/tinymce-styles.php';

# Filters
include get_template_directory() . '/inc/filters/active-archive-link-on-taxonomies.php';
include get_template_directory() . '/inc/filters/add-post-type-arg-to-get-terms.php';
# include get_template_directory() . '/inc/filters/advanced-search.php';
include get_template_directory() . '/inc/filters/comment-form-placeholders.php';
include get_template_directory() . '/inc/filters/exclude-current-post-in-upw.php';
include get_template_directory() . '/inc/filters/hide-sleek-from-admin.php';
include get_template_directory() . '/inc/filters/html-in-widget-titles.php';
include get_template_directory() . '/inc/filters/pagination-css-class.php';
# include get_template_directory() . '/inc/filters/relevanssi.php';
include get_template_directory() . '/inc/filters/remove-home-from-yoast-breadcrumbs.php';
include get_template_directory() . '/inc/filters/set-cpt-in-search.php';
include get_template_directory() . '/inc/filters/show-all-cpt-posts.php';
include get_template_directory() . '/inc/filters/show-all-post-types-for-auhors.php';
include get_template_directory() . '/inc/filters/unset-active-blog-class.php';
