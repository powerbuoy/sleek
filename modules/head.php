<!DOCTYPE html>

<html id="<?php echo sleek_get_page_type() ?>-page" <?php language_attributes() ?> <?php body_class('no-js') ?>>

	<head>

		<meta charset="<?php bloginfo('charset') ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<script>
			document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
		</script>

		<?php wp_head() ?>

	</head>

	<body>

		<?php do_action('sleek_after_body_tag_open') ?>
