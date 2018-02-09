<section id="text-block">

	<?php if ($text_block_title or $text_block_image) : ?>
		<header>

			<?php if ($text_block_image) : ?>
				<figure>
					<?php echo wp_get_attachment_image($text_block_image, 'large') ?>
				</figure>
			<?php endif ?>

			<?php if ($text_block_title) : ?>
				<h2><?php echo $text_block_title ?></h2>
			<?php endif ?>

		</header>
	<?php endif ?>

	<?php echo $text_block_description ?>

</section>
