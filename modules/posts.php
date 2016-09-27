<section id="posts">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post() ?>
			<article>

				<header>

					<h2>
						<a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail('sleek-medium') ?>
							<?php the_title() ?>
						</a>
					</h2>

					<?php get_template_part('modules/partials/post-pubdate') ?>

				</header>

				<?php the_excerpt() ?>

				<footer>

					<?php get_template_part('modules/partials/post-meta') ?>

				</footer>

			</article>
		<?php endwhile ?>
	<?php else : ?>
		<p><strong><?php _e('Sorry, nothing was found here.', 'sleek') ?></strong></p>
	<?php endif ?>

</section>

<?php get_template_part('modules/posts-pagination') ?>
