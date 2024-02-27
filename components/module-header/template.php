<?php
	$args = array_merge([
		'module_header' => null,
		'styles' => []
	], $args);

	$classes = [
		'module-header'
	];

	if (!empty($args['styles']['text_align']) and $args['styles']['text_align'] !== 'inherit') {
		$classes[] = 'text--' . $args['styles']['text_align'];
	}
?>

<?php if (!empty($args['module_header']['kicker']) or !empty($args['module_header']['title']) or !empty($args['module_header']['description'])) : ?>
	<header class="<?php echo implode(' ', $classes) ?>">

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