<?php global $post ?>

<section id="featured-posts">

	<?php if ($data['featured-posts-title'] or $data['featured-posts-description']) : ?>
		<header>

			<?php if ($data['featured-posts-title']) : ?>
				<h2><?php echo $data['featured-posts-title'] ?></h2>
			<?php endif ?>

			<?php echo $data['featured-posts-description'] ?>

		</header>
	<?php endif ?>

	<?php foreach ($data['featured-posts-posts'] as $post) : setup_postdata($post) ?>
		<?php $target = get_field('redirect-url') ? 'target="_blank"' : '' ?>
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
