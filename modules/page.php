<?php while (have_posts()) : the_post() ?>
	<section id="page">

		<header>

			<h1><?php the_title() ?></h1>

			<?php if (has_post_thumbnail()) : ?>
				<figure>
					<?php the_post_thumbnail('large') ?>
				</figure>
			<?php endif ?>

			<?php if ($post->post_excerpt) : ?>
				<?php the_excerpt() ?>
			<?php endif ?>

		</header>

		<?php get_template_part('modules/breadcrumbs') ?>

		<article>

			<?php the_content() ?>
			<?php wp_link_pages() ?>

		</article>

	</section>
<?php endwhile ?>
