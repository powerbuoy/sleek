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
		$next = $next ? $next : (get_posts(['post_type' => get_post_type(), 'numberposts' => 1])[0]);
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

	<article>

		<?php if (has_post_thumbnail($next)) : ?>
			<figure>
				<?php echo get_the_post_thumbnail($next->ID, 'large') ?>
			</figure>
		<?php endif ?>

		<h3>
			<a href="<?php the_permalink($next) ?>">
				<?php echo $next->post_title ?>
			</a>
		</h3>

		<?php the_excerpt() ?>

	</article>

</section>
