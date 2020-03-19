<?php get_header() ?>

<main>

	<?php get_template_part('modules/single-page') ?>
	<?php # Sleek\Modules\render_dummies(array_map('basename', array_filter(glob(get_stylesheet_directory() . '/modules/*'), 'is_dir'))) ?>
	<?php Sleek\Modules\render_flexible('flexible_modules') ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
