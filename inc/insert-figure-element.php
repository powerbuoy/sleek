<?php
# https://wordpress.stackexchange.com/questions/174582/always-use-figure-for-post-images
add_filter('the_content', function ($content) {
	return preg_replace('/<p>\\s*?(<a rel=\"attachment.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $content);
}, 99);
