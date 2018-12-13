<?php
	$nav = str_replace('<h2 class="screen-reader-text">REMOVE</h2>', '', get_the_posts_pagination(['screen_reader_text' => 'REMOVE']));
	$nav = str_replace(['<div class="nav-links">', '<div>'], '', $nav);
	$nav = preg_replace('/\<nav(.*?)\>/', '<nav id="pagination">', $nav);

	echo $nav;
?>
