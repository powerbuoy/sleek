<section id="archive">

	<header>

		<h1><?php the_archive_title() ?></h1>

		<?php the_archive_description() ?>

	</header>

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post() ?>
			<?php get_template_part('modules/post', get_post_type()) ?>
		<?php endwhile ?>

		<footer>

			<?php the_posts_pagination() ?>

		</footer>
	<?php else : ?>
		<p><strong><?php _e('Sorry, nothing was found here.', 'sleek') ?></strong></p>
	<?php endif ?>

</section>
