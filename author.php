<?php get_header() ?>

<main>

	<?php include TEMPLATEPATH . '/modules/post-author.php' ?>
	<?php include TEMPLATEPATH . '/modules/posts-intro.php' ?>
	<?php include TEMPLATEPATH . '/modules/posts.php' ?>

</main>

<aside id="aside">

	<?php dynamic_sidebar('aside') ?>

</aside>

<?php get_footer() ?>
