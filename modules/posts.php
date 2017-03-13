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

					<p>
						<time datetime="<?php echo get_the_time('Y-m-j') ?>"><?php echo get_the_time(get_option('date_format')) ?></time> |
						<?php echo get_the_author_meta('display_name') ?>
						<?php $postTerms = sleek_get_post_terms($post->ID, get_post_type()) ?>
						<?php if ($postTerms) : ?> | <?php echo implode(', ', $postTerms) ?><?php endif ?>
					</p>

				</header>

				<?php the_excerpt() ?>

			</article>
		<?php endwhile ?>
	<?php else : ?>
		<p><strong><?php _e('Sorry, nothing was found here.', 'sleek') ?></strong></p>
	<?php endif ?>

</section>

<?php get_template_part('modules/posts-pagination') ?>
