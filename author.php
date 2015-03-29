<?php get_header() ?>

<main>

	<?php sleek_get_module('posts-intro') ?>
	<?php sleek_get_module('posts') ?>

</main>

<?php if (is_active_sidebar('aside')) : ?>
	<aside id="aside">

		<?php dynamic_sidebar('aside') ?>

	</aside>
<?php endif ?>

<?php get_footer() ?>
