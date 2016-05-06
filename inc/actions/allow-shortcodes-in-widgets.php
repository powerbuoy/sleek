<?php
/**
 * Allow shortcodes in Widgets
 */
# add_action('init', 'sleek_allow_shortcodes_in_widgets');

function sleek_allow_shortcodes_in_widgets () {
	add_filter('widget_text', 'do_shortcode');
}
