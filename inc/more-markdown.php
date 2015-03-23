<?php
# http://support.advancedcustomfields.com/forums/topic/add-markdown-support-in-custom-fields/#post-19167
function sleek_more_markdown () {
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_content', 'wptexturize' );
	remove_filter( 'the_excerpt', 'wpautop' );
	remove_filter( 'the_excerpt', 'wptexturize' );
	remove_filter( 'acf_the_content', 'wpautop' );
	remove_filter( 'acf_the_content', 'wptexturize' );

	add_filter( 'the_content', 'Markdown' );
	add_filter( 'the_excerpt', 'Markdown' );
	add_filter( 'acf_the_content', 'Markdown' );
}
