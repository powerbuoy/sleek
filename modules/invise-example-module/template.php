<section id="invise-example-module" class="<?php echo sleek_module_class($styles) ?>">

	<?php get_template_part('components/color-scheme/template', null, ['styles' => $styles['color_scheme']]) ?>
	<?php get_template_part('components/module-header/template', null, [
		'module_header' => $module_header,
		'styles' => $styles['module_header']
	]) ?>

	<div>

		<?php foreach ($new_rows as $row) : ?>
			<article>

				<?php get_template_part('components/media/template', null, ['media' => $row['media']]) ?>

				<h3><?php echo $row['title'] ?></h3>

				<?php if ($row['description']) : ?>
					<div class="wysiwyg"><?php echo $row['description'] ?></div>
				<?php endif ?>

				<?php get_template_part('components/links/template', null, [
					'links' => $row['links'],
					'button_classes' => ['button--small']
				]) ?>

			</article>
		<?php endforeach ?>

	</div>

	<?php get_template_part('components/links/template', null, [
		'links' => $links,
		'styles' => $styles['links']
	]) ?>

</section>
