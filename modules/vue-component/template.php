<section id="vue-component" data-vue>

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<<?php echo $component ?>></<?php echo $component ?>>

</section>
