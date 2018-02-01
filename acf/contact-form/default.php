<?php if (shortcode_exists('contact-form-7')) : ?>
	<section id="contact-form">

		<?php if ($data['contact-form-title'] or $data['contact-form-description']) : ?>
			<header>

				<?php if ($data['contact-form-title']) : ?>
					<h2><?php echo $data['contact-form-title'] ?></h2>
				<?php endif ?>

				<?php echo $data['contact-form-description'] ?>

			</header>
		<?php endif ?>

		<?php echo do_shortcode('[contact-form-7 id="' . $data['contact-form-id'] . '"]') ?>

	</section>
<?php else : ?>
	<p class="error"><?php printf(__('Please make sure to activate the Contact Form 7 plugin to enable this module: %s', 'sleek'), '<a href="https://wordpress.org/plugins/contact-form-7/">wordpress.org/plugins/contact-form-7/</a>') ?></p>
<?php endif ?>
