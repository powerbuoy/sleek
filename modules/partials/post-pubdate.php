<p>
	<?php printf(__('Posted %s by %s', 'h5b'), 
		'<time datetime="' . get_the_time('Y-m-j') . '" pubdate="pubdate">' . get_the_time(get_option('date_format')) . '</time>', 
		'<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_the_author_meta('display_name') . '</a>'
	) ?><?php if (has_category()) : ?>, <?php printf(__('filed under %s', 'h5b'), get_the_category_list(', ')) ?><?php endif ?>.
</p>
