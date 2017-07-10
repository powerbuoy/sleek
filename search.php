<?php get_header() ?>

<main>

	<?php if (get_theme_mod('google_search_api_key') and get_theme_mod('google_search_engine_id')) : ?>
		<?php get_template_part('modules/google-search-results') ?>
	<?php else : ?>
		<?php get_template_part('modules/archive-header') ?>
		<?php get_template_part('modules/breadcrumbs') ?>
		<?php get_template_part('modules/archive-taxonomies') ?>
		<?php get_template_part('modules/posts') ?>
	<?php endif ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
