<section id="post">

	<?php while (have_posts()) : the_post(); ?>
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
	<?php endwhile ?>

</section>

<nav id="pagination">
	<?php previous_post_link('%link', '%title') ?>
	<?php next_post_link('%link', '%title') ?>
</nav>
