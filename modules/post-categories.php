<?php
	$catTerms = get_terms('category');
	$currCat = false;

	if (is_category()) {
		global $wp_query;
		global $wp_taxonomies;

		$currCat = $wp_query->get_queried_object();
	}
?>

<nav id="post-categories">

	<ul>
		<li<?php echo !$currCat ? ' class="current_page_item"' : '' ?>>
			<a href="<?php echo get_permalink(get_option('page_for_posts')) ?>">
				<?php _e('All posts', 'sleek') ?>
			</a>
		</li>
		<?php foreach ($catTerms as $t) : ?>
			<li class="category-<?php echo $t->slug ?><?php echo ($currCat and $currCat->term_id == $t->term_id) ? ' current_page_item' : '' ?>">
				<a href="<?php echo get_term_link($t) ?>">
					<?php echo $t->name ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>

</nav>
