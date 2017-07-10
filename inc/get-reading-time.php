<?php
# http://ryanfrankel.com/how-to-find-the-number-of-words-in-a-post-in-wordpress/
function sleek_get_reading_time ($post) {
	$numWords = str_word_count(strip_tags(get_post_field('post_content', $post->ID)));
	$min = ceil($numWords / 200); # NOTE: 200 words per minute seems normal; http://www.readingsoft.com/

	return $min;
}
