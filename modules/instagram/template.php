<?php if (class_exists('null_instagram_widget')) : ?>
	<section id="instagram">

		<?php if ($title or $description) : ?>
			<header>

				<?php if ($title) : ?>
					<h2><?php echo $title ?></h2>
				<?php endif ?>

				<?php echo $description ?>

			</header>
		<?php endif ?>

		<?php the_widget('null_instagram_widget', 'username=' . $username . '&number=' . $limit . '&target=_blank') ?>

	</section>
<?php else : ?>
	<p class="error"><?php printf(__('Please make sure to activate the WP Instagram Widget to enable this module: %s', 'sleek'), '<a href="https://github.com/scottsweb/wp-instagram-widget">github.com/scottsweb/wp-instagram-widget</a>') ?></p>
<?php endif ?>
