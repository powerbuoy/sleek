<?php get_header() ?>

<main>

	<?php get_template_part('modules/archive-header', sleek_get_current_post_type()) ?>
	<?php get_template_part('modules/archive-taxonomies', sleek_get_current_post_type()) ?>
	<?php get_template_part('modules/archive-posts', sleek_get_current_post_type()) ?>
	<?php the_posts_pagination() ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
