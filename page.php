<?php get_header() ?>

<div class="section gray"><div>

	<h1><?php the_title() ?></h1>

</div></div>

<div class="section"><div>

	<?php include TEMPLATEPATH . '/modules/post-content.php' ?>
	<?php include TEMPLATEPATH . '/modules/sub-nav.php' ?>

</div></div>

<div class="section dark-blue"><div>

	<?php comments_template('/modules/comments.php') ?>

</div></div>

<aside id="aside" class="section light-blue"><div>

	<?php dynamic_sidebar('aside') ?>

</div></aside>

<?php get_footer() ?>
