<?php get_header() ?>

<main>

	<?php get_template_part('modules/single-page') ?>

	<?php if (!post_password_required()) : ?>
		<?php comments_template('/modules/comments.php') ?>
		<?php get_template_part('modules/comment-form') ?>
	<?php endif ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
