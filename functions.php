<?php
# Roots stuff
include get_template_directory() . '/inc/roots/utils.php';
include get_template_directory() . '/inc/roots/cleanup.php';
include get_template_directory() . '/inc/roots/nav.php';

# Helper functions
include get_template_directory() . '/inc/helpers/disable-single-post-types.php';
include get_template_directory() . '/inc/helpers/get-archive-data.php';
include get_template_directory() . '/inc/helpers/get-site-logo.php';
include get_template_directory() . '/inc/helpers/misc.php';
include get_template_directory() . '/inc/helpers/register-acf.php';
include get_template_directory() . '/inc/helpers/register-assets.php';
include get_template_directory() . '/inc/helpers/register-post-types.php';
include get_template_directory() . '/inc/helpers/register-sidebars.php';
include get_template_directory() . '/inc/helpers/register-taxonomies.php';

# Shortcodes (TODO: Move to separate plugins)
include get_template_directory() . '/inc/shortcodes/hubspot-form.php';
include get_template_directory() . '/inc/shortcodes/include.php';
include get_template_directory() . '/inc/shortcodes/markdown-file.php';

# WP Hacks
include get_template_directory() . '/inc/hacks/active-archive-link-on-taxonomies.php';
include get_template_directory() . '/inc/hacks/add-excerpts-to-pages.php';
include get_template_directory() . '/inc/hacks/add-post-type-arg-to-get-terms.php';
include get_template_directory() . '/inc/hacks/add-upgrade-browser-script.php';
# include get_template_directory() . '/inc/hacks/advanced-search.php';
# include get_template_directory() . '/inc/hacks/ajax.php';
include get_template_directory() . '/inc/hacks/allow-shortcodes-in-widgets.php';
include get_template_directory() . '/inc/hacks/attachments-archive.php';
include get_template_directory() . '/inc/hacks/cleanup-head.php';
include get_template_directory() . '/inc/hacks/comment-form-placeholders.php';
include get_template_directory() . '/inc/hacks/disable-wp-embed.php';
include get_template_directory() . '/inc/hacks/exclude-current-post-in-upw.php';
include get_template_directory() . '/inc/hacks/hide-acf-section-fields.php';
include get_template_directory() . '/inc/hacks/hide-sleek-from-admin.php';
include get_template_directory() . '/inc/hacks/html-in-widget-titles.php';
include get_template_directory() . '/inc/hacks/jquery-cdn-in-foot.php';
include get_template_directory() . '/inc/hacks/more-markdown.php';
include get_template_directory() . '/inc/hacks/open-graph-tags.php';
include get_template_directory() . '/inc/hacks/pagination-css-class.php';
include get_template_directory() . '/inc/hacks/post-thumbnails.php';
include get_template_directory() . '/inc/hacks/register-theme-options.php';
# include get_template_directory() . '/inc/hacks/relevanssi.php';
include get_template_directory() . '/inc/hacks/remove-emoji-css-js.php';
include get_template_directory() . '/inc/hacks/remove-home-from-yoast-breadcrumbs.php';
include get_template_directory() . '/inc/hacks/set-cpt-in-search.php';
include get_template_directory() . '/inc/hacks/setup-lang.php';
include get_template_directory() . '/inc/hacks/show-all-cpt-posts.php';
include get_template_directory() . '/inc/hacks/show-all-post-types-for-auhors.php';
# include get_template_directory() . '/inc/hacks/submit-form.php';
# include get_template_directory() . '/inc/hacks/tinymce-styles.php';
include get_template_directory() . '/inc/hacks/unset-active-blog-class.php';
