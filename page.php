<?php get_header() ?>

<main>

	<?php get_template_part('modules/post-content') ?>
	<?php get_template_part('modules/sub-nav') ?>
	<?php comments_template('/modules/comments.php') ?>

</main>

<?php if (is_active_sidebar('aside')) : ?>
	<aside id="aside">

		<?php dynamic_sidebar('aside') ?>

	</aside>
<?php endif ?>

<?php get_footer() ?>
