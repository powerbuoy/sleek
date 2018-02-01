<section id="text-block">

	<?php if ($data['text-block-title'] or $data['text-block-image']) : ?>
		<header>

			<?php if ($data['text-block-image']) : ?>
				<figure>
					<?php echo wp_get_attachment_image($data['text-block-image'], 'large') ?>
				</figure>
			<?php endif ?>

			<?php if ($data['text-block-title']) : ?>
				<h2><?php echo $data['text-block-title'] ?></h2>
			<?php endif ?>

		</header>
	<?php endif ?>

	<?php echo $data['text-block-description'] ?>

</section>
