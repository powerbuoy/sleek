<?php while (have_posts()) : the_post() ?>
	<section id="attachment">

		<header>

			<h1><?php the_title() ?></h1>

			<figure>
				<a href="<?php echo wp_get_attachment_url($post->ID) ?>">
					<?php echo wp_get_attachment_image($post->ID, 'large') ?>
				</a>

				<?php if (!empty($post->post_excerpt)) : ?>
					<figcaption><?php the_excerpt() ?></figcaption>
				<?php endif ?>
			</figure>

		</header>

		<?php get_template_part('modules/breadcrumbs') ?>

		<article>

			<?php the_content() ?>

		</article>

	</section>
<?php endwhile ?>

<nav id="pagination">

	<?php previous_image_link() ?>
	<?php next_image_link() ?>

</nav>
