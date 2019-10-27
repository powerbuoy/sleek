<footer id="site-footer">

	<?php dynamic_sidebar('footer') ?>

	<?php if (has_nav_menu('footer_menu')) : ?>
		<?php wp_nav_menu(['theme_location' => 'footer_menu']) ?>
	<?php endif ?>

</footer>
