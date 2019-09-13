<!DOCTYPE html>

<html <?php language_attributes() ?> <?php body_class() ?>>

	<head>

		<?php wp_head() ?>

	</head>

	<body>

		<?php do_action('sleek_after_body_tag_open') ?>

		<header id="header">

			<?php the_custom_logo() ?>

			<?php if (get_bloginfo('description')) : ?>
				<p><?php echo get_bloginfo('description') ?></p>
			<?php endif ?>

			<?php dynamic_sidebar('header') ?>

		</header>
