<?php $portal_id = Sleek\Settings\get_setting('hubspot_portal_id') ?>

<section id="hubspot-form">

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<?php if (!empty($portal_id)) : ?>
		<!--[if lte IE 8]>
			<script charset="utf-8" src="//js.hsforms.net/forms/v2-legacy.js"></script>
		<![endif]-->
		<script charset="utf-8" src="//js.hsforms.net/forms/v2.js"></script>
		<script>
			hbspt.forms.create({
				css: '',
				portalId: '<?php echo $portal_id ?>',
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
