<?php $options = get_option(SLEEK_SETTINGS_NAME) ?>

<?php if (isset($options['site_notice']) and !empty($options['site_notice'])) : ?>
	<section id="site-notice">

		<?php echo wpautop($options['site_notice']) ?>

	</section>
<?php endif ?>
