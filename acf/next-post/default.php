<?php
	# Specific post
	if ($next_post_post) {
		$next = $next_post_post;
	}
	# Or..
	else {
		# Adjacent post
		$next = get_adjacent_post();

		# Or first post of same post type
		$next = $next ? $next : (get_posts([
			'post_type' => get_post_type(),
			'numberposts' => 1,
			'suppress_filters' => false
		])[0]);
	}
?>

<section id="next-post">

	<?php if ($next_post_title or $next_post_description) : ?>
		<header>

			<?php if ($next_post_title) : ?>
				<h2><?php echo $next_post_title ?></h2>
			<?php endif ?>

			<?php echo $next_post_description ?>

		</header>
	<?php endif ?>

	<?php foreach ([$next] as $post) : setup_postdata($post) ?>
		<?php get_template_part('modules/archive-post', get_post_type()) ?>
	<?php endforeach; wp_reset_postdata() ?>

</section>
