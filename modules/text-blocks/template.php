<section id="text-blocks">

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<?php foreach ($text_blocks as $block) : ?>
		<article>

			<?php if ($block['image']) : ?>
				<figure>
					<?php echo wp_get_attachment_image($block['image'], 'medium') ?>
				</figure>
			<?php endif ?>

			<?php if ($block['title']) : ?>
				<h3><?php echo $block['title'] ?></h3>
			<?php endif ?>

			<?php echo $block['description'] ?>

		</article>
	<?php endforeach ?>

</section>
