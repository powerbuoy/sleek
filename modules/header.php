<header id="header">

	<?php # if (get_theme_mod('header_text')) : # This is a built in WP option but doesn't seem to be true unless it's changed inside the admin... :/ ?>
		<?php if (is_front_page()) : ?>
			<h1 class="site-logo">
				<a href="<?php echo home_url('/') ?>">
					<?php echo sleek_get_site_logo() ?>
				</a>
			</h1>
		<?php else : ?>
			<p class="site-logo">
				<a href="<?php echo home_url('/') ?>">
					<?php echo sleek_get_site_logo() ?>
				</a>
			</p>
		<?php endif ?>

		<?php if (get_bloginfo('description')) : ?>
			<p class="tagline">
				<?php echo str_replace(['&lt;', '&gt;'], ['<', '>'], get_bloginfo('description')) ?>
			</p>
		<?php endif ?>
	<?php # endif ?>

	<?php dynamic_sidebar('header') ?>

</header>
