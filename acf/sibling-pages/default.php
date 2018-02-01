<?php
	global $post;

	$rows = [];
	$thisId = $post->ID;

	if ($post->post_parent) {
		$rows = get_pages([
			'parent' => $post->post_parent,
			'sort_column' => 'menu_order',
			'sort_order' => 'ASC'
		]);
	}
?>

<?php if ($rows) : ?>
	<section id="child-pages">

		<?php if ($data['sibling-pages-title'] or $data['sibling-pages-description']) : ?>
			<header>

				<?php if ($data['sibling-pages-title']) : ?>
					<h2><?php echo $data['sibling-pages-title'] ?></h2>
				<?php endif ?>

				<?php echo $data['sibling-pages-description'] ?>

			</header>
		<?php endif ?>

		<?php foreach ($rows as $post) : setup_postdata($post) ?>
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
<?php else : ?>
	<p class="error"><?php _e('This page does not have any siblings. You can remove this module until you add some.', 'sleek_child') ?></p>
<?php endif ?>
