<section id="search-results">

	<header>

		<h1><?php the_archive_title() ?></h1>

		<?php the_archive_description() ?>
		<?php get_search_form() ?>

	</header>

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post() ?>
			<?php get_template_part('modules/post', 'search') ?>
		<?php endwhile ?>

		<footer>

			<?php the_posts_pagination() ?>

		</footer>
	<?php else : ?>
		<p><strong><?php _e('Sorry, nothing was found here.', 'sleek') ?></strong></p>
	<?php endif ?>

</section>
