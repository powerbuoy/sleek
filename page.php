<?php get_header() ?>

<main>

	<?php include TEMPLATEPATH . '/modules/post-content.php' ?>
	<?php include TEMPLATEPATH . '/modules/sub-nav.php' ?>
	<?php comments_template('/modules/comments.php') ?>

</main>

<aside id="aside">

	<?php dynamic_sidebar('aside') ?>

</aside>

<?php get_footer() ?>
