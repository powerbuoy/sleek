<?php if (class_exists('null_instagram_widget')) : ?>
	<section id="instagram">

		<?php if ($instragram_title or $instragram_description) : ?>
			<header>

				<?php if ($instragram_title) : ?>
					<h2><?php echo $instragram_title ?></h2>
				<?php endif ?>

				<?php echo $instragram_description ?>

			</header>
		<?php endif ?>

		<?php the_widget('null_instagram_widget', 'username=' . $instragram_username . '&number=' . $instragram_limit . '&target=_blank') ?>

	</section>
<?php else : ?>
	<p class="error"><?php printf(__('Please make sure to activate the WP Instagram Widget to enable this module: %s', 'sleek'), '<a href="https://wordpress.org/plugins/wp-instagram-widget/">wordpress.org/plugins/wp-instagram-widget/</a>') ?></p>
<?php endif ?>
