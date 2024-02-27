<?php
	$args = array_merge([
		'links' => null,
		'styles' => []
	], $args);

	$classes = [
		'links'
	];

	if (!empty($args['styles']['text_align']) and $args['styles']['text_align'] !== 'inherit') {
		$classes[] = 'text--' . $args['styles']['text_align'];
	}
?>

<?php if ($args['links']) : ?>
	<nav class="<?php echo implode(' ', $classes) ?>">

		<?php $i = 0; foreach ($args['links'] as $link) : ?>
			<a href="<?php echo $link['link']['url'] ?>"
				class="<?php echo $link['link_style'] ?>"
				<?php if (!empty($link['link']['target'])) : ?>
					target="<?php echo $link['link']['target'] ?>"
				<?php endif ?>
			>
				<?php echo $link['link']['title'] ?>
			</a>
		<?php endforeach ?>

	</nav>
<?php endif ?>
