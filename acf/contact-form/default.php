<section id="contact-form">

	<?php if ($contact_form_title or $contact_form_description) : ?>
		<header>

			<?php if ($contact_form_title) : ?>
				<h2><?php echo $contact_form_title ?></h2>
			<?php endif ?>

			<?php echo $contact_form_description ?>

		</header>
	<?php endif ?>

	<?php if (shortcode_exists('contact-form-7')) : ?>
		<?php echo do_shortcode('[contact-form-7 id="' . $contact_form_id . '"]') ?>
	<?php else : ?>
		<p class="error"><?php printf(__('Please make sure to activate the Contact Form 7 plugin to enable this module: %s', 'sleek'), '<a href="https://wordpress.org/plugins/contact-form-7/">wordpress.org/plugins/contact-form-7/</a>') ?></p>
	<?php endif ?>

</section>
