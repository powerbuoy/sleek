<?php get_header() ?>

<main>

	<?php get_template_part('modules/single-page') ?>
	<?php Sleek\Modules\render_flexible('modules_below_content', get_the_ID()) ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
