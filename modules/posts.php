<section id="posts">

	<?php if (is_category()) : ?>
		<h2><?php _e('Posts categorized', 'h5b') ?> <strong><?php single_cat_title() ?></strong></h2>
	<?php elseif (is_tag()) : ?> 
		<h2><?php _e('Posts tagged', 'h5b') ?> <strong><?php single_tag_title() ?></strong></h2>
	<?php elseif (is_search()) : ?>
		<h2><?php _e('Search results for', 'h5b') ?> <strong><?php the_search_query() ?></strong></h2>
	<?php elseif (is_author()) : ?>
		<h2><?php _e('Posts by', 'h5b') ?> <strong><?php the_post(); the_author(); rewind_posts() ?></strong></h2>
	<?php elseif (is_day()) : ?>
		<h2><?php _e('Daily archives', 'h5b') ?> <strong><?php the_time('l, F j, Y') ?></strong></h2>
	<?php elseif (is_month()) : ?>
		<h2><?php _e('Monthly archives', 'h5b') ?> <strong><?php the_time('F Y') ?></strong></h2>
	<?php elseif (is_year()) : ?>
		<h2><?php _e('Yearly archives', 'h5b') ?> <strong><?php the_time('Y') ?></strong></h2>
	<?php else : ?>
		<h2><?php _e('Blog', 'h5b') ?></h2>
	<?php endif ?>

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post() ?>
			<article id="post-<?php the_ID() ?>">

				<header>

					<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>

					<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('h5b-100') ?></a>

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
