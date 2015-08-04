<?php
# Remove .current_page_parent from Blog-page when viewing another archive
# http://stackoverflow.com/questions/3269878/wordpress-custom-post-type-hierarchy-and-menu-highlighting-current-page-parent/3270171#3270171
add_filter('nav_menu_css_class', 'sleek_unset_active_blog_class', 10, 2);

function sleek_unset_active_blog_class ($cssClass, $post) {
    if (get_post_type() != 'post') {
        if ($post->object_id == get_option('page_for_posts')) {
            foreach ($cssClass as $k => $v) {
                if ($v == 'active-parent') {
					unset($cssClass[$k]);
				}
            }
        }
    }

    return $cssClass;
}

# Remo Emoji CSS/JS from head added since WP 4.2.2
# add_action('init', 'sleek_remove_emoji_css_js');

function sleek_remove_emoji_css_js () {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
}

# Remove HOME from Yoast Breadcrumbs (http://wordpress.org/support/topic/how-can-i-remove-home-from-breadcrumbs)
# add_filter('wpseo_breadcrumb_links', 'sleek_remove_home_from_breadcrumb');

function sleek_remove_home_from_breadcrumb ($links) {
	if ($links[0]['url'] == get_home_url()) {
		array_shift($links);
	}

	return $links;
}

# Give pages excerpts
# add_action('init', 'sleek_add_excerpts_to_pages');

function sleek_add_excerpts_to_pages () {
	add_post_type_support('page', 'excerpt');
}

# Cleanup HEAD
# From: http://www.themelab.com/2010/07/11/remove-code-wordpress-header/
# add_action('init', 'sleek_cleanup_head');

function sleek_cleanup_head () {
	# Comment if needed
	## Really Simple Discovery
	remove_action('wp_head', 'rsd_link');

	## Windows Live Writer
	remove_action('wp_head', 'wlwmanifest_link');

	## Wordpress Generator
	remove_action('wp_head', 'wp_generator');

	## WPML Generator
#	remove_action('wp_head', array($sitepress, 'meta_generator_tag'));

	## Useless link elements
	remove_action('wp_head', 'start_post_rel_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
}
