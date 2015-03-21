<section id="posts">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post() ?>
			<article id="post-<?php the_ID() ?>">

				<header>

					<h2><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('sleek-medium') ?> <?php the_title() ?></a></h2>

					<?php sleek_get_module('partials/post-pubdate') ?>

				</header>

				<?php the_excerpt() ?>
				<?php # the_content('Read more...') ?>

				<footer>

					<?php sleek_get_module('partials/post-meta') ?>

				</footer>

			</article>
		<?php endwhile ?>

		<nav id="pagination">
			<?php previous_posts_link(__('Previous page', 'sleek')) ?>
			<?php next_posts_link(__('Next page', 'sleek')) ?>
		</nav>
	<?php else : ?>
		<?php sleek_get_module('partials/nothing-found') ?>
	<?php endif ?>

</section>
