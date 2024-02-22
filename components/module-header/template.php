<?php
	$args = array_merge([
		'module_header' => null,
		'styles' => []
	], $args);
?>

<?php if (!empty($args['module_header']['kicker']) or !empty($args['module_header']['title']) or !empty($args['module_header']['description'])) : ?>
	<header class="module-header">

		<?php if (!empty($args['module_header']['kicker']) and !empty($args['module_header']['title'])) : ?>
			<p class="text--kicker"><?php echo $args['module_header']['kicker'] ?></p>
		<?php endif ?>

		<?php if (!empty($args['module_header']['title'])) : ?>
			<h2><?php echo $args['module_header']['title'] ?></h2>
		<?php endif ?>

		<?php if (!empty($args['module_header']['description'])) : ?>
			<div class="wysiwyg"><?php echo $args['module_header']['description'] ?></div>
		<?php endif ?>

	</header>
<?php endif ?>