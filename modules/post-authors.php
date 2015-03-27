<?php global $post ?>

<?php $users = get_users(array(
	'exclude' => array(1) # Ignore admin (ID: 1)
)) ?>

<section id="post-authors">

	<?php foreach ($users as $usr) : ?>
		<article>

			<?php sleek_get_module('partials/single-user') ?>

		</article>
	<?php endforeach ?>

</section>
