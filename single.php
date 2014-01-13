<?php get_header() ?>

<div class="section"><div>

	<?php include TEMPLATEPATH . '/modules/post.php' ?>

</div></div>

<div class="section dark-blue"><div>

	<?php comments_template('/modules/comments.php') ?>

</div></div>

<aside id="aside" class="section light-blue"><div>

	<?php dynamic_sidebar('aside') ?>

</div></aside>

<?php get_footer() ?>
