<section id="featured-posts">

	<?php if ($featured_posts_title or $featured_posts_description) : ?>
		<header>

			<?php if ($featured_posts_title) : ?>
				<h2><?php echo $featured_posts_title ?></h2>
			<?php endif ?>

			<?php echo $featured_posts_description ?>

		</header>
	<?php endif ?>

	<?php foreach ($featured_posts_posts as $post) : setup_postdata($post) ?>
		<?php $target = get_field('redirect_url') ? 'target="_blank" rel="noopener"' : '' ?>
		<article>

			<?php if (has_post_thumbnail()) : ?>
				<figure>
					<a href="<?php the_permalink() ?>" <?php echo $target ?>>
						<?php the_post_thumbnail('medium') ?>
					</a>
				</figure>
			<?php endif ?>

			<h3>
				<a href="<?php the_permalink() ?>" <?php echo $target ?>>
					<?php the_title() ?>
				</a>
			</h3>

			<?php the_excerpt() ?>

			<a href="<?php the_permalink() ?>" <?php echo $target ?>><?php _e('Read more', 'sleek') ?></a>

		</article>
	<?php endforeach; wp_reset_postdata() ?>

</section>
