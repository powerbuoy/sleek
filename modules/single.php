<?php while (have_posts()) : the_post() ?>
	<section id="single-<?php echo get_post_type() ?>">

		<header>

			<?php if (has_post_thumbnail()) : ?>
				<figure>
					<?php the_post_thumbnail('large') ?>
				</figure>
			<?php endif ?>

			<h1><?php the_title() ?></h1>

			<p>
				<time datetime="<?php echo get_the_time('Y-m-j') ?>">
					<?php echo get_the_time(get_option('date_format')) ?>
				</time>

				<?php if (($terms = get_the_terms($post->ID, (get_post_type() === 'post' ? 'category' : get_post_type() . '_category'))) and !is_wp_error($terms)) : ?>
					<?php echo implode(', ', array_map(function ($term) {
						return '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
					}, $terms)) ?>
				<?php endif ?>

				<?php the_author_posts_link() ?>
			</p>

		</header>

		<article>

			<?php the_content() ?>
			<?php wp_link_pages() ?>

		</article>

	</section>
<?php endwhile ?>
