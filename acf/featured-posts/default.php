<section id="featured-posts">

	<?php if ($featured_posts_title or $featured_posts_description) : ?>
		<header>

			<?php if ($featured_posts_title) : ?>
				<h2><?php echo $featured_posts_title ?></h2>
			<?php endif ?>

			<?php echo $featured_posts_description ?>

		</header>
	<?php endif ?>

	<?php foreach ($featured_posts_posts as $post) : setup_postdata($post) ?>
		<?php get_template_part('modules/archive-post', get_post_type()) ?>
	<?php endforeach; wp_reset_postdata() ?>

</section>
