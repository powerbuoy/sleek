<?php
add_filter('next_posts_link_attributes', 'h5b_link_next_class');
add_filter('next_post_link_attributes', 'h5b_link_next_class');
add_filter('next_image_link_attributes', 'h5b_link_next_class');

add_filter('previous_posts_link_attributes', 'h5b_link_prev_class');
add_filter('previous_post_link_attributes', 'h5b_link_prev_class');
add_filter('previous_image_link_attributes', 'h5b_link_prev_class');

function h5b_link_next_class () {
	return 'class="next" rel="next"';
}

function h5b_link_prev_class () {
	return 'class="prev" rel="prev"';
} 
