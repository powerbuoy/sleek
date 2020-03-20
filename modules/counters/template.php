<section id="counters">

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<?php foreach ($counters as $block) : ?>
		<article>

			<figure data-radial-progress data-value="<?php echo $block['from'] ?>" data-suffix="<?php echo $block['unit'] ?>">
				<?php echo $block['to'] ?><?php echo $block['unit'] ?>
			</figure>

			<?php if ($block['title']) : ?>
				<h3><?php echo $block['title'] ?></h3>
			<?php endif ?>

			<?php echo $block['description'] ?>

		</article>
	<?php endforeach ?>

</section>
