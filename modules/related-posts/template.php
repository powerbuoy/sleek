<?php if ($rows) : ?>
	<section id="related-posts">

		<?php if ($title or $description) : ?>
			<header>

				<?php if ($title) : ?>
					<h2><?php echo $title ?></h2>
				<?php endif ?>

				<?php echo $description ?>

			</header>
		<?php endif ?>

		<?php foreach ($rows as $post) : setup_postdata($post) ?>
			<?php get_template_part('modules/post', get_post_type()) ?>
		<?php endforeach; wp_reset_postdata() ?>

	</section>
<?php elseif (current_user_can('edit_posts')) : ?>
	<p class="error"><?php _e('No related posts found.', 'sleek_admin') ?></p>
<?php endif ?>
