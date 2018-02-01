<?php if (class_exists('null_instagram_widget')) : ?>
	<section id="instagram">

		<?php if ($data['instagram-title'] or $data['instagram-description']) : ?>
			<header>

				<?php if ($data['instagram-title']) : ?>
					<h2><?php echo $data['instagram-title'] ?></h2>
				<?php endif ?>

				<?php echo $data['instagram-description'] ?>

			</header>
		<?php endif ?>

		<?php the_widget('null_instagram_widget', 'username=' . $data['instagram-username'] . '&number=' . $data['instagram-limit'] . '&target=_blank') ?>

	</section>
<?php else : ?>
	<p class="error"><?php printf(__('Please make sure to activate the WP Instagram Widget to enable this module: %s', 'sleek'), '<a href="https://wordpress.org/plugins/wp-instagram-widget/">wordpress.org/plugins/wp-instagram-widget/</a>') ?></p>
<?php endif ?>
