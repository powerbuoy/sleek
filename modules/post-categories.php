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
		<?php foreach ($catTerms as $t) : ?>
			<li class="category-<?php echo $t->slug ?><?php echo ($currCat and $currCat->term_id == $t->term_id) ? ' active' : '' ?>">
				<a href="<?php echo get_term_link($t) ?>">
					<?php echo $t->name ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>

</nav>
