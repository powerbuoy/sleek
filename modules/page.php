<section id="page">

	<?php while (have_posts()) : the_post() ?>
		<header>

			<h1><?php the_title() ?></h1>

			<figure>
				<?php the_post_thumbnail('sleek-hd') ?>
			</figure>

			<?php the_excerpt() ?>

			<?php sleek_get_template_part('modules/acf-modules', ['where' => 'inside-hero']) ?>

		</header>

		<?php if (get_field('modules-right-of-content')) : ?>
			<div>

				<article>

					<?php the_content() ?>
					<?php wp_link_pages() ?>

				</article>

				<aside>

					<?php sleek_get_template_part('modules/acf-modules', ['where' => 'right-of-content']) ?>

				</aside>

			</div>
		<?php else : ?>
			<article>

				<?php the_content() ?>
				<?php wp_link_pages() ?>

			</article>
		<?php endif ?>
	<?php endwhile ?>

</section>
