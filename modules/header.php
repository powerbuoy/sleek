<header id="header">

	<a href="<?php echo home_url('/') ?>">
		<?php echo sleek_get_site_logo() ?>
	</a>

	<?php if (get_bloginfo('description')) : ?>
		<p><?php echo get_bloginfo('description') ?></p>
	<?php endif ?>

	<?php dynamic_sidebar('header') ?>

</header>
