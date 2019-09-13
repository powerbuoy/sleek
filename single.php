<?php get_header() ?>

<main>

	<?php get_template_part('modules/single', get_post_type()) ?>

	<?php if (!post_password_required()) : ?>
		<?php comments_template('/modules/comments.php') ?>
		<?php comment_form() ?>
	<?php endif ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
