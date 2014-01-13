<section id="post">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<header>

			<?php the_post_thumbnail('h5b-medium') ?>

			<h1><?php the_title() ?></h1>

			<?php include TEMPLATEPATH . '/modules/partials/post-pubdate.php' ?>

		</header>

		<?php the_content() ?>

		<footer>

			<?php wp_link_pages(array('before' => '<p>' . __('Pages', 'h5b') . ': ', 'after' => '</p>', 'next_or_number' => 'number')) ?>
			<?php include TEMPLATEPATH . '/modules/partials/post-meta.php' ?>

		</footer>

		<nav id="pagination">
			<?php previous_post_link('<span class="prev">%link</span>', '%title') ?>
			<?php next_post_link('<span class="next">%link</span>', '%title') ?>
		</nav>
	<?php endwhile; else : ?>
		<?php include TEMPLATEPATH . '/modules/partials/nothing-found.php' ?>
	<?php endif ?>

</section>
