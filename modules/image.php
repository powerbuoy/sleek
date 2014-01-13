<section id="image">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post() ?>
			<h1>
				<!-- <a href="<?php echo get_permalink($post->post_parent) ?>">
					<?php echo get_the_title($post->post_parent) ?>
				</a> &raquo; --><?php the_title() ?>
			</h1>

			<figure>
				<a href="<?php echo wp_get_attachment_url($post->ID) ?>">
					<?php echo wp_get_attachment_image($post->ID, 'h5b-100') ?>
				</a>

				<?php if (!empty($post->post_excerpt)) : ?>
					<figcaption><?php the_excerpt() ?></figcaption>
				<?php endif ?>
			</figure>

			<?php the_content() ?>
		<?php endwhile ?>

		<nav id="pagination">
			<?php previous_image_link() ?>
			<?php next_image_link() ?>
		</nav>
	<?php else : ?>
		<?php include TEMPLATEPATH . '/modules/partials/nothing-found.php' ?>
	<?php endif ?>

</section>
