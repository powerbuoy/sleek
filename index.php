<?php get_header() ?>

<main>

	<?php get_template_part('modules/archive') ?>
	<?php # Sleek\Modules\render_flexible('archive_modules', (Sleek\Utils\get_current_post_type() ?? 'post') . '_settings') ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
