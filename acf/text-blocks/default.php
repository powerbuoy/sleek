<section id="text-blocks">

	<?php if ($text_blocks_title or $text_blocks_description) : ?>
		<header>

			<?php if ($text_blocks_title) : ?>
				<h2><?php echo $text_blocks_title ?></h2>
			<?php endif ?>

			<?php echo $text_blocks_description ?>

		</header>
	<?php endif ?>

	<?php foreach ($text_blocks as $block) : ?>
		<article>

			<?php if ($block['text_block_image']) : ?>
				<figure>
					<?php echo wp_get_attachment_image($block['text_block_image'], 'medium') ?>
				</figure>
			<?php endif ?>

			<?php if ($block['text_block_title']) : ?>
				<h3><?php echo $block['text_block_title'] ?></h3>
			<?php endif ?>

			<?php echo $block['text_block_description'] ?>

		</article>
	<?php endforeach ?>

</section>
