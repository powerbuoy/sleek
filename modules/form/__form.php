<?php if ($form_embed_code) : ?>
	<?php echo $form_embed_code ?>
<?php endif ?>

<?php if (isset($wpcf7_form_id) and !empty($wpcf7_form_id)) : ?>
	<?php if (shortcode_exists('contact-form-7')) : ?>
		<?php echo do_shortcode('[contact-form-7 id="' . $wpcf7_form_id . '"]') ?>

		<?php if ($redirect_url) : ?>
			<script>
				document.addEventListener('wpcf7mailsent', function (e) {
					if (e.detail.contactFormId == <?php echo $wpcf7_form_id ?>) {
						window.location = '<?php echo $redirect_url ?>';
					}
				}, false);
			</script>
		<?php endif ?>
	<?php elseif (current_user_can('edit_posts')) : ?>
		<p class="error"><?php printf(__('Please make sure to activate the Contact Form 7 plugin to enable this module: %s', 'sleek_admin'), '<a href="https://wordpress.org/plugins/contact-form-7/">wordpress.org/plugins/contact-form-7/</a>') ?></p>
	<?php endif ?>
<?php endif ?>

<?php if (isset($hubspot_form_id) and !empty($hubspot_form_id)) : ?>
	<?php $portal_id = Sleek\Settings\get_setting('hubspot_portal_id') ?>

	<?php if (!empty($portal_id)) : # TODO: data-hs-form='{CONFIG}'?>
		<div data-hs-form data-hs-form-portal-id="<?php echo $portal_id ?>" data-hs-form-form-id="<?php echo $hubspot_form_id ?>" data-hs-form-redirect-url="<?php echo $redirect_url ?>"></div>
	<?php elseif (current_user_can('edit_posts')) : ?>
		<p class="error"><?php _e('Please make sure to enter a valid Hubspot Portal ID inside Settings -> Sleek', 'sleek_admin') ?></p>
	<?php endif ?>
<?php endif ?>
