<?php
	# Group search results by post type
	$groups = [];

	while (have_posts()) {
		the_post();

		if (!isset($groups[get_post_type()])) {
			$groups[get_post_type()] = [];
		}

		$groups[get_post_type()][] = $post;
	}
?>

<section id="search-results">

	<?php if (have_posts()) : ?>
		<?php foreach ($groups as $postType => $rows) : ?>
			<?php $postType = get_post_type_object($postType) ?>
			<section>

				<h2><?php echo $postType->labels->name ?></h2>

				<?php foreach ($rows as $post) : setup_postdata($post) ?>
					<article>

						<figure>
							<a href="<?php the_permalink() ?>">
								<?php the_post_thumbnail('medium') ?>
							</a>
						</figure>

						<header>

							<h3>
								<a href="<?php the_permalink() ?>">
									<?php the_title() ?>
								</a>
							</h3>

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
				<?php endforeach; wp_reset_postdata() ?>

			</section>
		<?php endforeach ?>
	<?php else : ?>
		<p><strong><?php _e('Sorry, nothing was found here.', 'sleek') ?></strong></p>
	<?php endif ?>

</section>
