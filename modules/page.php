<section id="page">

	<?php while (have_posts()) : the_post() ?>
		<header>

			<h1><?php the_title() ?></h1>

			<figure>
				<?php the_post_thumbnail('large') ?>
			</figure>

			<?php the_excerpt() ?>

		</header>

		<?php get_template_part('modules/breadcrumbs') ?>

		<article>

			<?php the_content() ?>
			<?php wp_link_pages() ?>

		</article>
	<?php endwhile ?>

</section>
