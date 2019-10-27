<section id="text-block">

	<?php if ($image) : ?>
		<figure>
			<?php echo wp_get_attachment_image($image, 'large') ?>
		</figure>
	<?php endif ?>

	<?php if ($title) : ?>
		<h2><?php echo $title ?></h2>
	<?php endif ?>

	<?php echo $description ?>

</section>
