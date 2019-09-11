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

	<header>

		<h1><?php the_archive_title() ?></h1>

		<?php the_archive_description() ?>
		<?php get_search_form() ?>

	</header>

	<?php if (have_posts()) : ?>
		<?php foreach ($groups as $postType => $rows) : ?>
			<?php $postType = get_post_type_object($postType) ?>
			<section>

				<h2><?php echo $postType->labels->name ?></h2>

				<?php foreach ($rows as $post) : setup_postdata($post) ?>
					<?php get_template_part('modules/archive-post', get_post_type()) ?>
				<?php endforeach; wp_reset_postdata() ?>

			</section>
		<?php endforeach ?>
	<?php else : ?>
		<p><strong><?php _e('Sorry, nothing was found here.', 'sleek') ?></strong></p>
	<?php endif ?>

</section>
