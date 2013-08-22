<?php get_header() ?>

<div id="primary-content">

	<?php include TEMPLATEPATH . '/modules/post.php' ?>
	<?php comments_template('/modules/comments.php') ?>

</div>

<div id="secondary-content">

	<?php dynamic_sidebar('aside') ?>

</div>

<?php get_footer() ?>
