<article>

	<figure>
		<a href="<?php the_permalink() ?>">
			<?php the_post_thumbnail('medium') ?>
		</a>
	</figure>

	<header>

		<h3>
			<a href="<?php the_permalink() ?>">
				<?php the_title() ?>
			</a>
		</h3>

		<?php if (get_post_type() == 'post') : ?>
			<p>
				<time datetime="<?php echo get_the_time('Y-m-j') ?>"><?php echo get_the_time(get_option('date_format')) ?></time>

				<?php if (($terms = get_the_terms($post->ID, (get_post_type() === 'post' ? 'category' : get_post_type() . '_category'))) and !is_wp_error($terms)) : ?>
					<span>
						<?php echo implode(', ', array_map(function ($term) {
							return '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
						}, $terms)) ?>
					</span>
				<?php endif ?>

				<?php if (get_the_author_meta('ID') != 1) : ?>
					<?php the_author_posts_link() ?>
				<?php endif ?>
			</p>
		<?php endif ?>

	</header>

	<?php the_excerpt() ?>

	<a href="<?php the_permalink() ?>"><?php _e('Read more', 'sleek') ?></a>

</article>
