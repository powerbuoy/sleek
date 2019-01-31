<?php get_header() ?>

<main>

	<?php get_template_part('modules/archive-header', get_post_type()) ?>
	<?php get_template_part('modules/archive-taxonomies', get_post_type()) ?>
	<?php get_template_part('modules/archive-posts', get_post_type()) ?>
	<?php get_template_part('modules/pagination', get_post_type()) ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
