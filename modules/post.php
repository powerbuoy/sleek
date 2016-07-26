<section id="post">

	<?php while (have_posts()) : the_post() ?>
		<header>

			<?php the_post_thumbnail('sleek-medium') ?>

			<h1><?php the_title() ?></h1>

			<?php get_template_part('modules/partials/post-pubdate') ?>

		</header>

		<?php the_content() ?>

		<footer>

			<?php wp_link_pages(['before' => '<p>' . __('Pages', 'sleek') . ': ', 'after' => '</p>', 'next_or_number' => 'number']) ?>
			<?php get_template_part('modules/partials/post-meta') ?>

		</footer>
	<?php endwhile ?>

</section>

<?php get_template_part('modules/post-pagination') ?>
