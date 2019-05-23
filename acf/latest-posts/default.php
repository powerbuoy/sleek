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
			<?php get_template_part('modules/archive-post', get_post_type()) ?>
		<?php endforeach; wp_reset_postdata() ?>

	</section>
<?php endif ?>
