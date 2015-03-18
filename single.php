<?php get_header() ?>

<main>

	<?php include TEMPLATEPATH . '/modules/post.php' ?>
	<?php comments_template('/modules/comments.php') ?>

</main>

<aside id="aside">

	<?php dynamic_sidebar('aside') ?>

</aside>

<?php get_footer() ?>
