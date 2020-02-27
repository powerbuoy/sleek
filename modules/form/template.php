<section id="form">

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<div class="form">

		<?php if ($form_embed_code) : ?>
			<?php echo $form_embed_code ?>
		<?php endif ?>

		<?php if ($wpcf7_form_id) : ?>
			<?php if (shortcode_exists('contact-form-7')) : ?>
				<?php echo do_shortcode('[contact-form-7 id="' . $wpcf7_form_id . '"]') ?>
			<?php else : ?>
				<p class="error"><?php printf(__('Please make sure to activate the Contact Form 7 plugin to enable this module: %s', 'sleek'), '<a href="https://wordpress.org/plugins/contact-form-7/">wordpress.org/plugins/contact-form-7/</a>') ?></p>
			<?php endif ?>
		<?php endif ?>

		<?php if ($hubspot_form_id) : ?>
			<?php $portal_id = Sleek\Settings\get_setting('hubspot_portal_id') ?>

			<?php if (!empty($portal_id)) : ?>
				<!--[if lte IE 8]>
					<script charset="utf-8" src="//js.hsforms.net/forms/v2-legacy.js"></script>
				<![endif]-->
				<script charset="utf-8" src="//js.hsforms.net/forms/v2.js"></script>
				<script>
					// Create form
					hbspt.forms.create({
						portalId: '<?php echo $portal_id ?>',
						formId: '<?php echo $hubspot_form_id ?>'

						<?php if (isset($redirect_url) and !empty($redirect_url)) : ?>,
							redirectUrl: '<?php echo $redirect_url ?>'
						<?php endif ?>
					});

					// Add events
					window.addEventListener('message', function (event) {
						if (event.data.type === 'hsFormCallback' && event.data.id === '<?php echo $hubspot_form_id ?>') {
							// Scroll into view unless redirect URL
							<?php if (!isset($redirect_url) or empty($redirect_url)) : ?>
								if (event.data.eventName === 'onFormSubmit') {
									document.getElementById('hubspot-form').scrollIntoView();
								}
							<?php endif ?>

							// Set additional form data
							<?php if (isset($additional_data)) : ?>
								if (event.data.eventName === 'onFormReady') {
									var form = document.getElementById('hsForm_' + event.data.id);
									var input;

									<?php foreach ($additional_data as $k => $v) : ?>
										<?php $v = is_array($v) ? json_encode($v) : $v ?>

										if (input = form.querySelector('input[name="<?php echo $k ?>"]')) {
											input.value = '<?php echo $v ?>';
											input.dispatchEvent(new Event('input', {bubbles: true}));
										}
									<?php endforeach ?>
								}
							<?php endif ?>
						}
					});
				</script>
			<?php else : ?>
				<p class="error"><?php _e('Please make sure to enter a valid Hubspot Portal ID inside Settings -> Sleek', 'sleek') ?></p>
			<?php endif ?>
		<?php endif ?>

	</div>

</section>
