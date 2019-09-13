<section id="archive">

	<header>

		<h1><?php the_archive_title() ?></h1>

		<?php the_archive_description() ?>

		<?php # TODO: Change taxonomy depending on post-type-archive ?>
		<?php if ($list = wp_list_categories([
				'taxonomy' => 'category',
				'title_li' => false,
				'show_option_all' => __('All', 'sleek'),
				'echo' => false
			])) : ?>
			<ul>
				<?php echo $list ?>
			</ul>
		<?php endif ?>

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
