<section id="archive">

	<header>

		<?php /* TODO: if ($image = Sleek\ArchiveMeta\get_the_archive_image('large')) : ?>
			<figure>
				<?php echo $image ?>
			</figure>
		<?php endif */ ?>

		<h1><?php the_archive_title() ?></h1>

		<?php the_archive_description() ?>

		<?php
			$pt = Sleek\Utils\get_current_post_type();
			$tax = $pt === 'post' ? 'category' : $pt . '_category';
			$list = wp_list_categories(['show_option_all' => __('All', 'sleek'), 'taxonomy' => $tax, 'title_li' => false, 'echo' => false]);
		?>
		<?php if ($list) : ?>
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
