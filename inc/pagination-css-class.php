<?php
# Add some way of styling the pagination's prev/next-links differently
# rel=next|prev seems to be semantically correct as well
add_filter('next_posts_link_attributes', 'sleek_link_next_class');
add_filter('next_post_link_attributes', 'sleek_link_next_class');
add_filter('next_image_link_attributes', 'sleek_link_next_class');

add_filter('previous_posts_link_attributes', 'sleek_link_prev_class');
add_filter('previous_post_link_attributes', 'sleek_link_prev_class');
add_filter('previous_image_link_attributes', 'sleek_link_prev_class');

function sleek_link_next_class () {
	return 'rel="next"';
}

function sleek_link_prev_class () {
	return 'rel="prev"';
} 
