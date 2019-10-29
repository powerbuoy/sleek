<section id="vue-component">

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<div data-vue>
		<<?php echo $component ?>></<?php echo $component ?>>
	</div>

</section>
