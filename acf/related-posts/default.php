<?php
	$args = [
		'post_type' => get_post_type(),
		'numberposts' => $related_posts_limit ? $related_posts_limit : 3,
		'suppress_filters' => false,
		'tax_query' => [
			'relation' => 'OR'
		]
	];

	# Ignore same post
	if (is_single()) {
		$args['post__not_in'] = [$post->ID];
	}

	# Use the same category as the currently viewed post
	if (is_single()) {
		$tax = 'category';

		if (get_post_type() !== 'post') {
			$tax = get_post_type() . '_category';
		}

		$ids = wp_get_post_terms($post->ID, $tax, ['fields' => 'ids']);

		if ($ids and !is_wp_error($ids)) {
			$args['tax_query'][] = [
				'taxonomy' => $tax,
				'field' => 'term_id',
				'terms' => $ids
			];
		}
	}

	$rows = get_posts($args);
?>

<?php if ($rows) : ?>
	<section id="related-posts">

		<?php if ($related_posts_title or $related_posts_description) : ?>
			<header>

				<?php if ($related_posts_title) : ?>
					<h2><?php echo $related_posts_title ?></h2>
				<?php endif ?>

				<?php echo $related_posts_description ?>

			</header>
		<?php endif ?>

		<?php foreach ($rows as $post) : setup_postdata($post) ?>
			<?php get_template_part('modules/archive-post', get_post_type()) ?>
		<?php endforeach; wp_reset_postdata() ?>

	</section>
<?php endif ?>
