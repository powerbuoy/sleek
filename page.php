<?php get_header() ?>

<main>

	<?php get_template_part('modules/single-page') ?>

	<?php if (!post_password_required()) : ?>
		<?php comments_template('/modules/comments.php') ?>
		<?php comment_form() ?>
		<?php Sleek\Modules\render_flexible('flexible_modules') ?>
	<?php endif ?>

</main>

<script>console.log('It dont work :/')</script>

<?php get_sidebar() ?>
<?php get_footer() ?>
