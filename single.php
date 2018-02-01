<?php get_header() ?>

<main>

	<?php get_template_part('modules/post') ?>

	<?php if (!post_password_required()) : ?>
		<?php comments_template('/modules/comments.php') ?>
		<?php get_template_part('modules/post-comment') ?>
	<?php endif ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
