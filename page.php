<?php get_header() ?>

<main>

	<?php get_template_part('modules/page') ?>
	<?php get_template_part('modules/sub-nav') ?>
	<?php comments_template('/modules/comments.php') ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
