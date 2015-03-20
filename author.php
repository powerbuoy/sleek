<?php get_header() ?>

<main>

	<?php sleek_include_module('posts-intro') ?>
	<?php sleek_include_module('post-author') ?>
	<?php sleek_include_module('posts') ?>

</main>

<aside id="aside">

	<?php dynamic_sidebar('aside') ?>

</aside>

<?php get_footer() ?>
