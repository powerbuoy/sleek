<?php get_header() ?>

<main>

	<?php get_template_part('modules/single-page') ?>

	<?php Sleek\Modules\render('share-page', get_the_ID()) ?>
	<?php $module = new Sleek\Modules\SharePage(['title' => 'Share!!', 'services' => ['Facebook', 'Twitter']]); $module->render() ?>

	<?php Sleek\Modules\render('social-links', ['title' => 'Socialize!!']) ?>
	<?php $module = new Sleek\Modules\SocialLinks(['title' => 'Socialize!!']); $module->render() ?>

	<?php Sleek\Modules\render('text-block') ?>
	<?php Sleek\Modules\render_flexible('modules_below_content', get_the_ID()) ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
