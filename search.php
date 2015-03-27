<?php if (XHR) : ?>
	<?php sleek_get_module('ajax-posts'); die ?>
<?php else : ?>
	<?php get_header() ?>

	<main>

		<?php sleek_get_module('posts-intro') ?>
		<?php sleek_get_module('posts') ?>

	</main>

	<aside id="aside">

		<?php sleek_get_module('contact') ?>

	</aside>

	<?php get_footer() ?>
<?php endif ?>
