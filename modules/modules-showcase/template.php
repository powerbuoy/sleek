<section id="modules-showcase">

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<?php foreach ($modules as $module) : ?>
		<article>

			<h3><?php echo $module->title ?></h3>

			<?php echo Michelf\Markdown::defaultTransform($module->readme) ?>

		</article>
	<?php endforeach ?>

</section>
