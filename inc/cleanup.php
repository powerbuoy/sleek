<?php
# A lot of this stuff is from the Roots WP theme
# Originally from http://wpengineer.com/1438/wordpress-header/
add_action('init', function () {
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
});

# Cleanup <link>
add_filter('style_loader_tag', function ($input) {
	preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);

	# Only display media if it is meaningful
	$media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';

	return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
});

# Remove />
function roots_remove_self_closing_tags ($input) {
	return str_replace(' />', '>', $input);
}

add_filter('get_avatar', 'roots_remove_self_closing_tags'); # <img />
add_filter('comment_id_fields', 'roots_remove_self_closing_tags'); # <input />
add_filter('post_thumbnail_html', 'roots_remove_self_closing_tags'); # <img />
