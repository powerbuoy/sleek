<?php if (!empty($args['kicker']) or !empty($args['title']) or !empty($args['description'])) : ?>
	<header class="module-header">

		<?php if (!empty($args['kicker'])) : ?>
			<p class="text--kicker"><?php echo $args['kicker'] ?></p>
		<?php endif ?>

		<?php if (!empty($args['title'])) : ?>
			<h2><?php echo $args['title'] ?></h2>
		<?php endif ?>

		<?php if (!empty($args['description'])) : ?>
			<div class="wysiwyg"><?php echo $args['description'] ?></div>
		<?php endif ?>

	</header>
<?php endif ?>