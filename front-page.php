<?php get_header() ?>

<main>

	<?php get_template_part('modules/single-page') ?>

	<h2>Sticky sharepage</h2>
	<?php Sleek\Modules\render('share-page', get_the_ID()) ?>

	<h2>Static sharepage</h2>
	<?php (new Sleek\Modules\SharePage(['title' => 'Share!!', 'services' => ['Facebook', 'Twitter']]))->render() ?>

	<h2>Static sociallinks</h2>
	<?php Sleek\Modules\render('social-links', ['title' => 'Socialize!!']) ?>

	<h2>Static sociallinks</h2>
	<?php (new Sleek\Modules\SocialLinks(['title' => 'Socialize!!']))->render() ?>

	<h2>Static text-block</h2>
	<?php Sleek\Modules\render('text-block') ?>

	<h2>Flexible content</h2>
	<?php Sleek\Modules\render_flexible('modules_below_content', get_the_ID()) ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
