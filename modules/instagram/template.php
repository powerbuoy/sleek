<?php if (class_exists('Meks_Instagram_Widget')) : ?>
	<section id="instagram">

		<?php if ($title or $description) : ?>
			<header>

				<?php if ($title) : ?>
					<h2><?php echo $title ?></h2>
				<?php endif ?>

				<?php echo $description ?>

			</header>
		<?php endif ?>

		<?php $html = do_shortcode("[meks_easy_photo_feed photos_number=$limit container_size=2000]") ?>
		<?php echo preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3', $html) ?>

	</section>
<?php elseif (current_user_can('edit_posts')) : ?>
	<p class="error"><?php printf(__('Please make sure to activate the Meks Easy Photo Feed Widget to enable this module: %s', 'sleek_admin'), '<a href="https://wordpress.org/plugins/meks-easy-instagram-widget/">wordpress.org/plugins/meks-easy-instagram-widget/</a>') ?></p>
<?php endif ?>
