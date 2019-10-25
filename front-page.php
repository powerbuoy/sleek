<?php get_header() ?>

<main>

	<?php get_template_part('modules/single-page') ?>

	<div data-vue>
		<h2>Vue Test</h2>
		<test-component></test-component>
		<another-component></another-component>
	</div>

	<?php Sleek\Modules\render('share-page', get_the_ID()) ?>
	<?php (new Sleek\Modules\SharePage(['title' => 'Share!!', 'services' => ['Facebook', 'Twitter']]))->render() ?>
	<?php Sleek\Modules\render('social-links', ['title' => 'Socialize!']) ?>
	<?php (new Sleek\Modules\SocialLinks(['title' => 'Socialize!!']))->render() ?>
	<?php Sleek\Modules\render('text-block') ?>
	<?php Sleek\Modules\render_flexible('modules_below_content', get_the_ID()) ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
