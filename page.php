<?php get_header() ?>

<main>

	<?php get_template_part('modules/page') ?>
	<?php comments_template('/modules/comments.php') ?>
	<?php get_template_part('modules/post-comment') ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
