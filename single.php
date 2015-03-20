<?php get_header() ?>

<main>

	<?php sleek_include_module('post') ?>
	<?php comments_template('/modules/comments.php') ?>

</main>

<aside id="aside">

	<?php dynamic_sidebar('aside') ?>

</aside>

<?php get_footer() ?>
