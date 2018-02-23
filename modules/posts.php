<section id="posts">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post() ?>
			<article>

				<figure>
					<a href="<?php the_permalink() ?>">
						<?php the_post_thumbnail('medium') ?>
					</a>
				</figure>

				<header>

					<h2>
						<a href="<?php the_permalink() ?>">
							<?php the_title() ?>
						</a>
					</h2>

					<?php if (get_post_type() == 'post') : ?>
						<p>
							<time datetime="<?php echo get_the_time('Y-m-j') ?>"><?php echo get_the_time(get_option('date_format')) ?></time>
							<?php if ($terms = sleek_get_post_terms($post->ID, get_post_type(), true)) : ?>
								<span><?php echo implode(', ', $terms) ?></span>
							<?php endif ?>
							<?php if (get_the_author_meta('ID') != 1) : ?>
								<?php the_author_posts_link() ?>
							<?php endif ?>
						</p>
					<?php endif ?>

				</header>

				<?php the_excerpt() ?>

				<a href="<?php the_permalink() ?>"><?php _e('Read more', 'sleek') ?></a>

			</article>
		<?php endwhile ?>
	<?php else : ?>
		<p><strong><?php _e('Sorry, nothing was found here.', 'sleek') ?></strong></p>
	<?php endif ?>

</section>
