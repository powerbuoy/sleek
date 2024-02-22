<?php get_header() ?>

<main>

	<?php if (post_password_required()) : ?>
		<div class="container">
			<h1><?php the_title() ?></h1>
			<?php echo get_the_password_form() ?>
		</div>
	<?php else : ?>
		<?php get_template_part('modules/single', get_post_type()) ?>
		<?php comments_template('/modules/comments.php') ?>
		<?php comment_form() ?>
		<?php # Sleek\Modules\render_flexible('flexible_modules') ?>
		<?php # Sleek\Modules\render_flexible('below_single', get_post_type() . '_settings') ?>
	<?php endif ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
