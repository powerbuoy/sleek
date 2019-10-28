<?php if ($rows) : ?>
	<section id="child-pages">

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
<?php else : ?>
	<p class="error"><?php _e('This page does not have any child pages. You can remove this module until you add some.', 'sleek') ?></p>
<?php endif ?>
