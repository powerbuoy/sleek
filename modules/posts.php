<section id="posts">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post() ?>
			<article id="post-<?php the_ID() ?>">

				<header>

					<h2><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('h5b-medium') ?> <?php the_title() ?></a></h2>

					<?php include TEMPLATEPATH . '/modules/partials/post-pubdate.php' ?>

				</header>

				<?php the_excerpt() ?>
				<?php # the_content('Read more...') ?>

				<footer>

					<?php include TEMPLATEPATH . '/modules/partials/post-meta.php' ?>

				</footer>

			</article>
		<?php endwhile ?>

		<nav id="pagination">
			<?php previous_posts_link(__('Previous page', 'h5b')) ?>
			<?php next_posts_link(__('Next page', 'h5b')) ?>
		</nav>
	<?php else : ?>
		<?php include TEMPLATEPATH . '/modules/partials/nothing-found.php' ?>
	<?php endif ?>

</section>
