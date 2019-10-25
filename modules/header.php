<header id="header">

	<?php the_custom_logo() ?>

	<?php if (get_bloginfo('description')) : ?>
		<p><?php echo get_bloginfo('description') ?></p>
	<?php endif ?>

	<?php if (has_nav_menu('main_menu')) : ?>
		<?php wp_nav_menu(['theme_location' => 'main_menu']) ?>
	<?php endif ?>

	<?php dynamic_sidebar('header') ?>

</header>
