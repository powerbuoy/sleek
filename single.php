<?php get_header() ?>

<main>

	<?php sleek_get_module('post') ?>
	<?php comments_template('/modules/comments.php') ?>

</main>

<?php if (is_active_sidebar('aside')) : ?>
	<aside id="aside">

		<?php dynamic_sidebar('aside') ?>

	</aside>
<?php endif ?>

<?php get_footer() ?>
