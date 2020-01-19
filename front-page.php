<?php get_header() ?>

<main>

	<?php get_template_part('modules/single-page') ?>
	<?php Sleek\Modules\render_flexible('modules_below_content', get_the_ID()) ?>
	<?php # Sleek\Modules\render_dummies(['attachments', 'contact-form', 'featured-posts', 'gallery', 'google-map', 'hubspot-form', 'instagram', 'latest-posts', 'next-post', 'page-menu', 'related-pages', 'related-posts', 'share-page', 'social-links', 'text-block', 'text-blocks', 'users', 'video']) ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
