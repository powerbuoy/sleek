<?php while (have_posts()) : the_post() ?>
	<section id="attachment">

		<header>

			<h1><?php the_title() ?></h1>

			<figure>
				<?php echo wp_get_attachment_image($post->ID, 'large') ?>
			</figure>

			<?php the_excerpt() ?>

		</header>

		<?php get_template_part('modules/breadcrumbs') ?>

		<article>

			<figure>

				<a href="<?php echo wp_get_attachment_url($post->ID) ?>">
					<?php echo wp_get_attachment_image($post->ID, 'large') ?>
				</a>

				<figcaption>

					<h2><?php the_title() ?></h2>

					<?php the_excerpt() ?>
					<?php the_content() ?>

				</figcaption>

			</figure>

		</article>

	</section>
<?php endwhile ?>

<nav id="pagination">

	<?php previous_image_link() ?>
	<?php next_image_link() ?>

</nav>
