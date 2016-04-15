<?php get_header() ?>

<main>

	<?php get_template_part('modules/post') ?>
	<?php comments_template('/modules/comments.php') ?>
	<?php get_template_part('modules/post-comment') ?>

</main>

<?php if (is_active_sidebar('aside')) : ?>
	<aside id="aside">

		<?php dynamic_sidebar('aside') ?>

	</aside>
<?php endif ?>

<?php get_footer() ?>
