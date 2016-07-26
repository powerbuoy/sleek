<?php
	$big = 999999;
	$pagination = paginate_links([
		# All args
		/* 'base' => '%_%',
		'format' => '/page/%#%',
		'total' => 1,
		'current' => 0,
		'show_all' => false,
		'end_size' => 1,
		'mid_size' => 2,
		'prev_next' => true,
		'prev_text' => __('« Previous'),
		'next_text' => __('Next »'),
		'type' => 'array',
		'add_args' => false,
		'add_fragment' => '',
		'before_page_number' => '',
		'after_page_number' => '', */

		# From https://codex.wordpress.org/Function_Reference/paginate_links
		'type' => 'list',
		'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $wp_query->max_num_pages
	]);
?>

<?php if ($pagination) : ?>
	<nav id="pagination">

		<?php echo $pagination ?>

	</nav>
<?php endif ?>
