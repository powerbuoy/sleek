<p class="pubdate">
	<?php printf(__('Posted %s by %s', 'sleek'), 
		'<time datetime="' . get_the_time('Y-m-j') . '">' . get_the_time(get_option('date_format')) . '</time>', 
		'<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_the_author_meta('display_name') . '</a>'
	) ?><?php if (has_category()) : ?>, <?php printf(__('filed under %s', 'sleek'), get_the_category_list(', ')) ?><?php endif ?>.
</p>

<?php /* <p>
	<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>"><?php echo get_the_author_meta('display_name') ?></a> 
	<time><?php echo get_the_time(get_option('date_format')) ?></time>
</p> */ ?>
