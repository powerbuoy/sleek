<?php get_header() ?>

<div id="primary-content">

	<?php include TEMPLATEPATH . '/modules/post-content.php' ?>
	<?php comments_template('/modules/comments.php') ?>

</div>

<div id="secondary-content">

	<?php include TEMPLATEPATH . '/modules/secondary-nav.php' ?>

	<?php dynamic_sidebar('aside') ?>

</div>

<?php get_footer() ?>
