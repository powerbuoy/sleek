<?php get_header() ?>

<main>

	<?php $options = get_option(SLEEK_SETTINGS_NAME) ?>
	<?php if (
		isset($options['google_search_api_key']) and
		!empty($options['google_search_api_key']) and
		isset($options['google_search_engine_id']) and
		!empty($options['google_search_engine_id'])
	) : ?>
		<?php get_template_part('modules/google-search-results') ?>
	<?php else : ?>
		<?php get_template_part('modules/archive-header') ?>
		<?php get_template_part('modules/search-results') ?>
		<?php get_template_part('modules/posts-pagination') ?>
	<?php endif ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
