<section id="post">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<header>

			<?php the_post_thumbnail('sleek-medium') ?>

			<h1><?php the_title() ?></h1>

			<?php sleek_get_module('partials/post-pubdate') ?>

		</header>

		<?php the_content() ?>

		<footer>

			<?php wp_link_pages(array('before' => '<p>' . __('Pages', 'sleek') . ': ', 'after' => '</p>', 'next_or_number' => 'number')) ?>
			<?php sleek_get_module('partials/post-meta') ?>

		</footer>

		<nav id="pagination">
			<?php previous_post_link('<span class="prev">%link</span>', '%title') ?>
			<?php next_post_link('<span class="next">%link</span>', '%title') ?>
		</nav>
	<?php endwhile; else : ?>
		<?php sleek_get_module('partials/nothing-found') ?>
	<?php endif ?>

</section>
