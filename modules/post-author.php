<?php
	if (get_query_var('author_name')) {
		$usr = get_user_by('slug', get_query_var('author_name'));
	}
	else {
		$usr = get_user_by('id', get_query_var('author'));
	}

	if (!$usr) {
		$usr = get_user_by('id', get_the_author_meta('ID'));
	}
?>

<?php if ($usr) : ?>
	<section id="post-author">

		<?php sleek_get_module('partials/single-user') ?>

	</section>
<?php endif ?>
