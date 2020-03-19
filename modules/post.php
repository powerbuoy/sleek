<article class="post--<?php echo get_post_type() ?>">

	<?php if (has_post_thumbnail()) : ?>
		<figure>
			<a href="<?php the_permalink() ?>">
				<?php the_post_thumbnail('medium') ?>
			</a>
		</figure>
	<?php endif ?>

	<header>

		<h3>
			<a href="<?php the_permalink() ?>">
				<?php the_title() ?>
			</a>
		</h3>

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

	<?php the_excerpt() ?>

	<footer>

		<a href="<?php the_permalink() ?>"><?php _e('Read more', 'sleek') ?></a>

	</footer>

</article>
