<header id="archive-header">

	<?php if ($image = sleek_get_the_archive_image('large')) : ?>
		<figure>
			<img src="<?php echo $image ?>">
		</figure>
	<?php endif ?>

	<h1><?php the_archive_title() ?></h1>

	<?php the_archive_description() ?>

</header>
