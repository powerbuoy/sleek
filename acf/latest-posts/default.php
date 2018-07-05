<?php
	$post_type = ($latest_posts_post_type ? $latest_posts_post_type : 'any');
	$args = [
		'post_type' => $post_type,
		'numberposts' => $latest_posts_limit ? $latest_posts_limit : 3,
		'suppress_filters' => false,
		'tax_query' => [
			'relation' => 'OR'
		]
	];

	# Ignore same post
	if (is_single()) {
		$args['post__not_in'] = [$post->ID];
	}

	# Check if user has selected any categories
	if ($latest_posts_category) {
		$args['tax_query'][] = [
			'taxonomy' => 'category',
			'field' => 'term_id',
			'terms' => $latest_posts_category
		];
	}
	# NOTE: Add more here as needed

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
