<?php
	$args = [
		'post_type' => 'post',
		'numberposts' => $latest_posts_limit ? $latest_posts_limit : 3,
		'suppress_filters' => false
	];

	# Ignore same post
	if (is_single()) {
		$args['post__not_in'] = [$post->ID];
	}

	$rows = get_posts($args);
?>

<?php if ($rows) : ?>
	<section id="latest-posts">

		<?php if ($latest_posts_title or $latest_posts_description) : ?>
			<header>

				<?php if ($latest_posts_title) : ?>
					<h2><?php echo $latest_posts_title ?></h2>
				<?php endif ?>

				<?php echo $latest_posts_description ?>

			</header>
		<?php endif ?>

		<?php foreach ($rows as $post) : setup_postdata($post) ?>
			<?php $target = get_field('redirect_url') ? 'target="_blank"' : '' ?>
			<article>

				<?php if (has_post_thumbnail()) : ?>
					<figure>
						<a href="<?php the_permalink() ?>" <?php echo $target ?>>
							<?php the_post_thumbnail('medium') ?>
						</a>
					</figure>
				<?php endif ?>

				<h3>
					<a href="<?php the_permalink() ?>" <?php echo $target ?>>
						<?php the_title() ?>
					</a>
				</h3>

				<?php the_excerpt() ?>

				<a href="<?php the_permalink() ?>" <?php echo $target ?>><?php _e('Read more', 'sleek') ?></a>

			</article>
		<?php endforeach; wp_reset_postdata() ?>

	</section>
<?php endif ?>
