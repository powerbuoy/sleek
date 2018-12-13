<?php $options = get_option(SLEEK_SETTINGS_NAME) ?>

<section id="hubspot-form">

	<?php if ($hubspot_form_title or $hubspot_form_description) : ?>
		<header>

			<?php if ($hubspot_form_title) : ?>
				<h2><?php echo $hubspot_form_title ?></h2>
			<?php endif ?>

			<?php echo $hubspot_form_description ?>

		</header>
	<?php endif ?>

	<?php if (isset($options['hubspot_portal_id']) and !empty($options['hubspot_portal_id'])) : ?>
		<!--[if lte IE 8]>
			<script charset="utf-8" src="//js.hsforms.net/forms/v2-legacy.js"></script>
		<![endif]-->
		<script charset="utf-8" src="//js.hsforms.net/forms/v2.js"></script>
		<script>
			hbspt.forms.create({
				css: '',
				portalId: '<?php echo $options['hubspot_portal_id'] ?>',
				formId: '<?php echo $hubspot_form_id ?>',
				onFormSubmit: function ($form) {
					document.getElementById('hubspot-form').scrollIntoView();
				}
			});
		</script>
	<?php else : ?>
		<p class="error"><?php _e('Please make sure to enter a valid Hubspot Portal ID inside Settings -> Sleek', 'sleek') ?></p>
	<?php endif ?>

</section>