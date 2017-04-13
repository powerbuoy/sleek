<?php while (have_posts()) : the_post() ?>
	<section id="post">

		<header>

			<h1><?php the_title() ?></h1>

			<figure>
				<?php the_post_thumbnail('large') ?>
			</figure>

			<p>
				<time datetime="<?php echo get_the_time('Y-m-j') ?>"><?php echo get_the_time(get_option('date_format')) ?></time> |
				<?php echo get_the_author_meta('display_name') ?> |
				<?php echo implode(', ', sleek_get_post_terms($post->ID, get_post_type())) ?>
			</p>

		</header>

		<?php get_template_part('modules/breadcrumbs') ?>

		<article>

			<?php the_content() ?>
			<?php wp_link_pages() ?>

		</article>

	</section>
<?php endwhile ?>

<nav id="pagination">

	<?php previous_post_link() ?>
	<?php next_post_link() ?>

</nav>
